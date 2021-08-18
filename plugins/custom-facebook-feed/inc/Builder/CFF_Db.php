<?php
/**
 * Custom Facebook Feed Database
 *
 * @since 4.0
 */

namespace CustomFacebookFeed\Builder;

class CFF_Db {

	const RESULTS_PER_PAGE = 20;

	const RESULTS_PER_CRON_UPDATE = 6;

	/**
	 * Query the cff_sources table
	 *
	 * @param array $args
	 *
	 * @return array|bool
	 *
	 * @since 4.0
	 */
	public static function source_query( $args = array() ) {
		global $wpdb;
		$sources_table_name = $wpdb->prefix . 'cff_sources';
		$feeds_table_name = $wpdb->prefix . 'cff_feeds';

		$page = 0;
		if ( isset( $args['page'] ) ) {
			$page = (int)$args['page'] - 1;
			unset( $args['page'] );
		}

		$offset = max( 0, $page * self::RESULTS_PER_PAGE );

		if ( empty( $args ) ) {

			$limit = (int)self::RESULTS_PER_PAGE;
			$sql = "SELECT s.id, s.account_id, s.account_type, s.privilege, s.access_token, s.username, s.info, s.error, s.expires, count(f.id) as used_in
				FROM $sources_table_name s
				LEFT JOIN $feeds_table_name f ON f.settings LIKE CONCAT('%', s.account_id, '%')
				GROUP BY s.id, s.account_id
				LIMIT $limit
				OFFSET $offset;
				";

			$results = $wpdb->get_results( $sql, ARRAY_A );

			if ( empty( $results ) ) {
				return array();
			}

			$i = 0;
			foreach ( $results as $result ) {
				if ( (int)$result['used_in'] > 0 ) {
					$account_id = esc_sql( $result['account_id'] );
					$sql = "SELECT *
						FROM $feeds_table_name
						WHERE settings LIKE CONCAT('%', $account_id, '%')
						GROUP BY id
						LIMIT 100;
						";

					$results[ $i ]['instances'] = $wpdb->get_results( $sql, ARRAY_A );
				}
				$i++;
			}


			return $results;
		}
		if ( isset( $args['access_token'] ) && ! isset( $args['id'] ) ) {
			$sql = $wpdb->prepare( "
			SELECT * FROM $sources_table_name
			WHERE access_token = %s;
		 ", $args['access_token'] );

			return $wpdb->get_results( $sql, ARRAY_A );
		}

		if ( ! isset( $args['id'] ) ) {
			return false;
		}

		if ( is_array( $args['id'] ) ) {
			$id_array = array();
			foreach ( $args['id'] as $id ) {
				$id_array[] = esc_sql( $id );
			}
		} elseif( strpos( $args['id'], ',' ) !== false ) {
			$id_array = explode( ',', str_replace( ' ' , '', esc_sql( $args['id'] ) ) );
		}
		if ( isset( $id_array ) ) {
			$id_string = "'" . implode( "' , '", $id_array ) . "'";
		}

		$privilege = isset( $args['privilege'] ) ? $args['privilege'] : '';

		if ( isset( $id_string ) ) {
			$sql = $wpdb->prepare( "
			SELECT * FROM $sources_table_name
			WHERE account_id IN ($id_string)
			AND privilege = %s;
		 ", $privilege );

		} else {
			$sql = $wpdb->prepare( "
			SELECT * FROM $sources_table_name
			WHERE account_id = %s
			AND privilege = %s;
		 ", $args['id'], $privilege );
		}

		return $wpdb->get_results( $sql, ARRAY_A );
	}

	/**
	 * Update a source (connected account)
	 *
	 * @param array $to_update
	 * @param array $where_data
	 *
	 * @return false|int
	 *
	 * @since 4.0
	 */
	public static function source_update( $to_update, $where_data ) {
		global $wpdb;
		$sources_table_name = $wpdb->prefix . 'cff_sources';

		$data = array();
		$where = array();
		$format = array();
		$where_format = array();
		if ( isset( $to_update['type'] ) ) {
			$data['account_type'] = $to_update['type'];
			$format[] = '%s';
		}
		if ( isset( $to_update['privilege'] ) ) {
			$data['privilege'] = $to_update['privilege'];
			$format[] = '%s';
		}
		if ( isset( $to_update['id'] ) ) {
			$where['account_id'] = $to_update['id'];
			$where_format[] = '%s';
		}
		if ( isset( $to_update['access_token'] ) ) {
			$data['access_token'] = $to_update['access_token'];
			$format[] = '%s';
		}
		if ( isset( $to_update['username'] ) ) {
			$data['username'] = $to_update['username'];
			$format[] = '%s';
		}
		if ( isset( $to_update['info'] ) ) {
			$data['info'] = $to_update['info'];
			$format[] = '%s';
		}
		if ( isset( $to_update['error'] ) ) {
			$data['error'] = $to_update['error'];
			$format[] = '%s';
		}
		if ( isset( $to_update['expires'] ) ) {
			$data['expires'] = $to_update['expires'];
			$format[] = '%s';
		}
		if ( isset( $to_update['last_updated'] ) ) {
			$data['last_updated'] = $to_update['last_updated'];
			$format[] = '%s';
		}
		if ( isset( $to_update['author'] ) ) {
			$data['author'] = $to_update['author'];
			$format[] = '%d';
		}

		if ( isset( $where_data['type'] ) ) {
			$where['account_type'] = $where_data['type'];
			$where_format[] = '%s';
		}
		if ( isset( $where_data['privilege'] ) ) {
			$where['privilege'] = $where_data['privilege'];
			$where_format[] = '%s';
		}
		if ( isset( $where_data['author'] ) ) {
			$where['author'] = $where_data['author'];
			$where_format[] = '%d';
		}
		if ( isset( $where_data['id'] ) ) {
			$where['account_id'] = $where_data['id'];
			$where_format[] = '%s';
		}
		if ( isset( $where_data['record_id'] ) ) {
			$where['id'] = $where_data['record_id'];
			$where_format[] = '%d';
		}

		$affected = $wpdb->update( $sources_table_name, $data, $where, $format, $where_format );

		return $affected;
	}

	/**
	 * New source (connected account) data is added to the
	 * cff_sources table and the new insert ID is returned
	 *
	 * @param array $to_insert
	 *
	 * @return false|int
	 *
	 * @since 4.0
	 */
	public static function source_insert( $to_insert ) {
		global $wpdb;
		$sources_table_name = $wpdb->prefix . 'cff_sources';

		$data = array();
		$format = array();
		if ( isset( $to_insert['id'] ) ) {
			$data['account_id'] = $to_insert['id'];
			$format[] = '%s';
		}
		if ( isset( $to_insert['type'] ) ) {
			$data['account_type'] = $to_insert['type'];
			$format[] = '%s';
		} else {
			$data['account_type'] = 'page';
			$format[] = '%s';
		}
		if ( isset( $to_insert['privilege'] ) ) {
			$data['privilege'] = $to_insert['privilege'];
			$format[] = '%s';
		}
		if ( isset( $to_insert['access_token'] ) ) {
			$data['access_token'] = $to_insert['access_token'];
			$format[] = '%s';
		}
		if ( isset( $to_insert['username'] ) ) {
			$data['username'] = $to_insert['username'];
			$format[] = '%s';
		}
		if ( isset( $to_insert['info'] ) ) {
			$data['info'] = $to_insert['info'];
			$format[] = '%s';
		}
		if ( isset( $to_insert['error'] ) ) {
			$data['error'] = $to_insert['error'];
			$format[] = '%s';
		}
		if ( isset( $to_insert['expires'] ) ) {
			$data['expires'] = $to_insert['expires'];
			$format[] = '%s';
		} else {
			$data['expires'] = '2100-12-30 00:00:00';
			$format[] = '%s';
		}
		$data['last_updated'] = date( 'Y-m-d H:i:s' );
		$format[] = '%s';
		if ( isset( $to_insert['author'] ) ) {
			$data['author'] = $to_insert['author'];
			$format[] = '%d';
		} else {
			$data['author'] = get_current_user_id();
			$format[] = '%d';
		}

		$affected = $wpdb->insert( $sources_table_name, $data, $format );

		return $affected;
	}

	/**
	 * Query the to get feeds list for Elementor
	 *
	 * @return array|bool
	 *
	 * @since 4.0
	 */
	public static function elementor_feeds_query() {
		global $wpdb;
		$feeds_elementor = [];
		$feeds_table_name = $wpdb->prefix . 'cff_feeds';
		$feeds_list = $wpdb->get_results( "
			SELECT id, feed_name FROM $feeds_table_name;
			"
		);
		if ( ! empty( $feeds_list ) ) {
			foreach($feeds_list as $feed) {
				$feeds_elementor[$feed->id] =  $feed->feed_name;
			}
		}
		return $feeds_elementor;
	}


	/**
	 * Count the cff_feeds table
	 *
	 * @param array $args
	 *
	 * @return array|bool
	 *
	 * @since 4.0
	 */
	public static function feeds_count() {
		global $wpdb;
		$feeds_table_name = $wpdb->prefix . 'cff_feeds';
		$results = $wpdb->get_results(
			"SELECT COUNT(*) AS num_entries FROM $feeds_table_name", ARRAY_A
		);
		return isset($results[0]['num_entries']) ? (int)$results[0]['num_entries'] : 0;
	}


	/**
	 * Query the cff_feeds table
	 *
	 * @param array $args
	 *
	 * @return array|bool
	 *
	 * @since 4.0
	 */
	public static function feeds_query( $args = array() ) {
		global $wpdb;
		$feeds_table_name = $wpdb->prefix . 'cff_feeds';
		$page = 0;
		if ( isset( $args['page'] ) ) {
			$page = (int)$args['page'] - 1;
			unset( $args['page'] );
		}

		$offset = max( 0, $page * self::RESULTS_PER_PAGE );

		if ( isset( $args['id'] ) ) {
			$sql = $wpdb->prepare( "
			SELECT * FROM $feeds_table_name
			WHERE id = %d;
		 ", $args['id'] );
		} else {
			$sql = $wpdb->prepare( "
			SELECT * FROM $feeds_table_name
			LIMIT %d
			OFFSET %d;", self::RESULTS_PER_PAGE, $offset );
		}

		return $wpdb->get_results( $sql, ARRAY_A );
	}

	/**
	 * Update feed data in the cff_feed table
	 *
	 * @param array $to_update
	 * @param array $where_data
	 *
	 * @return false|int
	 *
	 * @since 4.0
	 */
	public static function feeds_update( $to_update, $where_data ) {
		global $wpdb;
		$feeds_table_name = $wpdb->prefix . 'cff_feeds';

		$data = array();
		$where = array();
		$format = array();
		foreach ( $to_update as $single_insert ) {
			if ( $single_insert['key'] ) {
				$data[ $single_insert['key'] ] = $single_insert['values'][0];
				$format[] = '%s';
			}
		}

		if ( isset( $where_data['id'] ) ) {
			$where['id'] = $where_data['id'];
			$where_format = array( '%d' );
		} elseif ( isset( $where_data['feed_name'] ) ) {
			$where['feed_name'] = $where_data['feed_name'];
			$where_format = array( '%s' );
		} else {
			return false;
		}

		$data['last_modified'] = date( 'Y-m-d H:i:s' );
		$format[] = '%s';

		$affected = $wpdb->update( $feeds_table_name, $data, $where, $format, $where_format );

		return $affected;
	}

	/**
	 * New feed data is added to the cff_feeds table and
	 * the new insert ID is returned
	 *
	 * @param array $to_insert
	 *
	 * @return false|int
	 *
	 * @since 4.0
	 */
	public static function feeds_insert( $to_insert ) {
		global $wpdb;
		$feeds_table_name = $wpdb->prefix . 'cff_feeds';

		$data = array();
		$format = array();
		foreach ( $to_insert as $single_insert ) {
			if ( $single_insert['key'] ) {
				$data[ $single_insert['key'] ] = $single_insert['values'][0];
				$format[] = '%s';
			}
		}

		$data['last_modified'] = date( 'Y-m-d H:i:s' );
		$format[] = '%s';

		$data['author'] = get_current_user_id();
		$format[] = '%d';

		$wpdb->insert( $feeds_table_name, $data, $format );
		return $wpdb->insert_id;
	}

	/**
	 * Query the cff_feeds table
	 * Porcess to define the name of the feed when adding new
	 *
	 * @param array $args
	 *
	 * @return array|bool
	 *
	 * @since 4.0
	 */
	public static function feeds_query_name( $sourcename ) {
		global $wpdb;
		$feeds_table_name = $wpdb->prefix . 'cff_feeds';
		$sql = $wpdb->prepare(
			"SELECT * FROM $feeds_table_name
			WHERE feed_name LIKE %s;",
			$wpdb->esc_like($sourcename) . '%'
		);
		$count = sizeof($wpdb->get_results( $sql, ARRAY_A ));
		return ($count == 0) ? $sourcename : $sourcename .' ('. ($count+1) .')';
	}



	/**
	 * Query to Remove Feeds from Database
	 *
	 * @param array $args
	 *
	 * @return array|bool
	 *
	 * @since 4.0
	 */
	public static function delete_feeds_query( $feed_ids_array ) {
		global $wpdb;
		$feeds_table_name = $wpdb->prefix . 'cff_feeds';
		$feed_caches_table_name = $wpdb->prefix . 'cff_feed_caches';
		$feed_ids_array = implode(',', $feed_ids_array);
		$wpdb->query(
			$wpdb->prepare(
				"DELETE FROM $feeds_table_name WHERE id IN ($feed_ids_array)"
			)
		);
		$wpdb->query(
			$wpdb->prepare(
				"DELETE FROM $feed_caches_table_name WHERE feed_id IN ($feed_ids_array)"
			)
		);

		echo \CustomFacebookFeed\CFF_Utils::cff_json_encode(CFF_Feed_Builder::get_feed_list());
		wp_die();
	}

	/**
	 * Query to Remove Source from Database
	 *
	 * @param array $args
	 *
	 * @return array|bool
	 *
	 * @since 4.0
	 */
	public static function delete_source_query( $source_id ) {
		global $wpdb;
		$sources_table_name = $wpdb->prefix . 'cff_sources';
		$wpdb->query(
			$wpdb->prepare(
				"DELETE FROM $sources_table_name WHERE id = %d; ", $source_id
			)
		);

		echo \CustomFacebookFeed\CFF_Utils::cff_json_encode(CFF_Feed_Builder::get_source_list());
		wp_die();
	}

	/**
	 * Query to Duplicate a Single Feed
	 *
	 * @param array $args
	 *
	 * @return array|bool
	 *
	 * @since 4.0
	 */
	public static function duplicate_feed_query( $feed_id ){
		global $wpdb;
		$feeds_table_name = $wpdb->prefix . 'cff_feeds';
		$wpdb->query(
			$wpdb->prepare(
				"INSERT INTO $feeds_table_name (feed_name, settings, author, status)
				SELECT CONCAT(feed_name, ' (copy)'), settings, author, status
				FROM $feeds_table_name
				WHERE id = %d; ", $feed_id
			)
		);



		echo \CustomFacebookFeed\CFF_Utils::cff_json_encode(CFF_Feed_Builder::get_feed_list());
		wp_die();
	}


	/**
	 * Get cache records in the cff_feed_caches table
	 *
	 * @param array $args
	 *
	 * @return array|object|null
	 */
	public static function feed_caches_query( $args ) {
		global $wpdb;
		$feed_cache_table_name = $wpdb->prefix . 'cff_feed_caches';

		if ( ! isset( $args['cron_update'] ) ) {
			$sql = "
			SELECT * FROM $feed_cache_table_name;";
		} else {
			if ( ! isset( $args['additional_batch'] ) ) {
				$sql = $wpdb->prepare( "
					SELECT * FROM $feed_cache_table_name
					WHERE cron_update = 'yes'
					ORDER BY last_updated ASC
					LIMIT %d;", self::RESULTS_PER_CRON_UPDATE );
			} else {
				$sql = $wpdb->prepare( "
					SELECT * FROM $feed_cache_table_name
					WHERE cron_update = 'yes'
					AND last_updated < %s
					ORDER BY last_updated ASC
					LIMIT %d;", date( 'Y-m-d H:i:s', time() - HOUR_IN_SECONDS ), self::RESULTS_PER_CRON_UPDATE );
			}

		}

		return $wpdb->get_results( $sql, ARRAY_A );
	}


	/**
	 * Creates all database tables used in the new admin area in
	 * the 4.0 update.
	 *
	 * TODO: Add error reporting
	 *
	 * @since 4.0
	 */
	public static function create_tables() {
		if ( !function_exists( 'dbDelta' ) ) {
			require_once ABSPATH . '/wp-admin/includes/upgrade.php';
		}

		global $wpdb;
		$max_index_length = 191;
		$charset_collate = '';
		if ( method_exists( $wpdb, 'get_charset_collate' ) ) { // get_charset_collate introduced in WP 3.5
			$charset_collate = $wpdb->get_charset_collate();
		}

		$feeds_table_name = $wpdb->prefix . 'cff_feeds';

		if ( $wpdb->get_var( "show tables like '$feeds_table_name'" ) != $feeds_table_name ) {
			$sql = "
			CREATE TABLE $feeds_table_name (
			 id bigint(20) unsigned NOT NULL auto_increment,
			 feed_name text NOT NULL default '',
			 feed_title text NOT NULL default '',
			 settings longtext NOT NULL default '',
			 author bigint(20) unsigned NOT NULL default '1',
			 status varchar(255) NOT NULL default '',
			 last_modified datetime NOT NULL default '0000-00-00 00:00:00',
			 PRIMARY KEY  (id),
			 KEY author (author)
			) $charset_collate;
			";
			//dbDelta( $sql );
			$wpdb->query( $sql );
		}
		$error = $wpdb->last_error;
		$query = $wpdb->last_query;
		$had_error = false;
		if ( $wpdb->get_var( "show tables like '$feeds_table_name'" ) != $feeds_table_name ) {
			$had_error = true;
			//$sb_instagram_posts_manager->add_error( 'database_create', '<strong>' . __( 'There was an error when trying to create the database tables used to locate feeds.', 'instagram-feed' ) .'</strong><br>' . $error . '<br><code>' . $query . '</code>' );
		}

		if ( ! $had_error ) {
			//$sb_instagram_posts_manager->remove_error( 'database_create' );
		}

		$feed_caches_table_name = $wpdb->prefix . 'cff_feed_caches';

		if ( $wpdb->get_var( "show tables like '$feed_caches_table_name'" ) != $feed_caches_table_name ) {
			$sql = "
				CREATE TABLE " . $feed_caches_table_name . " (
				id bigint(20) unsigned NOT NULL auto_increment,
				feed_id bigint(20) unsigned NOT NULL default '1',
                cache_key varchar(255) NOT NULL default '',
                cache_value longtext NOT NULL default '',
                cron_update varchar(20) NOT NULL default 'yes',
                last_updated datetime NOT NULL default '0000-00-00 00:00:00',
                PRIMARY KEY  (id),
                KEY feed_id (feed_id)
            ) $charset_collate;";
			//dbDelta( $sql );
			$wpdb->query( $sql );
		}
		$error = $wpdb->last_error;
		$query = $wpdb->last_query;
		$had_error = false;
		if ( $wpdb->get_var( "show tables like '$feed_caches_table_name'" ) != $feed_caches_table_name ) {
			$had_error = true;
			//$sb_instagram_posts_manager->add_error( 'database_create', '<strong>' . __( 'There was an error when trying to create the database tables used to locate feeds.', 'instagram-feed' ) .'</strong><br>' . $error . '<br><code>' . $query . '</code>' );
		}

		if ( ! $had_error ) {
			//$sb_instagram_posts_manager->remove_error( 'database_create' );
		}

		$sources_table_name = $wpdb->prefix . 'cff_sources';

		if ( $wpdb->get_var( "show tables like '$sources_table_name'" ) != $sources_table_name ) {
			$sql = "
			CREATE TABLE " . $sources_table_name . " (
				id bigint(20) unsigned NOT NULL auto_increment,
				account_id varchar(255) NOT NULL default '',
                account_type varchar(255) NOT NULL default '',
                privilege varchar(255) NOT NULL default '',
                access_token varchar(255) NOT NULL default '',
                username varchar(255) NOT NULL default '',
                info text NOT NULL default '',
                error text NOT NULL default '',
                expires datetime NOT NULL default '0000-00-00 00:00:00',
                last_updated datetime NOT NULL default '0000-00-00 00:00:00',
                author bigint(20) unsigned NOT NULL default '1',
                PRIMARY KEY  (id),
                KEY account_type (account_type($max_index_length)),
                KEY author (author)
            ) $charset_collate;";
			//dbDelta( $sql );
			$wpdb->query( $sql );
		}
		$error = $wpdb->last_error;
		$query = $wpdb->last_query;
		$had_error = false;
		if ( $wpdb->get_var( "show tables like '$sources_table_name'" ) != $sources_table_name ) {
			$had_error = true;
			//$sb_instagram_posts_manager->add_error( 'database_create', '<strong>' . __( 'There was an error when trying to create the database tables used to locate feeds.', 'instagram-feed' ) .'</strong><br>' . $error . '<br><code>' . $query . '</code>' );
		}

		if ( ! $had_error ) {
			//$sb_instagram_posts_manager->remove_error( 'database_create' );
		}
	}

	/**
	 * Creates the sources table and adds existing sources from 3.x
	 * to it.
	 */
	public static function create_sources_database() {
		if ( !function_exists( 'dbDelta' ) ) {
			require_once ABSPATH . '/wp-admin/includes/upgrade.php';
		}

		global $wpdb;
		$max_index_length = 191;
		$charset_collate = '';
		if ( method_exists( $wpdb, 'get_charset_collate' ) ) { // get_charset_collate introduced in WP 3.5
			$charset_collate = $wpdb->get_charset_collate();
		}

		$sources_table_name = $wpdb->prefix . 'cff_sources';

		if ( $wpdb->get_var( "show tables like '$sources_table_name'" ) != $sources_table_name ) {
			$sql = "
			CREATE TABLE " . $sources_table_name . " (
				id bigint(20) unsigned NOT NULL auto_increment,
				account_id varchar(255) NOT NULL default '',
                account_type varchar(255) NOT NULL default '',
                privilege varchar(255) NOT NULL default '',
                access_token varchar(255) NOT NULL default '',
                username varchar(255) NOT NULL default '',
                info text NOT NULL default '',
                error text NOT NULL default '',
                expires datetime NOT NULL default '0000-00-00 00:00:00',
                last_updated datetime NOT NULL default '0000-00-00 00:00:00',
                author bigint(20) unsigned NOT NULL default '1',
                PRIMARY KEY  (id),
                KEY account_type (account_type($max_index_length)),
                KEY author (author)
            ) $charset_collate;";
			dbDelta( $sql );

			$connected_accounts = (array)json_decode(stripcslashes(get_option( 'cff_connected_accounts' )), true);

			foreach ( $connected_accounts as $connected_account ) {
				$source_data = array(
					'access_token' => $connected_account['accesstoken'],
					'id'           => $connected_account['id'],
					'type'         => $connected_account['pagetype'],
					'name'         => $connected_account['name'],
					'privilege'    => '', // see if events token?
				);

				$header_details = \CustomFacebookFeed\CFF_Utils::fetch_header_data( $source_data['id'], $source_data['type'] === 'group', $source_data['access_token'], 0, false, '' );

				if ( isset( $header_details->shortcode_options ) ) {
					unset( $header_details->shortcode_options );
				}

				if ( isset( $header_details->name ) ) {
					$source_data['name'] = $header_details->name;
				}
				$source_data['info'] = $header_details;

				// don't update or insert the access token if there is an API error
				if ( ! isset( $header_details->error ) && ! isset( $header_details->cached_error ) ) {
					\CustomFacebookFeed\Builder\CFF_Source::update_or_insert( $source_data );
				}
			}

			$db_access_token_option = get_option( 'cff_access_token' );
			$db_page_access_token  = get_option( 'cff_page_access_token' );
			$db_page_id_option  = get_option( 'cff_page_id' );
			$db_page_type = get_option( 'cff_page_type' );

			if ( (! empty( $db_access_token_option ) || ! empty( $db_page_access_token ))
			     && ! empty( $db_page_id_option ) ) {
				$db_access_tokens = explode(',', str_replace( ' ', '', $db_access_token_option ) );
				$db_page_ids = explode(',', str_replace( ' ', '', $db_page_id_option ) );

				$i = 0;
				foreach ( $db_access_tokens as $db_access_token ){
					$db_page_id = $db_page_ids[ $i ];
					$source_data = array(
						'access_token' =>  ! empty( $db_page_access_token ) ? $db_page_access_token : $db_access_token,
						'id'           => $db_page_id,
						'type'         => $db_page_type === 'group' ? 'group' : 'page',
						'name'         => $db_page_id,
						'privilege'    => '', // see if events token?
					);

					$header_details = \CustomFacebookFeed\CFF_Utils::fetch_header_data( $source_data['id'], $source_data['type'] === 'group', $source_data['access_token'], 0, false, '' );

					if ( isset( $header_details->shortcode_options ) ) {
						unset( $header_details->shortcode_options );
					}

					if ( isset( $header_details->name ) ) {
						$source_data['name'] = $header_details->name;
					}
					$source_data['info'] = $header_details;

					// don't update or insert the access token if there is an API error
					if ( ! isset( $header_details->error ) && ! isset( $header_details->cached_error ) ) {
						\CustomFacebookFeed\Builder\CFF_Source::update_or_insert( $source_data );
					} else {
						if ( ! empty( $db_page_access_token ) && ! empty( $db_access_token ) ) {
							$source_data = array(
								'access_token' => $db_access_token,
								'id'           => $db_page_id,
								'type'         => $db_page_type === 'group' ? 'group' : 'page',
								'name'         => $db_page_id,
								'privilege'    => '', // see if events token?
							);

							$header_details = \CustomFacebookFeed\CFF_Utils::fetch_header_data( $source_data['id'], $source_data['type'] === 'group', $source_data['access_token'], 0, false, '' );

							if ( isset( $header_details->shortcode_options ) ) {
								unset( $header_details->shortcode_options );
							}

							if ( isset( $header_details->name ) ) {
								$source_data['name'] = $header_details->name;
							}
							$source_data['info'] = $header_details;

							if ( ! isset( $header_details->error ) && ! isset( $header_details->cached_error ) ) {
								\CustomFacebookFeed\Builder\CFF_Source::update_or_insert( $source_data );
							}
						}
					}
					$i++;
				}

			}

			// how many legacy feeds?
			$args = array(
				'html_location' => array( 'header', 'footer', 'sidebar', 'content', 'unknown' ),
				'group_by' => 'shortcode_atts',
				'page' => 1
			);
			$feeds_data = \CustomFacebookFeed\CFF_Feed_Locator::legacy_facebook_feed_locator_query( $args );
			$num_legacy = count( $feeds_data );

			$cff_statuses_option['support_legacy_shortcode'] = false;

			if ( $num_legacy > 0 ) {
				$options 		= get_option( 'cff_style_settings', array() );

				foreach ( $feeds_data as $single_legacy_feed ) {
					$shortcode_atts = $single_legacy_feed['shortcode_atts'] != '[""]' ? json_decode( $single_legacy_feed['shortcode_atts'], true ) : [];
					$shortcode_atts = is_array( $shortcode_atts ) ? $shortcode_atts : array();
					$fb_settings    = new \CustomFacebookFeed\CFF_FB_Settings( $shortcode_atts, $options );
					$feed_options   = $fb_settings->get_settings();
					if ( ! empty( $feed_options['type'] )
					     && $feed_options['type'] === 'events'
					     && ! empty( $feed_options['eventsource'] )
					     && $feed_options['eventsource'] === 'eventspage' ) {

						$args         = array( 'id' => $feed_options['id'] );
						$access_token = $feed_options['accesstoken'];
						if ( strpos( $feed_options['accesstoken'], '02Sb981f26534g75h091287a46p5l63' ) !== false ) {
							$access_token = str_replace( "02Sb981f26534g75h091287a46p5l63", "", $feed_options['accesstoken'] );
						}
						$source_query = \CustomFacebookFeed\Builder\CFF_Db::source_query( $args );

						if ( empty( $source_query ) ) {

							$source_data = array(
								'access_token' => $access_token,
								'id'           => $feed_options['id'],
								'type'         => $feed_options['pagetype'],
								'name'         => 'Events Feed',
								'privilege'    => '', // see if events token?
							);

							$header_details = \CustomFacebookFeed\CFF_Utils::fetch_header_data( $source_data['id'], $source_data['type'] === 'group', $source_data['access_token'], 0, false, '' );

							if ( isset( $header_details->shortcode_options ) ) {
								unset( $header_details->shortcode_options );
							}

							if ( isset( $header_details->name ) ) {
								$source_data['name'] = $header_details->name;
							}
							$source_data['info'] = $header_details;

							$event_fields        = 'id,name,attending_count,cover,start_time,end_time,event_times,timezone,place,description,ticket_uri,interested_count';
							$cff_events_json_url = "https://graph.facebook.com/v3.2/" . $feed_options['id'] . "/events/?fields=" . $event_fields . "&limit=1&access_token=" . $access_token . "&format=json-strings";
							$events_json         = \CustomFacebookFeed\CFF_Utils::cff_get_set_cache( $cff_events_json_url, $feed_options['id'], 10, 10, $shortcode_atts, false, $access_token );

							$events_data = json_decode( $events_json, true );

							if ( isset( $events_data['data'] ) ) {
								$source_data['privilege'] = 'events';
							}

							// don't update or insert the access token if there is an API error
							if ( ! isset( $header_details->error ) && ! isset( $header_details->cached_error ) ) {
								\CustomFacebookFeed\Builder\CFF_Source::update_or_insert( $source_data );
							}
						} else {
							$event_fields        = 'id,name,attending_count,cover,start_time,end_time,event_times,timezone,place,description,ticket_uri,interested_count';
							$cff_events_json_url = "https://graph.facebook.com/v3.2/" . $feed_options['id'] . "/events/?fields=" . $event_fields . "&limit=1&access_token=" . $access_token . "&format=json-strings";
							$events_json         = \CustomFacebookFeed\CFF_Utils::cff_get_set_cache( $cff_events_json_url, $feed_options['id'], 10, 10, $shortcode_atts, false, $access_token );

							$events_data = json_decode( $events_json, true );

							if ( isset( $events_data['data'] ) ) {
								$source_data = [
									'id'           => $feed_options['id'],
									'access_token' => $access_token,
									'privilege'    => 'events'
								];

								\CustomFacebookFeed\Builder\CFF_Source::update( $source_data, false );
							}
						}
					}

				}
			}
		}
	}

	public static function reset_tables() {
		global $wpdb;
		$feeds_table_name = $wpdb->prefix . 'cff_feeds';

		$wpdb->query( "DROP TABLE IF EXISTS $feeds_table_name" );
		$feed_caches_table_name = $wpdb->prefix . 'cff_feed_caches';

		$wpdb->query( "DROP TABLE IF EXISTS $feed_caches_table_name" );

		$sources_table_name = $wpdb->prefix . 'cff_sources';
		$wpdb->query( "DROP TABLE IF EXISTS $sources_table_name" );
	}

	public static function reset_db_update() {
		update_option( 'cff_db_version', 1.9 );
		delete_option( 'cff_legacy_feed_settings' );
		delete_option( 'cff_page_slugs' );

		// are there existing feeds to toggle legacy onboarding?
		$cff_statuses_option = get_option( 'cff_statuses', array() );

		if ( isset( $cff_statuses_option['legacy_onboarding'] ) ) {
			unset( $cff_statuses_option['legacy_onboarding'] );
		}
		if ( isset( $cff_statuses_option['support_legacy_shortcode'] ) ) {
			unset( $cff_statuses_option['support_legacy_shortcode'] );
		}

		global $wpdb;

		$table_name = $wpdb->prefix . "usermeta";
		$wpdb->query( "
        DELETE
        FROM $table_name
        WHERE `meta_key` LIKE ('cff\_%')
        " );


		$feed_locator_table_name = esc_sql( $wpdb->prefix . CFF_FEED_LOCATOR );

		$results = $wpdb->query( "
			DELETE
			FROM $feed_locator_table_name
			WHERE feed_id LIKE '*%';" );

		update_option( 'cff_statuses', $cff_statuses_option );
	}
}