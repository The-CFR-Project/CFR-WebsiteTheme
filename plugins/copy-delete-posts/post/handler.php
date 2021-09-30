<?php

/**
 * Copy & Delete Posts – Post requests handler file.
 *
 * @package CDP
 * @subpackage PostHandler
 * @author CopyDeletePosts
 * @since 1.0.0
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
/** –– **\
 * Main handler + It will also sanitize and verify that request a little bit.
 * @since 1.0.0
 */
add_action('wp_ajax_cdp_action_handling', function () {
    if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
        if (isset($_POST['token']) && $_POST['token'] == 'cdp' && isset($_POST['f']) && is_admin()) {

            // Expand execution time
            if (intval(ini_get('max_execution_time')) < 7200)
                set_time_limit(0);

            // Get WP-Plugin path
            $premium_plugin = 'copy-delete-posts-premium/copy-delete-posts-premium.php';
            $premium_dir = WP_PLUGIN_DIR . '/' . 'copy-delete-posts-premium';
            $pplugin_path = $premium_dir . '/handler/premium.php';

            // Load premium content if the plugin is here
            if (is_dir($premium_dir) && is_plugin_active($premium_plugin))
                require_once($pplugin_path);

            // Is premium function
            $areWePro = is_plugin_active($premium_plugin);

            // Get user roles and check if the role is permmited to use plugin
            $access = false;
            $current_user = wp_get_current_user();
            $access_roles = get_option('_cdp_globals');
            if (!isset($access_roles['roles']))
                $access_roles = array();
            foreach ($current_user->roles as $role => $name)
                if ($name == 'administrator' || (isset($access_roles['roles'][$name]) && $access_roles['roles'][$name] == 'true')) {
                    $access = true;
                    break;
                }

            // Check user permission
            if ($access === true) {

                // Pointers
                if ($_POST['f'] == 'no_intro')
                    cdp_add_new_no_intro();
                else if ($_POST['f'] == 'intro_again')
                    cdp_add_new_intro();
                else if ($_POST['f'] == 'save_options')
                    cdp_save_plugin_options($areWePro);
                else if ($_POST['f'] == 'copy_post')
                    cdp_insert_new_post($areWePro);
                else if ($_POST['f'] == 'get_settings')
                    cdp_get_profile();
                else if ($_POST['f'] == 'get_all_settings')
                    cdp_get_all_profiles();
                else if ($_POST['f'] == 'save_profiles' && $areWePro)
                    cdp_save_profile_set();
                else if ($_POST['f'] == 'get_all_posts')
                    cdp_get_all_posts();
                else if ($_POST['f'] == 'delete_them')
                    cdp_delete_posts();
                else if ($_POST['f'] == 'get_formatted_time' && $areWePro)
                    cdp_formatted_time();
                else if ($_POST['f'] == 'set_default_profile')
                    cdp_set_default_profile();
                else if ($_POST['f'] == 'get_default_profile')
                    cdp_get_default_profile();
                else if ($_POST['f'] == 'clear_crons')
                    cdp_clear_all_crons();
                else if ($_POST['f'] == 'i_saw_this_noti')
                    cdp_set_noti_as_seen();
                else if ($_POST['f'] == 'try_to_hide_the_tasks')
                    cdp_just_hide_task();
                else if ($_POST['f'] == 'try_to_kill_the_tasks')
                    cdp_just_kill_task();
                else if ($_POST['f'] == 'give_me_current_tasks')
                    cdp_just_get_tasks();
                else if ($_POST['f'] == 'hide_cron_notice')
                    cdp_hide_perf_notice();
                else if ($_POST['f'] == 'review_dismiss')
                    cdp_review();
                else if ($_POST['f'] == 'debug_function')
                    cdp_debug_function();
                else if ($_POST['f'] == 'delete_success_img')
                    delete_option('_cdp_show_copy');
                else if ($_POST['f'] == 'save_redi_state' && $areWePro)
                    cdpp_save_redi_state();
                else if ($_POST['f'] == 'multi_redi_importer' && $areWePro)
                    cdpp_redis_importer();
                else if ($_POST['f'] == 'save_redirections' && $areWePro)
                    cdpp_save_redirections();
                else if ($_POST['f'] == 'delete_redirect' && $areWePro)
                    cdpp_delete_redirection();
                else if ($_POST['f'] == 'switch_redirects' && $areWePro)
                    cdpp_switch_redirects();
                else if ($_POST['f'] == 'get_authors' && $areWePro)
                    cdpp_get_authors();
                else if ($_POST['f'] == 'get_curr_time' && $areWePro)
                    cdpp_get_curr_s_time();
                else if ($_POST['f'] == 'get_post_export' && $areWePro)
                    cdpp_get_for_export();
                else if ($_POST['f'] == 'import_posts' && $areWePro)
                    cdpp_take_for_import();
                else if ($_POST['f'] == 'save_aci' && $areWePro)
                    cdpp_save_cleanup_settings();
                else if ($_POST['f'] == 'get_aci' && $areWePro)
                    cdpp_get_cleanup_settings();
                else if ($_POST['f'] == 'turn_off_aci' && $areWePro)
                    cdpp_turn_the_acii_off();
                else if ($_POST['f'] == 'i_love_squirrels' && $areWePro)
                    cdpp_squirrel();
                else
                    echo 'error';
            } else
                echo 'error';
        } else
            echo 'no_access';
    } else
        echo 'no_access';

    wp_die();
});
/** –– * */

/** –– **\
 * This function will be fired when user don't want to see intro – never again.
 * @since 1.0.6
 */
function cdp_review() {

    // Option
    $method = sanitize_text_field($_POST['decision']);

    // Get user id and array from db
    $user_id = get_current_user_id();
    $already = get_option('_cdp_review', false);

    // Create if not exists
    if ($already == false)
        $already = array('installed' => time(), 'users' => array());

    // Set dismiss
    $already['users'][$user_id] = array();
    $already['users'][$user_id]['dismiss'] = (($method == 'remind') ? time() : true);

    // Add option to datbase if not exit.
    $opt = update_option('_cdp_review', $already);

    // Return success
    echo json_encode(array('status' => 'success'));
}

/** –– * */

/** –– **\
 * This function will be fired when user don't want to see intro – never again.
 * @since 1.0.0
 */
function cdp_add_new_no_intro() {

    // Get user id and array from db
    $user_id = get_current_user_id();
    $already = get_option('_cdp_no_intro');

    // Check if it's first time that user checked this option.
    if (!$already)
        $already = array($user_id);

    // If it already exists just add another user.
    else if (!in_array($user_id, $already))
        array_push($already, $user_id);

    // If the user already exists exit.
    else
        exit;

    // Add option to datbase if not exit.
    $opt = update_option('_cdp_no_intro', $already);
}

/** –– * */

/** –– **\
 * This function will be fired when user want to see intro – again.
 * @since 1.0.0
 */
function cdp_add_new_intro() {

    // Get user id and array from db
    $user_id = get_current_user_id();
    $already = get_option('_cdp_no_intro');

    // Check if it's first time that user checked this option.
    if ($already && in_array($user_id, $already))
        unset($already[array_search($user_id, $already, true)]);

    // If the user no exists exit.
    else
        exit;

    // Add option to database if not exit.
    $opt = update_option('_cdp_no_intro', $already);
}

/** –– * */

/** –– **\
 * This function will be fired when user want to save plugin options – again.
 * @since 1.0.0
 */
function cdp_save_plugin_options($areWePro) {

    // Get the info about our professionalness
    $areWePro = $areWePro;

    // Get new options and current profile.
    $options = ((isset($_POST['options'])) ? cdp_sanitize_array($_POST['options']) : false);
    $entire = ((isset($_POST['entire'])) ? cdp_sanitize_array($_POST['entire']) : false);
    $profile = ((isset($_POST['profile'])) ? sanitize_text_field($_POST['profile']) : false);

    // Get current options and profiles.
    $a_or = get_option('_cdp_profiles');
    $already = get_option('_cdp_profiles');
    $g_or = get_option('_cdp_globals');
    $globals = get_option('_cdp_globals');

    // Check if it's first time – create array.
    if (!is_array($already))
        $already = array();
    if (!is_array($globals))
        $globals = array();

    // Add display name for this profile
    $profile = preg_replace('/\s+/', '_', trim(strtolower($profile)));

    // Write new settings for this profile.
    $already[$profile] = $options;
    $already[$profile]['usmplugin'] = 'false';
    $already[$profile]['yoast'] = 'false';
    $already[$profile]['woo'] = 'false';
    if ($areWePro)
        $already[$profile] = cdpp_filter_premium_opts($already, $options, $profile);

    if (!isset($already[$profile]['names']['display']) || (strlen(trim($already[$profile]['names']['display'])) <= 0))
        $already[$profile]['names']['display'] = $profile;
    $globals = $entire;

    // Check if there is default profile
    if (!array_key_exists('default', $already) || !array_key_exists('title', $already['default'])) {
        $already['default'] = array();

        if (function_exists('cdp_default_options'))
            $already['default'] = cdp_default_options();
        if (function_exists('cdp_default_global_options'))
            $globals['others'] = cdp_default_global_options();
    }

    // Add new options to database.
    $s1 = update_option('_cdp_globals', $globals);
    $s2 = update_option('_cdp_profiles', $already);

    // Check if success while uploading
    if (($s1 || $s2) || ($globals == $g_or) || ($already == $a_or))
        echo 'success';
    else
        echo 'error';
}

/** –– * */

/** –– **\
 * This function will be fired when user want to save plugin options – again.
 * @since 1.0.0
 */
function cdp_insert_new_post($areWePro = false) {

    // Performance copy time start
    $timein = microtime(true);

    // Create output array which will be returned to requester
    $output = array('status' => 'success');

    // Get ID(s) of post(s)
    $ids = ((isset($_POST['id'])) ? cdp_sanitize_array($_POST['id']) : false);

    // Get all important pieces of information from requester
    $data = ((isset($_POST['data'])) ? cdp_sanitize_array($_POST['data']) : false);
    $site = isset($_POST['data']['site']) ? sanitize_text_field($_POST['data']['site']) : false;
    $times = isset($_POST['data']['times']) ? sanitize_text_field($_POST['data']['times']) : 1;
    $swap = isset($_POST['data']['swap']) ? sanitize_text_field($_POST['data']['swap']) : false;
    $profile = isset($_POST['data']['profile']) ? sanitize_text_field($_POST['data']['profile']) : 'default';
    $origin = isset($_POST['origin']) ? sanitize_text_field($_POST['origin']) : false;
    $custom = isset($_POST['data']['custom']) ? cdp_sanitize_array($_POST['data']['custom']) : false;

    // Load default options for selected profile
    $defaults = get_option('_cdp_profiles')[$profile];

    // Settings for this copy
    $settings = (($data['type'] != 'copy-quick' && $custom != false) ? $custom : $defaults);
    if (!isset($settings['names']))
        $settings['names'] = $defaults['names'];

    // Convert string to boolean – only for much less code later
    foreach ($settings as $setting => $val)
        if ($setting != 'names')
            $settings[$setting] = (($val == 'true') ? true : false);

    /**
     * This local function filters post data by user settings
     * @param $post (array of wordpress post/page data)
     * @param $settings (array of preselected settings of profile or by user)
     * @return array with insert ready values for wordpress post || false on wrong $post
     */
    function cdp_filter_post($post, $swap, $opt, $settings, $taxonomies = false, $areWePro) {

        // If $post has wrong format return false
        if (!(is_array($post) || is_object($post)))
            return false;

        // Array for formatted and prepared taxonomy
        $ft = array();
        $buin = array('link_category', 'nav_menu', 'post_tag', 'category', 'post_format');

        // Loop thorugh all taxonomies from post
        foreach ($taxonomies as $taxonomy) {

            // Set the name to shorted variable
            $tn = $taxonomy->taxonomy;

            // Check if it's private taxonomy and if it's set in options
            if ($tn == 'link_category' && !$settings['link_category'])
                continue;
            if ($tn == 'nav_menu' && !$settings['nav_menu'])
                continue;
            if ($tn == 'post_tag' && !$settings['post_tag'])
                continue;
            if ($tn == 'category' && !$settings['category'])
                continue;
            if ($tn == 'post_format' && !$settings['format'])
                continue;

            // Don't copy custom taxonomy if it's not checked
            if (!in_array($tn, $buin) && !$settings['taxonomy'])
                continue;

            // Push next term of existing taxonomy
            if (isset($ft[$tn]))
                array_push($ft[$tn], $taxonomy->term_id);

            // Create new taxonomy and push new term
            else {
                $ft[$tn] = array();
                array_push($ft[$tn], $taxonomy->term_id);
            }
        }

        // Create array with required values and contant values
        $new = array(
            'post_title' => ($settings['title'] ? cdp_create_title($post['post_title'], $settings['names'], $post['ID'], $areWePro) : __('Untitled Copy', 'copy-delete-posts')),
            'post_date' => ($settings['date'] ? $post['post_date'] : current_time('mysql')),
            'post_status' => ($settings['status'] ? $post['post_status'] : 'draft'),
            'post_author' => ($settings['author'] ? $post['post_author'] : wp_get_current_user()->ID),
            'post_content' => ($settings['content']) ? $post['post_content'] : ' ',
            'comment_status' => $post['comment_status'], // that's additional element which cannot be edited by user
            'post_parent' => $post['post_parent'] // that's additional element which cannot be edited by user
        );

        // Converter
        if ((($opt == '2' && $swap == 'true') || $swap == 'true') && $areWePro && function_exists('cdpp_post_converter'))
            $new['post_type'] = cdpp_post_converter($post['post_type']);
        else
            $new['post_type'] = $post['post_type'];

        // Add optional values of post – depending on settings
        if ($settings['slug'])
            $new['post_name'] = $post['post_name'];
        if ($settings['excerpt'])
            $new['post_excerpt'] = $post['post_excerpt'];
        if ($settings['template'])
            $new['page_template'] = $post['page_template'];
        if ($settings['password'])
            $new['post_password'] = $post['post_password'];
        if ($settings['menu_order'])
            $new['menu_order'] = $post['menu_order'];
        if ($settings['category'])
            $new['post_category'] = $post['post_category'];
        if ($settings['post_tag'])
            $new['tags_input'] = $post['tags_input'];
        if ($taxonomies != false)
            $new['tax_input'] = $ft;

        // Return filtered data of current post
        return $new;
    }

    /**
     * This local function filters post data by user settings
     * @param $metas (array of wordpress post/page meta data)
     * @param $settings (array of preselected settings of profile or by user)
     * @return array with metadata values for post || false on wrong $metas
     */
    function cdp_filter_meta($metas, $settings, $id, $areWePro, $site, $title) {

        // If $metas has wrong format return false
        if (!(is_array($metas) || is_object($metas)))
            return false;

        // Create empty array for filtered meta data
        $prepared = array(
            // Add or replace ours copy tracker
            array('_cdp_origin' => $id),
            array('_cdp_origin_site' => $site),
            array('_cdp_origin_title' => $title),
            array('_cdp_counter' => '0')
        );

        // Iterate through every meta index
        foreach ($metas as $meta => $vals) {

            // Conditions
            $a = ($areWePro && function_exists('cdpp_check_yoast')) ? cdpp_check_yoast($settings, $meta) : false;
            $b = ($areWePro && function_exists('cdpp_check_usm')) ? cdpp_check_usm($settings, $meta) : false;
            $c = ($areWePro && function_exists('cdpp_check_woo')) ? cdpp_check_woo($settings, $meta, $id) : false;
            $d = ($settings['f_image'] && $meta == '_thumbnail_id') ? true : false;
            $e = (mb_substr($meta, 0, 4) == '_wp_') ? true : false;
            $f = ($meta == '_thumbnail_id' && $settings['f_image']) ? true : false;
            $g = ($meta == '_cdp_origin') ? true : false;
            $h = (mb_substr($meta, 0, 11) == '_elementor_') ? true : false;
            // $i = (isset($settings['all_metadata']) && $settings['all_metadata'] == 'true') ? true : false;

            // If any of above condition is true pass the meta tag
            if ($a || $b || $c || $d || $e || $f || $g || $h /*|| $i*/) {

                // Prepare data and insert filtered to results
                foreach ($vals as $val)
                    array_push($prepared, array($meta => $val));

            } else {

              // error_log(print_r($vals, true));

            }
        }

        // Return results
        return $prepared;
    }

    /**
     * This local function format title by user settings
     * @param $title (string)
     * @param $settings (array of name settings preselected in profile)
     * @return string formated title
     */
    function cdp_create_title($title, $settings, $id, $areWePro) {

        // Date formats
        $date_format = intval($settings['format']);

        // Get right format
        if ($date_format == 1)
            $date_format = 'm/d/Y';
        else if ($date_format == 2)
            $date_format = 'd/m/Y';
        else {
            if ($areWePro && function_exists('cdpp_custom_date'))
                $date_format = cdpp_custom_date($settings);
            else
                $date_format = 'd/m/Y';
        }

        // Create date and time replacements
        $curr = current_time('timestamp', true);
        $date = date($date_format, $curr);
        $time = date('H:i:s', $curr);

        // Concat whole title with prefix and suffix
        $new_title = $settings['prefix'] . ' ' . $title . ' ' . $settings['suffix'];

        // Make replace of placeholders
        $new_title = str_replace('[CurrentDate]', $date, $new_title);
        $new_title = str_replace('[CurrentTime]', $time, $new_title);

        // Return formatted title
        return $new_title;
    }

    /**
     * This local function inserts whole post into database
     * @param $data (array prepared by cdp_filter_post function)
     * @param $times (int how many times should this function copy post)
     * @return array of new inserted post(s) and error status
     * Structure of return array: { ids: [$ids], error: (count of errors) }
     */
    function cdp_insert_post($id, $data, $times, $areWePro, $isChild = false, $p_ids = null, $site) {

        // Get Wordpress database
        global $wpdb;

        // Create empty array for new id(s) and error(s)
        $results = array('ids' => array(), 'error' => 0, 'counter' => 0);

        // Get Counter value
        $prefix = (($site != -1) ? $wpdb->get_blog_prefix($site) : $wpdb->get_blog_prefix());
        $newestId = $wpdb->get_results("SELECT post_id FROM {$prefix}postmeta WHERE meta_key = '_cdp_origin' AND meta_value = {$id} ORDER BY post_id DESC LIMIT 1", ARRAY_A);
        $newestId = ((array_key_exists(0, $newestId)) ? (intval($newestId[0]['post_id'])) : false);
        if (isset($newestId) && $newestId != false && $newestId > 0)
            $counter = $wpdb->get_results("SELECT meta_value AS 'Counter' FROM {$prefix}postmeta WHERE meta_key = '_cdp_counter' AND post_id = {$newestId} ORDER BY post_id DESC", ARRAY_A)[0]['Counter'];
        else
            $counter = 1;

        $base_title = $data['post_title'];
        $counter = intval($counter) + 1;

        // Handle multisite for premium
        if ($areWePro && function_exists('cdpp_handle_multisite'))
            cdpp_handle_multisite($site);

        // Loop for each post iteration
        for ($i = 0; $i < $times; ++$i) {

            // Change parent if it's child
            if ($isChild)
                $data['post_parent'] = $p_ids['posts'][$i];

            // Replace title with Counter if multiple copies
            $data['post_title'] = str_replace('[Counter]', ($counter + $i), $base_title);

            // Insert post with filtered data
            $new = wp_insert_post($data, true);

            // Check if the post is inserted successfully and append array
            if (is_numeric($new))
                array_push($results['ids'], $new);
            else
                $results['error'] ++;
        }

        // Handle multisite for premium fix
        if ($areWePro && function_exists('cdpp_handle_multisite_after'))
            cdpp_handle_multisite_after($site);

        // Set first counter number for future
        $results['counter'] = $counter;

        // Return array with results
        return $results;
    }

    /**
     * This local function filter and adds missing meta to added post
     * @param $ids (array of post ids)
     * @param $metas (filtered meta data with cdp_filter_meta function)
     * @return array structure below
     * { ids: { [id] => [failed times]}, error: { [id] => [failed times]} }
     */
    function cdp_insert_post_meta($ids, $metas, $areWePro, $counter, $site) {

        // Handle multisite for premium
        if ($areWePro && function_exists('cdpp_handle_multisite'))
            cdpp_handle_multisite($site);

        // Create empty array for new id(s) and error(s)
        $results = array('ids' => array(), 'error' => array());

        // Iterate through every inserted post
        foreach ($ids as $id) {

            // Iterate through every meta tag
            foreach ($metas as $meta_id => $meta) {

                // Get individual data from metas array
                foreach ($meta as $key => $val) {

                    // Replace the counter with dynamic value
                    if ($key == '_cdp_counter')
                        $val = $counter;

                    // Insert meta tag
                    $res = add_post_meta($id, $key, $val);

                    // Check if the insert was successfull
                    if ($res != false) {
                        if (!isset($results['ids'][$id]))
                            $results['ids'][$id] = [];
                        array_push($results['ids'][$id], array($key, $val));
                    } else {
                        if (!isset($results['error'][$id]))
                            $results['error'][$id] = [];
                        array_push($results['error'][$id], array($key, $val));
                    }
                }
            }

            // Iterate the counter
            $counter++;
        }

        // Fix multisite handler
        if ($areWePro && function_exists('cdpp_handle_multisite_after'))
            cdpp_handle_multisite_after($site);

        // Return the results
        return $results;
    }

    /**
     * This local function search for childs and catch their IDs
     * @param $id string/int (post id)
     * @return array of child(s) ID(s)
     */
    function cdp_check_childs($id) {
        $childs = [];
        $childrens = get_children(array('post_parent' => $id));

        foreach ($childrens as $i => $child)
            array_push($childs, $child->ID);

        return $childs;
    }

    /**
     * This local function copies original attachments
     * @param $path string (path to original file)
     * @return string path to new file
     */
    function cdp_copy_attachment($path = '', $destination) {
        if ($path == '')
            return false;

        $dirname = $destination;
        $name = basename($path);
        $actual_name = pathinfo($name, PATHINFO_FILENAME);
        $original_name = $actual_name;
        $extension = pathinfo($name, PATHINFO_EXTENSION);

        $i = 1;
        while (file_exists($dirname . '/' . $actual_name . "." . $extension)) {
            $actual_name = (string) $original_name . '-' . $i;
            $name = $actual_name . '.' . $extension;
            $i++;
        }

        copy($path, $dirname . '/' . $name);
        return $dirname . '/' . $name;
    }

    /**
     * This local function gets copy and insert attachments
     * @param $id int/string of post
     * @return array of inserted attachments
     */
    function cdp_insert_attachments($id, $inserted_posts, $areWePro, $site) {
        $inserts = array();
        $media = get_attached_media('', $id);

        // Handle multisite for premium
        if ($areWePro && function_exists('cdpp_handle_multisite'))
            cdpp_handle_multisite($site);

        // Fix wordpress multisite path
        add_filter('upload_dir', 'cdp_fix_upload_paths');
        $wp_upload_dir = wp_upload_dir();
        remove_filter('upload_dir', 'cdp_fix_upload_paths');

        // Handle multisite for premium fix
        if ($areWePro && function_exists('cdpp_handle_multisite_after'))
            cdpp_handle_multisite_after($site);

        foreach ($media as $i => $m) {
            if (get_attached_file($m->ID) == '')
                continue;
            $path = cdp_copy_attachment(get_attached_file($m->ID), $wp_upload_dir['path']);

            $filename = $path;
            $parent_post_id = $inserted_posts['ids'][0];

            $filetype = wp_check_filetype(basename($filename), null);

            // Handle multisite for premium
            if ($areWePro && function_exists('cdpp_handle_multisite'))
                cdpp_handle_multisite($site);

            $attachment = array(
                'guid' => $wp_upload_dir['url'] . '/' . basename($filename),
                'post_mime_type' => $filetype['type'],
                'post_title' => preg_replace('/\.[^.]+$/', '', basename($filename)),
                'post_content' => '',
                'post_status' => 'inherit'
            );

            $attach_id = wp_insert_attachment($attachment, $filename, $parent_post_id);
            array_push($inserts, array('url' => wp_get_attachment_url($attach_id), 'id' => $attach_id));

            $attach_data = wp_generate_attachment_metadata($attach_id, $filename);
            wp_update_attachment_metadata($attach_id, $attach_data);

            // Handle multisite for premium fix
            if ($areWePro && function_exists('cdpp_handle_multisite_after'))
                cdpp_handle_multisite_after($site);
        }

        return $inserts;
    }

    /**
     * This local function gets comments and copy them
     * @param $id int/string of base post
     * @param $dests array of post ids where the comms from $id should be copied
     * @return array of inserted comments
     */
    function cdp_copy_comments($id, $dests) {
        $comments = get_comments(array('post_id' => $id));
        $curr = current_time('mysql');
        $all_inserts = array();
        $all_inserts['fix_try'] = array();
        $all_inserts['olds'] = '';

        foreach ($dests as $dest) {
            $p = 0;
            $olds = array();

            $cm1 = $comments;
            foreach ($cm1 as $i => $c) {
                $c = $c->to_array();
                $old_id = $c['comment_ID'];
                $parent = $c['comment_parent'];

                $c['comment_date'] = $curr;
                $c['comment_date_gmt'] = $curr;
                $c['comment_post_ID'] = $dest;
                $c['comment_parent'] = 0;
                if ($parent != "0")
                    $p++;

                $new_id = @wp_insert_comment($c);

                $olds[$old_id] = array('new' => $new_id, 'old_parent_id' => $parent);
                array_push($all_inserts, array('old' => $old_id, 'new' => $new_id, 'parent' => $parent));
            }

            if ($p != 0) {
                $cm2 = $comments;
                foreach ($cm2 as $j => $m) {
                    if ($m->comment_parent != "0" && $olds[$m->comment_ID]['old_parent_id'] == $m->comment_parent) {
                        $post = get_comment($olds[$m->comment_ID]['new']);
                        $post = $post->to_array();
                        $post['comment_parent'] = $olds[$m->comment_parent]['new'];
                        wp_update_comment($post);
                    }
                }
            }
        }

        return $all_inserts;
    }

    // Main code for this duplication – for each id (post) do whole process
    function cdp_process_ids($ids, $swap, $settings, $times, $site, $areWePro, $g, $isChild = false, $p_ids = null) {

        // Make it clear
        $globals = cdp_default_global_options();
        if ($g != false)
            $globals = $g;
        $g = $globals['others'];

        // Return data storage
        $output = [];
        $new_posts = array('parents' => array(), 'childs' => array(), 'ids' => array());

        // Iterate each id
        foreach ($ids as $id) {

            // Get post data and meta data
            $post = get_post($id)->to_array();
            $meta = get_post_custom($id);
            $taxonomies = wp_get_object_terms($id, get_taxonomies());

            // Check if this post type is allowed to copy
            $type = $post['post_type'];
            if ($g['cdp-content-pages'] == 'false' && $type == 'page')
                continue;
            if ($g['cdp-content-posts'] == 'false' && $type == 'post')
                continue;
            if ($g['cdp-content-custom'] == 'false' && ($type != 'page' && $type != 'post'))
                continue;

            // Post converting?
            $pConv = false;
            if (array_key_exists('postConverter', $globals))
                $pConv = $globals['postConverter'];

            // Run process and validate response
            $childrens = cdp_check_childs($id); // if sizeof($this) == has childs
            $post_data = cdp_filter_post($post, $swap, $pConv, $settings, $taxonomies, $areWePro, $swap); // can be false
            $meta_data = cdp_filter_meta($meta, $settings, $id, $areWePro, $site, $post_data['post_title']); // can be false
            $inserted_posts = cdp_insert_post($id, $post_data, $times, $areWePro, $isChild, $p_ids, $site); // $res['error'] must be == 0
            $inserted_metas = cdp_insert_post_meta($inserted_posts['ids'], $meta_data, $areWePro, $inserted_posts['counter'], $site); // sizeof($res['error']) must be == 0
            // Comments copy
            if ($settings['comments'])
                $inserted_comments = cdp_copy_comments($id, $inserted_posts['ids']);
            $cms = get_comments(array('post_id' => $id));

            // Post format
            if ($settings['format'])
                foreach ($inserted_posts['ids'] as $i => $tid)
                    $isReFormat = set_post_format($tid, get_post_format($id));

            // Featured image copy
            if ($settings['attachments'])
                $inserted_attachments = cdp_insert_attachments($id, $inserted_posts, $areWePro, $site);
            else
                $inserted_attachments = false;

            // Copy childrens recursively if exist
            if ($settings['children'] && sizeof($childrens) > 0) {
                $child_helpers = array('posts' => $inserted_posts['ids']);
                $inserted_childs = cdp_process_ids($childrens, $swap, $settings, $times, $site, $areWePro, $globals, true, $child_helpers);
                array_push($new_posts['childs'], array($id => $inserted_childs['$new_posts']['ids']));
            }

            // Add new inserted IDs
            foreach ($inserted_posts['ids'] as $i_id)
                array_push($new_posts['parents'], $i_id);

            // Merge for easier read
            $new_posts['ids'] = array_merge($new_posts['ids'], $new_posts['parents'], $new_posts['childs']);
        }

        // Return all data to main request
        return array('$output' => $output, '$new_posts' => $new_posts);
    }

    // Run the machine for selected post(s)
    $g = get_option('_cdp_globals', false);
    $new_insertions = cdp_process_ids($ids, $swap, $settings, $times, $site, $areWePro, $g);

    // Handle multisite for premium
    if ($areWePro && function_exists('cdpp_handle_multisite'))
        cdpp_handle_multisite($site);

    $pConv = false;
    if (array_key_exists('postConverter', $g) && $areWePro)
        $pConv = (($g['postConverter'] === '2' || $g['postConverter'] === 2) ? true : false);

    // Output link if it's edited post
    $aCop = ((array_key_exists('afterCopy', $g)) ? $g['afterCopy'] : '1');
    if (($data['type'] == 'copy-custom-link' || $aCop == '2'))
        $output['link'] = get_edit_post_link($new_insertions['$new_posts']['parents'][0], 'x');

    if ($pConv == true && !($data['type'] == 'copy-custom-link' || $aCop == '2'))
        $output['link'] = 'pConv';
    else
        update_option('_cdp_show_copy', true);

    // Handle multisite for premium fix
    if ($areWePro && function_exists('cdpp_handle_multisite_after'))
        cdpp_handle_multisite_after($site);

    // Check performance by time
    $copyTime = microtime(true) - $timein;
    $copyTimePerOne = $copyTime / $times;

    // Set only if had good performance all the time
    $isSlowPerf = true;
    if (get_option('cdp_latest_slow_performance', false) == false) {
      $isSlowPerf = false;
    }

    // Check if the copy time of one page was slower than 0.051 of second
    if ($copyTimePerOne > 0.051) {
      $isSlowPerf = true;
    }

    // Set the performance status
    update_option('cdp_latest_slow_performance', $isSlowPerf);

    // Update history with logs
    $logs = get_option('cdp_copy_logs_times', array());
    if (sizeof($logs) >= 50) {
      $logs = array_slice($logs, 0, 48);
    }
    $logs = array_values($logs);
    array_unshift($logs, array('amount' => $times, 'time' => $copyTime, 'perOne' => $copyTimePerOne, 'data' => time(), 'memory' => memory_get_usage(), 'peak' => memory_get_peak_usage(true)));
    update_option('cdp_copy_logs_times', $logs);

    echo json_encode(cdp_sanitize_array($output));
}

/** –– * */

/** –– **\
 * This function will return profile information for presets.
 * @return object of settings by requested profile
 * @since 1.0.0
 */
function cdp_get_profile() {

    if (function_exists('cdpp_get_all_profiles'))
        cdpp_get_profile();
    else {

        // Search for the settings of profile
        $settings = get_option('_cdp_profiles')['default'];

        // Display those settings
        echo json_encode(cdp_sanitize_array($settings));
    }
}

/** –– * */

/** –– **\
 * This function will return all profile information for manager.
 * @return object of settings by requested profile
 * @since 1.0.0
 */
function cdp_get_all_profiles() {

    if (function_exists('cdpp_get_all_profiles'))
        cdpp_get_all_profiles();
    else
        cdp_get_profile();
}

/** –– * */

/** –– **\
 * This function will return all not trashed posts
 * @return object of posts and success or fail message
 */
function cdp_get_all_posts() {
    $output = array();

    $args = array(
        'numberposts' => -1,
        'post_type' => 'post',
        'post_status' => 'publish,private,draft,future,pending,inherit,sticky'
    );

    $output['posts'] = get_posts($args);
    $args['post_type'] = 'page';
    $output['pages'] = get_posts($args);
    $output['custom'] = array();

    $post_types = get_post_types(array('public' => true, '_builtin' => false));

    if (sizeof($post_types) > 0)
        $output['custom'] = get_posts(array(
            'post_type' => $post_types,
            'numberposts' => -1,
            'post_status' => 'publish,private,draft,future,pending,inherit,sticky'
        ));

    $output['meta'] = array();
    foreach ($output['posts'] as $k => $p)
        $output['meta'][$p->ID] = get_post_meta($p->ID);
    foreach ($output['pages'] as $k => $p)
        $output['meta'][$p->ID] = get_post_meta($p->ID);
    foreach ($output['custom'] as $k => $p)
        $output['meta'][$p->ID] = get_post_meta($p->ID);

    echo json_encode(cdp_sanitize_array($output));
}

/** –– * */

/** –– **\
 * This function will delete all posts in array PERMANENTLY!
 * @return object of success message or error
 */
function cdp_delete_posts() {
    $ids = ((isset($_POST['ids'])) ? cdp_sanitize_array($_POST['ids']) : false); // ids to delete
    $throttling = sanitize_text_field($_POST['throttling']); // throttling if enabeld
    $thc = sanitize_text_field($_POST['thc']); // throttling count if enabeld
    $thrs = sanitize_text_field($_POST['thrs']) == 'true' ? true : false; // trash or not?
    $redi = sanitize_text_field($_POST['redi']) == 'true' ? true : false; // redirect if enabled
    $auit = sanitize_text_field($_POST['auit']) == 'true' ? true : false; // auit if enabled
    $auitd = ((isset($_POST['auitd'])) ? cdp_sanitize_array($_POST['auitd']) : false); // auitd if auit enabled

    $prepared_ids = array();
    $inGroup = 0;
    $curr = current_time('timestamp');
    $token = uniqid($curr, true);
    $cdp_cron = get_option('_cdp_crons');
    $site = is_multisite() ? get_current_blog_id() : '-1';
    if ($cdp_cron == false)
        $cdp_cron = array();
    $cdp_cron[$token] = array(
        'start' => $curr,
        'ids' => $ids,
        'done' => false,
        'shown' => false,
        'f' => 'delete',
        'del_size' => sizeof($ids),
        'handler' => 'cdp_cron_delete',
        'auit' => $auit,
        'auitd' => $auitd
    );
    $cdp_cron[$token]['tasks'] = array();
    $cdp_cron[$token]['args'] = array();

    if ($throttling == '1' && $thc && intval($thc) >= 1 && intval($thc) <= 10240) {

        $inGroup = ceil(intval($thc) / 30);

        for ($i = 0, $k = 2; $i < sizeof($ids); $i = $i + $inGroup, $k++)
            $cdp_cron[$token]['tasks']["-$k"] = false;

        update_option('_cdp_crons', $cdp_cron);
        for ($i = 0, $k = 2; $i < sizeof($ids); $i = $i + $inGroup, $k++) {
            $tg = array();
            $tt = array('tsk' => "-" . $k, 'token' => $token);

            for ($j = $i; $j < ($i + $inGroup); $j++)
                if (isset($ids[$j]))
                    array_push($tg, $ids[$j]);

            array_push($prepared_ids, $tg);
            $time = $k * 2;
            $args = array(array('ids' => $tg, 'site' => $site, 'trash' => $thrs, 'token' => $tt));
            wp_schedule_single_event(strtotime("+$time seconds"), 'cdp_cron_delete', $args);
            array_push($cdp_cron[$token]['args'], $args);
        }
    } else {

        $cdp_cron[$token]['tasks']["-0"] = false;
        update_option('_cdp_crons', $cdp_cron);
        $tt = array('tsk' => "-0", 'token' => $token);
        $args = array(array('ids' => $ids, 'site' => $site, 'trash' => $thrs, 'token' => $tt));
        wp_schedule_single_event(strtotime('+2 seconds'), 'cdp_cron_delete', $args);
        array_push($cdp_cron[$token]['args'], $args);
    }

    echo json_encode(array('status' => 'success', 'token' => cdp_sanitize_array($token)));
}

/** –– * */

/** –– **\
 * This function will delete all posts in array PERMANENTLY!
 * @return object of success message or error
 */
function cdp_clear_all_crons() {
    $cdp_cron = get_option('_cdp_crons');

    foreach ($cdp_cron as $cron => $val) {
        if (array_key_exists('done', $val)) {
            if ($val['done'] != true) {
                echo json_encode(array(
                    'status' => 'fail',
                    'type' => 'warning',
                    'msg' => __('You can\'t clear messages when tasks are in progress, please firstly kill tasks or wait till the end.', 'copy-delete-posts')
                ));
                return;
            }
        }
    }

    $cdp_cron = delete_option('_cdp_crons');
    echo json_encode(array('status' => 'success'));
}

/** –– * */

/** –– **\
 * Local function which sets default profile for user
 * @return Boolean
 */
function cdp_set_default_profile() {
    $curr = get_option('_cdp_preselections');
    $id = get_current_user_id();
    $new = array();
    $selection = ((isset($_POST['selection'])) ? cdp_sanitize_array($_POST['selection']) : false);
    if ($curr && !is_object($curr) || $curr == false)
        $new = array($id => $selection);
    else {
        $new = $curr;
        $new[$id] = $selection;
    }
    $stat = update_option('_cdp_preselections', $new);
    echo cdp_sanitize_array($stat);
}

/** –– * */

/** –– **\
 * Local function which gets default profile for user
 * @return String
 */
function cdp_get_default_profile() {
    echo(esc_html(get_option('_cdp_preselections')[get_current_user_id()]));
}

/** –– * */

/** –– **\
 * This function will set as seen notification!
 * @return object of success message — WARNING: ALWAYS
 */
function cdp_set_noti_as_seen() {
    if (wp_doing_cron())
        return;

    $token = ((isset($_POST['noti_token'])) ? sanitize_text_field($_POST['noti_token']) : false);
    $cdp_cron = get_option('_cdp_crons', array());
    $cdp_cron[$token]['shown'] = true;
    update_option('_cdp_crons', $cdp_cron);

    echo json_encode(array('status' => 'success'));
}

/** –– * */

/** –– **\
 * This function will delete task from the history!
 * @return object of success message or fail
 */
function cdp_just_hide_task() {
    $token = ((isset($_POST['task'])) ? sanitize_text_field($_POST['task']) : false);
    $cdp_cron = get_option('_cdp_crons', array());
    unset($cdp_cron[$token]);
    $res = update_option('_cdp_crons', $cdp_cron);

    if ($res)
        echo json_encode(array('status' => 'success'));
    else
        echo json_encode(array('status' => 'fail', 'type' => 'error', 'msg' => __('We can\'t hide this task now, – maybe it\'t already hidden. Please try again later.', 'copy-delete-posts')));
}

/** –– * */

/** –– **\
 * This function will kill task from the cron!
 * @return object of success message or fail
 */
function cdp_just_kill_task() {
    $token = ((isset($_POST['task'])) ? sanitize_text_field($_POST['task']) : false);
    $cdp_cron = get_option('_cdp_crons', array());
    $handler = $cdp_cron[$token]['handler'];
    $args = (array_key_exists('args', $cdp_cron[$token]) ? $cdp_cron[$token]['args'] : array());

    if ($cdp_cron[$token]['done'] != false) {
        echo json_encode(array('status' => 'fail', 'type' => 'error', 'msg' => __('This task has already ended this work, please wait for list refresh and try again.', 'copy-delete-posts')));
        return;
    }

    $status = true;
    $res = false;
    foreach ($args as $arg => $val) {
        $sres = wp_clear_scheduled_hook($handler, $val);
        if ($sres == false)
            $status = false;
    }

    if ($cdp_cron[$token]['done'] != false)
        $status = true;

    if ($status == true) {
        unset($cdp_cron[$token]);
        $res = update_option('_cdp_crons', $cdp_cron);
    }

    if ($status || $res)
        echo json_encode(array('status' => 'success'));
    else
        echo json_encode(array('status' => 'fail', 'type' => 'error', 'msg' => __('We can\'t confirm that we killed this task now, please try again later or check if it\'t killed.', 'copy-delete-posts')));
}

/** –– * */

/** –– **\
 * This function will catch current cron tasks!
 * @return object of tasks or fail
 */
function cdp_just_get_tasks() {
    $cdp_cron = get_option('_cdp_crons', false);

    if ($cdp_cron)
        echo json_encode(array('status' => 'success', 'tasks' => cdp_sanitize_array($cdp_cron)));
    else
        echo json_encode(array('status' => 'fail', 'type' => 'error', 'msg' => __('We couldn\'t catch current tasks, please try again later.', 'copy-delete-posts')));
}

/** –– * */

/** –– **\
 * This function will remove performance notice
 * @return void
 */
function cdp_hide_perf_notice() {
  update_option('cdp_dismiss_perf_notice', true);
  update_option('cdp_latest_slow_performance', false);
  echo json_encode(array('status' => 'success'));
}

/** –– * */

/** –– **\
 * This function is just for debug have fun with it!
 * It can be fired by function cdp_totally_know_what_i_am_doing('really');
 * It won't work in production mode so dont even try it, if you're not me ~ Mikołaj :P
 * @return mixed
 */
function cdp_debug_function() {

    // require_once('C:/Developer/Web/wordpress/wp-content/plugins/copy-delete-posts-premium/classes/methods.php');
    // $settings = get_option('cdpp_aci_settings', false);
    // $meth = new CDP_Premium($settings);
    // $posts = $meth->load_posts($settings['scan']);
    // $filtred = $meth->filter_posts($posts);

    $cdp_cron = get_option('_cdp_crons', false);
    $things_to_debug = array(
        '$cdp_cron' => $cdp_cron
    );
    var_export($things_to_debug);
}

/** –– **/
