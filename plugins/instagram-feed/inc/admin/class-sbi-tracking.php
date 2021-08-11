<?php
/**
 * Tracking functions for reporting plugin usage to the Smash Balloon site for users that have opted in
 *
 * @copyright   Copyright (c) 2018, Chris Christoff
 * @since       5.6
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Usage tracking
 *
 * @access public
 * @since  5.6
 * @return void
 */
class SB_Instagram_Tracking {

	public function __construct() {
		add_action( 'init', array( $this, 'schedule_send' ) );
		add_filter( 'cron_schedules', array( $this, 'add_schedules' ) );
		add_action( 'sbi_usage_tracking_cron', array( $this, 'send_checkin' ) );
	}

	private function normalize_and_format( $key, $value ) {
		$normal_bools = array(
			'sb_instagram_preserve_settings',
			'sb_instagram_ajax_theme',
			'enqueue_js_in_head',
			'disable_js_image_loading',
			'sb_instagram_disable_resize',
			'sb_instagram_favor_local',
			'sbi_hover_inc_username',
			'sbi_hover_inc_icon',
			'sbi_hover_inc_date',
			'sbi_hover_inc_instagram',
			'sbi_hover_inc_location',
			'sbi_hover_inc_caption',
			'sbi_hover_inc_likes',
			'sb_instagram_disable_lightbox',
			'sb_instagram_captionlinks',
			'sb_instagram_show_btn',
			'sb_instagram_show_caption',
			'sb_instagram_lightbox_comments',
			'sb_instagram_show_meta',
			'sb_instagram_show_header',
			'sb_instagram_show_followers',
			'sb_instagram_show_bio',
			'sb_instagram_outside_scrollable',
			'sb_instagram_stories',
			'sb_instagram_show_follow_btn',
			'sb_instagram_autoscroll',
			'sb_instagram_disable_font',
			'sb_instagram_backup',
			'sb_instagram_at',
			'sb_ajax_initial',
			'sbi_br_adjust',
			'sb_instagram_feed_width_resp',
			'enqueue_css_in_shortcode',
			'sb_instagram_disable_mob_swipe',
			'sb_instagram_disable_awesome',
			'sb_instagram_media_vine',
			'custom_template',
			'disable_admin_notice',
			'enable_email_report',
			'sb_instagram_carousel',
			'sb_instagram_carousel_arrows',
			'sb_instagram_carousel_pag',
			'sb_instagram_carousel_autoplay',
		);
		$custom_text_settings = array(
			'sb_instagram_btn_text',
			'sb_instagram_follow_btn_text',
			'sb_instagram_custom_bio',
			'sb_instagram_custom_avatar',
			'sb_instagram_custom_css',
			'sb_instagram_custom_js',
			'email_notification_addresses'
		);
		$comma_separate_counts_settings = array(
			'sb_instagram_user_id',
			'sb_instagram_tagged_ids',
			'sb_instagram_hashtag',
			'sb_instagram_highlight_ids',
			'sb_instagram_highlight_hashtag',
			'sb_instagram_hide_photos',
			'sb_instagram_exclude_words',
			'sb_instagram_include_words'
		);
		$defaults = class_exists( 'SB_Instagram_Settings_Pro' ) ? SB_Instagram_Settings_Pro::default_settings() : SB_Instagram_Settings::default_settings();

		if ( is_array( $value ) ) {
			if ( empty( $value ) ) {
				return 0;
			}
			return count( $value );
			// 0 for anything that might be false, 1 for everything else
		} elseif ( in_array( $key, $normal_bools, true ) ) {
			if ( in_array( $value, array( false, 0, '0', 'false', '' ), true ) ) {
				return 0;
			}
			return 1;

			// if a custom text setting, we just want to know if it's different than the default
		} elseif ( in_array( $key, $custom_text_settings, true ) ) {
			if ( $defaults[ $key ] === $value ) {
				return 0;
			}
			return 1;
		} elseif ( in_array( $key, $comma_separate_counts_settings, true ) ) {
			if ( str_replace( ' ', '', $value ) === '' ) {
				return 0;
			}
			$split_at_comma = explode( ',', $value );
			return count( $split_at_comma );
		}

		return $value;

	}

	private function get_data() {
		$data = array();

		// Retrieve current theme info
		$theme_data    = wp_get_theme();

		$count_b = 1;
		if ( is_multisite() ) {
			if ( function_exists( 'get_blog_count' ) ) {
				$count_b = get_blog_count();
			} else {
				$count_b = 'Not Set';
			}
		}

		$php_version = rtrim( ltrim( sanitize_text_field( phpversion() ) ) );
		$php_version = ! empty( $php_version ) ? substr( $php_version, 0, strpos( $php_version, '.', strpos( $php_version, '.' ) + 1 ) ) : phpversion();

		global $wp_version;
		$data['this_plugin'] = 'if';
		$data['php_version']   = $php_version;
		$data['mi_version']    = SBIVER;
		$data['wp_version']    = $wp_version;
		$data['server']        = isset( $_SERVER['SERVER_SOFTWARE'] ) ? $_SERVER['SERVER_SOFTWARE'] : '';
		$data['multisite']     = is_multisite();
		$data['url']           = home_url();
		$data['themename']     = $theme_data->Name;
		$data['themeversion']  = $theme_data->Version;
		$data['settings']      = array();
		$data['pro']           = (int) sbi_is_pro_version();
		$data['sites']         = $count_b;
		$data['usagetracking'] = get_option( 'sbi_usage_tracking_config', false );
		$num_users = function_exists( 'count_users' ) ? count_users() : 'Not Set';
		$data['usercount']     = is_array( $num_users ) ? $num_users['total_users'] : 1;
		$data['timezoneoffset']= date('P');

		$settings_to_send = array();
		$raw_settings = get_option( 'sb_instagram_settings', array() );

		foreach ( $raw_settings as $key => $value ) {
			$value = $this->normalize_and_format( $key, $value );

			if ( $value !== false ) {
				$key = str_replace( array( 'sb_instagram_', 'sbi_' ), '', $key );
				$settings_to_send[ $key ] = $value;
			}
		}
		$con_bus_accounts = 0;
		$recently_searched_hashtags = 0;
		$access_tokens_tried = array();
		if ( isset( $raw_settings['connected_accounts'] ) ) {
			foreach ( $raw_settings['connected_accounts'] as $connected_account ) {
				if ( isset( $connected_account['type'] ) && $connected_account['type'] === 'business') {
					$con_bus_accounts++;

					if ( ! in_array( $connected_account['access_token'], $access_tokens_tried, true ) && class_exists( 'SB_Instagram_API_Connect_Pro' ) ) {
						$access_tokens_tried[] = $connected_account['access_token'];
						$connection = new SB_Instagram_API_Connect_Pro( $connected_account, 'recently_searched_hashtags', array( 'hashtag' => '' ) );
						$connection->connect();

						$recently_searched_data = !$connection->is_wp_error() ? $connection->get_data() : false;
						$num_hashatags_searched = $recently_searched_data && isset( $recently_searched_data ) && ! isset( $recently_searched_data['data'] ) && is_array( $recently_searched_data ) ? count( $recently_searched_data ) : 0;
						$recently_searched_hashtags = $recently_searched_hashtags + $num_hashatags_searched;
					}


				}
			}
		}
		$settings_to_send['business_accounts'] = $con_bus_accounts;
		$settings_to_send['recently_searched_hashtags'] = $recently_searched_hashtags;

		$feed_caches = SB_Instagram_Cron_Updater::get_feed_cache_option_names();
		$settings_to_send['num_found_feed_caches'] = count( $feed_caches );


		if ( isset( $settings_to_send['caching_type'] ) && $settings_to_send['caching_type'] !== 'background' ) {
			$settings_to_send['recently_requested_caches'] = $settings_to_send['num_found_feed_caches'];
		} else {
			$settings_to_send['recently_requested_caches'] = 0;
			foreach ( $feed_caches as $feed_cache ) {
				$feed_id  = str_replace( '_transient_', '', $feed_cache['option_name'] );

				$transient = get_transient( $feed_id );

				if ( $transient ) {
					$feed_data      = json_decode( $transient, true );
					$last_requested = isset( $feed_data['last_requested'] ) ? (int) $feed_data['last_requested'] : false;

					if ( !$last_requested || $last_requested > time() - 5 * 3600 * 24 ) {
						$settings_to_send['recently_requested_caches']++;
					}
				}

			}
		}

		$settings_to_send['custom_header_template'] = '' !== locate_template( 'sbi/header.php', false, false ) ? 1 : 0;
		$settings_to_send['custom_header_boxed_template'] = '' !== locate_template( 'sbi/header-boxed.php', false, false ) ? 1 : 0;
		$settings_to_send['custom_header_generic_template'] = '' !== locate_template( 'sbi/header-generic.php', false, false ) ? 1 : 0;
		$settings_to_send['custom_item_template'] = '' !== locate_template( 'sbi/item.php', false, false ) ? 1 : 0;
		$settings_to_send['custom_footer_template'] = '' !== locate_template( 'sbi/footer.php', false, false ) ? 1 : 0;
		$settings_to_send['custom_feed_template'] = '' !== locate_template( 'sbi/feed.php', false, false ) ? 1 : 0;

		$sbi_current_white_names = get_option( 'sb_instagram_white_list_names', array() );
		if( empty( $sbi_current_white_names ) ){
			$settings_to_send['num_white_lists'] = 0;
		} else {
			$settings_to_send['num_white_lists'] = count( $sbi_current_white_names );
		}

		$data['settings']      = $settings_to_send;

		// Retrieve current plugin information
		if( ! function_exists( 'get_plugins' ) ) {
			include ABSPATH . '/wp-admin/includes/plugin.php';
		}

		$plugins = get_plugins();
		$active_plugins = get_option( 'active_plugins', array() );
		$plugins_to_send = array();

		foreach ( $plugins as $plugin_path => $plugin ) {
			// If the plugin isn't active, don't show it.
			if ( ! in_array( $plugin_path, $active_plugins ) )
				continue;

			$plugins_to_send[] = $plugin['Name'];
		}

		$data['active_plugins']   = $plugins_to_send;
		$data['locale']           = get_locale();

		return $data;
	}

	public function send_checkin( $override = false, $ignore_last_checkin = false ) {

		$home_url = trailingslashit( home_url() );
		if ( strpos( $home_url, 'smashballoon.com' ) !== false ) {
			return false;
		}

		if( ! $this->tracking_allowed() && ! $override ) {
			return false;
		}

		// Send a maximum of once per week
		$usage_tracking = get_option( 'sbi_usage_tracking', array( 'last_send' => 0, 'enabled' => sbi_is_pro_version() ) );
		if ( is_numeric( $usage_tracking['last_send'] ) && $usage_tracking['last_send'] > strtotime( '-1 week' ) && ! $ignore_last_checkin ) {
			return false;
		}

		$request = wp_remote_post( 'https://usage.smashballoon.com/v1/checkin/', array(
			'method'      => 'POST',
			'timeout'     => 5,
			'redirection' => 5,
			'httpversion' => '1.1',
			'blocking'    => false,
			'body'        => $this->get_data(),
			'user-agent'  => 'MI/' . SBIVER . '; ' . get_bloginfo( 'url' )
		) );

		// If we have completed successfully, recheck in 1 week
		$usage_tracking['last_send'] = time();
		update_option( 'sbi_usage_tracking', $usage_tracking, false );
		return true;
	}

	private function tracking_allowed() {
		$usage_tracking = sbi_get_option( 'sbi_usage_tracking', array( 'last_send' => 0, 'enabled' => sbi_is_pro_version() ) );
		$tracking_allowed = isset( $usage_tracking['enabled'] ) ? $usage_tracking['enabled'] : sbi_is_pro_version();

		return $tracking_allowed;
	}

	public function schedule_send() {
		if ( ! wp_next_scheduled( 'sbi_usage_tracking_cron' ) ) {
			$tracking             = array();
			$tracking['day']      = rand( 0, 6  );
			$tracking['hour']     = rand( 0, 23 );
			$tracking['minute']   = rand( 0, 59 );
			$tracking['second']   = rand( 0, 59 );
			$tracking['offset']   = ( $tracking['day']    * DAY_IN_SECONDS    ) +
			                        ( $tracking['hour']   * HOUR_IN_SECONDS   ) +
			                        ( $tracking['minute'] * MINUTE_IN_SECONDS ) +
			                        $tracking['second'];
			$last_sunday = strtotime("next sunday") - (7 * DAY_IN_SECONDS);
			if ( ($last_sunday + $tracking['offset']) > time() + 6 * HOUR_IN_SECONDS ) {
				$tracking['initsend'] = $last_sunday + $tracking['offset'];
			} else {
				$tracking['initsend'] = strtotime("next sunday") + $tracking['offset'];
			}

			wp_schedule_event( $tracking['initsend'], 'weekly', 'sbi_usage_tracking_cron' );
			update_option( 'sbi_usage_tracking_config', $tracking );
		}
	}

	public function add_schedules( $schedules = array() ) {
		// Adds once weekly to the existing schedules.
		$schedules['weekly'] = array(
			'interval' => 604800,
			'display'  => __( 'Once Weekly', 'instagram-feed' )
		);
		return $schedules;
	}
}
new SB_Instagram_Tracking();