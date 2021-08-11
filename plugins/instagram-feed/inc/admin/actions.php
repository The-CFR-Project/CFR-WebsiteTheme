<?php
/**
 * Includes functions related to actions while in the admin area.
 *
 * - All AJAX related features
 * - Enqueueing of JS and CSS files
 * - Settings link on "Plugins" page
 * - Creation of local avatar image files
 * - Connecting accounts on the "Configure" tab
 * - Displaying admin notices
 * - Clearing caches
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

function sb_instagram_admin_style() {
	wp_register_style( 'sb_instagram_admin_css', SBI_PLUGIN_URL . 'css/sb-instagram-admin.css', array(), SBIVER );
	wp_enqueue_style( 'sb_instagram_font_awesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css' );
	wp_enqueue_style( 'sb_instagram_admin_css' );
	wp_enqueue_style( 'wp-color-picker' );
}
add_action( 'admin_enqueue_scripts', 'sb_instagram_admin_style' );

function sb_instagram_admin_scripts() {
	wp_enqueue_script( 'sb_instagram_admin_js', SBI_PLUGIN_URL . 'js/sb-instagram-admin-2-2.js', array(), SBIVER );
	wp_localize_script( 'sb_instagram_admin_js', 'sbiA', array(
			'ajax_url' => admin_url( 'admin-ajax.php' ),
			'sbi_nonce' => wp_create_nonce( 'sbi_nonce' )
		)
	);
	$strings = array(
		'addon_activate'                  => esc_html__( 'Activate', 'instagram-feed' ),
		'addon_activated'                 => esc_html__( 'Activated', 'instagram-feed' ),
		'addon_active'                    => esc_html__( 'Active', 'instagram-feed' ),
		'addon_deactivate'                => esc_html__( 'Deactivate', 'instagram-feed' ),
		'addon_inactive'                  => esc_html__( 'Inactive', 'instagram-feed' ),
		'addon_install'                   => esc_html__( 'Install Addon', 'instagram-feed' ),
		'addon_error'                     => esc_html__( 'Could not install addon. Please download from wpforms.com and install manually.', 'instagram-feed' ),
		'plugin_error'                    => esc_html__( 'Could not install a plugin. Please download from WordPress.org and install manually.', 'instagram-feed' ),
		'addon_search'                    => esc_html__( 'Searching Addons', 'instagram-feed' ),
		'ajax_url'                        => admin_url( 'admin-ajax.php' ),
		'cancel'                          => esc_html__( 'Cancel', 'instagram-feed' ),
		'close'                           => esc_html__( 'Close', 'instagram-feed' ),
		'nonce'                           => wp_create_nonce( 'sbi-admin' ),
		'almost_done'                     => esc_html__( 'Almost Done', 'instagram-feed' ),
		'oops'                            => esc_html__( 'Oops!', 'instagram-feed' ),
		'ok'                              => esc_html__( 'OK', 'instagram-feed' ),
		'plugin_install_activate_btn'     => esc_html__( 'Install and Activate', 'instagram-feed' ),
		'plugin_install_activate_confirm' => esc_html__( 'needs to be installed and activated to import its forms. Would you like us to install and activate it for you?', 'instagram-feed' ),
		'plugin_activate_btn'             => esc_html__( 'Activate', 'instagram-feed' ),
	);
	$strings = apply_filters( 'sbi_admin_strings', $strings );

	wp_localize_script(
		'sb_instagram_admin_js',
		'sbi_admin',
		$strings
	);
	if( !wp_script_is('jquery-ui-draggable') ) {
		wp_enqueue_script(
			array(
				'jquery',
				'jquery-ui-core',
				'jquery-ui-draggable'
			)
		);
	}
	wp_enqueue_script(
		array(
			'hoverIntent',
			'wp-color-picker'
		)
	);
}
add_action( 'admin_enqueue_scripts', 'sb_instagram_admin_scripts' );

// Add a Settings link to the plugin on the Plugins page
$sbi_plugin_file = 'instagram-feed/instagram-feed.php';
add_filter( "plugin_action_links_{$sbi_plugin_file}", 'sbi_add_settings_link', 10, 2 );

//modify the link by unshifting the array
function sbi_add_settings_link( $links, $file ) {
	$pro_link = '<a href="https://smashballoon.com/instagram-feed/demo/?utm_campaign=instagram-free&utm_source=plugins-page&utm_medium=upgrade-link" target="_blank" style="font-weight: bold; color: #1da867;">' . __( 'Try the Pro Demo', 'instagram-feed' ) . '</a>';

	$sbi_settings_link = '<a href="' . admin_url( 'admin.php?page=sb-instagram-feed' ) . '">' . __( 'Settings', 'instagram-feed' ) . '</a>';
	array_unshift( $links, $pro_link, $sbi_settings_link );

	return $links;
}


/**
 * Called via ajax to automatically save access token and access token secret
 * retrieved with the big blue button
 */
function sbi_auto_save_tokens() {
	$nonce = $_POST['sbi_nonce'];

	if ( ! wp_verify_nonce( $nonce, 'sbi_nonce' ) ) {
		die ( 'You did not do this the right way!' );
	}

    wp_cache_delete ( 'alloptions', 'options' );

    $options = sbi_get_database_settings();
    $new_access_token = isset( $_POST['access_token'] ) ? sanitize_text_field( $_POST['access_token'] ) : false;
    $split_token = $new_access_token ? explode( '.', $new_access_token ) : array();
    $new_user_id = isset( $split_token[0] ) ? $split_token[0] : '';

    $connected_accounts =  isset( $options['connected_accounts'] ) ? $options['connected_accounts'] : array();
    $test_connection_data = sbi_account_data_for_token( $new_access_token );

    $connected_accounts[ $new_user_id ] = array(
        'access_token' => sbi_get_parts( $new_access_token ),
        'user_id' => $test_connection_data['id'],
        'username' => $test_connection_data['username'],
        'is_valid' => $test_connection_data['is_valid'],
        'last_checked' => $test_connection_data['last_checked'],
        'profile_picture' => $test_connection_data['profile_picture'],
    );

    if ( !$options['sb_instagram_disable_resize'] ) {
        if ( sbi_create_local_avatar( $test_connection_data['username'], $test_connection_data['profile_picture'] ) ) {
	        $connected_accounts[ $new_user_id ]['local_avatar'] = true;
        }
    } else {
	    $connected_accounts[ $new_user_id ]['local_avatar'] = false;
    }

    $options['connected_accounts'] = $connected_accounts;

    update_option( 'sb_instagram_settings', $options );

    echo sbi_json_encode( $connected_accounts[ $new_user_id ] );

	die();
}
add_action( 'wp_ajax_sbi_auto_save_tokens', 'sbi_auto_save_tokens' );

function sbi_delete_local_avatar( $username ) {
	$upload = wp_upload_dir();

	$image_files = glob( trailingslashit( $upload['basedir'] ) . trailingslashit( SBI_UPLOADS_NAME ) . $username . '.jpg'  ); // get all matching images
	foreach ( $image_files as $file ) { // iterate files
		if ( is_file( $file ) ) {
			unlink( $file );
		}
	}
}

function sbi_connect_business_accounts() {
	$nonce = $_POST['sbi_nonce'];

	if ( ! wp_verify_nonce( $nonce, 'sbi_nonce' ) ) {
		die ( 'You did not do this the right way!' );
	}

	$accounts = isset( $_POST['accounts'] ) ? json_decode( stripslashes( $_POST['accounts'] ), true ) : false;

	$return = array();
	foreach ( $accounts as $account ) {
		$account['type'] = 'business';

		$connector = new SBI_Account_Connector();

		$connector->add_account_data( $account );
		if ( $connector->update_stored_account() ) {
			$connector->after_update();

			$return[ $connector->get_id() ] = $connector->get_account_data();
		}
	}

	echo sbi_json_encode( $return );

	die();
}
add_action( 'wp_ajax_sbi_connect_business_accounts', 'sbi_connect_business_accounts' );

function sbi_auto_save_id() {
	$nonce = $_POST['sbi_nonce'];

	if ( ! wp_verify_nonce( $nonce, 'sbi_nonce' ) ) {
		die ( 'You did not do this the right way!' );
	}
	if ( current_user_can( 'edit_posts' ) && isset( $_POST['id'] ) ) {
		$options = get_option( 'sb_instagram_settings', array() );

		$options['sb_instagram_user_id'] = array( sanitize_text_field( $_POST['id'] ) );

		update_option( 'sb_instagram_settings', $options );
	}
	die();
}
add_action( 'wp_ajax_sbi_auto_save_id', 'sbi_auto_save_id' );

function sbi_formatted_error( $response ) {
	if ( isset( $response['error'] ) ) {
		$error = '<p>' . sprintf( __( 'API error %s:', 'instagram-feed' ), $response['error']['code'] ) . ' ' . $response['error']['message'] . '</p>';
		$error .= '<p class="sbi-error-directions"><a href="https://smashballoon.com/instagram-feed/docs/errors/" target="_blank" rel="noopener">' . __( 'Directions on how to resolve this issue', 'instagram-feed' ) . '</a></p>';

	    return $error;
    } else {
		$message = '<p>' . sprintf( __( 'Error connecting to %s.', 'instagram-feed' ), $response['url'] ). '</p>';
		if ( isset( $response['response'] ) && isset( $response['response']->errors ) ) {
			foreach ( $response['response']->errors as $key => $item ) {
				'<p>' .$message .= ' '.$key . ' - ' . $item[0] . '</p>';
			}
		}
		$message .= '<p class="sbi-error-directions"><a href="https://smashballoon.com/instagram-feed/docs/errors/" target="_blank" rel="noopener">' . __( 'Directions on how to resolve this issue', 'instagram-feed' ) . '</a></p>';

		return $message;
    }
}

function sbi_test_token() {
	$access_token = isset( $_POST['access_token'] ) ? trim( sanitize_text_field( $_POST['access_token'] ) ) : false;
	$account_id = isset( $_POST['account_id'] ) ? sanitize_text_field( $_POST['account_id'] ) : false;

	$return = sbi_connect_new_account( $access_token, $account_id );

	echo $return;
	die();
}
add_action( 'wp_ajax_sbi_test_token', 'sbi_test_token' );

function sbi_delete_account() {
	$nonce = $_POST['sbi_nonce'];

	if ( ! wp_verify_nonce( $nonce, 'sbi_nonce' ) ) {
		die ( 'You did not do this the right way!' );
	}
	$account_id = isset( $_POST['account_id'] ) ? sanitize_text_field( $_POST['account_id'] ) : false;

	sbi_do_account_delete( $account_id );

	die();
}
add_action( 'wp_ajax_sbi_delete_account', 'sbi_delete_account' );

function sbi_account_data_for_token( $access_token ) {
	$return = array(
		'id' => false,
		'username' => false,
		'is_valid' => false,
		'last_checked' => time()
	);
	$url = 'https://api.instagram.com/v1/users/self/?access_token=' . sbi_maybe_clean( $access_token );
	$args = array(
		'timeout' => 60,
		'sslverify' => false
	);
	$result = wp_remote_get( $url, $args );

	if ( ! is_wp_error( $result ) ) {
		$data = json_decode( $result['body'] );
	} else {
		$data = array();
	}

	if ( isset( $data->data->id ) ) {
		$return['id'] = $data->data->id;
		$return['username'] = $data->data->username;
		$return['is_valid'] = true;
		$return['profile_picture'] = $data->data->profile_picture;

	} elseif ( isset( $data->error_type ) && $data->error_type === 'OAuthRateLimitException' ) {
		$return['error_message'] = 'This account\'s access token is currently over the rate limit. Try removing this access token from all feeds and wait an hour before reconnecting.';
	} else {
		$return = false;
	}

	$sbi_options = get_option( 'sb_instagram_settings', array() );
	$sbi_options['sb_instagram_at'] = '';
	update_option( 'sb_instagram_settings', $sbi_options );

	return $return;
}

function sbi_do_account_delete( $account_id ) {
	$options = get_option( 'sb_instagram_settings', array() );
	$connected_accounts =  isset( $options['connected_accounts'] ) ? $options['connected_accounts'] : array();
	global $sb_instagram_posts_manager;
	$sb_instagram_posts_manager->reset_api_errors();
	wp_cache_delete ( 'alloptions', 'options' );
	$username = $connected_accounts[ $account_id ]['username'];
	$sb_instagram_posts_manager->add_action_log( 'Deleting account ' . $username );

	$num_times_used = 0;

	$new_con_accounts = array();
	foreach ( $connected_accounts as $connected_account ) {

		if ( $connected_account['username'] === $username ) {
			$num_times_used++;
		}

		if ( $connected_account['username'] !== '' && $account_id !== $connected_account['user_id'] && ! empty( $connected_account['user_id'] ) ) {
			$new_con_accounts[ $connected_account['user_id'] ] = $connected_account;
		}
	}

	if ( $num_times_used < 2 ) {
		sbi_delete_local_avatar( $username );
	}

	$options['connected_accounts'] = $new_con_accounts;

	update_option( 'sb_instagram_settings', $options );
}

function sbi_connect_new_account( $access_token, $account_id ) {
	$split_id = explode( ' ', trim( $account_id ) );
	$account_id = preg_replace("/[^A-Za-z0-9 ]/", '', $split_id[0] );
	if ( ! empty( $account_id ) ) {
		$split_token = explode( ' ', trim( $access_token ) );
		$access_token = preg_replace("/[^A-Za-z0-9 ]/", '', $split_token[0] );
	}

	$account = array(
		'access_token' => $access_token,
		'user_id' => $account_id,
		'type' => 'business'
	);

	if ( sbi_code_check( $access_token ) ) {
		$account['type'] = 'basic';
	}

	$connector = new SBI_Account_Connector();

	$response = $connector->fetch( $account );

	if ( isset( $response['access_token'] ) ) {
		$connector->add_account_data( $response );
		$connector->update_stored_account();
		$connector->after_update();
		return sbi_json_encode( $connector->get_account_data() );
	} else {
		return $response['error'];
	}
}

function sbi_no_js_connected_account_management() {
	if ( ! current_user_can( 'manage_instagram_feed_options' ) ) {
		return;
	}
	if ( isset( $_POST['sb_manual_at'] ) ) {
		$access_token = isset( $_POST['sb_manual_at'] ) ? trim( sanitize_text_field( $_POST['sb_manual_at'] ) ) : false;
		$account_id = isset( $_POST['sb_manual_account_id'] ) ? sanitize_text_field( $_POST['sb_manual_account_id'] ) : false;
		if ( ! $access_token || ! $account_id ) {
			return;
		}
		sbi_connect_new_account( $access_token, $account_id );
	} elseif ( isset( $_GET['disconnect'] ) && isset( $_GET['page'] ) && $_GET['page'] === 'sb-instagram-feed' ) {
		$account_id = sanitize_text_field( $_GET['disconnect'] );
		sbi_do_account_delete( $account_id );
	}

}
add_action( 'admin_init', 'sbi_no_js_connected_account_management' );

function sbi_get_connected_accounts_data( $sb_instagram_at ) {
	$sbi_options = get_option( 'sb_instagram_settings' );
	$return = array();
	$return['connected_accounts'] = isset( $sbi_options['connected_accounts'] ) ? $sbi_options['connected_accounts'] : array();

	if ( ! empty( $return['connected_accounts'] ) ) {
		$return['access_token'] = '';
	} else {
		$return['access_token'] = $sb_instagram_at;
	}

	if ( ! sbi_is_after_deprecation_deadline() && empty( $connected_accounts ) && ! empty( $sb_instagram_at ) ) {
		$tokens = explode(',', $sb_instagram_at );
		$user_ids = array();

		foreach ( $tokens as $token ) {
			$account = sbi_account_data_for_token( $token );
			if ( isset( $account['is_valid'] ) ) {
				$split = explode( '.', $token );
				$return['connected_accounts'][ $split[0] ] = array(
					'access_token' => sbi_get_parts( $token ),
					'user_id' => $split[0],
					'username' => '',
					'is_valid' => true,
					'last_checked' => time(),
					'profile_picture' => ''
				);
				$user_ids[] = $split[0];
			}

		}

		$sbi_options['connected_accounts'] = $return['connected_accounts'];
		$sbi_options['sb_instagram_at'] = '';
		$sbi_options['sb_instagram_user_id'] = $user_ids;

		$return['user_ids'] = $user_ids;

		update_option( 'sb_instagram_settings', $sbi_options );
	}

	return $return;
}

function sbi_connect_basic_account( $new_account_details ) {

	$options = sbi_get_database_settings();
	$connected_accounts =  isset( $options['connected_accounts'] ) ? $options['connected_accounts'] : array();

	$accounts_to_save = array();
	$old_account_user_id = '';
	$ids_to_save = array();
	$user_ids = is_array( $options[ 'sb_instagram_user_id' ] ) ? $options[ 'sb_instagram_user_id' ] : explode( ',', str_replace( ' ', '', $options[ 'sb_instagram_user_id' ] ) );

	$profile_picture = '';

	// do not connect as a basic display account if already connected as a business account
	if ( isset( $connected_accounts[ $new_account_details['user_id'] ] )
	     && isset( $connected_accounts[ $new_account_details['user_id'] ]['type'] )
	     && $connected_accounts[ $new_account_details['user_id'] ]['type'] === 'business' ) {
		return $options;
	}

	foreach ( $connected_accounts as $account ) {
		$account_type = isset( $account['type'] ) ? $account['type'] : 'personal';
		if ( ($account['username'] !== $new_account_details['username'])
		     || $account_type === 'business' ) {
			$accounts_to_save[ $account['user_id'] ] = $account;
		} else {
			$old_account_user_id = $account['user_id'];
			$profile_picture = isset( $account['profile_picture'] ) ? $account['profile_picture'] : '';
		}
	}

	foreach ( $user_ids as $id ) {
		if ( $id === $old_account_user_id ) {
			$ids_to_save[] = $new_account_details['user_id'];
		} else {
			$ids_to_save[] = $id;
		}
	}

	$accounts_to_save[ $new_account_details['user_id'] ] = array(
		'access_token' => sbi_fixer( $new_account_details['access_token'] ),
		'user_id' => $new_account_details['user_id'],
		'username' => $new_account_details['username'],
		'is_valid' => true,
		'last_checked' => time(),
		'expires_timestamp' => $new_account_details['expires_timestamp'],
		'profile_picture' => $profile_picture,
		'account_type' => strtolower( $new_account_details['account_type'] ),
		'type' => 'basic',
	);

	if ( ! empty( $old_account_user_id ) && $old_account_user_id !== $new_account_details['user_id'] ) {
		$accounts_to_save[ $new_account_details['user_id'] ]['old_user_id'] = $old_account_user_id;

		// get last saved header data
		$fuzzy_matches = sbi_fuzzy_matching_header_data( $old_account_user_id );
		if ( ! empty( $fuzzy_matches[0] ) ) {
			$header_data = sbi_find_matching_data_from_results( $fuzzy_matches, $old_account_user_id );
			$bio = SB_Instagram_Parse::get_bio( $header_data );
			$accounts_to_save[ $new_account_details['user_id'] ]['bio'] = sbi_sanitize_emoji( $bio );
		}

	}

	if ( ! empty( $profile_picture ) && !$options['sb_instagram_disable_resize'] ) {
		if ( sbi_create_local_avatar( $new_account_details['username'], $profile_picture ) ) {
			$accounts_to_save[ $new_account_details['user_id'] ]['local_avatar'] = true;
		}
	} else {
		$accounts_to_save[ $new_account_details['user_id'] ]['local_avatar'] = false;
	}

	delete_transient( SBI_USE_BACKUP_PREFIX . 'sbi_'  . $new_account_details['user_id'] );
	$refresher = new SB_Instagram_Token_Refresher( $accounts_to_save[ $new_account_details['user_id'] ] );
	$refresher->attempt_token_refresh();

	if ( $refresher->get_last_error_code() === 10 ) {
		$accounts_to_save[ $new_account_details['user_id'] ]['private'] = true;
	}

	$options['connected_accounts'] = $accounts_to_save;
	$options['sb_instagram_user_id'] = $ids_to_save;

	update_option( 'sb_instagram_settings', $options );
	//global $sb_instagram_posts_manager;

	//$sb_instagram_posts_manager->remove_all_errors();
	return $options;
}

function sbi_fuzzy_matching_header_data( $user_id ) {

	if ( empty( $user_id ) || strlen( $user_id ) < 4 ) {
		return array();
	}
	global $wpdb;
	$escaped_id = esc_sql( $user_id );

	$values = $wpdb->get_results( "
    SELECT option_value
    FROM $wpdb->options
    WHERE option_name LIKE ('%!sbi\_header\_".$escaped_id."%')
    LIMIT 10", ARRAY_A );

	$regular_values = $wpdb->get_results( "
    SELECT option_value
    FROM $wpdb->options
    WHERE option_name LIKE ('%sbi\_header\_".$escaped_id."%')
    LIMIT 10", ARRAY_A );

	$values = array_merge( $values, $regular_values );

	return $values;
}

function sbi_find_matching_data_from_results( $results, $user_id ) {

	$match = array();

	$i = 0;

	while( empty( $match ) && isset( $results[ $i ] ) ) {
		if ( ! empty( $results[ $i ] ) ) {
			$header_data = json_decode( $results[ $i ]['option_value'], true );
			if ( isset( $header_data['id'] ) && (string)$header_data['id'] === (string)$user_id ) {
				$match = $header_data;
			}
		}
		$i++;
	}

	return $match;
}

function sbi_matches_existing_personal( $new_account_details ) {

	$options = sbi_get_database_settings();
	$connected_accounts =  isset( $options['connected_accounts'] ) ? $options['connected_accounts'] : array();

	$matches_one_account = false;
	foreach ( $connected_accounts as $account ) {
		$account_type = isset( $account['type'] ) ? $account['type'] : 'personal';
		if ( ($account_type === 'personal' || $account_type === 'basic')
		     && $account['username'] == $new_account_details['username'] ) {
			$matches_one_account = true;
		}
	}

	return $matches_one_account;

}

function sbi_business_account_request( $url, $account, $remove_access_token = true ) {
	$args = array(
		'timeout' => 60,
		'sslverify' => false
	);
	$result = wp_remote_get( $url, $args );

	if ( ! is_wp_error( $result ) ) {
		$response_no_at = $remove_access_token ? str_replace( sbi_maybe_clean( $account['access_token'] ), '{accesstoken}', $result['body'] ) : $result['body'];
		return $response_no_at;
	} else {
		return sbi_json_encode( $result );
	}
}

function sbi_after_connection() {

	if ( isset( $_POST['access_token'] ) ) {
		$access_token = sanitize_text_field( $_POST['access_token'] );
		$account_info = 	sbi_account_data_for_token( $access_token );
		echo sbi_json_encode( $account_info );
	}

	die();
}
add_action( 'wp_ajax_sbi_after_connection', 'sbi_after_connection' );

function sbi_get_business_account_connection_modal($sb_instagram_user_id) {
	$access_token = sbi_maybe_clean(urldecode($_GET['sbi_access_token']));
	//
	$url = 'https://graph.facebook.com/me/accounts?fields=instagram_business_account,access_token&limit=500&access_token='.$access_token;
	$args = array(
		'timeout' => 60,
		'sslverify' => false
	);
	$result = wp_remote_get( $url, $args );
	$pages_data = '{}';
	if ( ! is_wp_error( $result ) ) {
		$pages_data = $result['body'];
	} else {
		$page_error = $result;
	}

	$pages_data_arr = json_decode($pages_data);
	$num_accounts = 0;
	if(isset($pages_data_arr)){
		$num_accounts = is_array( $pages_data_arr->data ) ? count( $pages_data_arr->data ) : 0;
	}
	?>
<div id="sbi_config_info" class="sb_list_businesses sbi_num_businesses_<?php echo $num_accounts; ?>">
    <div class="sbi_config_modal">
        <div class="sbi-managed-pages">
			<?php if ( isset( $page_error ) && isset( $page_error->errors ) ) {
				foreach ($page_error->errors as $key => $item) {
					echo '<div class="sbi_user_id_error" style="display:block;"><strong>Connection Error: </strong>' . $key . ': ' . $item[0] . '</div>';
				}
			}
			?>
			<?php if( empty($pages_data_arr->data) ) : ?>
                <span id="sbi-bus-account-error">
                            <p style="margin-top: 5px;"><b style="font-size: 16px">Couldn't find Business Profile</b><br />
                            Uh oh. It looks like this Facebook account is not currently connected to an Instagram Business profile. Please check that you are logged into the <a href="https://www.facebook.com/" target="_blank">Facebook account</a> in this browser which is associated with your Instagram Business Profile.</p>
                            <p><b style="font-size: 16px">Why do I need a Business Profile?</b><br />
                            A Business Profile is only required if you are displaying a Hashtag feed. If you want to display a regular User feed then you can do this by selecting to connect a Personal account instead. For directions on how to convert your Personal profile into a Business profile please <a href="https://smashballoon.com/instagram-business-profiles" target="_blank">see here</a>.</p>
                            </span>

			<?php elseif ( $num_accounts === 0 ): ?>
                <span id="sbi-bus-account-error">
                            <p style="margin-top: 5px;"><b style="font-size: 16px">Couldn't find Business Profile</b><br />
                            Uh oh. It looks like this Facebook account is not currently connected to an Instagram Business profile. Please check that you are logged into the <a href="https://www.facebook.com/" target="_blank">Facebook account</a> in this browser which is associated with your Instagram Business Profile.</p>
                            <p>If you are, in fact, logged-in to the correct account please make sure you have Instagram accounts connected with your Facebook account by following <a href="https://smashballoon.com/reconnecting-an-instagram-business-profile/" target="_blank">this FAQ</a></p>
                            </span>
			<?php else: ?>
                <p class="sbi-managed-page-intro"><b style="font-size: 16px;">Instagram Business profiles for this account</b><br /><i style="color: #666;">Note: In order to display a Hashtag feed you first need to select a Business profile below.</i></p>
				<?php if ( $num_accounts > 1 ) : ?>
                    <div class="sbi-managed-page-select-all"><input type="checkbox" id="sbi-select-all" class="sbi-select-all"><label for="sbi-select-all">Select All</label></div>
				<?php endif; ?>
                <div class="sbi-scrollable-accounts">

					<?php foreach ( $pages_data_arr->data as $page => $page_data ) : ?>

						<?php if( isset( $page_data->instagram_business_account ) ) :

							$instagram_business_id = $page_data->instagram_business_account->id;

							$page_access_token = isset( $page_data->access_token ) ? $page_data->access_token : '';

							//Make another request to get page info
							$instagram_account_url = 'https://graph.facebook.com/'.$instagram_business_id.'?fields=name,username,profile_picture_url&access_token='.$access_token;

							$args = array(
								'timeout' => 60,
								'sslverify' => false
							);
							$result = wp_remote_get( $instagram_account_url, $args );
							$instagram_account_info = '{}';
							if ( ! is_wp_error( $result ) ) {
								$instagram_account_info = $result['body'];
							} else {
								$page_error = $result;
							}

							$instagram_account_data = json_decode($instagram_account_info);

							$instagram_biz_img = isset( $instagram_account_data->profile_picture_url ) ? $instagram_account_data->profile_picture_url : false;
							$selected_class = $instagram_business_id == $sb_instagram_user_id ? ' sbi-page-selected' : '';

							?>
							<?php if ( isset( $page_error ) && isset( $page_error->errors ) ) :
							foreach ($page_error->errors as $key => $item) {
								echo '<div class="sbi_user_id_error" style="display:block;"><strong>Connection Error: </strong>' . $key . ': ' . $item[0] . '</div>';
							}
						else : ?>
                            <div class="sbi-managed-page<?php echo $selected_class; ?>" data-page-token="<?php echo esc_attr( $page_access_token ); ?>" data-token="<?php echo esc_attr( $access_token ); ?>" data-page-id="<?php echo esc_attr( $instagram_business_id ); ?>">
                                <div class="sbi-add-checkbox">
                                    <input id="sbi-<?php echo esc_attr( $instagram_business_id ); ?>" type="checkbox" name="sbi_managed_pages[]" value="<?php echo esc_attr( $instagram_account_info ); ?>">
                                </div>
                                <div class="sbi-managed-page-details">
                                    <label for="sbi-<?php echo esc_attr( $instagram_business_id ); ?>"><img class="sbi-page-avatar" border="0" height="50" width="50" src="<?php echo esc_url( $instagram_biz_img ); ?>"><b style="font-size: 16px;"><?php echo esc_html( $instagram_account_data->name ); ?></b>
                                        <br />@<?php echo esc_html( $instagram_account_data->username); ?><span style="font-size: 11px; margin-left: 5px;">(<?php echo esc_html( $instagram_business_id ); ?>)</span></label>
                                </div>
                            </div>
						<?php endif; ?>

						<?php endif; ?>

					<?php endforeach; ?>

                </div> <!-- end scrollable -->
                <p style="font-size: 11px; line-height: 1.5; margin-bottom: 0;"><i style="color: #666;">*<?php echo sprintf( __( 'Changing the password, updating privacy settings, or removing page admins for the related Facebook page may require %smanually reauthorizing our app%s to reconnect an account.', 'instagram-feed' ), '<a href="https://smashballoon.com/reauthorizing-our-instagram-facebook-app/" target="_blank" rel="noopener noreferrer">', '</a>' ); ?></i></p>

                <button id="sbi-connect-business-accounts" class="button button-primary" disabled="disabled" style="margin-top: 20px;"><?php _e( 'Connect Accounts', 'instagram-feed' ); ?></button>

			<?php endif; ?>

            <a href="JavaScript:void(0);" class="sbi_modal_close"><i class="fa fa-times"></i></a>
        </div>
    </div>
    </div><?php
}

function sbi_get_personal_connection_modal( $connected_accounts, $action_url = 'admin.php?page=sb-instagram-feed' ) {
	$access_token = sanitize_text_field( $_GET['sbi_access_token'] );
	$account_type = sanitize_text_field( $_GET['sbi_account_type'] );
	$user_id = sanitize_text_field( $_GET['sbi_id'] );
	$user_name = sanitize_text_field( $_GET['sbi_username'] );
	$expires_in = (int)$_GET['sbi_expires_in'];
	$expires_timestamp = time() + $expires_in;

	$new_account_details = array(
		'access_token' => $access_token,
		'account_type' => $account_type,
		'user_id' => $user_id,
		'username' => $user_name,
		'expires_timestamp' => $expires_timestamp,
		'profile_picture' => '',
		'type' => 'basic'
	);


	$matches_existing_personal = sbi_matches_existing_personal( $new_account_details );
	$button_text = $matches_existing_personal ? __( 'Update This Account', 'instagram-feed' ) : __( 'Connect This Account', 'instagram-feed' );

	$account_json = sbi_json_encode( $new_account_details );

	$already_connected_as_business_account = (isset( $connected_accounts[ $user_id ] ) && $connected_accounts[ $user_id ]['type'] === 'business');

	?>

    <div id="sbi_config_info" class="sb_get_token">
        <div class="sbi_config_modal">
            <div class="sbi_ca_username"><strong><?php echo esc_html( $user_name ); ?></strong></div>
            <form action="<?php echo admin_url( $action_url ); ?>" method="post">
                <p class="sbi_submit">
					<?php if ( $already_connected_as_business_account ) :
						_e( 'The Instagram account you are logged into is already connected as a "business" account. Remove the business account if you\'d like to connect as a basic account instead (not recommended).', 'instagram-feed' );
						?>
					<?php else : ?>
                        <input type="submit" name="sbi_submit" id="sbi_connect_account" class="button button-primary" value="<?php echo esc_html( $button_text ); ?>">
					<?php  endif; ?>
                    <input type="hidden" name="sbi_account_json" value="<?php echo esc_attr( $account_json ) ; ?>">
                    <input type="hidden" name="sbi_connect_username" value="<?php echo esc_attr( $user_name ); ?>">
                    <a href="JavaScript:void(0);" class="button button-secondary" id="sbi_switch_accounts"><?php esc_html_e( 'Switch Accounts', 'instagram-feed' ); ?></a>
                </p>
            </form>
            <a href="JavaScript:void(0);"><i class="sbi_modal_close fa fa-times"></i></a>
        </div>
    </div>
	<?php
}

function sbi_account_type_display( $type, $private = false ) {
	if ( $type === 'basic' ) {
		$type = 'personal';
		if ( $private ) {
			$type .= ' (private)';
		}
	}
	return $type;
}

function sbi_clear_backups() {
	$nonce = isset( $_POST['sbi_nonce'] ) ? sanitize_text_field( $_POST['sbi_nonce'] ) : '';

	if ( ! wp_verify_nonce( $nonce, 'sbi_nonce' ) ) {
		die ( 'You did not do this the right way!' );
	}

	//Delete all transients
	global $wpdb;
	$table_name = $wpdb->prefix . "options";
	$wpdb->query( "
    DELETE
    FROM $table_name
    WHERE `option_name` LIKE ('%!sbi\_%')
    " );
	$wpdb->query( "
    DELETE
    FROM $table_name
    WHERE `option_name` LIKE ('%\_transient\_&sbi\_%')
    " );
	$wpdb->query( "
    DELETE
    FROM $table_name
    WHERE `option_name` LIKE ('%\_transient\_timeout\_&sbi\_%')
    " );

	die();
}
add_action( 'wp_ajax_sbi_clear_backups', 'sbi_clear_backups' );

function sbi_reset_resized() {

	global $sb_instagram_posts_manager;
	$sb_instagram_posts_manager->delete_all_sbi_instagram_posts();
	delete_option( 'sbi_top_api_calls' );

	$sb_instagram_posts_manager->add_action_log( 'Reset resizing tables.' );

	echo "1";

	die();
}
add_action( 'wp_ajax_sbi_reset_resized', 'sbi_reset_resized' );

function sbi_reset_log() {
	global $sb_instagram_posts_manager;

	$sb_instagram_posts_manager->remove_all_errors();

	echo "1";

	die();
}
add_action( 'wp_ajax_sbi_reset_log', 'sbi_reset_log' );

function sbi_reset_api_errors() {
	global $sb_instagram_posts_manager;
	$sb_instagram_posts_manager->add_action_log( 'View feed and retry button clicked.' );

	$sb_instagram_posts_manager->reset_api_errors();

	echo "1";

	die();
}
add_action( 'wp_ajax_sbi_reset_api_errors', 'sbi_reset_api_errors' );

function sbi_lite_dismiss() {
	$nonce = isset( $_POST['sbi_nonce'] ) ? sanitize_text_field( $_POST['sbi_nonce'] ) : '';

	if ( ! wp_verify_nonce( $nonce, 'sbi_nonce' ) ) {
		die ( 'You did not do this the right way!' );
	}

	set_transient( 'instagram_feed_dismiss_lite', 'dismiss', 1 * WEEK_IN_SECONDS );

	die();
}
add_action( 'wp_ajax_sbi_lite_dismiss', 'sbi_lite_dismiss' );

add_action('admin_notices', 'sbi_admin_error_notices');
function sbi_admin_error_notices() {

	if ( isset( $_GET['page'] ) && in_array( $_GET['page'], array( 'sb-instagram-feed' )) ) {

		global $sb_instagram_posts_manager;

		$errors = $sb_instagram_posts_manager->get_errors();
		if ( ! empty( $errors ) && (! empty( $errors['database_create'] ) || ! empty( $errors['upload_dir'] )) ) : ?>
            <div class="notice notice-warning is-dismissible sbi-admin-notice">
				<?php if ( ! empty( $errors['database_create'] ) ) echo '<p>' . $errors['database_create'] . '</p>'; ?>

				<?php if ( ! empty( $errors['upload_dir'] ) ) echo '<p>' . $errors['upload_dir'] . '</p>'; ?>
                <p><?php _e( sprintf( 'Visit our %s page for help', '<a href="https://smashballoon.com/instagram-feed/support/faq/" target="_blank">FAQ</a>' ), 'instagram-feed' ); ?></p>

            </div>

		<?php endif;
		$errors = $sb_instagram_posts_manager->get_critical_errors();
		if ( $sb_instagram_posts_manager->are_critical_errors() && ! empty( $errors ) ) : ?>
            <div class="notice notice-warning is-dismissible sbi-admin-notice">
                <p><strong><?php echo esc_html__( 'Instagram Feed is encountering an error and your feeds may not be updating due to the following reasons:', 'instagram-feed') ; ?></strong></p>

				<?php echo $errors; ?>

				<?php
				$error_page = $sb_instagram_posts_manager->get_error_page();
				if ( $error_page ) {
					echo '<a href="' . get_the_permalink( $error_page ) . '" class="sbi-clear-errors-visit-page sbi-space-left button button-secondary">' . __( 'View Feed and Retry', 'instagram-feed' ) . '</a>';
				}
				?>
            </div>
		<?php endif;
	}

}

function sbi_get_user_names_of_personal_accounts_not_also_already_updated() {
	$sbi_options = get_option( 'sb_instagram_settings', array() );
	$users_in_personal_accounts = array();
	$non_personal_account_users = array();

	$connected_accounts = isset( $sbi_options['connected_accounts'] ) ? $sbi_options['connected_accounts'] : array();

	if ( ! empty( $connected_accounts ) ) {

		foreach ( $connected_accounts as $account ) {
			$account_type = isset( $account['type'] ) ? $account['type'] : 'personal';

			if ( $account_type === 'personal' ) {
				$users_in_personal_accounts[] = $account['username'];
			} else {
				$non_personal_account_users[] = $account['username'];
			}

		}

		if ( ! empty( $users_in_personal_accounts ) ) {
			$user_accounts_that_need_updating = array();
			foreach ( $users_in_personal_accounts as $personal_user ) {
				if ( ! in_array( $personal_user, $non_personal_account_users, true ) && $personal_user !== '' ) {
					$user_accounts_that_need_updating[] = $personal_user;
				}
			}

			return $user_accounts_that_need_updating;
		}
	} elseif ( empty( $connected_accounts ) && ! empty( $sbi_options['sb_instagram_at'] ) ) {
		return array( 'your Instagram feed');
	}

	return array();
}

function sbi_get_current_time() {
	$current_time = time();

	// where to do tests
	// $current_time = strtotime( 'November 25, 2020' ) + 1;

	return $current_time;
}

// generates the html for the admin notices
function sbi_notices_html() {

}
//add_action( 'admin_notices', 'sbi_notices_html', 8 ); // priority 12 for Twitter, priority 10 for Facebook


function sbi_get_future_date( $month, $year, $week, $day, $direction ) {
	if ( $direction > 0 ) {
		$startday = 1;
	} else {
		$startday = date( 't', mktime(0, 0, 0, $month, 1, $year ) );
	}

	$start = mktime( 0, 0, 0, $month, $startday, $year );
	$weekday = date( 'N', $start );

	$offset = 0;
	if ( $direction * $day >= $direction * $weekday ) {
		$offset = -$direction * 7;
	}

	$offset += $direction * ($week * 7) + ($day - $weekday);
	return mktime( 0, 0, 0, $month, $startday + $offset, $year );
}

function sbi_admin_hide_unrelated_notices() {

	// Bail if we're not on a sbi screen or page.
	if ( ! isset( $_GET['page'] ) || ( strpos( $_GET['page'], 'sb-instagram-feed') === false && strpos( $_GET['page'], 'sbi-') === false ) ) {
		return;
	}

	// Extra banned classes and callbacks from third-party plugins.
	$blacklist = array(
		'classes'   => array(),
		'callbacks' => array(
			'sbidb_admin_notice', // 'Database for sbi' plugin.
		),
	);

	global $wp_filter;

	foreach ( array( 'user_admin_notices', 'admin_notices', 'all_admin_notices' ) as $notices_type ) {
		if ( empty( $wp_filter[ $notices_type ]->callbacks ) || ! is_array( $wp_filter[ $notices_type ]->callbacks ) ) {
			continue;
		}
		foreach ( $wp_filter[ $notices_type ]->callbacks as $priority => $hooks ) {
			foreach ( $hooks as $name => $arr ) {
				if ( is_object( $arr['function'] ) && $arr['function'] instanceof Closure ) {
					unset( $wp_filter[ $notices_type ]->callbacks[ $priority ][ $name ] );
					continue;
				}
				$class = ! empty( $arr['function'][0] ) && is_object( $arr['function'][0] ) ? strtolower( get_class( $arr['function'][0] ) ) : '';
				if (
					! empty( $class ) &&
					strpos( $class, 'sbi' ) !== false &&
					! in_array( $class, $blacklist['classes'], true )
				) {
					continue;
				}
				if (
					! empty( $name ) && (
						strpos( $name, 'sbi' ) === false ||
						in_array( $class, $blacklist['classes'], true ) ||
						in_array( $name, $blacklist['callbacks'], true )
					)
				) {
					unset( $wp_filter[ $notices_type ]->callbacks[ $priority ][ $name ] );
				}
			}
		}
	}
}
add_action( 'admin_print_scripts', 'sbi_admin_hide_unrelated_notices' );

/* Usage */
add_action( 'admin_notices', 'sbi_usage_opt_in' );
function sbi_usage_opt_in() {
	if ( isset( $_GET['trackingdismiss'] ) ) {
		$usage_tracking = get_option( 'sbi_usage_tracking', array( 'last_send' => 0, 'enabled' => false ) );

		$usage_tracking['enabled'] = false;

		update_option( 'sbi_usage_tracking', $usage_tracking, false );

		return;
	}

	$cap = current_user_can( 'manage_instagram_feed_options' ) ? 'manage_instagram_feed_options' : 'manage_options';

	$cap = apply_filters( 'sbi_settings_pages_capability', $cap );
    if ( ! current_user_can( $cap ) ) {
        return;
    }
	$usage_tracking = sbi_get_option( 'sbi_usage_tracking', false );
	if ( $usage_tracking ) {
	    return;
    }
?>
    <div class="notice notice-warning is-dismissible sbi-admin-notice">

        <p>
            <strong><?php echo __( 'Help us improve the Instagram Feed plugin', 'instagram-feed' ); ?></strong><br>
	        <?php echo __( 'Understanding how you are using the plugin allows us to further improve it. Opt-in below to agree to send a weekly report of plugin usage data.', 'instagram-feed' ); ?>
            <a target="_blank" rel="noopener noreferrer" href="https://smashballoon.com/instagram-feed/usage-tracking/"><?php echo __( 'More information', 'instagram-feed' ); ?></a>
        </p>
        <p>
            <a href="<?php echo admin_url('admin.php?page=sb-instagram-feed&trackingdismiss=1') ?>" class="button button-primary sb-opt-in"><?php echo __( 'Yes, I\'d like to help', 'instagram-feed' ); ?></a>
            <a href="<?php echo admin_url('admin.php?page=sb-instagram-feed&trackingdismiss=1') ?>" class="sb-no-usage-opt-out sbi-space-left button button-secondary"><?php echo __( 'No, thanks', 'instagram-feed' ); ?></a>
        </p>

    </div>

<?php
}

function sbi_usage_opt_in_or_out() {
	$nonce = isset( $_POST['sbi_nonce'] ) ? sanitize_text_field( $_POST['sbi_nonce'] ) : '';

	if ( ! wp_verify_nonce( $nonce, 'sbi_nonce' ) ) {
		die ( 'You did not do this the right way!' );
	}

	$usage_tracking = sbi_get_option( 'sbi_usage_tracking', array( 'last_send' => 0, 'enabled' => false ) );

	$usage_tracking['enabled'] = isset( $_POST['opted_in'] ) ? $_POST['opted_in'] === 'true' : false;

	sbi_update_option( 'sbi_usage_tracking', $usage_tracking, false );

	die();
}
add_action( 'wp_ajax_sbi_usage_opt_in_or_out', 'sbi_usage_opt_in_or_out' );

function sbi_oembed_disable() {
	$nonce = isset( $_POST['sbi_nonce'] ) ? sanitize_text_field( $_POST['sbi_nonce'] ) : '';

	if ( ! wp_verify_nonce( $nonce, 'sbi_nonce' ) ) {
		die ( 'You did not do this the right way!' );
	}

	$oembed_settings = get_option( 'sbi_oembed_token', array() );
	$oembed_settings['access_token'] = '';
	$oembed_settings['disabled'] = true;
	echo '<strong>';
	if ( update_option( 'sbi_oembed_token', $oembed_settings ) ) {
		_e( 'Instagram oEmbeds will no longer be handled by Instagram Feed.', 'instagram-feed' );
	} else {
		_e( 'An error occurred when trying to delete your oEmbed token.', 'instagram-feed' );
	}
	echo '</strong>';

	die();
}
add_action( 'wp_ajax_sbi_oembed_disable', 'sbi_oembed_disable' );
