<?php
use CustomFacebookFeed\CFF_Utils;
use CustomFacebookFeed\CFF_Oembed;
use CustomFacebookFeed\CFF_GDPR_Integrations;
use CustomFacebookFeed\CFF_Feed_Locator;

add_action('group_post_scheduler_cron', 'cff_group_cache_function');
function cff_group_cache_function(){
    CustomFacebookFeed\CFF_Group_Posts::cron_update_group_persistent_cache();
}


//Create Style page
	function cff_style_page() {
	    //Declare variables for fields
	    $style_hidden_field_name                = 'cff_style_submit_hidden';
	    $style_general_hidden_field_name        = 'cff_style_general_submit_hidden';
	    $style_post_layout_hidden_field_name    = 'cff_style_post_layout_submit_hidden';
	    $style_typography_hidden_field_name     = 'cff_style_typography_submit_hidden';
	    $style_misc_hidden_field_name           = 'cff_style_misc_submit_hidden';
	    $style_custom_text_hidden_field_name    = 'cff_style_custom_text_submit_hidden';

	    //Defaults need to be here on the Settings page so that they're saved when the initial settings are saved
	    $defaults = array(
	        //Post types
	        'cff_show_links_type'       => true,
	        'cff_show_event_type'       => true,
	        'cff_show_video_type'       => true,
	        'cff_show_photos_type'      => true,
	        'cff_show_status_type'      => true,
	        //Layout
	        'cff_preset_layout'         => 'thumb',
	        //Include
	        'cff_show_text'             => true,
	        'cff_show_desc'             => true,
	        'cff_show_shared_links'     => true,
	        'cff_show_date'             => true,
	        'cff_show_media'            => true,
	        'cff_show_media_link'       => true,
	        'cff_show_event_title'      => true,
	        'cff_show_event_details'    => true,
	        'cff_show_meta'             => true,
	        'cff_show_link'             => true,
	        'cff_show_like_box'         => true,
	        //Post Style
	        'cff_post_style'            => '',
	        'cff_post_bg_color'         => '',
	        'cff_post_rounded'          => '0',
	        'cff_box_shadow'            => false,
	        //Typography
	        'cff_title_format'          => 'p',
	        'cff_title_size'            => 'inherit',
	        'cff_title_weight'          => 'inherit',
	        'cff_title_color'           => '',
	        'cff_posttext_link_color'   => '',
	        'cff_body_size'             => '12',
	        'cff_body_weight'           => 'inherit',
	        'cff_body_color'            => '',
	        'cff_link_title_format'     => 'p',
	        'cff_link_title_size'       => 'inherit',
	        'cff_link_url_size'         => '12',
	        'cff_link_desc_size'        => 'inherit',
	        'cff_link_desc_color'       => '',
	        'cff_link_title_color'      => '',
	        'cff_link_url_color'        => '',
	        'cff_link_bg_color'         => '',
	        'cff_link_border_color'     => '',
	        'cff_disable_link_box'      => '',
	        //Event title
	        'cff_event_title_format'    => 'p',
	        'cff_event_title_size'      => 'inherit',
	        'cff_event_title_weight'    => 'inherit',
	        'cff_event_title_color'     => '',
	        //Event date
	        'cff_event_date_size'       => 'inherit',
	        'cff_event_date_weight'     => 'inherit',
	        'cff_event_date_color'      => '',
	        'cff_event_date_position'   => 'below',
	        'cff_event_date_formatting' => '1',
	        'cff_event_date_custom'     => '',
	        //Event details
	        'cff_event_details_size'    => 'inherit',
	        'cff_event_details_weight'  => 'inherit',
	        'cff_event_details_color'   => '',
	        'cff_event_link_color'      => '',
	        //Date
	        'cff_date_position'         => 'author',
	        'cff_date_size'             => 'inherit',
	        'cff_date_weight'           => 'inherit',
	        'cff_date_color'            => '',
	        'cff_date_formatting'       => '1',
	        'cff_date_custom'           => '',
	        'cff_date_before'           => '',
	        'cff_date_after'            => '',
	        'cff_timezone'              => 'America/Chicago',

	        //Link to Facebook
	        'cff_link_size'             => 'inherit',
	        'cff_link_weight'           => 'inherit',
	        'cff_link_color'            => '',
	        'cff_facebook_link_text'    => 'View on Facebook',
	        'cff_view_link_text'        => 'View Link',
	        'cff_link_to_timeline'      => false,
	        //Meta
	        'cff_icon_style'            => 'light',
	        'cff_meta_text_color'       => '',
	        'cff_meta_bg_color'         => '',
	        'cff_nocomments_text'       => 'No comments yet',
	        'cff_hide_comments'         => '',
	        //Misc
	        'cff_feed_width'            => '100%',
	        'cff_feed_width_resp'       => false,
	        'cff_feed_height'           => '',
	        'cff_feed_padding'          => '',
	        'cff_like_box_position'     => 'bottom',
	        'cff_like_box_outside'      => false,
	        'cff_likebox_width'         => '',
	        'cff_likebox_height'        => '',
	        'cff_like_box_faces'        => false,
	        'cff_like_box_border'       => false,
	        'cff_like_box_cover'        => true,
	        'cff_like_box_small_header' => false,
	        'cff_like_box_hide_cta'     => false,

	        'cff_bg_color'              => '',
	        'cff_likebox_bg_color'      => '',
	        'cff_like_box_text_color'   => 'blue',
	        'cff_video_height'          => '',
	        'cff_show_author'           => true,
	        'cff_class'                 => '',
	        'cff_open_links'            => true,
	        'cff_cron'                  => 'unset',
	        'cff_request_method'        => 'auto',
	        'cff_disable_styles'        => false,
	        'cff_format_issue'          => false,
	        'cff_restricted_page'       => false,
	        'cff_cols'                  => 1,
	        'cff_cols_mobile'           => 1,

	        //New
        	'gdpr' => 'auto',
	        'cff_custom_css'            => '',
	        'cff_custom_js'             => '',
	        'cff_title_link'            => false,
	        'cff_post_tags'             => true,
	        'cff_link_hashtags'         => true,
	        'cff_event_title_link'      => true,
	        'cff_video_action'          => 'post',
	        'cff_app_id'                => '',
	        'cff_show_credit'           => '',
	        'cff_font_source'           => '',
            'cff_enqueue_with_shortcode' => false,
	        'cff_minify'                => false,
	        'disable_admin_notice'      => false,
	        'cff_sep_color'             => '',
	        'cff_sep_size'              => '1',

	        //Feed Header
	        'cff_show_header'           => '',
	        'cff_header_type'           => '',
	        'cff_header_cover'          => true,
	        'cff_header_name'           => true,
	        'cff_header_bio'            => true,
	        'cff_header_outside'        => false,
	        'cff_header_cover_height' => '300',
	        'cff_header_text'           => 'Facebook Posts',
	        'cff_header_bg_color'       => '',
	        'cff_header_padding'        => '',
	        'cff_header_text_size'      => '',
	        'cff_header_text_weight'    => '',
	        'cff_header_text_color'     => '',
	        'cff_header_icon'           => '',
	        'cff_header_icon_color'     => '',
	        'cff_header_icon_size'      => '28',

	        //Author
	        'cff_author_size'           => 'inherit',
	        'cff_author_color'          => '',

	        //Translate - general
	        'cff_see_more_text'         => 'See More',
	        'cff_see_less_text'         => 'See Less',
	        'cff_facebook_link_text'    => 'View on Facebook',
	        'cff_facebook_share_text'   => 'Share',
	        'cff_show_facebook_link'    => true,
	        'cff_show_facebook_share'   => true,

	        'cff_translate_photos_text' => 'photos',
	        'cff_translate_photo_text'  => 'Photo',
	        'cff_translate_video_text'  => 'Video',

	        'cff_translate_learn_more_text' => 'Learn More',
	        'cff_translate_shop_now_text'   => 'Shop Now',
	        'cff_translate_message_page_text' => 'Message Page',

	        //Translate - date
	        'cff_translate_second'      => 'second',
	        'cff_translate_seconds'     => 'seconds',
	        'cff_translate_minute'      => 'minute',
	        'cff_translate_minutes'     => 'minutes',
	        'cff_translate_hour'        => 'hour',
	        'cff_translate_hours'       => 'hours',
	        'cff_translate_day'         => 'day',
	        'cff_translate_days'        => 'days',
	        'cff_translate_week'        => 'week',
	        'cff_translate_weeks'       => 'weeks',
	        'cff_translate_month'       => 'month',
	        'cff_translate_months'      => 'months',
	        'cff_translate_year'        => 'year',
	        'cff_translate_years'       => 'years',
	        'cff_translate_ago'         => 'ago',

	        // email
	        'enable_email_report' => 'on',
			'email_notification' => 'monday',
			'email_notification_addresses' => get_option( 'admin_email' )
	    );
	    //Save layout option in an array
	    $options = wp_parse_args(get_option('cff_style_settings'), $defaults);
	    add_option( 'cff_style_settings', $options );

	    //Set the page variables
	    //Post types
	    $cff_show_links_type = $options[ 'cff_show_links_type' ];
	    $cff_show_event_type = $options[ 'cff_show_event_type' ];
	    $cff_show_video_type = $options[ 'cff_show_video_type' ];
	    $cff_show_photos_type = $options[ 'cff_show_photos_type' ];
	    $cff_show_status_type = $options[ 'cff_show_status_type' ];
	    //Layout
	    $cff_preset_layout = $options[ 'cff_preset_layout' ];
	    //Include
	    $cff_show_text = $options[ 'cff_show_text' ];
	    $cff_show_desc = $options[ 'cff_show_desc' ];
	    $cff_show_shared_links = $options[ 'cff_show_shared_links' ];
	    $cff_show_date = $options[ 'cff_show_date' ];
	    $cff_show_media = $options[ 'cff_show_media' ];
	    $cff_show_media_link = $options[ 'cff_show_media_link' ];
	    $cff_show_event_title = $options[ 'cff_show_event_title' ];
	    $cff_show_event_details = $options[ 'cff_show_event_details' ];
	    $cff_show_meta = $options[ 'cff_show_meta' ];
	    $cff_show_link = $options[ 'cff_show_link' ];
	    $cff_show_like_box = $options[ 'cff_show_like_box' ];
	    //Post Style
	    $cff_post_style = $options[ 'cff_post_style' ];
	    $cff_post_bg_color = $options[ 'cff_post_bg_color' ];
	    $cff_post_rounded = $options[ 'cff_post_rounded' ];
	    $cff_box_shadow = $options[ 'cff_box_shadow' ];

	    //Typography
	    $cff_see_more_text = $options[ 'cff_see_more_text' ];
	    $cff_see_less_text = $options[ 'cff_see_less_text' ];
	    $cff_title_format = $options[ 'cff_title_format' ];
	    $cff_title_size = $options[ 'cff_title_size' ];
	    $cff_title_weight = $options[ 'cff_title_weight' ];
	    $cff_title_color = $options[ 'cff_title_color' ];
	    $cff_posttext_link_color = $options[ 'cff_posttext_link_color' ];
	    $cff_body_size = $options[ 'cff_body_size' ];
	    $cff_body_weight = $options[ 'cff_body_weight' ];
	    $cff_body_color = $options[ 'cff_body_color' ];
	    $cff_link_title_format = $options[ 'cff_link_title_format' ];
	    $cff_link_title_size = $options[ 'cff_link_title_size' ];
	    $cff_link_url_size = $options[ 'cff_link_url_size' ];
	    $cff_link_desc_size = $options[ 'cff_link_desc_size' ];
	    $cff_link_desc_color = $options[ 'cff_link_desc_color' ];
	    $cff_link_title_color = $options[ 'cff_link_title_color' ];
	    $cff_link_url_color = $options[ 'cff_link_url_color' ];
	    $cff_link_bg_color = $options[ 'cff_link_bg_color' ];
	    $cff_link_border_color = $options[ 'cff_link_border_color' ];
	    $cff_disable_link_box = $options[ 'cff_disable_link_box' ];

	    //Event title
	    $cff_event_title_format = $options[ 'cff_event_title_format' ];
	    $cff_event_title_size = $options[ 'cff_event_title_size' ];
	    $cff_event_title_weight = $options[ 'cff_event_title_weight' ];
	    $cff_event_title_color = $options[ 'cff_event_title_color' ];
	    //Event date
	    $cff_event_date_size = $options[ 'cff_event_date_size' ];
	    $cff_event_date_weight = $options[ 'cff_event_date_weight' ];
	    $cff_event_date_color = $options[ 'cff_event_date_color' ];
	    $cff_event_date_position = $options[ 'cff_event_date_position' ];
	    $cff_event_date_formatting = $options[ 'cff_event_date_formatting' ];
	    $cff_event_date_custom = $options[ 'cff_event_date_custom' ];
	    //Event details
	    $cff_event_details_size = $options[ 'cff_event_details_size' ];
	    $cff_event_details_weight = $options[ 'cff_event_details_weight' ];
	    $cff_event_details_color = $options[ 'cff_event_details_color' ];
	    $cff_event_link_color = $options[ 'cff_event_link_color' ];
	    //Date
	    $cff_date_position = $options[ 'cff_date_position' ];
	    $cff_date_size = $options[ 'cff_date_size' ];
	    $cff_date_weight = $options[ 'cff_date_weight' ];
	    $cff_date_color = $options[ 'cff_date_color' ];
	    $cff_date_formatting = $options[ 'cff_date_formatting' ];
	    $cff_date_custom = $options[ 'cff_date_custom' ];
	    $cff_date_before = $options[ 'cff_date_before' ];
	    $cff_date_after = $options[ 'cff_date_after' ];
	    $cff_timezone = $options[ 'cff_timezone' ];

	    //Date translate
	    $cff_translate_second = $options[ 'cff_translate_second' ];
	    $cff_translate_seconds = $options[ 'cff_translate_seconds' ];
	    $cff_translate_minute = $options[ 'cff_translate_minute' ];
	    $cff_translate_minutes = $options[ 'cff_translate_minutes' ];
	    $cff_translate_hour = $options[ 'cff_translate_hour' ];
	    $cff_translate_hours = $options[ 'cff_translate_hours' ];
	    $cff_translate_day = $options[ 'cff_translate_day' ];
	    $cff_translate_days = $options[ 'cff_translate_days' ];
	    $cff_translate_week = $options[ 'cff_translate_week' ];
	    $cff_translate_weeks = $options[ 'cff_translate_weeks' ];
	    $cff_translate_month = $options[ 'cff_translate_month' ];
	    $cff_translate_months = $options[ 'cff_translate_months' ];
	    $cff_translate_year = $options[ 'cff_translate_year' ];
	    $cff_translate_years = $options[ 'cff_translate_years' ];
	    $cff_translate_ago = $options[ 'cff_translate_ago' ];
	    //Photos translate
	    $cff_translate_photos_text = $options[ 'cff_translate_photos_text' ];
	    $cff_translate_photo_text = $options[ 'cff_translate_photo_text' ];
	    $cff_translate_video_text = $options[ 'cff_translate_video_text' ];

	    $cff_translate_learn_more_text = $options[ 'cff_translate_learn_more_text' ];
	    $cff_translate_shop_now_text = $options[ 'cff_translate_shop_now_text' ];
	    $cff_translate_message_page_text = $options[ 'cff_translate_message_page_text' ];

	    //View on Facebook link
	    $cff_link_size = $options[ 'cff_link_size' ];
	    $cff_link_weight = $options[ 'cff_link_weight' ];
	    $cff_link_color = $options[ 'cff_link_color' ];
	    $cff_facebook_link_text = $options[ 'cff_facebook_link_text' ];
	    $cff_view_link_text = $options[ 'cff_view_link_text' ];
	    $cff_link_to_timeline = $options[ 'cff_link_to_timeline' ];
	    $cff_facebook_share_text = $options[ 'cff_facebook_share_text' ];
	    $cff_show_facebook_link = $options[ 'cff_show_facebook_link' ];
	    $cff_show_facebook_share = $options[ 'cff_show_facebook_share' ];
	    //Meta
	    $cff_icon_style = $options[ 'cff_icon_style' ];
	    $cff_meta_text_color = $options[ 'cff_meta_text_color' ];
	    $cff_meta_bg_color = $options[ 'cff_meta_bg_color' ];
	    $cff_nocomments_text = $options[ 'cff_nocomments_text' ];
	    $cff_hide_comments = $options[ 'cff_hide_comments' ];
	    //Misc
	    $cff_feed_width = $options[ 'cff_feed_width' ];
	    $cff_feed_width_resp = $options[ 'cff_feed_width_resp' ];
	    $cff_feed_height = $options[ 'cff_feed_height' ];
	    $cff_feed_padding = $options[ 'cff_feed_padding' ];
	    $cff_like_box_position = $options[ 'cff_like_box_position' ];
	    $cff_like_box_outside = $options[ 'cff_like_box_outside' ];
	    $cff_likebox_width = $options[ 'cff_likebox_width' ];
	    $cff_likebox_height = $options[ 'cff_likebox_height' ];
	    $cff_like_box_faces = $options[ 'cff_like_box_faces' ];
	    $cff_like_box_border = $options[ 'cff_like_box_border' ];
	    $cff_like_box_cover = $options[ 'cff_like_box_cover' ];
	    $cff_like_box_small_header = $options[ 'cff_like_box_small_header' ];
	    $cff_like_box_hide_cta = $options[ 'cff_like_box_hide_cta' ];


	    $cff_show_media = $options[ 'cff_show_media' ];
	    $cff_bg_color = $options[ 'cff_bg_color' ];
	    $cff_likebox_bg_color = $options[ 'cff_likebox_bg_color' ];
	    $cff_like_box_text_color = $options[ 'cff_like_box_text_color' ];
	    $cff_video_height = $options[ 'cff_video_height' ];
	    $cff_show_author = $options[ 'cff_show_author' ];
	    $cff_class = $options[ 'cff_class' ];
	    $cff_open_links = $options[ 'cff_open_links' ];
	    $cff_app_id = $options[ 'cff_app_id' ];
	    $cff_show_credit = $options[ 'cff_show_credit' ];
	    $cff_font_source = $options[ 'cff_font_source' ];
	    $cff_preserve_settings   = 'cff_preserve_settings';
	    $cff_preserve_settings_val = get_option( $cff_preserve_settings );
	    $cff_cron = $options[ 'cff_cron' ];
	    $cff_request_method = $options[ 'cff_request_method' ];
	    $cff_disable_styles = $options[ 'cff_disable_styles' ];
	    $cff_format_issue = $options[ 'cff_format_issue' ];
	    $cff_restricted_page = $options[ 'cff_restricted_page' ];
        $cff_enqueue_with_shortcode = $options[ 'cff_enqueue_with_shortcode' ];
	    $cff_minify = $options[ 'cff_minify' ];
	    $cff_cols = $options[ 'cff_cols' ];
	    $cff_cols_mobile = $options[ 'cff_cols_mobile' ];
		$cff_disable_admin_notice = $options[ 'disable_admin_notice' ];
		$cff_enable_email_report = $options[ 'enable_email_report' ];
		$cff_email_notification = $options[ 'email_notification' ];
		$cff_email_notification_addresses = $options[ 'email_notification_addresses' ];

	    //Page Header
	    $cff_show_header = $options[ 'cff_show_header' ];
	    $cff_header_type = $options[ 'cff_header_type' ];
	    $cff_header_cover = $options[ 'cff_header_cover' ];
	    $cff_header_name = $options[ 'cff_header_name' ];
	    $cff_header_bio = $options[ 'cff_header_bio' ];
	    $cff_header_cover_height = $options[ 'cff_header_cover_height' ];
	    $cff_header_outside = $options[ 'cff_header_outside' ];
	    $cff_header_text = $options[ 'cff_header_text' ];
	    $cff_header_bg_color = $options[ 'cff_header_bg_color' ];
	    $cff_header_padding = $options[ 'cff_header_padding' ];
	    $cff_header_text_size = $options[ 'cff_header_text_size' ];
	    $cff_header_text_weight = $options[ 'cff_header_text_weight' ];
	    $cff_header_text_color = $options[ 'cff_header_text_color' ];
	    $cff_header_icon = $options[ 'cff_header_icon' ];
	    $cff_header_icon_color = $options[ 'cff_header_icon_color' ];
	    $cff_header_icon_size = $options[ 'cff_header_icon_size' ];

	    //Author
	    $cff_author_size = $options[ 'cff_author_size' ];
	    $cff_author_color = $options[ 'cff_author_color' ];

    	$gdpr = $options[ 'gdpr' ];
	    //New
	    $cff_custom_css = $options[ 'cff_custom_css' ];
	    $cff_custom_js = $options[ 'cff_custom_js' ];
	    $cff_title_link = $options[ 'cff_title_link' ];
	    $cff_post_tags = $options[ 'cff_post_tags' ];
	    $cff_link_hashtags = $options[ 'cff_link_hashtags' ];
	    $cff_event_title_link = $options[ 'cff_event_title_link' ];
	    $cff_video_action = $options[ 'cff_video_action' ];
	    $cff_sep_color = $options[ 'cff_sep_color' ];
	    $cff_sep_size = $options[ 'cff_sep_size' ];

		// Texts lengths
		$cff_title_length   = 'cff_title_length';
	    $cff_body_length    = 'cff_body_length';
	    // Read in existing option value from database
	    $cff_title_length_val = get_option( $cff_title_length, '400' );
	    $cff_body_length_val = get_option( $cff_body_length, '200' );

	    //Ajax
	    $cff_ajax = 'cff_ajax';
	    $cff_ajax_val = get_option( $cff_ajax );

	    //Check nonce before saving data
	    if ( ! isset( $_POST['cff_customize_nonce'] ) || ! wp_verify_nonce( $_POST['cff_customize_nonce'], 'cff_saving_customize' ) ) {
	        //Nonce did not verify
	    } else {
	        // See if the user has posted us some information. If they did, this hidden field will be set to 'Y'.
	        if( isset($_POST[ $style_hidden_field_name ]) && $_POST[ $style_hidden_field_name ] == 'Y' ) {
	            //Update the General options
	            if( isset($_POST[ $style_general_hidden_field_name ]) && $_POST[ $style_general_hidden_field_name ] == 'Y' ) {
	                //General
	                if (isset($_POST[ 'cff_feed_width' ]) ) $cff_feed_width = sanitize_text_field( $_POST[ 'cff_feed_width' ] );
	                (isset($_POST[ 'cff_feed_width_resp' ]) ) ? $cff_feed_width_resp = sanitize_text_field( $_POST[ 'cff_feed_width_resp' ] ) : $cff_feed_width_resp = '';
	                if (isset($_POST[ 'cff_feed_height' ]) ) $cff_feed_height = sanitize_text_field( $_POST[ 'cff_feed_height' ] );
	                if (isset($_POST[ 'cff_feed_padding' ]) ) $cff_feed_padding = sanitize_text_field( $_POST[ 'cff_feed_padding' ] );
	                if (isset($_POST[ 'cff_bg_color' ]) ) $cff_bg_color = sanitize_text_field( $_POST[ 'cff_bg_color' ] );
	                if (isset($_POST[ 'cff_class' ]) ) $cff_class = sanitize_text_field( $_POST[ 'cff_class' ] );
	                if (isset($_POST[ 'cff_cols' ])) $cff_cols = sanitize_text_field( $_POST[ 'cff_cols' ] );
	                if (isset($_POST[ 'cff_cols_mobile' ])) $cff_cols_mobile = sanitize_text_field( $_POST[ 'cff_cols_mobile' ] );

	                //Page Header
	                (isset($_POST[ 'cff_show_header' ])) ? $cff_show_header = sanitize_text_field( $_POST[ 'cff_show_header' ] ) : $cff_show_header = '';
	                (isset($_POST[ 'cff_header_type' ])) ? $cff_header_type = $_POST[ 'cff_header_type' ] : $cff_header_type = '';
	                (isset($_POST[ 'cff_header_cover' ])) ? $cff_header_cover = $_POST[ 'cff_header_cover' ] : $cff_header_cover = '';
	                (isset($_POST[ 'cff_header_name' ])) ? $cff_header_name = $_POST[ 'cff_header_name' ] : $cff_header_name = '';
	                (isset($_POST[ 'cff_header_bio' ])) ? $cff_header_bio = $_POST[ 'cff_header_bio' ] : $cff_header_bio = '';
	                (isset($_POST[ 'cff_header_cover_height' ])) ? $cff_header_cover_height = $_POST[ 'cff_header_cover_height' ] : $cff_header_cover_height = '';
	                (isset($_POST[ 'cff_header_outside' ])) ? $cff_header_outside = sanitize_text_field( $_POST[ 'cff_header_outside' ] ) : $cff_header_outside = '';
	                if (isset($_POST[ 'cff_header_text' ])) $cff_header_text = sanitize_text_field( $_POST[ 'cff_header_text' ] );
	                if (isset($_POST[ 'cff_header_bg_color' ])) $cff_header_bg_color = sanitize_text_field( $_POST[ 'cff_header_bg_color' ] );
	                if (isset($_POST[ 'cff_header_padding' ])) $cff_header_padding = sanitize_text_field( $_POST[ 'cff_header_padding' ] );
	                if (isset($_POST[ 'cff_header_text_size' ])) $cff_header_text_size = sanitize_text_field( $_POST[ 'cff_header_text_size' ] );
	                if (isset($_POST[ 'cff_header_text_weight' ])) $cff_header_text_weight = sanitize_text_field( $_POST[ 'cff_header_text_weight' ] );
	                if (isset($_POST[ 'cff_header_text_color' ])) $cff_header_text_color = sanitize_text_field( $_POST[ 'cff_header_text_color' ] );
	                if (isset($_POST[ 'cff_header_icon' ])) $cff_header_icon = sanitize_text_field( $_POST[ 'cff_header_icon' ] );
	                if (isset($_POST[ 'cff_header_icon_color' ])) $cff_header_icon_color = sanitize_text_field( $_POST[ 'cff_header_icon_color' ] );
	                if (isset($_POST[ 'cff_header_icon_size' ])) $cff_header_icon_size = sanitize_text_field( $_POST[ 'cff_header_icon_size' ] );

	                //Like Box
	                (isset($_POST[ 'cff_show_like_box' ])) ? $cff_show_like_box = sanitize_text_field( $_POST[ 'cff_show_like_box' ] ) : $cff_show_like_box = '';
	                if (isset($_POST[ 'cff_like_box_position' ])) $cff_like_box_position = sanitize_text_field( $_POST[ 'cff_like_box_position' ] );
	                (isset($_POST[ 'cff_like_box_outside' ])) ? $cff_like_box_outside = sanitize_text_field( $_POST[ 'cff_like_box_outside' ] ) : $cff_like_box_outside = '';
	                if (isset($_POST[ 'cff_likebox_bg_color' ])) $cff_likebox_bg_color = sanitize_text_field( $_POST[ 'cff_likebox_bg_color' ] );
	                if (isset($_POST[ 'cff_like_box_text_color' ])) $cff_like_box_text_color = sanitize_text_field( $_POST[ 'cff_like_box_text_color' ] );
	                if (isset($_POST[ 'cff_likebox_width' ])) $cff_likebox_width = sanitize_text_field( $_POST[ 'cff_likebox_width' ] );
	                if (isset($_POST[ 'cff_likebox_height' ])) $cff_likebox_height = sanitize_text_field( $_POST[ 'cff_likebox_height' ] );
	                (isset($_POST[ 'cff_like_box_faces' ])) ? $cff_like_box_faces = sanitize_text_field( $_POST[ 'cff_like_box_faces' ] ) : $cff_like_box_faces = '';
	                (isset($_POST[ 'cff_like_box_border' ])) ? $cff_like_box_border = sanitize_text_field( $_POST[ 'cff_like_box_border' ] ) : $cff_like_box_border = '';
	                (isset($_POST[ 'cff_like_box_cover' ])) ? $cff_like_box_cover = sanitize_text_field( $_POST[ 'cff_like_box_cover' ] ) : $cff_like_box_cover = '';
	                (isset($_POST[ 'cff_like_box_small_header' ])) ? $cff_like_box_small_header = sanitize_text_field( $_POST[ 'cff_like_box_small_header' ] ) : $cff_like_box_small_header = '';
	                (isset($_POST[ 'cff_like_box_hide_cta' ])) ? $cff_like_box_hide_cta = sanitize_text_field( $_POST[ 'cff_like_box_hide_cta' ] ) : $cff_like_box_hide_cta = '';

	                //Post types
	                if (isset($_POST[ 'cff_show_links_type' ]) ) $cff_show_links_type = sanitize_text_field( $_POST[ 'cff_show_links_type' ] );
	                if (isset($_POST[ 'cff_show_event_type' ]) ) $cff_show_event_type = sanitize_text_field( $_POST[ 'cff_show_event_type' ] );
	                if (isset($_POST[ 'cff_show_video_type' ]) ) $cff_show_video_type = sanitize_text_field( $_POST[ 'cff_show_video_type' ] );
	                if (isset($_POST[ 'cff_show_photos_type' ]) ) $cff_show_photos_type = sanitize_text_field( $_POST[ 'cff_show_photos_type' ] );
	                if (isset($_POST[ 'cff_show_status_type' ]) ) $cff_show_status_type = sanitize_text_field( $_POST[ 'cff_show_status_type' ] );
	                //General
	                $options[ 'cff_feed_width' ] = $cff_feed_width;
	                $options[ 'cff_feed_width_resp' ] = $cff_feed_width_resp;
	                $options[ 'cff_feed_height' ] = $cff_feed_height;
	                $options[ 'cff_feed_padding' ] = $cff_feed_padding;
	                $options[ 'cff_bg_color' ] = $cff_bg_color;
	                $options[ 'cff_class' ] = $cff_class;
	                $options[ 'cff_cols' ] = $cff_cols;
	                $options[ 'cff_cols_mobile' ] = $cff_cols_mobile;

	                //Page Header
	                $options[ 'cff_show_header' ] = $cff_show_header;
	                $options[ 'cff_header_type' ] = $cff_header_type;
	                $options[ 'cff_header_cover' ] = $cff_header_cover;
	                $options[ 'cff_header_name' ] = $cff_header_name;
	                $options[ 'cff_header_bio' ] = $cff_header_bio;
	                $options[ 'cff_header_cover_height' ] = $cff_header_cover_height;
	                $options[ 'cff_header_outside' ] = $cff_header_outside;
	                $options[ 'cff_header_text' ] = $cff_header_text;
	                $options[ 'cff_header_bg_color' ] = $cff_header_bg_color;
	                $options[ 'cff_header_padding' ] = $cff_header_padding;
	                $options[ 'cff_header_text_size' ] = $cff_header_text_size;
	                $options[ 'cff_header_text_weight' ] = $cff_header_text_weight;
	                $options[ 'cff_header_text_color' ] = $cff_header_text_color;
	                $options[ 'cff_header_icon' ] = $cff_header_icon;
	                $options[ 'cff_header_icon_color' ] = $cff_header_icon_color;
	                $options[ 'cff_header_icon_size' ] = $cff_header_icon_size;

	                //Misc
	                $options[ 'cff_show_like_box' ] = $cff_show_like_box;
	                $options[ 'cff_like_box_position' ] = $cff_like_box_position;
	                $options[ 'cff_like_box_outside' ] = $cff_like_box_outside;
	                $options[ 'cff_likebox_bg_color' ] = $cff_likebox_bg_color;
	                $options[ 'cff_like_box_text_color' ] = $cff_like_box_text_color;
	                $options[ 'cff_likebox_width' ] = $cff_likebox_width;
	                $options[ 'cff_likebox_height' ] = $cff_likebox_height;
	                $options[ 'cff_like_box_faces' ] = $cff_like_box_faces;
	                $options[ 'cff_like_box_border' ] = $cff_like_box_border;
	                $options[ 'cff_like_box_cover' ] = $cff_like_box_cover;
	                $options[ 'cff_like_box_small_header' ] = $cff_like_box_small_header;
	                $options[ 'cff_like_box_hide_cta' ] = $cff_like_box_hide_cta;

	                //Post types
	                $options[ 'cff_show_links_type' ] = $cff_show_links_type;
	                $options[ 'cff_show_event_type' ] = $cff_show_event_type;
	                $options[ 'cff_show_video_type' ] = $cff_show_video_type;
	                $options[ 'cff_show_photos_type' ] = $cff_show_photos_type;
	                $options[ 'cff_show_status_type' ] = $cff_show_status_type;
	            }
	            //Update the Post Layout options
	            if( isset($_POST[ $style_post_layout_hidden_field_name ]) && $_POST[ $style_post_layout_hidden_field_name ] == 'Y' ) {
	                //Layout
	                if (isset($_POST[ 'cff_preset_layout' ]) ) $cff_preset_layout = sanitize_text_field( $_POST[ 'cff_preset_layout' ] );
	                //Include
	                (isset($_POST[ 'cff_show_author' ]) ) ? $cff_show_author = sanitize_text_field( $_POST[ 'cff_show_author' ] ) : $cff_show_author = '';
	                (isset($_POST[ 'cff_show_text' ]) ) ? $cff_show_text = sanitize_text_field( $_POST[ 'cff_show_text' ] ) : $cff_show_text = '';
	                (isset($_POST[ 'cff_show_desc' ]) ) ? $cff_show_desc = sanitize_text_field( $_POST[ 'cff_show_desc' ] ) : $cff_show_desc = '';
	                (isset($_POST[ 'cff_show_shared_links' ]) ) ? $cff_show_shared_links = sanitize_text_field( $_POST[ 'cff_show_shared_links' ] ) : $cff_show_shared_links = '';
	                (isset($_POST[ 'cff_show_date' ]) ) ? $cff_show_date = sanitize_text_field( $_POST[ 'cff_show_date' ] ) : $cff_show_date = '';
	                (isset($_POST[ 'cff_show_media' ]) ) ? $cff_show_media = sanitize_text_field( $_POST[ 'cff_show_media' ] ) : $cff_show_media = '';
	                (isset($_POST[ 'cff_show_media_link' ]) ) ? $cff_show_media_link = sanitize_text_field( $_POST[ 'cff_show_media_link' ] ) : $cff_show_media_link = '';
	                (isset($_POST[ 'cff_show_event_title' ]) ) ? $cff_show_event_title = sanitize_text_field( $_POST[ 'cff_show_event_title' ] ) : $cff_show_event_title = '';
	                (isset($_POST[ 'cff_show_event_details' ]) ) ? $cff_show_event_details = sanitize_text_field( $_POST[ 'cff_show_event_details' ] ) : $cff_show_event_details = '';
	                (isset($_POST[ 'cff_show_meta' ]) ) ? $cff_show_meta = sanitize_text_field( $_POST[ 'cff_show_meta' ] ) : $cff_show_meta = '';
	                (isset($_POST[ 'cff_show_link' ]) ) ? $cff_show_link = sanitize_text_field( $_POST[ 'cff_show_link' ] ) : $cff_show_link = '';

	                //Layout
	                $options[ 'cff_preset_layout' ] = $cff_preset_layout;
	                //Include
	                $options[ 'cff_show_author' ] = $cff_show_author;
	                $options[ 'cff_show_text' ] = $cff_show_text;
	                $options[ 'cff_show_desc' ] = $cff_show_desc;
	                $options[ 'cff_show_shared_links' ] = $cff_show_shared_links;
	                $options[ 'cff_show_date' ] = $cff_show_date;
	                $options[ 'cff_show_media' ] = $cff_show_media;
	                $options[ 'cff_show_media_link' ] = $cff_show_media_link;
	                $options[ 'cff_show_event_title' ] = $cff_show_event_title;
	                $options[ 'cff_show_event_details' ] = $cff_show_event_details;
	                $options[ 'cff_show_meta' ] = $cff_show_meta;
	                $options[ 'cff_show_link' ] = $cff_show_link;

	            }
	            //Update the Typography options
	            if( isset($_POST[ $style_typography_hidden_field_name ]) && $_POST[ $style_typography_hidden_field_name ] == 'Y' ) {
	                //Character limits
	                if (isset($_POST[ 'cff_title_length' ]) ) $cff_title_length_val = sanitize_text_field( $_POST[ $cff_title_length ] );
	                if (isset($_POST[ 'cff_body_length' ]) ) $cff_body_length_val = sanitize_text_field( $_POST[ $cff_body_length ] );

	                //Post Style
	                if (isset($_POST[ 'cff_post_style' ]) ) $cff_post_style = $_POST[ 'cff_post_style' ];
	                (isset($_POST[ 'cff_post_bg_color' ]) ) ? $cff_post_bg_color = $_POST[ 'cff_post_bg_color' ] : $cff_post_bg_color = '';
	                (isset($_POST[ 'cff_post_rounded' ]) ) ? $cff_post_rounded = $_POST[ 'cff_post_rounded' ] : $cff_post_rounded = '';
	                if (isset($_POST[ 'cff_sep_color' ])) $cff_sep_color = $_POST[ 'cff_sep_color' ];
	                if (isset($_POST[ 'cff_sep_size' ])) $cff_sep_size = $_POST[ 'cff_sep_size' ];
	                (isset($_POST[ 'cff_box_shadow' ]) ) ? $cff_box_shadow = $_POST[ 'cff_box_shadow' ] : $cff_box_shadow = '';

	                //Author
	                if (isset($_POST[ 'cff_author_size' ])) $cff_author_size = sanitize_text_field( $_POST[ 'cff_author_size' ] );
	                if (isset($_POST[ 'cff_author_color' ])) $cff_author_color = sanitize_text_field( $_POST[ 'cff_author_color' ] );

	                //Typography
	                if (isset($_POST[ 'cff_title_format' ]) ) $cff_title_format = sanitize_text_field( $_POST[ 'cff_title_format' ] );
	                if (isset($_POST[ 'cff_title_size' ]) ) $cff_title_size = sanitize_text_field( $_POST[ 'cff_title_size' ] );
	                if (isset($_POST[ 'cff_title_weight' ]) ) $cff_title_weight = sanitize_text_field( $_POST[ 'cff_title_weight' ] );
	                if (isset($_POST[ 'cff_title_color' ]) ) $cff_title_color = sanitize_text_field( $_POST[ 'cff_title_color' ] );
	                if (isset($_POST[ 'cff_posttext_link_color' ]) ) $cff_posttext_link_color = sanitize_text_field( $_POST[ 'cff_posttext_link_color' ] );

	                (isset($_POST[ 'cff_title_link' ]) ) ? $cff_title_link = sanitize_text_field( $_POST[ 'cff_title_link' ] ) : $cff_title_link = '';
	                (isset($_POST[ 'cff_post_tags' ]) ) ? $cff_post_tags = sanitize_text_field( $_POST[ 'cff_post_tags' ] ) : $cff_post_tags = '';
	                (isset($_POST[ 'cff_link_hashtags' ]) ) ? $cff_link_hashtags = sanitize_text_field( $_POST[ 'cff_link_hashtags' ] ) : $cff_link_hashtags = '';

	                $cff_body_size = $_POST[ 'cff_body_size' ];
	                if (isset($_POST[ 'cff_body_weight' ]) ) $cff_body_weight = sanitize_text_field( $_POST[ 'cff_body_weight' ] );
	                if (isset($_POST[ 'cff_body_color' ]) ) $cff_body_color = sanitize_text_field( $_POST[ 'cff_body_color' ] );
	                if (isset($_POST[ 'cff_link_title_format' ]) ) $cff_link_title_format = sanitize_text_field( $_POST[ 'cff_link_title_format' ] );
	                if (isset($_POST[ 'cff_link_title_size' ]) ) $cff_link_title_size = $_POST[ 'cff_link_title_size' ];
	                if (isset($_POST[ 'cff_link_url_size' ]) ) $cff_link_url_size = $_POST[ 'cff_link_url_size' ];
	                if (isset($_POST[ 'cff_link_desc_size' ]) ) $cff_link_desc_size = $_POST[ 'cff_link_desc_size' ];
	                if (isset($_POST[ 'cff_link_desc_color' ]) ) $cff_link_desc_color = $_POST[ 'cff_link_desc_color' ];
	                if (isset($_POST[ 'cff_link_title_color' ]) ) $cff_link_title_color = $_POST[ 'cff_link_title_color' ];
	                if (isset($_POST[ 'cff_link_url_color' ]) ) $cff_link_url_color = $_POST[ 'cff_link_url_color' ];
	                if (isset($_POST[ 'cff_link_bg_color' ]) ) $cff_link_bg_color = $_POST[ 'cff_link_bg_color' ];
	                if (isset($_POST[ 'cff_link_border_color' ]) ) $cff_link_border_color = $_POST[ 'cff_link_border_color' ];
	                (isset($_POST[ 'cff_disable_link_box' ])) ? $cff_disable_link_box = $_POST[ 'cff_disable_link_box' ] : $cff_disable_link_box = '';


	                //Event title
	                if (isset($_POST[ 'cff_event_title_format' ]) ) $cff_event_title_format = sanitize_text_field( $_POST[ 'cff_event_title_format' ] );
	                if (isset($_POST[ 'cff_event_title_size' ]) ) $cff_event_title_size = sanitize_text_field( $_POST[ 'cff_event_title_size' ] );
	                if (isset($_POST[ 'cff_event_title_weight' ]) ) $cff_event_title_weight = sanitize_text_field( $_POST[ 'cff_event_title_weight' ] );
	                if (isset($_POST[ 'cff_event_title_color' ]) ) $cff_event_title_color = sanitize_text_field( $_POST[ 'cff_event_title_color' ] );
	                (isset($_POST[ 'cff_event_title_link' ]) ) ? $cff_event_title_link = sanitize_text_field( $_POST[ 'cff_event_title_link' ] ) : $cff_event_title_link = '';
	                //Event date
	                if (isset($_POST[ 'cff_event_date_size' ]) ) $cff_event_date_size = sanitize_text_field( $_POST[ 'cff_event_date_size' ] );
	                if (isset($_POST[ 'cff_event_date_weight' ]) ) $cff_event_date_weight = sanitize_text_field( $_POST[ 'cff_event_date_weight' ] );
	                if (isset($_POST[ 'cff_event_date_color' ]) ) $cff_event_date_color = sanitize_text_field( $_POST[ 'cff_event_date_color' ] );
	                if (isset($_POST[ 'cff_event_date_position' ]) ) $cff_event_date_position = sanitize_text_field( $_POST[ 'cff_event_date_position' ] );
	                if (isset($_POST[ 'cff_event_date_formatting' ]) ) $cff_event_date_formatting = sanitize_text_field( $_POST[ 'cff_event_date_formatting' ] );
	                if (isset($_POST[ 'cff_event_date_custom' ]) ) $cff_event_date_custom = sanitize_text_field( $_POST[ 'cff_event_date_custom' ] );
	                //Event details
	                if (isset($_POST[ 'cff_event_details_size' ]) ) $cff_event_details_size = sanitize_text_field( $_POST[ 'cff_event_details_size' ] );
	                if (isset($_POST[ 'cff_event_details_weight' ]) ) $cff_event_details_weight = sanitize_text_field( $_POST[ 'cff_event_details_weight' ] );
	                if (isset($_POST[ 'cff_event_details_color' ]) ) $cff_event_details_color = sanitize_text_field( $_POST[ 'cff_event_details_color' ] );
	                if (isset($_POST[ 'cff_event_link_color' ]) ) $cff_event_link_color = sanitize_text_field( $_POST[ 'cff_event_link_color' ] );
	                //Date
	                if (isset($_POST[ 'cff_date_position' ]) ) $cff_date_position = sanitize_text_field( $_POST[ 'cff_date_position' ] );
	                if (isset($_POST[ 'cff_date_size' ]) ) $cff_date_size = sanitize_text_field( $_POST[ 'cff_date_size' ] );
	                if (isset($_POST[ 'cff_date_weight' ]) ) $cff_date_weight = sanitize_text_field( $_POST[ 'cff_date_weight' ] );
	                if (isset($_POST[ 'cff_date_color' ]) ) $cff_date_color = sanitize_text_field( $_POST[ 'cff_date_color' ] );
	                if (isset($_POST[ 'cff_date_formatting' ]) ) $cff_date_formatting = sanitize_text_field( $_POST[ 'cff_date_formatting' ] );
	                if (isset($_POST[ 'cff_date_custom' ]) ) $cff_date_custom = sanitize_text_field( $_POST[ 'cff_date_custom' ] );
	                if (isset($_POST[ 'cff_date_before' ]) ) $cff_date_before = sanitize_text_field( $_POST[ 'cff_date_before' ] );
	                if (isset($_POST[ 'cff_date_after' ]) ) $cff_date_after = sanitize_text_field( $_POST[ 'cff_date_after' ] );
	                if (isset($_POST[ 'cff_timezone' ]) ) $cff_timezone = sanitize_text_field( $_POST[ 'cff_timezone' ] );

	                //Date translate
	                if (isset($_POST[ 'cff_translate_second' ]) ) $cff_translate_second = sanitize_text_field( $_POST[ 'cff_translate_second' ] );
	                if (isset($_POST[ 'cff_translate_seconds' ]) ) $cff_translate_seconds = sanitize_text_field( $_POST[ 'cff_translate_seconds' ] );
	                if (isset($_POST[ 'cff_translate_minute' ]) ) $cff_translate_minute = sanitize_text_field( $_POST[ 'cff_translate_minute' ] );
	                if (isset($_POST[ 'cff_translate_minutes' ]) ) $cff_translate_minutes = sanitize_text_field( $_POST[ 'cff_translate_minutes' ] );
	                if (isset($_POST[ 'cff_translate_hour' ]) ) $cff_translate_hour = sanitize_text_field( $_POST[ 'cff_translate_hour' ] );
	                if (isset($_POST[ 'cff_translate_hours' ]) ) $cff_translate_hours = sanitize_text_field( $_POST[ 'cff_translate_hours' ] );
	                if (isset($_POST[ 'cff_translate_day' ]) ) $cff_translate_day = sanitize_text_field( $_POST[ 'cff_translate_day' ] );
	                if (isset($_POST[ 'cff_translate_days' ]) ) $cff_translate_days = sanitize_text_field( $_POST[ 'cff_translate_days' ] );
	                if (isset($_POST[ 'cff_translate_week' ]) ) $cff_translate_week = sanitize_text_field( $_POST[ 'cff_translate_week' ] );
	                if (isset($_POST[ 'cff_translate_weeks' ]) ) $cff_translate_weeks = sanitize_text_field( $_POST[ 'cff_translate_weeks' ] );
	                if (isset($_POST[ 'cff_translate_month' ]) ) $cff_translate_month = sanitize_text_field( $_POST[ 'cff_translate_month' ] );
	                if (isset($_POST[ 'cff_translate_months' ]) ) $cff_translate_months = sanitize_text_field( $_POST[ 'cff_translate_months' ] );
	                if (isset($_POST[ 'cff_translate_year' ]) ) $cff_translate_year = sanitize_text_field( $_POST[ 'cff_translate_year' ] );
	                if (isset($_POST[ 'cff_translate_years' ]) ) $cff_translate_years = sanitize_text_field( $_POST[ 'cff_translate_years' ] );
	                if (isset($_POST[ 'cff_translate_ago' ]) ) $cff_translate_ago = sanitize_text_field( $_POST[ 'cff_translate_ago' ] );

	                //Meta
	                if (isset($_POST[ 'cff_icon_style' ])) $cff_icon_style = sanitize_text_field( $_POST[ 'cff_icon_style' ] );
	                if (isset($_POST[ 'cff_meta_text_color' ])) $cff_meta_text_color = sanitize_text_field( $_POST[ 'cff_meta_text_color' ] );
	                if (isset($_POST[ 'cff_meta_bg_color' ])) $cff_meta_bg_color = sanitize_text_field( $_POST[ 'cff_meta_bg_color' ] );
	                if (isset($_POST[ 'cff_nocomments_text' ])) $cff_nocomments_text = sanitize_text_field( $_POST[ 'cff_nocomments_text' ] );
	                if (isset($_POST[ 'cff_hide_comments' ])) $cff_hide_comments = sanitize_text_field( $_POST[ 'cff_hide_comments' ] );

	                //View on Facebook link
	                if (isset($_POST[ 'cff_link_size' ]) ) $cff_link_size = sanitize_text_field( $_POST[ 'cff_link_size' ] );
	                if (isset($_POST[ 'cff_link_weight' ]) ) $cff_link_weight = sanitize_text_field( $_POST[ 'cff_link_weight' ] );
	                if (isset($_POST[ 'cff_link_color' ]) ) $cff_link_color = sanitize_text_field( $_POST[ 'cff_link_color' ] );
	                if (isset($_POST[ 'cff_facebook_link_text' ]) ) $cff_facebook_link_text = sanitize_text_field( $_POST[ 'cff_facebook_link_text' ] );
	                if (isset($_POST[ 'cff_facebook_share_text' ]) ) $cff_facebook_share_text = sanitize_text_field( $_POST[ 'cff_facebook_share_text' ] );
	                (isset($_POST[ 'cff_show_facebook_link' ]) ) ? $cff_show_facebook_link = sanitize_text_field( $_POST[ 'cff_show_facebook_link' ] ) : $cff_show_facebook_link = '';
	                (isset($_POST[ 'cff_show_facebook_share' ]) ) ? $cff_show_facebook_share = sanitize_text_field( $_POST[ 'cff_show_facebook_share' ] ) : $cff_show_facebook_share = '';
	                if (isset($_POST[ 'cff_view_link_text' ]) ) $cff_view_link_text = sanitize_text_field( $_POST[ 'cff_view_link_text' ] );
	                if (isset($_POST[ 'cff_link_to_timeline' ]) ) $cff_link_to_timeline = sanitize_text_field( $_POST[ 'cff_link_to_timeline' ] );

	                //Character limits
	                update_option( $cff_title_length, $cff_title_length_val );
	                update_option( $cff_body_length, $cff_body_length_val );
	                //Author
	                $options[ 'cff_author_size' ] = $cff_author_size;
	                $options[ 'cff_author_color' ] = $cff_author_color;

	                //Post Style
	                $options[ 'cff_post_style' ] = $cff_post_style;
	                $options[ 'cff_post_bg_color' ] = $cff_post_bg_color;
	                $options[ 'cff_post_rounded' ] = $cff_post_rounded;
	                $options[ 'cff_sep_color' ] = $cff_sep_color;
	                $options[ 'cff_sep_size' ] = $cff_sep_size;
	                $options[ 'cff_box_shadow' ] = $cff_box_shadow;

	                //Typography
	                $options[ 'cff_title_format' ] = $cff_title_format;
	                $options[ 'cff_title_size' ] = $cff_title_size;
	                $options[ 'cff_title_weight' ] = $cff_title_weight;
	                $options[ 'cff_title_color' ] = $cff_title_color;
	                $options[ 'cff_posttext_link_color' ] = $cff_posttext_link_color;
	                $options[ 'cff_title_link' ] = $cff_title_link;
	                $options[ 'cff_post_tags' ] = $cff_post_tags;
	                $options[ 'cff_link_hashtags' ] = $cff_link_hashtags;
	                $options[ 'cff_body_size' ] = $cff_body_size;
	                $options[ 'cff_body_weight' ] = $cff_body_weight;
	                $options[ 'cff_body_color' ] = $cff_body_color;
	                $options[ 'cff_link_title_format' ] = $cff_link_title_format;
	                $options[ 'cff_link_title_size' ] = $cff_link_title_size;
	                $options[ 'cff_link_url_size' ] = $cff_link_url_size;
	                $options[ 'cff_link_desc_size' ] = $cff_link_desc_size;
	                $options[ 'cff_link_desc_color' ] = $cff_link_desc_color;
	                $options[ 'cff_link_title_color' ] = $cff_link_title_color;
	                $options[ 'cff_link_url_color' ] = $cff_link_url_color;
	                $options[ 'cff_link_bg_color' ] = $cff_link_bg_color;
	                $options[ 'cff_link_border_color' ] = $cff_link_border_color;
	                $options[ 'cff_disable_link_box' ] = $cff_disable_link_box;

	                //Event title
	                $options[ 'cff_event_title_format' ] = $cff_event_title_format;
	                $options[ 'cff_event_title_size' ] = $cff_event_title_size;
	                $options[ 'cff_event_title_weight' ] = $cff_event_title_weight;
	                $options[ 'cff_event_title_color' ] = $cff_event_title_color;
	                $options[ 'cff_event_title_link' ] = $cff_event_title_link;
	                //Event date
	                $options[ 'cff_event_date_size' ] = $cff_event_date_size;
	                $options[ 'cff_event_date_weight' ] = $cff_event_date_weight;
	                $options[ 'cff_event_date_color' ] = $cff_event_date_color;
	                $options[ 'cff_event_date_position' ] = $cff_event_date_position;
	                $options[ 'cff_event_date_formatting' ] = $cff_event_date_formatting;
	                $options[ 'cff_event_date_custom' ] = $cff_event_date_custom;
	                //Event details
	                $options[ 'cff_event_details_size' ] = $cff_event_details_size;
	                $options[ 'cff_event_details_weight' ] = $cff_event_details_weight;
	                $options[ 'cff_event_details_color' ] = $cff_event_details_color;
	                $options[ 'cff_event_link_color' ] = $cff_event_link_color;
	                //Date
	                $options[ 'cff_date_position' ] = $cff_date_position;
	                $options[ 'cff_date_size' ] = $cff_date_size;
	                $options[ 'cff_date_weight' ] = $cff_date_weight;
	                $options[ 'cff_date_color' ] = $cff_date_color;
	                $options[ 'cff_date_formatting' ] = $cff_date_formatting;
	                $options[ 'cff_date_custom' ] = $cff_date_custom;
	                $options[ 'cff_date_before' ] = $cff_date_before;
	                $options[ 'cff_date_after' ] = $cff_date_after;
	                $options[ 'cff_timezone' ] = $cff_timezone;

	                //Date translate
	                $options[ 'cff_translate_second' ] = $cff_translate_second;
	                $options[ 'cff_translate_seconds' ] = $cff_translate_seconds;
	                $options[ 'cff_translate_minute' ] = $cff_translate_minute;
	                $options[ 'cff_translate_minutes' ] = $cff_translate_minutes;
	                $options[ 'cff_translate_hour' ] = $cff_translate_hour;
	                $options[ 'cff_translate_hours' ] = $cff_translate_hours;
	                $options[ 'cff_translate_day' ] = $cff_translate_day;
	                $options[ 'cff_translate_days' ] = $cff_translate_days;
	                $options[ 'cff_translate_week' ] = $cff_translate_week;
	                $options[ 'cff_translate_weeks' ] = $cff_translate_weeks;
	                $options[ 'cff_translate_month' ] = $cff_translate_month;
	                $options[ 'cff_translate_months' ] = $cff_translate_months;
	                $options[ 'cff_translate_year' ] = $cff_translate_year;
	                $options[ 'cff_translate_years' ] = $cff_translate_years;
	                $options[ 'cff_translate_ago' ] = $cff_translate_ago;

	                //Meta
	                $options[ 'cff_icon_style' ] = $cff_icon_style;
	                $options[ 'cff_meta_text_color' ] = $cff_meta_text_color;
	                $options[ 'cff_meta_bg_color' ] = $cff_meta_bg_color;
	                $options[ 'cff_nocomments_text' ] = $cff_nocomments_text;
	                $options[ 'cff_hide_comments' ] = $cff_hide_comments;

	                //View on Facebook link
	                $options[ 'cff_link_size' ] = $cff_link_size;
	                $options[ 'cff_link_weight' ] = $cff_link_weight;
	                $options[ 'cff_link_color' ] = $cff_link_color;
	                $options[ 'cff_facebook_link_text' ] = $cff_facebook_link_text;
	                $options[ 'cff_facebook_share_text' ] = $cff_facebook_share_text;
	                $options[ 'cff_show_facebook_link' ] = $cff_show_facebook_link;
	                $options[ 'cff_show_facebook_share' ] = $cff_show_facebook_share;
	                $options[ 'cff_view_link_text' ] = $cff_view_link_text;
	                $options[ 'cff_link_to_timeline' ] = $cff_link_to_timeline;
	            }
	            //Update the Misc options
	            if( isset($_POST[ $style_misc_hidden_field_name ]) && $_POST[ $style_misc_hidden_field_name ] == 'Y' ) {
          		 	if (isset($_POST[ 'gdpr' ])) $gdpr = sanitize_text_field( $_POST[ 'gdpr' ] );
	                //Custom CSS
	                if (isset($_POST[ 'cff_custom_css' ])) $cff_custom_css = $_POST[ 'cff_custom_css' ];
	                if (isset($_POST[ 'cff_custom_js' ])) $cff_custom_js = $_POST[ 'cff_custom_js' ];

	                if (isset($_POST[ 'cff_video_height' ])) $cff_video_height = sanitize_text_field( $_POST[ 'cff_video_height' ] );
	                if (isset($_POST[ 'cff_video_action' ])) $cff_video_action = sanitize_text_field( $_POST[ 'cff_video_action' ] );
	                if (isset($_POST[ 'cff_open_links' ])) $cff_open_links = sanitize_text_field( $_POST[ 'cff_open_links' ] );

	                (isset($_POST[ $cff_ajax ])) ? $cff_ajax_val = sanitize_text_field( $_POST[ 'cff_ajax' ] ) : $cff_ajax_val = '';
	                if (isset($_POST[ 'cff_app_id' ])) $cff_app_id = sanitize_text_field( $_POST[ 'cff_app_id' ] );
	                (isset($_POST[ 'cff_show_credit' ])) ? $cff_show_credit = sanitize_text_field( $_POST[ 'cff_show_credit' ] ) : $cff_show_credit = '';
	                (isset($_POST[ 'cff_font_source' ])) ? $cff_font_source = sanitize_text_field( $_POST[ 'cff_font_source' ] ) : $cff_font_source = '';
	                (isset($_POST[ $cff_preserve_settings ])) ? $cff_preserve_settings_val = sanitize_text_field( $_POST[ 'cff_preserve_settings' ] ) : $cff_preserve_settings_val = '';
	                if (isset($_POST[ 'cff_cron' ])) $cff_cron = sanitize_text_field( $_POST[ 'cff_cron' ] );
	                if (isset($_POST[ 'cff_request_method' ])) $cff_request_method = sanitize_text_field( $_POST[ 'cff_request_method' ] );
	                (isset($_POST[ 'cff_disable_styles' ])) ? $cff_disable_styles = sanitize_text_field( $_POST[ 'cff_disable_styles' ] ) : $cff_disable_styles = '';
	                (isset($_POST[ 'cff_format_issue' ])) ? $cff_format_issue = sanitize_text_field( $_POST[ 'cff_format_issue' ] ) : $cff_format_issue = '';
	                (isset($_POST[ 'cff_restricted_page' ])) ? $cff_restricted_page = sanitize_text_field( $_POST[ 'cff_restricted_page' ] ) : $cff_restricted_page = '';
                    (isset($_POST[ 'cff_enqueue_with_shortcode' ])) ? $cff_enqueue_with_shortcode = $_POST[ 'cff_enqueue_with_shortcode' ] : $cff_enqueue_with_shortcode = '';
	                (isset($_POST[ 'cff_minify' ])) ? $cff_minify = sanitize_text_field( $_POST[ 'cff_minify' ] ) : $cff_minify = '';
		            (isset($_POST[ 'cff_disable_admin_notice' ])) ? $cff_disable_admin_notice = sanitize_text_field( $_POST[ 'cff_disable_admin_notice' ] ) : $cff_disable_admin_notice = '';

	        		$options[ 'gdpr' ] = $gdpr;
	                //Custom CSS
	                $options[ 'cff_custom_css' ] = $cff_custom_css;
	                $options[ 'cff_custom_js' ] = $cff_custom_js;

	                $options[ 'cff_video_height' ] = $cff_video_height;
	                $options[ 'cff_video_action' ] = $cff_video_action;
	                $options[ 'cff_open_links' ] = $cff_open_links;

	                update_option( $cff_ajax, $cff_ajax_val );
	                $options[ 'cff_app_id' ] = $cff_app_id;
	                $options[ 'cff_show_credit' ] = $cff_show_credit;
	                $options[ 'cff_font_source' ] = $cff_font_source;
	                update_option( $cff_preserve_settings, $cff_preserve_settings_val );

	                $options[ 'cff_cron' ] = $cff_cron;
	                $options[ 'cff_request_method' ] = $cff_request_method;
	                $options[ 'cff_disable_styles' ] = $cff_disable_styles;
	                $options[ 'cff_format_issue' ] = $cff_format_issue;
	                $options[ 'cff_restricted_page' ] = $cff_restricted_page;
                    $options[ 'cff_enqueue_with_shortcode' ] = $cff_enqueue_with_shortcode;
	                $options[ 'cff_minify' ] = $cff_minify;
		            $options[ 'disable_admin_notice' ] = $cff_disable_admin_notice;

	                if( $cff_cron == 'no' ) wp_clear_scheduled_hook('cff_cron_job');

	                //Run cron when Misc settings are saved
	                if( $cff_cron == 'yes' ){
	                    //Clear the existing cron event
	                    wp_clear_scheduled_hook('cff_cron_job');
	                    $cff_cache_time = get_option( 'cff_cache_time' );
		                $cff_cache_time_unit = get_option( 'cff_cache_time_unit' );

		                    //Set the event schedule based on what the caching time is set to
		                $cff_cron_schedule = 'hourly';
		                if( $cff_cache_time_unit == 'hours' && $cff_cache_time > 5 ) $cff_cron_schedule = 'twicedaily';
		                if( $cff_cache_time_unit == 'days' ) $cff_cron_schedule = 'daily';
	                    wp_schedule_event(time(), $cff_cron_schedule, 'cff_cron_job');
	                }

		            isset($_POST[ 'cff_enable_email_report' ]) ? $cff_enable_email_report = $_POST[ 'cff_enable_email_report' ] : $cff_enable_email_report = '';
		            $options['enable_email_report'] = $cff_enable_email_report;
		            isset($_POST[ 'cff_email_notification' ]) ? $cff_email_notification = $_POST[ 'cff_email_notification' ] : $cff_email_notification = '';
		            $original = $options['email_notification'];
		            $options['email_notification'] = $cff_email_notification;
		            isset($_POST[ 'cff_email_notification_addresses' ]) ? $cff_email_notification_addresses = $_POST[ 'cff_email_notification_addresses' ] : $cff_email_notification_addresses = get_option( 'admin_email' );
		            $options['email_notification_addresses'] = $cff_email_notification_addresses;

		            if ( $original !== $cff_email_notification && $cff_enable_email_report === 'on' ){
			            //Clear the existing cron event
			            wp_clear_scheduled_hook('cff_feed_issue_email');

			            $input = sanitize_text_field($_POST[ 'cff_email_notification' ] );
			            $timestamp = strtotime( 'next ' . $input );

			            if ( $timestamp - (3600 * 1) < time() ) {
				            $timestamp = $timestamp + (3600 * 24 * 7);
			            }
			            $six_am_local = $timestamp + CFF_Utils::cff_get_utc_offset() + (6*60*60);

			            wp_schedule_event( $six_am_local, 'cffweekly', 'cff_feed_issue_email' );
		            }

	            }
	            //Update the Custom Text / Translate options
	            if( isset($_POST[ $style_custom_text_hidden_field_name ]) && $_POST[ $style_custom_text_hidden_field_name ] == 'Y' ) {

	                //Translate
	                if (isset($_POST[ 'cff_see_more_text' ])) $cff_see_more_text = sanitize_text_field( $_POST[ 'cff_see_more_text' ] );
	                if (isset($_POST[ 'cff_see_less_text' ])) $cff_see_less_text = sanitize_text_field( $_POST[ 'cff_see_less_text' ] );
	                if (isset($_POST[ 'cff_facebook_link_text' ])) $cff_facebook_link_text = sanitize_text_field( $_POST[ 'cff_facebook_link_text' ] );
	                if (isset($_POST[ 'cff_facebook_share_text' ])) $cff_facebook_share_text = sanitize_text_field( $_POST[ 'cff_facebook_share_text' ] );

	                //Social translate
	                if (isset($_POST[ 'cff_translate_photos_text' ])) $cff_translate_photos_text = sanitize_text_field( $_POST[ 'cff_translate_photos_text' ] );
	                if (isset($_POST[ 'cff_translate_photo_text' ])) $cff_translate_photo_text = sanitize_text_field( $_POST[ 'cff_translate_photo_text' ] );
	                if (isset($_POST[ 'cff_translate_video_text' ])) $cff_translate_video_text = sanitize_text_field( $_POST[ 'cff_translate_video_text' ] );

	                if (isset($_POST[ 'cff_translate_learn_more_text' ])) $cff_translate_learn_more_text = sanitize_text_field( $_POST[ 'cff_translate_learn_more_text' ] );
	                if (isset($_POST[ 'cff_translate_shop_now_text' ])) $cff_translate_shop_now_text = sanitize_text_field( $_POST[ 'cff_translate_shop_now_text' ] );
	                if (isset($_POST[ 'cff_translate_message_page_text' ])) $cff_translate_message_page_text = sanitize_text_field( $_POST[ 'cff_translate_message_page_text' ] );

	                //Date translate
	                if (isset($_POST[ 'cff_translate_second' ])) $cff_translate_second = sanitize_text_field( $_POST[ 'cff_translate_second' ] );
	                if (isset($_POST[ 'cff_translate_seconds' ])) $cff_translate_seconds = sanitize_text_field( $_POST[ 'cff_translate_seconds' ] );
	                if (isset($_POST[ 'cff_translate_minute' ])) $cff_translate_minute = sanitize_text_field( $_POST[ 'cff_translate_minute' ] );
	                if (isset($_POST[ 'cff_translate_minutes' ])) $cff_translate_minutes = sanitize_text_field( $_POST[ 'cff_translate_minutes' ] );
	                if (isset($_POST[ 'cff_translate_hour' ])) $cff_translate_hour = sanitize_text_field( $_POST[ 'cff_translate_hour' ] );
	                if (isset($_POST[ 'cff_translate_hours' ])) $cff_translate_hours = sanitize_text_field( $_POST[ 'cff_translate_hours' ] );
	                if (isset($_POST[ 'cff_translate_day' ])) $cff_translate_day = sanitize_text_field( $_POST[ 'cff_translate_day' ] );
	                if (isset($_POST[ 'cff_translate_days' ])) $cff_translate_days = sanitize_text_field( $_POST[ 'cff_translate_days' ] );
	                if (isset($_POST[ 'cff_translate_week' ])) $cff_translate_week = sanitize_text_field( $_POST[ 'cff_translate_week' ] );
	                if (isset($_POST[ 'cff_translate_weeks' ])) $cff_translate_weeks = sanitize_text_field( $_POST[ 'cff_translate_weeks' ] );
	                if (isset($_POST[ 'cff_translate_month' ])) $cff_translate_month = sanitize_text_field( $_POST[ 'cff_translate_month' ] );
	                if (isset($_POST[ 'cff_translate_months' ])) $cff_translate_months = sanitize_text_field( $_POST[ 'cff_translate_months' ] );
	                if (isset($_POST[ 'cff_translate_year' ])) $cff_translate_year = sanitize_text_field( $_POST[ 'cff_translate_year' ] );
	                if (isset($_POST[ 'cff_translate_years' ])) $cff_translate_years = sanitize_text_field( $_POST[ 'cff_translate_years' ] );
	                if (isset($_POST[ 'cff_translate_ago' ])) $cff_translate_ago = sanitize_text_field( $_POST[ 'cff_translate_ago' ] );

	                //Translate
	                $options[ 'cff_see_more_text' ] = $cff_see_more_text;
	                $options[ 'cff_see_less_text' ] = $cff_see_less_text;
	                $options[ 'cff_facebook_link_text' ] = $cff_facebook_link_text;
	                $options[ 'cff_facebook_share_text' ] = $cff_facebook_share_text;

	                //Social translate
	                $options[ 'cff_translate_photos_text' ] = $cff_translate_photos_text;
	                $options[ 'cff_translate_photo_text' ] = $cff_translate_photo_text;
	                $options[ 'cff_translate_video_text' ] = $cff_translate_video_text;

	                $options[ 'cff_translate_learn_more_text' ] = $cff_translate_learn_more_text;
	                $options[ 'cff_translate_shop_now_text' ] = $cff_translate_shop_now_text;
	                $options[ 'cff_translate_message_page_text' ] = $cff_translate_message_page_text;

	                //Date translate
	                $options[ 'cff_translate_second' ] = $cff_translate_second;
	                $options[ 'cff_translate_seconds' ] = $cff_translate_seconds;
	                $options[ 'cff_translate_minute' ] = $cff_translate_minute;
	                $options[ 'cff_translate_minutes' ] = $cff_translate_minutes;
	                $options[ 'cff_translate_hour' ] = $cff_translate_hour;
	                $options[ 'cff_translate_hours' ] = $cff_translate_hours;
	                $options[ 'cff_translate_day' ] = $cff_translate_day;
	                $options[ 'cff_translate_days' ] = $cff_translate_days;
	                $options[ 'cff_translate_week' ] = $cff_translate_week;
	                $options[ 'cff_translate_weeks' ] = $cff_translate_weeks;
	                $options[ 'cff_translate_month' ] = $cff_translate_month;
	                $options[ 'cff_translate_months' ] = $cff_translate_months;
	                $options[ 'cff_translate_year' ] = $cff_translate_year;
	                $options[ 'cff_translate_years' ] = $cff_translate_years;
	                $options[ 'cff_translate_ago' ] = $cff_translate_ago;

	            }
	            //Update the array
	            update_option( 'cff_style_settings', $options );
	            // Put an settings updated message on the screen
	        ?>
	        <div class="updated"><p><strong><?php _e('Settings saved.', 'custom-facebook-feed' ); ?></strong></p></div>
	        <?php } ?>

	    <?php } //End nonce check ?>

	    <?php
	    $lite_notice_dismissed = get_transient( 'facebook_feed_dismiss_lite' );

	    if ( ! $lite_notice_dismissed ) :
	        ?>
	        <div id="cff-notice-bar" style="display:none">
	            <span class="cff-notice-bar-message"><?php _e( 'You\'re using Custom Facebook Feed Lite. To unlock more features consider <a href="https://smashballoondemo.com/?utm_campaign=facebook-free&utm_source=notices&utm_medium=lite" target="_blank" rel="noopener noreferrer">upgrading to Pro</a>.', 'custom-facebook-feed'); ?></span>
	            <button type="button" class="dismiss" title="<?php _e( 'Dismiss this message.', 'custom-facebook-feed'); ?>" data-page="overview">
	            </button>
	        </div>
	    <?php endif; ?>

	    <div id="cff-admin" class="wrap">
	        <div id="header">
	            <h1><?php _e('Custom Facebook Feed', 'custom-facebook-feed'); ?></h1>
	        </div>

	        <form name="form1" method="post" action="">
	            <input type="hidden" name="<?php echo $style_hidden_field_name; ?>" value="Y">
	            <?php wp_nonce_field( 'cff_saving_customize', 'cff_customize_nonce' ); ?>

	            <?php
	            $cff_active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : 'general';
	            ?>

	            <h2 class="nav-tab-wrapper">
	                <a href="?page=cff-top&amp;tab=configuration" class="nav-tab <?php echo $cff_active_tab == 'configuration' ? 'nav-tab-active' : ''; ?>"><?php _e('Configuration'); ?></a>
	                <a href="?page=cff-style" class="nav-tab nav-tab-active"><?php _e('Customize'); ?></a>
	                <a href="?page=cff-top&amp;tab=support" class="nav-tab <?php echo $cff_active_tab == 'support' ? 'nav-tab-active' : ''; ?>"><?php _e('Support'); ?></a>
	                <a href="?page=cff-top&amp;tab=more" class="nav-tab <?php echo $cff_active_tab == 'more' ? 'nav-tab-active' : ''; ?>"><?php _e('More Social Feeds', 'custom-facebook-feed'); ?>
	                    <?php
	                    $seen_more_plugins_page = get_user_meta(get_current_user_id(), 'seen_more_plugins_page_1', true);
	                    if( !$seen_more_plugins_page ) echo '<span class="cff-alert-bubble">1</span>';
	                    ?>
	                </a>
	            </h2>

	            <h2 class="nav-tab-wrapper cff-subtabs">
	                <a href="?page=cff-style&amp;tab=general" class="nav-tab <?php echo $cff_active_tab == 'general' ? 'nav-tab-active' : ''; ?>"><?php _e('General'); ?></a>
	                <a href="?page=cff-style&amp;tab=post_layout" class="nav-tab <?php echo $cff_active_tab == 'post_layout' ? 'nav-tab-active' : ''; ?>"><?php _e('Post Layout'); ?></a>
	                <a href="?page=cff-style&amp;tab=typography" class="nav-tab <?php echo $cff_active_tab == 'typography' ? 'nav-tab-active' : ''; ?>"><?php _e('Style Posts'); ?></a>
	                <a href="?page=cff-style&amp;tab=misc" class="nav-tab <?php echo $cff_active_tab == 'misc' ? 'nav-tab-active' : ''; ?>"><?php _e('Misc'); ?></a>
	                <a href="?page=cff-style&amp;tab=custom_text" class="nav-tab <?php echo $cff_active_tab == 'custom_text' ? 'nav-tab-active' : ''; ?>"><?php _e('Custom Text / Translate'); ?></a>
	            </h2>
	            <?php if( $cff_active_tab == 'general' ) { //Start General tab ?>

	            <p class="cff_contents_links" id="general">
	                <span>Jump to: </span>
	                <a href="#general"><?php _e('General', 'custom-facebook-feed'); ?></a>
	                <a href="#header"><?php _e('Header', 'custom-facebook-feed'); ?></a>
	                <a href="#likebox"><?php _e('Like Box', 'custom-facebook-feed'); ?></a>
	            </p>

	            <input type="hidden" name="<?php echo $style_general_hidden_field_name; ?>" value="Y">
	            <br />
	            <table class="form-table">
	                <tbody>
	                    <h3><?php _e('General', 'custom-facebook-feed'); ?></h3>
	                    <tr valign="top">
	                        <th class="bump-left" scope="row"><label><?php _e('Feed Width', 'custom-facebook-feed'); ?></label><code class="cff_shortcode"> width
	                        Eg: width=500px</code></th>
	                        <td>
	                            <input name="cff_feed_width" id="cff_feed_width" type="text" value="<?php esc_attr_e( $cff_feed_width, 'custom-facebook-feed' ); ?>" size="6" />
	                            <i style="color: #666; font-size: 11px;">Eg. 100% or 500px</i>
	                            <div id="cff_width_options">
	                                <input name="cff_feed_width_resp" type="checkbox" id="cff_feed_width_resp" <?php if($cff_feed_width_resp == true) echo "checked"; ?> /><label for="cff_feed_width_resp"><?php _e('Set to be 100% width on mobile?', 'custom-facebook-feed'); ?></label>
	                                <a class="cff-tooltip-link" href="JavaScript:void(0);"><?php _e('What does this mean?', 'custom-facebook-feed'); ?></a>
	                                <p class="cff-tooltip cff-more-info"><?php _e("If you set a width on the feed then this will be used on mobile as well as desktop. Check this setting to set the feed width to be 100% on mobile so that it is responsive.", 'custom-facebook-feed'); ?></p>
	                            </div>
	                        </td>
	                    </tr>
	                    <tr valign="top">
	                        <th class="bump-left" scope="row"><label><?php _e('Feed Height', 'custom-facebook-feed'); ?></label><code class="cff_shortcode"> height
	                        Eg: height=500px</code></th>
	                        <td>
	                            <input name="cff_feed_height" type="text" value="<?php esc_attr_e( $cff_feed_height, 'custom-facebook-feed' ); ?>" size="6" />
	                            <i style="color: #666; font-size: 11px;">Eg. 500px</i>
	                            <a class="cff-tooltip-link" href="JavaScript:void(0);"><i class="fa fa-question-circle" aria-hidden="true"></i></a>
	                                <p class="cff-tooltip cff-more-info"><?php _e("Use this to set a fixed height on the feed. If the feed exceeds this height then a scroll bar will be used. Leave it empty to set no maximum height."); ?></p>
	                        </td>
	                    </tr>
	                        <th class="bump-left" scope="row"><label><?php _e('Feed Padding', 'custom-facebook-feed'); ?></label><code class="cff_shortcode"> padding
	                        Eg: padding=20px</code></th>
	                        <td>
	                            <input name="cff_feed_padding" type="text" value="<?php esc_attr_e( $cff_feed_padding, 'custom-facebook-feed' ); ?>" size="6" />
	                            <i style="color: #666; font-size: 11px;">Eg. 20px or 2%</i>
	                            <a class="cff-tooltip-link" href="JavaScript:void(0);"><i class="fa fa-question-circle" aria-hidden="true"></i></a>
	                            <p class="cff-tooltip cff-more-info"><?php _e("This is the amount of padding/spacing that goes around the feed. This is particularly useful if you intend to set a background color on the feed."); ?></p>
	                        </td>
	                    </tr>
	                    <tr valign="top">
	                        <th class="bump-left" scope="row"><label><?php _e('Feed Background Color', 'custom-facebook-feed'); ?></label><code class="cff_shortcode"> bgcolor
	                        Eg: bgcolor=FF0000</code></th>
	                        <td>
	                            <input name="cff_bg_color" value="#<?php esc_attr_e( str_replace('#', '', $cff_bg_color), 'custom-facebook-feed' ); ?>" class="cff-colorpicker" />
	                        </td>
	                    </tr>
	                    <tr valign="top">
	                        <th class="bump-left" scope="row"><label><?php _e('Add CSS class to feed', 'custom-facebook-feed'); ?></label><code class="cff_shortcode"> class
	                        Eg: class=myfeed</code></th>
	                        <td>
	                            <input name="cff_class" type="text" value="<?php esc_attr_e( $cff_class, 'custom-facebook-feed' ); ?>" size="25" />
	                            <a class="cff-tooltip-link" href="JavaScript:void(0);"><i class="fa fa-question-circle" aria-hidden="true"></i></a>
	                            <p class="cff-tooltip cff-more-info"><?php _e("You can add your own CSS classes to the feed here. To add multiple classes separate each with a space, Eg. classone classtwo classthree"); ?></p>
	                        </td>
	                    </tr>

	                    <tr valign="top">
	                        <th class="bump-left" scope="row"><label for="cff_cols">Feed Columns</label><code class="cff_shortcode"> cols
	                                Eg: cols=3</code></th>
	                        <td class="cff-short">
	                            <select name="cff_cols" id="cff_cols">
	                                <option value="1" <?php if( $cff_cols == 1 ) { echo 'selected'; } ?>>1</option>
	                                <option value="2" <?php if( $cff_cols == 2 ) { echo 'selected'; } ?>>2</option>
	                                <option value="3" <?php if( $cff_cols == 3 ) { echo 'selected'; } ?>>3</option>
	                                <option value="4" <?php if( $cff_cols == 4 ) { echo 'selected'; } ?>>4</option>
	                                <option value="5" <?php if( $cff_cols == 5 ) { echo 'selected'; } ?>>5</option>
	                                <option value="6" <?php if( $cff_cols == 6 ) { echo 'selected'; } ?>>6</option>
	                            </select>

	                            <br />
	                            <div class="cff-mobile-col-settings" <?php if( intval($cff_cols) > 1 ) echo 'style="display:block;"' ?>>
	                                <div class="cff-row">
	                                    <label title="Click for shortcode option">Mobile Columns:</label><code class="cff_shortcode"> colsmobile
	                                    Eg: colsmobile=2</code>
	                                    <select name="cff_cols_mobile" id="cff_cols_mobile">
	                                        <option value="1" <?php if( $cff_cols_mobile == 1 ) { echo 'selected'; } ?>>1</option>
	                                        <option value="2" <?php if( $cff_cols_mobile == 2 ) { echo 'selected'; } ?>>2</option>
	                                    </select>
	                                </div>
	                            </div>

	                        </td>
	                    </tr>

	                </tbody>
	            </table>

	            <?php submit_button(); ?>

	            <hr id="types" />
	            <table class="form-table">
	                <tbody>
	                    <h3><?php _e('Post Types', 'custom-facebook-feed'); ?></h3>
	                    <tr valign="top">
	                        <th scope="row"><?php _e('Only show these types of posts:', 'custom-facebook-feed'); ?><br />
	                            <i style="color: #666; font-size: 11px;"><a href="https://smashballoon.com/custom-facebook-feed/?utm_campaign=facebook-free&utm_source=settings&utm_medium=types" target="_blank"><?php _e('Upgrade to Pro to enable post types, photos, videos and more', 'custom-facebook-feed'); ?></a></i></th>
	                        <td>
	                            <div>
	                                <input name="cff_show_status_type" type="checkbox" id="cff_show_status_type" disabled checked />
	                                <label for="cff_show_status_type"><?php _e('Statuses', 'custom-facebook-feed'); ?></label>
	                            </div>
	                            <div>
	                                <input type="checkbox" name="cff_show_event_type" id="cff_show_event_type" disabled checked />
	                                <label for="cff_show_event_type"><?php _e('Events', 'custom-facebook-feed'); ?></label>
	                            </div>
	                            <div>
	                                <input type="checkbox" name="cff_show_photos_type" id="cff_show_photos_type" disabled checked />
	                                <label for="cff_show_photos_type"><?php _e('Photos', 'custom-facebook-feed'); ?></label>
	                            </div>
	                            <div>
	                                <input type="checkbox" name="cff_show_video_type" id="cff_show_video_type" disabled checked />
	                                <label for="cff_show_video_type"><?php _e('Videos', 'custom-facebook-feed'); ?></label>
	                            </div>
	                            <div>
	                                <input type="checkbox" name="cff_show_links_type" id="cff_show_links_type" disabled checked />
	                                <label for="cff_show_links_type"><?php _e('Links', 'custom-facebook-feed'); ?></label>
	                            </div>
	                            <div>
	                                <input type="checkbox" name="cff_show_links_type" id="cff_show_links_type" disabled checked />
	                                <label for="cff_show_links_type"><?php _e('Albums', 'custom-facebook-feed'); ?></label>
	                            </div>
	                        </td>
	                    </tr>
	                </tbody>
	            </table>

	            <hr />

	            <table class="form-table">
	                <tbody>
	                    <h3><?php _e('Header', 'custom-facebook-feed'); ?></h3>
	                    <tr valign="top">
	                        <th class="bump-left" scope="row"><label><?php _e('Show Feed Header', 'custom-facebook-feed'); ?></label><code class="cff_shortcode"> showheader
	                        Eg: showheader=true</code></th>
	                        <td>
	                            <input type="checkbox" name="cff_show_header" id="cff_show_header" <?php if($cff_show_header == true) echo 'checked="checked"' ?> />
	                            <a class="cff-tooltip-link" href="JavaScript:void(0);"><?php _e('What is the header?', 'custom-facebook-feed'); ?></a>
	                            <p class="cff-tooltip cff-more-info"><?php _e("The header allows you to display text and an icon at the top of your feed. Customize the text, style, and layout of the header using the settings below.", "custom-facebook-feed"); ?></p>
	                        </td>
	                    </tr>

	                    <tbody>

	                    <tr valign="top" class="cff-header-type">
	                        <th class="bump-left" scope="row"><label><?php _e('Header Type'); ?></label><code class="cff_shortcode"> headertype
	                        Eg: headertype=visual</code></th>
	                        <td>
	                            <select name="cff_header_type" id="cff_header_type" style="width: 100px;">
	                                <option value="text" <?php if($cff_header_type == "text") echo 'selected="selected"' ?> ><?php _e('Text'); ?></option>
	                                <option value="visual" <?php if($cff_header_type == "visual") echo 'selected="selected"' ?> ><?php _e('Visual'); ?></option>
	                            </select>

	                            <div class="cff-header-options">
	                                <table>
	                                    <tbody class="cff-facebook-header">
	                                        <tr valign="top">
	                                            <th class="bump-left" scope="row"><label><?php _e('Facebook Header Elements', 'custom-facebook-feed'); ?></label><code class="cff_shortcode"> include  exclude
	                                            Eg: headerinc=cover,name
	                                            Eg: headerexclude=about

	                                            Options: cover,name,about</code></th>
	                                            <td>
	                                                <div>
	                                                    <input name="cff_header_cover" type="checkbox" id="cff_header_cover" <?php if($cff_header_cover == true) echo "checked"; ?> />
	                                                    <label for="cff_header_cover">
	                                                        <?php _e('Cover Photo', 'custom-facebook-feed'); ?>
	                                                    </label>
	                                                </div>
	                                                <div>
	                                                    <input name="cff_header_name" type="checkbox" id="cff_header_name" <?php if($cff_header_name == true) echo "checked"; ?> />
	                                                    <label for="cff_header_name">
	                                                        <?php _e('Name and Avatar', 'custom-facebook-feed'); ?>
	                                                    </label>
	                                                </div>
	                                                <div>
	                                                    <input name="cff_header_bio" type="checkbox" id="cff_header_bio" <?php if($cff_header_bio == true) echo "checked"; ?> />
	                                                    <label for="cff_header_bio">
	                                                        <?php _e('About Info (bio and likes)', 'custom-facebook-feed'); ?>
	                                                    </label>
	                                                </div>
	                                            </td>
	                                        </tr>
	                                        <tr valign="top">
	                                            <th class="bump-left" scope="row"><label><?php _e('Cover Photo Height', 'custom-facebook-feed'); ?></label></th>
	                                            <td>
	                                                <input style="width:70px" name="cff_header_cover_height" type="text" id="cff_header_cover_height" value="<?php echo $cff_header_cover_height; ?>"/> px
	                                            </td>
	                                        </tr>
	                                    </tbody>
	                                    <tbody class="cff-text-header">
	                                        <tr>
	                                        <th class="bump-left cff-text-header" scope="row"><label><?php _e('Header Text'); ?></label><code class="cff_shortcode"> headertext
	                                Eg: headertext='Facebook Feed'</code></th>
	                                            <td>
	                                                <input name="cff_header_text" type="text" value="<?php echo stripslashes( esc_attr( $cff_header_text ) ); ?>" size="30" />
	                                            </td>
	                                        </tr>
	                                        <tr valign="top">
	                                            <th class="bump-left" scope="row"><label><?php _e('Background Color'); ?></label><code class="cff_shortcode"> headerbg
	                                Eg: headerbg=DDD</code></th>
	                                            <td>
	                                                <input name="cff_header_bg_color" value="#<?php esc_attr_e( str_replace('#', '', $cff_header_bg_color) ); ?>" class="cff-colorpicker" />
	                                            </td>
	                                        </tr>
	                                        </tr>
	                                            <th class="bump-left" scope="row"><label><?php _e('Padding/Spacing'); ?></label><code class="cff_shortcode"> headerpadding
	                                Eg: headerpadding=20px</code></th>
	                                            <td>
	                                                <input name="cff_header_padding" type="text" value="<?php esc_attr_e( $cff_header_padding ); ?>" size="6" />
	                                                <i style="color: #666; font-size: 11px;">Eg. 20px</i>
	                                            </td>
	                                        </tr>
	                                        <tr>
	                                            <th class="bump-left" scope="row"><label><?php _e('Icon Type'); ?></label><code class="cff_shortcode"> headericon
	                                Eg: headericon=facebook</code></th>
	                                            <td>
	                                                <select name="cff_header_icon" id="cff-header-icon">
	                                                    <option value="facebook-square" <?php if($cff_header_icon == "facebook-square") echo 'selected="selected"' ?> >Facebook 1</option>
	                                                    <option value="facebook" <?php if($cff_header_icon == "facebook") echo 'selected="selected"' ?> >Facebook 2</option>
	                                                    <option value="calendar" <?php if($cff_header_icon == "calendar") echo 'selected="selected"' ?> >Events 1</option>
	                                                    <option value="calendar-o" <?php if($cff_header_icon == "calendar-o") echo 'selected="selected"' ?> >Events 2</option>
	                                                    <option value="picture-o" <?php if($cff_header_icon == "picture-o") echo 'selected="selected"' ?> >Photos</option>
	                                                    <option value="users" <?php if($cff_header_icon == "users") echo 'selected="selected"' ?> >People</option>
	                                                    <option value="thumbs-o-up" <?php if($cff_header_icon == "thumbs-o-up") echo 'selected="selected"' ?> >Thumbs Up 1</option>
	                                                    <option value="thumbs-up" <?php if($cff_header_icon == "thumbs-up") echo 'selected="selected"' ?> >Thumbs Up 2</option>
	                                                    <option value="comment-o" <?php if($cff_header_icon == "comment-o") echo 'selected="selected"' ?> >Speech Bubble 1</option>
	                                                    <option value="comment" <?php if($cff_header_icon == "comment") echo 'selected="selected"' ?> >Speech Bubble 2</option>
	                                                    <option value="ticket" <?php if($cff_header_icon == "ticket") echo 'selected="selected"' ?> >Ticket</option>
	                                                    <option value="list-alt" <?php if($cff_header_icon == "list-alt") echo 'selected="selected"' ?> >News List</option>
	                                                    <option value="file" <?php if($cff_header_icon == "file") echo 'selected="selected"' ?> >File 1</option>
	                                                    <option value="file-o" <?php if($cff_header_icon == "file-o") echo 'selected="selected"' ?> >File 2</option>
	                                                    <option value="file-text" <?php if($cff_header_icon == "file-text") echo 'selected="selected"' ?> >File 3</option>
	                                                    <option value="file-text-o" <?php if($cff_header_icon == "file-text-o") echo 'selected="selected"' ?> >File 4</option>
	                                                    <option value="youtube-play" <?php if($cff_header_icon == "youtube-play") echo 'selected="selected"' ?> >Video</option>
	                                                    <option value="youtube" <?php if($cff_header_icon == "youtube") echo 'selected="selected"' ?> >YouTube</option>
	                                                    <option value="vimeo-square" <?php if($cff_header_icon == "vimeo-square") echo 'selected="selected"' ?> >Vimeo</option>
	                                                </select>

	                                                <i id="cff-header-icon-example" class="fa fa-facebook-square"></i>
	                                            </td>
	                                        </tr>
	                                        <tr>
	                                            <th class="bump-left" scope="row"><label><?php _e('Icon Color'); ?></label><code class="cff_shortcode"> headericoncolor
	                                Eg: headericoncolor=FFF</code></th>
	                                            <td>
	                                                <input name="cff_header_icon_color" value="#<?php esc_attr_e( str_replace('#', '', $cff_header_icon_color) ); ?>" class="cff-colorpicker" />
	                                            </td>
	                                        </tr>
	                                        <tr>
	                                            <th class="bump-left" scope="row"><label><?php _e('Icon Size'); ?></label><code class="cff_shortcode"> headericonsize
	                                Eg: headericonsize=28</code></th>
	                                            <td>
	                                                <select name="cff_header_icon_size" id="cff-header-icon-size" style="width: 80px;">
	                                                    <option value="10" <?php if($cff_header_icon_size == "10") echo 'selected="selected"' ?> >10px</option>
	                                                    <option value="11" <?php if($cff_header_icon_size == "11") echo 'selected="selected"' ?> >11px</option>
	                                                    <option value="12" <?php if($cff_header_icon_size == "12") echo 'selected="selected"' ?> >12px</option>
	                                                    <option value="13" <?php if($cff_header_icon_size == "13") echo 'selected="selected"' ?> >13px</option>
	                                                    <option value="14" <?php if($cff_header_icon_size == "14") echo 'selected="selected"' ?> >14px</option>
	                                                    <option value="16" <?php if($cff_header_icon_size == "16") echo 'selected="selected"' ?> >16px</option>
	                                                    <option value="18" <?php if($cff_header_icon_size == "18") echo 'selected="selected"' ?> >18px</option>
	                                                    <option value="20" <?php if($cff_header_icon_size == "20") echo 'selected="selected"' ?> >20px</option>
	                                                    <option value="24" <?php if($cff_header_icon_size == "24") echo 'selected="selected"' ?> >24px</option>
	                                                    <option value="28" <?php if($cff_header_icon_size == "28") echo 'selected="selected"' ?> >28px</option>
	                                                    <option value="32" <?php if($cff_header_icon_size == "32") echo 'selected="selected"' ?> >32px</option>
	                                                    <option value="36" <?php if($cff_header_icon_size == "36") echo 'selected="selected"' ?> >36px</option>
	                                                    <option value="42" <?php if($cff_header_icon_size == "42") echo 'selected="selected"' ?> >42px</option>
	                                                    <option value="48" <?php if($cff_header_icon_size == "48") echo 'selected="selected"' ?> >48px</option>
	                                                    <option value="54" <?php if($cff_header_icon_size == "54") echo 'selected="selected"' ?> >54px</option>
	                                                    <option value="60" <?php if($cff_header_icon_size == "60") echo 'selected="selected"' ?> >60px</option>
	                                                </select>
	                                            </td>
	                                        </tr>
	                                    </tbody>
	                                </table>
	                            </div>
	                        </td>
	                    </tr>
	                </tbody>

	                <tbody class="cff-header-text-styles">
	                    <tr valign="top">
	                        <th class="bump-left" scope="row"><label><?php _e('Display outside scrollable area'); ?></label><code class="cff_shortcode"> headeroutside
	            Eg: headeroutside=true</code></th>
	                        <td>
	                            <input type="checkbox" name="cff_header_outside" id="cff_header_outside" <?php if($cff_header_outside == true) echo 'checked="checked"' ?> />
	                            <a class="cff-tooltip-link" href="JavaScript:void(0);"><i class="fa fa-question-circle" aria-hidden="true"></i></a>
	                            <p class="cff-tooltip cff-more-info"><?php _e("This positions the Header outside of the feed container. It is useful if your feed has a vertical scrollbar as it places it outside of the scrollable area and fixes it at the top."); ?></p>
	                        </td>
	                    </tr>
	                    <tr>
	                        <th class="bump-left" scope="row"><label><?php _e('Text Size'); ?></label><code class="cff_shortcode"> headertextsize
	            Eg: headertextsize=28</code></th>
	                        <td>
	                            <select name="cff_header_text_size" class="cff-text-size-setting">
	                                <option value="inherit" <?php if($cff_header_text_size == "inherit") echo 'selected="selected"' ?> >Inherit from theme</option>
	                                <option value="10" <?php if($cff_header_text_size == "10") echo 'selected="selected"' ?> >10px</option>
	                                <option value="11" <?php if($cff_header_text_size == "11") echo 'selected="selected"' ?> >11px</option>
	                                <option value="12" <?php if($cff_header_text_size == "12") echo 'selected="selected"' ?> >12px</option>
	                                <option value="13" <?php if($cff_header_text_size == "13") echo 'selected="selected"' ?> >13px</option>
	                                <option value="14" <?php if($cff_header_text_size == "14") echo 'selected="selected"' ?> >14px</option>
	                                <option value="16" <?php if($cff_header_text_size == "16") echo 'selected="selected"' ?> >16px</option>
	                                <option value="18" <?php if($cff_header_text_size == "18") echo 'selected="selected"' ?> >18px</option>
	                                <option value="20" <?php if($cff_header_text_size == "20") echo 'selected="selected"' ?> >20px</option>
	                                <option value="24" <?php if($cff_header_text_size == "24") echo 'selected="selected"' ?> >24px</option>
	                                <option value="28" <?php if($cff_header_text_size == "28") echo 'selected="selected"' ?> >28px</option>
	                                <option value="32" <?php if($cff_header_text_size == "32") echo 'selected="selected"' ?> >32px</option>
	                                <option value="36" <?php if($cff_header_text_size == "36") echo 'selected="selected"' ?> >36px</option>
	                                <option value="42" <?php if($cff_header_text_size == "42") echo 'selected="selected"' ?> >42px</option>
	                                <option value="48" <?php if($cff_header_text_size == "48") echo 'selected="selected"' ?> >48px</option>
	                                <option value="54" <?php if($cff_header_text_size == "54") echo 'selected="selected"' ?> >54px</option>
	                                <option value="60" <?php if($cff_header_text_size == "60") echo 'selected="selected"' ?> >60px</option>
	                            </select>
	                        </td>
	                    </tr>
	                    <tr>
	                        <th class="bump-left" scope="row"><label><?php _e('Text Weight'); ?></label><code class="cff_shortcode"> headertextweight
	            Eg: headertextweight=bold</code></th>
	                        <td>
	                            <select name="cff_header_text_weight" class="cff-text-size-setting">
	                                <option value="inherit" <?php if($cff_header_text_weight == "inherit") echo 'selected="selected"' ?> >Inherit from theme</option>
	                                <option value="normal" <?php if($cff_header_text_weight == "normal") echo 'selected="selected"' ?> >Normal</option>
	                                <option value="bold" <?php if($cff_header_text_weight == "bold") echo 'selected="selected"' ?> >Bold</option>
	                            </select>
	                        </td>
	                    </tr>
	                    <tr>
	                        <th class="bump-left" scope="row"><label><?php _e('Text Color'); ?></label><code class="cff_shortcode"> headertextcolor
	            Eg: headertextcolor=333</code></th>
	                        <td>
	                            <input name="cff_header_text_color" value="#<?php esc_attr_e( str_replace('#', '', $cff_header_text_color) ); ?>" class="cff-colorpicker" />
	                        </td>
	                    </tr>
	                    <tr id="author"><!-- Quick link --></tr>
	                </tbody>
	            </table>

	            <?php submit_button(); ?>

	            <hr id="likebox" /><!-- Quick link -->

	            <h3><?php _e('Like Box / Page Plugin', 'custom-facebook-feed'); ?></h3>
	            <table class="form-table">
	                <tbody>
	                    <tr valign="top">
	                        <th class="bump-left" scope="row"><label><?php _e('Show the Like Box', 'custom-facebook-feed'); ?></label><code class="cff_shortcode"> include  exclude
	                        Eg: include/exclude=likebox</code></th>
	                        <td>
	                            <input type="checkbox" name="cff_show_like_box" id="cff_show_like_box" <?php if($cff_show_like_box == true) echo 'checked="checked"' ?> />&nbsp;<?php _e('Yes', 'custom-facebook-feed'); ?>
	                            <a class="cff-tooltip-link" href="JavaScript:void(0);"><?php _e('What is the Like Box?'); ?></a>
	                            <p class="cff-tooltip cff-more-info"><?php _e("The Like Box is an official Facebook widget that we include at the bottom or top of the feed. It contains information about your Facebook Page and allows users to 'like' it directly on your site."); ?></p>
	                        </td>
	                    </tr>
	                    <tr valign="top">
	                        <th class="bump-left" scope="row"><label><?php _e('Position', 'custom-facebook-feed'); ?></label><code class="cff_shortcode"> likeboxpos
	                        Eg: likeboxpos=top</code></th>
	                        <td>
	                            <select name="cff_like_box_position">
	                                <option value="bottom" <?php if($cff_like_box_position == "bottom") echo 'selected="selected"' ?> ><?php _e('Bottom of feed', 'custom-facebook-feed'); ?></option>
	                                <option value="top" <?php if($cff_like_box_position == "top") echo 'selected="selected"' ?> ><?php _e('Top of feed', 'custom-facebook-feed'); ?></option>
	                            </select>
	                        </td>
	                    </tr>
	                    <tr valign="top">
	                        <th class="bump-left" scope="row"><label><?php _e('Display outside the scrollable area', 'custom-facebook-feed'); ?></label><code class="cff_shortcode"> likeboxoutside
	                        Eg: likeboxoutside=true</code></th>
	                        <td>
	                            <input type="checkbox" name="cff_like_box_outside" id="cff_like_box_outside" <?php if($cff_like_box_outside == true) echo 'checked="checked"' ?> />
	                            <a class="cff-tooltip-link" href="JavaScript:void(0);"><i class="fa fa-question-circle" aria-hidden="true"></i></a>
	                            <p class="cff-tooltip cff-more-info"><?php _e("This positions the Like Box widget outside of the feed container. It is useful if your feed has a vertical scrollbar as it places it outside of the scrollable area and fixes it at the top or bottom."); ?></p>
	                        </td>
	                    </tr>

	                    <tr valign="top">
	                        <th class="bump-left" scope="row"><label><?php _e('Show faces of fans', 'custom-facebook-feed'); ?></label><code class="cff_shortcode"> likeboxfaces
	                        Eg: likeboxfaces=true</code></th>
	                        <td>
	                            <input type="checkbox" name="cff_like_box_faces" id="cff_like_box_faces" <?php if($cff_like_box_faces == true) echo 'checked="checked"' ?> />
	                            <a class="cff-tooltip-link" href="JavaScript:void(0);"><i class="fa fa-question-circle" aria-hidden="true"></i></a>
	                            <p class="cff-tooltip cff-more-info"><?php _e("This will display thumbnail photos within the Like Box of some of the people who like your page."); ?></p>
	                        </td>
	                    </tr>
	                    <tr valign="top">
	                        <th class="bump-left" scope="row"><label><?php _e('Include the Cover Photo', 'custom-facebook-feed'); ?></label><code class="cff_shortcode"> likeboxcover
	                        Eg: likeboxcover=true</code></th>
	                        <td>
	                            <input type="checkbox" name="cff_like_box_cover" id="cff_like_box_cover" <?php if($cff_like_box_cover == true) echo 'checked="checked"' ?> />
	                        </td>
	                    </tr>
	                    <tr valign="top">
	                        <th class="bump-left" scope="row"><label><?php _e('Use a small header', 'custom-facebook-feed'); ?></label><code class="cff_shortcode"> likeboxsmallheader
	                        Eg: likeboxsmallheader=true</code></th>
	                        <td>
	                            <input type="checkbox" name="cff_like_box_small_header" id="cff_like_box_small_header" <?php if($cff_like_box_small_header == true) echo 'checked="checked"' ?> />
	                            <a class="cff-tooltip-link" href="JavaScript:void(0);"><i class="fa fa-question-circle" aria-hidden="true"></i></a>
	                            <p class="cff-tooltip cff-more-info"><?php _e("This will display a shorter version of the Like Box with a slimmer cover photo and less information."); ?></p>
	                        </td>
	                    </tr>
	                    <tr valign="top">
	                        <th class="bump-left" scope="row"><label><?php _e('Hide custom call to action button', 'custom-facebook-feed'); ?></label><code class="cff_shortcode"> likeboxhidebtn
	                        Eg: likeboxhidebtn=true</code></th>
	                        <td>
	                            <input type="checkbox" name="cff_like_box_hide_cta" id="cff_like_box_hide_cta" <?php if($cff_like_box_hide_cta == true) echo 'checked="checked"' ?> />
	                            <a class="cff-tooltip-link" href="JavaScript:void(0);"><i class="fa fa-question-circle" aria-hidden="true"></i></a>
	                            <p class="cff-tooltip cff-more-info"><?php _e("If you have a custom 'Call To Action' button for your Facebook Page then this will hide it and display the default Like Box button."); ?></p>
	                        </td>
	                    </tr>
	                    <tr valign="top">
	                        <th class="bump-left" for="cff_likebox_width" scope="row"><label><?php _e('Custom Like Box Width', 'custom-facebook-feed'); ?></label><code class="cff_shortcode"> likeboxwidth
	                        Eg: likeboxwidth=500</code></th>
	                        <td>
	                            <input name="cff_likebox_width" type="text" value="<?php esc_attr_e( $cff_likebox_width, 'custom-facebook-feed' ); ?>" size="3" /><span class="cff-pixel-label">px</span>
	                            <span><i style="color: #666; font-size: 11px; margin-left: 5px;"><?php _e('Default: 340, Min: 180, Max: 500', 'custom-facebook-feed'); ?></i></span>
	                        </td>
	                    </tr>
	                </tbody>
	            </table>

	            <?php submit_button(); ?>

	            <hr />

	            <h3><?php _e('"Load More" button'); ?></h3>
	            <a href="https://smashballoon.com/custom-facebook-feed/?utm_campaign=facebook-free&utm_source=settings&utm_medium=loadmore" target="_blank">Upgrade to Pro to enable the Load More button</a>
	            <p class="submit cff-expand-button">
	                <a href="javascript:void(0);" class="button"><b>+</b> Show Pro Options</a>
	            </p>
	            <table class="form-table cff-expandable-options">
	                <tbody>
	                    <tr valign="top" class="cff-pro">
	                        <th class="bump-left" scope="row"><label><?php _e('Show "Load More" Button'); ?></label></th>
	                        <td>
	                            <input type="checkbox" name="cff_load_more" id="cff_load_more" disabled />
	                            <a class="cff-tooltip-link" href="JavaScript:void(0);"><i class="fa fa-question-circle" aria-hidden="true"></i></a>
	                            <p class="cff-tooltip cff-more-info"><?php _e("The Load More button is added to the bottom of your feed and allows you to dynamically load more posts into your feed. Use the button below to reveal customization settings for the button."); ?></p>
	                        </td>
	                    </tr>
	                    <tr valign="top" class="cff-pro">
	                        <th class="bump-left" scope="row"><label><?php _e('Button Background Color'); ?></label></th>
	                        <td>
	                            <input name="cff_load_more_bg" type="text" class="cff-colorpicker" disabled />
	                        </td>
	                    </tr>
	                    <tr valign="top" class="cff-pro">
	                        <th class="bump-left" scope="row"><label><?php _e('Button Hover Color'); ?></label></th>
	                        <td>
	                            <input name="cff_load_more_bg_hover" type="text" class="cff-colorpicker" disabled />
	                        </td>
	                    </tr>
	                    <tr valign="top" class="cff-pro">
	                        <th class="bump-left" scope="row"><label><?php _e('Button Text Color'); ?></label></th>
	                        <td>
	                            <input name="cff_load_more_text_color" type="text" class="cff-colorpicker" disabled />
	                        </td>
	                    </tr>
	                    <tr valign="top" class="cff-pro">
	                        <th class="bump-left" scope="row"><label><?php _e('Button Text'); ?></label></th>
	                        <td>
	                            <input name="cff_load_more_text" type="text" size="30" disabled />
	                        </td>
	                    </tr>
	                </tbody>
	            </table>

	            <hr />

	            <h3><?php _e('Lightbox'); ?></h3>
	            <a href="https://smashballoon.com/custom-facebook-feed/?utm_campaign=facebook-free&utm_source=settings&utm_medium=lightbox" target="_blank">Upgrade to Pro to enable the Lightbox</a>
	            <p class="submit cff-expand-button">
	                <a href="javascript:void(0);" class="button"><b>+</b> Show Pro Options</a>
	            </p>
	            <table class="form-table cff-expandable-options">
	                <tbody>
	                    <tr valign="top" class="cff-pro">
	                        <th class="bump-left" scope="row"><label><?php _e('Disable Popup Lightbox'); ?></label><code class="cff_shortcode"> disablelightbox
	                        Eg: disablelightbox=true</code></th>
	                        <td>
	                            <input name="cff_disable_lightbox" type="checkbox" id="cff_disable_lightbox" disabled />
	                            <label for="cff_disable_lightbox"><?php _e('Disable'); ?></label>
	                        </td>
	                    </tr>
	                    <tr valign="top" class="cff-pro">
	                        <th class="bump-left" scope="row"><label><?php _e('Background Color'); ?></label></th>
	                        <td>
	                            <input name="cff_lightbox_bg_color" type="text" class="cff-colorpicker" disabled />
	                        </td>
	                    </tr>
	                    <tr valign="top" class="cff-pro">
	                        <th class="bump-left" scope="row"><label><?php _e('Text Color'); ?></label></th>
	                        <td>
	                            <input name="cff_lightbox_text_color" type="text" class="cff-colorpicker" disabled />
	                        </td>
	                    </tr>
	                    <tr valign="top" class="cff-pro">
	                        <th class="bump-left" scope="row"><label><?php _e('Link Color'); ?></label></th>
	                        <td>
	                            <input name="cff_lightbox_link_color" type="text" class="cff-colorpicker" disabled />
	                        </td>
	                    </tr>
	                    <tr valign="top" class="cff-pro">
	                        <th class="bump-left" scope="row"><label><?php _e('Show Comments in Lightbox'); ?></label><code class="cff_shortcode"> lightboxcomments
	                        Eg: lightboxcomments=true</code></th>
	                        <td>
	                            <input type="checkbox" name="cff_lightbox_comments" id="cff_lightbox_comments" disabled/>
	                            <span><i style="color: #666; font-size: 11px; margin-left: 5px;"><?php _e('For timeline posts only'); ?></i></span>
	                        </td>
	                    </tr>
	                </tbody>
	            </table>

	            <hr />

	            <h3><?php _e('Filter Content by String'); ?></h3>
	            <a href="https://smashballoon.com/custom-facebook-feed/?utm_campaign=facebook-free&utm_source=settings&utm_medium=filtering" target="_blank">Upgrade to Pro to enable Filtering</a>
	            <p class="submit cff-expand-button">
	                <a href="javascript:void(0);" class="button"><b>+</b> Show Pro Options</a>
	            </p>
	            <table class="form-table cff-expandable-options">
	                <tbody>
	                    <tr valign="top" class="cff-pro">
	                        <th class="bump-left" scope="row"><label><?php _e('Only show posts containing:'); ?></label></th>
	                        <td>
	                            <input name="cff_filter_string" type="text" size="25" disabled />
	                            <i style="color: #666; font-size: 11px;">Eg. #smash, balloon </i>
	                            <a class="cff-tooltip-link" href="JavaScript:void(0);"><i class="fa fa-question-circle" aria-hidden="true"></i></a>
	                            <p class="cff-tooltip cff-more-info"><?php _e("You can use this setting to only display posts containing these text strings. Separate multiple strings using commas. If only a few posts, or none at all, are displayed then you may need to increase the plugin's 'Post Limit' settings. See <a href='https://smashballoon.com/filtering-your-facebook-posts/' target='_blank'>this FAQ</a> to learn more about how filtering works."); ?></p>
	                        </td>
	                    </tr>
	                    <tr valign="top" class="cff-pro">
	                        <th class="bump-left" scope="row"><label><?php _e("Don't show posts containing:"); ?></label></th>
	                        <td>
	                            <input name="cff_exclude_string" type="text" size="25" disabled />
	                            <a class="cff-tooltip-link" href="JavaScript:void(0);"><i class="fa fa-question-circle" aria-hidden="true"></i></a>
	                            <p class="cff-tooltip cff-more-info"><?php _e("You can use this setting to remove any posts containing these text strings. Separate multiple strings using commas."); ?></p>
	                        </td>
	                    </tr>
	                </tbody>
	            </table>

	            <hr />

	            <?php submit_button(); ?>

	            <p style="padding-top: 5px;"><i class="fa fa-life-ring" aria-hidden="true"></i>&nbsp; <?php _e('Having trouble using the plugin? Check out the', 'custom-facebook-feed'); ?> <a href='admin.php?page=cff-top&amp;tab=support'><?php _e('Support', 'custom-facebook-feed'); ?></a> <?php _e('tab', 'custom-facebook-feed'); ?>.</p>

	            <div class="cff_quickstart">
	                <h3><i class="fa fa-rocket" aria-hidden="true"></i>&nbsp; Display your feed</h3>
	                <p>Copy and paste this shortcode directly into the page, post or widget where you'd like to display the feed:        <input type="text" value="[custom-facebook-feed]" size="22" readonly="readonly" style="text-align: center;" onclick="this.focus();this.select()" title="To copy, click the field then press Ctrl + C (PC) or Cmd + C (Mac)."></p>
	                <p>Find out how to display <a href="https://smashballoon.com/using-shortcode-options-customize-facebook-feeds/" target="_blank"><b>multiple feeds</b></a>.</p>
	            </div>


	            <a href="https://smashballoon.com/custom-facebook-feed/demo/?utm_campaign=facebook-free&utm_source=footer&utm_medium=ad" target="_blank" class="cff-pro-notice"><img src="<?php echo CFF_PLUGIN_URL. 'admin/assets/img/pro.png?2019'  ?>" /></a>

	            <?php } //End General tab ?>
	            <?php if( $cff_active_tab == 'post_layout' ) { //Start Post Layout tab ?>

	            <p class="cff_contents_links" id="layout">
	                <span>Jump to: </span>
	                <a href="#showhide">Show/Hide</a>
	            </p>

	            <input type="hidden" name="<?php echo $style_post_layout_hidden_field_name; ?>" value="Y">
	            <br />
	            <h3><?php _e('Post Layouts', 'custom-facebook-feed'); ?></h3>
	            <a href="https://smashballoon.com/custom-facebook-feed/?utm_campaign=facebook-free&utm_source=settings&utm_medium=layouts" target="_blank"><?php _e('Upgrade to Pro to enable layouts', 'custom-facebook-feed'); ?></a>
	            <p class="submit cff-expand-button">
	                <a href="javascript:void(0);" class="button"><b>+</b> Show Pro Options</a>
	            </p>

	            <div class="form-table cff-expandable-options cff-pro">
	                <p><?php _e("Choose a layout from the 3 below."); ?>

	                <div class="cff-layouts">
	                    <div class="cff-layout cff-thumb <?php if($cff_preset_layout == "thumb") echo "cff-layout-selected"; ?>">
	                        <h3><input type="radio" name="cff_preset_layout" id="cff_preset_layout" value="thumb" disabled />&nbsp;<?php _e('Thumbnail'); ?></h3>
	                            <img src="<?php echo CFF_PLUGIN_URL . 'admin/assets/img/layout-thumb.png'  ?>" alt="Thumbnail Layout" />

	                    </div>
	                    <div class="cff-layout cff-half <?php if($cff_preset_layout == "half") echo "cff-layout-selected"; ?>">
	                        <h3><input type="radio" name="cff_preset_layout" id="cff_preset_layout" value="half" disabled />&nbsp;<?php _e('Half-width'); ?></h3>
	                            <img src="<?php echo CFF_PLUGIN_URL . 'admin/assets/img/layout-half.png' ?>" alt="Half Width Layout" />

	                    </div>
	                    <div class="cff-layout cff-full <?php if($cff_preset_layout == "full") echo "cff-layout-selected"; ?>">
	                        <h3><input type="radio" name="cff_preset_layout" id="cff_preset_layout" value="full" disabled />&nbsp;<?php _e('Full-width'); ?></h3>
	                            <img src="<?php echo CFF_PLUGIN_URL . 'admin/assets/img/layout-full.png' ?>" alt="Full Width Layout" />

	                    </div>
	                </div>

	                <table class="form-table">
	                    <tbody>
	                        <tr class="cff-media-position" class="cff-pro">
	                            <th><label for="cff_media_position" class="bump-left"><?php _e('Photo/Video Position'); ?></label></th>
	                            <td>
	                                <select name="cff_media_position" disabled>
	                                    <option value="below">Below Text</option>
	                                    <option value="above">Above Text</option>
	                                </select>
	                            </td>
	                        </tr>
	                        <tr class="cff-pro">
	                            <th><label for="cff_media_position" class="bump-left"><?php _e('Photo/Video Position'); ?></label></th>
	                            <td>
	                                <select name="cff_media_position" disabled>
	                                    <option value="below">Below Text</option>
	                                    <option value="above">Above Text</option>
	                                </select>
	                                <i style="color: #666; font-size: 11px; margin-left: 5px;">Only applies to Full-width layout</i>
	                            </td>
	                        </tr>
	                        <tr class="cff-pro">
	                            <th><label for="cff_enable_narrow" class="bump-left"><?php _e('Always use the Full-width layout when feed is narrow?'); ?></label></th>
	                            <td>
	                                <input name="cff_enable_narrow" type="checkbox" id="cff_enable_narrow" disabled />
	                                <a class="cff-tooltip-link" href="JavaScript:void(0);"><i class="fa fa-question-circle" aria-hidden="true"></i></a>
	                                <p class="cff-tooltip cff-more-info"><?php _e("When displaying posts in either a narrow column or on a mobile device the plugin will automatically default to using the 'Full-width' layout as it's better suited to narrow sizes."); ?></p>
	                            </td>
	                        </tr>
	                        <tr class="cff-pro">
	                            <th><label for="cff_one_image" class="bump-left"><?php _e('Only show one image per post'); ?></label></th>
	                            <td>
	                                <input name="cff_one_image" type="checkbox" id="cff_one_image" disabled />
	                                <a class="cff-tooltip-link" href="JavaScript:void(0);"><i class="fa fa-question-circle" aria-hidden="true"></i></a>
	                                <p class="cff-tooltip cff-more-info"><?php _e("If a Facebook post contains more than photo then enabling this setting means that only the first photo in the post is displayed."); ?></p>
	                            </td>
	                        </tr>
	                    </tbody>
	                </table>
	            </div>



	            <table class="form-table" id="showhide">

	                <hr />
	                <h3><?php _e('Show/Hide'); ?></h3>
	                <table class="form-table">
	                    <tbody>
	                    <tr valign="top">
	                        <th scope="row"><label><?php _e('Include the following in posts: <i style="font-size: 11px;">(when applicable)</i>'); ?></label><code class="cff_shortcode"> include  exclude
	                        Eg: include=text,date,likebox
	                        Eg: exclude=likebox

	                        Options: author, text, desc, sharedlinks, date, eventtitle, eventdetails, link, likebox</code></th>
	                        <td class="cff_show_hide_settings">
	                            <div>
	                                <input name="cff_show_author" type="checkbox" id="cff_show_author" <?php if($cff_show_author == true) echo "checked"; ?> />
	                                <label for="cff_show_author">
	                                    <b><?php _e('Author Name and Avatar'); ?></b>
	                                    <p class="cff-show-hide-desc"><?php _e("The author name and avatar image that's shown at the top of each timeline post"); ?></p>
	                                </label>

	                            </div>
	                            <div>
	                                <input name="cff_show_text" type="checkbox" id="cff_show_text" <?php if($cff_show_text == true) echo "checked"; ?> />
	                                <label for="cff_show_text">
	                                    <b><?php _e('Post Text'); ?></b>
	                                    <p class="cff-show-hide-desc"><?php _e("The main text of the Facebook post"); ?></p>
	                                </label>
	                            </div>
	                            <div>
	                                <input type="checkbox" name="cff_show_desc" id="cff_show_desc" <?php if($cff_show_desc == true) echo 'checked="checked"' ?> />
	                                <label for="cff_show_desc">
	                                    <b><?php _e('Description Text'); ?></b>
	                                    <p class="cff-show-hide-desc"><?php _e("The description text associated with shared photos, videos, or links"); ?></p>
	                                </label>
	                            </div>
	                            <div>
	                                <input type="checkbox" name="cff_show_shared_links" id="cff_show_shared_links" <?php if($cff_show_shared_links == true) echo 'checked="checked"' ?> />
	                                <label for="cff_show_shared_links">
	                                    <b><?php _e('Shared Link Box'); ?></b>
	                                    <p class="cff-show-hide-desc"><?php _e("The link info box that's created when a link is shared in a Facebook post"); ?></p>
	                                </label>
	                            </div>
	                            <div>
	                                <input type="checkbox" name="cff_show_date" id="cff_show_date" <?php if($cff_show_date == true) echo 'checked="checked"' ?> />
	                                <label for="cff_show_date">
	                                    <b><?php _e('Date'); ?></b>
	                                    <p class="cff-show-hide-desc"><?php _e("The date of the post"); ?></p>
	                                </label>
	                            </div>
	                            <div class="cff-disabled">
	                                <input type="checkbox" name="cff_show_media" disabled />
	                                <label for="cff_show_media">
	                                    <b><?php _e('Photos and Videos'); ?></b>
	                                    <p class="cff-show-hide-desc"><?php _e("Any photos or videos in your posts"); ?></p>
	                                </label>
	                            </div>
	                            <div>
	                                <input type="checkbox" name="cff_show_media_link" id="cff_show_media_link" <?php if($cff_show_media_link == true) echo 'checked="checked"' ?> />
	                                <label for="cff_show_media_link">
	                                    <b><?php _e('Media link', 'custom-facebook-feed'); ?></b>
	                                    <p class="cff-show-hide-desc"><?php _e("Display an icon and link to Facebook if the post contains either a photo or video"); ?></p>
	                                </label>
	                            </div>
	                            <div>
	                                <input type="checkbox" name="cff_show_event_title" id="cff_show_event_title" <?php if($cff_show_event_title == true) echo 'checked="checked"' ?> />
	                                <label for="cff_show_event_title">
	                                    <b><?php _e('Event Title'); ?></b>
	                                    <p class="cff-show-hide-desc"><?php _e("The title of an event"); ?></p>
	                                </label>
	                            </div>
	                            <div>
	                                <input type="checkbox" name="cff_show_event_details" id="cff_show_event_details" <?php if($cff_show_event_details == true) echo 'checked="checked"' ?> />
	                                <label for="cff_show_event_details">
	                                    <b><?php _e('Event Details'); ?></b>
	                                    <p class="cff-show-hide-desc"><?php _e("The information associated with an event"); ?></p>
	                                </label>
	                            </div>
	                            <div class="cff-disabled">
	                                <input type="checkbox" name="cff_show_meta" disabled />
	                                <label for="cff_show_meta">
	                                    <b><?php _e('Like, Shares, and Comments'); ?></b>
	                                    <p class="cff-show-hide-desc"><?php _e("The comments box displayed at the bottom of each timeline post"); ?></p>
	                                </label>
	                            </div>
	                            <div>
	                                <input type="checkbox" name="cff_show_link" id="cff_show_link" <?php if($cff_show_link == true) echo 'checked="checked"' ?> />
	                                <label for="cff_show_link">
	                                    <b><?php _e('Post Action Links'); ?></b>
	                                    <p class="cff-show-hide-desc"><?php _e('The "View on Facebook" and "Share" links at the bottom of each post'); ?></p>
	                                </label>
	                            </div>
	                        </td>
	                    </tr>
	                    <tr id="poststyle"><!-- Quick link --></tr>
	                </tbody>
	            </table>

	            <?php submit_button(); ?>
	            <a href="https://smashballoon.com/custom-facebook-feed/demo/?utm_campaign=facebook-free&utm_source=footer&utm_medium=ad" target="_blank" class="cff-pro-notice"><img src="<?php echo CFF_PLUGIN_URL. 'admin/assets/img/pro.png'  ?>" /></a>
	            <?php } //End Post Layout tab ?>
	            <?php if( $cff_active_tab == 'typography' ) { //Start Typography tab ?>

	            <p class="cff_contents_links" id="postitem">
	                <span>Jump to: </span>
	                <a href="#postitem">Post Item</a>
	                <a href="#author">Post Author</a>
	                <a href="#text">Post Text</a>
	                <a href="#description">Shared Post Description</a>
	                <a href="#date">Post Date</a>
	                <a href="#links">Shared Link Boxes</a>
	                <a href="#eventtitle">Event Title</a>
	                <a href="#eventdate">Event Date</a>
	                <a href="#eventdetails">Event Details</a>
	                <a href="#comments">Comments Box</a>
	                <a href="#action">Post Action Links</a>
	            </p>

	            <input type="hidden" name="<?php echo $style_typography_hidden_field_name; ?>" value="Y">
	            <br />

	            <h3><?php _e('Post Item'); ?></h3>
	            <table class="form-table">
	                <tbody>
	                <tr>
	                    <th class="bump-left" scope="row"><label><?php _e('Post Style'); ?></label><code class="cff_shortcode"> poststyle
	                        Eg: poststyle=regular/boxed</code></th>
	                        <td>
	                            <?php
	                            //If a post style isn't set (eg on initial update) then set it to be regular unless a bgcolor is set
	                            if( $cff_post_style == '' || empty($cff_post_style) ){
	                                $cff_post_style = 'regular';
	                                if( strlen($cff_post_bg_color) > 1 ) $cff_post_style = 'boxed';
	                            }

	                            ?>
	                            <div class="cff-layouts">
	                                <div class="cff-post-style cff-layout <?php if($cff_post_style == "regular") echo "cff-layout-selected"; ?>">
	                                    <h3><input type="radio" name="cff_post_style" id="cff_post_style" class="cff_post_style" value="regular" <?php if($cff_post_style == "regular") echo "checked"; ?> />&nbsp;<?php _e('Regular'); ?></h3>
	                                    <img src="<?php echo CFF_PLUGIN_URL . 'admin/assets/img/post-style.png' ?>" alt="Regular Post Style" />
	                                    <img src="<?php echo CFF_PLUGIN_URL . 'admin/assets/img/post-style.png' ?>" alt="Regular Post Style" />
	                                </div>

	                                <div class="cff-post-style cff-boxed cff-layout <?php if($cff_post_style == "boxed") echo "cff-layout-selected"; ?>">
	                                    <h3><input type="radio" name="cff_post_style" id="cff_post_style" class="cff_post_style" value="boxed" <?php if($cff_post_style == "boxed") echo "checked"; ?> />&nbsp;<?php _e('Boxed'); ?></h3>
	                                    <img src="<?php echo CFF_PLUGIN_URL . 'admin/assets/img/post-style.png' ?>" alt="Box Post Style" style="margin-top: -2px;" />
	                                    <img src="<?php echo CFF_PLUGIN_URL . 'admin/assets/img/post-style.png' ?>" alt="Box Post Style" style="margin-top: 2px;" />
	                                </div>

	                                <div class="cff-post-style-settings cff-regular">

	                                    <div class="cff-row">
	                                        <label><?php _e('Separating Line Color'); ?></label><code class="cff_shortcode"> sepcolor
	                                        Eg: sepcolor=CFCFCF</code>
	                                        <br />
	                                        <input name="cff_sep_color" value="#<?php esc_attr_e( str_replace('#', '', $cff_sep_color) ); ?>" class="cff-colorpicker" />
	                                    </div>
	                                     <div class="cff-row">
	                                        <label><?php _e('Separating Line Thickness'); ?></label><code class="cff_shortcode"> sepsize
	                                        Eg: sepsize=3</code>
	                                        <br />
	                                        <input name="cff_sep_size" type="text" value="<?php esc_attr_e( $cff_sep_size ); ?>" size="1" /><span class="cff-pixel-label">px</span> <i style="color: #666; font-size: 11px; margin-left: 5px;"><?php _e('Leave empty to hide'); ?></i>
	                                    </div>
	                                </div>

	                                <div class="cff-post-style-settings cff-boxed">
	                                    <div class="cff-row">
	                                        <label><?php _e('Background Color'); ?></label><code class="cff_shortcode"> postbgcolor
	                                        Eg: postbgcolor=ff0000</code>
	                                        <br />
	                                        <input name="cff_post_bg_color" value="#<?php esc_attr_e( str_replace('#', '', $cff_post_bg_color) ); ?>" class="cff-colorpicker" />
	                                    </div>
	                                    <div class="cff-row">
	                                        <label><?php _e('Rounded Corner Size'); ?></label><code class="cff_shortcode"> postcorners
	                                        Eg: postcorners=10</code>
	                                        <br />
	                                        <input name="cff_post_rounded" type="text" value="<?php esc_attr_e( $cff_post_rounded ); ?>" size="3" /><span class="cff-pixel-label">px</span> <span><i style="color: #666; font-size: 11px; margin-left: 5px;">Eg. 5</i></span>
	                                    </div>
	                                     <div class="cff-row">
	                                        <label><?php _e('Box Shadow'); ?></label><code class="cff_shortcode"> boxshadow
	                                        Eg: boxshadow=true</code>
	                                        <br />
	                                        <input type="checkbox" name="cff_box_shadow" id="cff_box_shadow" <?php if($cff_box_shadow == true) echo 'checked="checked"' ?> /> <i style="color: #666; font-size: 11px; margin-left: 5px;"><?php _e('Adds a subtle shadow around the post'); ?></i>
	                                    </div>
	                                </div>

	                            </div>
	                        </td>
	                    </tr>
	                </tbody>
	            </table>
	            <hr />

	            <h3><?php _e('Post Author'); ?></h3>
	            <table class="form-table">
	                <tbody>
	                    <tr>
	                        <th class="bump-left"><label for="cff_author_size" class="bump-left"><?php _e('Text Size'); ?></label><code class="cff_shortcode"> authorsize
	            Eg: authorsize=20</code></th>
	                        <td>
	                            <select name="cff_author_size" class="cff-text-size-setting">
	                                <option value="inherit" <?php if($cff_author_size == "inherit") echo 'selected="selected"' ?> >Inherit from theme</option>
	                                <option value="10" <?php if($cff_author_size == "10") echo 'selected="selected"' ?> >10px</option>
	                                <option value="11" <?php if($cff_author_size == "11") echo 'selected="selected"' ?> >11px</option>
	                                <option value="12" <?php if($cff_author_size == "12") echo 'selected="selected"' ?> >12px</option>
	                                <option value="13" <?php if($cff_author_size == "13") echo 'selected="selected"' ?> >13px</option>
	                                <option value="14" <?php if($cff_author_size == "14") echo 'selected="selected"' ?> >14px</option>
	                                <option value="16" <?php if($cff_author_size == "16") echo 'selected="selected"' ?> >16px</option>
	                                <option value="18" <?php if($cff_author_size == "18") echo 'selected="selected"' ?> >18px</option>
	                                <option value="20" <?php if($cff_author_size == "20") echo 'selected="selected"' ?> >20px</option>
	                                <option value="24" <?php if($cff_author_size == "24") echo 'selected="selected"' ?> >24px</option>
	                                <option value="28" <?php if($cff_author_size == "28") echo 'selected="selected"' ?> >28px</option>
	                                <option value="32" <?php if($cff_author_size == "32") echo 'selected="selected"' ?> >32px</option>
	                                <option value="36" <?php if($cff_author_size == "36") echo 'selected="selected"' ?> >36px</option>
	                                <option value="42" <?php if($cff_author_size == "42") echo 'selected="selected"' ?> >42px</option>
	                                <option value="48" <?php if($cff_author_size == "48") echo 'selected="selected"' ?> >48px</option>
	                                <option value="54" <?php if($cff_author_size == "54") echo 'selected="selected"' ?> >54px</option>
	                                <option value="60" <?php if($cff_author_size == "60") echo 'selected="selected"' ?> >60px</option>
	                            </select>
	                        </td>
	                    </tr>
	                    <tr>
	                        <th class="bump-left"><label for="cff_author_color" class="bump-left"><?php _e('Text Color'); ?></label><code class="cff_shortcode"> authorcolor
	            Eg: authorcolor=ff0000</code></th>
	                        <td>
	                            <input name="cff_author_color" value="#<?php esc_attr_e( str_replace('#', '', $cff_author_color) ); ?>" class="cff-colorpicker" />
	                        </td>
	                    </tr>
	                    <tr id="text"><!-- Quick link --></tr>
	                </tbody>
	            </table>

	            <div style="margin-top: -15px;">
	                <?php submit_button(); ?>
	            </div>

	            <hr />

	            <h3><?php _e('Post Text'); ?></h3>
	            <table class="form-table">
	                <tbody>
	                    <tr valign="top">
	                        <th class="bump-left" scope="row"><label class="bump-left"><?php _e('Maximum Post Text Length'); ?></label><code class="cff_shortcode"> textlength
	            Eg: textlength=200</code></th>
	                        <td>
	                            <input name="cff_title_length" type="text" value="<?php esc_attr_e( $cff_title_length_val ); ?>" size="4" /><span class="cff-pixel-label"><?php _e('Characters'); ?></span> <i style="color: #666; font-size: 11px; margin-left: 5px;"><?php _e('Eg. 200'); ?></i>
	                            <a class="cff-tooltip-link" href="JavaScript:void(0);"><i class="fa fa-question-circle" aria-hidden="true"></i></a>
	                            <p class="cff-tooltip cff-more-info"><?php _e("If the post text exceeds this length then a 'See More' link will be added. Leave empty to set no maximum length."); ?></p>
	                        </td>
	                    </tr>
	                    <tr>
	                        <th class="bump-left"><label for="cff_title_format" class="bump-left"><?php _e('Format'); ?></label><code class="cff_shortcode"> textformat
	            Eg: textformat=h4</code></th>
	                        <td>
	                            <select name="cff_title_format" class="cff-text-size-setting">
	                                <option value="p" <?php if($cff_title_format == "p") echo 'selected="selected"' ?> >Paragraph</option>
	                                <option value="h3" <?php if($cff_title_format == "h3") echo 'selected="selected"' ?> >Heading 3</option>
	                                <option value="h4" <?php if($cff_title_format == "h4") echo 'selected="selected"' ?> >Heading 4</option>
	                                <option value="h5" <?php if($cff_title_format == "h5") echo 'selected="selected"' ?> >Heading 5</option>
	                                <option value="h6" <?php if($cff_title_format == "h6") echo 'selected="selected"' ?> >Heading 6</option>
	                            </select>
	                        </td>
	                    </tr>
	                    <tr>
	                        <th class="bump-left"><label for="cff_title_size" class="bump-left"><?php _e('Text Size'); ?></label><code class="cff_shortcode"> textsize
	            Eg: textsize=12</code></th>
	                        <td>
	                            <select name="cff_title_size" class="cff-text-size-setting">
	                                <option value="inherit" <?php if($cff_title_size == "inherit") echo 'selected="selected"' ?> >Inherit from theme</option>
	                                <option value="10" <?php if($cff_title_size == "10") echo 'selected="selected"' ?> >10px</option>
	                                <option value="11" <?php if($cff_title_size == "11") echo 'selected="selected"' ?> >11px</option>
	                                <option value="12" <?php if($cff_title_size == "12") echo 'selected="selected"' ?> >12px</option>
	                                <option value="13" <?php if($cff_title_size == "13") echo 'selected="selected"' ?> >13px</option>
	                                <option value="14" <?php if($cff_title_size == "14") echo 'selected="selected"' ?> >14px</option>
	                                <option value="16" <?php if($cff_title_size == "16") echo 'selected="selected"' ?> >16px</option>
	                                <option value="18" <?php if($cff_title_size == "18") echo 'selected="selected"' ?> >18px</option>
	                                <option value="20" <?php if($cff_title_size == "20") echo 'selected="selected"' ?> >20px</option>
	                                <option value="24" <?php if($cff_title_size == "24") echo 'selected="selected"' ?> >24px</option>
	                                <option value="28" <?php if($cff_title_size == "28") echo 'selected="selected"' ?> >28px</option>
	                                <option value="32" <?php if($cff_title_size == "32") echo 'selected="selected"' ?> >32px</option>
	                                <option value="36" <?php if($cff_title_size == "36") echo 'selected="selected"' ?> >36px</option>
	                                <option value="42" <?php if($cff_title_size == "42") echo 'selected="selected"' ?> >42px</option>
	                                <option value="48" <?php if($cff_title_size == "48") echo 'selected="selected"' ?> >48px</option>
	                                <option value="54" <?php if($cff_title_size == "54") echo 'selected="selected"' ?> >54px</option>
	                                <option value="60" <?php if($cff_title_size == "60") echo 'selected="selected"' ?> >60px</option>
	                            </select>
	                        </td>
	                    </tr>
	                    <tr>
	                        <th class="bump-left"><label for="cff_title_weight" class="bump-left"><?php _e('Text Weight'); ?></label><code class="cff_shortcode"> textweight
	            Eg: textweight=bold</code></th>
	                        <td>
	                            <select name="cff_title_weight" class="cff-text-size-setting">
	                                <option value="inherit" <?php if($cff_title_weight == "inherit") echo 'selected="selected"' ?> >Inherit from theme</option>
	                                <option value="normal" <?php if($cff_title_weight == "normal") echo 'selected="selected"' ?> >Normal</option>
	                                <option value="bold" <?php if($cff_title_weight == "bold") echo 'selected="selected"' ?> >Bold</option>
	                            </select>
	                        </td>
	                    </tr>
	                    <tr>
	                        <th class="bump-left"><label for="cff_title_color" class="bump-left"><?php _e('Text Color'); ?></label><code class="cff_shortcode"> textcolor
	            Eg: textcolor=333</code></th>
	                        <td>
	                            <input name="cff_title_color" value="#<?php esc_attr_e( str_replace('#', '', $cff_title_color) ); ?>" class="cff-colorpicker" />
	                        </td>
	                    </tr>
	                    <tr>
	                        <th class="bump-left"><label for="cff_posttext_link_color" class="bump-left"><?php _e('Link Color'); ?></label><code class="cff_shortcode"> textlinkcolor
	            Eg: textlinkcolor=E69100</code></th>
	                        <td>
	                            <input name="cff_posttext_link_color" value="#<?php esc_attr_e( str_replace('#', '', $cff_posttext_link_color) ); ?>" class="cff-colorpicker" />
	                        </td>
	                    </tr>
	                    <tr>
	                        <th class="bump-left"><label for="cff_title_link" class="bump-left"><?php _e('Link Text to Facebook Post'); ?></label><code class="cff_shortcode"> textlink
	            Eg: textlink=true</code></th>
	                        <td><input type="checkbox" name="cff_title_link" id="cff_title_link" <?php if($cff_title_link == true) echo 'checked="checked"' ?> /></td>
	                    </tr>

	                    <tr>
	                        <th class="bump-left"><label for="cff_post_tags" class="bump-left"><?php _e('Link Post Tags'); ?></label><code class="cff_shortcode"> posttags
	            Eg: posttags=false</code></th>
	                        <td>
	                            <input type="checkbox" name="cff_post_tags" id="cff_post_tags" <?php if($cff_post_tags == true) echo 'checked="checked"' ?> />
	                            <a class="cff-tooltip-link" href="JavaScript:void(0);"><?php _e('What are Post Tags?'); ?></a>
	                            <p class="cff-tooltip cff-more-info"><?php _e("When you tag another Facebook page or user in your post using the @ symbol it creates a post tag, which is a link to either that Facebook page or user profile."); ?></p>
	                        </td>
	                    </tr>

	                    <tr>
	                        <th class="bump-left"><label for="cff_link_hashtags" class="bump-left"><?php _e('Link Hashtags'); ?></label><code class="cff_shortcode"> linkhashtags
	            Eg: linkhashtags=false</code></th>
	                        <td>
	                            <input type="checkbox" name="cff_link_hashtags" id="cff_link_hashtags" <?php if($cff_link_hashtags == true) echo 'checked="checked"' ?> />
	                        </td>
	                    </tr>
	                    <tr id="description"><!-- Quick link --></tr>
	                </tbody>
	            </table>

	            <hr />

	            <h3><?php _e('Shared Post Description'); ?></h3>
	            <table class="form-table">
	                <tbody>
	                    <tr>
	                        <th class="bump-left"><label for="cff_body_size" class="bump-left"><?php _e('Text Size'); ?></label><code class="cff_shortcode"> descsize
	            Eg: descsize=11</code></th>
	                        <td>
	                            <select name="cff_body_size" class="cff-text-size-setting">
	                                <option value="inherit" <?php if($cff_body_size == "inherit") echo 'selected="selected"' ?> >Inherit from theme</option>
	                                <option value="10" <?php if($cff_body_size == "10") echo 'selected="selected"' ?> >10px</option>
	                                <option value="11" <?php if($cff_body_size == "11") echo 'selected="selected"' ?> >11px</option>
	                                <option value="12" <?php if($cff_body_size == "12") echo 'selected="selected"' ?> >12px</option>
	                                <option value="13" <?php if($cff_body_size == "13") echo 'selected="selected"' ?> >13px</option>
	                                <option value="14" <?php if($cff_body_size == "14") echo 'selected="selected"' ?> >14px</option>
	                                <option value="16" <?php if($cff_body_size == "16") echo 'selected="selected"' ?> >16px</option>
	                                <option value="18" <?php if($cff_body_size == "18") echo 'selected="selected"' ?> >18px</option>
	                                <option value="20" <?php if($cff_body_size == "20") echo 'selected="selected"' ?> >20px</option>
	                                <option value="24" <?php if($cff_body_size == "24") echo 'selected="selected"' ?> >24px</option>
	                                <option value="28" <?php if($cff_body_size == "28") echo 'selected="selected"' ?> >28px</option>
	                                <option value="32" <?php if($cff_body_size == "32") echo 'selected="selected"' ?> >32px</option>
	                                <option value="36" <?php if($cff_body_size == "36") echo 'selected="selected"' ?> >36px</option>
	                                <option value="42" <?php if($cff_body_size == "42") echo 'selected="selected"' ?> >42px</option>
	                                <option value="48" <?php if($cff_body_size == "48") echo 'selected="selected"' ?> >48px</option>
	                                <option value="54" <?php if($cff_body_size == "54") echo 'selected="selected"' ?> >54px</option>
	                                <option value="60" <?php if($cff_body_size == "60") echo 'selected="selected"' ?> >60px</option>
	                            </select>
	                        </td>
	                    </tr>
	                    <tr>
	                        <th class="bump-left"><label for="cff_body_weight" class="bump-left"><?php _e('Text Weight'); ?></label><code class="cff_shortcode"> descweight
	            Eg: descweight=bold</code></th>
	                        <td>
	                            <select name="cff_body_weight" class="cff-text-size-setting">
	                                <option value="inherit" <?php if($cff_body_weight == "inherit") echo 'selected="selected"' ?> >Inherit from theme</option>
	                                <option value="normal" <?php if($cff_body_weight == "normal") echo 'selected="selected"' ?> >Normal</option>
	                                <option value="bold" <?php if($cff_body_weight == "bold") echo 'selected="selected"' ?> >Bold</option>
	                            </select>
	                        </td>
	                    </tr>
	                    <tr>
	                        <th class="bump-left"><label for="cff_body_color" class="bump-left"><?php _e('Text Color'); ?></label><code class="cff_shortcode"> desccolor
	            Eg: desccolor=9F9F9F</code></th>

	                        <td>
	                            <input name="cff_body_color" value="#<?php esc_attr_e( str_replace('#', '', $cff_body_color) ); ?>" class="cff-colorpicker" />
	                        </td>
	                    </tr>
	                    <tr id="date"><!-- Quick link --></tr>
	                </tbody>
	            </table>

	            <div style="margin-top: -15px;">
	                <?php submit_button(); ?>
	            </div>
	            <hr />

	            <h3><?php _e('Post Date'); ?></h3>
	            <table class="form-table">
	                <tbody>
	                <tr>
	                    <th class="bump-left"><label for="cff_date_position" class="bump-left"><?php _e('Position'); ?></label><code class="cff_shortcode"> datepos
	            Eg: datepos=below</code></th>
	                    <td>
	                        <select name="cff_date_position" style="width: 300px;">
	                            <option value="author" <?php if($cff_date_position == "author") echo 'selected="selected"' ?> >Immediately under the post author</option>
	                            <option value="above" <?php if($cff_date_position == "above") echo 'selected="selected"' ?> >At the top of the post</option>
	                            <option value="below" <?php if($cff_date_position == "below") echo 'selected="selected"' ?> >At the bottom of the post</option>
	                        </select>
	                    </td>
	                </tr>
	                <tr>
	                    <th class="bump-left"><label for="cff_date_size" class="bump-left"><?php _e('Text Size'); ?></label><code class="cff_shortcode"> datesize
	            Eg: datesize=14</code></th>
	                    <td>
	                        <select name="cff_date_size" class="cff-text-size-setting">
	                            <option value="inherit" <?php if($cff_date_size == "inherit") echo 'selected="selected"' ?> >Inherit from theme</option>
	                            <option value="10" <?php if($cff_date_size == "10") echo 'selected="selected"' ?> >10px</option>
	                            <option value="11" <?php if($cff_date_size == "11") echo 'selected="selected"' ?> >11px</option>
	                            <option value="12" <?php if($cff_date_size == "12") echo 'selected="selected"' ?> >12px</option>
	                            <option value="13" <?php if($cff_date_size == "13") echo 'selected="selected"' ?> >13px</option>
	                            <option value="14" <?php if($cff_date_size == "14") echo 'selected="selected"' ?> >14px</option>
	                            <option value="16" <?php if($cff_date_size == "16") echo 'selected="selected"' ?> >16px</option>
	                            <option value="18" <?php if($cff_date_size == "18") echo 'selected="selected"' ?> >18px</option>
	                            <option value="20" <?php if($cff_date_size == "20") echo 'selected="selected"' ?> >20px</option>
	                            <option value="24" <?php if($cff_date_size == "24") echo 'selected="selected"' ?> >24px</option>
	                            <option value="28" <?php if($cff_date_size == "28") echo 'selected="selected"' ?> >28px</option>
	                            <option value="32" <?php if($cff_date_size == "32") echo 'selected="selected"' ?> >32px</option>
	                            <option value="36" <?php if($cff_date_size == "36") echo 'selected="selected"' ?> >36px</option>
	                            <option value="42" <?php if($cff_date_size == "42") echo 'selected="selected"' ?> >42px</option>
	                            <option value="48" <?php if($cff_date_size == "48") echo 'selected="selected"' ?> >48px</option>
	                            <option value="54" <?php if($cff_date_size == "54") echo 'selected="selected"' ?> >54px</option>
	                            <option value="60" <?php if($cff_date_size == "60") echo 'selected="selected"' ?> >60px</option>
	                        </select>
	                    </td>
	                </tr>
	                <tr>
	                    <th class="bump-left"><label for="cff_date_weight" class="bump-left"><?php _e('Text Weight'); ?></label><code class="cff_shortcode"> dateweight
	            Eg: dateweight=normal</code></th>
	                    <td>
	                        <select name="cff_date_weight" class="cff-text-size-setting">
	                            <option value="inherit" <?php if($cff_date_weight == "inherit") echo 'selected="selected"' ?> >Inherit from theme</option>
	                            <option value="normal" <?php if($cff_date_weight == "normal") echo 'selected="selected"' ?> >Normal</option>
	                            <option value="bold" <?php if($cff_date_weight == "bold") echo 'selected="selected"' ?> >Bold</option>
	                        </select>
	                    </td>
	                </tr>
	                <tr>
	                    <th class="bump-left"><label for="cff_date_color" class="bump-left"><?php _e('Text Color'); ?></label><code class="cff_shortcode"> datecolor
	            Eg: datecolor=EAD114</code></th>
	                    <td>
	                        <input name="cff_date_color" value="#<?php esc_attr_e( str_replace('#', '', $cff_date_color) ); ?>" class="cff-colorpicker" />
	                    </td>
	                </tr>

	                <tr>
	                    <th class="bump-left"><label for="cff_date_formatting" class="bump-left"><?php _e('Date Formatting'); ?></label><code class="cff_shortcode"> dateformat
	            Eg: dateformat=3</code></th>
	                    <td>
	                        <select name="cff_date_formatting" style="width: 300px;">
	                            <?php $original = strtotime('2016-07-25T17:30:00+0000'); ?>
	                            <option value="1" <?php if($cff_date_formatting == "1") echo 'selected="selected"' ?> ><?php _e('2 days ago'); ?></option>
	                            <option value="2" <?php if($cff_date_formatting == "2") echo 'selected="selected"' ?> ><?php echo date('F jS, g:i a', $original); ?></option>
	                            <option value="3" <?php if($cff_date_formatting == "3") echo 'selected="selected"' ?> ><?php echo date('F jS', $original); ?></option>
	                            <option value="4" <?php if($cff_date_formatting == "4") echo 'selected="selected"' ?> ><?php echo date('D F jS', $original); ?></option>
	                            <option value="5" <?php if($cff_date_formatting == "5") echo 'selected="selected"' ?> ><?php echo date('l F jS', $original); ?></option>
	                            <option value="6" <?php if($cff_date_formatting == "6") echo 'selected="selected"' ?> ><?php echo date('D M jS, Y', $original); ?></option>
	                            <option value="7" <?php if($cff_date_formatting == "7") echo 'selected="selected"' ?> ><?php echo date('l F jS, Y', $original); ?></option>
	                            <option value="8" <?php if($cff_date_formatting == "8") echo 'selected="selected"' ?> ><?php echo date('l F jS, Y - g:i a', $original); ?></option>
	                            <option value="9" <?php if($cff_date_formatting == "9") echo 'selected="selected"' ?> ><?php echo date("l M jS, 'y", $original); ?></option>
	                            <option value="10" <?php if($cff_date_formatting == "10") echo 'selected="selected"' ?> ><?php echo date('m.d.y', $original); ?></option>
	                            <option value="18" <?php if($cff_date_formatting == "18") echo 'selected="selected"' ?> ><?php echo date('m.d.y - G:i', $original); ?></option>
	                            <option value="11" <?php if($cff_date_formatting == "11") echo 'selected="selected"' ?> ><?php echo date('m/d/y', $original); ?></option>
	                            <option value="12" <?php if($cff_date_formatting == "12") echo 'selected="selected"' ?> ><?php echo date('d.m.y', $original); ?></option>
	                            <option value="19" <?php if($cff_date_formatting == "19") echo 'selected="selected"' ?> ><?php echo date('d.m.y - G:i', $original); ?></option>
	                            <option value="13" <?php if($cff_date_formatting == "13") echo 'selected="selected"' ?> ><?php echo date('d/m/y', $original); ?></option>

	                            <option value="14" <?php if($cff_date_formatting == "14") echo 'selected="selected"' ?> ><?php echo date('d-m-Y, G:i', $original); ?></option>
	                            <option value="15" <?php if($cff_date_formatting == "15") echo 'selected="selected"' ?> ><?php echo date('jS F Y, G:i', $original); ?></option>
	                            <option value="16" <?php if($cff_date_formatting == "16") echo 'selected="selected"' ?> ><?php echo date('d M Y, G:i', $original); ?></option>
	                            <option value="17" <?php if($cff_date_formatting == "17") echo 'selected="selected"' ?> ><?php echo date('l jS F Y, G:i', $original); ?></option>
	                        </select>
	                </tr>

	                <tr>
	                    <th class="bump-left"><label for="cff_timezone" class="bump-left"><?php _e('Timezone'); ?></label><code class="cff_shortcode"> timezone
	                        Eg: timezone="America/New_York"
	                        <a href="http://php.net/manual/en/timezones.php" target="_blank">See full list</a></code></th>
	                    <td>
	                        <select name="cff_timezone" style="width: 300px;">
	                            <option value="Pacific/Midway" <?php if($cff_timezone == "Pacific/Midway") echo 'selected="selected"' ?> ><?php _e('(GMT-11:00) Midway Island, Samoa'); ?></option>
	                            <option value="America/Adak" <?php if($cff_timezone == "America/Adak") echo 'selected="selected"' ?> ><?php _e('(GMT-10:00) Hawaii-Aleutian'); ?></option>
	                            <option value="Etc/GMT+10" <?php if($cff_timezone == "Etc/GMT+10") echo 'selected="selected"' ?> ><?php _e('(GMT-10:00) Hawaii'); ?></option>
	                            <option value="Pacific/Marquesas" <?php if($cff_timezone == "Pacific/Marquesas") echo 'selected="selected"' ?> ><?php _e('(GMT-09:30) Marquesas Islands'); ?></option>
	                            <option value="Pacific/Gambier" <?php if($cff_timezone == "Pacific/Gambier") echo 'selected="selected"' ?> ><?php _e('(GMT-09:00) Gambier Islands'); ?></option>
	                            <option value="America/Anchorage" <?php if($cff_timezone == "America/Anchorage") echo 'selected="selected"' ?> ><?php _e('(GMT-09:00) Alaska'); ?></option>
	                            <option value="America/Ensenada" <?php if($cff_timezone == "America/Ensenada") echo 'selected="selected"' ?> ><?php _e('(GMT-08:00) Tijuana, Baja California'); ?></option>
	                            <option value="Etc/GMT+8" <?php if($cff_timezone == "Etc/GMT+8") echo 'selected="selected"' ?> ><?php _e('(GMT-08:00) Pitcairn Islands'); ?></option>
	                            <option value="America/Los_Angeles" <?php if($cff_timezone == "America/Los_Angeles") echo 'selected="selected"' ?> ><?php _e('(GMT-08:00) Pacific Time (US & Canada)'); ?></option>
	                            <option value="America/Denver" <?php if($cff_timezone == "America/Denver") echo 'selected="selected"' ?> ><?php _e('(GMT-07:00) Mountain Time (US & Canada)'); ?></option>
	                            <option value="America/Chihuahua" <?php if($cff_timezone == "America/Chihuahua") echo 'selected="selected"' ?> ><?php _e('(GMT-07:00) Chihuahua, La Paz, Mazatlan'); ?></option>
	                            <option value="America/Dawson_Creek" <?php if($cff_timezone == "America/Dawson_Creek") echo 'selected="selected"' ?> ><?php _e('(GMT-07:00) Arizona'); ?></option>
	                            <option value="America/Belize" <?php if($cff_timezone == "America/Belize") echo 'selected="selected"' ?> ><?php _e('(GMT-06:00) Saskatchewan, Central America'); ?></option>
	                            <option value="America/Cancun" <?php if($cff_timezone == "America/Cancun") echo 'selected="selected"' ?> ><?php _e('(GMT-06:00) Guadalajara, Mexico City, Monterrey'); ?></option>
	                            <option value="Chile/EasterIsland" <?php if($cff_timezone == "Chile/EasterIsland") echo 'selected="selected"' ?> ><?php _e('(GMT-06:00) Easter Island'); ?></option>
	                            <option value="America/Chicago" <?php if($cff_timezone == "America/Chicago") echo 'selected="selected"' ?> ><?php _e('(GMT-06:00) Central Time (US & Canada)'); ?></option>
	                            <option value="America/New_York" <?php if($cff_timezone == "America/New_York") echo 'selected="selected"' ?> ><?php _e('(GMT-05:00) Eastern Time (US & Canada)'); ?></option>
	                            <option value="America/Havana" <?php if($cff_timezone == "America/Havana") echo 'selected="selected"' ?> ><?php _e('(GMT-05:00) Cuba'); ?></option>
	                            <option value="America/Bogota" <?php if($cff_timezone == "America/Bogota") echo 'selected="selected"' ?> ><?php _e('(GMT-05:00) Bogota, Lima, Quito, Rio Branco'); ?></option>
	                            <option value="America/Caracas" <?php if($cff_timezone == "America/Caracas") echo 'selected="selected"' ?> ><?php _e('(GMT-04:30) Caracas'); ?></option>
	                            <option value="America/Santiago" <?php if($cff_timezone == "America/Santiago") echo 'selected="selected"' ?> ><?php _e('(GMT-04:00) Santiago'); ?></option>
	                            <option value="America/La_Paz" <?php if($cff_timezone == "America/La_Paz") echo 'selected="selected"' ?> ><?php _e('(GMT-04:00) La Paz'); ?></option>
	                            <option value="Atlantic/Stanley" <?php if($cff_timezone == "Atlantic/Stanley") echo 'selected="selected"' ?> ><?php _e('(GMT-04:00) Faukland Islands'); ?></option>
	                            <option value="America/Campo_Grande" <?php if($cff_timezone == "America/Campo_Grande") echo 'selected="selected"' ?> ><?php _e('(GMT-04:00) Brazil'); ?></option>
	                            <option value="America/Goose_Bay" <?php if($cff_timezone == "America/Goose_Bay") echo 'selected="selected"' ?> ><?php _e('(GMT-04:00) Atlantic Time (Goose Bay)'); ?></option>
	                            <option value="America/Glace_Bay" <?php if($cff_timezone == "America/Glace_Bay") echo 'selected="selected"' ?> ><?php _e('(GMT-04:00) Atlantic Time (Canada)'); ?></option>
	                            <option value="America/St_Johns" <?php if($cff_timezone == "America/St_Johns") echo 'selected="selected"' ?> ><?php _e('(GMT-03:30) Newfoundland'); ?></option>
	                            <option value="America/Araguaina" <?php if($cff_timezone == "America/Araguaina") echo 'selected="selected"' ?> ><?php _e('(GMT-03:00) UTC-3'); ?></option>
	                            <option value="America/Montevideo" <?php if($cff_timezone == "America/Montevideo") echo 'selected="selected"' ?> ><?php _e('(GMT-03:00) Montevideo'); ?></option>
	                            <option value="America/Miquelon" <?php if($cff_timezone == "America/Miquelon") echo 'selected="selected"' ?> ><?php _e('(GMT-03:00) Miquelon, St. Pierre'); ?></option>
	                            <option value="America/Godthab" <?php if($cff_timezone == "America/Godthab") echo 'selected="selected"' ?> ><?php _e('(GMT-03:00) Greenland'); ?></option>
	                            <option value="America/Argentina/Buenos_Aires" <?php if($cff_timezone == "America/Argentina/Buenos_Aires") echo 'selected="selected"' ?> ><?php _e('(GMT-03:00) Buenos Aires'); ?></option>
	                            <option value="America/Sao_Paulo" <?php if($cff_timezone == "America/Sao_Paulo") echo 'selected="selected"' ?> ><?php _e('(GMT-03:00) Brasilia'); ?></option>
	                            <option value="America/Noronha" <?php if($cff_timezone == "America/Noronha") echo 'selected="selected"' ?> ><?php _e('(GMT-02:00) Mid-Atlantic'); ?></option>
	                            <option value="Atlantic/Cape_Verde" <?php if($cff_timezone == "Atlantic/Cape_Verde") echo 'selected="selected"' ?> ><?php _e('(GMT-01:00) Cape Verde Is.'); ?></option>
	                            <option value="Atlantic/Azores" <?php if($cff_timezone == "Atlantic/Azores") echo 'selected="selected"' ?> ><?php _e('(GMT-01:00) Azores'); ?></option>
	                            <option value="Europe/Belfast" <?php if($cff_timezone == "Europe/Belfast") echo 'selected="selected"' ?> ><?php _e('(GMT) Greenwich Mean Time : Belfast'); ?></option>
	                            <option value="Europe/Dublin" <?php if($cff_timezone == "Europe/Dublin") echo 'selected="selected"' ?> ><?php _e('(GMT) Greenwich Mean Time : Dublin'); ?></option>
	                            <option value="Europe/Lisbon" <?php if($cff_timezone == "Europe/Lisbon") echo 'selected="selected"' ?> ><?php _e('(GMT) Greenwich Mean Time : Lisbon'); ?></option>
	                            <option value="Europe/London" <?php if($cff_timezone == "Europe/London") echo 'selected="selected"' ?> ><?php _e('(GMT) Greenwich Mean Time : London'); ?></option>
	                            <option value="Africa/Abidjan" <?php if($cff_timezone == "Africa/Abidjan") echo 'selected="selected"' ?> ><?php _e('(GMT) Monrovia, Reykjavik'); ?></option>
	                            <option value="Europe/Amsterdam" <?php if($cff_timezone == "Europe/Amsterdam") echo 'selected="selected"' ?> ><?php _e('(GMT+01:00) Amsterdam, Berlin, Bern, Rome, Stockholm, Vienna'); ?></option>
	                            <option value="Europe/Belgrade" <?php if($cff_timezone == "Europe/Belgrade") echo 'selected="selected"' ?> ><?php _e('(GMT+01:00) Belgrade, Bratislava, Budapest, Ljubljana, Prague'); ?></option>
	                            <option value="Europe/Brussels" <?php if($cff_timezone == "Europe/Brussels") echo 'selected="selected"' ?> ><?php _e('(GMT+01:00) Brussels, Copenhagen, Madrid, Paris'); ?></option>
	                            <option value="Africa/Algiers" <?php if($cff_timezone == "Africa/Algiers") echo 'selected="selected"' ?> ><?php _e('(GMT+01:00) West Central Africa'); ?></option>
	                            <option value="Africa/Windhoek" <?php if($cff_timezone == "Africa/Windhoek") echo 'selected="selected"' ?> ><?php _e('(GMT+01:00) Windhoek'); ?></option>
	                            <option value="Asia/Beirut" <?php if($cff_timezone == "Asia/Beirut") echo 'selected="selected"' ?> ><?php _e('(GMT+02:00) Beirut'); ?></option>
	                            <option value="Africa/Cairo" <?php if($cff_timezone == "Africa/Cairo") echo 'selected="selected"' ?> ><?php _e('(GMT+02:00) Cairo'); ?></option>
	                            <option value="Asia/Gaza" <?php if($cff_timezone == "Asia/Gaza") echo 'selected="selected"' ?> ><?php _e('(GMT+02:00) Gaza'); ?></option>
	                            <option value="Africa/Blantyre" <?php if($cff_timezone == "Africa/Blantyre") echo 'selected="selected"' ?> ><?php _e('(GMT+02:00) Harare, Pretoria'); ?></option>
	                            <option value="Asia/Jerusalem" <?php if($cff_timezone == "Asia/Jerusalem") echo 'selected="selected"' ?> ><?php _e('(GMT+02:00) Jerusalem'); ?></option>
	                            <option value="Europe/Helsinki" <?php if($cff_timezone == "Europe/Helsinki") echo 'selected="selected"' ?> ><?php _e('(GMT+02:00) Helsinki'); ?></option>
	                            <option value="Europe/Minsk" <?php if($cff_timezone == "Europe/Minsk") echo 'selected="selected"' ?> ><?php _e('(GMT+02:00) Minsk'); ?></option>
	                            <option value="Asia/Damascus" <?php if($cff_timezone == "Asia/Damascus") echo 'selected="selected"' ?> ><?php _e('(GMT+02:00) Syria'); ?></option>
	                            <option value="Europe/Moscow" <?php if($cff_timezone == "Europe/Moscow") echo 'selected="selected"' ?> ><?php _e('(GMT+03:00) Moscow, St. Petersburg, Volgograd'); ?></option>
	                            <option value="Africa/Addis_Ababa" <?php if($cff_timezone == "Africa/Addis_Ababa") echo 'selected="selected"' ?> ><?php _e('(GMT+03:00) Nairobi'); ?></option>
	                            <option value="Asia/Tehran" <?php if($cff_timezone == "Asia/Tehran") echo 'selected="selected"' ?> ><?php _e('(GMT+03:30) Tehran'); ?></option>
	                            <option value="Asia/Dubai" <?php if($cff_timezone == "Asia/Dubai") echo 'selected="selected"' ?> ><?php _e('(GMT+04:00) Abu Dhabi, Muscat'); ?></option>
	                            <option value="Asia/Yerevan" <?php if($cff_timezone == "Asia/Yerevan") echo 'selected="selected"' ?> ><?php _e('(GMT+04:00) Yerevan'); ?></option>
	                            <option value="Asia/Kabul" <?php if($cff_timezone == "Asia/Kabul") echo 'selected="selected"' ?> ><?php _e('(GMT+04:30) Kabul'); ?></option>
	                            <option value="Asia/Yekaterinburg" <?php if($cff_timezone == "Asia/Yekaterinburg") echo 'selected="selected"' ?> ><?php _e('(GMT+05:00) Ekaterinburg'); ?></option>
	                            <option value="Asia/Tashkent" <?php if($cff_timezone == "Asia/Tashkent") echo 'selected="selected"' ?> ><?php _e('(GMT+05:00) Tashkent'); ?></option>
	                            <option value="Asia/Kolkata" <?php if($cff_timezone == "Asia/Kolkata") echo 'selected="selected"' ?> ><?php _e('(GMT+05:30) Chennai, Kolkata, Mumbai, New Delhi'); ?></option>
	                            <option value="Asia/Katmandu" <?php if($cff_timezone == "Asia/Katmandu") echo 'selected="selected"' ?> ><?php _e('(GMT+05:45) Kathmandu'); ?></option>
	                            <option value="Asia/Dhaka" <?php if($cff_timezone == "Asia/Dhaka") echo 'selected="selected"' ?> ><?php _e('(GMT+06:00) Astana, Dhaka'); ?></option>
	                            <option value="Asia/Novosibirsk" <?php if($cff_timezone == "Asia/Novosibirsk") echo 'selected="selected"' ?> ><?php _e('(GMT+06:00) Novosibirsk'); ?></option>
	                            <option value="Asia/Rangoon" <?php if($cff_timezone == "Asia/Rangoon") echo 'selected="selected"' ?> ><?php _e('(GMT+06:30) Yangon (Rangoon)'); ?></option>
	                            <option value="Asia/Bangkok" <?php if($cff_timezone == "Asia/Bangkok") echo 'selected="selected"' ?> ><?php _e('(GMT+07:00) Bangkok, Hanoi, Jakarta'); ?></option>
	                            <option value="Asia/Krasnoyarsk" <?php if($cff_timezone == "Asia/Krasnoyarsk") echo 'selected="selected"' ?> ><?php _e('(GMT+07:00) Krasnoyarsk'); ?></option>
	                            <option value="Asia/Hong_Kong" <?php if($cff_timezone == "Asia/Hong_Kong") echo 'selected="selected"' ?> ><?php _e('(GMT+08:00) Beijing, Chongqing, Hong Kong, Urumqi'); ?></option>
	                            <option value="Asia/Irkutsk" <?php if($cff_timezone == "Asia/Irkutsk") echo 'selected="selected"' ?> ><?php _e('(GMT+08:00) Irkutsk, Ulaan Bataar'); ?></option>
	                            <option value="Australia/Perth" <?php if($cff_timezone == "Australia/Perth") echo 'selected="selected"' ?> ><?php _e('(GMT+08:00) Perth'); ?></option>
	                            <option value="Australia/Eucla" <?php if($cff_timezone == "Australia/Eucla") echo 'selected="selected"' ?> ><?php _e('(GMT+08:45) Eucla'); ?></option>
	                            <option value="Asia/Tokyo" <?php if($cff_timezone == "Asia/Tokyo") echo 'selected="selected"' ?> ><?php _e('(GMT+09:00) Osaka, Sapporo, Tokyo'); ?></option>
	                            <option value="Asia/Seoul" <?php if($cff_timezone == "Asia/Seoul") echo 'selected="selected"' ?> ><?php _e('(GMT+09:00) Seoul'); ?></option>
	                            <option value="Asia/Yakutsk" <?php if($cff_timezone == "Asia/Yakutsk") echo 'selected="selected"' ?> ><?php _e('(GMT+09:00) Yakutsk'); ?></option>
	                            <option value="Australia/Adelaide" <?php if($cff_timezone == "Australia/Adelaide") echo 'selected="selected"' ?> ><?php _e('(GMT+09:30) Adelaide'); ?></option>
	                            <option value="Australia/Darwin" <?php if($cff_timezone == "Australia/Darwin") echo 'selected="selected"' ?> ><?php _e('(GMT+09:30) Darwin'); ?></option>
	                            <option value="Australia/Brisbane" <?php if($cff_timezone == "Australia/Brisbane") echo 'selected="selected"' ?> ><?php _e('(GMT+10:00) Brisbane'); ?></option>
	                            <option value="Australia/Hobart" <?php if($cff_timezone == "Australia/Hobart") echo 'selected="selected"' ?> ><?php _e('(GMT+10:00) Hobart'); ?></option>
	                            <option value="Asia/Vladivostok" <?php if($cff_timezone == "Asia/Vladivostok") echo 'selected="selected"' ?> ><?php _e('(GMT+10:00) Vladivostok'); ?></option>
	                            <option value="Australia/Lord_Howe" <?php if($cff_timezone == "Australia/Lord_Howe") echo 'selected="selected"' ?> ><?php _e('(GMT+10:30) Lord Howe Island'); ?></option>
	                            <option value="Etc/GMT-11" <?php if($cff_timezone == "Etc/GMT-11") echo 'selected="selected"' ?> ><?php _e('(GMT+11:00) Solomon Is., New Caledonia'); ?></option>
	                            <option value="Asia/Magadan" <?php if($cff_timezone == "Asia/Magadan") echo 'selected="selected"' ?> ><?php _e('(GMT+11:00) Magadan'); ?></option>
	                            <option value="Pacific/Norfolk" <?php if($cff_timezone == "Pacific/Norfolk") echo 'selected="selected"' ?> ><?php _e('(GMT+11:30) Norfolk Island'); ?></option>
	                            <option value="Asia/Anadyr" <?php if($cff_timezone == "Asia/Anadyr") echo 'selected="selected"' ?> ><?php _e('(GMT+12:00) Anadyr, Kamchatka'); ?></option>
	                            <option value="Pacific/Auckland" <?php if($cff_timezone == "Pacific/Auckland") echo 'selected="selected"' ?> ><?php _e('(GMT+12:00) Auckland, Wellington'); ?></option>
	                            <option value="Etc/GMT-12" <?php if($cff_timezone == "Etc/GMT-12") echo 'selected="selected"' ?> ><?php _e('(GMT+12:00) Fiji, Kamchatka, Marshall Is.'); ?></option>
	                            <option value="Pacific/Chatham" <?php if($cff_timezone == "Pacific/Chatham") echo 'selected="selected"' ?> ><?php _e('(GMT+12:45) Chatham Islands'); ?></option>
	                            <option value="Pacific/Tongatapu" <?php if($cff_timezone == "Pacific/Tongatapu") echo 'selected="selected"' ?> ><?php _e('(GMT+13:00) Nuku\'alofa'); ?></option>
	                            <option value="Pacific/Kiritimati" <?php if($cff_timezone == "Pacific/Kiritimati") echo 'selected="selected"' ?> ><?php _e('(GMT+14:00) Kiritimati'); ?></option>
	                        </select>
	                    </td>
	                </tr>

	                <tr>
	                    <th class="bump-left"><label for="cff_date_custom" class="bump-left"><?php _e('Custom Format'); ?></label><code class="cff_shortcode"> datecustom
	            Eg: datecustom='D M jS, Y'</code></th>
	                    <td>
	                        <input name="cff_date_custom" type="text" value="<?php esc_attr_e( $cff_date_custom ); ?>" size="10" placeholder="Eg. F j, Y" />
	                        <a href="http://smashballoon.com/custom-facebook-feed/docs/date/" class="cff-external-link" target="_blank"><?php _e('Examples'); ?></a>
	                    </td>
	                </tr>
	                <tr>
	                    <th class="bump-left"><label for="cff_date_before" class="bump-left"><?php _e('Text Before Date'); ?></label><code class="cff_shortcode"> beforedate
	            Eg: beforedate='Posted'</code></th>
	                    <td>
	                        <input name="cff_date_before" type="text" value="<?php esc_attr_e( $cff_date_before ); ?>" size="20" placeholder="Eg. Posted" />
	                        <a class="cff-tooltip-link" href="JavaScript:void(0);"><i class="fa fa-question-circle" aria-hidden="true"></i></a>
	                        <p class="cff-tooltip cff-more-info"><?php _e('You can add custom text here to display immediately <b>before</b> the date text'); ?></p>
	                    </td>
	                </tr>
	                <tr>
	                    <th class="bump-left"><label for="cff_date_after" class="bump-left"><?php _e('Text After Date'); ?></label><code class="cff_shortcode"> afterdate
	            Eg: afterdate='Ago'</code></th>
	                    <td>
	                        <input name="cff_date_after" type="text" value="<?php esc_attr_e( $cff_date_after ); ?>" size="20" placeholder="Eg. by ___" />
	                        <a class="cff-tooltip-link" href="JavaScript:void(0);"><i class="fa fa-question-circle" aria-hidden="true"></i></a>
	                        <p class="cff-tooltip cff-more-info"><?php _e('You can add custom text here to display immediately <b>after</b> the date text'); ?></p>
	                    </td>
	                </tr>
	                <tr id="links"><!-- Quick link --></tr>
	                </tbody>
	            </table>

	            <hr />


	            <h3><?php _e('Shared Link Boxes'); ?></h3>
	            <table class="form-table">
	                <tbody>

	                    <tr class="cff-settings-row-header"><th>Box Style</th></tr>
	                    <tr>
	                        <th class="bump-left"><label for="cff_link_bg_color" class="bump-left"><?php _e('Link Box Background Color'); ?></label><code class="cff_shortcode"> linkbgcolor
	            Eg: linkbgcolor='EEE'</code></th>
	                        <td>
	                            <input name="cff_link_bg_color" value="#<?php esc_attr_e( str_replace('#', '', $cff_link_bg_color) ); ?>" class="cff-colorpicker" />
	                        </td>
	                    </tr>

	                    <tr>
	                        <th class="bump-left"><label for="cff_link_border_color" class="bump-left"><?php _e('Link Box Border Color'); ?></label><code class="cff_shortcode"> linkbordercolor
	            Eg: linkbordercolor='CCC'</code></th>
	                        <td>
	                            <input name="cff_link_border_color" value="#<?php esc_attr_e( str_replace('#', '', $cff_link_border_color) ); ?>" class="cff-colorpicker" />
	                        </td>
	                    </tr>

	                    <tr>
	                        <th class="bump-left"><label for="cff_disable_link_box" class="bump-left"><?php _e('Remove Background/Border'); ?></label><code class="cff_shortcode"> disablelinkbox
	            Eg: disablelinkbox=true</code></th>
	                        <td><input type="checkbox" name="cff_disable_link_box" id="cff_disable_link_box" <?php if($cff_disable_link_box == true) echo 'checked="checked"' ?> /></td>
	                    </tr>

	                    <tr class="cff-settings-row-header"><th>Link Title</th></tr>
	                    <tr>
	                        <th class="bump-left"><label for="cff_link_title_format" class="bump-left"><?php _e('Link Title Format'); ?></label><code class="cff_shortcode"> linktitleformat
	            Eg: linktitleformat='h3'</code></th>
	                        <td>
	                            <select name="cff_link_title_format" class="cff-text-size-setting">
	                                <option value="p" <?php if($cff_link_title_format == "p") echo 'selected="selected"' ?> >Paragraph</option>
	                                <option value="h3" <?php if($cff_link_title_format == "h3") echo 'selected="selected"' ?> >Heading 3</option>
	                                <option value="h4" <?php if($cff_link_title_format == "h4") echo 'selected="selected"' ?> >Heading 4</option>
	                                <option value="h5" <?php if($cff_link_title_format == "h5") echo 'selected="selected"' ?> >Heading 5</option>
	                                <option value="h6" <?php if($cff_link_title_format == "h6") echo 'selected="selected"' ?> >Heading 6</option>
	                            </select>
	                        </td>
	                    </tr>
	                    <tr>
	                        <th class="bump-left"><label for="cff_link_title_size" class="bump-left"><?php _e('Link Title Size'); ?></label><code class="cff_shortcode"> linktitlesize
	            Eg: linktitlesize='18'</code></th>
	                        <td>
	                            <select name="cff_link_title_size" class="cff-text-size-setting">
	                                <option value="inherit" <?php if($cff_link_title_size == "inherit") echo 'selected="selected"' ?> >Inherit from theme</option>
	                                <option value="10" <?php if($cff_link_title_size == "10") echo 'selected="selected"' ?> >10px</option>
	                                <option value="11" <?php if($cff_link_title_size == "11") echo 'selected="selected"' ?> >11px</option>
	                                <option value="12" <?php if($cff_link_title_size == "12") echo 'selected="selected"' ?> >12px</option>
	                                <option value="13" <?php if($cff_link_title_size == "13") echo 'selected="selected"' ?> >13px</option>
	                                <option value="14" <?php if($cff_link_title_size == "14") echo 'selected="selected"' ?> >14px</option>
	                                <option value="16" <?php if($cff_link_title_size == "16") echo 'selected="selected"' ?> >16px</option>
	                                <option value="18" <?php if($cff_link_title_size == "18") echo 'selected="selected"' ?> >18px</option>
	                                <option value="20" <?php if($cff_link_title_size == "20") echo 'selected="selected"' ?> >20px</option>
	                                <option value="24" <?php if($cff_link_title_size == "24") echo 'selected="selected"' ?> >24px</option>
	                                <option value="28" <?php if($cff_link_title_size == "28") echo 'selected="selected"' ?> >28px</option>
	                                <option value="32" <?php if($cff_link_title_size == "32") echo 'selected="selected"' ?> >32px</option>
	                                <option value="36" <?php if($cff_link_title_size == "36") echo 'selected="selected"' ?> >36px</option>
	                                <option value="42" <?php if($cff_link_title_size == "42") echo 'selected="selected"' ?> >42px</option>
	                                <option value="48" <?php if($cff_link_title_size == "48") echo 'selected="selected"' ?> >48px</option>
	                                <option value="54" <?php if($cff_link_title_size == "54") echo 'selected="selected"' ?> >54px</option>
	                                <option value="60" <?php if($cff_link_title_size == "60") echo 'selected="selected"' ?> >60px</option>
	                            </select>
	                        </td>
	                    </tr>
	                    <tr>
	                        <th class="bump-left"><label for="cff_link_title_color" class="bump-left"><?php _e('Link Title Color'); ?></label><code class="cff_shortcode"> linktitlecolor
	            Eg: linktitlecolor='ff0000'</code></th>
	                        <td>
	                            <input name="cff_link_title_color" value="#<?php esc_attr_e( str_replace('#', '', $cff_link_title_color) ); ?>" class="cff-colorpicker" />
	                        </td>
	                    </tr>

	                    <tr class="cff-settings-row-header"><th>Link URL</th></tr>
	                    <tr>
	                        <th class="bump-left"><label for="cff_link_url_size" class="bump-left"><?php _e('Link URL Size'); ?></label><code class="cff_shortcode"> linkurlsize
	            Eg: linkurlsize='12'</code></th>
	                        <td>
	                            <select name="cff_link_url_size" class="cff-text-size-setting">
	                                <option value="inherit" <?php if($cff_link_url_size == "inherit") echo 'selected="selected"' ?> >Inherit from theme</option>
	                                <option value="10" <?php if($cff_link_url_size == "10") echo 'selected="selected"' ?> >10px</option>
	                                <option value="11" <?php if($cff_link_url_size == "11") echo 'selected="selected"' ?> >11px</option>
	                                <option value="12" <?php if($cff_link_url_size == "12") echo 'selected="selected"' ?> >12px</option>
	                                <option value="13" <?php if($cff_link_url_size == "13") echo 'selected="selected"' ?> >13px</option>
	                                <option value="14" <?php if($cff_link_url_size == "14") echo 'selected="selected"' ?> >14px</option>
	                                <option value="16" <?php if($cff_link_url_size == "16") echo 'selected="selected"' ?> >16px</option>
	                                <option value="18" <?php if($cff_link_url_size == "18") echo 'selected="selected"' ?> >18px</option>
	                                <option value="20" <?php if($cff_link_url_size == "20") echo 'selected="selected"' ?> >20px</option>
	                                <option value="24" <?php if($cff_link_url_size == "24") echo 'selected="selected"' ?> >24px</option>
	                                <option value="28" <?php if($cff_link_url_size == "28") echo 'selected="selected"' ?> >28px</option>
	                                <option value="32" <?php if($cff_link_url_size == "32") echo 'selected="selected"' ?> >32px</option>
	                                <option value="36" <?php if($cff_link_url_size == "36") echo 'selected="selected"' ?> >36px</option>
	                                <option value="42" <?php if($cff_link_url_size == "42") echo 'selected="selected"' ?> >42px</option>
	                                <option value="48" <?php if($cff_link_url_size == "48") echo 'selected="selected"' ?> >48px</option>
	                                <option value="54" <?php if($cff_link_url_size == "54") echo 'selected="selected"' ?> >54px</option>
	                                <option value="60" <?php if($cff_link_url_size == "60") echo 'selected="selected"' ?> >60px</option>
	                            </select>
	                        </td>
	                    </tr>
	                    <tr>
	                        <th class="bump-left"><label for="cff_link_url_color" class="bump-left"><?php _e('Link URL Color'); ?></label><code class="cff_shortcode"> linkurlcolor
	            Eg: linkurlcolor='999999'</code></th>
	                        <td>
	                            <input name="cff_link_url_color" value="#<?php esc_attr_e( str_replace('#', '', $cff_link_url_color) ); ?>" class="cff-colorpicker" />
	                        </td>
	                    </tr>

	                    <tr class="cff-settings-row-header"><th>Link Description</th></tr>

	                    <tr>
	                        <th class="bump-left"><label for="cff_link_desc_size" class="bump-left"><?php _e('Link Description Size'); ?></label><code class="cff_shortcode"> linkdescsize
	            Eg: linkdescsize='14'</code></th>
	                        <td>
	                            <select name="cff_link_desc_size" class="cff-text-size-setting">
	                                <option value="inherit" <?php if($cff_link_desc_size == "inherit") echo 'selected="selected"' ?> >Inherit from theme</option>
	                                <option value="10" <?php if($cff_link_desc_size == "10") echo 'selected="selected"' ?> >10px</option>
	                                <option value="11" <?php if($cff_link_desc_size == "11") echo 'selected="selected"' ?> >11px</option>
	                                <option value="12" <?php if($cff_link_desc_size == "12") echo 'selected="selected"' ?> >12px</option>
	                                <option value="13" <?php if($cff_link_desc_size == "13") echo 'selected="selected"' ?> >13px</option>
	                                <option value="14" <?php if($cff_link_desc_size == "14") echo 'selected="selected"' ?> >14px</option>
	                                <option value="16" <?php if($cff_link_desc_size == "16") echo 'selected="selected"' ?> >16px</option>
	                                <option value="18" <?php if($cff_link_desc_size == "18") echo 'selected="selected"' ?> >18px</option>
	                                <option value="20" <?php if($cff_link_desc_size == "20") echo 'selected="selected"' ?> >20px</option>
	                                <option value="24" <?php if($cff_link_desc_size == "24") echo 'selected="selected"' ?> >24px</option>
	                                <option value="28" <?php if($cff_link_desc_size == "28") echo 'selected="selected"' ?> >28px</option>
	                                <option value="32" <?php if($cff_link_desc_size == "32") echo 'selected="selected"' ?> >32px</option>
	                                <option value="36" <?php if($cff_link_desc_size == "36") echo 'selected="selected"' ?> >36px</option>
	                                <option value="42" <?php if($cff_link_desc_size == "42") echo 'selected="selected"' ?> >42px</option>
	                                <option value="48" <?php if($cff_link_desc_size == "48") echo 'selected="selected"' ?> >48px</option>
	                                <option value="54" <?php if($cff_link_desc_size == "54") echo 'selected="selected"' ?> >54px</option>
	                                <option value="60" <?php if($cff_link_desc_size == "60") echo 'selected="selected"' ?> >60px</option>
	                            </select>
	                        </td>
	                    </tr>

	                    <tr>
	                        <th class="bump-left"><label for="cff_link_desc_color" class="bump-left"><?php _e('Link Description Color'); ?></label><code class="cff_shortcode"> linkdesccolor
	            Eg: linkdesccolor='ff0000'</code></th>
	                        <td>
	                            <input name="cff_link_desc_color" value="#<?php esc_attr_e( str_replace('#', '', $cff_link_desc_color) ); ?>" class="cff-colorpicker" />
	                        </td>
	                    </tr>

	                    <tr valign="top">
	                        <th class="bump-left" scope="row"><label class="bump-left"><?php _e('Maximum Link Description Length'); ?></label><code class="cff_shortcode"> desclength
	            Eg: desclength=150</code></th>
	                        <td>
	                            <input name="cff_body_length" type="text" value="<?php esc_attr_e( $cff_body_length_val ); ?>" size="4" /><span class="cff-pixel-label"><?php _e('Characters'); ?></span> <i style="color: #666; font-size: 11px; margin-left: 5px;"><?php _e('Eg. 200'); ?></i>
	                            <a class="cff-tooltip-link" href="JavaScript:void(0);"><i class="fa fa-question-circle" aria-hidden="true"></i></a>
	                            <p class="cff-tooltip cff-more-info"><?php _e("If the link description text exceeds this length then it will be truncated with an ellipsis. Leave empty to set no maximum length."); ?></p>
	                        </td>
	                    </tr>
	                    <tr id="eventtitle"><!-- Quick link --></tr>
	                </tbody>
	            </table>

	            <div style="margin-top: -15px;">
	                <?php submit_button(); ?>
	            </div>
	            <hr />

	            <h3><?php _e('Event Title'); ?></h3>
	            <table class="form-table">
	                <tbody>
	                    <tr>
	                        <th class="bump-left"><label for="cff_event_title_format" class="bump-left"><?php _e('Format'); ?></label><code class="cff_shortcode"> eventtitleformat
	                Eg: eventtitleformat=h5</code></th>
	                        <td>
	                            <select name="cff_event_title_format" class="cff-text-size-setting">
	                                <option value="p" <?php if($cff_event_title_format == "p") echo 'selected="selected"' ?> >Paragraph</option>
	                                <option value="h3" <?php if($cff_event_title_format == "h3") echo 'selected="selected"' ?> >Heading 3</option>
	                                <option value="h4" <?php if($cff_event_title_format == "h4") echo 'selected="selected"' ?> >Heading 4</option>
	                                <option value="h5" <?php if($cff_event_title_format == "h5") echo 'selected="selected"' ?> >Heading 5</option>
	                                <option value="h6" <?php if($cff_event_title_format == "h6") echo 'selected="selected"' ?> >Heading 6</option>
	                            </select>
	                        </td>
	                    </tr>

	                    <tr>
	                        <th class="bump-left"><label for="cff_event_title_size" class="bump-left"><?php _e('Text Size'); ?></label><code class="cff_shortcode"> eventtitlesize
	                Eg: eventtitlesize=12</code></th>
	                        <td>
	                            <select name="cff_event_title_size" class="cff-text-size-setting">
	                                <option value="inherit" <?php if($cff_event_title_size == "inherit") echo 'selected="selected"' ?> >Inherit from theme</option>
	                                <option value="10" <?php if($cff_event_title_size == "10") echo 'selected="selected"' ?> >10px</option>
	                                <option value="11" <?php if($cff_event_title_size == "11") echo 'selected="selected"' ?> >11px</option>
	                                <option value="12" <?php if($cff_event_title_size == "12") echo 'selected="selected"' ?> >12px</option>
	                                <option value="13" <?php if($cff_event_title_size == "13") echo 'selected="selected"' ?> >13px</option>
	                                <option value="14" <?php if($cff_event_title_size == "14") echo 'selected="selected"' ?> >14px</option>
	                                <option value="16" <?php if($cff_event_title_size == "16") echo 'selected="selected"' ?> >16px</option>
	                                <option value="18" <?php if($cff_event_title_size == "18") echo 'selected="selected"' ?> >18px</option>
	                                <option value="20" <?php if($cff_event_title_size == "20") echo 'selected="selected"' ?> >20px</option>
	                                <option value="24" <?php if($cff_event_title_size == "24") echo 'selected="selected"' ?> >24px</option>
	                                <option value="28" <?php if($cff_event_title_size == "28") echo 'selected="selected"' ?> >28px</option>
	                                <option value="32" <?php if($cff_event_title_size == "32") echo 'selected="selected"' ?> >32px</option>
	                                <option value="36" <?php if($cff_event_title_size == "36") echo 'selected="selected"' ?> >36px</option>
	                                <option value="42" <?php if($cff_event_title_size == "42") echo 'selected="selected"' ?> >42px</option>
	                                <option value="48" <?php if($cff_event_title_size == "48") echo 'selected="selected"' ?> >48px</option>
	                                <option value="54" <?php if($cff_event_title_size == "54") echo 'selected="selected"' ?> >54px</option>
	                                <option value="60" <?php if($cff_event_title_size == "60") echo 'selected="selected"' ?> >60px</option>
	                            </select>
	                        </td>
	                    </tr>
	                    <tr>
	                        <th class="bump-left"><label for="cff_event_title_weight" class="bump-left"><?php _e('Text Weight'); ?></label><code class="cff_shortcode"> eventtitleweight
	                Eg: eventtitleweight=bold</code></th>
	                        <td>
	                            <select name="cff_event_title_weight" class="cff-text-size-setting">
	                                <option value="inherit" <?php if($cff_event_title_weight == "inherit") echo 'selected="selected"' ?> >Inherit from theme</option>
	                                <option value="normal" <?php if($cff_event_title_weight == "normal") echo 'selected="selected"' ?> >Normal</option>
	                                <option value="bold" <?php if($cff_event_title_weight == "bold") echo 'selected="selected"' ?> >Bold</option>
	                            </select>
	                        </td>
	                    </tr>
	                    <tr>
	                        <th class="bump-left"><label for="cff_event_title_color" class="bump-left"><?php _e('Text Color'); ?></label><code class="cff_shortcode"> eventtitlecolor
	                Eg: eventtitlecolor=666</code></th>
	                        <td>
	                            <input name="cff_event_title_color" value="#<?php esc_attr_e( str_replace('#', '', $cff_event_title_color) ); ?>" class="cff-colorpicker" />
	                        </td>
	                    </tr>
	                    <tr>
	                        <th class="bump-left"><label for="cff_event_title_link" class="bump-left"><?php _e('Link Title to Event on Facebook'); ?></label><code class="cff_shortcode"> eventtitlelink
	                Eg: eventtitlelink=true</code></th>
	                        <td><input type="checkbox" name="cff_event_title_link" id="cff_event_title_link" <?php if($cff_event_title_link == true) echo 'checked="checked"' ?> /></td>
	                    </tr>
	                    <tr id="eventdate"><!-- Quick link --></tr>
	                </tbody>
	            </table>
	            <hr />

	            <h3><?php _e('Event Date'); ?></h3>
	            <table class="form-table">
	                <tbody>
	                    <tr>
	                        <th class="bump-left"><label for="cff_event_date_size" class="bump-left"><?php _e('Text Size'); ?></label><code class="cff_shortcode"> eventdatesize
	                Eg: eventdatesize=18</code></th>
	                        <td>
	                            <select name="cff_event_date_size" class="cff-text-size-setting">
	                                <option value="inherit" <?php if($cff_event_date_size == "inherit") echo 'selected="selected"' ?> >Inherit from theme</option>
	                                <option value="10" <?php if($cff_event_date_size == "10") echo 'selected="selected"' ?> >10px</option>
	                                <option value="11" <?php if($cff_event_date_size == "11") echo 'selected="selected"' ?> >11px</option>
	                                <option value="12" <?php if($cff_event_date_size == "12") echo 'selected="selected"' ?> >12px</option>
	                                <option value="13" <?php if($cff_event_date_size == "13") echo 'selected="selected"' ?> >13px</option>
	                                <option value="14" <?php if($cff_event_date_size == "14") echo 'selected="selected"' ?> >14px</option>
	                                <option value="16" <?php if($cff_event_date_size == "16") echo 'selected="selected"' ?> >16px</option>
	                                <option value="18" <?php if($cff_event_date_size == "18") echo 'selected="selected"' ?> >18px</option>
	                                <option value="20" <?php if($cff_event_date_size == "20") echo 'selected="selected"' ?> >20px</option>
	                                <option value="24" <?php if($cff_event_date_size == "24") echo 'selected="selected"' ?> >24px</option>
	                                <option value="28" <?php if($cff_event_date_size == "28") echo 'selected="selected"' ?> >28px</option>
	                                <option value="32" <?php if($cff_event_date_size == "32") echo 'selected="selected"' ?> >32px</option>
	                                <option value="36" <?php if($cff_event_date_size == "36") echo 'selected="selected"' ?> >36px</option>
	                                <option value="42" <?php if($cff_event_date_size == "42") echo 'selected="selected"' ?> >42px</option>
	                                <option value="48" <?php if($cff_event_date_size == "48") echo 'selected="selected"' ?> >48px</option>
	                                <option value="54" <?php if($cff_event_date_size == "54") echo 'selected="selected"' ?> >54px</option>
	                                <option value="60" <?php if($cff_event_date_size == "60") echo 'selected="selected"' ?> >60px</option>
	                            </select>
	                        </td>
	                    </tr>
	                    <tr>
	                        <th class="bump-left"><label for="cff_event_date_weight" class="bump-left"><?php _e('Text Weight'); ?></label><code class="cff_shortcode"> eventdateweight
	                Eg: eventdateweight=bold</code></th>
	                        <td>
	                            <select name="cff_event_date_weight" class="cff-text-size-setting">
	                                <option value="inherit" <?php if($cff_event_date_weight == "inherit") echo 'selected="selected"' ?> >Inherit from theme</option>
	                                <option value="normal" <?php if($cff_event_date_weight == "normal") echo 'selected="selected"' ?> >Normal</option>
	                                <option value="bold" <?php if($cff_event_date_weight == "bold") echo 'selected="selected"' ?> >Bold</option>
	                            </select>
	                        </td>
	                    </tr>
	                    <tr>
	                        <th class="bump-left"><label for="cff_event_date_color" class="bump-left"><?php _e('Text Color'); ?></label><code class="cff_shortcode"> eventdatecolor
	                Eg: eventdatecolor=EB6A00</code></th>
	                        <td>
	                            <input name="cff_event_date_color" value="#<?php esc_attr_e( str_replace('#', '', $cff_event_date_color) ); ?>" class="cff-colorpicker" />
	                        </td>
	                    </tr>
	                    <tr valign="top">
	                        <th class="bump-left" scope="row"><label class="bump-left"><?php _e('Date Position'); ?></label><code class="cff_shortcode"> eventdatepos
	                Eg: eventdatepos=below</code></th>
	                        <td>
	                            <select name="cff_event_date_position">
	                                <option value="below" <?php if($cff_event_date_position == "below") echo 'selected="selected"' ?> ><?php _e('Below event title'); ?></option>
	                                <option value="above" <?php if($cff_event_date_position == "above") echo 'selected="selected"' ?> ><?php _e('Above event title'); ?></option>
	                            </select>
	                        </td>
	                    </tr>
	                    <tr>
	                        <th class="bump-left"><label for="cff_event_date_formatting" class="bump-left"><?php _e('Event Date Formatting'); ?></label><code class="cff_shortcode"> eventdateformat
	                Eg: eventdateformat=12</code></th>
	                        <td>
	                            <select name="cff_event_date_formatting" style="width: 280px;">
	                                <?php $original = strtotime('2016-07-25T17:30:00+0000'); ?>
	                                <option value="14" <?php if($cff_event_date_formatting == "14") echo 'selected="selected"' ?> ><?php echo date('M j, g:ia', $original); ?></option>
	                                <option value="15" <?php if($cff_event_date_formatting == "15") echo 'selected="selected"' ?> ><?php echo date('M j, G:i', $original); ?></option>
	                                <option value="1" <?php if($cff_event_date_formatting == "1") echo 'selected="selected"' ?> ><?php echo date('F j, Y, g:ia', $original); ?></option>
	                                <option value="2" <?php if($cff_event_date_formatting == "2") echo 'selected="selected"' ?> ><?php echo date('F jS, g:ia', $original); ?></option>
	                                <option value="3" <?php if($cff_event_date_formatting == "3") echo 'selected="selected"' ?> ><?php echo date('g:ia - F jS', $original); ?></option>
	                                <option value="4" <?php if($cff_event_date_formatting == "4") echo 'selected="selected"' ?> ><?php echo date('g:ia, F jS', $original); ?></option>
	                                <option value="5" <?php if($cff_event_date_formatting == "5") echo 'selected="selected"' ?> ><?php echo date('l F jS - g:ia', $original); ?></option>
	                                <option value="6" <?php if($cff_event_date_formatting == "6") echo 'selected="selected"' ?> ><?php echo date('D M jS, Y, g:iA', $original); ?></option>
	                                <option value="7" <?php if($cff_event_date_formatting == "7") echo 'selected="selected"' ?> ><?php echo date('l F jS, Y, g:iA', $original); ?></option>
	                                <option value="8" <?php if($cff_event_date_formatting == "8") echo 'selected="selected"' ?> ><?php echo date('l F jS, Y - g:ia', $original); ?></option>
	                                <option value="9" <?php if($cff_event_date_formatting == "9") echo 'selected="selected"' ?> ><?php echo date("l M jS, 'y", $original); ?></option>
	                                <option value="10" <?php if($cff_event_date_formatting == "10") echo 'selected="selected"' ?> ><?php echo date('m.d.y - g:iA', $original); ?></option>
	                                <option value="20" <?php if($cff_event_date_formatting == "20") echo 'selected="selected"' ?> ><?php echo date('m.d.y - G:i', $original); ?></option>
	                                <option value="11" <?php if($cff_event_date_formatting == "11") echo 'selected="selected"' ?> ><?php echo date('m/d/y, g:ia', $original); ?></option>
	                                <option value="12" <?php if($cff_event_date_formatting == "12") echo 'selected="selected"' ?> ><?php echo date('d.m.y - g:iA', $original); ?></option>
	                                <option value="21" <?php if($cff_event_date_formatting == "21") echo 'selected="selected"' ?> ><?php echo date('d.m.y - G:i', $original); ?></option>
	                                <option value="13" <?php if($cff_event_date_formatting == "13") echo 'selected="selected"' ?> ><?php echo date('d/m/y, g:ia', $original); ?></option>

	                                <option value="16" <?php if($cff_event_date_formatting == "16") echo 'selected="selected"' ?> ><?php echo date('d-m-Y, G:i', $original); ?></option>
	                                <option value="17" <?php if($cff_event_date_formatting == "17") echo 'selected="selected"' ?> ><?php echo date('jS F Y, G:i', $original); ?></option>
	                                <option value="18" <?php if($cff_event_date_formatting == "18") echo 'selected="selected"' ?> ><?php echo date('d M Y, G:i', $original); ?></option>
	                                <option value="19" <?php if($cff_event_date_formatting == "19") echo 'selected="selected"' ?> ><?php echo date('l jS F Y, G:i', $original); ?></option>
	                            </select>
	                        </td>
	                    </tr>
	                    <tr>
	                        <th class="bump-left"><label for="cff_event_date_custom" class="bump-left"><?php _e('Custom Event Date Format'); ?></label><code class="cff_shortcode"> eventdatecustom
	                Eg: eventdatecustom='D M jS, Y'</code></th>
	                        <td>
	                            <input name="cff_event_date_custom" type="text" value="<?php _e($cff_event_date_custom); ?>" size="10" placeholder="Eg. F j, Y - g:ia" />
	                            <a href="http://smashballoon.com/custom-facebook-feed/docs/date/" class="cff-external-link" target="_blank"><?php _e('Examples'); ?></a>
	                        </td>
	                    </tr>
	                    <tr id="eventdetails"><!-- Quick link --></tr>
	                </tbody>
	            </table>
	            <hr />

	            <h3><?php _e('Event Details'); ?></h3>
	            <table class="form-table">
	                <tbody>
	                    <tr>
	                        <th class="bump-left"><label for="cff_event_details_size" class="bump-left"><?php _e('Text Size'); ?></label><code class="cff_shortcode"> eventdetailssize
	                Eg: eventdetailssize=13</code></th>
	                        <td>
	                            <select name="cff_event_details_size" class="cff-text-size-setting">
	                                <option value="inherit" <?php if($cff_event_details_size == "inherit") echo 'selected="selected"' ?> >Inherit from theme</option>
	                                <option value="10" <?php if($cff_event_details_size == "10") echo 'selected="selected"' ?> >10px</option>
	                                <option value="11" <?php if($cff_event_details_size == "11") echo 'selected="selected"' ?> >11px</option>
	                                <option value="12" <?php if($cff_event_details_size == "12") echo 'selected="selected"' ?> >12px</option>
	                                <option value="13" <?php if($cff_event_details_size == "13") echo 'selected="selected"' ?> >13px</option>
	                                <option value="14" <?php if($cff_event_details_size == "14") echo 'selected="selected"' ?> >14px</option>
	                                <option value="16" <?php if($cff_event_details_size == "16") echo 'selected="selected"' ?> >16px</option>
	                                <option value="18" <?php if($cff_event_details_size == "18") echo 'selected="selected"' ?> >18px</option>
	                                <option value="20" <?php if($cff_event_details_size == "20") echo 'selected="selected"' ?> >20px</option>
	                                <option value="24" <?php if($cff_event_details_size == "24") echo 'selected="selected"' ?> >24px</option>
	                                <option value="28" <?php if($cff_event_details_size == "28") echo 'selected="selected"' ?> >28px</option>
	                                <option value="32" <?php if($cff_event_details_size == "32") echo 'selected="selected"' ?> >32px</option>
	                                <option value="36" <?php if($cff_event_details_size == "36") echo 'selected="selected"' ?> >36px</option>
	                                <option value="42" <?php if($cff_event_details_size == "42") echo 'selected="selected"' ?> >42px</option>
	                                <option value="48" <?php if($cff_event_details_size == "48") echo 'selected="selected"' ?> >48px</option>
	                                <option value="54" <?php if($cff_event_details_size == "54") echo 'selected="selected"' ?> >54px</option>
	                                <option value="60" <?php if($cff_event_details_size == "60") echo 'selected="selected"' ?> >60px</option>
	                            </select>
	                        </td>
	                    </tr>
	                    <tr>
	                        <th class="bump-left"><label for="cff_event_details_weight" class="bump-left"><?php _e('Text Weight'); ?></label><code class="cff_shortcode"> eventdetailsweight
	                Eg: eventdetailsweight=bold</code></th>
	                        <td>
	                            <select name="cff_event_details_weight" class="cff-text-size-setting">
	                                <option value="inherit" <?php if($cff_event_details_weight == "inherit") echo 'selected="selected"' ?> >Inherit from theme</option>
	                                <option value="normal" <?php if($cff_event_details_weight == "normal") echo 'selected="selected"' ?> >Normal</option>
	                                <option value="bold" <?php if($cff_event_details_weight == "bold") echo 'selected="selected"' ?> >Bold</option>
	                            </select>
	                        </td>
	                    </tr>
	                    <tr>
	                        <th class="bump-left"><label for="cff_event_details_color" class="bump-left"><?php _e('Text Color'); ?></label><code class="cff_shortcode"> eventdetailscolor
	                Eg: eventdetailscolor=FFF000</code></th>
	                        <td>
	                            <input name="cff_event_details_color" value="#<?php esc_attr_e( str_replace('#', '', $cff_event_details_color) ); ?>" class="cff-colorpicker" />
	                        </td>
	                    </tr>
	                    <tr>
	                        <th class="bump-left"><label for="cff_event_link_color" class="bump-left"><?php _e('Link Color'); ?></label><code class="cff_shortcode"> eventlinkcolor
	                Eg: eventlinkcolor=333</code></th>
	                        <td>
	                            <input name="cff_event_link_color" value="#<?php esc_attr_e( str_replace('#', '', $cff_event_link_color) ); ?>" class="cff-colorpicker" />
	                        </td>
	                    </tr>
	                    <tr id="comments"><!-- Quick link --></tr>
	                </tbody>
	            </table>

	            <?php submit_button(); ?>

	            <hr />

	            <h3><?php _e('Post Action Links'); ?></span> <a class="cff-tooltip-link" href="JavaScript:void(0);"><?php _e('What is this?'); ?></a>
	            <p class="cff-tooltip cff-more-info"><?php _e('Post action links refer to the "View on Facebook" and "Share" links at the bottom of each post'); ?></p></h3>
	            <table class="form-table">
	                <tbody>
	                    <tr>
	                        <th class="bump-left"><label for="cff_link_size" class="bump-left"><?php _e('Text Size'); ?></label><code class="cff_shortcode"> linksize
	                Eg: linksize=13</code></th>
	                        <td>
	                            <select name="cff_link_size" class="cff-text-size-setting">
	                                <option value="inherit" <?php if($cff_link_size == "inherit") echo 'selected="selected"' ?> >Inherit from theme</option>
	                                <option value="10" <?php if($cff_link_size == "10") echo 'selected="selected"' ?> >10px</option>
	                                <option value="11" <?php if($cff_link_size == "11") echo 'selected="selected"' ?> >11px</option>
	                                <option value="12" <?php if($cff_link_size == "12") echo 'selected="selected"' ?> >12px</option>
	                                <option value="13" <?php if($cff_link_size == "13") echo 'selected="selected"' ?> >13px</option>
	                                <option value="14" <?php if($cff_link_size == "14") echo 'selected="selected"' ?> >14px</option>
	                                <option value="16" <?php if($cff_link_size == "16") echo 'selected="selected"' ?> >16px</option>
	                                <option value="18" <?php if($cff_link_size == "18") echo 'selected="selected"' ?> >18px</option>
	                                <option value="20" <?php if($cff_link_size == "20") echo 'selected="selected"' ?> >20px</option>
	                                <option value="24" <?php if($cff_link_size == "24") echo 'selected="selected"' ?> >24px</option>
	                                <option value="28" <?php if($cff_link_size == "28") echo 'selected="selected"' ?> >28px</option>
	                                <option value="32" <?php if($cff_link_size == "32") echo 'selected="selected"' ?> >32px</option>
	                                <option value="36" <?php if($cff_link_size == "36") echo 'selected="selected"' ?> >36px</option>
	                                <option value="42" <?php if($cff_link_size == "42") echo 'selected="selected"' ?> >42px</option>
	                                <option value="48" <?php if($cff_link_size == "48") echo 'selected="selected"' ?> >48px</option>
	                                <option value="54" <?php if($cff_link_size == "54") echo 'selected="selected"' ?> >54px</option>
	                                <option value="60" <?php if($cff_link_size == "60") echo 'selected="selected"' ?> >60px</option>
	                            </select>
	                        </td>
	                    </tr>
	                    <tr>
	                        <th class="bump-left"><label for="cff_link_weight" class="bump-left"><?php _e('Text Weight'); ?></label><code class="cff_shortcode"> linkweight
	                Eg: linkweight=bold</code></th>
	                        <td>
	                            <select name="cff_link_weight" class="cff-text-size-setting">
	                                <option value="inherit" <?php if($cff_link_weight == "inherit") echo 'selected="selected"' ?> >Inherit from theme</option>
	                                <option value="normal" <?php if($cff_link_weight == "normal") echo 'selected="selected"' ?> >Normal</option>
	                                <option value="bold" <?php if($cff_link_weight == "bold") echo 'selected="selected"' ?> >Bold</option>
	                            </select>
	                        </td>
	                    </tr>
	                    <tr>
	                        <th class="bump-left"><label for="cff_link_color" class="bump-left"><?php _e('Text Color'); ?></label><code class="cff_shortcode"> linkcolor
	                Eg: linkcolor=E01B5D</code></th>
	                        <td>
	                            <input name="cff_link_color" value="#<?php esc_attr_e( str_replace('#', '', $cff_link_color) ); ?>" class="cff-colorpicker" />
	                        </td>
	                    </tr>
	                    <tr>
	                        <th class="bump-left"><label for="cff_facebook_link_text" class="bump-left"><?php _e('"View on Facebook" Text'); ?></label><code class="cff_shortcode"> facebooklinktext
	                Eg: facebooklinktext='Read more...'</code></th>
	                        <td>
	                            <input name="cff_facebook_link_text" type="text" value="<?php echo stripslashes( esc_attr( $cff_facebook_link_text ) ); ?>" size="25" />
	                        </td>
	                    </tr>

	                     <tr>
	                        <th class="bump-left"><label for="cff_facebook_share_text" class="bump-left"><?php _e('"Share" Text'); ?></label><code class="cff_shortcode"> sharelinktext
	                Eg: sharelinktext='Share this post'</code></th>
	                        <td>
	                            <input name="cff_facebook_share_text" type="text" value="<?php echo stripslashes( esc_attr( $cff_facebook_share_text ) ); ?>" size="25" />
	                        </td>
	                    </tr>

	                    <tr>
	                        <th class="bump-left"><label for="cff_show_facebook_link" class="bump-left"><?php _e('Show "View on Facebook" link'); ?></label><code class="cff_shortcode"> showfacebooklink
	                Eg: showfacebooklink=true</code></th>
	                        <td>
	                            <input type="checkbox" name="cff_show_facebook_link" id="cff_show_facebook_link" <?php if($cff_show_facebook_link == true) echo 'checked="checked"' ?> />
	                        </td>
	                    </tr>

	                    <tr>
	                        <th class="bump-left"><label for="cff_show_facebook_share" class="bump-left"><?php _e('Show "Share" link'); ?></label><code class="cff_shortcode"> showsharelink
	                Eg: showsharelink=true</code></th>
	                        <td>
	                            <input type="checkbox" name="cff_show_facebook_share" id="cff_show_facebook_share" <?php if($cff_show_facebook_share == true) echo 'checked="checked"' ?> />
	                        </td>
	                    </tr>
	                    <tr id="loadmore"><!-- Quick link --></tr>
	                </tbody>
	            </table>

	            <hr />

	            <h3><?php _e('Likes, Shares and Comments Box'); ?></h3>
	            <a href="https://smashballoon.com/custom-facebook-feed/?utm_campaign=facebook-free&utm_source=settings&utm_medium=likesharescom" target="_blank">Upgrade to Pro to enable likes, shares and comments</a>
	            <p class="submit cff-expand-button">
	                <a href="javascript:void(0);" class="button"><b>+</b> Show Pro Options</a>
	            </p>
	            <table class="form-table cff-expandable-options">
	                <tbody>
	                    <tr valign="top" class="cff-pro">
	                        <th class="bump-left" scope="row"><label><?php _e('Icon Style'); ?></label><code class="cff_shortcode"> iconstyle
	                        Eg: iconstyle=dark</code></th>
	                        <td>
	                            <select name="cff_icon_style" style="width: 250px;" disabled>
	                                <option value="light"><?php _e('Light (for light backgrounds)'); ?></option>
	                                <option value="dark"><?php _e('Dark (for dark backgrounds)'); ?></option>
	                            </select>
	                        </td>
	                    </tr>
	                    <tr valign="top" class="cff-pro">
	                        <th class="bump-left" scope="row"><label><?php _e('Text Color'); ?></label><code class="cff_shortcode"> socialtextcolor
	                        Eg: socialtextcolor=FFF</code></th>
	                        <td>
	                            <input name="cff_meta_text_color" class="cff-colorpicker" />
	                        </td>
	                    </tr>
	                    <tr valign="top" class="cff-pro">
	                        <th class="bump-left" scope="row"><label><?php _e('Link Color'); ?></label><code class="cff_shortcode"> sociallinkcolor
	                        Eg: sociallinkcolor=FFF</code></th>
	                        <td>
	                            <input name="cff_meta_link_color" class="cff-colorpicker" />
	                        </td>
	                    </tr>
	                    <tr valign="top" class="cff-pro">
	                        <th class="bump-left" scope="row"><label><?php _e('Background Color'); ?></label><code class="cff_shortcode"> socialbgcolor
	                        Eg: socialbgcolor=111</code></th>
	                        <td>
	                            <input name="cff_meta_bg_color" class="cff-colorpicker" />
	                        </td>
	                    </tr>
	                    <tr valign="top" class="cff-pro">
	                        <th class="bump-left" scope="row"><label><?php _e('Expand Comments Box Initially'); ?></label><code class="cff_shortcode"> expandcomments
	                        Eg: expandcomments=true</code></th>
	                        <td>
	                            <input type="checkbox" name="cff_expand_comments" id="cff_expand_comments" disabled />
	                            <a class="cff-tooltip-link" href="JavaScript:void(0);"><i class="fa fa-question-circle" aria-hidden="true"></i></a>
	                            <p class="cff-tooltip cff-more-info"><?php _e('Checking this box will automatically expand the comments box beneath each post. Unchecking this box will mean that users will need to click the number of comments below each post in order to expand the comments box.'); ?></p>
	                        </td>
	                    </tr>
	                    <tr valign="top" class="cff-pro">
	                        <th class="bump-left" for="cff_comments_num" scope="row"><label><?php _e('Number of Comments to Show Initially'); ?></label><code class="cff_shortcode"> commentsnum
	                        Eg: commentsnum=1</code></th>
	                        <td>
	                            <input name="cff_comments_num" type="text" size="2" disabled />
	                            <span><i style="color: #666; font-size: 11px; margin-left: 5px;"><?php _e('25 max'); ?></i></span>
	                            <a class="cff-tooltip-link" href="JavaScript:void(0);"><i class="fa fa-question-circle" aria-hidden="true"></i></a>
	                            <p class="cff-tooltip cff-more-info"><?php _e('The number of comments to show initially when the comments box is expanded.'); ?></p>

	                        </td>
	                    </tr>
	                    <tr valign="top" class="cff-pro">
	                        <th class="bump-left" scope="row"><label><?php _e('Hide Comment Avatars'); ?></label><code class="cff_shortcode"> hidecommentimages
	                        Eg: hidecommentimages=true</code></th>
	                        <td>
	                            <input type="checkbox" name="cff_hide_comment_avatars" id="cff_hide_comment_avatars" disabled />
	                        </td>
	                    </tr>
	                    <tr valign="top" class="cff-pro">
	                        <th class="bump-left" scope="row"><label><?php _e('Show Comments in Lightbox'); ?></label></th>
	                        <td>
	                            <input type="checkbox" name="cff_lightbox_comments" id="cff_lightbox_comments" disabled />
	                            <span><i style="color: #666; font-size: 11px; margin-left: 5px;"><?php _e('For timeline posts only'); ?>
	                        </td>
	                    </tr>
	                    <tr id="action"><!-- Quick link --></tr>
	                </tbody>
	            </table>


	            <div style="margin-top: -15px;">
	                <?php submit_button(); ?>
	            </div>

	            <a href="https://smashballoon.com/custom-facebook-feed/demo/?utm_campaign=facebook-free&utm_source=footer&utm_medium=ad" target="_blank" class="cff-pro-notice"><img src="<?php echo CFF_PLUGIN_URL. 'admin/assets/img/pro.png' ?>" /></a>

	            <?php } //End Typography tab ?>
	            <?php if( $cff_active_tab == 'misc' ) { //Start Misc tab ?>

	            <p class="cff_contents_links" id="comments">
	                <span>Jump to: </span>
	                <a href="#css">Custom CSS</a>
	                <a href="#js">Custom JavaScript</a>
               		<a href="#gdpr">GDPR</a>
	                <a href="#misc">Misc Settings</a>
	            </p>

	            <input type="hidden" name="<?php echo $style_misc_hidden_field_name; ?>" value="Y">
	            <br />

	            <span id="css"><!-- Quick link --></span>
	            <hr />
	            <h3><?php _e('Custom CSS', 'custom-facebook-feed'); ?></h3>
	            <table class="form-table">
	                <tbody>
	                    <tr valign="top">
	                        <td style="padding-top: 0;">
	                            <p style="padding-bottom: 10px;"><?php _e('Enter your own custom CSS in the box below', 'custom-facebook-feed'); ?> <i style="margin-left: 5px; font-size: 11px;"><a href="https://smashballoon.com/snippets/" target="_blank"><?php _e('See some examples', 'custom-facebook-feed'); ?></a></i></p>
	                            <textarea name="cff_custom_css" id="cff_custom_css" style="width: 70%;" rows="7"><?php echo esc_textarea( stripslashes($cff_custom_css), 'custom-facebook-feed' ); ?></textarea>
	                        </td>
	                    </tr>
	                </tbody>
	            </table>
	            <h3 id="js"><?php _e('Custom JavaScript', 'custom-facebook-feed'); ?></h3><!-- Quick link -->
	            <table class="form-table">
	                <tbody>
	                    <tr valign="top">
	                        <td style="padding-top: 0;">
	                            <p style="padding-bottom: 10px;"><?php _e('Enter your own custom JavaScript/jQuery in the box below', 'custom-facebook-feed'); ?> <i style="margin-left: 5px; font-size: 11px;"><a href="https://smashballoon.com/snippets/" target="_blank"><?php _e('See some examples', 'custom-facebook-feed'); ?></a></i></p>
	                            <textarea name="cff_custom_js" id="cff_custom_js" style="width: 70%;" rows="7"><?php echo esc_textarea( stripslashes($cff_custom_js), 'custom-facebook-feed' ); ?></textarea>
	                        </td>
	                    </tr>
	                </tbody>
	            </table>

	            <?php submit_button(); ?>
	            <span id="gdpr"><!-- Quick link --></span>
            	<hr />
            	<h3><?php _e('GDPR'); ?></h3>
	            <table class="form-table">
	            	<tbody>
		            <tr>
		                <th class="bump-left"><label class="bump-left"><?php _e("Enable GDPR settings", 'custom-facebook-feed'); ?></label></th>
		                <td>

		                    <?php
		                    $select_options = array(
		                        array(
		                            'label' => __( 'Automatic', 'custom-facebook-feed' ),
		                            'value' => 'auto'
		                        ),
			                    array(
				                    'label' => __( 'Yes', 'custom-facebook-feed' ),
				                    'value' => 'yes'
			                    ),
			                    array(
				                    'label' => __( 'No', 'custom-facebook-feed' ),
				                    'value' => 'no'
			                    )
		                    )
		                    ?>
		                    <?php
		                    $gdpr_list = "<ul class='cff-list'>
		                            	<li>" . __('The Facebook "Like Box" widget won\'t be included in the feed.', 'custom-facebook-feed') . "</li>
		                            	<li>" . __('The "Visual" header will not be shown.', 'custom-facebook-feed') . "</li>
		                            	<li>" . __('Any profile pictures will show a placeholder.', 'custom-facebook-feed') . "</li>
		                            </ul>";
		                    ?>
		                    <div>
		                        <select name="gdpr" id="cff_gdpr_setting">
		                            <?php foreach ( $select_options as $select_option ) :
		                                $selected = $select_option['value'] === $gdpr ? ' selected' : '';
		                                ?>
		                                <option value="<?php echo esc_attr( $select_option['value'] ); ?>"<?php echo $selected; ?> ><?php echo esc_html( $select_option['label'] ); ?></option>
		                            <?php endforeach; ?>
		                        </select>
		                        <a class="cff-tooltip-link" href="JavaScript:void(0);"><?php _e('What does this mean?', 'custom-facebook-feed'); ?></a>
		                        <div class="cff-tooltip cff-more-info gdpr_tooltip">

			                        <p><span><?php _e("Yes", 'custom-facebook-feed' ); ?>:</span> <?php _e("Enabling this setting prevents all images and videos from being loaded directly from Facebook's servers (CDN) to prevent any requests to external websites in your browser. To accommodate this, some features of the plugin will be disabled or limited.", 'custom-facebook-feed' ); ?> <a href="JavaScript:void(0);" class="cff_show_gdpr_list"><?php _e( 'What will be limited?', 'custom-facebook-feed' ); ?></a></p>

		                            <?php echo "<div class='cff_gdpr_list'>" . $gdpr_list . '</div>'; ?>


									<p><span><?php _e("No", 'custom-facebook-feed' ); ?>:</span> <?php _e("The plugin will still make some requests to load and display images and videos directly from Facebook.", 'custom-facebook-feed' ); ?></p>


									<p><span><?php _e("Automatic", 'custom-facebook-feed' ); ?>:</span> <?php echo sprintf( __( 'The plugin will only load images and videos directly from Facebook if consent has been given by one of these integrated %s', 'custom-facebook-feed' ), '<a href="https://smashballoon.com/doc/gdpr-plugin-list/?facebook" target="_blank" rel="noopener">' . __( 'GDPR cookie plugins', 'custom-facebook-feed' ) . '</a>' ); ?></p>

									<p><?php echo sprintf( __( '%s to learn more about GDPR compliance in the Facebook Feed plugin.', 'custom-facebook-feed' ), '<a href="https://smashballoon.com/doc/custom-facebook-feed-gdpr-compliance/?facebook" target="_blank" rel="noopener">'. __( 'Click here', 'custom-facebook-feed' ).'</a>' ); ?></p>
		                        </div>
		                    </div>

		                    <?php if ( ! CFF_GDPR_Integrations::gdpr_tests_successful( isset( $_GET['retest'] ) ) ) :
		                        $errors = CFF_GDPR_Integrations::gdpr_tests_error_message();
		                        ?>
		                    <div class="cff-box cff_gdpr_error">
		                        <div class="cff-box-setting">
		                            <p>
		                                <strong><?php _e( 'Error:', 'custom-facebook-feed' ); ?></strong> <?php _e("Due to a configuration issue on your web server, the GDPR setting is unable to be enabled. Please see below for more information.", 'custom-facebook-feed' ); ?></p>
		                            <p>
		                                <?php echo $errors; ?>
		                            </p>
		                        </div>
		                    </div>
		                    <?php else: ?>

		                    <div class="cff_gdpr_auto">
		                        <?php if ( CFF_GDPR_Integrations::gdpr_plugins_active() ) :
		                            $active_plugin = CFF_GDPR_Integrations::gdpr_plugins_active();
		                            ?>
		                            <div class="cff_gdpr_plugin_active">
		                                <div class="cff_active">
		                                    <p>
		                                        <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="check-circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svg-inline--fa fa-check-circle fa-w-16 fa-2x"><path fill="currentColor" d="M504 256c0 136.967-111.033 248-248 248S8 392.967 8 256 119.033 8 256 8s248 111.033 248 248zM227.314 387.314l184-184c6.248-6.248 6.248-16.379 0-22.627l-22.627-22.627c-6.248-6.249-16.379-6.249-22.628 0L216 308.118l-70.059-70.059c-6.248-6.248-16.379-6.248-22.628 0l-22.627 22.627c-6.248 6.248-6.248 16.379 0 22.627l104 104c6.249 6.249 16.379 6.249 22.628.001z" class=""></path></svg>
		                                        <b><?php echo sprintf( __( '%s detected', 'custom-facebook-feed' ), $active_plugin ); ?></b>
		                                        <br />
		                                        <?php _e( 'Some Facebook Feed features will be limited for visitors to ensure GDPR compliance until they give consent.', 'custom-facebook-feed' ); ?>
		                                        <a href="JavaScript:void(0);" class="cff_show_gdpr_list"><?php _e( 'What will be limited?', 'custom-facebook-feed' ); ?></a>
		                                    </p>
		                                    <?php echo "<div class='cff_gdpr_list'>" . $gdpr_list . '</div>'; ?>
		                                </div>

		                            </div>
		                        <?php else: ?>
		                            <div class="cff-box">
		                                <div class="cff-box-setting">
		                                    <p><?php _e( 'No GDPR consent plugin detected. Install a compatible <a href="https://smashballoon.com/doc/gdpr-plugin-list/?facebook" target="_blank">GDPR consent plugin</a>, or manually enable the setting above to display a GDPR compliant version of the feed to all visitors.', 'custom-facebook-feed' ); ?></p>
		                                </div>
		                            </div>
		                        <?php endif; ?>
		                    </div>

		                    <div class="cff-box cff_gdpr_yes">
		                        <div class="cff-box-setting">
		                            <p><?php _e( "No requests will be made to third-party websites. To accommodate this, some features of the plugin will be limited:", 'custom-facebook-feed' ); ?></p>
		                            <?php echo $gdpr_list; ?>
		                        </div>
		                    </div>

		                    <div class="cff-box cff_gdpr_no">
		                        <div class="cff-box-setting">
		                            <p><?php _e( "The plugin will function as normal and load images and videos directly from Facebook.", 'custom-facebook-feed' ); ?></p>
		                        </div>
		                    </div>
		                    <?php endif; ?>

		                </td>
		            </tr>

		            </tbody>
		        </table>

	            <hr />
	            <h3><?php _e('Media'); ?></h3>
	            <a href="https://smashballoon.com/custom-facebook-feed/?utm_campaign=facebook-free&utm_source=settings&utm_medium=media" target="_blank">Upgrade to Pro to enable Media options</a>
	            <p class="submit cff-expand-button">
	                <a href="javascript:void(0);" class="button"><b>+</b> Show Pro Options</a>
	            </p>
	            <table class="form-table cff-expandable-options">
	                <tbody>
	                    <tr valign="top" class="cff-pro">
	                        <th class="bump-left" scope="row"><label><?php _e('Disable Popup Lightbox'); ?></label><code class="cff_shortcode"> disablelightbox
	                        Eg: disablelightbox=true</code></th>
	                        <td>
	                            <input name="cff_disable_lightbox" type="checkbox" id="cff_disable_lightbox" disabled />
	                            <label for="cff_disable_lightbox"><?php _e('Disable'); ?></label>
	                        </td>
	                    </tr>
	                    <tr class="cff-pro">
	                        <th class="bump-left"><label class="bump-left"><?php _e('Use full-size shared link images'); ?></label><code class="cff_shortcode"> fulllinkimages
	                    Eg: fulllinkimages=false</code></th>
	                        <td>
	                            <input type="checkbox" name="cff_full_link_images" id="cff_full_link_images" disabled />
	                            <a class="cff-tooltip-link" href="JavaScript:void(0);"><i class="fa fa-question-circle" aria-hidden="true"></i></a>
	                            <p class="cff-tooltip cff-more-info"><?php _e("By default the shared link boxes in your posts use the same layout selected on the 'Post Layout' page, however, but you can disable this by unchecking this setting to force all shared links to use the smaller image thumbnails instead."); ?></p>
	                        </td>
	                    </tr>
	                    <tr valign="top" class="cff-pro">
	                        <th class="bump-left" scope="row"><label><?php _e('Lightbox video player'); ?></label><code class="cff_shortcode"> videoplayer
	                        Eg: videoplayer=facebook</code></th>
	                        <td>
	                            <select name="cff_video_player" style="width: 280px;" disabled>
	                                <option value="facebook"><?php _e('Facebook Video Player'); ?></option>
	                                <option value="standard"><?php _e('Standard HTML5 Video'); ?></option>
	                            </select>
	                        </td>
	                    </tr>
	                    <tr valign="top" class="cff-pro">
	                        <th class="bump-left" scope="row"><label><?php _e('Play video action'); ?></label><code class="cff_shortcode"> videoaction
	                        Eg: videoaction=facebook</code></th>
	                        <td>
	                            <select name="cff_video_action" style="width: 280px;" disabled>
	                                <option value="post"><?php _e('Play videos directly in the feed'); ?></option>
	                                <!-- Link to the video either on Facebook or whatever the source is: -->
	                                <option value="facebook"><?php _e('Link to the video on Facebook'); ?></option>
	                            </select>
	                        </td>
	                    </tr>
	                </tbody>
	            </table>

	            <hr id="misc" />
	            <h3><?php _e('Misc Settings', 'custom-facebook-feed'); ?></h3>
	            <table class="form-table">
	                <tbody>
	                    <tr>
	                        <th class="bump-left"><label class="bump-left"><?php _e('Is your theme loading the feed via Ajax?', 'custom-facebook-feed'); ?></label><code class="cff_shortcode"> ajax
	                        Eg: ajax=true</code></th>
	                        <td>
	                            <input name="cff_ajax" type="checkbox" id="cff_ajax" <?php if($cff_ajax_val == true) echo "checked"; ?> />
	                            <label for="cff_ajax"><?php _e('Yes', 'custom-facebook-feed'); ?></label>
	                            <a class="cff-tooltip-link" href="JavaScript:void(0);"><i class="fa fa-question-circle" aria-hidden="true"></i></a>
	                            <p class="cff-tooltip cff-more-info"><?php _e('Some modern WordPress themes use Ajax to load content into the page after it has loaded. If your theme uses Ajax to load the Custom Facebook Feed content into the page then check this box. If you are not sure then please check with the theme author.', 'custom-facebook-feed'); ?></p>
	                        </td>
	                    </tr>
	                    <tr>
	                        <th class="bump-left"><label class="bump-left"><?php _e("Preserve settings when plugin is removed", 'custom-facebook-feed'); ?></label></th>
	                        <td>
	                            <input name="cff_preserve_settings" type="checkbox" id="cff_preserve_settings" <?php if($cff_preserve_settings_val == true) echo "checked"; ?> />
	                            <label for="cff_preserve_settings"><?php _e('Yes', 'custom-facebook-feed'); ?></label>
	                            <a class="cff-tooltip-link" href="JavaScript:void(0);"><i class="fa fa-question-circle" aria-hidden="true"></i></a>
	                            <p class="cff-tooltip cff-more-info"><?php _e('When removing the plugin your settings are automatically deleted from your database. Checking this box will prevent any settings from being deleted. This means that you can uninstall and reinstall the plugin without losing your settings.', 'custom-facebook-feed'); ?></p>
	                        </td>
	                    </tr>
	                    <tr>
	                        <th class="bump-left"><label class="bump-left"><?php _e("Display credit link", 'custom-facebook-feed'); ?></label><code class="cff_shortcode"> credit
	                        Eg: credit=true</code></th>
	                        <td>
	                            <input name="cff_show_credit" type="checkbox" id="cff_show_credit" <?php if($cff_show_credit == true) echo "checked"; ?> />
	                            <label for="cff_show_credit"><?php _e('Yes', 'custom-facebook-feed'); ?></label>
	                            <i style="color: #666; font-size: 11px; margin-left: 5px;"><?php _e('Display a link at the bottom of the feed to help promote the plugin', 'custom-facebook-feed'); ?></i>
	                        </td>
	                    </tr>

                        <tr>
                            <th class="bump-left"><label class="bump-left"><?php _e("Enqueue CSS/JS with the shortcode"); ?></label></th>
                            <td>
                                <input name="cff_enqueue_with_shortcode" type="checkbox" id="cff_enqueue_with_shortcode" <?php if($cff_enqueue_with_shortcode == true) echo "checked"; ?> />
                                <a class="cff-tooltip-link" href="JavaScript:void(0);"><?php _e('What does this mean?', 'custom-facebook-feed'); ?></a>
                                <p class="cff-tooltip cff-more-info"><?php _e("Check this box if you'd like to only include the CSS and JS files for the plugin when the feed is on the page.", 'custom-facebook-feed'); ?></p>
                            </td>
                        </tr>

	                    <tr>
	                        <th class="bump-left"><label class="bump-left"><?php _e("Minify CSS and JavaScript files"); ?></label></th>
	                        <td>
	                            <input name="cff_minify" type="checkbox" id="cff_minify" <?php if($cff_minify == true) echo "checked"; ?> />
	                        </td>
	                    </tr>

	                    <tr>
	                        <th class="bump-left"><label class="bump-left"><?php _e('Is Facebook Page restricted?'); ?></label><code class="cff_shortcode"> restrictedpage
	                        Eg: restrictedpage=true</code></th>
	                        <td>
	                            <input name="cff_restricted_page" type="checkbox" id="cff_restricted_page" <?php if($cff_restricted_page == true) echo "checked"; ?> />
	                            <label for="cff_ajax"><?php _e('Yes'); ?></label>
	                            <a class="cff-tooltip-link" href="JavaScript:void(0);"><i class="fa fa-question-circle" aria-hidden="true"></i></a>
	                            <p class="cff-tooltip cff-more-info"><?php _e('If you want to display your Facebook feed on your website then ideally your Facebook page should not have any age or location restrictions on it as that restricts the plugin from being able to fully access the content. If it is not possible for you to remove all restrictions then you can enable this setting.'); ?></p>
	                        </td>
	                    </tr>

	                    <tr>
	                        <th class="bump-left"><label class="bump-left"><?php _e("Icon font source", 'custom-facebook-feed'); ?></label></th>
	                        <td>
	                            <select name="cff_font_source">
	                                <option value="cdn" <?php if($cff_font_source == "cdn") echo 'selected="selected"' ?> ><?php _e('CDN', 'custom-facebook-feed'); ?></option>
	                                <option value="local" <?php if($cff_font_source == "local") echo 'selected="selected"' ?> ><?php _e('Local copy', 'custom-facebook-feed'); ?></option>
	                                <option value="none" <?php if($cff_font_source == "none") echo 'selected="selected"' ?> ><?php _e("Don't load", 'custom-facebook-feed'); ?></option>
	                            </select>
	                        </td>
	                    </tr>

	                    <tr>
	                        <th class="bump-left">
	                            <label class="bump-left"><?php _e("Force cache to clear on interval", 'custom-facebook-feed'); ?></label>
	                        </th>
	                        <td>
	                            <select name="cff_cron">
	                                <option value="unset" <?php if($cff_cron == "unset") echo 'selected="selected"' ?> ><?php _e(' - ', 'custom-facebook-feed'); ?></option>
	                                <option value="yes" <?php if($cff_cron == "yes") echo 'selected="selected"' ?> ><?php _e('Yes', 'custom-facebook-feed'); ?></option>
	                                <option value="no" <?php if($cff_cron == "no") echo 'selected="selected"' ?> ><?php _e('No', 'custom-facebook-feed'); ?></option>
	                            </select>

	                            <a class="cff-tooltip-link" href="JavaScript:void(0);"><i class="fa fa-question-circle" aria-hidden="true"></i></a>
	                            <p class="cff-tooltip cff-more-info"><?php _e("If you're experiencing an issue with the plugin not auto-updating then you can set this to 'Yes' to run a scheduled event behind the scenes which forces the plugin cache to clear on a regular basis and retrieve new data from Facebook.", 'custom-facebook-feed'); ?></p>
	                        </td>
	                    </tr>

	                    <tr>
	                        <th class="bump-left"><label class="bump-left"><?php _e("Request method", 'custom-facebook-feed'); ?></label></th>
	                        <td>
	                            <select name="cff_request_method">
	                                <option value="auto" <?php if($cff_request_method == "auto") echo 'selected="selected"' ?> ><?php _e('Auto', 'custom-facebook-feed'); ?></option>
	                                <option value="1" <?php if($cff_request_method == "1") echo 'selected="selected"' ?> ><?php _e('cURL', 'custom-facebook-feed'); ?></option>
	                                <option value="2" <?php if($cff_request_method == "2") echo 'selected="selected"' ?> ><?php _e('file_get_contents', 'custom-facebook-feed'); ?></option>
	                                <option value="3" <?php if($cff_request_method == "3") echo 'selected="selected"' ?> ><?php _e("WP_Http", 'custom-facebook-feed'); ?></option>
	                            </select>
	                        </td>
	                    </tr>
	                    <tr>
	                        <th class="bump-left"><label class="bump-left"><?php _e('Fix text shortening issue'); ?></label><code class="cff_shortcode"> textissue
	                        Eg: textissue=true</code></th>
	                        <td>
	                            <input name="cff_format_issue" type="checkbox" id="cff_format_issue" <?php if($cff_format_issue == true) echo "checked"; ?> />
	                        </td>
	                    </tr>
	                    <tr>
	                        <th class="bump-left"><label for="cff_disable_styles" class="bump-left"><?php _e("Disable default styles", 'custom-facebook-feed'); ?></label></th>
	                        <td>
	                            <input name="cff_disable_styles" type="checkbox" id="cff_disable_styles" <?php if($cff_disable_styles == true) echo "checked"; ?> />
	                            <label for="cff_disable_styles"><?php _e('Yes', 'custom-facebook-feed'); ?></label>
	                            <a class="cff-tooltip-link" href="JavaScript:void(0);"><i class="fa fa-question-circle" aria-hidden="true"></i></a>
	                            <p class="cff-tooltip cff-more-info"><?php _e("The plugin includes some basic text and link styles which can be disabled by enabling this setting. Note that the styles used for the layout of the posts will still be applied.", 'custom-facebook-feed'); ?></p>
	                        </td>
	                    </tr>

	                    <tr>
	                        <th class="bump-left"><label for="cff_disable_admin_notice" class="bump-left"><?php _e("Disable admin error notice", 'custom-facebook-feed'); ?></label></th>
	                        <td>
	                            <input name="cff_disable_admin_notice" type="checkbox" id="cff_disable_admin_notice" <?php if($cff_disable_admin_notice == true) echo "checked"; ?> />
	                            <label for="cff_disable_admin_notice"><?php _e('Yes', 'custom-facebook-feed'); ?></label>
	                            <a class="cff-tooltip-link" href="JavaScript:void(0);"><i class="fa fa-question-circle" aria-hidden="true"></i></a>
	                            <p class="cff-tooltip cff-more-info"><?php _e("This will permanently disable the feed error notice that displays in the bottom right corner for admins on the front end of your site.", 'custom-facebook-feed'); ?></p>
	                        </td>
	                    </tr>

	                    <tr>
	                        <th class="bump-left"><label for="cff_enable_email_report" class="bump-left"><?php _e("Feed issue email report", 'custom-facebook-feed'); ?></label></th>
	                        <td>
	                            <input name="cff_enable_email_report" type="checkbox" id="cff_enable_email_report" <?php if($cff_enable_email_report == 'on') echo "checked"; ?> />
	                            <label for="cff_enable_email_report"><?php _e('Yes', 'custom-facebook-feed'); ?></label>
	                            <a class="cff-tooltip-link" href="JavaScript:void(0);"><i class="fa fa-question-circle" aria-hidden="true"></i></a>
	                            <p class="cff-tooltip cff-more-info"><?php _e("Custom Facebook Feed will send a weekly notification email using your site's wp_mail() function if one or more of your feeds is not updating or is not displaying. If you're not receiving the emails in your inbox, you may need to configure an SMTP service using another plugin like WP Mail SMTP.", 'custom-facebook-feed'); ?></p>

	                            <div class="cff_box" style="display: block;">
	                                <div class="cff_box_setting">
	                                    <label><?php _e('Schedule Weekly on', 'custom-facebook-feed'); ?></label><br>
					                    <?php
					                    $schedule_options = array(
						                    array(
							                    'val' => 'monday',
							                    'label' => __( 'Monday', 'custom-facebook-feed' )
						                    ),
						                    array(
							                    'val' => 'tuesday',
							                    'label' => __( 'Tuesday', 'custom-facebook-feed' )
						                    ),
						                    array(
							                    'val' => 'wednesday',
							                    'label' => __( 'Wednesday', 'custom-facebook-feed' )
						                    ),
						                    array(
							                    'val' => 'thursday',
							                    'label' => __( 'Thursday', 'custom-facebook-feed' )
						                    ),
						                    array(
							                    'val' => 'friday',
							                    'label' => __( 'Friday', 'custom-facebook-feed' )
						                    ),
						                    array(
							                    'val' => 'saturday',
							                    'label' => __( 'Saturday', 'custom-facebook-feed' )
						                    ),
						                    array(
							                    'val' => 'sunday',
							                    'label' => __( 'Sunday', 'custom-facebook-feed' )
						                    ),
					                    );

					                    if ( isset( $_GET['flag'] ) ){
						                    echo '<span id="cff-goto"></span>';
					                    }
					                    ?>
	                                    <select name="cff_email_notification" id="cff_email_notification">
						                    <?php foreach ( $schedule_options as $schedule_option ) : ?>
	                                            <option value="<?php echo esc_attr( $schedule_option['val'] ) ; ?>" <?php if ( $schedule_option['val'] === $cff_email_notification ) { echo 'selected';} ?>><?php echo esc_html( $schedule_option['label'] ) ; ?></option>
						                    <?php endforeach; ?>
	                                    </select>
	                                </div>
	                                <div class="cff_box_setting">
	                                    <label><?php _e('Email Recipients', 'custom-facebook-feed'); ?></label><br><input class="regular-text" type="text" name="cff_email_notification_addresses" value="<?php echo esc_attr( $cff_email_notification_addresses ); ?>"><span class="cff_note"><?php _e('separate multiple emails with commas', 'custom-facebook-feed'); ?></span>
	                                    <br><br><?php _e( 'Emails not working?', 'custom-facebook-feed' ) ?> <a href="https://smashballoon.com/email-report-is-not-in-my-inbox/" target="_blank"><?php _e( 'See our related FAQ', 'custom-facebook-feed' ) ?></a>
	                                </div>
	                            </div>

	                        </td>
	                    </tr>

	                    <tr>
		                    <?php
		                    $usage_tracking = get_option( 'cff_usage_tracking', array( 'last_send' => 0, 'enabled' => CFF_Utils::cff_is_pro_version() ) );

		                    if ( isset( $_POST['cff_email_notification_addresses'] ) ) {
			                    $usage_tracking['enabled'] = false;
			                    if ( isset( $_POST['cff_usage_tracking_enable'] ) ) {
			                        if ( ! is_array( $usage_tracking ) ) {
	                                    $usage_tracking = array(
	                                        'enabled' => true,
	                                        'last_send' => 0,
	                                    );
			                        } else {
			                            $usage_tracking['enabled'] = true;
			                        }
			                    }
			                    update_option( 'cff_usage_tracking', $usage_tracking, false );
		                    }
		                    $cff_usage_tracking_enable = isset( $usage_tracking['enabled'] ) ? $usage_tracking['enabled'] : true;
		                    ?>
	                        <th class="bump-left"><label class="bump-left"><?php _e("Enable Usage Tracking", 'custom-facebook-feed'); ?></label></th>
	                        <td>
	                            <input name="cff_usage_tracking_enable" type="checkbox" id="cff_usage_tracking_enable" <?php if( $cff_usage_tracking_enable ) echo "checked"; ?> />
	                            <label for="cff_usage_tracking_enable"><?php _e('Yes', 'custom-facebook-feed'); ?></label>
	                            <a class="cff-tooltip-link" href="JavaScript:void(0);"><?php _e('What is usage tracking?', 'custom-facebook-feed'); ?></a>
	                            <p class="cff-tooltip"><?php _e("Understanding how you are using the plugin allows us to further improve it. The plugin will send a report in the background once per week which includes information about your plugin settings and statistics about your site, which we can use to help improve the features which matter most to you and improve your experience using the plugin. The plugin will never collect any sensitive information like access tokens, email addresses, or user information, and sending this data won't slow down your site at all. For more information,", 'custom-facebook-feed'); ?> <a href="https://smashballoon.com/custom-facebook-feed/docs/usage-tracking/" target="_blank"><?php _e("see here", 'custom-facebook-feed'); ?></a>.</p>
	                        </td>
	                    </tr>

	                </tbody>
	            </table>

	            <?php submit_button(); ?>
	            <a href="https://smashballoon.com/custom-facebook-feed/demo/?utm_campaign=facebook-free&utm_source=footer&utm_medium=ad" target="_blank" class="cff-pro-notice"><img src="<?php echo CFF_PLUGIN_URL. 'admin/assets/img/pro.png' ?>" /></a>
	            <?php } //End Misc tab ?>


	            <?php if( $cff_active_tab == 'custom_text' ) { //Start Custom Text tab ?>

	            <p class="cff_contents_links">
	                <span>Jump to: </span>
	                <a href="#text">Post Text</a>
	                <a href="#action">Post Action Links</a>
	                <a href="#medialink">Media Links</a>
	                <a href="#date">Date</a>
	            </p>

	            <input type="hidden" name="<?php echo $style_custom_text_hidden_field_name; ?>" value="Y">
	            <br />
	            <h3><?php _e('Custom Text / Translate', 'custom-facebook-feed'); ?></h3>
	            <p><?php _e('Enter custom text for the words below, or translate it into the language you would like to use.', 'custom-facebook-feed'); ?></p>
	            <table class="form-table cff-translate-table" style="width: 100%; max-width: 940px;">
	                <tbody>

	                    <thead id="text">
	                        <tr>
	                            <th><?php _e('Original Text', 'custom-facebook-feed'); ?></th>
	                            <th><?php _e('Custom Text / Translation', 'custom-facebook-feed'); ?></th>
	                            <th><?php _e('Context', 'custom-facebook-feed'); ?></th>
	                        </tr>
	                    </thead>

	                    <tr class="cff-table-header"><th colspan="3"><?php _e('Post Text', 'custom-facebook-feed'); ?></th></tr>
	                    <tr>
	                        <td><label for="cff_see_more_text" class="bump-left"><?php _e('See More', 'custom-facebook-feed'); ?></label></td>
	                        <td><input name="cff_see_more_text" type="text" value="<?php echo stripslashes( esc_attr( $cff_see_more_text ) ); ?>" /></td>
	                        <td class="cff-context"><?php _e('Used when truncating the post text', 'custom-facebook-feed'); ?></td>
	                    </tr>

	                    <tr id="action"><!-- Quick link -->
	                        <td><label for="cff_see_less_text" class="bump-left"><?php _e('See Less', 'custom-facebook-feed'); ?></label></td>
	                        <td><input name="cff_see_less_text" type="text" value="<?php echo stripslashes( esc_attr( $cff_see_less_text ) ); ?>" /></td>
	                        <td class="cff-context"><?php _e('Used when truncating the post text', 'custom-facebook-feed'); ?></td>
	                    </tr>

	                    <tr class="cff-table-header"><th colspan="3"><?php _e('Post Action Links', 'custom-facebook-feed'); ?></th></tr>
	                    <tr>
	                        <td><label for="cff_facebook_link_text" class="bump-left"><?php _e('View on Facebook', 'custom-facebook-feed'); ?></label></td>
	                        <td><input name="cff_facebook_link_text" type="text" value="<?php echo stripslashes( esc_attr( $cff_facebook_link_text ) ); ?>" /></td>
	                        <td class="cff-context"><?php _e('Used for the link to the post on Facebook', 'custom-facebook-feed'); ?></td>
	                    </tr>
	                    <tr>
	                        <td><label for="cff_facebook_share_text" class="bump-left"><?php _e('Share', 'custom-facebook-feed'); ?></label></td>
	                        <td><input name="cff_facebook_share_text" type="text" value="<?php echo stripslashes( esc_attr( $cff_facebook_share_text ) ); ?>" /></td>
	                        <td class="cff-context"><?php _e('Used for sharing the Facebook post via Social Media', 'custom-facebook-feed'); ?></td>
	                    </tr>

	                    <tr id="medialink"><!-- Quick link -->
	                        <td><label for="cff_translate_photos_text" class="bump-left"><?php _e('photos', 'custom-facebook-feed'); ?></label></td>
	                        <td><input name="cff_translate_photos_text" type="text" value="<?php echo stripslashes( esc_attr( $cff_translate_photos_text ) ); ?>" /></td>
	                        <td class="cff-context"><?php _e('Added to the end of an album name. Eg. (6 photos)', 'custom-facebook-feed'); ?></td>
	                    </tr>

	                    <tr class="cff-table-header"><th colspan="3"><?php _e('Media Links', 'custom-facebook-feed'); ?></th></tr>
	                    <tr>
	                        <td><label for="cff_translate_photo_text" class="bump-left"><?php _e('Photo', 'custom-facebook-feed'); ?></label></td>
	                        <td><input name="cff_translate_photo_text" type="text" value="<?php echo stripslashes( esc_attr( $cff_translate_photo_text ) ); ?>" /></td>
	                        <td class="cff-context"><?php _e('Used to link to photos on Facebook', 'custom-facebook-feed'); ?></td>
	                    </tr>
	                    <tr id="date"><!-- Quick link -->
	                        <td><label for="cff_translate_video_text" class="bump-left"><?php _e('Video', 'custom-facebook-feed'); ?></label></td>
	                        <td><input name="cff_translate_video_text" type="text" value="<?php echo stripslashes( esc_attr( $cff_translate_video_text ) ); ?>" /></td>
	                        <td class="cff-context"><?php _e('Used to link to videos on Facebook', 'custom-facebook-feed'); ?></td>
	                    </tr>

	                    <tr class="cff-table-header"><th colspan="3"><?php _e('Call-to-action Buttons', 'custom-facebook-feed'); ?></th></tr>
	                    <tr>
	                        <td><label for="cff_translate_learn_more_text" class="bump-left"><?php _e('Learn More', 'custom-facebook-feed'); ?></label></td>
	                        <td><input name="cff_translate_learn_more_text" type="text" value="<?php echo stripslashes( esc_attr( $cff_translate_learn_more_text ) ); ?>" /></td>
	                        <td class="cff-context"><?php _e("Used for the 'Learn More' button", 'custom-facebook-feed'); ?></td>
	                    </tr>
	                    <tr>
	                        <td><label for="cff_translate_shop_now_text" class="bump-left"><?php _e('Shop Now', 'custom-facebook-feed'); ?></label></td>
	                        <td><input name="cff_translate_shop_now_text" type="text" value="<?php echo stripslashes( esc_attr( $cff_translate_shop_now_text ) ); ?>" /></td>
	                        <td class="cff-context"><?php _e("Used for the 'Shop Now' button", 'custom-facebook-feed'); ?></td>
	                    </tr>
	                    <tr>
	                        <td><label for="cff_translate_message_page_text" class="bump-left"><?php _e('Message Page', 'custom-facebook-feed'); ?></label></td>
	                        <td><input name="cff_translate_message_page_text" type="text" value="<?php echo stripslashes( esc_attr( $cff_translate_message_page_text ) ); ?>" /></td>
	                        <td class="cff-context"><?php _e("Used for the 'Message Page' button", 'custom-facebook-feed'); ?></td>
	                    </tr>

	                    <tr class="cff-table-header"><th colspan="3"><?php _e('Date', 'custom-facebook-feed'); ?></th></tr>
	                    <tr>
	                        <td><label for="cff_photos_text" class="bump-left"><?php _e('"Posted _ hours ago" text', 'custom-facebook-feed'); ?></label></td>
	                        <td class="cff-translate-date">

	                            <label for="cff_translate_second"><?php _e("second", 'custom-facebook-feed'); ?></label>
	                            <input name="cff_translate_second" type="text" value="<?php echo stripslashes( esc_attr( $cff_translate_second ) ); ?>" size="20" />
	                            <br />
	                            <label for="cff_translate_seconds"><?php _e("seconds", 'custom-facebook-feed'); ?></label>
	                            <input name="cff_translate_seconds" type="text" value="<?php echo stripslashes( esc_attr( $cff_translate_seconds ) ); ?>" size="20" />
	                            <br />
	                            <label for="cff_translate_minute"><?php _e("minute", 'custom-facebook-feed'); ?></label>
	                            <input name="cff_translate_minute" type="text" value="<?php echo stripslashes( esc_attr( $cff_translate_minute ) ); ?>" size="20" />
	                            <br />
	                            <label for="cff_translate_minutes"><?php _e("minutes", 'custom-facebook-feed'); ?></label>
	                            <input name="cff_translate_minutes" type="text" value="<?php echo stripslashes( esc_attr( $cff_translate_minutes ) ); ?>" size="20" />
	                            <br />
	                            <label for="cff_translate_hour"><?php _e("hour", 'custom-facebook-feed'); ?></label>
	                            <input name="cff_translate_hour" type="text" value="<?php echo stripslashes( esc_attr( $cff_translate_hour ) ); ?>" size="20" />
	                            <br />
	                            <label for="cff_translate_hours"><?php _e("hours", 'custom-facebook-feed'); ?></label>
	                            <input name="cff_translate_hours" type="text" value="<?php echo stripslashes( esc_attr( $cff_translate_hours ) ); ?>" size="20" />
	                            <br />
	                            <label for="cff_translate_day"><?php _e("day", 'custom-facebook-feed'); ?></label>
	                            <input name="cff_translate_day" type="text" value="<?php echo stripslashes( esc_attr( $cff_translate_day ) ); ?>" size="20" />
	                            <br />
	                            <label for="cff_translate_days"><?php _e("days", 'custom-facebook-feed'); ?></label>
	                            <input name="cff_translate_days" type="text" value="<?php echo stripslashes( esc_attr( $cff_translate_days ) ); ?>" size="20" />
	                            <br />
	                            <label for="cff_translate_week"><?php _e("week", 'custom-facebook-feed'); ?></label>
	                            <input name="cff_translate_week" type="text" value="<?php echo stripslashes( esc_attr( $cff_translate_week ) ); ?>" size="20" />
	                            <br />
	                            <label for="cff_translate_weeks"><?php _e("weeks", 'custom-facebook-feed'); ?></label>
	                            <input name="cff_translate_weeks" type="text" value="<?php echo stripslashes( esc_attr( $cff_translate_weeks ) ); ?>" size="20" />
	                            <br />
	                            <label for="cff_translate_month"><?php _e("month", 'custom-facebook-feed'); ?></label>
	                            <input name="cff_translate_month" type="text" value="<?php echo stripslashes( esc_attr( $cff_translate_month ) ); ?>" size="20" />
	                            <br />
	                            <label for="cff_translate_months"><?php _e("months", 'custom-facebook-feed'); ?></label>
	                            <input name="cff_translate_months" type="text" value="<?php echo stripslashes( esc_attr( $cff_translate_months ) ); ?>" size="20" />
	                            <br />
	                            <label for="cff_translate_year"><?php _e("year", 'custom-facebook-feed'); ?></label>
	                            <input name="cff_translate_year" type="text" value="<?php echo stripslashes( esc_attr( $cff_translate_year ) ); ?>" size="20" />
	                            <br />
	                            <label for="cff_translate_years"><?php _e("years", 'custom-facebook-feed'); ?></label>
	                            <input name="cff_translate_years" type="text" value="<?php echo stripslashes( esc_attr( $cff_translate_years ) ); ?>" size="20" />
	                            <br />
	                            <label for="cff_translate_ago"><?php _e("ago", 'custom-facebook-feed'); ?></label>
	                            <input name="cff_translate_ago" type="text" value="<?php echo stripslashes( esc_attr( $cff_translate_ago ) ); ?>" size="20" />
	                        </td>
	                        <td class="cff-context"><?php _e('Used to translate the "__ days ago" date text', 'custom-facebook-feed'); ?></td>
	                    </tr>

	                </tbody>
	            </table>

	            <?php submit_button(); ?>
	            <a href="https://smashballoon.com/custom-facebook-feed/demo/?utm_campaign=facebook-free&utm_source=footer&utm_medium=ad" target="_blank" class="cff-pro-notice"><img src="<?php echo CFF_PLUGIN_URL. 'admin/assets/img/pro.png'  ?>" /></a>
	            <?php } //End Custom Text tab ?>

	        </form>

	        <div class="cff-share-plugin">
	            <h3><?php _e('Like the plugin? Help spread the word!', 'custom-facebook-feed'); ?></h3>

	            <button id="cff-admin-show-share-links" class="button secondary" style="margin-bottom: 1px;"><i class="fa fa-share-alt" aria-hidden="true"></i>&nbsp;&nbsp;Share the plugin</button> <div id="cff-admin-share-links"></div>
	        </div>

	<?php
	} //End Style_Page



 //Create Settings page
function cff_settings_page() {
    //Declare variables for fields
    $hidden_field_name      = 'cff_submit_hidden';
    $show_access_token      = 'cff_show_access_token';
    $access_token           = 'cff_access_token';
    $page_id                = 'cff_page_id';
    $cff_connected_accounts = 'cff_connected_accounts';
    $cff_page_type          = 'cff_page_type';
    $num_show               = 'cff_num_show';
    $cff_post_limit         = 'cff_post_limit';
    $cff_show_others        = 'cff_show_others';
    $cff_cache_time         = 'cff_cache_time';
    $cff_cache_time_unit    = 'cff_cache_time_unit';
    $cff_locale             = 'cff_locale';
    // Read in existing option value from database
    $show_access_token_val = true;
    $access_token_val = get_option( $access_token );
    $page_id_val = get_option( $page_id );
    $cff_connected_accounts_val = get_option( $cff_connected_accounts );

    $cff_page_type_val = get_option( $cff_page_type, 'page' );
    $num_show_val = get_option( $num_show, '5' );
    $cff_post_limit_val = get_option( $cff_post_limit );
    $cff_show_others_val = get_option( $cff_show_others );
    $cff_cache_time_val = get_option( $cff_cache_time, '1' );
    $cff_cache_time_unit_val = get_option( $cff_cache_time_unit, 'hours' );
    $cff_locale_val = get_option( $cff_locale, 'en_US' );

    //Timezone
    $defaults = array(
        'cff_timezone' => 'America/Chicago',
        'cff_num_mobile' => ''
    );
    $options = wp_parse_args(get_option('cff_style_settings'), $defaults);
    $cff_timezone = $options[ 'cff_timezone' ];
    $cff_num_mobile = $options[ 'cff_num_mobile' ];


    //Check nonce before saving data
    if ( ! isset( $_POST['cff_settings_nonce'] ) || ! wp_verify_nonce( $_POST['cff_settings_nonce'], 'cff_saving_settings' ) ) {
        //Nonce did not verify
    } else {

        // See if the user has posted us some information. If they did, this hidden field will be set to 'Y'.
        if( isset($_POST[ $hidden_field_name ]) && $_POST[ $hidden_field_name ] == 'Y' ) {
            // Read their posted value
            isset( $_POST[ $show_access_token ] ) ? $show_access_token_val = true : $show_access_token_val = true;
            isset( $_POST[ $access_token ] ) ? $access_token_val = sanitize_text_field( $_POST[ $access_token ] ) : $access_token_val = '';
            isset( $_POST[ $page_id ] ) ? $page_id_val = sanitize_text_field( $_POST[ $page_id ] ) : $page_id_val = '';
            isset( $_POST[ $cff_connected_accounts ] ) ? $cff_connected_accounts_val = $_POST[ $cff_connected_accounts ] : $cff_connected_accounts_val = '';
            isset( $_POST[ $cff_page_type ] ) ? $cff_page_type_val = sanitize_text_field( $_POST[ $cff_page_type ] ) : $cff_page_type_val = '';
            isset( $_POST[ $num_show ] ) ? $num_show_val = sanitize_text_field( $_POST[ $num_show ] ) : $num_show_val = '';
            isset( $_POST[ 'cff_num_mobile' ] ) ? $cff_num_mobile = sanitize_text_field( $_POST[ 'cff_num_mobile' ] ) : $cff_num_mobile = '';
            isset( $_POST[ $cff_post_limit ] ) ? $cff_post_limit_val = sanitize_text_field( $_POST[ $cff_post_limit ] ) : $cff_post_limit_val = '';
            isset( $_POST[ $cff_show_others ] ) ? $cff_show_others_val = sanitize_text_field( $_POST[ $cff_show_others ] ) : $cff_show_others_val = '';
            isset( $_POST[ $cff_cache_time ] ) ? $cff_cache_time_val = sanitize_text_field( $_POST[ $cff_cache_time ] ) : $cff_cache_time_val = '';
            isset( $_POST[ $cff_cache_time_unit ] ) ? $cff_cache_time_unit_val = sanitize_text_field( $_POST[ $cff_cache_time_unit ] ) : $cff_cache_time_unit_val = '';
            isset( $_POST[ $cff_locale ] ) ? $cff_locale_val = sanitize_text_field( $_POST[ $cff_locale ] ) : $cff_locale_val = '';
            if (isset($_POST[ 'cff_timezone' ]) ) $cff_timezone = sanitize_text_field( $_POST[ 'cff_timezone' ] );

            // Save the posted value in the database
            update_option( $show_access_token, true );
            update_option( $access_token, $access_token_val );
            update_option( $page_id, $page_id_val );
            update_option( $cff_connected_accounts, $cff_connected_accounts_val );

            update_option( $cff_page_type, $cff_page_type_val );
            update_option( $num_show, $num_show_val );
            update_option( $cff_post_limit, $cff_post_limit_val );
            update_option( $cff_show_others, $cff_show_others_val );
            update_option( $cff_cache_time, $cff_cache_time_val );
            update_option( $cff_cache_time_unit, $cff_cache_time_unit_val );
            update_option( $cff_locale, $cff_locale_val );

            $options[ 'cff_timezone' ] = $cff_timezone;
            $options[ 'cff_num_mobile' ] = $cff_num_mobile;
            update_option( 'cff_style_settings', $options );
			$cff_cron_schedule = 'hourly';
			if( $cff_cache_time_unit_val == 'hours' && $cff_cache_time_val > 5 ) $cff_cron_schedule = 'twicedaily';
			if( $cff_cache_time_unit_val == 'days' ) $cff_cron_schedule = 'daily';
			CustomFacebookFeed\CFF_Group_Posts::group_reschedule_event(time(), $cff_cron_schedule);

            //Delete ALL transients
            cff_delete_cache();
            // Put an settings updated message on the screen
        	\cff_main()->cff_error_reporter->add_action_log( 'Saved settings on the configure tab.' );
        ?>
        <div class="updated"><p><strong><?php _e('Settings saved.', 'custom-facebook-feed' ); ?></strong></p></div>
        <?php } ?>

    <?php } //End nonce check ?>

    <div id="cff-admin" class="wrap">

	<?php
	$lite_notice_dismissed = get_transient( 'facebook_feed_dismiss_lite' );

	if ( ! $lite_notice_dismissed ) :
		?>
        <div id="cff-notice-bar" style="display:none">
            <span class="cff-notice-bar-message"><?php _e( 'You\'re using Custom Facebook Feed Lite. To unlock more features consider <a href="https://smashballoon.com/custom-facebook-feed/?utm_campaign=facebook-free&utm_source=notices&utm_medium=lite" target="_blank" rel="noopener noreferrer">upgrading to Pro</a>.', 'custom-facebook-feed'); ?></span>
            <button type="button" class="dismiss" title="<?php _e( 'Dismiss this message.', 'custom-facebook-feed'); ?>" data-page="overview">
            </button>
        </div>
	<?php endif; ?>
        <?php do_action( 'cff_admin_overview_before_table' ); ?>

        <div id="header">
            <h1><?php _e('Custom Facebook Feed', 'custom-facebook-feed'); ?></h1>
        </div>

        <?php
        $cff_active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : 'configuration';
        ?>
        <h2 class="nav-tab-wrapper">
            <a href="?page=cff-top&amp;tab=configuration" class="nav-tab <?php echo $cff_active_tab == 'configuration' ? 'nav-tab-active' : ''; ?>"><?php _e('Configuration', 'custom-facebook-feed'); ?></a>
            <a href="?page=cff-style" class="nav-tab <?php echo $cff_active_tab == 'customize' ? 'nav-tab-active' : ''; ?>"><?php _e('Customize', 'custom-facebook-feed'); ?></a>
            <a href="?page=cff-top&amp;tab=support" class="nav-tab <?php echo $cff_active_tab == 'support' ? 'nav-tab-active' : ''; ?>"><?php _e('Support', 'custom-facebook-feed'); ?></a>
            <a href="?page=cff-top&amp;tab=more" class="nav-tab <?php echo $cff_active_tab == 'more' ? 'nav-tab-active' : ''; ?>"><?php _e('More Social Feeds', 'custom-facebook-feed'); ?>
                <?php
                $seen_more_plugins_page = get_user_meta(get_current_user_id(), 'seen_more_plugins_page_1', true);
                if( !$seen_more_plugins_page ) echo '<span class="cff-alert-bubble">1</span>';
                ?>
            </a>
        </h2>

        <?php if( $cff_active_tab == 'configuration' ) { //Start tab ?>

        <form name="form1" method="post" action="">
            <input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y">
            <?php wp_nonce_field( 'cff_saving_settings', 'cff_settings_nonce' ); ?>

            <br />
            <h3><?php _e('Configuration', 'custom-facebook-feed'); ?></h3>


            <div id="cff_fb_login_modal">
                <div class="cff_modal_box">

                    <p>Log into your Facebook account using the button below and approve the plugin to connect your account.</p>


                    <div class="cff-login-options">
                        <label for="cff_login_type">Would you like to display a Facebook Page or Group?</label>
                        <select id="cff_login_type">
                            <option value="page">Facebook Page</option>
                            <option value="group">Facebook Group</option>
                        </select>

                        <p>
                            <a href="javascript:void(0);" id="cff_admin_cancel_btn" class="cff-admin-cancel-btn">Cancel</a>

                            <?php
                            $admin_url_state = admin_url('admin.php?page=cff-top');
                            //If the admin_url isn't returned correctly then use a fallback
                            if( $admin_url_state == '/wp-admin/admin.php?page=cff-top' || $admin_url_state == '/wp-admin/admin.php?page=cff-top&tab=configuration' ){
                                $admin_url_state = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                            }
                            ?>
                            <a href="https://api.smashballoon.com/v2/facebook-login.php?state=<?php echo $admin_url_state; ?>" class="cff_admin_btn" id="cff_page_app"><i class="fa fa-facebook-square"></i> <?php _e( 'Continue', 'custom-facebook-feed' ); ?></a>

                            <a href="https://api.smashballoon.com/v2/facebook-group-login.php?state=<?php echo $admin_url_state; ?>" class="cff_admin_btn" id="cff_group_app"><i class="fa fa-facebook-square"></i> <?php _e( 'Continue', 'custom-facebook-feed' ); ?></a>

                        </p>
                    </div>

                    <p style="font-size: 11px; margin-top: 25px;"><b>Please note:</b> this does not give us permission to manage your Facebook pages or groups, it simply allows the plugin to see a list that you manage and retrieve an Access Token.</p>

                </div>
            </div>

            <a href="JavaScript:void(0);" class="cff_admin_btn" id="cff_fb_login"><i class="fa fa-facebook-square"></i> <?php _e( 'Connect a Facebook account', 'custom-facebook-feed' ); ?></a>


            <?php
            if( isset($_GET['cff_access_token']) && isset($_GET['cff_final_response']) ){

                if( $_GET['cff_final_response'] == 'true' ) {

	                \cff_main()->cff_error_reporter->remove_error( 'connection' );
                    \cff_main()->cff_error_reporter->add_action_log( 'Connection or updating account');

                    $access_token = $_GET['cff_access_token'];
                    $cff_is_groups = false;
                    $pages_data_arr = '';
                    $groups_data_arr = '';

                    if( isset($_GET['cff_group']) ){
                        //Get Groups

                        $cff_is_groups = true;
                        $groups_data_arr = '';

                        //Extend the user token by making a call to /me/accounts. User must be an admin of a page for this to work as won't work if the response is empty.
                        $url = 'https://graph.facebook.com/me/accounts?limit=500&access_token='.$access_token;

                        $accounts_data = CFF_Utils::cff_fetchUrl($url);
                        $accounts_data_arr = json_decode($accounts_data);
                        $cff_token_expiration = 'never';
                        if( empty($accounts_data_arr->data) ){
                            $cff_token_expiration = '60 days';
                        }

                        //Get User ID
                        $user_url = 'https://graph.facebook.com/me?fields=id&access_token='.$access_token;
                        $user_id_data = CFF_Utils::cff_fetchUrl($user_url);

                        if( !empty($user_id_data) ){
                            $user_id_data_arr = json_decode($user_id_data);
                            $user_id = $user_id_data_arr->id;

                            //Get groups they're admin of
                            $groups_admin_url = 'https://graph.facebook.com/'.$user_id.'/groups?admin_only=true&fields=name,id,picture&access_token='.$access_token;
                            $groups_admin_data = CFF_Utils::cff_fetchUrl($groups_admin_url);
                            $groups_admin_data_arr = json_decode($groups_admin_data);

                            //Get member groups
                            $groups_url = 'https://graph.facebook.com/'.$user_id.'/groups?admin_only=false&fields=name,id,picture&access_token='.$access_token;
                            $groups_data = CFF_Utils::cff_fetchUrl($groups_url);
                            $groups_data_arr = json_decode($groups_data);

                            // $pages_data_arr = $groups_data_arr;
                        }
                    } else {
                        //Get Pages

                        $url = 'https://graph.facebook.com/me/accounts?limit=500&access_token='.$access_token;
                        $pages_data = CFF_Utils::cff_fetchUrl($url);
                        $pages_data_arr = json_decode($pages_data);

                        if( empty($pages_data_arr->data) ){
                        //If they don't manage any pages then just use the user token instead
                        ?>
                            <script type='text/javascript'>
                            jQuery(document).ready(function($) {
                                $('#cff_access_token').val('<?php echo $access_token ?>').addClass('cff-success');
                                //Check the own access token setting so it reveals token field
                                if( $('#cff_show_access_token:checked').length < 1 ){
                                    $("#cff_show_access_token").trigger("change").prop( "checked", true );
                                }
                            });
                            </script>
                        <?php
                        }

                    }


                    if( !empty($pages_data_arr->data) || $cff_is_groups ){
                    //Show the pages they manage
                        echo '<div id="cff_fb_login_modal" class="cff_modal_tokens cffnomodal">';
                        echo '<div class="cff_modal_box">';
                        echo '<div class="cff-managed-pages">';

                        if( $cff_is_groups ){
                            //GROUPS

                            if( empty($groups_data_arr->data) && empty($groups_admin_data_arr->data) ){
                                echo '<h3>No Groups Returned</h3>';
                                echo "<p>Facebook has not returned any groups for your user. It is only possible to display a feed from a group which you are either an admin or a member. Please note, if you are not an admin of the group then it is required that an admin add our app in the group settings in order to display a feed.</p><p>Please either create or join a Facebook group and then follow the directions when connecting your account on this page.</p>";
                                echo '<a href="JavaScript:void(0);" class="button button-primary" id="cff-close-modal-primary-button">Close</a>';
                            } else {


	                            \cff_main()->cff_error_reporter->remove_error( 'connection' );
                                echo '<div class="cff-groups-list">';
                                    echo '<p style="margin-top: 0;"><i class="fa fa-check-circle" aria-hidden="true" style="font-size: 15px; margin: 0 8px 0 2px;"></i>Select a Facebook group below to get an Access Token.</p>';

                                    echo '<div class="cff-pages-wrap">';
                                    //Admin groups
                                    foreach ( $groups_admin_data_arr->data as $page => $group_data ) {
                                        echo '<div class="cff-managed-page cff-group-admin';
                                        if( $group_data->id == $page_id_val ) echo ' cff-page-selected';
                                        echo '" data-token="'.$access_token.'" data-page-id="'.$group_data->id.'" id="cff_'.$group_data->id.'" data-pagetype="group">';
                                        echo '<p>';
                                        if( isset( $group_data->picture->data->url ) ) echo '<img class="cff-page-avatar" border="0" height="50" width="50" src="'.$group_data->picture->data->url.'">';
                                        echo '<b class="cff-page-info-name">'.$group_data->name.'</b><span class="cff-page-info">(Group ID: '.$group_data->id.')</span></p>';
                                        echo '<div class="cff-group-admin-icon"><i class="fa fa-user" aria-hidden="true"></i> Admin</div>';
                                        echo '</div>';
                                    }
                                    //Member groups
                                    foreach ( $groups_data_arr->data as $page => $group_data ) {
                                        echo '<div class="cff-managed-page';
                                        if( $group_data->id == $page_id_val ) echo ' cff-page-selected';
                                        echo '" data-token="'.$access_token.'" data-page-id="'.$group_data->id.'" id="cff_'.$group_data->id.'" data-pagetype="group">';
                                        echo '<p>';
                                        if( isset( $group_data->picture->data->url ) ) echo '<img class="cff-page-avatar" border="0" height="50" width="50" src="'.$group_data->picture->data->url.'">';
                                        echo '<b class="cff-page-info-name">'.$group_data->name.'</b><span class="cff-page-info">(Group ID: '.$group_data->id.')</span></p>';
                                        echo '</div>';
                                    }
                                    echo '</div>';
                                    echo '<a href="JavaScript:void(0);" class="button button-primary cff-group-btn" id="cff-insert-token" disabled="disabled">Use token for this Group</a>';
                                    if( $cff_token_expiration == "60 days" ) echo '<div id="cff_token_expiration_note" class="cff-error"><b>Important:</b> This token will expire in 60 days.<br /><a href="https://smashballoon.com/extending-a-group-access-token-so-it-never-expires/" target="_blank">Extend token so it never expires</a></div>';
                                echo '</div>';

                                echo '<div id="cff-group-installation">';
                                    echo '<h3>Important</h3>';

                                    echo '<div id="cff-group-admin-directions">';
                                        echo '<p>To display a feed from your group you need to add our app in your Facebook group settings:</p>';
                                        echo '<ul>';
                                        echo '<li><b>1)</b> Go to your group settings page by clicking <a id="cff-group-edit" href="https://www.facebook.com/groups/" target="_blank">here<i class="fa fa-external-link" aria-hidden="true" style="font-size: 13px; position: relative; top: 2px; margin-left: 5px;"></i></a></li>';
                                        echo '<li><b>2)</b> In the "Apps" section click "Add Apps".</li>';
                                        echo '<li><b>3)</b> Search for "Smash Balloon" and select our app (<a id="cff-group-app-tooltip">screenshot</a>).<img id="cff-group-app-screenshot" src="'. CFF_PLUGIN_URL ."admin/assets/img/group-app.png"  .'" alt="Thumbnail Layout" /></li>';
                                        echo '<li><b>4</b>) Click "Add".</li>';
                                        echo '</ul>';

                                        echo '<p style="margin-bottom: 10px;">You can now use the plugin to display a feed from your group.</p>';
                                    echo '</div>';

                                    echo '<div id="cff-group-member-directions">';
                                        echo '<p>To display a feed from this group an admin needs to first add our app in the group settings. Please ask an admin to follow the directions <a href="https://smashballoon.com/adding-our-app-to-a-facebook-group/" target="_blank">here</a> to add our app.</p>';
                                        echo '<p>Once this is done you will then be able to display a feed from this group.</p>';
                                    echo '</div>';

                                    echo '<a href="JavaScript:void(0);" class="button button-primary" id="cff-close-modal-primary-button">Done</a>';
                                    echo '<a href="https://smashballoon.com/display-facebook-group-feed/" target="_blank" class="button button-secondary"><i class="fa fa-life-ring"></i> Help</a>';
                                echo '</div>';

                            }

                        } else {
                            //PAGES


	                        \cff_main()->cff_error_reporter->remove_error( 'connection' );

                            echo '<p class="cff-tokens-note"><i class="fa fa-check-circle" aria-hidden="true" style="font-size: 15px; margin: 0 8px 0 2px;"></i> Select a Facebook page below to connect it.</p>';

                            echo '<div class="cff-pages-wrap">';
                            foreach ( $pages_data_arr->data as $page => $page_data ) {
                                echo '<div class="cff-managed-page ';
                                if( $page_data->id == $page_id_val ) echo 'cff-page-selected';
                                echo '" data-token="'.$page_data->access_token.'" data-page-id="'.$page_data->id.'" data-pagetype="page">';
                                echo '<p><img class="cff-page-avatar" border="0" height="50" width="50" src="https://graph.facebook.com/'.$page_data->id.'/picture"><b class="cff-page-info-name">'.$page_data->name.'</b><span class="cff-page-info">(Page ID: '.$page_data->id.')</span></p>';
                                echo '</div>';
                            }
                            echo '</div>';

                            $cff_use_token_text = 'Connect this page';
                            echo '<a href="JavaScript:void(0);" id="cff-insert-token" class="button button-primary" disabled="disabled">'.$cff_use_token_text.'</a>';
                            echo '<a href="JavaScript:void(0);" id="cff-insert-all-tokens" class="button button-secondary cff_connect_all">Connect All</a>';
                            echo "<a href='https://smashballoon.com/facebook-pages-im-admin-of-arent-listed-after-authorizing-plugin/' target='_blank' class='cff-connection-note'>One of my pages isn't listed</a>";

                        }

                        echo '</div>';
                        echo '<a href="JavaScript:void(0);" class="cff-modal-close"><i class="fa fa-times"></i></a>';
                        echo '</div>';
                        echo '</div>';

                        echo '<a href="JavaScript:void(0);" class="cff_admin_btn" id="cff_fb_show_tokens"><i class="fa fa-th-list" aria-hidden="true" style="font-size: 14px; margin-right: 8px;"></i>';
                        $cff_is_groups ? _e( "Show Available Groups", "custom-facebook-feed" ) : _e( "Show Available Pages", "custom-facebook-feed" );
                        echo '</a>';

                    }

                }
            }
            ?>

            <table class="form-table">
                <tbody>
                    <tr valign="top">
                        <th scope="row"><label><?php _e('Facebook Page ID<br /><i style="font-weight: normal; font-size: 12px;">ID of your Facebook Page or Group</i>', 'custom-facebook-feed'); ?></label><code class="cff_shortcode"> id
                        Eg: id="YOUR_PAGE_OR_GROUP_ID"</code></th>
                        <td>
                            <p id="cff_primary_account_label"></p>
                            <input name="cff_page_id" id="cff_page_id" type="text" value="<?php esc_attr_e( $page_id_val, 'custom-facebook-feed' ); ?>" size="45" data-page-id="<?php esc_attr_e( $page_id_val ); ?>" />
                            &nbsp;<a class="cff-tooltip-link" href="JavaScript:void(0);"><?php _e('What\'s my Page ID?', 'custom-facebook-feed'); ?></a>
                            <br /><i style="color: #666; font-size: 11px;">Eg. 1234567890123 or smashballoon</i>
                            <div class="cff-tooltip cff-more-info">
                                <ul>
                                    <li><?php _e('<b>Facebook Page</b><br />
                                        You can find the ID of your Facebook <b>Page</b> from the URL. In each URL format, the ID is highlighted below:<br /><br />
                                    URL Format 1: <code>https://www.facebook.com/<span class="cff-highlight">your_page_name</span></code>
                                    <br />
                                    URL Format 2: <code>https://www.facebook.com/your_page_name-<span class="cff-highlight">1234567890</span></code>
                                    <br />
                                    URL Format 3: <code>https://www.facebook.com/pages/your_page_name/<span class="cff-highlight">1234567890</span></code>
                                    '); ?>
                                    </li>
                                    <li><?php _e('<b>Facebook Group</b><br />You can find the ID of your Facebook <b>Group</b> from the URL, like so: <code>https://www.facebook.com/groups/<span class="cff-highlight">1234567890</span></code>'); ?></li>
                                </ul>
                            </div>
                        </td>
                    </tr>

                    <?php
                    //When connecting an account check the current access token to see if it has an error. If so then add a class to the field and replace it automatically in JS when getting a new one.
                    $cff_replace_token = false;
                    if( isset($_GET['cff_access_token']) && isset($_GET['cff_final_response']) ){

                        if( $_GET['cff_final_response'] == 'true' ){
                            $api_page_id = trim($page_id_val);
                            $url = 'https://graph.facebook.com/'.$api_page_id.'?limit=1&fields=id&access_token='.$access_token_val;
                            $accounts_data = CFF_Utils::cff_fetchUrl($url);
                            //If there's an error (and it's not the PPCA one) then mark the token as needing to be replaced
                            if (strpos($accounts_data, 'error') !== false && strpos($accounts_data, 'Public') == false) $cff_replace_token = true;
                        }

                    }

                    ?>

                    <tr valign="top">

                        <?php
                        //Check to see whether we've already checked the token against the API. If so, then don't do it again until the settings are saved which clears this transient.
                        //This var is used to add an attr to the access token field below. If it's set then ana Ajax call is made in the admin JS file which checks the API to see if the token matches the ID.
                        $cff_check_api_for_ppca = false;
                        if( ! get_transient( 'cff_ppca_admin_token_check' ) ){
                            $cff_check_api_for_ppca = true;
                            set_transient( 'cff_ppca_admin_token_check', 1, YEAR_IN_SECONDS );
                        }

                        ?>
                        <th scope="row" style="padding-bottom: 10px;"><?php _e('Facebook Access Token', 'custom-facebook-feed'); ?><br /><i style="font-weight: normal; font-size: 12px; color: red;"><?php _e('Required', 'custom-facebook-feed'); ?></i></th>
                        <td>
                            <textarea name="cff_access_token" id="cff_access_token" <?php if($cff_replace_token) echo 'class="cff-replace-token"' ?> style="min-width: 60%;" data-accesstoken="<?php esc_attr_e( $access_token_val ); ?>" <?php if($cff_check_api_for_ppca) echo 'data-check-ppca="true"'; ?>><?php esc_attr_e( $access_token_val ); ?></textarea>

                            <div class="cff-ppca-check-notice cff-error"><?php _e("<b>Important:</b> This Access Token does not match the Facebook ID used above. To check which Facebook Page this Access Token is for, <a href='https://smashballoon.com/checking-what-facebook-page-an-access-token-is-from/' target='_blank'>see here</a>.", 'custom-facebook-feed'); ?>

                                <span style="display: block; padding-top: 4px;"><i class="fa fa-question-circle" aria-hidden="true"></i>&nbsp;<a class="cff-tooltip-link" style="margin:0;" href="JavaScript:void(0);"><?php _e("Why am I seeing this?"); ?></a></span>
                                <p class="cff-tooltip cff-more-info"><?php _e("Due to <a href='https://smashballoon.com/facebook-api-changes-september-4-2020/' target='_blank'>Facebook API changes</a> on September 4, 2020, it is only possible to display Facebook feeds from a Facebook page you have admin permissions on. This Access Token doesn't appear to match the Facebook page specified above that you are trying to display a feed from. To troubleshoot this issue, please <a href='https://smashballoon.com/facebook-ppca-error-notice/' target='_blank'>see here</a>.", 'custom-facebook-feed'); ?></p>
                            </div>

                            <br /><a class="cff-tooltip-link" style="margin-left: 3px;" href="JavaScript:void(0);"><?php _e("What is this?", 'custom-facebook-feed'); ?></a>
                            <p class="cff-tooltip cff-more-info"><?php _e("In order to connect to Facebook and get a feed, you need to use an Access Token. To get one, simply use the blue button above to log into your Facebook account. You will then receive a token that will be used to connect to Facebook's API. If you already have an Access Token then you can enter it here.", 'custom-facebook-feed'); ?></p>

                            <div class="cff-notice cff-profile-error cff-access-token">
                                <?php _e("<p>This doesn't appear to be an Access Token. Please be sure that you didn't enter your App Secret instead of your Access Token.<br />Your App ID and App Secret are used to obtain your Access Token; simply paste them into the fields in the last step of the <a href='https://smashballoon.com/custom-facebook-feed/access-token/' target='_blank'>Access Token instructions</a> and click '<b>Get my Access Token</b>'.</p>", 'custom-facebook-feed'); ?>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>

            <div id="cff_accounts_section">
                <a href="JavaScript:void(0);" class="button-secondary button" id="cff_manual_account_button">Manually connect account</a>

                <div id="cff_manual_account">
                    <div id="cff_manual_account_step_1">
                        <label for="cff_manual_account_type"><?php _e('Is it a Facebook page or group?'); ?></label>
                        <select name="cff_manual_account_type" id="cff_manual_account_type">
                            <option value="" disabled selected><?php _e('- Select one -'); ?></option>
                            <option value="page"><?php _e('Page'); ?></option>
                            <option value="group"><?php _e('Group'); ?></option>
                        </select>
                        <a href="javascript:void(0);" class="cff_manual_forward button-primary"><i class="fa fa-chevron-right" aria-hidden="true"></i></a>
                    </div>

                    <div id="cff_manual_account_step_2" class="cff_account_type_page">
                        <div>
                            <label for="cff_manual_account_name"><span class="cff_page"><?php _e('Page'); ?></span><span class="cff_group"><?php _e('Group'); ?></span> <?php _e('Name'); ?> <span style="font-size: 11px;"><?php _e('(optional)'); ?></span></label>
                            <input name="cff_manual_account_name" id="cff_manual_account_name" type="text" value="" placeholder="Eg: John's Facebook Page" />
                            <a class="cff-tooltip-link" href="JavaScript:void(0);"><i class="fa fa-question-circle" aria-hidden="true"></i></a>
                            <p class="cff-tooltip cff-more-info"><?php _e('This is just for labeling the account here on this settings page'); ?></p>
                        </div>

                        <div>
                            <label for="cff_manual_account_id"><span class="cff_page"><?php _e('Page'); ?></span><span class="cff_group"><?php _e('Group'); ?></span> <?php _e('ID'); ?></label>
                            <input name="cff_manual_account_id" id="cff_manual_account_id" type="text" value="" placeholder="Eg: 1234567890123 or smashballoon" />
                            <a class="cff-tooltip-link" href="JavaScript:void(0);"><i class="fa fa-question-circle" aria-hidden="true"></i></a>
                            <p class="cff-tooltip cff-more-info"><?php _e('The ID of the Facebook'); ?> <span class="cff_page"><?php _e('Page'); ?></span><span class="cff_group"><?php _e('Group'); ?></span> <?php _e('you want to add.'); ?> &nbsp;<a href='https://smashballoon.com/custom-facebook-feed/id/' target='_blank'><?php _e("How do I find my Page ID?"); ?></a></p>
                        </div>

                        <div>
                            <label for="cff_manual_account_token"><?php _e('Access Token'); ?></label>
                            <input name="cff_manual_account_token" id="cff_manual_account_token" type="text" value="" />
                            <a class="cff-tooltip-link" href="JavaScript:void(0);"><i class="fa fa-question-circle" aria-hidden="true"></i></a>
                            <p class="cff-tooltip cff-more-info"><?php _e('The Access Token of the Facebook'); ?> <span class="cff_page"><?php _e('Page'); ?></span><span class="cff_group"><?php _e('Group'); ?></span> <?php _e('you want to add'); ?></p>
                        </div>

                        <?php
                        $cff_submit_btn_atts = array( 'disabled' => 'true' );
                        submit_button('Connect Account', 'primary', 'submit', true, $cff_submit_btn_atts);
                        ?>
                        <a href="javascript:void(0);" class="cff_manual_back button-secondary">Back</a>
                    </div>

                </div>

                <h3 class="cff_connected_actions">Connected Accounts:</h3>
                <div id="cff_connected_accounts_wrap"><?php //Add connected accounts here ?></div>

                <div class="cff_connected_actions cff_feeds_account_ctn">
                	<?php if ( CFF_Feed_Locator::count_unique() >= 1 ) : ?>
                        <div class="cff_locations_link">
                            <a href="?page=cff-top&amp;tab=allfeeds"><svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="search" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svg-inline--fa fa-search fa-w-16 fa-2x"><path fill="currentColor" d="M508.5 468.9L387.1 347.5c-2.3-2.3-5.3-3.5-8.5-3.5h-13.2c31.5-36.5 50.6-84 50.6-136C416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c52 0 99.5-19.1 136-50.6v13.2c0 3.2 1.3 6.2 3.5 8.5l121.4 121.4c4.7 4.7 12.3 4.7 17 0l22.6-22.6c4.7-4.7 4.7-12.3 0-17zM208 368c-88.4 0-160-71.6-160-160S119.6 48 208 48s160 71.6 160 160-71.6 160-160 160z" class=""></path></svg> <?php _e('Feed Finder', 'custom-facebook-feed'); ?></a>
                        </div>
                    <?php endif; ?>
                    <a href="JavaScript:void(0);" id="cff_export_accounts">Show raw account data</a>
                    <div id="cff_export_accounts_wrap">
                        <textarea name="cff_connected_accounts" id="cff_connected_accounts" style="width: 100%;" rows="5" /><?php echo stripslashes( esc_attr( $cff_connected_accounts_val ) ); ?></textarea>
                    </div>

                    <?php submit_button('Save Settings'); ?>
                </div>

            </div>

            <hr />
            <table class="form-table">
                <tbody>
                    <h3><?php _e('Settings', 'custom-facebook-feed'); ?></h3>

                    <tr valign="top" class="cff-page-type">
                        <th scope="row"><label><?php _e('Is it a page or group?'); ?></label><code class="cff_shortcode"> pagetype
                        Eg: pagetype=group</code></th>
                        <td>
                            <select name="cff_page_type" id="cff_page_type" style="width: 100px;">
                                <option value="page" <?php if($cff_page_type_val == "page") echo 'selected="selected"' ?> ><?php _e('Page'); ?></option>
                                <option value="group" <?php if($cff_page_type_val == "group") echo 'selected="selected"' ?> ><?php _e('Group'); ?></option>
                                <option value="profile" <?php if($cff_page_type_val == "profile") echo 'selected="selected"' ?> ><?php _e('Profile'); ?></option>
                            </select>
                            <div class="cff-notice cff-profile-error cff-page-type">
                                <?php _e("<p>Due to Facebook's privacy policy you're not able to display posts from a personal profile, only from a public Facebook Page.</p><p>If you're using a profile to represent a business, organization, product, public figure or the like, then Facebook recommends <a href='http://www.facebook.com/help/175644189234902/' target='_blank'>converting your profile to a page</a>. There are many advantages to using pages over profiles, and once you've converted then the plugin will be able to successfully retrieve and display all of your posts.</p>", 'custom-facebook-feed'); ?>
                            </div>
                        </td>
                    </tr>

                    <tr valign="top">
                        <th scope="row"><label><?php _e('Show posts on my page by:', 'custom-facebook-feed'); ?></label><code class="cff_shortcode"> showpostsby
                        Eg: showpostsby=others</code></th>
                        <td>
                            <select name="cff_show_others" id="cff_show_others" style="width: 250px;">
                                <option value="me" <?php if($cff_show_others_val == 'me') echo 'selected="selected"' ?> ><?php _e('Only the page owner (me)', 'custom-facebook-feed'); ?></option>
                                <option value="others" <?php if($cff_show_others_val == 'others' || $cff_show_others_val == 'on') echo 'selected="selected"' ?> ><?php _e('Page owner + other people', 'custom-facebook-feed'); ?></option>
                                <option value="onlyothers" <?php if($cff_show_others_val == 'onlyothers') echo 'selected="selected"' ?> ><?php _e('Only other people', 'custom-facebook-feed'); ?></option>
                            </select>
                        </td>
                    </tr>

                    <tr valign="top">
                        <th scope="row"><label><?php _e('Number of posts to display', 'custom-facebook-feed'); ?></label><code class="cff_shortcode"> num, nummobile
                        Eg: num=5
                        nummobile=3</code></th>
                        <td>
                            <input name="cff_num_show" type="text" value="<?php esc_attr_e( $num_show_val, 'custom-facebook-feed' ); ?>" size="4" />
                            <i style="color: #666; font-size: 11px;">Max 100</i>
                            <div style="margin: 8px 0 0 1px; font-size: 12px;">
                                <input type="checkbox" name="cff_show_num_mobile" id="cff_show_num_mobile" <?php if(! empty( $cff_num_mobile )) echo 'checked="checked"' ?> />&nbsp;<label for="cff_show_num_mobile"><?php _e('Show different number for mobile'); ?></label>
                                <div class="cff-mobile-col-settings">
                                    <div class="cff-row">
                                        <label title="Click for shortcode option"><?php _e('Mobile Number', 'custom-facebook-feed'); ?>:</label><code class="cff_shortcode"> nummobile
                                        Eg: nummobile=4</code>
                                        <input type="text" name="cff_num_mobile" id="cff_num_mobile" size="4" value="<?php echo esc_attr( $cff_num_mobile ); ?>">
                                        <i style="color: #666; font-size: 11px;"><?php _e('Leave blank for default', 'custom-facebook-feed'); ?></i>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><label><?php _e('Facebook API post limit', 'custom-facebook-feed'); ?></label><code class="cff_shortcode"> limit
                        Eg: limit=10</code></th>
                        <td>
                            <select name="cff_limit_setting" id="cff_limit_setting" style="width: 90px;">
                                <option value="auto" selected="selected"><?php _e('Auto'); ?></option>
                                <option value="manual"><?php _e('Manual'); ?></option>
                            </select>
                            <div id="cff_limit_manual_settings">
                                <input name="cff_post_limit" id="cff_post_limit" type="text" value="<?php esc_attr_e( $cff_post_limit_val ); ?>" size="4" />
                                <i style="color: #666; font-size: 11px;">Eg. 10. Max 100.</i>
                            </div>
                            <a class="cff-tooltip-link" href="JavaScript:void(0);"><i class="fa fa-question-circle" aria-hidden="true"></i></a>
                            <p class="cff-tooltip cff-more-info"><?php _e("The post 'limit' is the number of posts retrieved from the Facebook API. Most users won't need to manually adjust this setting as by default the plugin automatically retrieves a few more posts from the Facebook API than you need, as some posts may be filtered out.", "custom-facebook-feed"); ?><br /><br />

                                <b><?php _e('Auto', 'custom-facebook-feed'); ?></b> (<?php _e('Recommended', 'custom-facebook-feed'); ?>)<br />
                                <?php _e("Allow the plugin to automatically decide how many posts to retrieve from Facebook's API.", "custom-facebook-feed"); ?><br /><br />

                                <b><?php _e('Manual', 'custom-facebook-feed'); ?></b><br />
                                <?php _e("Manually set how many posts to retrieve from Facebook's API.<br /><b>Note:</b> If you choose to retrieve a high number of posts then it will take longer for Facebook to return the posts when the plugin checks for new ones.", "custom-facebook-feed"); ?></p>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><?php _e('Check for new posts every', 'custom-facebook-feed'); ?></th>
                        <td>
                            <input name="cff_cache_time" type="text" value="<?php esc_attr_e( $cff_cache_time_val, 'custom-facebook-feed' ); ?>" size="4" />
                            <select name="cff_cache_time_unit" style="width: 100px;">
                                <option value="minutes" <?php if($cff_cache_time_unit_val == "minutes") echo 'selected="selected"' ?> ><?php _e('Minutes', 'custom-facebook-feed'); ?></option>
                                <option value="hours" <?php if($cff_cache_time_unit_val == "hours") echo 'selected="selected"' ?> ><?php _e('Hours', 'custom-facebook-feed'); ?></option>
                                <option value="days" <?php if($cff_cache_time_unit_val == "days") echo 'selected="selected"' ?> ><?php _e('Days', 'custom-facebook-feed'); ?></option>
                            </select>
                            <a class="cff-tooltip-link" href="JavaScript:void(0);"><i class="fa fa-question-circle" aria-hidden="true"></i></a>
                            <p class="cff-tooltip cff-more-info"><?php _e('Your Facebook posts and comments data is temporarily cached by the plugin in your WordPress database. You can choose how long this data should be cached for. If you set the time to 60 minutes then the plugin will clear the cached data after that length of time, and the next time the page is viewed it will check for new data.', 'custom-facebook-feed'); ?></p>
                        </td>
                    </tr>

                    <tr valign="top">
                        <th scope="row"><label><?php _e('Localization', 'custom-facebook-feed'); ?></label><code class="cff_shortcode"> locale
                        Eg: locale=es_ES</code></th>
                        <td>
                            <select name="cff_locale">
                                <option value="af_ZA" <?php if($cff_locale_val == "af_ZA") echo 'selected="selected"' ?> ><?php _e('Afrikaans', 'custom-facebook-feed'); ?></option>
                                <option value="ar_AR" <?php if($cff_locale_val == "ar_AR") echo 'selected="selected"' ?> ><?php _e('Arabic', 'custom-facebook-feed'); ?></option>
                                <option value="az_AZ" <?php if($cff_locale_val == "az_AZ") echo 'selected="selected"' ?> ><?php _e('Azerbaijani', 'custom-facebook-feed'); ?></option>
                                <option value="be_BY" <?php if($cff_locale_val == "be_BY") echo 'selected="selected"' ?> ><?php _e('Belarusian', 'custom-facebook-feed'); ?></option>
                                <option value="bg_BG" <?php if($cff_locale_val == "bg_BG") echo 'selected="selected"' ?> ><?php _e('Bulgarian', 'custom-facebook-feed'); ?></option>
                                <option value="bn_IN" <?php if($cff_locale_val == "bn_IN") echo 'selected="selected"' ?> ><?php _e('Bengali', 'custom-facebook-feed'); ?></option>
                                <option value="bs_BA" <?php if($cff_locale_val == "bs_BA") echo 'selected="selected"' ?> ><?php _e('Bosnian', 'custom-facebook-feed'); ?></option>
                                <option value="ca_ES" <?php if($cff_locale_val == "ca_ES") echo 'selected="selected"' ?> ><?php _e('Catalan', 'custom-facebook-feed'); ?></option>
                                <option value="cs_CZ" <?php if($cff_locale_val == "cs_CZ") echo 'selected="selected"' ?> ><?php _e('Czech', 'custom-facebook-feed'); ?></option>
                                <option value="cy_GB" <?php if($cff_locale_val == "cy_GB") echo 'selected="selected"' ?> ><?php _e('Welsh', 'custom-facebook-feed'); ?></option>
                                <option value="da_DK" <?php if($cff_locale_val == "da_DK") echo 'selected="selected"' ?> ><?php _e('Danish', 'custom-facebook-feed'); ?></option>
                                <option value="de_DE" <?php if($cff_locale_val == "de_DE") echo 'selected="selected"' ?> ><?php _e('German', 'custom-facebook-feed'); ?></option>
                                <option value="el_GR" <?php if($cff_locale_val == "el_GR") echo 'selected="selected"' ?> ><?php _e('Greek', 'custom-facebook-feed'); ?></option>
                                <option value="en_GB" <?php if($cff_locale_val == "en_GB") echo 'selected="selected"' ?> ><?php _e('English (UK)', 'custom-facebook-feed'); ?></option>
                                <option value="en_PI" <?php if($cff_locale_val == "en_PI") echo 'selected="selected"' ?> ><?php _e('English (Pirate)', 'custom-facebook-feed'); ?></option>
                                <option value="en_UD" <?php if($cff_locale_val == "en_UD") echo 'selected="selected"' ?> ><?php _e('English (Upside Down)', 'custom-facebook-feed'); ?></option>
                                <option value="en_US" <?php if($cff_locale_val == "en_US") echo 'selected="selected"' ?> ><?php _e('English (US)', 'custom-facebook-feed'); ?></option>
                                <option value="eo_EO" <?php if($cff_locale_val == "eo_EO") echo 'selected="selected"' ?> ><?php _e('Esperanto', 'custom-facebook-feed'); ?></option>
                                <option value="es_ES" <?php if($cff_locale_val == "es_ES") echo 'selected="selected"' ?> ><?php _e('Spanish (Spain)', 'custom-facebook-feed'); ?></option>
                                <option value="es_LA" <?php if($cff_locale_val == "es_LA") echo 'selected="selected"' ?> ><?php _e('Spanish', 'custom-facebook-feed'); ?></option>
                                <option value="et_EE" <?php if($cff_locale_val == "et_EE") echo 'selected="selected"' ?> ><?php _e('Estonian', 'custom-facebook-feed'); ?></option>
                                <option value="eu_ES" <?php if($cff_locale_val == "eu_ES") echo 'selected="selected"' ?> ><?php _e('Basque', 'custom-facebook-feed'); ?></option>
                                <option value="fa_IR" <?php if($cff_locale_val == "fa_IR") echo 'selected="selected"' ?> ><?php _e('Persian', 'custom-facebook-feed'); ?></option>
                                <option value="fb_LT" <?php if($cff_locale_val == "fb_LT") echo 'selected="selected"' ?> ><?php _e('Leet Speak', 'custom-facebook-feed'); ?></option>
                                <option value="fi_FI" <?php if($cff_locale_val == "fi_FI") echo 'selected="selected"' ?> ><?php _e('Finnish', 'custom-facebook-feed'); ?></option>
                                <option value="fo_FO" <?php if($cff_locale_val == "fo_FO") echo 'selected="selected"' ?> ><?php _e('Faroese', 'custom-facebook-feed'); ?></option>
                                <option value="fr_CA" <?php if($cff_locale_val == "fr_CA") echo 'selected="selected"' ?> ><?php _e('French (Canada)', 'custom-facebook-feed'); ?></option>
                                <option value="fr_FR" <?php if($cff_locale_val == "fr_FR") echo 'selected="selected"' ?> ><?php _e('French (France)', 'custom-facebook-feed'); ?></option>
                                <option value="fy_NL" <?php if($cff_locale_val == "fy_NL") echo 'selected="selected"' ?> ><?php _e('Frisian', 'custom-facebook-feed'); ?></option>
                                <option value="ga_IE" <?php if($cff_locale_val == "ga_IE") echo 'selected="selected"' ?> ><?php _e('Irish', 'custom-facebook-feed'); ?></option>
                                <option value="gl_ES" <?php if($cff_locale_val == "gl_ES") echo 'selected="selected"' ?> ><?php _e('Galician', 'custom-facebook-feed'); ?></option>
                                <option value="he_IL" <?php if($cff_locale_val == "he_IL") echo 'selected="selected"' ?> ><?php _e('Hebrew', 'custom-facebook-feed'); ?></option>
                                <option value="hi_IN" <?php if($cff_locale_val == "hi_IN") echo 'selected="selected"' ?> ><?php _e('Hindi', 'custom-facebook-feed'); ?></option>
                                <option value="hr_HR" <?php if($cff_locale_val == "hr_HR") echo 'selected="selected"' ?> ><?php _e('Croatian', 'custom-facebook-feed'); ?></option>
                                <option value="hu_HU" <?php if($cff_locale_val == "hu_HU") echo 'selected="selected"' ?> ><?php _e('Hungarian', 'custom-facebook-feed'); ?></option>
                                <option value="hy_AM" <?php if($cff_locale_val == "hy_AM") echo 'selected="selected"' ?> ><?php _e('Armenian', 'custom-facebook-feed'); ?></option>
                                <option value="id_ID" <?php if($cff_locale_val == "id_ID") echo 'selected="selected"' ?> ><?php _e('Indonesian', 'custom-facebook-feed'); ?></option>
                                <option value="is_IS" <?php if($cff_locale_val == "is_IS") echo 'selected="selected"' ?> ><?php _e('Icelandic', 'custom-facebook-feed'); ?></option>
                                <option value="it_IT" <?php if($cff_locale_val == "it_IT") echo 'selected="selected"' ?> ><?php _e('Italian', 'custom-facebook-feed'); ?></option>
                                <option value="ja_JP" <?php if($cff_locale_val == "ja_JP") echo 'selected="selected"' ?> ><?php _e('Japanese', 'custom-facebook-feed'); ?></option>
                                <option value="ka_GE" <?php if($cff_locale_val == "ka_GE") echo 'selected="selected"' ?> ><?php _e('Georgian', 'custom-facebook-feed'); ?></option>
                                <option value="km_KH" <?php if($cff_locale_val == "km_KH") echo 'selected="selected"' ?> ><?php _e('Khmer', 'custom-facebook-feed'); ?></option>
                                <option value="ko_KR" <?php if($cff_locale_val == "ko_KR") echo 'selected="selected"' ?> ><?php _e('Korean', 'custom-facebook-feed'); ?></option>
                                <option value="ku_TR" <?php if($cff_locale_val == "ku_TR") echo 'selected="selected"' ?> ><?php _e('Kurdish', 'custom-facebook-feed'); ?></option>
                                <option value="la_VA" <?php if($cff_locale_val == "la_VA") echo 'selected="selected"' ?> ><?php _e('Latin', 'custom-facebook-feed'); ?></option>
                                <option value="lt_LT" <?php if($cff_locale_val == "lt_LT") echo 'selected="selected"' ?> ><?php _e('Lithuanian', 'custom-facebook-feed'); ?></option>
                                <option value="lv_LV" <?php if($cff_locale_val == "lv_LV") echo 'selected="selected"' ?> ><?php _e('Latvian', 'custom-facebook-feed'); ?></option>
                                <option value="mk_MK" <?php if($cff_locale_val == "mk_MK") echo 'selected="selected"' ?> ><?php _e('Macedonian', 'custom-facebook-feed'); ?></option>
                                <option value="ml_IN" <?php if($cff_locale_val == "ml_IN") echo 'selected="selected"' ?> ><?php _e('Malayalam', 'custom-facebook-feed'); ?></option>
                                <option value="ms_MY" <?php if($cff_locale_val == "ms_MY") echo 'selected="selected"' ?> ><?php _e('Malay', 'custom-facebook-feed'); ?></option>
                                <option value="nb_NO" <?php if($cff_locale_val == "nb_NO") echo 'selected="selected"' ?> ><?php _e('Norwegian (bokmal)', 'custom-facebook-feed'); ?></option>
                                <option value="ne_NP" <?php if($cff_locale_val == "ne_NP") echo 'selected="selected"' ?> ><?php _e('Nepali', 'custom-facebook-feed'); ?></option>
                                <option value="nl_NL" <?php if($cff_locale_val == "nl_NL") echo 'selected="selected"' ?> ><?php _e('Dutch', 'custom-facebook-feed'); ?></option>
                                <option value="nn_NO" <?php if($cff_locale_val == "nn_NO") echo 'selected="selected"' ?> ><?php _e('Norwegian (nynorsk)', 'custom-facebook-feed'); ?></option>
                                <option value="pa_IN" <?php if($cff_locale_val == "pa_IN") echo 'selected="selected"' ?> ><?php _e('Punjabi', 'custom-facebook-feed'); ?></option>
                                <option value="pl_PL" <?php if($cff_locale_val == "pl_PL") echo 'selected="selected"' ?> ><?php _e('Polish', 'custom-facebook-feed'); ?></option>
                                <option value="ps_AF" <?php if($cff_locale_val == "ps_AF") echo 'selected="selected"' ?> ><?php _e('Pashto', 'custom-facebook-feed'); ?></option>
                                <option value="pt_BR" <?php if($cff_locale_val == "pt_BR") echo 'selected="selected"' ?> ><?php _e('Portuguese (Brazil)', 'custom-facebook-feed'); ?></option>
                                <option value="pt_PT" <?php if($cff_locale_val == "pt_PT") echo 'selected="selected"' ?> ><?php _e('Portuguese (Portugal)', 'custom-facebook-feed'); ?></option>
                                <option value="ro_RO" <?php if($cff_locale_val == "ro_RO") echo 'selected="selected"' ?> ><?php _e('Romanian', 'custom-facebook-feed'); ?></option>
                                <option value="ru_RU" <?php if($cff_locale_val == "ru_RU") echo 'selected="selected"' ?> ><?php _e('Russian', 'custom-facebook-feed'); ?></option>
                                <option value="sk_SK" <?php if($cff_locale_val == "sk_SK") echo 'selected="selected"' ?> ><?php _e('Slovak', 'custom-facebook-feed'); ?></option>
                                <option value="sl_SI" <?php if($cff_locale_val == "sl_SI") echo 'selected="selected"' ?> ><?php _e('Slovenian', 'custom-facebook-feed'); ?></option>
                                <option value="sq_AL" <?php if($cff_locale_val == "sq_AL") echo 'selected="selected"' ?> ><?php _e('Albanian', 'custom-facebook-feed'); ?></option>
                                <option value="sr_RS" <?php if($cff_locale_val == "sr_RS") echo 'selected="selected"' ?> ><?php _e('Serbian', 'custom-facebook-feed'); ?></option>
                                <option value="sv_SE" <?php if($cff_locale_val == "sv_SE") echo 'selected="selected"' ?> ><?php _e('Swedish', 'custom-facebook-feed'); ?></option>
                                <option value="sw_KE" <?php if($cff_locale_val == "sw_KE") echo 'selected="selected"' ?> ><?php _e('Swahili', 'custom-facebook-feed'); ?></option>
                                <option value="ta_IN" <?php if($cff_locale_val == "ta_IN") echo 'selected="selected"' ?> ><?php _e('Tamil', 'custom-facebook-feed'); ?></option>
                                <option value="te_IN" <?php if($cff_locale_val == "te_IN") echo 'selected="selected"' ?> ><?php _e('Telugu', 'custom-facebook-feed'); ?></option>
                                <option value="th_TH" <?php if($cff_locale_val == "th_TH") echo 'selected="selected"' ?> ><?php _e('Thai', 'custom-facebook-feed'); ?></option>
                                <option value="tl_PH" <?php if($cff_locale_val == "tl_PH") echo 'selected="selected"' ?> ><?php _e('Filipino', 'custom-facebook-feed'); ?></option>
                                <option value="tr_TR" <?php if($cff_locale_val == "tr_TR") echo 'selected="selected"' ?> ><?php _e('Turkish', 'custom-facebook-feed'); ?></option>
                                <option value="uk_UA" <?php if($cff_locale_val == "uk_UA") echo 'selected="selected"' ?> ><?php _e('Ukrainian', 'custom-facebook-feed'); ?></option>
                                <option value="vi_VN" <?php if($cff_locale_val == "vi_VN") echo 'selected="selected"' ?> ><?php _e('Vietnamese', 'custom-facebook-feed'); ?></option>
                                <option value="zh_CN" <?php if($cff_locale_val == "zh_CN") echo 'selected="selected"' ?> ><?php _e('Simplified Chinese (China)', 'custom-facebook-feed'); ?></option>
                                <option value="zh_HK" <?php if($cff_locale_val == "zh_HK") echo 'selected="selected"' ?> ><?php _e('Traditional Chinese (Hong Kong)', 'custom-facebook-feed'); ?></option>
                                <option value="zh_TW" <?php if($cff_locale_val == "zh_TW") echo 'selected="selected"' ?> ><?php _e('Traditional Chinese (Taiwan)', 'custom-facebook-feed'); ?></option>
                            </select>
                            <a class="cff-tooltip-link" href="JavaScript:void(0);"><i class="fa fa-question-circle" aria-hidden="true"></i></a>
                            <p class="cff-tooltip cff-more-info"><?php _e("This translates some of the text sent by Facebook, specifically, the descriptive post text (eg: Smash Balloon shared a link) and the text in the 'Like Box' widget. To find out how to translate the other text in the plugin see <a href='https://smashballoon.com/cff-how-does-the-plugin-handle-text-and-language-translation/' target='_blank'>this FAQ</a>."); ?></p>
                        </td>
                    </tr>

                    <tr>
                        <th><label for="cff_timezone" class="bump-left"><?php _e('Timezone', 'custom-facebook-feed'); ?></label><code class="cff_shortcode"> timezone
                        Eg: timezone="America/New_York"
                        <a href="http://php.net/manual/en/timezones.php" target="_blank">See full list</a></code></th>
                            <td>
                                <select name="cff_timezone" style="width: 300px;">
                                    <option value="Pacific/Midway" <?php if($cff_timezone == "Pacific/Midway") echo 'selected="selected"' ?> ><?php _e('(GMT-11:00) Midway Island, Samoa', 'custom-facebook-feed'); ?></option>
                                    <option value="America/Adak" <?php if($cff_timezone == "America/Adak") echo 'selected="selected"' ?> ><?php _e('(GMT-10:00) Hawaii-Aleutian', 'custom-facebook-feed'); ?></option>
                                    <option value="Etc/GMT+10" <?php if($cff_timezone == "Etc/GMT+10") echo 'selected="selected"' ?> ><?php _e('(GMT-10:00) Hawaii', 'custom-facebook-feed'); ?></option>
                                    <option value="Pacific/Marquesas" <?php if($cff_timezone == "Pacific/Marquesas") echo 'selected="selected"' ?> ><?php _e('(GMT-09:30) Marquesas Islands', 'custom-facebook-feed'); ?></option>
                                    <option value="Pacific/Gambier" <?php if($cff_timezone == "Pacific/Gambier") echo 'selected="selected"' ?> ><?php _e('(GMT-09:00) Gambier Islands', 'custom-facebook-feed'); ?></option>
                                    <option value="America/Anchorage" <?php if($cff_timezone == "America/Anchorage") echo 'selected="selected"' ?> ><?php _e('(GMT-09:00) Alaska', 'custom-facebook-feed'); ?></option>
                                    <option value="America/Ensenada" <?php if($cff_timezone == "America/Ensenada") echo 'selected="selected"' ?> ><?php _e('(GMT-08:00) Tijuana, Baja California', 'custom-facebook-feed'); ?></option>
                                    <option value="Etc/GMT+8" <?php if($cff_timezone == "Etc/GMT+8") echo 'selected="selected"' ?> ><?php _e('(GMT-08:00) Pitcairn Islands', 'custom-facebook-feed'); ?></option>
                                    <option value="America/Los_Angeles" <?php if($cff_timezone == "America/Los_Angeles") echo 'selected="selected"' ?> ><?php _e('(GMT-08:00) Pacific Time (US & Canada)', 'custom-facebook-feed'); ?></option>
                                    <option value="America/Denver" <?php if($cff_timezone == "America/Denver") echo 'selected="selected"' ?> ><?php _e('(GMT-07:00) Mountain Time (US & Canada)', 'custom-facebook-feed'); ?></option>
                                    <option value="America/Chihuahua" <?php if($cff_timezone == "America/Chihuahua") echo 'selected="selected"' ?> ><?php _e('(GMT-07:00) Chihuahua, La Paz, Mazatlan', 'custom-facebook-feed'); ?></option>
                                    <option value="America/Dawson_Creek" <?php if($cff_timezone == "America/Dawson_Creek") echo 'selected="selected"' ?> ><?php _e('(GMT-07:00) Arizona', 'custom-facebook-feed'); ?></option>
                                    <option value="America/Belize" <?php if($cff_timezone == "America/Belize") echo 'selected="selected"' ?> ><?php _e('(GMT-06:00) Saskatchewan, Central America', 'custom-facebook-feed'); ?></option>
                                    <option value="America/Cancun" <?php if($cff_timezone == "America/Cancun") echo 'selected="selected"' ?> ><?php _e('(GMT-06:00) Guadalajara, Mexico City, Monterrey', 'custom-facebook-feed'); ?></option>
                                    <option value="Chile/EasterIsland" <?php if($cff_timezone == "Chile/EasterIsland") echo 'selected="selected"' ?> ><?php _e('(GMT-06:00) Easter Island', 'custom-facebook-feed'); ?></option>
                                    <option value="America/Chicago" <?php if($cff_timezone == "America/Chicago") echo 'selected="selected"' ?> ><?php _e('(GMT-06:00) Central Time (US & Canada)', 'custom-facebook-feed'); ?></option>
                                    <option value="America/New_York" <?php if($cff_timezone == "America/New_York") echo 'selected="selected"' ?> ><?php _e('(GMT-05:00) Eastern Time (US & Canada)', 'custom-facebook-feed'); ?></option>
                                    <option value="America/Havana" <?php if($cff_timezone == "America/Havana") echo 'selected="selected"' ?> ><?php _e('(GMT-05:00) Cuba', 'custom-facebook-feed'); ?></option>
                                    <option value="America/Bogota" <?php if($cff_timezone == "America/Bogota") echo 'selected="selected"' ?> ><?php _e('(GMT-05:00) Bogota, Lima, Quito, Rio Branco', 'custom-facebook-feed'); ?></option>
                                    <option value="America/Caracas" <?php if($cff_timezone == "America/Caracas") echo 'selected="selected"' ?> ><?php _e('(GMT-04:30) Caracas', 'custom-facebook-feed'); ?></option>
                                    <option value="America/Santiago" <?php if($cff_timezone == "America/Santiago") echo 'selected="selected"' ?> ><?php _e('(GMT-04:00) Santiago', 'custom-facebook-feed'); ?></option>
                                    <option value="America/La_Paz" <?php if($cff_timezone == "America/La_Paz") echo 'selected="selected"' ?> ><?php _e('(GMT-04:00) La Paz', 'custom-facebook-feed'); ?></option>
                                    <option value="Atlantic/Stanley" <?php if($cff_timezone == "Atlantic/Stanley") echo 'selected="selected"' ?> ><?php _e('(GMT-04:00) Faukland Islands', 'custom-facebook-feed'); ?></option>
                                    <option value="America/Campo_Grande" <?php if($cff_timezone == "America/Campo_Grande") echo 'selected="selected"' ?> ><?php _e('(GMT-04:00) Brazil', 'custom-facebook-feed'); ?></option>
                                    <option value="America/Goose_Bay" <?php if($cff_timezone == "America/Goose_Bay") echo 'selected="selected"' ?> ><?php _e('(GMT-04:00) Atlantic Time (Goose Bay)', 'custom-facebook-feed'); ?></option>
                                    <option value="America/Glace_Bay" <?php if($cff_timezone == "America/Glace_Bay") echo 'selected="selected"' ?> ><?php _e('(GMT-04:00) Atlantic Time (Canada)', 'custom-facebook-feed'); ?></option>
                                    <option value="America/St_Johns" <?php if($cff_timezone == "America/St_Johns") echo 'selected="selected"' ?> ><?php _e('(GMT-03:30) Newfoundland', 'custom-facebook-feed'); ?></option>
                                    <option value="America/Araguaina" <?php if($cff_timezone == "America/Araguaina") echo 'selected="selected"' ?> ><?php _e('(GMT-03:00) UTC-3', 'custom-facebook-feed'); ?></option>
                                    <option value="America/Montevideo" <?php if($cff_timezone == "America/Montevideo") echo 'selected="selected"' ?> ><?php _e('(GMT-03:00) Montevideo', 'custom-facebook-feed'); ?></option>
                                    <option value="America/Miquelon" <?php if($cff_timezone == "America/Miquelon") echo 'selected="selected"' ?> ><?php _e('(GMT-03:00) Miquelon, St. Pierre', 'custom-facebook-feed'); ?></option>
                                    <option value="America/Godthab" <?php if($cff_timezone == "America/Godthab") echo 'selected="selected"' ?> ><?php _e('(GMT-03:00) Greenland', 'custom-facebook-feed'); ?></option>
                                    <option value="America/Argentina/Buenos_Aires" <?php if($cff_timezone == "America/Argentina/Buenos_Aires") echo 'selected="selected"' ?> ><?php _e('(GMT-03:00) Buenos Aires', 'custom-facebook-feed'); ?></option>
                                    <option value="America/Sao_Paulo" <?php if($cff_timezone == "America/Sao_Paulo") echo 'selected="selected"' ?> ><?php _e('(GMT-03:00) Brasilia', 'custom-facebook-feed'); ?></option>
                                    <option value="America/Noronha" <?php if($cff_timezone == "America/Noronha") echo 'selected="selected"' ?> ><?php _e('(GMT-02:00) Mid-Atlantic', 'custom-facebook-feed'); ?></option>
                                    <option value="Atlantic/Cape_Verde" <?php if($cff_timezone == "Atlantic/Cape_Verde") echo 'selected="selected"' ?> ><?php _e('(GMT-01:00) Cape Verde Is.', 'custom-facebook-feed'); ?></option>
                                    <option value="Atlantic/Azores" <?php if($cff_timezone == "Atlantic/Azores") echo 'selected="selected"' ?> ><?php _e('(GMT-01:00) Azores', 'custom-facebook-feed'); ?></option>
                                    <option value="Europe/Belfast" <?php if($cff_timezone == "Europe/Belfast") echo 'selected="selected"' ?> ><?php _e('(GMT) Greenwich Mean Time : Belfast', 'custom-facebook-feed'); ?></option>
                                    <option value="Europe/Dublin" <?php if($cff_timezone == "Europe/Dublin") echo 'selected="selected"' ?> ><?php _e('(GMT) Greenwich Mean Time : Dublin', 'custom-facebook-feed'); ?></option>
                                    <option value="Europe/Lisbon" <?php if($cff_timezone == "Europe/Lisbon") echo 'selected="selected"' ?> ><?php _e('(GMT) Greenwich Mean Time : Lisbon', 'custom-facebook-feed'); ?></option>
                                    <option value="Europe/London" <?php if($cff_timezone == "Europe/London") echo 'selected="selected"' ?> ><?php _e('(GMT) Greenwich Mean Time : London', 'custom-facebook-feed'); ?></option>
                                    <option value="Africa/Abidjan" <?php if($cff_timezone == "Africa/Abidjan") echo 'selected="selected"' ?> ><?php _e('(GMT) Monrovia, Reykjavik', 'custom-facebook-feed'); ?></option>
                                    <option value="Europe/Amsterdam" <?php if($cff_timezone == "Europe/Amsterdam") echo 'selected="selected"' ?> ><?php _e('(GMT+01:00) Amsterdam, Berlin, Bern, Rome, Stockholm, Vienna', 'custom-facebook-feed'); ?></option>
                                    <option value="Europe/Belgrade" <?php if($cff_timezone == "Europe/Belgrade") echo 'selected="selected"' ?> ><?php _e('(GMT+01:00) Belgrade, Bratislava, Budapest, Ljubljana, Prague', 'custom-facebook-feed'); ?></option>
                                    <option value="Europe/Brussels" <?php if($cff_timezone == "Europe/Brussels") echo 'selected="selected"' ?> ><?php _e('(GMT+01:00) Brussels, Copenhagen, Madrid, Paris', 'custom-facebook-feed'); ?></option>
                                    <option value="Africa/Algiers" <?php if($cff_timezone == "Africa/Algiers") echo 'selected="selected"' ?> ><?php _e('(GMT+01:00) West Central Africa', 'custom-facebook-feed'); ?></option>
                                    <option value="Africa/Windhoek" <?php if($cff_timezone == "Africa/Windhoek") echo 'selected="selected"' ?> ><?php _e('(GMT+01:00) Windhoek', 'custom-facebook-feed'); ?></option>
                                    <option value="Asia/Beirut" <?php if($cff_timezone == "Asia/Beirut") echo 'selected="selected"' ?> ><?php _e('(GMT+02:00) Beirut', 'custom-facebook-feed'); ?></option>
                                    <option value="Africa/Cairo" <?php if($cff_timezone == "Africa/Cairo") echo 'selected="selected"' ?> ><?php _e('(GMT+02:00) Cairo', 'custom-facebook-feed'); ?></option>
                                    <option value="Asia/Gaza" <?php if($cff_timezone == "Asia/Gaza") echo 'selected="selected"' ?> ><?php _e('(GMT+02:00) Gaza', 'custom-facebook-feed'); ?></option>
                                    <option value="Africa/Blantyre" <?php if($cff_timezone == "Africa/Blantyre") echo 'selected="selected"' ?> ><?php _e('(GMT+02:00) Harare, Pretoria', 'custom-facebook-feed'); ?></option>
                                    <option value="Asia/Jerusalem" <?php if($cff_timezone == "Asia/Jerusalem") echo 'selected="selected"' ?> ><?php _e('(GMT+02:00) Jerusalem', 'custom-facebook-feed'); ?></option>
                                    <option value="Europe/Minsk" <?php if($cff_timezone == "Europe/Minsk") echo 'selected="selected"' ?> ><?php _e('(GMT+02:00) Minsk', 'custom-facebook-feed'); ?></option>
                                    <option value="Asia/Damascus" <?php if($cff_timezone == "Asia/Damascus") echo 'selected="selected"' ?> ><?php _e('(GMT+02:00) Syria', 'custom-facebook-feed'); ?></option>
                                    <option value="Europe/Moscow" <?php if($cff_timezone == "Europe/Moscow") echo 'selected="selected"' ?> ><?php _e('(GMT+03:00) Moscow, St. Petersburg, Volgograd', 'custom-facebook-feed'); ?></option>
                                    <option value="Africa/Addis_Ababa" <?php if($cff_timezone == "Africa/Addis_Ababa") echo 'selected="selected"' ?> ><?php _e('(GMT+03:00) Nairobi', 'custom-facebook-feed'); ?></option>
                                    <option value="Asia/Tehran" <?php if($cff_timezone == "Asia/Tehran") echo 'selected="selected"' ?> ><?php _e('(GMT+03:30) Tehran', 'custom-facebook-feed'); ?></option>
                                    <option value="Asia/Dubai" <?php if($cff_timezone == "Asia/Dubai") echo 'selected="selected"' ?> ><?php _e('(GMT+04:00) Abu Dhabi, Muscat', 'custom-facebook-feed'); ?></option>
                                    <option value="Asia/Yerevan" <?php if($cff_timezone == "Asia/Yerevan") echo 'selected="selected"' ?> ><?php _e('(GMT+04:00) Yerevan', 'custom-facebook-feed'); ?></option>
                                    <option value="Asia/Kabul" <?php if($cff_timezone == "Asia/Kabul") echo 'selected="selected"' ?> ><?php _e('(GMT+04:30) Kabul', 'custom-facebook-feed'); ?></option>
                                    <option value="Asia/Yekaterinburg" <?php if($cff_timezone == "Asia/Yekaterinburg") echo 'selected="selected"' ?> ><?php _e('(GMT+05:00) Ekaterinburg', 'custom-facebook-feed'); ?></option>
                                    <option value="Asia/Tashkent" <?php if($cff_timezone == "Asia/Tashkent") echo 'selected="selected"' ?> ><?php _e('(GMT+05:00) Tashkent', 'custom-facebook-feed'); ?></option>
                                    <option value="Asia/Kolkata" <?php if($cff_timezone == "Asia/Kolkata") echo 'selected="selected"' ?> ><?php _e('(GMT+05:30) Chennai, Kolkata, Mumbai, New Delhi', 'custom-facebook-feed'); ?></option>
                                    <option value="Asia/Katmandu" <?php if($cff_timezone == "Asia/Katmandu") echo 'selected="selected"' ?> ><?php _e('(GMT+05:45) Kathmandu', 'custom-facebook-feed'); ?></option>
                                    <option value="Asia/Dhaka" <?php if($cff_timezone == "Asia/Dhaka") echo 'selected="selected"' ?> ><?php _e('(GMT+06:00) Astana, Dhaka', 'custom-facebook-feed'); ?></option>
                                    <option value="Asia/Novosibirsk" <?php if($cff_timezone == "Asia/Novosibirsk") echo 'selected="selected"' ?> ><?php _e('(GMT+06:00) Novosibirsk', 'custom-facebook-feed'); ?></option>
                                    <option value="Asia/Rangoon" <?php if($cff_timezone == "Asia/Rangoon") echo 'selected="selected"' ?> ><?php _e('(GMT+06:30) Yangon (Rangoon)', 'custom-facebook-feed'); ?></option>
                                    <option value="Asia/Bangkok" <?php if($cff_timezone == "Asia/Bangkok") echo 'selected="selected"' ?> ><?php _e('(GMT+07:00) Bangkok, Hanoi, Jakarta', 'custom-facebook-feed'); ?></option>
                                    <option value="Asia/Krasnoyarsk" <?php if($cff_timezone == "Asia/Krasnoyarsk") echo 'selected="selected"' ?> ><?php _e('(GMT+07:00) Krasnoyarsk', 'custom-facebook-feed'); ?></option>
                                    <option value="Asia/Hong_Kong" <?php if($cff_timezone == "Asia/Hong_Kong") echo 'selected="selected"' ?> ><?php _e('(GMT+08:00) Beijing, Chongqing, Hong Kong, Urumqi', 'custom-facebook-feed'); ?></option>
                                    <option value="Asia/Irkutsk" <?php if($cff_timezone == "Asia/Irkutsk") echo 'selected="selected"' ?> ><?php _e('(GMT+08:00) Irkutsk, Ulaan Bataar', 'custom-facebook-feed'); ?></option>
                                    <option value="Australia/Perth" <?php if($cff_timezone == "Australia/Perth") echo 'selected="selected"' ?> ><?php _e('(GMT+08:00) Perth', 'custom-facebook-feed'); ?></option>
                                    <option value="Australia/Eucla" <?php if($cff_timezone == "Australia/Eucla") echo 'selected="selected"' ?> ><?php _e('(GMT+08:45) Eucla', 'custom-facebook-feed'); ?></option>
                                    <option value="Asia/Tokyo" <?php if($cff_timezone == "Asia/Tokyo") echo 'selected="selected"' ?> ><?php _e('(GMT+09:00) Osaka, Sapporo, Tokyo', 'custom-facebook-feed'); ?></option>
                                    <option value="Asia/Seoul" <?php if($cff_timezone == "Asia/Seoul") echo 'selected="selected"' ?> ><?php _e('(GMT+09:00) Seoul', 'custom-facebook-feed'); ?></option>
                                    <option value="Asia/Yakutsk" <?php if($cff_timezone == "Asia/Yakutsk") echo 'selected="selected"' ?> ><?php _e('(GMT+09:00) Yakutsk', 'custom-facebook-feed'); ?></option>
                                    <option value="Australia/Adelaide" <?php if($cff_timezone == "Australia/Adelaide") echo 'selected="selected"' ?> ><?php _e('(GMT+09:30) Adelaide', 'custom-facebook-feed'); ?></option>
                                    <option value="Australia/Darwin" <?php if($cff_timezone == "Australia/Darwin") echo 'selected="selected"' ?> ><?php _e('(GMT+09:30) Darwin', 'custom-facebook-feed'); ?></option>
                                    <option value="Australia/Brisbane" <?php if($cff_timezone == "Australia/Brisbane") echo 'selected="selected"' ?> ><?php _e('(GMT+10:00) Brisbane', 'custom-facebook-feed'); ?></option>
                                    <option value="Australia/Hobart" <?php if($cff_timezone == "Australia/Hobart") echo 'selected="selected"' ?> ><?php _e('(GMT+10:00) Sydney', 'custom-facebook-feed'); ?></option>
                                    <option value="Asia/Vladivostok" <?php if($cff_timezone == "Asia/Vladivostok") echo 'selected="selected"' ?> ><?php _e('(GMT+10:00) Vladivostok', 'custom-facebook-feed'); ?></option>
                                    <option value="Australia/Lord_Howe" <?php if($cff_timezone == "Australia/Lord_Howe") echo 'selected="selected"' ?> ><?php _e('(GMT+10:30) Lord Howe Island', 'custom-facebook-feed'); ?></option>
                                    <option value="Etc/GMT-11" <?php if($cff_timezone == "Etc/GMT-11") echo 'selected="selected"' ?> ><?php _e('(GMT+11:00) Solomon Is., New Caledonia', 'custom-facebook-feed'); ?></option>
                                    <option value="Asia/Magadan" <?php if($cff_timezone == "Asia/Magadan") echo 'selected="selected"' ?> ><?php _e('(GMT+11:00) Magadan', 'custom-facebook-feed'); ?></option>
                                    <option value="Pacific/Norfolk" <?php if($cff_timezone == "Pacific/Norfolk") echo 'selected="selected"' ?> ><?php _e('(GMT+11:30) Norfolk Island', 'custom-facebook-feed'); ?></option>
                                    <option value="Asia/Anadyr" <?php if($cff_timezone == "Asia/Anadyr") echo 'selected="selected"' ?> ><?php _e('(GMT+12:00) Anadyr, Kamchatka', 'custom-facebook-feed'); ?></option>
                                    <option value="Pacific/Auckland" <?php if($cff_timezone == "Pacific/Auckland") echo 'selected="selected"' ?> ><?php _e('(GMT+12:00) Auckland, Wellington', 'custom-facebook-feed'); ?></option>
                                    <option value="Etc/GMT-12" <?php if($cff_timezone == "Etc/GMT-12") echo 'selected="selected"' ?> ><?php _e('(GMT+12:00) Fiji, Kamchatka, Marshall Is.', 'custom-facebook-feed'); ?></option>
                                    <option value="Pacific/Chatham" <?php if($cff_timezone == "Pacific/Chatham") echo 'selected="selected"' ?> ><?php _e('(GMT+12:45) Chatham Islands', 'custom-facebook-feed'); ?></option>
                                    <option value="Pacific/Tongatapu" <?php if($cff_timezone == "Pacific/Tongatapu") echo 'selected="selected"' ?> ><?php _e('(GMT+13:00) Nuku\'alofa', 'custom-facebook-feed'); ?></option>
                                    <option value="Pacific/Kiritimati" <?php if($cff_timezone == "Pacific/Kiritimati") echo 'selected="selected"' ?> ><?php _e('(GMT+14:00) Kiritimati', 'custom-facebook-feed'); ?></option>
                                </select>
                            </td>
                        </tr>

                </tbody>
            </table>

            <div class="cff-save-settings-btn">
                <?php submit_button('Save Settings & Clear Cache'); ?>

                <a class="cff-tooltip-link" href="JavaScript:void(0);">Why is the cache cleared?</a>
                <p class="cff-tooltip cff-more-info"><?php _e("As the settings on this page directly affect the request made to Facebook to get data, then when these settings are changed the plugin cache is cleared in order for the plugin to check Facebook for data again using these new settings. The plugin will check Facebook for data the next time the page that the feed is on is loaded."); ?></p>
            </div>

            <p style="padding-top: 5px;"><i class="fa fa-life-ring" aria-hidden="true"></i>&nbsp; <?php _e('Having trouble using the plugin? Check out the', 'custom-facebook-feed'); ?> <a href='admin.php?page=cff-top&amp;tab=support'><?php _e('Support', 'custom-facebook-feed'); ?></a> <?php _e('tab', 'custom-facebook-feed'); ?>.</p>
        </form>

        <div class="cff_quickstart">
            <h3><i class="fa fa-rocket" aria-hidden="true"></i>&nbsp; Display your feed</h3>
            <p>Copy and paste this shortcode directly into the page, post or widget where you'd like to display the feed:        <input type="text" value="[custom-facebook-feed]" size="22" readonly="readonly" style="text-align: center;" onclick="this.focus();this.select()" title="To copy, click the field then press Ctrl + C (PC) or Cmd + C (Mac)."></p>
            <p>Find out how to display <a href="https://smashballoon.com/using-shortcode-options-customize-facebook-feeds/?utm_campaign=facebook-free&utm_source=settings&utm_medium=multiple" target="_blank"><b>multiple feeds</b></a>.</p>
        </div>

        <a href="https://smashballoon.com/custom-facebook-feed/demo/?utm_campaign=facebook-free&utm_source=footer&utm_medium=ad" target="_blank" class="cff-pro-notice"><img src="<?php echo CFF_PLUGIN_URL. 'admin/assets/img/pro.png?2019' ?>" /></a>

        <p class="cff_plugins_promo dashicons-before dashicons-admin-plugins"> <?php _e('Check out our other free plugins for <a href="https://wordpress.org/plugins/instagram-feed/" target="_blank">Instagram</a>, <a href="https://wordpress.org/plugins/custom-twitter-feeds/" target="_blank">Twitter</a>, and <a href="https://wordpress.org/plugins/feeds-for-youtube/" target="_blank">YouTube</a>.', 'custom-facebook-feed' ); ?></p>

        <div class="cff-share-plugin">
            <h3><?php _e('Like the plugin? Help spread the word!', 'custom-facebook-feed'); ?></h3>

            <button id="cff-admin-show-share-links" class="button secondary" style="margin-bottom: 1px;"><i class="fa fa-share-alt" aria-hidden="true"></i>&nbsp;&nbsp;Share the plugin</button> <div id="cff-admin-share-links"></div>
        </div>

    <?php } //End config tab ?>

     <?php if ( $cff_active_tab == 'allfeeds' ) {
        $locator_summary = CFF_Feed_Locator::summary();
        include_once trailingslashit( CFF_PLUGIN_DIR ) . 'admin/templates/locator-summary.php';
    } ?>

    <?php if( $cff_active_tab == 'support' ) { //Start Support tab ?>

        <div class="cff_support">

            <br />
            <h3 style="padding-bottom: 10px;">Need help?</h3>

            <p>
                <span class="cff-support-title"><i class="fa fa-life-ring" aria-hidden="true"></i>&nbsp; <a href="https://smashballoon.com/custom-facebook-feed/docs/free/?utm_campaign=facebook-free&utm_source=support&utm_medium=setup" target="_blank"><?php _e('Setup Directions'); ?></a></span>
                <?php _e('A step-by-step guide on how to setup and use the plugin.'); ?>
            </p>

            <p>
                <span class="cff-support-title"><i class="fa fa-question-circle" aria-hidden="true"></i>&nbsp; <a href="https://smashballoon.com/custom-facebook-feed/faq/?utm_campaign=facebook-free&utm_source=support&utm_medium=faqs" target="_blank"><?php _e('FAQs and Docs'); ?></a></span>
                <?php _e('View our expansive library of FAQs and documentation to help solve your problem as quickly as possible.'); ?>
            </p>

            <div class="cff-support-faqs">

                <ul class="cff-faq-col-1">
                <li><b>FAQs</b></li>
                <li>&bull;&nbsp; <?php _e('<a href="https://smashballoon.com/category/custom-facebook-feed/faq/?utm_campaign=facebook-free&utm_source=support&utm_medium=general" target="_blank">General Questions</a>'); ?></li>
                <li>&bull;&nbsp; <?php _e('<a href="https://smashballoon.com/category/custom-facebook-feed/getting-started/?utm_campaign=facebook-free&utm_source=support&utm_medium=setup" target="_blank">Getting Started</a>'); ?></li>
                <li>&bull;&nbsp; <?php _e('<a href="https://smashballoon.com/category/custom-facebook-feed/troubleshooting/?utm_campaign=facebook-free&utm_source=support&utm_medium=issues" target="_blank">Common Issues</a>'); ?></li>
                <li style="margin-top: 8px; font-size: 12px;"><a href="https://smashballoon.com/custom-facebook-feed/faq/?utm_campaign=facebook-free&utm_source=support&utm_medium=faqs" target="_blank">See all<i class="fa fa-chevron-right" aria-hidden="true"></i></a></li>

                </ul>

                <ul>
                <li><b>Documentation</b></li>
                <li>&bull;&nbsp; <?php _e('<a href="http://smashballoon.com/custom-facebook-feed/docs/free/?utm_campaign=facebook-free&utm_source=support&utm_medium=setup" target="_blank">Installation and Configuration</a>'); ?></li>
                <li>&bull;&nbsp; <?php _e('<a href="https://smashballoon.com/custom-facebook-feed/docs/shortcodes/?utm_campaign=facebook-free&utm_source=support&utm_medium=shortcode" target="_blank">Shortcode Reference</a>', 'custom-facebook-feed'); ?></li>
                <li>&bull;&nbsp; <?php _e('<a href="https://smashballoon.com/snippets/?utm_campaign=facebook-free&utm_source=support&utm_medium=snippets" target="_blank">Custom CSS and JavaScript Snippets</a>'); ?></li>
                <li style="margin-top: 8px; font-size: 12px;"><a href="https://smashballoon.com/custom-facebook-feed/docs/?utm_campaign=facebook-free&utm_source=support&utm_medium=docs" target="_blank">See all<i class="fa fa-chevron-right" aria-hidden="true"></i></a></li>
                </ul>
            </div>

            <p>
                <span class="cff-support-title"><i class="fa fa-envelope" aria-hidden="true"></i>&nbsp; <a href="http://smashballoon.com/custom-facebook-feed/support/?utm_campaign=facebook-free&utm_source=support&utm_medium=support" target="_blank"><?php _e('Request Support'); ?></a></span>
                <?php _e('Still need help? Submit a ticket and one of our support experts will get back to you as soon as possible.<br /><b>Important:</b> Please include your <b>System Info</b> below with all support requests.'); ?>
            </p>
        </div>

        <hr />

        <h3><?php _e('System Info &nbsp; <i style="color: #666; font-size: 11px; font-weight: normal;">Click the text below to select all</i>', 'custom-facebook-feed'); ?></h3>

        <?php
        $cff_use_own_token = get_option( 'cff_show_access_token' );
        $access_token = get_option( $access_token );
        $posts_json = CFF_Utils::cff_fetchUrl("https://graph.facebook.com/".get_option( trim($page_id) )."/feed?access_token=". trim($access_token) ."&limit=1");
        ?>

        <textarea readonly="readonly" onclick="this.focus();this.select()" title="To copy, click the field then press Ctrl + C (PC) or Cmd + C (Mac)." style="width: 70%; height: 500px; white-space: pre; font-family: Menlo,Monaco,monospace;">
## SITE/SERVER INFO: ##
Site URL:                 <?php echo site_url() . "\n"; ?>
Home URL:                 <?php echo home_url() . "\n"; ?>
WordPress Version:        <?php echo get_bloginfo( 'version' ) . "\n"; ?>
PHP Version:              <?php echo PHP_VERSION . "\n"; ?>
Web Server Info:          <?php echo $_SERVER['SERVER_SOFTWARE'] . "\n"; ?>
PHP allow_url_fopen:      <?php echo ini_get( 'allow_url_fopen' ) ? "Yes" . "\n" : "No" . "\n"; ?>
PHP cURL:                 <?php echo is_callable('curl_init') ? "Yes" . "\n" : "No" . "\n"; ?>
JSON:                     <?php echo function_exists("json_decode") ? "Yes" . "\n" : "No" . "\n" ?>
SSL Stream:               <?php echo in_array('https', stream_get_wrappers()) ? "Yes" . "\n" : "No" . "\n" ?>

## ACTIVE PLUGINS: ##
<?php
$plugins = get_plugins();
$active_plugins = get_option( 'active_plugins', array() );

foreach ( $plugins as $plugin_path => $plugin ) {
    // If the plugin isn't active, don't show it.
    if ( ! in_array( $plugin_path, $active_plugins ) )
        continue;

    echo $plugin['Name'] . ': ' . $plugin['Version'] ."\n";
}
?>

## PLUGIN SETTINGS: ##
Access Token:           <?php echo chunk_split( get_option( 'cff_access_token' ), 110 ); ?>
Page ID:                <?php echo get_option( 'cff_page_id' ) ."\n"; ?>
Number of Posts:        <?php echo get_option( 'cff_num_show' ) ."\n"; ?>
Post Limit:             <?php echo get_option( 'cff_post_limit' ) ."\n"; ?>
Show Posts by:          <?php echo get_option( 'cff_show_others' ) ."\n"; ?>
Cache Time:             <?php echo get_option( 'cff_cache_time' ) ." ".get_option( 'cff_cache_time_unit' )."\n"; ?>
Locale:                 <?php echo get_option( 'cff_locale' ) ."\n"; ?>
Timezone:               <?php $options = get_option( 'cff_style_settings', array() );
                        echo $options[ 'cff_timezone' ] ."\n"; ?>

<?php if( isset( $options[ 'cff_feed_width' ] ) ) { ?>
## CUSTOMIZE ##
Feed Width => <?php echo $options[ 'cff_feed_width' ] ."\n"; ?>
Responsive => <?php echo $options[ 'cff_feed_width_resp' ] ."\n"; ?>
Feed Height => <?php echo $options[ 'cff_feed_height' ] ."\n"; ?>
Feed Padding => <?php echo $options[ 'cff_feed_padding' ] ."\n"; ?>
Feed BG Color => <?php echo $options[ 'cff_bg_color' ] ."\n"; ?>
CSS Class => <?php echo $options[ 'cff_class' ] ."\n"; ?>
Feed Columns => <?php echo $options['cff_cols'] ."\n"; ?>
Mobile Columns => <?php echo $options['cff_cols_mobile'] ."\n"; ?>

## HEADER: ##
Show Header => <?php echo $options[ 'cff_show_header' ] ."\n"; ?>
Header Type => <?php echo $options[ 'cff_header_type' ] ."\n"; ?>
Header Cover => <?php echo $options[ 'cff_header_cover' ] ."\n"; ?>
Header Name => <?php echo $options[ 'cff_header_name' ] ."\n"; ?>
Header Bio => <?php echo $options[ 'cff_header_bio' ] ."\n"; ?>
Header Cover Height => <?php echo $options[ 'cff_header_cover_height' ] ."\n"; ?>
Text => <?php echo $options[ 'cff_header_text' ] ."\n"; ?>
Header Outside => <?php echo $options[ 'cff_header_outside' ] ."\n"; ?>
Background Color => <?php echo $options[ 'cff_header_bg_color' ] ."\n"; ?>
Padding => <?php echo $options[ 'cff_header_padding' ] ."\n"; ?>
Text Size => <?php echo $options[ 'cff_header_text_size' ] ."\n"; ?>
Text Weight => <?php echo $options[ 'cff_header_text_weight' ] ."\n"; ?>
Text Color => <?php echo $options[ 'cff_header_text_color' ] ."\n"; ?>
Icon => <?php echo $options[ 'cff_header_icon' ] ."\n"; ?>
Icon Color => <?php echo $options[ 'cff_header_icon_color' ] ."\n"; ?>
Icon Size => <?php echo $options[ 'cff_header_icon_size' ] ."\n"; ?>

## LIKE BOX: ##
Position => <?php echo $options[ 'cff_like_box_position' ] ."\n"; ?>
Display Outside => <?php echo $options[ 'cff_like_box_outside' ] ."\n"; ?>
Show Fans => <?php echo $options[ 'cff_like_box_faces' ] ."\n"; ?>
Cover Photo => <?php echo $options[ 'cff_like_box_cover' ] ."\n"; ?>
Small Header => <?php echo $options[ 'cff_like_box_small_header' ] ."\n"; ?>
Hide CTA => <?php echo $options[ 'cff_like_box_hide_cta' ] ."\n"; ?>
Custom Width => <?php echo $options[ 'cff_likebox_width' ] ."\n"; ?>

## SHOW/HIDE: ##
Show => <?php if( $options[ 'cff_show_author' ] ) echo 'Author, ';
if( $options[ 'cff_show_text' ] ) echo 'Post Text, ';
if( $options[ 'cff_show_desc' ] ) echo 'Description, ';
if( $options[ 'cff_show_shared_links' ] ) echo 'Shared Links, ';
if( $options[ 'cff_show_date' ] ) echo 'Date, ';
if( $options[ 'cff_show_media' ] ) echo 'Photos/Videos, ';
if( $options[ 'cff_show_event_title' ] ) echo 'Event Title, ';
if( $options[ 'cff_show_event_details' ] ) echo 'Event Details, ';
if( $options[ 'cff_show_meta' ] ) echo 'Comments Box, ';
if( $options[ 'cff_show_link' ] ) echo 'Post Link';
echo "\n"; ?>
Hide => <?php if( !$options[ 'cff_show_author' ] ) echo 'Author, ';
if( !$options[ 'cff_show_text' ] ) echo 'Post Text, ';
if( !$options[ 'cff_show_desc' ] ) echo 'Description, ';
if( !$options[ 'cff_show_shared_links' ] ) echo 'Shared Links, ';
if( !$options[ 'cff_show_date' ] ) echo 'Date, ';
if( !$options[ 'cff_show_media' ] ) echo 'Photos/Videos, ';
if( !$options[ 'cff_show_event_title' ] ) echo 'Event Title, ';
if( !$options[ 'cff_show_event_details' ] ) echo 'Event Details, ';
if( !$options[ 'cff_show_meta' ] ) echo 'Comments Box, ';
if( !$options[ 'cff_show_link' ] ) echo 'Post Link';
echo "\n"; ?>

## STYLE POSTS: ##
Post Style => <?php echo $options[ 'cff_post_style' ] ."\n"; ?>
Background Color => <?php echo $options[ 'cff_post_bg_color' ] ."\n"; ?>
Rounded => <?php echo $options[ 'cff_post_rounded' ] ."\n"; ?>
Seperator Color => <?php echo $options[ 'cff_sep_color' ] ."\n"; ?>
Seperator Size => <?php echo $options[ 'cff_sep_size' ] ."\n"; ?>
Box Shadow => <?php echo $options[ 'cff_box_shadow' ] ."\n"; ?>

## POST AUTHOR: ##
Text Size => <?php echo $options[ 'cff_author_size' ] ."\n"; ?>
Text Color => <?php echo $options[ 'cff_author_color' ] ."\n"; ?>

## POST TEXT: ##
Text Length => <?php echo get_option('cff_title_length') ."\n"; ?>
Format => <?php echo $options['cff_title_format'] ."\n"; ?>
Text Size => <?php echo $options['cff_title_size'] ."\n"; ?>
Text Weight => <?php echo $options['cff_title_weight'] ."\n"; ?>
Text Color => <?php echo $options['cff_title_color'] ."\n"; ?>
Link Color => <?php echo $options['cff_link_color'] ."\n"; ?>
Link Text To Facebook => <?php echo $options['cff_link_to_timeline'] ."\n"; ?>
Link Post Tags => <?php echo $options['cff_post_tags'] ."\n"; ?>
Link Hashags => <?php echo $options['cff_link_hashtags'] ."\n"; ?>

## SHARED POST DESCRIPTION: ##
Text Size => <?php echo $options['cff_body_size'] ."\n"; ?>
Text Weight => <?php echo $options['cff_body_weight'] ."\n"; ?>
Text Color => <?php echo $options['cff_body_color'] ."\n"; ?>

## POST DATE: ##
Position => <?php echo $options['cff_date_position'] ."\n"; ?>
Text Size => <?php echo $options['cff_date_size'] ."\n"; ?>
Text Weight => <?php echo $options['cff_date_weight'] ."\n"; ?>
Text Color => <?php echo $options['cff_date_color'] ."\n"; ?>
Date Formatting => <?php echo $options['cff_date_formatting'] ."\n"; ?>
Timezone => <?php echo $options['cff_timezone'] ."\n"; ?>
Custom Format => <?php echo $options['cff_date_custom'] ."\n"; ?>
Text Before Date => <?php echo $options['cff_date_before'] ."\n"; ?>
Text After Date => <?php echo $options['cff_date_after'] ."\n"; ?>

## SHARED LINK BOXES: ##
Link Box BG Color => <?php echo $options['cff_link_bg_color'] ."\n"; ?>
Link Box Border Color => <?php echo $options['cff_link_border_color'] ."\n"; ?>
Remove Background/Border => <?php echo $options['cff_disable_link_box'] ."\n"; ?>
Link Title Format => <?php echo $options['cff_link_title_format'] ."\n"; ?>
Link Title Color => <?php echo $options['cff_link_title_color'] ."\n"; ?>
Link Title Size => <?php echo $options['cff_link_title_size'] ."\n"; ?>
Link URL Size => <?php echo $options['cff_link_url_size'] ."\n"; ?>
Link URL Color => <?php echo $options['cff_link_url_color'] ."\n"; ?>
Link Description Size => <?php echo $options['cff_link_desc_size'] ."\n"; ?>
Link Description Color => <?php echo $options['cff_link_desc_color'] ."\n"; ?>
Max Length => <?php echo get_option('cff_body_length') ."\n"; ?>

## EVENT TITLE: ##
Format => <?php echo $options['cff_event_title_format'] ."\n"; ?>
Text Size => <?php echo $options['cff_event_title_size'] ."\n"; ?>
Text Weight => <?php echo $options['cff_event_title_weight'] ."\n"; ?>
Text Color => <?php echo $options['cff_event_title_color'] ."\n"; ?>
Link To Facebook => <?php echo $options['cff_event_title_link'] ."\n"; ?>

## EVENT DATE: ##
Text Size => <?php echo $options['cff_event_date_size'] ."\n"; ?>
Text Weight => <?php echo $options['cff_event_date_weight'] ."\n"; ?>
Text Color => <?php echo $options['cff_event_date_color'] ."\n"; ?>
Date Position => <?php echo $options['cff_event_date_position'] ."\n"; ?>
Date Formatting => <?php echo $options['cff_event_date_formatting'] ."\n"; ?>
Custom Format => <?php echo $options['cff_event_date_custom'] ."\n"; ?>

## EVENT DETAILS: ##
Text Size => <?php echo $options['cff_event_details_size'] ."\n"; ?>
Text Weight => <?php echo $options['cff_event_details_weight'] ."\n"; ?>
Text Color => <?php echo $options['cff_event_details_color'] ."\n"; ?>
Link Color => <?php echo $options['cff_event_link_color'] ."\n"; ?>

## POST ACTION LINKS: ##
Text Size => <?php echo $options['cff_link_size'] ."\n"; ?>
Text Weight => <?php echo $options['cff_link_weight'] ."\n"; ?>
Text Color => <?php echo $options['cff_link_color'] ."\n"; ?>
View on Facebook Text => <?php echo $options['cff_facebook_link_text'] ."\n"; ?>
Share Text => <?php echo $options['cff_facebook_share_text'] ."\n"; ?>
Show View on Facebook Text  => <?php echo $options['cff_show_facebook_link'] ."\n"; ?>
Show Share Text => <?php echo $options['cff_show_facebook_share'] ."\n"; ?>

## CUSTOM CSS/JS: ##
Custom CSS => <?php echo $options['cff_custom_css'] ."\n"; ?>
Custom JavaScript => <?php echo $options['cff_custom_js'] ."\n"; ?>

## MISC SETTINGS: ##
Loading via AJAX => <?php echo get_option('cff_ajax') ."\n"; ?>
Preserve Settings => <?php echo get_option('cff_preserve_settings') ."\n"; ?>
Credit Link => <?php echo $options['cff_show_credit'] ."\n"; ?>
Minify CSS/JS => <?php echo $options['cff_minify'] ."\n"; ?>
Restricted Page => <?php echo $options['cff_restricted_page'] ."\n"; ?>
Icon Font Source Method => <?php echo $options['cff_font_source'] ."\n"; ?>
Force Cache To Clear => <?php echo $options['cff_cron'] ."\n"; ?>
Request Method => <?php echo $options['cff_request_method'] ."\n"; ?>
Fix Text Shortening => <?php echo $options['cff_format_issue'] ."\n"; ?>
Disable Default Styles => <?php echo $options['cff_disable_styles'] ."\n"; ?>
Disable Frontend Error Notice => <?php if ( isset( $options['disable_admin_notice'] ) ) echo $options['disable_admin_notice']; echo "\n"; ?>
Enable Email => <?php if ( isset( $options['enable_email_report'] ) ) echo $options['enable_email_report']; echo "\n" ?>
Email Addresses => <?php if ( isset( $options['enable_email_report'] ) ) echo $options['email_notification_addresses']; echo "\n"; ?>

## CUSTOM TEXT/TRANSLATE: ##
Modified text strings:
<?php if($options['cff_see_more_text'] != 'See More'){ ?>See More => <?php echo $options['cff_see_more_text'] ."\n"; ?><?php } ?>
<?php if($options['cff_see_less_text'] != 'See Less'){ ?>See Less => <?php echo $options['cff_see_less_text'] ."\n"; ?><?php } ?>
<?php if($options['cff_facebook_link_text'] != 'View on Facebook'){ ?>View on Facebook => <?php echo $options['cff_facebook_link_text'] ."\n"; ?><?php } ?>
<?php if($options['cff_facebook_share_text'] != 'Share'){ ?>Share => <?php echo $options['cff_facebook_share_text'] ."\n"; ?><?php } ?>
<?php if($options['cff_translate_photos_text'] != 'photos'){ ?>Photos => <?php echo $options['cff_translate_photos_text'] ."\n"; ?><?php } ?>
<?php if($options['cff_translate_photo_text'] != 'Photo'){ ?>Photo => <?php echo $options['cff_translate_photo_text'] ."\n"; ?><?php } ?>
<?php if($options['cff_translate_video_text'] != 'Video'){ ?>Video => <?php echo $options['cff_translate_video_text'] ."\n"; ?><?php } ?>
<?php if($options['cff_translate_learn_more_text'] != 'Learn More'){ ?>Learn More => <?php echo $options['cff_translate_learn_more_text'] ."\n"; ?><?php } ?>
<?php if($options['cff_translate_shop_now_text'] != 'Shop Now'){ ?>Shop Now => <?php echo $options['cff_translate_shop_now_text'] ."\n"; ?><?php } ?>
<?php if($options['cff_translate_message_page_text'] != 'Message Page'){ ?>Message Page => <?php echo $options['cff_translate_message_page_text'] ."\n"; ?><?php } ?>
<?php if($options['cff_translate_second'] != 'second'){ ?>Second => <?php echo $options['cff_translate_second'] ."\n"; ?><?php } ?>
<?php if($options['cff_translate_seconds'] != 'seconds'){ ?>Seconds => <?php echo $options['cff_translate_seconds'] ."\n"; ?><?php } ?>
<?php if($options['cff_translate_minute'] != 'minute'){ ?>Minute => <?php echo $options['cff_translate_minute'] ."\n"; ?><?php } ?>
<?php if($options['cff_translate_minutes'] != 'minutes'){ ?>Minutes => <?php echo $options['cff_translate_minutes'] ."\n"; ?><?php } ?>
<?php if($options['cff_translate_hour'] != 'hour'){ ?>Hour => <?php echo $options['cff_translate_hour'] ."\n"; ?><?php } ?>
<?php if($options['cff_translate_hours'] != 'hours'){ ?>Hours => <?php echo $options['cff_translate_hours'] ."\n"; ?><?php } ?>
<?php if($options['cff_translate_day'] != 'day'){ ?>Day => <?php echo $options['cff_translate_day'] ."\n"; ?><?php } ?>
<?php if($options['cff_translate_days'] != 'days'){ ?>Days => <?php echo $options['cff_translate_days'] ."\n"; ?><?php } ?>
<?php if($options['cff_translate_week'] != 'week'){ ?>Week => <?php echo $options['cff_translate_week'] ."\n"; ?><?php } ?>
<?php if($options['cff_translate_weeks'] != 'weeks'){ ?>Weeks => <?php echo $options['cff_translate_weeks'] ."\n"; ?><?php } ?>
<?php if($options['cff_translate_month'] != 'month'){ ?>Month => <?php echo $options['cff_translate_month'] ."\n"; ?><?php } ?>
<?php if($options['cff_translate_months'] != 'months'){ ?>Months => <?php echo $options['cff_translate_months'] ."\n"; ?><?php } ?>
<?php if($options['cff_translate_year'] != 'year'){ ?>Year => <?php echo $options['cff_translate_year'] ."\n"; ?><?php } ?>
<?php if($options['cff_translate_years'] != 'years'){ ?>Years => <?php echo $options['cff_translate_years'] ."\n"; ?><?php } ?>
<?php if($options['cff_translate_ago'] != 'ago'){ ?>Ago => <?php echo $options['cff_translate_ago'] ."\n"; ?><?php } ?>
<?php } else {
echo "\n"."## CUSTOMIZE ##"."\n";
echo '-----------------------------'."\n";
echo "Customize Settings not saved."."\n";
echo '-----------------------------'."\n";
} ?>

## FACEBOOK API RESPONSE: ##
<?php
$api_response_json = json_decode($posts_json);
if( isset( $api_response_json->error ) ) echo $posts_json;
if( isset( $api_response_json->data ) ){
    $posts_json_split = explode(',"paging":{', $posts_json);
    echo $posts_json_split[0];
} ?>


## CRON EVENTS: ##
<?php
$cron = _get_cron_array();
foreach ( $cron as $key => $data ) {
	$is_target = false;
	foreach ( $data as $key2 => $val ) {
		if ( strpos( $key2, 'cff' ) !== false ) {
			$is_target = true;
			echo $key2;
			echo "\n";
		}
	}
	if ( $is_target) {
		echo date( "Y-m-d H:i:s", $key );
		echo "\n";
		echo 'Next Scheduled: ' . ((int)$key - time())/60 . ' minutes';
		echo "\n\n";
	}
}
?>

## Errors: ##
<?php

$errors = \cff_main()->cff_error_reporter->get_errors();
if ( ! empty( $errors['resizing'] ) ) :
    echo '* Resizing *' . "\n";
    echo $errors['resizing'] . "\n";
endif;
if ( ! empty( $errors['database_create'] ) ) :
    echo '* Database Create *' . "\n";
    echo $errors['database_create'] . "\n";
endif;
if ( ! empty( $errors['upload_dir'] ) ) :
    echo '* Uploads Directory *' . "\n";
    echo $errors['upload_dir'] . "\n";
endif;
if ( ! empty( $errors['connection'] ) ) :
    echo '* API/WP_HTTP Request *' . "\n";
    var_export( $errors['connection'] );
endif;
?>

## Error Log: ##
<?php
$error_log = \cff_main()->cff_error_reporter->get_error_log();
if ( ! empty( $error_log ) ) :
    foreach ( $error_log as $error ) :
        echo strip_tags($error) . "\n";
    endforeach;
endif;
?>

## Action Log: ##
<?php
$actions = \cff_main()->cff_error_reporter->get_action_log();

if ( ! empty( $actions ) ) :
    foreach ( $actions as $action ) :
        echo strip_tags($action) . "\n";
    endforeach;
endif;
?>

## Location Summary: ##
<?php
$locator_summary = CFF_Feed_Locator::summary();

if ( ! empty( $locator_summary) ) {

    foreach ( $locator_summary as $locator_section ) {
        if ( ! empty( $locator_section['results'] ) ) {
            $first_five = array_slice( $locator_section['results'], 0, 5 );
            foreach ( $first_five as $result ) {
                echo esc_url( get_the_permalink( $result['post_id'] ) ) . "\n";
            }

        }
    }
}?>

## oEmbed: ##
<?php
$oembed_token_settings = get_option( 'cff_oembed_token', array() );
foreach( $oembed_token_settings as $key => $value ) {
    echo $key . ': ' . esc_attr( $value ) . "\n";
}

 ?>
        </textarea>
        <div style="margin-bottom: 20px;"><input id="cff_reset_log" class="button-secondary" type="submit" value="<?php esc_attr_e( 'Reset Error Log' ); ?>" style="vertical-align: middle;"/></div>

    <?php } //End support tab


if( $cff_active_tab == 'more' ) { //Start More Social Feeds tab

    add_user_meta(get_current_user_id(), 'seen_more_plugins_page_1', 'true', true); //Iterate when adding a new plugin
    ?>

    <div class="cff_more_plugins" id="cff-admin-about">

        <div class="cff-more-plugins-intro">
            <h3><?php _e( "Here's some more <span>free</span> plugins you might like!", 'custom-facebook-feed' ); ?></h3>
            <p><?php _e( "As you're already using one of our free plugins we thought we'd suggest some others you might like to. Check out our other free plugins below:", 'custom-facebook-feed' ); ?></p>
        </div>

            <?php function get_am_plugins() {

                $images_url = CFF_PLUGIN_URL . 'admin/assets/img/about/';

                return array(
                    'instagram-feed/instagram-feed.php' => array(
                        'icon' => $images_url . 'plugin-if.png',
                        'name' => esc_html__( 'Instagram Feed', 'custom-facebook-feed' ),
                        'desc' => esc_html__( 'Instagram Feed is a clean and beautiful way to add your Instagram posts to your website. Grab your visitors attention and keep them engaged with your site longer.', 'custom-facebook-feed' ),
                        'url'  => 'https://downloads.wordpress.org/plugin/instagram-feed.zip',
                        'pro'  => array(
                            'plug' => 'instagram-feed-pro/instagram-feed.php',
                            'icon' => $images_url . 'plugin-if.png',
                            'name' => esc_html__( 'Instagram Feed Pro', 'custom-facebook-feed' ),
                            'desc' => esc_html__( 'Instagram Feed is a clean and beautiful way to add your Instagram posts to your website. Grab your visitors attention and keep them engaged with your site longer.', 'custom-facebook-feed' ),
                            'url'  => 'https://smashballoon.com/instagram-feed/?utm_campaign=facebook-free&utm_source=cross&utm_medium=cffinstaller',
                            'act'  => 'go-to-url',
                        ),
                    ),
                    'custom-facebook-feed/custom-facebook-feed.php' => array(
                        'icon' => $images_url . 'plugin-fb.png',
                        'name' => esc_html__( 'Custom Facebook Feed', 'custom-facebook-feed' ),
                        'desc' => esc_html__( 'Custom Facebook Feed makes displaying your Facebook posts easy. Keep your site visitors informed and increase engagement with your Facebook page by displaying a feed on your website.', 'custom-facebook-feed' ),
                        'url'  => 'https://downloads.wordpress.org/plugin/custom-facebook-feed.zip',
                        'pro'  => array(
                            'plug' => 'custom-facebook-feed-pro/custom-facebook-feed.php',
                            'icon' => $images_url . 'plugin-fb.png',
                            'name' => esc_html__( 'Custom Facebook Feed Pro', 'custom-facebook-feed' ),
                            'desc' => esc_html__( 'Custom Facebook Feed makes displaying your Facebook posts easy. Keep your site visitors informed and increase engagement with your Facebook page by displaying a feed on your website.', 'custom-facebook-feed' ),
                            'url'  => 'https://smashballoon.com/custom-facebook-feed/?utm_campaign=instagram-free&utm_source=cross&utm_medium=cffinstaller',
                            'act'  => 'go-to-url',
                        )
                    ),

                    'custom-twitter-feeds/custom-twitter-feed.php' => array(
                        'icon' => $images_url . 'plugin-tw.jpg',
                        'name' => esc_html__( 'Custom Twitter Feeds', 'custom-facebook-feed' ),
                        'desc' => esc_html__( 'Custom Twitter Feeds is a highly customizable way to display tweets from your Twitter account. Promote your latest content and update your site content automatically.', 'custom-facebook-feed' ),
                        'url'  => 'https://downloads.wordpress.org/plugin/custom-twitter-feeds.zip',
                        'pro'  => array(
                            'plug' => 'custom-twitter-feeds-pro/custom-twitter-feed.php',
                            'icon' => $images_url . 'plugin-tw.jpg',
                            'name' => esc_html__( 'Custom Twitter Feeds Pro', 'custom-facebook-feed' ),
                            'desc' => esc_html__( 'Custom Twitter Feeds is a highly customizable way to display tweets from your Twitter account. Promote your latest content and update your site content automatically.', 'custom-facebook-feed' ),
                            'url'  => 'https://smashballoon.com/custom-twitter-feeds/?utm_campaign=instagram-free&utm_source=cross&utm_medium=ctfinstaller',
                            'act'  => 'go-to-url',
                        )
                    ),

                    'feeds-for-youtube/youtube-feed.php' => array(
                        'icon' => $images_url . 'plugin-yt.png',
                        'name' => esc_html__( 'Feeds for YouTube', 'custom-facebook-feed' ),
                        'desc' => esc_html__( 'Feeds for YouTube is a simple yet powerful way to display videos from YouTube on your website. Increase engagement with your channel while keeping visitors on your website.', 'custom-facebook-feed' ),
                        'url'  => 'https://downloads.wordpress.org/plugin/feeds-for-youtube.zip',
                        'pro'  => array(
                            'plug' => 'youtube-feed-pro/youtube-feed.php',
                            'icon' => $images_url . 'plugin-yt.png',
                            'name' => esc_html__( 'Feeds for YouTube Pro', 'custom-facebook-feed' ),
                            'desc' => esc_html__( 'Feeds for YouTube is a simple yet powerful way to display videos from YouTube on your website. Increase engagement with your channel while keeping visitors on your website.', 'custom-facebook-feed' ),
                            'url'  => 'https://smashballoon.com/youtube-feed/?utm_campaign=instagram-free&utm_source=cross&utm_medium=sbyinstaller',
                            'act'  => 'go-to-url',
                        )
                    ),
                );

            }

            function output_about_addons() {

                if ( version_compare( PHP_VERSION,  '5.3.0' ) <= 0
                    || version_compare( get_bloginfo('version'), '4.6' , '<' ) ){
                    return;
                }

                $all_plugins = get_plugins();
                $am_plugins  = get_am_plugins();
                $has_all_plugins = true;

                ?>
                <div id="cff-admin-addons">
                    <div class="addons-container">
                        <?php
                        foreach ( $am_plugins as $plugin => $details ) :

                            $free_only = true;
                            $plugin_data = get_the_plugin_data( $plugin, $details, $all_plugins, $free_only );
                            $plugin_slug = strtolower( str_replace( ' ', '_', $plugin_data['details']['name'] ) );

                            //Only show the plugin if both free/pro versions aren't already active
                            isset( $plugin_data['details']['plug'] ) ? $pro_plugin_source = $plugin_data['details']['plug'] : $pro_plugin_source = '';

                            if( !is_plugin_active( $plugin ) && !is_plugin_active( $pro_plugin_source ) ){
                                $has_all_plugins = false;
                                ?>
                                <div class="addon-container" id="install_<?php echo $plugin_slug; ?>">
                                    <div class="addon-item">
                                        <div class="details cff-clear">
                                            <img src="<?php echo esc_url( $plugin_data['details']['icon'] ); ?>">
                                            <h5 class="addon-name">
                                                <?php echo esc_html( $plugin_data['details']['name'] ); ?>
                                            </h5>
                                            <p class="addon-desc">
                                                <?php echo wp_kses_post( $plugin_data['details']['desc'] ); ?>
                                            </p>
                                        </div>
                                        <div class="actions cff-clear">
                                            <div class="status">
                                                <strong>
                                                    <?php _e( 'Price:', 'custom-facebook-feed' );
                                                    echo ' <span style="color: green;">';
                                                    _e( 'Free', 'custom-facebook-feed' );
                                                    echo '</span>'; ?>
                                                </strong>
                                            </div>
                                            <div class="action-button">
                                                <button class="<?php echo esc_attr( $plugin_data['action_class'] ); ?>" data-plugin="<?php echo esc_attr( $plugin_data['plugin_src'] ); ?>" data-type="plugin">
                                                    <?php echo wp_kses_post( $plugin_data['action_text'] ); ?>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            <?php } ?>

                        <?php endforeach;

                        if( $has_all_plugins == true ){ ?>

                            <style type="text/css">.cff-more-plugins-intro{display:none;}</style>
                            <h2><?php _e( 'You already have all of our free plugins. Awesome!', 'custom-facebook-feed' ); ?></h2>

                            <p><?php _e( 'Thank you so much for using our plugins. We appreciate you trusting us to power your social media feeds.', 'custom-facebook-feed' ); ?></p>
                            <p><?php _e( 'If you want to support us in our mission to make bringing social media content to your website both easy and reliable, then consider upgrading to one of our Pro plugins.', 'custom-facebook-feed' ); ?></p>

                            <div class="cff-cols-4">
                                <?php //Show a list of Pro plugins which aren't currently active ?>
                                <?php foreach ( $am_plugins as $plugin => $details ) :

                                    $plugin_data = get_the_plugin_data( $plugin, $details, $all_plugins );
                                    $plugin_slug = strtolower( str_replace( ' ', '_', $plugin_data['details']['name'] ) );

                                    isset( $plugin_data['details']['plug'] ) ? $pro_plugin_source = $plugin_data['details']['plug'] : $pro_plugin_source = '';
                                    if( !is_plugin_active( $pro_plugin_source ) ){
                                    ?>

                                        <div class="addon-container" id="install_<?php echo $plugin_slug; ?>">
                                            <div class="addon-item">
                                                <div class="details cff-clear">
                                                    <img src="<?php echo esc_url( $plugin_data['details']['icon'] ); ?>">
                                                    <h5 class="addon-name">
                                                        <?php echo esc_html( $plugin_data['details']['name'] ); ?>
                                                    </h5>
                                                    <p class="addon-desc">
                                                        <?php echo wp_kses_post( $plugin_data['details']['desc'] ); ?>
                                                    </p>
                                                </div>
                                                <div class="actions cff-clear">
                                                    <div class="action-button">
                                                        <a href="<?php echo esc_attr( $details['pro']['url'] ); ?>" target="_blank" class="status-go-to-url button button-primary">
                                                            <?php  _e( 'Upgrade to Pro', 'custom-facebook-feed' ); ?>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    <?php } ?>

                                <?php endforeach; ?>
                            </div>

                        <?php } ?>

                    </div>
                </div>
                <?php
            }


            function get_the_plugin_data( $plugin, $details, $all_plugins, $free_only = false ) {

                $have_pro = ( ! empty( $details['pro'] ) && ! empty( $details['pro']['plug'] ) );
                $show_pro = false;

                $plugin_data = array();

                if( $free_only ) $have_pro = false;

                if ( $have_pro ) {
                    if ( array_key_exists( $plugin, $all_plugins ) ) {
                        if ( is_plugin_active( $plugin ) ) {
                            $show_pro = true;
                        }
                    }
                    if ( array_key_exists( $details['pro']['plug'], $all_plugins ) ) {
                        $show_pro = true;
                    }
                    if ( $show_pro ) {
                        $plugin  = $details['pro']['plug'];
                        $details = $details['pro'];
                    }
                }

                if( $free_only ) $show_pro = false;

                if ( array_key_exists( $plugin, $all_plugins ) ) {
                    if ( is_plugin_active( $plugin ) ) {
                        // Status text/status.
                        $plugin_data['status_class'] = 'status-active';
                        $plugin_data['status_text']  = esc_html__( 'Active', 'custom-facebook-feed' );
                        // Button text/status.
                        $plugin_data['action_class'] = $plugin_data['status_class'] . ' button button-secondary disabled';
                        $plugin_data['action_text']  = esc_html__( 'Activated', 'custom-facebook-feed' );
                        $plugin_data['plugin_src']   = esc_attr( $plugin );
                    } else {
                        // Status text/status.
                        $plugin_data['status_class'] = 'status-inactive';
                        $plugin_data['status_text']  = esc_html__( 'Inactive', 'custom-facebook-feed' );
                        // Button text/status.
                        $plugin_data['action_class'] = $plugin_data['status_class'] . ' button button-secondary';
                        $plugin_data['action_text']  = esc_html__( 'Activate', 'custom-facebook-feed' );
                        $plugin_data['plugin_src']   = esc_attr( $plugin );
                    }
                } else {
                    // Doesn't exist, install.
                    // Status text/status.
                    $plugin_data['status_class'] = 'status-download';
                    if ( isset( $details['act'] ) && 'go-to-url' === $details['act'] ) {
                        $plugin_data['status_class'] = 'status-go-to-url';
                    }
                    $plugin_data['status_text'] = esc_html__( 'Not Installed', 'custom-facebook-feed' );
                    // Button text/status.
                    $plugin_data['action_class'] = $plugin_data['status_class'] . ' button button-primary';
                    $plugin_data['action_text']  = esc_html__( 'Install Plugin', 'custom-facebook-feed' );
                    $plugin_data['plugin_src']   = esc_url( $details['url'] );
                }

                $plugin_data['details'] = $details;

                return $plugin_data;
            }


            output_about_addons();

            ?>
            <style>.cff_quickstart, .cff-pro-notice, .cff_plugins_promo, .cff_share_plugin{ display: none !Important; }</style>
        </div>

        <?php
} //End More tab




} //End Settings_Page



function cff_oembeds_page() {
    ( is_plugin_active( 'social-wall/social-wall.php' ) ) ? $cff_sw_active = true : $cff_sw_active = false;

    ?>

    <div id="cff-admin" class="wrap cff-oembeds">
        <?php
        $lite_notice_dismissed = get_transient( 'facebook_feed_dismiss_lite' );

        if ( ! $lite_notice_dismissed ) :
            ?>
            <div id="cff-notice-bar" style="display:none">
                <span class="cff-notice-bar-message"><?php _e( 'You\'re using Custom Facebook Feed Lite. To unlock more features consider <a href="https://smashballoon.com/custom-facebook-feed/?utm_campaign=facebook-free&utm_source=notices&utm_medium=lite" target="_blank" rel="noopener noreferrer">upgrading to Pro</a>.', 'custom-facebook-feed'); ?></span>
                <button type="button" class="dismiss" title="<?php _e( 'Dismiss this message.', 'custom-facebook-feed'); ?>" data-page="overview">
                </button>
            </div>
        <?php endif; ?>

            <div id="header">
                <h1><?php _e('Facebook oEmbeds', 'custom-facebook-feed'); ?></h1>
            </div>

            <p>
                <?php
                _e( "You can use the Custom Facebook Feed plugin to power your Facebook oEmbeds, both old and new.", "custom-facebook-feed" );
                if ( ! CFF_Oembed::can_do_oembed() ) {
                    echo ' ';
                    _e( "Just click the button below and we'll do the rest.", "custom-facebook-feed" );
                }
                ?>
            </p>

            <div class="cff-oembed-button">

                <?php
                //delete_option('cff_oembed_token');
                $admin_url_state = admin_url('admin.php?page=cff-oembeds');
                //If the admin_url isn't returned correctly then use a fallback
                if( $admin_url_state == '/wp-admin/admin.php?page=cff-oembeds' ){
                    $admin_url_state = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                }

	            $oembed_token_settings = get_option( 'cff_oembed_token', array() );
	            $saved_access_token_data = isset( $oembed_token_settings['access_token'] ) ? $oembed_token_settings['access_token'] : false;

                $access_token_error = false;
                $valid_new_access_token = false;
                $show_token_expiration_modal = false;
                if ( ! empty( $_GET['cff_access_token'] ) && strlen( $_GET['cff_access_token'] ) <= 20 ) {
                    $access_token_error = true;
                } elseif ( ! empty( $_GET['transfer'] ) ) {
                    if ( class_exists( 'SB_Instagram_Oembed' ) ) {
                        $sbi_oembed_token = SB_Instagram_Oembed::last_access_token();
                        $valid_new_access_token = $sbi_oembed_token;
                    }
                } else {
                    $valid_new_access_token = ! empty( $_GET['cff_access_token'] ) && strlen( $_GET['cff_access_token'] ) > 20 && $saved_access_token_data !== $_GET['cff_access_token'] ? sanitize_text_field( $_GET['cff_access_token'] ) : false;
                    if ( $valid_new_access_token && ! empty( $_GET['cff_access_token'] ) ) {
                        $url = esc_url_raw( 'https://graph.facebook.com/me/accounts?limit=500&access_token=' . $valid_new_access_token );
                        $pages_data_connection = wp_remote_get( $url );

                        if ( ! is_wp_error( $pages_data_connection ) && isset( $pages_data_connection['body'] ) ) {
                            $pages_data = json_decode( $pages_data_connection['body'], true );
                            if ( isset( $pages_data['data'][0]['access_token'] ) ) {
                                $oembed_token_settings['expiration_date'] = 'never';
                            } else {
                                $oembed_token_settings['expiration_date'] = time() + (60 * DAY_IN_SECONDS);
                                $show_token_expiration_modal = true;
                            }
                        } else {
                            $oembed_token_settings['expiration_date'] = 'unknown';
                        }
                    }
                }

                ?>

                <?php if ( ! $saved_access_token_data && ! $valid_new_access_token && ! CFF_Oembed::can_do_oembed() ) {
                    if ( $access_token_error ) { ?>
                        <p><?php _e("There was a problem with the access token that was retrieved.", "custom-facebook-feed"); ?></p>

                    <?php }
                    $token_href = 'https://api.smashballoon.com/v2/facebook-login.php?state=' . $admin_url_state;
                    if ( class_exists( 'SB_Instagram_Oembed' ) ) {
                        $sbi_oembed_token = SB_Instagram_Oembed::last_access_token();

                        if ( ! empty( $sbi_oembed_token ) ) {
                            $token_href = add_query_arg( 'transfer', '1', $admin_url_state );
                        }
                    }

				?>
				<a href="<?php echo esc_url( $token_href ); ?>" class="cff_admin_btn" id="cff_fb_login"><i class="fa fa-facebook-square"></i> <?php _e( 'Connect to Facebook and Enable oEmbeds', 'custom-facebook-feed' ); ?></a>

                <div class="cff-oembed-promo cff-oembed-desc">
                    <div class="cff-col">
                        <h2><?php _e("What are oEmbeds?", "custom-facebook-feed"); ?></h2>
                        <p><?php _e("Anytime you share a link to a Facebook post or video in WordPress, it is automatically converted into an embedded version of that Facebook post (an \"oEmbed\").</p><p>WordPress is discontinuing support for Facebook oEmbeds due to them now requiring an Access Token to work. Don't worry though, we have your back. Just use the button above to connect to Facebook and we'll make sure your Facebook oEmbeds keep working.", "custom-facebook-feed"); ?></p>
                    </div>

                    <img src="<?php echo CFF_PLUGIN_URL .  'admin/assets/img/cff-oembed.png'; ?>" style="padding: 0px; background: white;">
                </div>

                <?php } else {
                    if ( $valid_new_access_token ) {
                        $oembed_token_settings['access_token'] = $valid_new_access_token;
                        $oembed_token_settings['disabled'] = false;
                        update_option( 'cff_oembed_token', $oembed_token_settings );
                        ?>
                        <div><p class="cff-success"><strong><?php _e("You're all set!", "custom-facebook-feed"); ?></strong> <?php _e("You're all set! Custom Facebook Feed is now powering all of your existing Facebook oEmbeds and also any new ones you create.", "custom-facebook-feed"); ?> <a href="javascript:void(0);" id="cff-oembed-disable"><?php _e("Disable", "custom-facebook-feed"); ?></a></p></div>

                        <?php if ( $show_token_expiration_modal ) : ?>
                        <div id="cff_fb_login_modal" class="cff_modal_tokens cffnomodal">
                            <div class="cff_modal_box">
                                <p><strong><?php _e( 'Heads up!', 'custom-facebook-feed' ); ?></strong><br></p>

                                <p>
                                    <?php _e( 'Your access token will expire in 60 days. Facebook requires that users have a role on a Facebook page in order to create access tokens that don\'t expire. Click the button below for instructions on creating a Facebook page and extending your access token to never expire.', 'custom-facebook-feed' ); ?>
                                </p>
                                <p style="text-align: center;">
                                    <a style="display: inline-block; float: none; margin-bottom: 0;" href="https://smashballoon.com/doc/how-to-prevent-your-oembed-access-token-from-expiring/?facebook" class="cff_admin_btn" target="blank" rel="noopener"><?php _e( 'How to Create a Facebook Page', 'custom-facebook-feed' ); ?></a>
                                    &nbsp;&nbsp;<a href="https://api.smashballoon.com/v2/facebook-login.php?state=<?php echo $admin_url_state; ?>" class="button button-secondary" style="height: 47px;line-height: 47px;font-size: 14px;padding: 0 21px;"><?php _e( 'Try Again', 'custom-facebook-feed' ); ?></a>
                                </p>

                                <a href="JavaScript:void(0);" class="cff-modal-close"><i class="fa fa-times"></i></a>
                            </div>
                        </div>
                        <?php endif; ?>
                    <?php } else {
                        if ( ! isset( $oembed_token_settings['expiration_date'] ) || (int)$oembed_token_settings['expiration_date'] === 0 || $oembed_token_settings['expiration_date'] > time() ) :
                            ?>
                        <div><p class="cff-success"><?php _e("The Custom Facebook Feed plugin is now powering your Facebook oEmbeds.", "custom-facebook-feed"); ?> <a href="javascript:void(0);" id="cff-oembed-disable"><?php _e("Disable", "custom-facebook-feed"); ?></a></p></div>
                        <?php
                        endif;
                            if ( ! empty( $oembed_token_settings['expiration_date'] )
                                 && $oembed_token_settings['expiration_date'] !== 'never' ) :
                                $link_1 = '<a href="https://smashballoon.com/doc/how-to-prevent-your-oembed-access-token-from-expiring/?facebook" target="blank" rel="noopener">';
                                $link_2 = '</a>';
                                $class = 'cff-warning';
                                if ( $oembed_token_settings['expiration_date'] > time() ) {
                                    $days_to_expire = floor( ( $oembed_token_settings['expiration_date'] - time() ) / DAY_IN_SECONDS );
                                    $message        = sprintf( __( '%1sImportant:%2s Your access token for powering oEmbeds will expire in %3s days.', 'custom-facebook-feed' ), '<strong>', '</strong>', $days_to_expire );
                                } else {
                                    $class = 'cff-profile-error';
                                    $message = __( 'Your access token for powering oEmbeds has expired.', 'custom-facebook-feed' );
                                }
                                ?>
                                <div class="<?php echo $class; ?>" style="display:inline-block;width: auto;">
                                    <p>
                                        <?php echo $message ; ?>
                                    </p>
                                    <p>
                                        <?php echo sprintf(  __( 'Facebook requires that users have a role on a Facebook page in order to create access tokens that don\'t expire. Visit %1sthis link%2s for instructions on extending your access token to never expire.', 'custom-facebook-feed' ), $link_1, $link_2 ); ?>
                                    </p>
                                    <p>
                                        <a href="https://api.smashballoon.com/v2/facebook-login.php?state=<?php echo $admin_url_state; ?>" class="cff_admin_btn" id="cff_fb_login"><i class="fa fa-facebook-square"></i> <?php _e( 'Connect to Facebook and Recheck Access Token', 'custom-facebook-feed' ); ?></a>
                                    </p>
                                </div>

                            <?php endif; ?>

                        <?php } ?>

                    <div class="cff-oembed-promo">
                        <h2><?php _e("Did you know, the Custom Facebook Feed plugin can also automatically display your Facebook updates on your website?", "custom-facebook-feed"); ?></h2>
                        <div class="cff-reasons">
                            <div><svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="clock" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svg-inline--fa fa-clock fa-w-16 fa-2x"><path fill="currentColor" d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm0 448c-110.5 0-200-89.5-200-200S145.5 56 256 56s200 89.5 200 200-89.5 200-200 200zm61.8-104.4l-84.9-61.7c-3.1-2.3-4.9-5.9-4.9-9.7V116c0-6.6 5.4-12 12-12h32c6.6 0 12 5.4 12 12v141.7l66.8 48.6c5.4 3.9 6.5 11.4 2.6 16.8L334.6 349c-3.9 5.3-11.4 6.5-16.8 2.6z" class=""></path></svg><span><?php _e("Save time", "custom-facebook-feed"); ?></span></div>
                            <div><svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="chart-line" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svg-inline--fa fa-chart-line fa-w-16 fa-2x"><path fill="currentColor" d="M117.65 277.65c6.25 6.25 16.38 6.25 22.63 0L192 225.94l84.69 84.69c6.25 6.25 16.38 6.25 22.63 0L409.54 200.4l29.49 29.5c15.12 15.12 40.97 4.41 40.97-16.97V112c0-8.84-7.16-16-16-16H363.07c-21.38 0-32.09 25.85-16.97 40.97l29.5 29.49-87.6 87.6-84.69-84.69c-6.25-6.25-16.38-6.25-22.63 0l-74.34 74.34c-6.25 6.25-6.25 16.38 0 22.63l11.31 11.31zM496 400H48V80c0-8.84-7.16-16-16-16H16C7.16 64 0 71.16 0 80v336c0 17.67 14.33 32 32 32h464c8.84 0 16-7.16 16-16v-16c0-8.84-7.16-16-16-16z" class=""></path></svg><span><?php _e("Increase social engagement", "custom-facebook-feed"); ?></span></div>
                            <div><svg style="width: 16px; height: 16px;" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="search" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svg-inline--fa fa-search fa-w-16 fa-2x"><path fill="currentColor" d="M505 442.7L405.3 343c-4.5-4.5-10.6-7-17-7H372c27.6-35.3 44-79.7 44-128C416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c48.3 0 92.7-16.4 128-44v16.3c0 6.4 2.5 12.5 7 17l99.7 99.7c9.4 9.4 24.6 9.4 33.9 0l28.3-28.3c9.4-9.4 9.4-24.6.1-34zM208 336c-70.7 0-128-57.2-128-128 0-70.7 57.2-128 128-128 70.7 0 128 57.2 128 128 0 70.7-57.2 128-128 128z" class=""></path></svg><span><?php _e("Add dynamic SEO content to your site.", "custom-facebook-feed"); ?></span></div>
                        </div>
                        <p>
                            <?php $check_svg = '<svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="check" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svg-inline--fa fa-check fa-w-16 fa-2x"><path fill="currentColor" d="M173.898 439.404l-166.4-166.4c-9.997-9.997-9.997-26.206 0-36.204l36.203-36.204c9.997-9.998 26.207-9.998 36.204 0L192 312.69 432.095 72.596c9.997-9.997 26.207-9.997 36.204 0l36.203 36.204c9.997 9.997 9.997 26.206 0 36.204l-294.4 294.401c-9.998 9.997-26.207 9.997-36.204-.001z" class=""></path></svg>'; ?>
                            <?php echo $check_svg; ?><span><?php _e("Super simple to set up", "custom-facebook-feed"); ?></span>
                            <?php echo $check_svg; ?><span><?php _e("Works for Facebook pages or groups", "custom-facebook-feed"); ?></span>
                            <?php echo $check_svg; ?><span><?php _e("Lightning fast", "custom-facebook-feed"); ?></span>
                            <?php echo $check_svg; ?><span><?php _e("Completely customizable", "custom-facebook-feed"); ?></span>
                        </p>
                        <a href="?page=cff-top" class="button button-primary"><?php _e("Add a Facebook feed now", "custom-facebook-feed"); ?></a>
                    </div>
                <?php } ?>

            </div>
    </div>
<?php }

function cff_social_wall_page() {

    ( is_plugin_active( 'social-wall/social-wall.php' ) ) ? $cff_sw_active = true : $cff_sw_active = false;

    ?>

    <div id="cff-admin" class="wrap sw-landing-page">

        <?php $plus_svg = '<span class="cff-sb-plus"><svg aria-hidden="true" focusable="false" data-prefix="fal" data-icon="plus" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" class="svg-inline--fa fa-plus fa-w-12 fa-2x"><path fill="currentColor" d="M376 232H216V72c0-4.42-3.58-8-8-8h-32c-4.42 0-8 3.58-8 8v160H8c-4.42 0-8 3.58-8 8v32c0 4.42 3.58 8 8 8h160v160c0 4.42 3.58 8 8 8h32c4.42 0 8-3.58 8-8V280h160c4.42 0 8-3.58 8-8v-32c0-4.42-3.58-8-8-8z" class=""></path></svg></span>'; ?>

        <div class="cff-sw-icons">

            <span style="display: inline-block; padding: 0 0 12px 0; width: 360px; max-width: 100%;">
                <svg viewBox="0 0 9161 1878" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd" stroke-linejoin="round" stroke-miterlimit="2">
                    <path d="M671.51192 492.98498c-131.56765-59.12206-268.60859-147.41608-396.53319-188.5154 45.4516 108.39585 83.81326 223.88002 123.5099 338.03081-79.17849 59.49897-171.6647 105.68858-260.02357 156.01204C213.65642 872.8361 320.1446 915.85885 404.9893 980.52836c-67.96118 83.8619-201.48512 171.0179-234.02089 247.0198 140.6921-17.62678 304.63665-46.21028 435.53762-52.00414 28.76425 144.58318 43.59867 303.0974 84.5075 435.5368 60.92028-175.2656 116.0013-356.3729 188.5158-520.0447 111.90636 46.28566 248.28994 102.72599 357.52876 130.01178-76.6463-107.53462-146.59336-221.76932-214.51645-338.02878 100.51155-72.83872 202.17166-144.52441 299.02516-221.02077-136.89504-12.61227-278.73407-20.28825-422.53587-25.99863-22.85286-148.332-16.84825-325.5158-52.00496-461.53949-53.19323 111.48812-115.96685 213.3914-175.51405 318.52475m65.00509 1228.60643c-18.07949 77.37581 41.48757 109.11319 32.50294 156.01204-58.81404-20.26799-103.0575-30.6796-182.01552-19.50201 2.47017-60.37032 56.76657-68.90954 45.50428-143.0107-841.40803-95.6632-843.09804-1616.06909-6.50107-1709.64388C1672.04777-111.55711 1704.8713 1694.70523 736.517 1721.5914" fill="#e34f0e"/>
                    <path d="M847.02597 174.46023c35.15671 136.0237 29.1521 313.20749 52.00455 461.53544 143.80221 5.71443 285.63962 13.38636 422.53628 26.00268-96.8531 76.49636-198.51483 148.18205-299.02556 221.01874 67.92349 116.2623 137.87014 230.49416 214.51847 338.03-109.24085-27.2866-245.62443-83.72572-357.5308-130.0126-72.51448 163.67262-127.5955 344.77992-188.51538 520.04553-40.90924-132.4394-55.74325-290.95364-84.5079-435.53681-130.90057 5.79548-294.84472 34.37736-435.53722 52.00415 32.53577-76.0007 166.0589-163.15589 234.02008-247.02021-84.8451-64.67032-191.33207-107.69066-266.52343-182.01472 88.35886-50.32346 180.84346-96.51307 260.02276-156.01609-39.69705-114.14674-78.05668-229.63091-123.50868-338.02675C402.9013 345.5689 539.94427 433.86292 671.51192 492.98498c59.5468-105.13335 122.32082-207.03663 175.51405-318.52475" fill="#fff"/>
                    <path d="M1782.27033 1236.51938c41.18267 21.61921 126.79927 44.31938 214.58338 44.31938 213.49962 0 311.03752-107.01507 311.03752-232.40646 0-101.61027-58.52274-171.87269-189.65702-220.5159-92.11913-33.50977-131.13429-48.6432-131.13429-85.39586 0-32.4288 32.51263-54.04801 92.11913-54.04801 72.61154 0 126.79927 20.53824 158.22814 34.59073l41.18267-155.65828c-47.6852-21.6192-110.54295-37.83361-197.2433-37.83361-184.23826 0-293.69746 99.44834-293.69746 228.08262 0 108.09602 82.36534 176.19652 205.91335 219.43493 82.36533 28.10497 114.87797 48.64321 114.87797 84.3149 0 36.75265-32.51264 59.45282-99.70541 59.45282-73.6953 0-145.2231-22.70017-189.65703-45.40034l-36.84765 161.06308zM3019.37602 1270.02915h189.65702l-36.84765-728.56722h-256.8498l-55.27148 194.57285c-21.67508 76.74818-45.51768 179.4394-66.10902 268.07815h-3.25126c-15.17256-88.63875-36.84765-185.92517-57.43898-266.99719l-47.6852-195.6538h-263.35233l-45.51768 728.56721h179.90323l11.9213-260.51142c3.25127-83.23394 6.50253-191.32997 10.83755-294.0212h2.1675c17.34008 99.44835 39.01517 207.54438 58.52274 286.45448l60.69025 252.9447h152.80938l72.61154-254.02566c23.8426-79.99106 54.18773-189.16805 76.94657-285.37352h3.25126c0 113.50083 1.08376 210.78726 4.33502 294.0212l8.67004 260.51142zM3699.9738 1101.39935l46.60144 168.6298h211.33211l-217.83464-728.56722H3478.8879l-211.33211 728.56722h202.66208l41.18267-168.6298h188.57327zm-162.56317-143.76772l31.42888-130.79619c9.7538-41.07649 20.59134-101.61026 31.42888-143.76771h2.1675c11.9213 42.15745 26.01012 102.69122 36.84766 143.76771l33.59639 130.7962h-135.4693zM4016.4301 1236.51938c41.18266 21.61921 126.79926 44.31938 214.58337 44.31938 213.49962 0 311.03752-107.01507 311.03752-232.40646 0-101.61027-58.52274-171.87269-189.65702-220.5159-92.11913-33.50977-131.1343-48.6432-131.1343-85.39586 0-32.4288 32.51264-54.04801 92.11914-54.04801 72.61154 0 126.79926 20.53824 158.22814 34.59073l41.18267-155.65828c-47.6852-21.6192-110.54295-37.83361-197.2433-37.83361-184.23826 0-293.69746 99.44834-293.69746 228.08262 0 108.09602 82.36534 176.19652 205.91335 219.43493 82.36533 28.10497 114.87797 48.64321 114.87797 84.3149 0 36.75265-32.51264 59.45282-99.70541 59.45282-73.6953 0-145.2231-22.70017-189.65703-45.40034l-36.84765 161.06308zM4623.27688 541.46193v728.56722h196.15955V981.41276h237.34222v288.6164h196.15955V541.46192h-196.15955v269.1591h-237.34222v-269.1591h-196.15955z" fill="#282828" fill-rule="nonzero"/>
                    <g>
                        <path d="M6900.00785 293.7053c5.29-14.371 11.90999-24.77099 19.84998-31.19998 7.94-6.429 16.07-9.644 24.38998-9.644 8.32 0 15.7 2.08 22.12999 6.241 6.43 4.16 10.39999 9.265 11.90999 15.31599 2.27 43.86896 4.16 92.65493 5.67 146.35689 1.51 53.70296 2.65 109.86291 3.4 168.48187.76 58.61796 1.52 118.74891 2.26999 180.39386.76 61.64396 1.33 122.71991 1.71 183.22987.37 60.50695.56 119.1269.56 175.85686 0 56.72996.38 109.28992 1.14 157.69988-3.78 12.1-10.59 20.98999-20.41999 26.65998-9.83999 5.68-19.85998 8.14-30.06997 7.38-10.21-.76-19.28999-4.73-27.22998-11.91-7.94-7.18999-11.91-17.58998-11.91-31.19997l-3.4-983.66226zm173.57987 0c5.3-14.371 11.90999-24.77099 19.85998-31.19998 7.94-6.429 16.06999-9.644 24.38998-9.644 8.32 0 15.69 2.08 22.11999 6.241 6.43 4.16 10.39999 9.265 11.91999 15.31599 2.27 43.86896 4.15 92.65493 5.67 146.35689 1.51 53.70296 2.64 109.86291 3.4 168.48187.76 58.61796 1.51999 118.74891 2.26999 180.39386.76 61.64396 1.33 122.71991 1.7 183.22987.38 60.50695.57 119.1269.57 175.85686 0 56.72996.38 109.28992 1.13 157.69988-3.78 12.1-10.59 20.98999-20.41999 26.65998-9.82999 5.68-19.84998 8.14-30.05998 7.38-10.20999-.76-19.28998-4.73-27.22997-11.91-7.94-7.18999-11.92-17.58998-11.92-31.19997l-3.4-983.66226zm-419.49969 980.25225c-6.81-4.54-13.60999-12.66999-20.41998-24.38998-6.81-11.71999-13.61-24.57998-20.41999-38.57997-6.81-13.98999-13.61999-28.16998-20.41998-42.53997-6.81-14.36999-13.99999-26.84998-21.55998-37.43997-7.56-10.58999-15.51-18.33998-23.82999-23.25998-8.31999-4.92-17.38998-4.73-27.22998.57-15.11998 24.95998-30.43997 49.15996-45.93996 72.60994-15.50999 23.44999-32.52998 43.48997-51.05996 60.12996-18.52999 16.63999-39.70997 28.35998-63.52995 35.16997-23.82999 6.81-51.62997 6.05-83.38994-2.27-31.01998-8.31999-56.16996-24.57998-75.44994-48.77996-19.28999-24.20998-33.65998-52.94996-43.10997-86.22993-9.46-33.27998-14.19-69.77995-14.19-109.48992 0-39.70397 4.35-79.22394 13.05-118.55591 8.7-39.33097 21.36998-77.14894 38.00997-113.45492 16.63999-36.30597 36.67997-67.50595 60.12995-93.60093 23.44999-26.09398 50.10997-45.75996 79.98994-58.99595 29.86998-13.237 62.20996-16.82999 96.99993-10.779 32.51998 6.051 59.36996 19.855 80.54994 41.41198 21.17998 21.55598 38.76997 47.65096 52.75996 78.28394 13.98999 30.63297 24.95998 64.47995 32.89998 101.54192 7.93999 37.06197 15.12998 74.12394 21.55998 111.18692 6.43 37.06197 12.85999 72.42194 19.28999 106.08192 6.41999 33.65997 14.92998 62.58995 25.51998 86.78993 10.58999 24.20998 24.01998 41.97997 40.27997 53.32996 16.25998 11.34 37.62997 12.84999 64.09995 4.53 30.25997-31.00998 54.45996-51.61996 72.60994-61.82996 18.15999-10.20999 31.38998-13.60999 39.70997-10.20999 8.32 3.4 11.91 11.91 10.78 25.52998-1.13 13.61-6.05 28.73998-14.75 45.37997-8.69999 16.63999-20.60998 32.89997-35.73997 48.77996-15.11999 15.88999-32.32997 27.98998-51.61996 36.30997-19.28998 8.32-40.46997 11.16-63.52995 8.51-23.06998-2.65-47.08997-14.56-72.04995-35.73998zm2413.83818 6.81c-2.26-39.32997-5.67-82.25994-10.20999-128.7699-4.53-46.51997-10.58-92.84993-18.14999-138.9899-7.55999-46.13396-16.63998-89.81493-27.22998-131.0369-10.58999-41.22197-23.06998-76.01494-37.43997-104.37892-14.36999-28.36298-30.81997-48.21797-49.34996-59.56396-18.52999-11.34499-39.51997-9.83199-62.96995 4.539-23.44998 14.37099-49.34997 43.30197-77.71994 86.79293-28.35998 43.49097-59.93996 106.08092-94.72993 187.76786-3.03 6.05-7 15.88-11.91 29.49998-4.91999 13.60999-10.20999 28.92998-15.88998 45.94997-5.67 17.01998-11.91 34.97997-18.71999 53.88996-6.8 18.90998-13.03999 37.05997-18.71998 54.45995-5.67 17.4-10.78 32.89998-15.31 46.50997-4.53999 13.61999-7.56999 23.82998-9.07998 30.63998-6.05 15.11998-13.62 23.62998-22.68999 25.52998-9.08 1.89-18.14998.18-27.22998-5.11-9.07999-5.3-17.39998-12.47999-24.95998-21.55998-7.56-9.07-12.09999-17.01999-13.61999-23.81999 6.81-26.47998 12.86-55.96995 18.15999-88.49993 5.29-32.51997 9.45-69.57995 12.47999-111.17991 3.02-41.60397 4.16-88.68794 3.4-141.2559-.76-52.56696-4.54-112.13091-11.35-178.69186 8.32-17.39599 16.65-27.03998 24.96999-28.93098 8.31999-1.891 16.63998.756 24.94998 7.942 8.32 7.18499 16.07999 17.77498 23.25998 31.76697 7.19 13.99299 13.61999 28.17498 19.28999 42.54597 5.67 14.37099 10.20999 27.79698 13.61998 40.27697 3.4 12.47999 5.1 20.61098 5.1 24.39298 16.63999-14.371 31.95998-32.71298 45.94997-55.02596 13.98999-22.31298 28.35997-44.62597 43.10996-66.93895 14.75-22.31298 30.82998-42.16697 48.21997-59.56396 17.39998-17.39598 38.19997-27.98597 62.39995-31.76697 49.91996-9.077 92.27993-3.215 127.0699 17.58499 34.79998 20.79998 63.34996 50.67696 85.65994 89.62993 22.30998 38.95297 39.32997 84.14593 51.05996 135.5789 11.72 51.43296 20.03999 103.05492 24.95998 154.86588 4.91 51.80996 6.99 101.34992 6.24 148.62989-.76 47.26996-2.65 86.02993-5.68 116.2899-8.32 17.39-19.46998 26.08999-33.46997 26.08999-13.99 0-25.13998-8.7-33.46998-26.08998zm-1029.72922-9.08c-43.86997-18.14998-78.46994-41.97996-103.80992-71.46994-25.33998-29.49998-43.10997-61.83995-53.32996-97.00993-10.21-35.16997-13.61-72.03994-10.21-110.61791 3.41-38.57497 12.48-76.20395 27.22999-112.88792 14.74998-36.68397 34.41997-71.28794 58.99995-103.81092 24.57998-32.52398 52.56996-60.32095 83.95994-83.38994 31.38997-23.06898 65.79995-40.08797 103.23992-51.05496 37.43997-10.967 76.20994-13.42599 116.28991-7.375 33.27998 5.295 61.83995 20.99 85.65994 47.08397 23.82998 26.09498 42.73996 58.42996 56.72995 97.00493 13.99 38.57397 22.87999 80.93094 26.65998 127.0699 3.78 46.13797 1.7 91.70893-6.24 136.7079-7.93999 45.00996-21.55997 86.79993-40.83996 125.3699-19.28999 38.57998-44.62997 69.77995-76.01994 93.59993-31.38998 23.82999-69.39995 37.81998-114.01992 41.97997-44.62996 4.16-96.05992-6.24-154.29988-31.19997zm-642.42952 0c-43.86996-18.14998-78.46994-41.97996-103.80992-71.46994-25.33998-29.49998-43.10997-61.83995-53.31996-97.00993-10.20999-35.16997-13.61999-72.03994-10.20999-110.61791 3.4-38.57497 12.48-76.20395 27.21998-112.88792 14.74999-36.68397 34.41997-71.28794 58.99996-103.81092 24.57998-32.52398 52.56996-60.32095 83.95993-83.38994 31.38998-23.06898 65.79995-40.08797 103.23992-51.05496 37.43998-10.967 76.20995-13.42599 116.29992-7.375 33.27997 5.295 61.82995 20.99 85.64993 47.08397 23.82998 26.09498 42.73997 58.42996 56.72996 97.00493 13.98999 38.57397 22.87998 80.93094 26.65998 127.0699 3.79 46.13797 1.71 91.70893-6.24 136.7079-7.94 45.00996-21.54998 86.79993-40.83997 125.3699-19.28998 38.57998-44.62996 69.77995-76.01994 93.59993-31.38997 23.82999-69.38995 37.81998-114.01991 41.97997-44.61997 4.16-96.05993-6.24-154.29989-31.19997zm-1823.64862-14.69998c-5.29-34.31998-9.64-71.39995-13.04999-111.24992-3.4-39.85997-6.24-80.95994-8.5-123.2999-2.27-42.34497-3.79-85.24294-4.54-128.6939-.75999-43.45198-1.13999-86.07294-1.13999-127.86391 0-41.78997.38-81.91994 1.14-120.38991.75-38.46997 1.89-74.30995 3.4-107.52092 2.27-9.41 8.13-15.63699 17.58998-18.68199 9.45-3.044 19.65999-3.736 30.62998-2.075 10.97 1.66 20.98998 5.12 30.06998 10.378 9.07 5.259 13.98999 11.48599 14.73999 18.68198-1.51 31.54998-2.64 62.40896-3.4 92.57593-.76 30.16698-.57 59.91796.57 89.25494 1.13 29.33597 3.4 58.81095 6.81 88.42493 3.4 29.61298 8.12999 59.64095 14.17998 90.08493 35.54998-34.31797 72.03995-55.90596 109.47992-64.76195 37.43997-8.856 72.79995-8.441 106.07992 1.245 33.27998 9.687 63.72995 26.56898 91.32993 50.64796 27.60998 24.07798 49.54996 51.61496 65.80995 82.61194 16.25999 31.00198 25.89998 63.65195 28.92998 97.97192 3.02 34.31998-3.22 66.41995-18.71999 96.30993-15.50998 29.88998-41.40996 55.62996-77.71994 77.21994-36.29997 21.58999-85.46993 35.42998-147.48989 41.50997-27.22998 2.77-50.86996 4.99-70.90994 6.65-20.03999 1.66-38.94997 1.8-56.72996.41-17.76999-1.38-35.91997-5.12-54.45996-11.21-18.52998-6.08999-39.89997-15.49998-64.09995-28.22997zm85.08994-154.42989c-9.83 32.09998-11.34 58.25996-4.53 78.45994 6.8 20.20999 18.89998 35.00998 36.29997 44.41997 17.39999 9.41 38.57997 14.11999 63.53995 14.11999 24.95998 0 50.66997-3.74 77.13995-11.21 26.47998-7.46999 52.37996-18.12998 77.71994-31.96997 25.33998-13.83999 47.08996-30.15997 65.23995-48.97996 13.60999-13.83999 20.79998-30.58998 21.55998-50.23996.75-19.64999-2.84-39.70997-10.78-60.18996-7.94998-20.47998-19.85998-40.13097-35.73996-58.95095-15.88-18.81999-33.65998-34.31798-53.31996-46.49597-19.66999-12.17699-40.65997-19.64998-62.96996-22.41698-22.31998-2.768-44.24996 1.799-65.80995 13.69899-21.54998 11.90099-41.78996 32.10397-60.69995 60.61095-18.90999 28.50398-34.78997 68.22395-47.64996 119.14391zm2380.9882 74.95995c49.15996 31.76997 93.21993 45.00996 132.1799 39.70997 38.94997-5.29 71.65995-21.92999 98.12993-49.91997 26.47998-27.97997 46.32996-63.71995 59.56995-107.20991 13.24-43.48997 18.90999-87.92994 17.01999-133.3119-1.9-45.38197-11.73-87.54994-29.49998-126.5029-17.77999-38.95298-44.81997-68.26196-81.11994-87.92694-20.41998-10.59-44.24997-10.022-71.47994 1.701-27.22998 11.72399-53.88996 30.63297-79.97994 56.72795-26.09998 26.09498-49.73997 57.29496-70.90995 93.60093-21.17999 36.30498-35.54997 73.55695-43.11997 111.75292-7.56 38.19897-6.62 75.06894 2.84 110.61892 9.45 35.54997 31.57998 65.79995 66.36995 90.75993zm-642.42952 0c49.16997 31.76997 93.21993 45.00996 132.1799 39.70997 38.94997-5.29 71.65995-21.92999 98.13993-49.91997 26.46998-27.97997 46.31997-63.71995 59.55996-107.20991 13.23999-43.48997 18.90998-87.92994 17.01998-133.3119-1.89-45.38197-11.71999-87.54994-29.49998-126.5029-17.76998-38.95298-44.80996-68.26196-81.11993-87.92694-20.41999-10.59-44.24997-10.022-71.47995 1.701-27.22998 11.72399-53.88996 30.63297-79.97994 56.72795-26.09998 26.09498-49.72996 57.29496-70.90995 93.60093-21.17998 36.30498-35.54997 73.55695-43.10996 111.75292-7.57 38.19897-6.62 75.06894 2.83 110.61892 9.45999 35.54997 31.57997 65.79995 66.36994 90.75993zm-1159.18912-39.69997c19.65998 30.24997 40.26997 47.64996 61.82995 52.18996 21.55999 4.53 42.53997.56 62.96995-11.92 20.41999-12.47998 39.70997-31.00997 57.85996-55.58995 18.14999-24.57998 33.65998-50.86996 46.51997-78.84994 12.84999-27.98998 22.30998-55.40696 28.35997-82.25794 6.05-26.85098 7.56-48.97496 4.54-66.37095-3.78-18.15299-6.81-34.41497-9.08-48.78596-2.27-14.371-4.72999-27.22898-7.36999-38.57497-2.65-11.345-5.68-21.74599-9.07999-31.19998-3.4-9.455-8.13-19.09799-14.17999-28.93098-30.25998-21.17898-58.42996-29.49898-84.52994-24.95998-26.08998 4.538-49.53996 17.39599-70.33994 38.57397-20.79999 21.17898-38.18997 48.40796-52.18996 81.68794-13.99 33.27997-24.19998 68.07295-30.62998 104.37892-6.43 36.30597-8.51 71.47995-6.24 105.50992 2.27 34.03998 9.45 62.39995 21.55999 85.09994z" fill="#282828" fill-rule="nonzero"/>
                        <path d="M6892.93785 1141.07765l-2.93-847.33736c-.01-1.191.2-2.374.61-3.492 6.06-16.43098 13.87-28.16497 22.94999-35.51497 9.95999-8.065 20.24998-11.87199 30.67997-11.87199 10.37 0 19.54999 2.66 27.55998 7.845 8.86 5.732 14.1 12.94799 16.18 21.28698.16.625.25 1.264.29 1.908 2.26999 43.93997 4.15999 92.80393 5.67999 146.59289 1.51 53.75096 2.65 109.96191 3.4 168.63387.76 58.61996 1.52 118.75391 2.27 180.39986.76 61.66396 1.33 122.76091 1.71 183.28987.37 60.52995.56 119.1699.56 175.91986 0 56.66996.38 109.18992 1.13999 157.54988.01 1.06-.14 2.12-.46 3.13-4.6 14.73-12.99999 25.43998-24.96998 32.34998-11.7 6.75-23.64998 9.58-35.79997 8.68-12.44-.92-23.51999-5.71-33.19998-14.47-9.87-8.93-15.19999-21.69998-15.19999-38.57997l-.25-72.25994c-2.06 5.06-4.48 10.24999-7.27 15.58998-9.08998 17.41-21.52998 34.43998-37.35996 51.04997-16.08 16.88998-34.38998 29.74997-54.89996 38.58997-20.83999 8.98999-43.70997 12.12999-68.62995 9.25999-24.60998-2.82-50.33996-15.20999-76.94994-37.68997-7.62-5.23-15.41999-14.25-23.02998-27.34998-6.92-11.92-13.84-24.98998-20.75999-39.21997-6.83-14.02-13.64999-28.23998-20.46998-42.63997-6.53-13.77999-13.4-25.75998-20.65999-35.90997-6.62-9.27-13.48999-16.15999-20.76998-20.45999-4.67-2.76-9.71-2.7-15.12-.35-14.69998 24.18998-29.57997 47.66997-44.62996 70.42995-16.00999 24.20998-33.58997 44.87997-52.71996 62.05995-19.67998 17.66999-42.16997 30.11998-67.46995 37.34997-25.32998 7.23-54.88996 6.63-88.72993-2.23-33.15997-8.89999-60.03995-26.31997-80.66994-52.20995-20.07998-25.18998-35.06997-55.08996-44.90996-89.72994-9.7-34.10997-14.57-71.50994-14.57-112.21991 0-40.42697 4.43-80.66694 13.29-120.71491 8.84999-40.02697 21.73998-78.51394 38.67997-115.46191 17.08998-37.28898 37.69997-69.31695 61.77995-96.11793 24.43998-27.19398 52.23996-47.66197 83.36994-61.45595 31.65997-14.024 65.90995-17.899 102.88992-11.467 34.67997 6.452 63.26995 21.24799 85.85994 44.23397 21.94998 22.34798 40.20996 49.38096 54.70995 81.13794 14.28 31.25498 25.48998 65.78695 33.58998 103.60192 7.97 37.19097 15.17999 74.38195 21.62998 111.57192 6.42 37.00197 12.84 72.31194 19.25999 105.91192 6.27 32.82997 14.53999 61.05995 24.85998 84.65993 9.73 22.24999 21.89998 38.70997 36.83997 49.12997 13.55 9.45999 31.25998 10.32999 53.02996 3.92 30.31998-30.90998 54.72996-51.40997 73.05995-61.72996 12.16999-6.84 22.40998-10.8 30.62997-12.17 7.06-1.17999 12.97-.53999 17.76999 1.42 3.08 1.26 5.82 2.97 8.15 5.15zm171.26987-850.82935c-.41 1.118-.62 2.301-.62 3.492l3.4 983.65725c0 16.87999 5.34 29.64998 15.21 38.57997 9.67998 8.76 20.75997 13.55 33.19997 14.47 12.14999.9 24.09998-1.93 35.79997-8.68 11.95999-6.91 20.36998-17.61999 24.96998-32.34998.32-1.01.47-2.07.45-3.13-.75-48.35996-1.13-100.87992-1.13-157.54988 0-56.74995-.19-115.3899-.57-175.91986-.38-60.52896-.94-121.62591-1.7-183.28987-.76-61.64595-1.51-121.7799-2.27-180.39986-.76-58.67196-1.89-114.88291-3.41-168.63387-1.51-53.78896-3.4-102.65292-5.67999-146.5929-.03-.644-.13-1.283-.28-1.90799-2.09-8.339-7.32-15.55499-16.17999-21.28698-8.02-5.185-17.18998-7.845-27.55998-7.845-10.43999 0-20.71998 3.807-30.68997 11.872-9.08 7.34999-16.88999 19.08398-22.93999 35.51497zm1588.0788 521.3466c11.02-11.49199 21.36999-24.98198 31.06998-40.44997 14.03-22.37998 28.44998-44.75996 43.23997-67.13995 15.13999-22.89798 31.63998-43.26796 49.48996-61.12095 18.93999-18.93699 41.57997-30.45998 67.67995-34.53497 52.65996-9.574 97.29993-3.098 133.9899 18.84098 36.21997 21.64899 65.98995 52.69896 89.20993 93.24193 22.76999 39.74697 40.15997 85.84694 52.12996 138.3279 11.82 51.85696 20.20999 103.90492 25.15998 156.14788 4.96 52.18996 7.05 102.09992 6.29 149.72989-.77 47.60996-2.68 86.64993-5.73 117.1199-.11 1.16-.43 2.28-.92 3.32-10.40999 21.74999-24.99998 31.77998-42.49996 31.77998-17.48999 0-32.07998-10.03-42.48997-31.77997-.56-1.17-.88-2.44-.96-3.73-2.26-39.21997-5.65-82.00994-10.18-128.3799-4.51999-46.29997-10.53998-92.40994-18.06998-138.3399-7.51-45.82997-16.51999-89.21993-27.03998-130.1689-10.38999-40.41497-22.58998-74.53795-36.67997-102.34693-13.35999-26.36698-28.42998-45.00796-45.64997-55.55495-15.47998-9.474-32.93997-7.465-52.51996 4.536-22.56998 13.82998-47.26996 41.87496-74.56994 83.72993-28.12998 43.12897-59.40996 105.21592-93.90993 186.22486-.08.19-.17.37-.26.55-2.91 5.83-6.71 15.30999-11.45 28.42998-4.88999 13.53999-10.15998 28.77998-15.79998 45.70996-5.7 17.09-11.95999 35.12998-18.79998 54.11996-6.77 18.80999-12.98 36.85997-18.61999 54.16996-5.68 17.41999-10.79 32.93998-15.33999 46.57997-4.39 13.16999-7.33 23.04998-8.8 29.63997-.12.52-.28 1.04-.48 1.54-7.70999 19.27999-18.35998 29.19998-29.92997 31.59998-11.43 2.39-22.87998.41-34.30997-6.25-10.03-5.85-19.24999-13.76999-27.59998-23.78998-8.86-10.63999-13.93-20.08998-15.7-28.05998-.33999-1.54-.30999-3.14.08-4.66 6.74-26.20997 12.73-55.41995 17.97-87.60993 5.25-32.26997 9.36999-69.03995 12.36999-110.30991 3.01-41.34297 4.13-88.13794 3.38-140.3819-.75-52.31096-4.52-111.58291-11.29-177.81786-.19-1.829.13-3.674.92-5.332 10.19-21.30698 21.57999-32.05198 31.76998-34.36797 11.17999-2.541 22.52998.468 33.70997 10.12499 9.13 7.881 17.73999 19.41898 25.61998 34.76697 7.34 14.288 13.9 28.76898 19.68999 43.44197 5.82 14.74199 10.46999 28.51598 13.95999 41.31797.7 2.54 1.32 4.919 1.87 7.135zm-1260.43904 469.29265c-45.43997-18.81999-81.21994-43.59997-107.46992-74.15995-26.30998-30.62997-44.73997-64.20995-55.34996-100.72992-10.55-36.33997-14.07999-74.42994-10.56-114.28691 3.48-39.54797 12.79-78.12894 27.90999-115.73892 15.06999-37.49597 35.16997-72.86794 60.28995-106.11092 25.18998-33.31797 53.85996-61.78595 86.01994-85.41793 32.32997-23.76398 67.77995-41.29597 106.34992-52.59396 38.82997-11.373 79.02994-13.941 120.6799-7.653 35.51998 5.652 66.02996 22.35899 91.46994 50.21697 24.64998 26.99898 44.25996 60.42495 58.73995 100.33692 14.28 39.36297 23.36998 82.58094 27.22998 129.6629 3.85 46.99997 1.73 93.42293-6.36 139.2649-8.10999 45.98996-22.03998 88.68993-41.74996 128.1099-20.00999 40.01997-46.33997 72.36995-78.90994 97.08993-32.80998 24.89998-72.49995 39.61997-119.13991 43.96996-46.01997 4.29-99.08993-6.22-159.14988-31.95997zm642.41951 0c-45.43996-18.81999-81.21994-43.59997-107.46992-74.15995-26.30998-30.62997-44.73996-64.20995-55.33995-100.72992-10.55-36.33997-14.08-74.42994-10.57-114.28691 3.49-39.54797 12.79-78.12894 27.90998-115.73892 15.08-37.49597 35.17998-72.86794 60.29996-106.11092 25.17998-33.31797 53.85996-61.78595 86.00993-85.41793 32.33998-23.76398 67.78995-41.29597 106.35992-52.59396 38.82997-11.373 79.01994-13.941 120.66991-7.653 35.52997 5.652 66.03995 22.35899 91.47993 50.21697 24.64998 26.99898 44.25997 60.42495 58.73996 100.33692 14.27999 39.36297 23.36998 82.58094 27.22998 129.6629 3.85 46.99997 1.73 93.42293-6.36 139.2649-8.12 45.98996-22.03998 88.68993-41.74997 128.1099-20.00998 40.01997-46.33996 72.36995-78.90994 97.08993-32.80997 24.89998-72.49994 39.61997-119.1399 43.96996-46.01997 4.29-99.09993-6.22-159.15989-31.95997zM6968.3578 276.0543c-1.1-3.399-3.7-6.152-7.41999-8.557-4.84-3.135-10.41999-4.636-16.68999-4.636-6.2 0-12.17999 2.622-18.09998 7.417-6.5 5.259-11.73 13.762-16.13999 25.24198l3.4 981.84726c0 10.31 2.6 18.33999 8.62 23.77998 6.20999 5.62 13.27998 8.76 21.25998 9.36 8.26999.61 16.35998-1.47 24.32998-6.07 7.31-4.21 12.36999-10.78 15.39999-19.52998-.75-47.98997-1.12-100.04993-1.12-156.16989 0-56.70995-.19-115.30991-.56-175.79486-.38-60.48896-.95-121.54591-1.7-183.16987-.76-61.64195-1.52-121.7709-2.27-180.38686-.76-58.56596-1.89-114.67491-3.4-168.32887-1.5-53.15996-3.37-101.49493-5.61-145.0029zm173.57988 0c-1.1-3.399-3.69-6.152-7.41-8.557-4.84-3.135-10.42-4.636-16.68999-4.636-6.21 0-12.17999 2.622-18.09998 7.417-6.5 5.259-11.74 13.762-16.14 25.24198l3.39 981.84726c0 10.31 2.61 18.33999 8.63 23.77998 6.2 5.62 13.27999 8.76 21.25998 9.36 8.27.61 16.36-1.47 24.31999-6.07 7.31-4.21 12.36999-10.78 15.39998-19.52998-.74-47.98997-1.11-100.04993-1.11-156.16989 0-56.70995-.19-115.30991-.57-175.79486-.37-60.48896-.94-121.54591-1.7-183.16987-.75-61.64195-1.51-121.7709-2.27-180.38686-.75-58.56596-1.88999-114.67491-3.39999-168.32887-1.49-53.15996-3.36-101.49493-5.61-145.0029zm-1474.8589 611.05154c32.78998-28.61098 66.40996-46.87097 100.71993-54.98596 39.23997-9.282 76.29994-8.777 111.17992 1.375 34.64997 10.08599 66.35995 27.64098 95.10993 52.71196 28.56997 24.91798 51.24996 53.42596 68.07995 85.50393 16.88998 32.18698 26.89997 66.10695 30.03997 101.73693 3.2 36.27997-3.42 70.20994-19.80998 101.79992-16.27999 31.37997-43.34997 58.53995-81.47994 81.19994-37.32997 22.19998-87.83993 36.60997-151.58989 42.86996-27.29998 2.78-50.99996 5-71.08994 6.66-20.60999 1.71-40.05997 1.84-58.32996.42-18.53999-1.44-37.47997-5.33-56.80996-11.68-18.96998-6.22999-40.84997-15.83998-65.62995-28.87997-2.81-1.47-4.75-4.19-5.23-7.32-5.32999-34.52997-9.70999-71.83994-13.12998-111.92991-3.41-39.95997-6.26-81.15994-8.53-123.6199-2.28-42.45897-3.79-85.47694-4.55-129.0499-.76-43.51098-1.14-86.18994-1.14-128.03791 0-41.85797.38-82.05394 1.14-120.58691.76-38.56197 1.89-74.48795 3.41-107.77892.03-.637.12-1.27.27-1.889 3.13-12.99999 11.18-21.65098 24.23999-25.85598 10.86999-3.498 22.58998-4.353 35.19997-2.445 12.24999 1.856 23.43998 5.739 33.57997 11.614 12.52 7.25499 18.62999 16.35998 19.67999 26.28797.05.506.07 1.016.04 1.524-1.51 31.47298-2.64 62.25596-3.39 92.34793-.75 29.95198-.57 59.49096.56 88.61794 1.12 29.08597 3.37 58.30895 6.75 87.66993 2.72 23.63898 6.28 47.54596 10.70999 71.71995zm992.55926 378.53171c-5.84-3.89-11.48-11.03-17.31999-21.08998-6.7-11.53-13.38999-24.16999-20.07998-37.92998-6.79-13.95998-13.58-28.10997-20.37999-42.44996-7.08-14.97-14.57999-27.94998-22.44998-38.97997-8.51-11.9-17.51999-20.51999-26.87998-26.04998-11.32-6.69-23.67998-6.83-37.05997.37-1.57.85-2.88 2.1-3.81 3.62-15.05999 24.84997-30.29998 48.93996-45.73996 72.27994-15 22.68998-31.45998 42.10997-49.38997 58.20995-17.37998 15.61-37.24997 26.60998-59.59995 32.99998-22.31999 6.37-48.34997 5.46-78.10994-2.33-28.79998-7.73-52.21996-22.82998-70.15995-45.34996-18.49999-23.20999-32.24998-50.79997-41.31997-82.71994-9.21-32.44998-13.79999-68.03995-13.79999-106.75992 0-38.98097 4.27-77.78094 12.81-116.39591 8.54998-38.63497 20.98998-75.78495 37.33996-111.44792 16.19-35.32397 35.65998-65.69495 58.47996-91.08393 22.45998-24.99598 47.97996-43.85797 76.59994-56.53696 28.08998-12.44899 58.50996-15.75999 91.23993-10.069 30.24998 5.628 55.35996 18.44 75.12995 38.56698 20.39998 20.76598 37.30997 45.92097 50.78996 75.43094 13.70999 30.00998 24.43998 63.17396 32.21997 99.48293 7.92 36.93297 15.08 73.86594 21.48999 110.79991 6.43 37.12298 12.86999 72.53295 19.30998 106.24292 6.59 34.48998 15.34 64.12996 26.18998 88.92994 11.45 26.16998 26.13998 45.24996 43.71997 57.51995 18.48999 12.9 42.71997 15.33 72.81994 5.87 1.58-.49 3.01-1.37 4.16-2.55 29.34998-30.08998 52.73996-50.19996 70.35995-60.09995 8.15-4.59 15.17999-7.72 21.11998-9.24 4.06-1.05 7.35-1.48 9.9-.44 4.83 1.98 5.26 7.53 4.6 15.45-1.04 12.47998-5.67 26.31997-13.65 41.57996-8.3 15.86999-19.68998 31.36998-34.11997 46.51997-14.17 14.87998-30.26998 26.22998-48.33997 34.01997-17.73998 7.65-37.21997 10.19-58.42995 7.76-21.40999-2.46-43.55997-13.78-66.71995-33.42998l-.92-.7zm2465.44814 12.35c2.91-29.76999 4.72-67.65996 5.46-113.66992.75-46.92997-1.32-96.09993-6.2-147.5199-4.87-51.38895-13.12999-102.58491-24.74998-153.59388-11.49-50.38496-28.12998-94.67092-49.98996-132.8309-21.39999-37.36197-48.73997-66.06595-82.10994-86.01693-32.88998-19.65999-72.95995-24.90898-120.38991-16.28799-22.05998 3.447-41.01997 13.102-56.87996 28.95798-16.93999 16.93999-32.57997 36.27997-46.93996 58.00796-14.71 22.24498-29.03998 44.49096-42.98997 66.73695-14.56999 23.23798-30.54998 42.31396-47.87996 57.28095-2.96 2.557-7.14 3.153-10.7 1.525-3.56-1.628-5.84-5.181-5.84-9.093 0-3.38099-1.70999-10.60698-4.74999-21.76198-3.32-12.15799-7.74-25.23598-13.26999-39.23597-5.55-14.06799-11.84999-27.95098-18.87998-41.64996-6.49-12.637-13.39-22.27799-20.89999-28.76698-5.47-4.718-10.73999-7-16.20999-5.759-2.45.558-4.67 2.587-7.11999 5.432-3.3 3.817-6.54 9.02999-9.82 15.58699 6.66 65.73995 10.36 124.6399 11.11 176.70886.76 52.89196-.39 100.26493-3.43 142.1199-3.05 41.92996-7.25 79.28994-12.57999 112.06991-5.18 31.79998-11.08 60.72995-17.68999 86.79993 1.68 5.13 5.45 10.9 10.96 17.51 6.77 8.11999 14.18999 14.57998 22.31998 19.31998 6.72 3.93 13.41999 5.36 20.14998 3.96 6.46-1.35 10.86-8.16 15.16-18.77 1.62-7.01999 4.65999-17.27998 9.15999-30.76997 4.53-13.58999 9.62999-29.07998 15.29998-46.44996 5.7-17.48999 11.97-35.73998 18.80999-54.74996 6.78-18.82999 12.99999-36.71997 18.63999-53.65996 5.71-17.10999 11.02999-32.49998 15.96998-46.18997 5.02-13.88999 9.11-23.97298 12.22-30.26797 35.04997-82.24394 66.88994-145.2539 95.45992-189.06286 29.42998-45.12797 56.52996-74.94494 80.85994-89.85593 27.31998-16.744 51.82996-17.75999 73.41995-4.541 19.83998 12.144 37.66997 33.21197 53.04996 63.57295 14.64998 28.91898 27.40998 64.38095 38.20997 106.40992 10.65999 41.49597 19.79998 85.46594 27.40998 131.9149 7.6 46.34997 13.67999 92.88993 18.23998 139.6299 4.47 45.84996 7.84 88.22993 10.12 127.1199 6.08999 12 13.56998 18.70999 23.59998 18.70999 10.08999 0 17.58998-6.77 23.68998-18.86999zm-1725.4887-15.54c-42.25997-17.47998-75.64994-40.33997-100.04992-68.74995-24.36999-28.36997-41.48997-59.44995-51.30996-93.27993-9.87-33.99997-13.14-69.64994-9.85-106.94891 3.31-37.60098 12.17-74.27895 26.53998-110.03592 14.43-35.87297 33.65998-69.70795 57.69996-101.51292 23.97998-31.72998 51.27996-58.85496 81.89994-81.36094 30.43997-22.37399 63.81995-38.87897 100.12992-49.51597 36.05997-10.56199 73.38995-12.91099 111.98992-7.084 30.95997 4.925 57.54995 19.607 79.76994 43.93898 22.99998 25.18998 41.19997 56.43395 54.70996 93.67193 13.70999 37.78597 22.38998 79.28094 26.09998 124.4769 3.71 45.27597 1.67 89.99593-6.12 134.1609-7.77 44.01997-21.07998 84.89994-39.94997 122.6299-18.55999 37.11998-42.89997 67.17996-73.10994 90.10994-29.96998 22.74998-66.29995 36.00997-108.90992 39.98997-43.22997 4.03-93.00993-6.26-149.42989-30.43998l-.11-.05zm642.41952 0c-42.24997-17.47998-75.63995-40.33997-100.04993-68.74995-24.35998-28.36997-41.47997-59.44995-51.29996-93.27993-9.87-33.99997-13.14999-69.64994-9.86-106.94891 3.32-37.60098 12.17-74.27895 26.54999-110.03592 14.41999-35.87297 33.65997-69.70795 57.69995-101.51292 23.97999-31.72998 51.27997-58.85496 81.89994-81.36094 30.43998-22.37399 63.81995-38.87897 100.12993-49.51597 36.05997-10.56199 73.38994-12.91099 111.98991-7.084 30.94998 4.925 57.54996 19.607 79.76994 43.93898 22.99999 25.18998 41.19997 56.43395 54.70996 93.67193 13.7 37.78597 22.38998 79.28094 26.08998 124.4769 3.71 45.27597 1.68 89.99593-6.12 134.1609-7.76999 44.01997-21.06998 84.89994-39.93996 122.6299-18.55999 37.11998-42.90997 67.17996-73.10995 90.10994-29.96998 22.74998-66.29995 36.00997-108.90992 39.98997-43.22996 4.03-93.00993-6.26-149.42988-30.43998l-.12-.05zM5632.4288 546.7151c-.72-4.174-4.34-7.351-9.72999-10.47199-8.01-4.642-16.86999-7.678-26.54998-9.144-9.33-1.413-18.01998-.883-26.06998 1.707-5.56 1.792-9.16 5.322-10.71 10.675-1.47999 32.83197-2.59999 68.23495-3.33999 106.20592-.76 38.40597-1.14 78.47094-1.14 120.1929 0 41.73398.38 84.29694 1.14 127.68891.75 43.32997 2.26 86.10694 4.52 128.3289 2.26 42.23997 5.09 83.22994 8.49 122.97991 3.21999 37.68997 7.27999 72.88995 12.20998 105.58992 21.78999 11.26 41.14997 19.67999 58.09996 25.24998 17.72999 5.83 35.09997 9.42 52.10996 10.74 17.26999 1.35 35.64997 1.2 55.11996-.41 19.99998-1.66 43.56997-3.87 70.75994-6.63 60.26996-5.91 108.08992-19.17999 143.3599-40.15997 34.48997-20.49998 59.21995-44.82997 73.94994-73.21994 14.61999-28.18998 20.48999-58.46996 17.63999-90.82994-2.91-32.99997-12.19-64.39995-27.82998-94.20593-15.68999-29.91597-36.86997-56.48395-63.51995-79.72193-26.46998-23.08499-55.63996-39.29498-87.54994-48.58197-31.67997-9.221-65.34995-9.546-100.98992-1.115-35.87997 8.488-70.76995 29.33298-104.83992 62.22396-2.63 2.541-6.44 3.442-9.93 2.349-3.49-1.093-6.10999-4.005-6.81999-7.594-6.11-30.71598-10.88-61.01395-14.30999-90.89293-3.43-29.86598-5.72-59.59296-6.86-89.17993-1.15-29.54598-1.34-59.50996-.58-89.89194.75-29.94797 1.88-60.57595 3.37-91.88193zm15.14 553.17259c13.18998-52.14997 29.57997-92.78993 48.95996-122.00191 19.95998-30.08698 41.44996-51.27696 64.19995-63.83695 23.53998-12.994 47.49996-17.891 71.86994-14.869 23.73999 2.944 46.07997 10.883 66.99995 23.83899 20.53999 12.71799 39.10997 28.89298 55.69996 48.54796 16.63999 19.71899 29.09998 40.32097 37.41997 61.78096 8.47 21.83998 12.25 43.24996 11.45 64.19995-.86 22.23998-9.01 41.18997-24.34999 56.78995-18.82998 19.51999-41.36997 36.46998-67.63995 50.81997-26.01998 14.20999-52.61996 25.13998-79.79994 32.80997-27.39998 7.74-54.02996 11.59-79.85994 11.59-26.84998 0-49.58996-5.2-68.29994-15.32-19.60999-10.60999-33.33998-27.23998-41.01997-50.02996-7.32-21.70998-6.15-49.83996 4.37-84.31993zm19.33998 5.12c12.51999-49.58997 27.86998-88.30994 46.28996-116.06692 17.85999-26.92498 36.82998-46.14197 57.19996-57.38296 19.56999-10.80799 39.46997-15.04399 59.73996-12.52999 20.87998 2.59 40.51996 9.597 58.92995 20.99499 18.78999 11.63699 35.76997 26.45898 50.94996 44.44396 15.12 17.92099 26.48998 36.61097 34.04998 56.11096 7.42 19.12999 10.81999 37.84997 10.10999 56.19996-.65 17.04998-6.87 31.58997-18.68999 43.59996-17.54998 18.2-38.49997 33.89998-62.89995 47.22997-24.65998 13.46999-49.86996 23.83998-75.63994 31.10998-25.53998 7.20999-50.34996 10.83999-74.42995 10.83999-23.07998 0-42.69996-4.21-58.77995-12.91-15.18-8.20999-25.64998-21.19998-31.58998-38.81996-6.28-18.63999-4.44-42.72997 4.63-72.33995l.13-.48zm1723.4387 80.90993c51.62996 33.36998 98.03992 46.77997 138.9499 41.21997 41.29996-5.61 75.97994-23.27998 104.04991-52.95996 27.45998-29.02998 48.13997-66.05995 61.86996-111.16992 13.55999-44.57996 19.37998-90.12293 17.43998-136.6379-1.95-46.72396-12.08999-90.13293-30.38997-130.2379-18.71999-41.02096-47.21997-71.85994-85.45994-92.56893-23.01998-11.93999-49.70996-11.81599-80.18994 1.31-28.27998 12.173-56.00995 31.74398-83.09993 58.84096-26.66998 26.66498-50.83997 58.53395-72.47995 95.63293-21.75998 37.30897-36.50997 75.59694-44.27997 114.84991-7.87999 39.75097-6.86 78.13094 2.98 115.13091 10.02 37.67997 33.31998 69.85995 70.19995 96.31993l.41.27zm642.41951 0c51.62996 33.36998 98.04993 46.77997 138.9499 41.21997 41.30997-5.61 75.98994-23.27998 104.05992-52.95996 27.45998-29.02998 48.12996-66.05995 61.86995-111.16992 13.56-44.57996 19.37999-90.12293 17.43999-136.6379-1.95-46.72396-12.09-90.13293-30.38998-130.2379-18.71998-41.02096-47.22996-71.85994-85.45993-92.56893-23.01998-11.93999-49.70996-11.81599-80.18994 1.31-28.27998 12.173-56.00996 31.74398-83.10994 58.84096-26.65998 26.66498-50.82996 58.53395-72.46994 95.63293-21.76999 37.30897-36.51998 75.59694-44.28997 114.84991-7.87 39.75097-6.86 78.13094 2.98 115.13091 10.02999 37.67997 33.32997 69.85995 70.20994 96.31993l.4.27zm11.07-16.65999c46.60996 30.07998 88.23993 43.08997 125.1899 38.06997 36.59997-4.98 67.34995-20.58998 92.21993-46.88996 25.47998-26.93998 44.51997-61.38995 57.25996-103.24992 12.90999-42.40997 18.43998-85.73594 16.58999-129.9859-1.83-44.03997-11.35-84.96594-28.59998-122.76691-16.82999-36.88497-42.40997-64.66495-76.62995-83.20194-17.97998-9.323-38.93997-8.313-62.91995 2.009-26.17998 11.274-51.76996 29.52098-76.85994 54.61396-25.52998 25.52498-48.62996 56.05596-69.34995 91.56793-20.58998 35.30297-34.57997 71.51695-41.93997 108.65792-7.24999 36.63597-6.38 72.00594 2.69 106.10592 8.87 33.34997 29.74998 61.62995 62.34996 85.06993zm-642.42952 0c46.60996 30.07998 88.24993 43.08997 125.1899 38.06997 36.59998-4.98 67.34995-20.58998 92.21994-46.88996 25.48998-26.93998 44.51996-61.38995 57.25995-103.24992 12.91-42.40997 18.43999-85.73594 16.59999-129.9859-1.84-44.03997-11.36-84.96594-28.60998-122.76691-16.82999-36.88497-42.39997-64.66495-76.61994-83.20194-17.97999-9.323-38.94997-8.313-62.91995 2.009-26.18998 11.274-51.77996 29.52098-76.86995 54.61396-25.52998 25.52498-48.62996 56.05596-69.33994 91.56793-20.59999 35.30297-34.58998 71.51695-41.94997 108.65792-7.25 36.63597-6.37 72.00594 2.7 106.10592 8.86999 33.34997 29.73997 61.62995 62.33995 85.06993zm-1173.21912-25.98998c21.51999 33.09998 44.56997 51.54996 68.15995 56.51996 24.03999 5.06 47.46997.75 70.23995-13.16999 21.39998-13.06999 41.66997-32.41998 60.68995-58.17996 18.56-25.12998 34.41998-52.00996 47.55997-80.61994 13.16999-28.64997 22.83998-56.73495 29.03998-84.22993 6.4-28.42898 7.83-51.86396 4.63-70.28295l-.06-.326c-3.75-17.97399-6.74-34.07597-8.99-48.30596-2.31-14.636-4.82-27.73198-7.52-39.28697-2.74-11.752-5.86999-22.52199-9.39999-32.31498-3.62-10.059-8.64-20.32498-15.06999-30.78498-.72-1.164-1.67-2.168-2.79-2.952-32.86997-23.00798-63.61995-31.54997-91.96992-26.61997-28.08998 4.885-53.36996 18.62598-75.75995 41.41997-21.60998 21.99998-39.73997 50.24796-54.27996 84.81893-14.26999 33.96098-24.69998 69.46395-31.25997 106.51092-6.57 37.13497-8.69 73.11395-6.37 107.92392 2.38 35.65997 10.03 65.34995 22.70999 89.12993l.44.75zm223.31984-388.7207c-26.98998-18.50399-52.01996-26.18998-75.36995-22.12799-24.10998 4.192-45.70996 16.16699-64.91995 35.72898-19.99998 20.35698-36.65997 46.56796-50.10996 78.55694-13.70999 32.59997-23.70998 66.68295-29.99998 102.24692-6.29 35.47697-8.33 69.84595-6.11 103.10592 2.15 32.21998 8.8 59.13996 20.2 80.67994 17.73998 27.17998 35.82996 43.38997 55.26995 47.47996 19.06999 4.02 37.61997.38 55.68996-10.65999 19.44998-11.87999 37.74997-29.59997 55.02996-52.99996 17.74998-24.02998 32.90997-49.72996 45.47996-77.08994 12.55-27.30998 21.78999-54.06896 27.68998-80.27594 5.69-25.21598 7.29-45.98996 4.46-62.34495-3.79-18.24499-6.83-34.59698-9.12-49.05396-2.22-14.106-4.63-26.72698-7.22999-37.86298-2.55-10.93899-5.47-20.96898-8.75-30.08497-2.98-8.28-7.05999-16.709-12.20998-25.29798z" fill="#fff"/>
                    </g>
                </svg>
            </span>
            <br />

            <span style="width: 34px; top: -5px;"><svg aria-hidden="true" focusable="false" data-prefix="fab" data-icon="facebook" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svg-inline--fa fa-facebook fa-w-16 fa-2x"><path fill="#475e8f" d="M504 256C504 119 393 8 256 8S8 119 8 256c0 123.78 90.69 226.38 209.25 245V327.69h-63V256h63v-54.64c0-62.15 37-96.48 93.67-96.48 27.14 0 55.52 4.84 55.52 4.84v61h-31.28c-30.8 0-40.41 19.12-40.41 38.73V256h68.78l-11 71.69h-57.78V501C413.31 482.38 504 379.78 504 256z" class=""></path></svg></span>

            <?php echo $plus_svg; ?>

            <span><svg aria-hidden="true" focusable="false" data-prefix="fab" data-icon="instagram" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="svg-inline--fa fa-instagram fa-w-14 fa-2x"><path fill="#e15073" d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z" class=""></path></svg></span>

            <?php echo $plus_svg; ?>

            <span style="top: -4px;"><svg aria-hidden="true" focusable="false" data-prefix="fab" data-icon="twitter" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svg-inline--fa fa-twitter fa-w-16 fa-2x"><path fill="#1a92dc" d="M459.37 151.716c.325 4.548.325 9.097.325 13.645 0 138.72-105.583 298.558-298.558 298.558-59.452 0-114.68-17.219-161.137-47.106 8.447.974 16.568 1.299 25.34 1.299 49.055 0 94.213-16.568 130.274-44.832-46.132-.975-84.792-31.188-98.112-72.772 6.498.974 12.995 1.624 19.818 1.624 9.421 0 18.843-1.3 27.614-3.573-48.081-9.747-84.143-51.98-84.143-102.985v-1.299c13.969 7.797 30.214 12.67 47.431 13.319-28.264-18.843-46.781-51.005-46.781-87.391 0-19.492 5.197-37.36 14.294-52.954 51.655 63.675 129.3 105.258 216.365 109.807-1.624-7.797-2.599-15.918-2.599-24.04 0-57.828 46.782-104.934 104.934-104.934 30.213 0 57.502 12.67 76.67 33.137 23.715-4.548 46.456-13.32 66.599-25.34-7.798 24.366-24.366 44.833-46.132 57.827 21.117-2.273 41.584-8.122 60.426-16.243-14.292 20.791-32.161 39.308-52.628 54.253z" class=""></path></svg></span>

            <?php echo $plus_svg; ?>

            <span style="width: 35px; top: -5px;"><svg aria-hidden="true" focusable="false" data-prefix="fab" data-icon="youtube" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" class="svg-inline--fa fa-youtube fa-w-18 fa-2x"><path fill="#f5413d" d="M549.655 124.083c-6.281-23.65-24.787-42.276-48.284-48.597C458.781 64 288 64 288 64S117.22 64 74.629 75.486c-23.497 6.322-42.003 24.947-48.284 48.597-11.412 42.867-11.412 132.305-11.412 132.305s0 89.438 11.412 132.305c6.281 23.65 24.787 41.5 48.284 47.821C117.22 448 288 448 288 448s170.78 0 213.371-11.486c23.497-6.321 42.003-24.171 48.284-47.821 11.412-42.867 11.412-132.305 11.412-132.305s0-89.438-11.412-132.305zm-317.51 213.508V175.185l142.739 81.205-142.739 81.201z" class=""></path></svg></span>
        </div>

        <h1>Combine all your social media channels into one single wall.</h1>
        <h2>Maximize your social content and get more followers.</h2>

        <div style="text-align: center;">
            <a href="https://smashballoon.com/social-wall/?utm_source=plugin-pro&utm_campaign=cff&utm_medium=sw-cta-1" target="_blank" class="cta button button-primary">Get the Social Wall plugin</a>
        </div>

        <div class="cff-sw-info">
            <div class="cff-sw-features">
                <p><span>A dash of Instagram</span>Add posts from your profile, public hashtag posts, or posts you're tagged in.</p>
                <p><span>A sprinkle of Facebook</span>Include posts from your page or group timeline, or from your photos, videos, albums, and events pages.</p>
                <p><span>A spoonful of Twitter</span>Add Tweets from any Twitter account, hashtag Tweets, mentions, and more.</p>
                <p><span>And a dollop of YouTube</span>Embed videos from any public YouTube channel, playlists, searches, and more.</p>
                <p><span>All in the same feed</span>Combine feeds from all of our Smash Balloon Pro plugins into one single wall feed, and show off all your social media content in one place.</p>
            </div>
            <a class="cff-sw-screenshot" href="https://smashballoon.com/social-wall/demo?utm_source=plugin-pro&utm_campaign=cff&utm_medium=sw-demo" target="_blank">
                <span class="cta">View Demo</span>

                <img src="<?php echo CFF_PLUGIN_URL .  'admin/assets/img/sw-screenshot.png'; ?>" alt="Smash Balloon Social Wall plugin screenshot showing Facebook, Instagram, Twitter, and YouTube posts combined into one wall.">
            </a>
        </div>

        <div class="cff-sw-footer-cta">
            <a href="https://smashballoon.com/social-wall/?utm_source=plugin-pro&utm_campaign=cff&utm_medium=sw-cta-2" target="_blank"><span>🚀</span>Get Social Wall and Increase Engagement >></a>
        </div>

    </div>

    <?php
}



function cff_lite_dismiss() {
	$nonce = isset( $_POST['cff_nonce'] ) ? sanitize_text_field( $_POST['cff_nonce'] ) : '';

	if ( ! wp_verify_nonce( $nonce, 'cff_nonce' ) ) {
		die ( 'You did not do this the right way!' );
	}

	set_transient( 'facebook_feed_dismiss_lite', 'dismiss', 1 * WEEK_IN_SECONDS );

	die();
}
add_action( 'wp_ajax_cff_lite_dismiss', 'cff_lite_dismiss' );

function cff_reset_log() {
	\cff_main()->cff_error_reporter->add_action_log( 'View feed and retry button clicked.' );
	cff_delete_cache();
	die();
}
add_action( 'wp_ajax_cff_reset_log', 'cff_reset_log' );


/* Display a notice regarding PPCA changes, which can be dismissed */
add_action('admin_notices', 'cff_ppca_notice');
function cff_ppca_notice() {

    global $current_user;
    $user_id = $current_user->ID;

    $cap = current_user_can( 'manage_custom_facebook_feed_options' ) ? 'manage_custom_facebook_feed_options' : 'manage_options';
    $cap = apply_filters( 'cff_settings_pages_capability', $cap );
    if( !current_user_can( $cap ) ) return;

    // Use this to show notice again
    // delete_user_meta($user_id, 'cff_ignore_ppca_notice');

    /* Check whether it's an app token or if the user hasn't already clicked to ignore the message */
    if( get_user_meta($user_id, 'cff_ignore_ppca_notice') ) return;

    $page_id = get_option( 'cff_page_id' );
    $cff_access_token = get_option( 'cff_access_token' );

    if( $page_id && $cff_access_token ){

        //Make a call to the API to see whether the ID and token are for the same Facebook page.
        $cff_ppca_check_url = 'https://graph.facebook.com/v8.0/'.$page_id.'/posts?limit=1&access_token='.$cff_access_token;

        //Store the response in a transient which is deleted and then reset if the settings are saved.
        if ( ! get_transient( 'cff_ppca_admin_check' ) ) {
            //Get the contents of the API response
            $cff_ppca_admin_check_response = CFF_Utils::cff_fetchUrl($cff_ppca_check_url);
            set_transient( 'cff_ppca_admin_check', $cff_ppca_admin_check_response, YEAR_IN_SECONDS );

            $cff_ppca_admin_check_json = json_decode($cff_ppca_admin_check_response);
        } else {
            $cff_ppca_admin_check_response = get_transient( 'cff_ppca_admin_check' );
            //If we can't find the transient then fall back to just getting the json from the api
            if ($cff_ppca_admin_check_response == false) $cff_ppca_admin_check_response = CFF_Utils::cff_fetchUrl($cff_ppca_check_url);

            $cff_ppca_admin_check_json = json_decode($cff_ppca_admin_check_response);
        }

        //If there's a PPCA error or it's a multifeed then display notice
        if( ( isset($cff_ppca_admin_check_json->error->message) && strpos($cff_ppca_admin_check_json->error->message, 'Public Content Access') ) || strpos( $page_id, ',') != false ){
            _e("
            <div class='cff-admin-top-notice'>
                <a class='cff-admin-notice-close' href='" .esc_url( add_query_arg( 'cff_nag_ppca_ignore', '0' ) ). "'>Don't show again<i class='fa fa-close' style='margin-left: 5px;'></i></a>
                <p style='min-height: 22px;'><img src='" .  CFF_PLUGIN_URL . 'admin/assets/img/fb-icon.png' . "' style='float: left; width: 22px; height: 22px; margin-right: 12px; border-radius: 5px; box-shadow: 0 0 1px 0 #BA7B7B;'>
                <b>Action required: PPCA Error.</b> <span style='margin-right: 10px;'>Due to Facebook API changes it is no longer possible to display feeds from Facebook Pages you are not an admin of. Please <a href='https://smashballoon.com/facebook-ppca-error-notice/' target='_blank'>see here</a> for more information.</span><a href='admin.php?page=cff-top' class='cff-admin-notice-button'>Go to Facebook Feed Settings</a></p>
            </div>
            ");
        }
    }

}
//If PPCA notice is dismissed then don't show again
add_action('admin_init', 'cff_nag_ppca_ignore');
function cff_nag_ppca_ignore() {
    global $current_user;
        $user_id = $current_user->ID;
        if ( isset($_GET['cff_nag_ppca_ignore']) && '0' == $_GET['cff_nag_ppca_ignore'] ) {
             add_user_meta($user_id, 'cff_ignore_ppca_notice', 'true', true);
    }
}


// Add a Settings link to the plugin on the Plugins page
$cff_plugin_file = 'custom-facebook-feed/custom-facebook-feed.php';
add_filter( "plugin_action_links_{$cff_plugin_file}", 'cff_add_settings_link', 10, 2 );

//modify the link by unshifting the array
function cff_add_settings_link( $links, $file ) {
	$pro_link = '<a href="https://smashballoondemo.com/?utm_campaign=facebook-free&utm_source=plugins-page&utm_medium=upgrade-link" target="_blank" style="font-weight: bold; color: #1da867;">' . __( 'Try the Pro Demo', 'custom-facebook-feed' ) . '</a>';
    $cff_settings_link = '<a href="' . admin_url( 'admin.php?page=cff-feed-builder' ) . '">' . __( 'Settings', 'cff-feed-builder', 'custom-facebook-feed' ) . '</a>';
    array_unshift( $links, $pro_link, $cff_settings_link );

    return $links;
}


//Delete cache
function cff_delete_cache(){
    global $wpdb;
    $table_name = $wpdb->prefix . "options";
    $wpdb->query( "
        DELETE
        FROM $table_name
        WHERE `option_name` LIKE ('%\_transient\_cff\_%')
        " );
    $wpdb->query( "
        DELETE
        FROM $table_name
        WHERE `option_name` LIKE ('%\_transient\_cff\_tle\_%')
        " );
    $wpdb->query( "
        DELETE
        FROM $table_name
        WHERE `option_name` LIKE ('%\_transient\_timeout\_cff\_%')
        " );

    //Clear cache of major caching plugins
    if(isset($GLOBALS['wp_fastest_cache']) && method_exists($GLOBALS['wp_fastest_cache'], 'deleteCache')){
        $GLOBALS['wp_fastest_cache']->deleteCache();
    }
    //WP Super Cache
    if (function_exists('wp_cache_clear_cache')) {
        wp_cache_clear_cache();
    }
    //W3 Total Cache
    if (function_exists('w3tc_flush_all')) {
        w3tc_flush_all();
    }
    if (function_exists('sg_cachepress_purge_cache')) {
        sg_cachepress_purge_cache();
    }

    // Litespeed Cache
    if ( method_exists( 'LiteSpeed_Cache_API', 'purge' ) ) {
        LiteSpeed_Cache_API::purge( 'esi.custom-facebook-feed' );
    }

}

//Cron job to clear transients
add_action('cff_cron_job', 'cff_cron_clear_cache');
function cff_cron_clear_cache() {
    //Delete all transients
    cff_delete_cache();
}

//NOTICES
function cff_get_current_time() {
    $current_time = time();

    // where to do tests
    // $current_time = strtotime( 'November 25, 2020' );

    return $current_time;
}

// generates the html for the admin notices
function cff_notices_html() {
    // reset everything for testing
    /*
    global $current_user;
    $user_id = $current_user->ID;
    // delete_user_meta( $user_id, 'cff_ignore_bfcm_sale_notice' );
    // delete_user_meta( $user_id, 'cff_ignore_new_user_sale_notice' );
    // $cff_statuses_option = array( 'first_install' => strtotime( 'December 8, 2017' ) );
    // $cff_statuses_option = array( 'first_install' => time() );

    // update_option( 'cff_statuses', $cff_statuses_option, false );
    // delete_option( 'cff_rating_notice');
    // delete_transient( 'custom_facebook_rating_notice_waiting' );

    // set_transient( 'custom_facebook_rating_notice_waiting', 'waiting', 2 * WEEK_IN_SECONDS );
    delete_transient('custom_facebook_rating_notice_waiting');
    update_option( 'cff_rating_notice', 'pending', false );
    */
}

function cff_get_future_date( $month, $year, $week, $day, $direction ) {
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

function cff_admin_hide_unrelated_notices() {

	// Bail if we're not on a cff screen or page.
	if ( ! isset( $_GET['page'] ) || strpos( $_GET['page'], 'cff') === false ) {
		return;
	}

	// Extra banned classes and callbacks from third-party plugins.
	$blacklist = array(
		'classes'   => array(),
		'callbacks' => array(
			'cffdb_admin_notice', // 'Database for cff' plugin.
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
					strpos( $class, 'cff' ) !== false &&
					! in_array( $class, $blacklist['classes'], true )
				) {
					continue;
				}
				if (
					! empty( $name ) && (
						strpos( $name, 'cff' ) === false ||
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
add_action( 'admin_print_scripts', 'cff_admin_hide_unrelated_notices' );

function cff_free_add_caps() {
	global $wp_roles;

	$wp_roles->add_cap( 'administrator', 'manage_custom_facebook_feed_options' );

}
add_action( 'admin_init', 'cff_free_add_caps', 90 );

//PPCA token checks
function cff_ppca_token_check_flag() {
    if( get_transient('cff_ppca_access_token_invalid') ){
        print_r(true);
    } else {
        print_r(false);
    }

    die();
}
add_action( 'wp_ajax_cff_ppca_token_check_flag', 'cff_ppca_token_check_flag' );

//Set the PPCA token transient. Is cleared when settings are saved.
function cff_ppca_token_set_flag() {
    set_transient('cff_ppca_access_token_invalid', true);
    die();
}
add_action( 'wp_ajax_cff_ppca_token_set_flag', 'cff_ppca_token_set_flag' );

function cff_oembed_disable() {
	$nonce = isset( $_POST['cff_nonce'] ) ? sanitize_text_field( $_POST['cff_nonce'] ) : '';

	if ( ! wp_verify_nonce( $nonce, 'cff_nonce' ) ) {
		die ( 'You did not do this the right way!' );
	}

	$oembed_settings = get_option( 'cff_oembed_token', array() );
	$oembed_settings['access_token'] = '';
	$oembed_settings['disabled'] = true;
	echo '<strong>';
	if ( update_option( 'cff_oembed_token', $oembed_settings ) ) {
		_e( 'Facebook oEmbeds will no longer be handled by Custom Facebook Feed.', 'custom-facebook-feed' );
	} else {
		_e( 'An error occurred when trying to disable your oEmbed token.', 'custom-facebook-feed' );
	}
	echo '</strong>';

	die();
}
add_action( 'wp_ajax_cff_oembed_disable', 'cff_oembed_disable' );

function cff_clear_error_log() {

	\cff_main()->cff_error_reporter->remove_all_errors();

    cff_delete_cache();

    echo "1";

	die();
}
add_action( 'wp_ajax_cff_clear_error_log', 'cff_clear_error_log' );