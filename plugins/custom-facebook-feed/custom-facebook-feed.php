<?php
/*
Plugin Name: Smash Balloon Custom Facebook Feed
Plugin URI: https://smashballoon.com/custom-facebook-feed
Description: Add completely customizable Facebook feeds to your WordPress site
Version: 4.0
Author: Smash Balloon
Author URI: http://smashballoon.com/
License: GPLv2 or later
Text Domain: custom-facebook-feed
*/
/*
Copyright 2021 Smash Balloon LLC (email : hey@smashballoon.com)
This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.
This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.
You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

define('CFFVER', '4.0');
define( 'WPW_SL_STORE_URL', 'https://smashballoon.com/' );
define( 'WPW_SL_ITEM_NAME', 'Custom Facebook Feed WordPress Plugin Personal' ); //*!*Update Plugin Name at top of file*!*

// Db version.
if ( ! defined( 'CFF_DBVERSION' ) ) {
    define( 'CFF_DBVERSION', '2.1' );
}

// Plugin Folder Path.
if ( ! defined( 'CFF_PLUGIN_DIR' ) ) {
    define( 'CFF_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
}

// Plugin Folder URL.
if ( ! defined( 'CFF_PLUGIN_URL' ) ) {
    define( 'CFF_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
}

if ( ! defined( 'CFF_UPLOADS_NAME' ) ) {
	define( 'CFF_UPLOADS_NAME', 'sb-facebook-feed-images' );
}

// Name of the database table that contains instagram posts
if ( ! defined( 'CFF_POSTS_TABLE' ) ) {
	define( 'CFF_POSTS_TABLE', 'cff_posts' );
}

// Name of the database table that contains feed ids and the ids of posts
if ( ! defined( 'CFF_FEEDS_POSTS_TABLE' ) ) {
	define( 'CFF_FEEDS_POSTS_TABLE', 'cff_feeds_posts' );
}

// Plugin File.
if ( ! defined( 'CFF_FILE' ) ) {
    define( 'CFF_FILE',  __FILE__ );
}

if ( ! defined( 'CFF_PLUGIN_BASE' ) ) {
    define( 'CFF_PLUGIN_BASE', plugin_basename( CFF_FILE ) );
}
if ( ! defined( 'CFF_FEED_LOCATOR' ) ) {
    define( 'CFF_FEED_LOCATOR', 'cff_facebook_feed_locator' );
}

if ( ! defined( 'CFF_BUILDER_DIR' ) ) {
    define( 'CFF_BUILDER_DIR', CFF_PLUGIN_DIR . 'admin/builder/' );
}

if ( ! defined( 'CFF_BUILDER_URL' ) ) {
    define( 'CFF_BUILDER_URL', CFF_PLUGIN_URL . 'admin/builder/' );
}

/**
 * Check PHP version
 *
 * Check for minimum PHP 5.6 version
 *
 * @since 2.19
*/
if ( version_compare( phpversion(), '5.6', '<' ) ) {
    if( !function_exists( 'cff_check_php_notice' ) ){
        include CFF_PLUGIN_DIR . 'admin/enqueu-script.php';
        function cff_check_php_notice(){
            $include_revert = ( version_compare( phpversion(), '5.6', '<' ) &&  version_compare( phpversion(), '5.3', '>' ) );
            ?>
                <div class="notice notice-error">
                    <div>
                        <p><strong><?php echo esc_html__('Important:','custom-facebook-feed') ?> </strong><?php echo esc_html__('Your website is using an outdated version of PHP. The Custom Facebook Feed plugin requires PHP version 5.6 or higher and so has been temporarily deactivated.','custom-facebook-feed') ?></p>

                        <p>
                            <?php
                            echo esc_html__('To continue using the plugin','custom-facebook-feed') . ', ';

                            if($include_revert):
                                echo esc_html__('either use the button below to revert back to the previous version','custom-facebook-feed') . ', ';
                            else:
                                echo sprintf( __('you can either manually reinstall the previous version of the plugin (%s) ','custom-facebook-feed' ), '<a href="https://downloads.wordpress.org/plugin/custom-facebook-feed.2.17.1.zip">'. __( 'download', 'custom-facebook-feed' ).'</a>' );
                            endif;

                            echo esc_html__('or contact your host to request that they upgrade your PHP version to 5.6 or higher.','custom-facebook-feed');
                            ?>
                        </p>

                        <?php if($include_revert): ?>
                            <p><button data-plugin="https://downloads.wordpress.org/plugin/custom-facebook-feed.2.17.1.zip" data-type="plugin" class="cff-notice-admin-btn status-download button button-primary"><?php echo esc_html__('Revert Back to Previous Version','custom-facebook-feed') ?></button></p>
                        <?php endif; ?>
                    </div>
                </div>
            <?php
        }
    }
    add_action( 'admin_notices', 'cff_check_php_notice' );
    return; //Stop until PHP version is fixed
}

include CFF_PLUGIN_DIR . 'admin/admin-functions.php';
include CFF_PLUGIN_DIR . 'inc/Custom_Facebook_Feed.php';

if ( function_exists('cff_main_pro') ){
    wp_die( "Please deactivate the Pro version of the Custom Facebook Feed plugin before activating this version.<br /><br />Back to the WordPress <a href='".get_admin_url(null, 'plugins.php')."'>Plugins page</a>." );
}


function cff_main() {
    return CustomFacebookFeed\Custom_Facebook_Feed::instance();
}
cff_main();