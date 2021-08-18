<?php
/**
 * Custom Facebook Feed Main Shortcode Class
 *
 * @since 2.19
 */

namespace CustomFacebookFeed;

use CustomFacebookFeed\Builder\CFF_Source;

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

class CFF_Shortcode extends CFF_Shortcode_Display{

	/**
	 * @var Class
	 */
	protected $fb_feed_settings;

	/**
	 * @var array
	 */
	protected $atts;

	/**
	 * @var array
	 */
	protected $options;

	/**
	 * @var id
	 */
	protected $page_id;

	/**
	 * @var string
	 */
	protected $access_token;

	/**
	 * @var string
	 */
	protected $feed_id;


	/**
	 * Shortcode constructor
	 *
	 * @since 2.19
	 */
	public function __construct(){
		$this->init();
	}



	/**
	 * Init.
	 *
	 * @since 2.19
	 */
	public function init(){
		add_shortcode('custom-facebook-feed', array($this, 'display_cff'));
	}


	/**
	 * Get JSON data
	 *
	 * Returns a list of posts JSON form the FaceBook API API
	 *
	 * @since 2.19
	 * @return JSON OBJECT
	 */
	public function get_feed_json( $graph_query, $cff_post_limit, $cff_locale, $cff_show_access_token, $cache_seconds, $cff_cache_time, $show_posts_by, $data_att_html ){
		//Is it SSL?
		$cff_ssl = is_ssl() ? '&return_ssl_resources=true' : '';
		$attachments_desc = ( $this->atts['salesposts'] == 'true' ) ? '' : ',description';
        $story_tags = ( $this->atts['storytags'] == 'true' ) ? '' : ',story_tags';

		$cff_posts_json_url = 'https://graph.facebook.com/v4.0/' . $this->page_id . '/' . $graph_query . '?fields=id,updated_time,from{picture,id,name,link},message,message_tags,story'. $story_tags .',status_type,created_time,backdated_time,call_to_action,attachments{title'. $attachments_desc . ',media_type,unshimmed_url,target{id},media{source}}&access_token=' . $this->access_token . '&limit=' . $cff_post_limit . '&locale=' . $cff_locale . $cff_ssl;
		//Create the transient name
		//Split the Page ID in half and stick it together so we definitely have the beginning and end of it
		$trans_page_id = substr($this->page_id, 0, 16) . substr($this->page_id, -15);
		$transient_name = 'cff_' . substr($graph_query, 0, 1) . '_' . $trans_page_id . substr($cff_post_limit, 0, 3) . substr($show_posts_by, 0, 2) . substr($cff_locale, 0, 2);
		//Limit to 45 chars max
		$transient_name = substr($transient_name, 0, 45);

		$posts_json = CFF_Utils::cff_get_set_cache( $cff_posts_json_url, $transient_name, $cff_cache_time, $cache_seconds, $data_att_html, false, $this->access_token, true );

		return json_decode($posts_json);
	}


	/**
	 * Get Graph Query & (Show only by others)
	 *
	 * Getting the FaceBook Graph Query depending on the settings
	 *
	 * @since 2.19
	 * @return array
	 */
	public function get_graph_query($show_posts_by, $cff_is_group){
		//Use posts? or feed?
		$old_others_option 		= get_option('cff_show_others'); //Use this to help depreciate the old option
		$show_others 			= $this->atts['others'];
		$graph_query 			= 'posts';
		$cff_show_only_others 	= false;
	    //If 'others' shortcode option is used then it overrides any other option
		if ($show_others || $old_others_option == 'on') {
	        //Show posts by everyone
			if ( $old_others_option == 'on' || $show_others == 'on' || $show_others == 'true' || $show_others == true || $cff_is_group ) $graph_query = 'feed';
	        //Only show posts by me
			if ( $show_others == 'false' ) $graph_query = 'posts';
		} else {
		    //Else use the settings page option or the 'showpostsby' shortcode option
	        //Only show posts by me
			if ( $show_posts_by == 'me' ) $graph_query = 'posts';
	        //Show posts by everyone
			if ( $show_posts_by == 'others' || $cff_is_group ) $graph_query = 'feed';
	        //Show posts ONLY by others
			if ( $show_posts_by == 'onlyothers' && !$cff_is_group ) {
				$graph_query = 'visitor_posts';
				$cff_show_only_others = true;
			}
		}

		return [
			'graph_query' 			=> $graph_query,
			'cff_show_only_others'  => $cff_show_only_others
		];

	}


	/**
	 * Get Posts Limit
	 *
	 * Getting the FaceBook Graph Query depending on the settings
	 *
	 * @since 2.19
	 * @return int
	 */
	public function get_post_limit($show_posts){
		$cff_post_limit = $this->atts['limit'];
		if ( isset($cff_post_limit) && $cff_post_limit !== '' ) {
			$cff_post_limit = $cff_post_limit;
		} else {
			if( intval($show_posts) >= 50 ) $cff_post_limit = intval(intval($show_posts) + 7);
			if( intval($show_posts) < 50 ) $cff_post_limit = intval(intval($show_posts) + 5);
			if( intval($show_posts) < 25  ) $cff_post_limit = intval(intval($show_posts) + 4);
			if( intval($show_posts) < 10  ) $cff_post_limit = intval(intval($show_posts) + 3);
			if( intval($show_posts) < 6  ) $cff_post_limit = intval(intval($show_posts) + 2);
			if( intval($show_posts) < 2  ) $cff_post_limit = intval(intval($show_posts) + 1);
		}
		if( $cff_post_limit >= 100 ) $cff_post_limit = 100;
		return $cff_post_limit;
	}


	function cff_get_shortcode_data_attribute_html( $feed_options ) {

	    //If an access token is set in the shortcode then set "use own access token" to be enabled
	    if( isset($feed_options['accesstoken']) ){
	        //Add an encryption string to protect token
	        if ( strpos($feed_options['accesstoken'], ',') !== false ) {
	            //If there are multiple tokens then just add the string after the colon to avoid having to de/reconstruct the array
	            $feed_options['accesstoken'] = str_replace(":", ":02Sb981f26534g75h091287a46p5l63", $feed_options['accesstoken']);
	        } else {
	            //Add an encryption string to protect token
	            $feed_options['accesstoken'] = substr_replace($feed_options['accesstoken'], '02Sb981f26534g75h091287a46p5l63', 25, 0);
	        }
	        $feed_options['ownaccesstoken'] = 'on';
	    }

	    if( !empty($feed_options) ){
	        $json_data = '{';
	        $i = 0;
	        $len = count($feed_options);
	        foreach( $feed_options as $key => $value ) {
	            if ($i == $len - 1) {
	                $json_data .= '&quot;'.$key.'&quot;: &quot;'.$value.'&quot;';
	            } else {
	                $json_data .= '&quot;'.$key.'&quot;: &quot;'.$value.'&quot;, ';
	            }
	            $i++;
	        }
	        $json_data .= '}';

	        return $json_data;
	    }

	}

	function cff_get_processed_options($feed_options){
		$feed_id = empty( $feed_options['feed'] ) ? 'default' : intval( $feed_options['feed'] );
		$feed_options = $this->get_settings_for_feed( $feed_options );

		if ( empty( $feed_options ) ) {
			$options 		= get_option('cff_style_settings');
			$fdo 			= new CFF_FB_Settings($feed_options, $options);
			$feed_options 	= $fdo->get_settings();
			$feed_options['feederror'] = $feed_id;
			return $feed_options;
		}

		$page_id = $feed_options['id'];
		$cff_facebook_string = 'facebook.com';
		( stripos($page_id, $cff_facebook_string) !== false) ? $cff_page_id_url_check = true : $cff_page_id_url_check = false;
		if ( $cff_page_id_url_check === true ) {
	        //Remove trailing slash if exists
			$page_id = preg_replace('{/$}', '', $page_id);
	        //Get last part of url
			$page_id = substr( $page_id, strrpos( $page_id, '/' )+1 );
		}
	    //If the Page ID contains a query string at the end then remove it
		if ( stripos( $page_id, '?') !== false ) $page_id = substr($page_id, 0, strrpos($page_id, '?'));

	    //Always remove slash from end of Page ID
		$page_id = preg_replace('{/$}', '', $page_id);

	    //Update the page ID in the feed options array for use everywhere
		$feed_options['id'] = $page_id;


	    //If an 'account' is specified then use that instead of the Page ID/token from the settings
		$cff_account = trim($feed_options['account']);

		if( !empty( $cff_account ) ){
			$cff_connected_accounts = get_option('cff_connected_accounts');
			if( !empty($cff_connected_accounts) ){

	            //Replace both single and double quotes before decoding
				$cff_connected_accounts = str_replace('\"','"', $cff_connected_accounts);
				$cff_connected_accounts = str_replace("\'","'", $cff_connected_accounts);

				$cff_connected_accounts = json_decode( $cff_connected_accounts );

				if ( isset( $cff_account ) && is_object( $cff_connected_accounts ) ) {
		            //Grab the ID and token from the connected accounts setting
					if( isset( $cff_connected_accounts->{ $cff_account } ) ){
						$feed_options['id'] = $cff_connected_accounts->{ $cff_account }->{'id'};
						$feed_options['accesstoken'] = $cff_connected_accounts->{ $cff_account }->{'accesstoken'};
					}

				}

	            //Replace the encryption string in the Access Token
				if (strpos($feed_options['accesstoken'], '02Sb981f26534g75h091287a46p5l63') !== false) {
					$feed_options['accesstoken'] = str_replace("02Sb981f26534g75h091287a46p5l63","",$feed_options['accesstoken']);
				}
			}
		}

	    //Replace the encryption string in the Access Token
		if (strpos($feed_options['accesstoken'], '02Sb981f26534g75h091287a46p5l63') !== false) {
			$feed_options['accesstoken'] = str_replace("02Sb981f26534g75h091287a46p5l63","",$feed_options['accesstoken']);
		}
		$cff_connected_accounts = get_option('cff_connected_accounts');
		if(!empty($cff_connected_accounts)){
			$connected_accounts = (array)json_decode(stripcslashes($cff_connected_accounts));
			if(array_key_exists($feed_options['id'], $connected_accounts)){
				$feed_options['pagetype'] = $connected_accounts[$feed_options['id']]->pagetype;
			}
		}

		if ( ! empty( $feed_options['feedlayout'] ) ) {
			if ( $feed_options['feedlayout'] === 'list' ) {
				$feed_options['cols'] = 1;
				$feed_options['colsmobile'] = 1;
				$feed_options['colstablet'] = 1;
				$feed_options['masonrycols'] = 1;
				$feed_options['masonrycolsmobile'] = 1;
			} elseif ( $feed_options['feedlayout'] === 'masonry' ) {
				$feed_options['masonrycols'] = $feed_options['cols'] ;
				$feed_options['masonrycolsmobile'] = $feed_options['colsmobile'];
			}
		}

		return $feed_options;
	}

	/**
	 * Display.
	 * The main Shortcode display
	 *
	 * @since 2.19
	 */
	public function display_cff($atts) {
		$this->options 			= get_option('cff_style_settings');
		$data_att_html 			= $this->cff_get_shortcode_data_attribute_html( $atts );
		$feed_id = empty( $atts['feed'] ) ? 'default' : intval( $atts['feed'] );
		$feed_options = $this->get_settings_for_feed( $atts );

		if ( empty( $feed_options ) ) {
			$this->fb_feed_settings = new CFF_FB_Settings($atts, $this->options);
			$this->atts 			= $this->fb_feed_settings->get_settings();
			$id_and_token 			= $this->fb_feed_settings->get_id_and_token();
			$this->page_id 			= $id_and_token['id'];
			$this->access_token 	= $id_and_token['token'];
			$this->atts 			= $this->cff_get_processed_options( $this->atts  );

		} else {
			if ( ! empty( $feed_options['feedlayout'] ) ) {
				if ( $feed_options['feedlayout'] === 'list' ) {
					$feed_options['cols'] = 1;
					$feed_options['colsmobile'] = 1;
					$feed_options['colstablet'] = 1;
					$feed_options['masonrycols'] = 1;
					$feed_options['masonrycolsmobile'] = 1;
				} elseif ( $feed_options['feedlayout'] === 'masonry' ) {
					$feed_options['masonrycols'] = $feed_options['cols'] ;
					$feed_options['masonrycolsmobile'] = $feed_options['colsmobile'];
				}
			}


			$this->atts  = $feed_options;
		}

		$this->cff_add_translations();
		#var_dump($this->atts);

		//Vars for the templates
		$atts 			= $this->atts;
		$options 		= $this->options;
		$access_token 	= $this->access_token;
		$page_id 		= $this->page_id;

        if ( $atts['cff_enqueue_with_shortcode'] === 'on' || $atts['cff_enqueue_with_shortcode'] === 'true' ) {
            wp_enqueue_style( 'cff' );
            wp_enqueue_script( 'cffscripts' );
        }

		$palette = '';
		$custom_palette_class = '';
		$doing_custom_styles = false;

		if ( ! empty( $this->atts['colorpalette'] ) ) {
			switch ( $this->atts['colorpalette'] ) {
				case 'dark' :
					$palette = 'cff-dark ';
					break;
				case 'light' :
					$palette = 'cff-light ';
					break;
				case 'custom' :
					$doing_custom_styles = true;
					$custom_palette_class = 'cff-palette-' . $feed_id . ' ';
					break;
				default:
					$palette = '';
			}
		}

		$this->atts['paletteclass'] = $palette . $custom_palette_class;

		/********** GENERAL **********/
		$cff_page_type = $this->atts[ 'pagetype' ];
		($cff_page_type == 'group') ? $cff_is_group = true : $cff_is_group = false;


		$cff_show_author = $this->atts[ 'showauthornew' ];
		$cff_cache_time = $this->atts[ 'cachetime' ];
		$cff_locale = $this->atts[ 'locale' ];
		if( empty($cff_locale) || !isset($cff_locale) || $cff_locale == '' ) $cff_locale = 'en_US';
		if(!isset($cff_cache_time) || $cff_cache_time == '' ) $cff_cache_time = 0;
		$cff_cache_time_unit = $this->atts[ 'cacheunit' ];

		$like_box = CFF_Utils::print_template_part( 'likebox', get_defined_vars());


		if($cff_cache_time == 'nocaching') $cff_cache_time = 0;

	   //Like box
		$cff_like_box_position = $this->atts[ 'likeboxpos' ];
		$cff_like_box_outside = CFF_Utils::check_if_on($this->atts[ 'likeboxoutside' ]);
	    //Open links in new window?
		$target = 'target="_blank"';
		/********** LAYOUT **********/
		$cff_show_author			= $this->check_show_section( 'author' );
		$cff_show_text				= $this->check_show_section( 'text' );
		$cff_show_desc				= $this->check_show_section( 'desc' );
		$cff_show_shared_links		= $this->check_show_section( 'sharedlink' );
		$cff_show_date				= $this->check_show_section( 'date' );
		$cff_show_media				= $this->check_show_section( 'media' );
		$cff_show_media_link		= $this->check_show_section( 'medialink' );
		$cff_show_event_title		= $this->check_show_section( 'eventtitle' );
		$cff_show_event_details		= $this->check_show_section( 'eventdetail' );
		$cff_show_meta				= $this->check_show_section( 'social' );
		$cff_show_link				= $this->check_show_section( ',link' );
		$cff_show_like_box			= isset( $this->atts['showlikebox'] ) ? CFF_Utils::check_if_on( $this->atts['showlikebox'] ) : false;

	    //Set free version to thumb layout by default as layout option not available on settings page
		$cff_preset_layout = 'thumb';

	    //If the old shortcode option 'showauthor' is being used then apply it
		$cff_show_author_old = $this->atts[ 'showauthor' ];
		if( $cff_show_author_old == 'false' ) $cff_show_author = false;
		if( $cff_show_author_old == 'true' ) $cff_show_author = true;

	    //See Less text
		$cff_posttext_link_color = str_replace('#', '', $this->atts['textlinkcolor']);
		$cff_title_link = CFF_Utils::check_if_on( $this->atts['textlink'] );

	    //Description Style
		$cff_body_styles = $this->get_style_attribute( 'body_description' );

	    //Shared link box
		$cff_disable_link_box = CFF_Utils::check_if_on( $this->atts['disablelinkbox'] );

		$cff_link_box_styles = $cff_disable_link_box ? '' : $this->get_style_attribute( 'link_box' );

	    //Date
		$cff_date_position = ( !isset( $this->atts[ 'datepos' ] ) ) ? 'below' : $this->atts[ 'datepos' ];


	    //Show Facebook link
		$cff_link_to_timeline = $this->atts[ 'linktotimeline' ];

	    //Post Style settings
		$cff_post_style 			= $this->atts['poststyle'];
		$cff_post_bg_color_check 	= ($this->atts['postbgcolor'] !== '' && $this->atts['postbgcolor'] !== '#' && $cff_post_style != 'regular' ) ? true : false;
		$cff_box_shadow				= CFF_Utils::check_if_on( $this->atts['boxshadow'] ) && $cff_post_style == 'boxed';

	    //Text limits
		$body_limit = $this->atts['desclength'];

	    //Get show posts attribute. If not set then default to 25
		$show_posts = ( empty( $this->atts['num'] ) || $this->atts['num'] == 'undefined' ) ? 25 : $this->atts['num'];
	    $show_posts_number = isset( $this->atts['minnum'] ) ? $this->atts['minnum'] : $this->atts['num'];

	    //If the 'Enter my own Access Token' box is unchecked then don't use the user's access token, even if there's one in the field
		get_option('cff_show_access_token') ? $cff_show_access_token = true : $cff_show_access_token = false;

	    //Check whether a Page ID has been defined
		if ($this->page_id == '') {
			if ( $this->using_legacy_feed( $feed_options ) ) {
				echo "Please enter the Page ID of the Facebook feed you'd like to display. You can do this in either the Custom Facebook Feed plugin settings or in the shortcode itself. For example, [custom-facebook-feed id=YOUR_PAGE_ID_HERE].<br /><br />";
			}
			return false;
		}

	    //Is it a restricted page?
		$cff_restricted_page 	= CFF_Utils::check_if_on( $this->atts['restrictedpage'] );

		$show_posts_by 			= $this->atts['showpostsby'];
		$graph_info 			= $this->get_graph_query($show_posts_by, $cff_is_group);
		$graph_query 			= $graph_info['graph_query'];
		$cff_show_only_others 	= $graph_info['cff_show_only_others'];




		// If Mobile and Desktop post nums are not the same, use minnum for API requests.
		$mobile_num = isset( $this->atts['nummobile'] ) && (int)$this->atts['nummobile'] > 0 ? (int)$this->atts['nummobile'] : 0;
		$desk_num = $show_posts;
		if ( $desk_num < $mobile_num ) {
			$this->atts['minnum'] = $mobile_num;
		}

		$show_posts = isset( $this->atts['minnum'] ) ? $this->atts['minnum'] : $show_posts;
		$cff_post_limit = $this->get_post_limit($show_posts);

	    //If the number of posts is set to zero then don't show any and set limit to one
		if ( ($show_posts == '0' || $show_posts == 0) && $show_posts !== ''){
			$show_posts = 0;
			$cff_post_limit = 1;
		}


	    //Calculate the cache time in seconds
		if($cff_cache_time_unit == 'minutes') $cff_cache_time_unit = 60;
		if($cff_cache_time_unit == 'hours') $cff_cache_time_unit = 60*60;
		if($cff_cache_time_unit == 'days') $cff_cache_time_unit = 60*60*24;
		$cache_seconds = $cff_cache_time * $cff_cache_time_unit;





	    //Misc Settings
		$cff_nofollow = CFF_Utils::check_if_on( $this->atts['nofollow'] );
		( $cff_nofollow ) ? $cff_nofollow = ' rel="nofollow noopener"' : $cff_nofollow = '';
		$cff_nofollow_referrer = ' rel="nofollow noopener noreferrer"';

	    //If the number of posts is set to zero then don't show any and set limit to one
		if ( ($this->atts['num'] == '0' || $this->atts['num'] == 0) && $this->atts['num'] !== ''){
			$show_posts = 0;
			$cff_post_limit = 1;
		}

		//***START FEED***
		#$defined_vars = get_defined_vars();
		$cff_content = '';

	    //Create CFF container HTML
		$cff_content .= '<div class="cff-wrapper">';
		$cff_style_class = $this->feed_style_class_compiler();
		$cff_insider_style = $this->get_style_attribute( 'feed_wrapper_insider' );
		$cff_feed_height = CFF_Utils::get_css_distance( $this->atts[ 'height' ] ) ;
		//Feed header
		$cff_show_header 		= CFF_Utils::check_if_on( $this->atts['showheader'] );
		$cff_header_outside 	= CFF_Utils::check_if_on( $this->atts['headeroutside'] );
		$cff_header_type 		= strtolower( $this->atts['headertype'] );
		$cff_header 			= CFF_Utils::print_template_part( 'header', get_defined_vars(), $this);

	    //Add the page header to the outside of the top of feed
		if ($cff_show_header && $cff_header_outside) $cff_content .= $cff_header;

	    //Add like box to the outside of the top of feed
		if ($cff_like_box_position == 'top' && $cff_show_like_box && $cff_like_box_outside) $cff_content .= $like_box;


		//Get Custom Class and Compiled CSS

	    $custom_wrp_class = !empty($cff_feed_height) ? ' cff-wrapper-fixed-height' : '';

		$cff_content .= '<div class="cff-wrapper-ctn '.$custom_wrp_class.'" '.$cff_insider_style.'>';
		$cff_content .= '<div id="cff" ' . $cff_style_class['cff_custom_class'] . ' ' . $cff_style_class['cff_feed_styles'] . ' ' . $cff_style_class['cff_feed_attributes'] . '>';

	    //Add the page header to the inside of the top of feed
		if ($cff_show_header && !$cff_header_outside) $cff_content .= $cff_header;

	    //Add like box to the inside of the top of feed
		if ($cff_like_box_position == 'top' && $cff_show_like_box && !$cff_like_box_outside) $cff_content .= $like_box;
	    //Limit var
		$i_post = 0;

	    //Define array for post items
		$cff_posts_array = array();
	    //ALL POSTS

		$FBdata = $this->get_feed_json( $graph_query, $cff_post_limit, $cff_locale, $cff_show_access_token, $cache_seconds, $cff_cache_time, $show_posts_by, $data_att_html );
		if( $cff_is_group ){
			$cff_ssl = is_ssl() ? '&return_ssl_resources=true' : '';
			$attachments_desc = ( $this->atts['salesposts'] == 'true' ) ? '' : ',description';
			$cff_posts_json_url = 'https://graph.facebook.com/v4.0/' . $this->page_id . '/' . $graph_query . '?fields=id,updated_time,from{picture,id,name,link},message,message_tags,story,story_tags,status_type,created_time,backdated_time,call_to_action,attachments{title'. $attachments_desc . ',media_type,unshimmed_url,target{id},media{source}}&access_token=' . $this->access_token . '&limit=' . $cff_post_limit . '&locale=' . $cff_locale . $cff_ssl;
			$this->atts['type'] = 'links_events_videos_photos_albums_statuses_';
			$groups_post = new CFF_Group_Posts($this->page_id, $this->atts, $cff_posts_json_url, $data_att_html, false);
			$groups_post_result = $groups_post->init_group_posts(json_encode($FBdata), false, $show_posts_number);
			$posts_json = $groups_post_result['posts_json'];
			$FBdata = json_decode($posts_json);
		}


		global $current_user;
		$user_id = $current_user->ID;

	        //Print Pretty Message Error
		$cff_content .= CFF_Utils::print_template_part( 'error-message', get_defined_vars());

		$numeric_page_id = '';
		if( !empty($FBdata->data) ){
			if ( ($cff_show_only_others || $show_posts_by == 'others') && count($FBdata->data) > 0 ) {
	                //Get the numeric ID of the page so can compare it to the author of each post
				$first_post_id = explode("_", $FBdata->data[0]->id);
				$numeric_page_id = $first_post_id[0];
			}
		}

		$posts_wrap_box_shadow_class = $cff_box_shadow && $this->atts['feedlayout'] === 'list' ? ' cff-posts-wrap-box-shadow' : '';
        $cff_content .= '<div class="cff-posts-wrap'.$posts_wrap_box_shadow_class.'">';

	        //***STARTS POSTS LOOP***
		if( isset($FBdata->data) ){
			if ( ! \cff_main()->cff_error_reporter->are_critical_errors()
			     && isset( $this->atts['sources'] )
					&& is_array( $this->atts['sources'] ) ) {
				foreach ( $this->atts['sources'] as $source ) {
					if ( ! empty( $source['error'] ) ) {
						\CustomFacebookFeed\Builder\CFF_Source::clear_error( $source['account_id'] );
					}
				}
			}
			foreach ($FBdata->data as $news )
			{
	            //Explode News and Page ID's into 2 values
				$PostID = '';
				$cff_post_id = '';
				if( isset($news->id) ){
					$cff_post_id = $news->id;
					$PostID = explode("_", $cff_post_id);
				}

	                //Reassign variable changes from API v3.3 update
				$news->link 		= isset($news->attachments->data[0]->unshimmed_url) 	? $news->attachments->data[0]->unshimmed_url : '';
				$news->description 	= isset($news->attachments->data[0]->description) 		? $news->attachments->data[0]->description : '';
				$news->object_id 	= isset($news->attachments->data[0]->target->id) 		? $news->attachments->data[0]->target->id : '';
				$news->source 		= isset($news->attachments->data[0]->media->source) 	? $news->attachments->data[0]->media->source : '';
				$news->name 		= isset($news->attachments->data[0]->title) 			? $news->attachments->data[0]->title : '';
				$news->caption 		= isset($news->attachments->data[0]->title) 			? $news->attachments->data[0]->title : '';

	            //Check the post type
				$cff_post_type 		= isset($news->attachments->data[0]->media_type) ? $news->attachments->data[0]->media_type : 'status';

				if ($cff_post_type == 'link') {
					isset($news->story) ? $story = $news->story : $story = '';
	                //Check whether it's an event
					$event_link_check = "facebook.com/events/";
					if( isset($news->link) ){
						$event_link_check = CFF_Utils::stripos($news->link, $event_link_check);
						if ( $event_link_check ) $cff_post_type = 'event';
					}
				}
				$cff_show_links_type = true;
			    $cff_show_event_type = true;
			    $cff_show_video_type = true;
			    $cff_show_photos_type = true;
			    $cff_show_status_type = true;
			    $cff_show_albums_type = true;
			    $cff_events_only = false;
			    //Are we showing ONLY events?
			    if ($cff_show_event_type && !$cff_show_links_type && !$cff_show_video_type && !$cff_show_photos_type && !$cff_show_status_type) $cff_events_only = true;
                //Should we show this post or not?
				$cff_show_post = false;
				switch ($cff_post_type) {
                    case 'link':
                        if ( $cff_show_links_type ) $cff_show_post = true;
                        break;
                    case 'event':
                        if ( $cff_show_event_type ) $cff_show_post = true;
                        break;
                    case 'video':
                         if ( $cff_show_video_type ) $cff_show_post = true;
                        break;
                    case 'swf':
                         if ( $cff_show_video_type ) $cff_show_post = true;
                        break;
                    case 'photo':
                         if ( $cff_show_photos_type ) $cff_show_post = true;
                        break;
                    case 'offer':
                         $cff_show_post = true;
                        break;
                    default:
                        //Check whether it's a status (author comment or like)
                        if ( $cff_show_status_type && !empty($news->message) ) $cff_show_post = true;
                        break;
                }
                //Is it a duplicate post?
				if (!isset($prev_post_message)) $prev_post_message = '';
				if (!isset($prev_post_link)) $prev_post_link = '';
				if (!isset($prev_post_description)) $prev_post_description = '';
				isset($news->message) ? $pm = $news->message : $pm = '';
				isset($news->link) ? $pl = $news->link : $pl = '';
				isset($news->description) ? $pd = $news->description : $pd = '';

				if ( ($prev_post_message == $pm) && ($prev_post_link == $pl) && ($prev_post_description == $pd) ) $cff_show_post = false;

	            //Offset. If the post index ($i_post) is less than the offset then don't show the post
				if( intval($i_post) < intval($this->atts['offset']) ){
					$cff_show_post = false;
					$i_post++;
				}

				//Check post type and display post if selected
				if ( $cff_show_post ) {
	            	//If it isn't then create the post
	                //Only create posts for the amount of posts specified
					if( intval($this->atts['offset']) > 0 ){
						//If offset is being used then stop after showing the number of posts + the offset
						if ( $i_post == (intval($show_posts) + intval($this->atts['offset'])) ) break;
					} else {
	                        //Else just stop after the number of posts to be displayed is reached
						if ( $i_post == $show_posts ) break;
					}
					$i_post++;
	                    //********************************//
	                    //***COMPILE SECTION VARIABLES***//
	                    //********************************//
	                    //Set the post link
					isset($news->link) ? $link = htmlspecialchars($news->link) : $link = '';
	                    //Is it a shared album?
					$shared_album_string = 'shared an album:';
					isset($news->story) ? $story = $news->story : $story = '';
					$shared_album = CFF_Utils::stripos($story, $shared_album_string);
					if ( $shared_album ) {
						$link = str_replace('photo.php?','media/set/?',$link);
					}
	                    //Check the post type
					isset($cff_post_type) ? $cff_post_type = $cff_post_type : $cff_post_type = '';
					if ($cff_post_type == 'link') {
						isset($news->story) ? $story = $news->story : $story = '';
	                        //Check whether it's an event
						$event_link_check = "facebook.com/events/";
	                        //Make sure URL doesn't include 'permalink' as that indicates someone else sharing a post from within an event (eg: https://www.facebook.com/events/617323338414282/permalink/617324268414189/) and the event ID is then not retrieved properly from the event URL as it's formatted like so: facebook.com/events/EVENT_ID/permalink/POST_ID
						$event_link_check = CFF_Utils::stripos($news->link, $event_link_check);
						$event_link_check_2 = CFF_Utils::stripos($news->link, "permalink/");
						if ( $event_link_check && !$event_link_check_2 ) $cff_post_type = 'event';
					}

	                    //If it's an event then check whether the URL contains facebook.com
					if(isset($news->link)){
						if( CFF_Utils::stripos($news->link, "events/") && $cff_post_type == 'event' ){
	                            //Facebook changed the event link from absolute to relative, and so if the link isn't absolute then add facebook.com to front
							( CFF_Utils::stripos($link, 'facebook.com') ) ? $link = $link : $link = 'https://facebook.com' . $link;
						}
					}

	                    //Is it an album?
					$cff_album = false;
					if( isset($news->status_type) ){
						if( $news->status_type == 'added_photos' ){
							if( isset($news->attachments) ){
								if( $news->attachments->data[0]->media_type == 'album' ) $cff_album = true;
							}
						}
					}

	                    //If there's no link provided then link to either the Facebook page or the individual status
					if (empty($news->link)) {
						if ($cff_link_to_timeline == true){
	                            //Link to page
							$link = 'https://facebook.com/' . $this->page_id;
						} else {
	                            //Link to status
							$link = "https://www.facebook.com/" . $this->page_id . "/posts/" . $PostID[1];
						}
					}

					$cff_date = CFF_Utils::print_template_part( 'item/date', get_defined_vars(), $this);




	                //Story/post text vars
					$post_text = '';
					$cff_story_raw = '';
					$cff_message_raw = '';
					$cff_name_raw = '';
					$text_tags = '';
					$post_text_story = '';
					$post_text_message = '';

					//STORY TAGS
					$cff_post_tags = $this->atts[ 'posttags' ];

	                    //Use the story
					if (!empty($news->story)) {
						$cff_story_raw = $news->story;
						$post_text_story .= htmlspecialchars($cff_story_raw);


	                        //Add message and story tags if there are any and the post text is the message or the story
						if( $cff_post_tags && isset($news->story_tags) && !$cff_title_link){

							$text_tags = $news->story_tags;

	                            //Does the Post Text contain any html tags? - the & symbol is the best indicator of this
							$cff_html_check_array = array('&lt;', '’', '“', '&quot;', '&amp;', '&gt;&gt;');

	                            //always use the text replace method
							if( CFF_Utils::cff_stripos_arr($post_text_story, $cff_html_check_array) !== false || ($cff_locale == 'el_GR' && count($news->story_tags) > 3) ) {

	                                //Loop through the tags
								foreach($text_tags as $message_tag ) {

									( isset($message_tag->id) ) ? $message_tag = $message_tag : $message_tag = $message_tag[0];

									$tag_name = $message_tag->name;
									$tag_link = '<a href="https://facebook.com/' . $message_tag->id . '">' . $message_tag->name . '</a>';

									$post_text_story = str_replace($tag_name, $tag_link, $post_text_story);
								}

							} else {

	                                //If it doesn't contain HTMl tags then use the offset to replace message tags
								$message_tags_arr = array();

								$tag = 0;
								foreach($text_tags as $message_tag ) {
									$tag++;
									( isset($message_tag->id) ) ? $message_tag = $message_tag : $message_tag = $message_tag[0];

									isset($message_tag->type) ? $tag_type = $message_tag->type : $tag_type = '';

									$message_tags_arr = CFF_Utils::cff_array_push_assoc(
										$message_tags_arr,
										$tag,
										array(
											'id' => $message_tag->id,
											'name' => $message_tag->name,
											'type' => isset($message_tag->type) ? $message_tag->type : '',
											'offset' => $message_tag->offset,
											'length' => $message_tag->length
										)
									);

								}

	                                //Keep track of the offsets so that if two tags have the same offset then only one is used. Need this as API 2.5 update changed the story_tag JSON format. A duplicate offset usually means '__ was with __ and 3 others'. We don't want to link the '3 others' part.
								$cff_story_tag_offsets = '';
								$cff_story_duplicate_offset = '';

	                                //Check if there are any duplicate offsets. If so, assign to the cff_story_duplicate_offset var.
								for($tag = count($message_tags_arr); $tag >= 1; $tag--) {
									$c = (string)$message_tags_arr[$tag]['offset'];
									if( strpos( $cff_story_tag_offsets, $c ) !== false && $c !== '0' ){
										$cff_story_duplicate_offset = $c;
									} else {
										$cff_story_tag_offsets .= $c . ',';
									}

								}

								for($tag = count($message_tags_arr); $tag >= 1; $tag--) {

	                                    //If the name is blank (aka the story tag doesn't work properly) then don't use it
									if( $message_tags_arr[$tag]['name'] !== '' ) {

	                                        //If it's an event tag or it has the same offset as another tag then don't display it
										if( $message_tags_arr[$tag]['type'] == 'event' || $message_tags_arr[$tag]['offset'] == $cff_story_duplicate_offset || $message_tags_arr[$tag]['type'] == 'page' ){
	                                            //Don't use the story tag in this case otherwise it changes '__ created an event' to '__ created an Name Of Event'
	                                            //Don't use the story tag if it's a page as it causes an issue when sharing a page: Smash Balloon Dev shared a Smash Balloon.
										} else {
											$b = '<a href="https://facebook.com/' . $message_tags_arr[$tag]['id'] . '" target="_blank">' . $message_tags_arr[$tag]['name'] . '</a>';
											$c = $message_tags_arr[$tag]['offset'];
											$d = $message_tags_arr[$tag]['length'];
											$post_text_story = CFF_Utils::cff_mb_substr_replace( $post_text_story, $b, $c, $d);
										}

									}

								}

	                            } // end if/else

	                        } //END STORY TAGS

	                    }

	                    //POST AUTHOR
	                    $cff_author = CFF_Utils::print_template_part( 'item/author', get_defined_vars(), $this);

	                    //Get the actual post text
	                    //Which content should we use?
	                    //Use the message
	                    if (!empty($news->message)) {
	                    	$cff_message_raw = $news->message;

	                    	$post_text_message = htmlspecialchars($cff_message_raw);

	                        //MESSAGE TAGS
	                        //Add message and story tags if there are any and the post text is the message or the story
	                    	if( $cff_post_tags && isset($news->message_tags) && !$cff_title_link){

	                    		$text_tags = $news->message_tags;

	                            //Does the Post Text contain any html tags? - the & symbol is the best indicator of this
	                    		$cff_html_check_array = array('&lt;', '’', '“', '&quot;', '&amp;', '&gt;&gt;', '&gt;');

	                            //always use the text replace method
	                    		if( CFF_Utils::cff_stripos_arr($post_text_message, $cff_html_check_array) !== false ) {
	                                //Loop through the tags
	                    			foreach($text_tags as $message_tag ) {

	                    				( isset($message_tag->id) ) ? $message_tag = $message_tag : $message_tag = $message_tag[0];

	                    				$tag_name = $message_tag->name;
	                    				$tag_link = '<a href="https://facebook.com/' . $message_tag->id . '">' . $message_tag->name . '</a>';

	                    				$post_text_message = str_replace($tag_name, $tag_link, $post_text_message);
	                    			}

	                    		} else {
	                            //If it doesn't contain HTMl tags then use the offset to replace message tags
	                    			$message_tags_arr = array();

	                    			$tag = 0;
	                    			foreach($text_tags as $message_tag ) {
	                    				$tag++;

	                    				( isset($message_tag->id) ) ? $message_tag = $message_tag : $message_tag = $message_tag[0];

	                    				$message_tags_arr = CFF_Utils::cff_array_push_assoc(
	                    					$message_tags_arr,
	                    					$tag,
	                    					array(
	                    						'id' => $message_tag->id,
	                    						'name' => $message_tag->name,
	                    						'type' => isset($message_tag->type) ? $message_tag->type : '',
	                    						'offset' => $message_tag->offset,
	                    						'length' => $message_tag->length
	                    					)
	                    				);
	                    			}

	                                //Keep track of the offsets so that if two tags have the same offset then only one is used. Need this as API 2.5 update changed the story_tag JSON format.
	                    			$cff_msg_tag_offsets = '';
	                    			$cff_msg_duplicate_offset = '';

	                                //Check if there are any duplicate offsets. If so, assign to the cff_duplicate_offset var.
	                    			for($tag = count($message_tags_arr); $tag >= 1; $tag--) {
	                    				$c = (string)$message_tags_arr[$tag]['offset'];
	                    				if( strpos( $cff_msg_tag_offsets, $c ) !== false && $c !== '0' ){
	                    					$cff_msg_duplicate_offset = $c;
	                    				} else {
	                    					$cff_msg_tag_offsets .= $c . ',';
	                    				}
	                    			}

	                                //Sort the array by the "offset" key as Facebook doesn't always return them in the correct order
	                    			usort($message_tags_arr, "CustomFacebookFeed\CFF_Utils::cffSortTags");

	                    			for($tag = count($message_tags_arr)-1; $tag >= 0; $tag--) {

	                                    //If the name is blank (aka the story tag doesn't work properly) then don't use it
	                    				if( $message_tags_arr[$tag]['name'] !== '' ) {

	                    					if( $message_tags_arr[$tag]['offset'] == $cff_msg_duplicate_offset ){
	                                            //If it has the same offset as another tag then don't display it
	                    					} else {
	                    						$b = '<a href="https://facebook.com/' . $message_tags_arr[$tag]['id'] . '">' . $message_tags_arr[$tag]['name'] . '</a>';
	                    						$c = $message_tags_arr[$tag]['offset'];
	                    						$d = $message_tags_arr[$tag]['length'];
	                    						$post_text_message = CFF_Utils::cff_mb_substr_replace( $post_text_message, $b, $c, $d);
	                    					}

	                    				}

	                    			}

	                            } // end if/else

	                        } //END MESSAGE TAGS

	                    }


	                    //Check to see whether it's an embedded video so that we can show the name above the post text if necessary
	                    $cff_soundcloud = false;
	                    $cff_is_video_embed = false;
	                    if ($cff_post_type == 'video' || $cff_post_type == 'music'){
	                    	if( isset($news->source) && !empty($news->source) ){
	                    		$url = $news->source;
	                    	} else if ( isset($news->link) ) {
	                    		$url = $news->link;
	                    	} else {
	                    		$url = '';
	                    	}
	                        //Embeddable video strings
	                    	$vimeo 				= 'vimeo';
	                    	$youtube 			= CFF_Utils::stripos($url, 'youtube');
	                    	$youtu 				= CFF_Utils::stripos($url, 'youtu');
	                    	$youtubeembed 		= CFF_Utils::stripos($url, 'youtube.com/embed');
	                    	$soundcloudembed 	= CFF_Utils::stripos($url, 'soundcloud.com');

	                        //Check whether it's a youtube video
	                    	if($youtube || $youtu || $youtubeembed || (stripos($url, $vimeo) !== false)) {
	                    		$cff_is_video_embed = true;
	                    	}
	                        //If it's soundcloud then add it into the shared link box at the bottom of the post
	                    	if( $soundcloudembed ) $cff_soundcloud = true;
	                    }

	                    //Add the story and message together
	                    $post_text = '';

	                    //DESCRIPTION
	                    $cff_description = '';
	                    if ( !empty($news->description) || !empty($news->caption) ) {
	                    	$description_text = '';

	                    	if ( !empty($news->description) ) {
	                    		$description_text = $news->description;
	                    	}

	                        //Replace ellipsis char in description text
	                    	$raw_desc = $description_text;
	                    	$description_text = str_replace( '…','...', $description_text);

	                        //If the description is the same as the post text then don't show it
	                    	if( $raw_desc ==  $cff_story_raw || $raw_desc ==  $cff_message_raw || $raw_desc ==  $cff_name_raw ){
	                    		$cff_description = '';
	                    	} else {
	                            //Add links and create HTML
	                    		$cff_description .= '<span class="cff-post-desc" '.$cff_body_styles.'>';

	                    		if ($cff_title_link) {
	                    			$cff_description_tagged = CFF_Utils::cff_wrap_span( htmlspecialchars($description_text) );
	                    		} else {
	                    			$cff_description_text = CFF_Autolink::cff_autolink( htmlspecialchars($description_text), $link_color=$cff_posttext_link_color );
	                    			$cff_description_tagged = CFF_Utils::cff_desc_tags($cff_description_text);
	                    		}

	                    		$cff_description .= $cff_description_tagged;
	                    		$cff_description .= ' </span>';
	                    	}

	                    	if( $cff_post_type == 'event' || $cff_is_video_embed || $cff_soundcloud ) $cff_description = '';
	                    }

	                    //Add the message
	                    if($cff_show_text) $post_text .= $post_text_message;

	                    $post_text = apply_filters( 'cff_post_text', $post_text );

		                //If it's a shared video post then add the video name after the post text above the video description so it's all one chunk
	                    if ($cff_post_type == 'video'){
	                    	if( !empty($cff_description) && $cff_description != '' ){
	                    		if( (!empty($post_text) && $post_text != '') && !empty($cff_video_name) ) $post_text .= '<br /><br />';
	                    		$post_text .=  $cff_video_name;
	                    	}
	                    }


	                    //Use the name if there's no other text, unless it's a shared link post as then it's already used as the shared link box title
	                    if ( !empty($news->name) && empty($news->message) && $cff_post_type != 'link' ) {
	                    	$cff_name_raw = $news->name;
	                    	$post_text = htmlspecialchars($cff_name_raw);
	                    }

	                    //OFFER TEXT
	                    if ($cff_post_type == 'offer'){
	                    	isset($news->story) ? $post_text = htmlspecialchars($news->story) . '<br /><br />' : $post_text = '';
	                    	$post_text .= htmlspecialchars($news->name);
	                    }

	                    //Add the description
	                    if( $cff_show_desc && $cff_post_type != 'offer' && $cff_post_type != 'link' ) $post_text .= $cff_description;

	                    //Change the linebreak element if the text issue setting is enabled
	                    $cff_format_issue = CFF_Utils::check_if_on( $this->atts['textissue'] );
	                    $cff_linebreak_el = ( $cff_format_issue ) ?  '<br />' : '<img class="cff-linebreak" />';

	                    //EVENT
	                    $cff_event_has_cover_photo = false;
	                    $cff_event = '';


	                    //Create note
	                    if ($cff_post_type == 'note') {
	                        //Notes don't include any post text and so just replace the post text with the note content
	                    	if($cff_show_text) $post_text = CFF_Utils::print_template_part( 'item/type/note', get_defined_vars(), $this);
	                    }

	                    $cff_post_text = CFF_Utils::print_template_part( 'item/post-text', get_defined_vars(), $this);

	                    //LINK
	                    //Display shared link
	                    $cff_shared_link = CFF_Utils::print_template_part( 'item/shared-link', get_defined_vars(), $this);

	                    //Link to the Facebook post if it's a link or a video
	                    if($cff_post_type == 'link' || $cff_post_type == 'video') $link = "https://www.facebook.com/" . $this->page_id . "/posts/" . $PostID[1];


	                    //If it's a shared post then change the link to use the Post ID so that it links to the shared post and not the original post that's being shared
	                    if( isset($news->status_type) ){
	                    	if( $news->status_type == 'shared_story' ) $link = "https://www.facebook.com/" . $cff_post_id;
	                    }

	                    //Create post action links HTML
	                    $cff_link = CFF_Utils::print_template_part( 'item/post-link', get_defined_vars(), $this);
	                    /* MEDIA LINK */
	                    $cff_media_link = CFF_Utils::print_template_part( 'item/media-link', get_defined_vars(), $this);
	                    //**************************//
	                    //***CREATE THE POST HTML***//
	                    //**************************//
	                    //Start the container
	                    $cff_post_item = CFF_Utils::print_template_part( 'item/container', get_defined_vars(), $this);

	                    //PUSH TO ARRAY
	                    $cff_posts_array = CFF_Utils::cff_array_push_assoc($cff_posts_array, $i_post, $cff_post_item);

	                } // End post type check

	                if (isset($news->message)) $prev_post_message = $news->message;
	                if (isset($news->link))  $prev_post_link = $news->link;
	                if (isset($news->description))  $prev_post_description = $news->description;

	            } // End the loop
	        } //End isset($FBdata->data)

	        //Sort the array in reverse order (newest first)
	        if(!$cff_is_group) ksort($cff_posts_array);

	    // End ALL POSTS


	    //Output the posts array
	        $p = 0;
	        foreach ($cff_posts_array as $post ) {
	        	if ( $p == $show_posts ) break;
	        	$cff_content .= $post;
	        	$p++;
	        }


	    //Add the Like Box inside
	        if ($cff_like_box_position == 'bottom' && $cff_show_like_box && !$cff_like_box_outside) $cff_content .= $like_box;
	        /* Credit link */

            $cff_content .= '</div>'; // End cff-posts-wrap

	        $cff_content .= CFF_Utils::print_template_part( 'credit', get_defined_vars());

	    //End the feed
	         $cff_content .= '<input class="cff-pag-url" type="hidden" data-cff-shortcode="'.$data_att_html.'" data-post-id="' . get_the_ID() . '" data-feed-id="'.$atts['id'].'">';
	        $cff_content .= '</div></div><div class="cff-clear"></div>';

	   	 	//Add the Like Box outside
	        if ($cff_like_box_position == 'bottom' && $cff_show_like_box && $cff_like_box_outside) $cff_content .= $like_box;

	    	//If the feed is loaded via Ajax then put the scripts into the shortcode itself
	        $cff_content .= $this->ajax_loaded();
	        $cff_content .= '</div>';

		if ( $doing_custom_styles ) {
			$cff_content .= '<style type="text/css">'. "\n";

			if ( ! empty( $this->atts['colorpalette'] )
			     && $this->atts['colorpalette'] === 'custom' ) {

				$wrap_selector = '#cff.' . $custom_palette_class;

				if ( ! empty( $this->atts['custombgcolor1'] ) ) {
					$cff_content .= $wrap_selector . ' ' . '.cff-item,' . "\n";
					$cff_content .= $wrap_selector . ' ' . '.cff-item.cff-box,' . "\n";
					$cff_content .= $wrap_selector . ' ' . '.cff-item.cff-box:first-child,' . "\n";
					$cff_content .= $wrap_selector . ' ' . '.cff-album-item {' . "\n";
					$cff_content .= '  ' . 'background-color: ' . esc_attr( $this->atts['custombgcolor1'] ) . ';' ."\n";
					$cff_content .= '}' . "\n";
				}

				if ( ! $cff_disable_link_box && ! empty( $this->atts['custombgcolor2'] ) ) {
					$cff_content .= $wrap_selector . ' ' . '.cff-view-comments,' . "\n";
					$cff_content .= $wrap_selector . ' ' . '.cff-load-more,' . "\n";
					$cff_content .= $wrap_selector . ' ' . '.cff-shared-link {' . "\n";
					$cff_content .= '  ' . 'background-color: ' . esc_attr( $this->atts['custombgcolor2'] ) . ';' ."\n";
					$cff_content .= '}' . "\n";
				}

				if ( ! empty( $this->atts['textcolor1'] ) ) {
					$cff_content .= $wrap_selector . ' ' . '.cff-comment .cff-comment-text p,' . "\n";
					$cff_content .= $wrap_selector . ' ' . '.cff-album-info p,' . "\n";
					$cff_content .= $wrap_selector . ' ' . '.cff-story,' . "\n";
					$cff_content .= $wrap_selector . ' ' . '.cff-text {' . "\n";
					$cff_content .= '  ' . 'color: ' . esc_attr( $this->atts['textcolor1'] ) . ';' ."\n";
					$cff_content .= '}' . "\n";
				}

				if ( ! empty( $this->atts['textcolor2'] ) ) {
					$cff_content .= $wrap_selector . ' ' . '.cff-comment-date,' . "\n";
					$cff_content .= $wrap_selector . ' ' . '.cff-text-link .cff-post-desc,' . "\n";
					$cff_content .= $wrap_selector . ' ' . '.cff-link-caption,' . "\n";
					$cff_content .= $wrap_selector . ' ' . '.cff-date {' . "\n";
					$cff_content .= '  ' . 'color: ' . esc_attr( $this->atts['textcolor2'] ) . ';' ."\n";
					$cff_content .= '}' . "\n";
				}

				if ( ! empty( $this->atts['customlinkcolor'] ) ) {
					$cff_content .= $wrap_selector . ' ' . 'a,' . "\n";
					$cff_content .= $wrap_selector . ' ' . '.cff-post-links a,' . "\n";
					$cff_content .= $wrap_selector . ' ' . 'a {' . "\n";
					$cff_content .= '  ' . 'color: ' . esc_attr( $this->atts['customlinkcolor'] ) . ';' ."\n";
					$cff_content .= '}' . "\n";
				}

			}
			$lightbox_selector = '#cff-lightbox-wrapper';

			if ( ! empty( $this->atts['lightboxbgcolor'] ) ) {
				$cff_content .= $lightbox_selector . ' ' . '.cff-lightbox-dataContainer,' . "\n";
				$cff_content .= $lightbox_selector . ' ' . '.cff-lightbox-sidebar {' . "\n";
				$cff_content .= '  ' . 'background-color: ' . esc_attr( $this->atts['lightboxbgcolor'] ) . ';' ."\n";
				$cff_content .= '}' . "\n";
			}

			if ( ! empty( $this->atts['lightboxtextcolor'] ) ) {
				$cff_content .= $lightbox_selector . ' ' . '.cff-author .cff-date,' . "\n";
				$cff_content .= $lightbox_selector . ' ' . '.cff-lightbox-closeContainer svg,' . "\n";
				$cff_content .= $lightbox_selector . ' ' . '.cff-lightbox-caption-text {' . "\n";
				$cff_content .= '  ' . 'color: ' . esc_attr( $this->atts['lightboxtextcolor'] ) . ';' ."\n";
				$cff_content .= '}' . "\n";
			}

			if ( ! empty( $this->atts['lightboxlinkcolor'] ) ) {
				$cff_content .= $lightbox_selector . ' ' . '.cff-lightbox-caption-text a:link,' . "\n";
				$cff_content .= $lightbox_selector . ' ' . '.cff-lightbox-caption-text a:hover,' . "\n";
				$cff_content .= $lightbox_selector . ' ' . '.cff-lightbox-caption-text a:active,' . "\n";
				$cff_content .= $lightbox_selector . ' ' . '.cff-lightbox-caption-text a:visited,' . "\n";
				$cff_content .= $lightbox_selector . ' ' . '.cff-lightbox-facebook:link,' . "\n";
				$cff_content .= $lightbox_selector . ' ' . '.cff-lightbox-facebook:hover,' . "\n";
				$cff_content .= $lightbox_selector . ' ' . '.cff-lightbox-facebook:active,' . "\n";
				$cff_content .= $lightbox_selector . ' ' . '.cff-lightbox-facebook:visited,' . "\n";
				$cff_content .= $lightbox_selector . ' ' . 'a {' . "\n";
				$cff_content .= '  ' . 'color: ' . esc_attr( $this->atts['lightboxlinkcolor'] ) . ';' ."\n";
				$cff_content .= '}' . "\n";
			}

			$cff_content .= '</style>';

		}


	        if( isset( $cff_posttext_link_color ) && !empty( $cff_posttext_link_color ) ) $cff_content .= '<style>#cff .cff-post-text a{ color: #'.$cff_posttext_link_color.'; }</style>';

			if ( isset( $_GET['sb_debug'] ) ) {
				$cff_content .= $this->sb_get_debug_report( $feed_options );
			}

	   	 	//Return our feed HTML to display
	        return $cff_content;
	    }

	/**
	 * Get Debug Report for Feed
	 *
	 * @since 4.0
	 *
	 * @param array $feed_opitons
	 *
	 * @return string $output
	 */
	public function sb_get_debug_report( $feed_options ) {
		if ( !isset( $_GET['sb_debug'] ) ) {
			return;
		}
		$cff_options = get_option( 'cff_style_settings' );

		$output = '';
		$output .= '<p>Settings</p>';
		$output .= '<ul style="word-break: break-all;">';

		$output .= '<li>Optimize Images: ';
        $output .= isset( $cff_options[ 'cff_disable_resize' ] ) && $cff_options[ 'cff_disable_resize' ] == 'on' ? 'Enabled' : 'Disabled';
        $output .= "</li>";
        $output .= "</li>";
        $output .= '<li>AJAX theme loading fix: ';
        $output .= isset( $cff_options[ 'cff_disable_ajax_cache' ] ) && $cff_options[ 'cff_disable_ajax_cache' ] == true ? 'Enabled' : 'Disabled';
        $output .= "</li>";
        $output .= '<li>Show Credit Link: ';
        $output .= isset( $cff_options['cff_format_issue'] ) && $cff_options['cff_format_issue'] == true ? 'Enabled' : 'Disabled';
        $output .= "</li>";
        $output .= '<li>Fix Text Shortening Issue: ';
        $output .= isset( $cff_options['cff_show_credit'] ) && $cff_options['cff_show_credit'] == true ? 'Enabled' : 'Disabled';
        $output .= "</li>";
        $output .= '<li>Admin Error Notice: ';
        $output .= isset( $cff_options['disable_admin_notice'] ) && $cff_options['disable_admin_notice'] == true ? 'Enabled' : 'Disabled';
        $output .= "</li>";
		$output .= '</ul>';

		$output .= '<p>Feed Options</p>';
		$public_settings_keys = CFF_Shortcode::get_public_db_settings_keys();

		$output .= '<ul style="word-break: break-all;">';
		foreach( $feed_options as $key => $option ) {
			if ( is_array( $option ) ) continue;
			if ( in_array( $key, $public_settings_keys, true ) ) {
				$output .= sprintf('<li>%s: %s</li>', esc_html( $key ), esc_html( $option ) );
			}
		}
		$output .= '</ul>';

		return $output;
	}

	/**
	 * The plugin will output settings on the frontend for debugging purposes.
	 * Safe settings to display are added here.
	 **
	 * @return array
	 *
	 * @since 4.0
	 */
	public static function get_public_db_settings_keys() {
		$public = array(
			'ownaccesstoken',
			'id',
			'pagetype',
			'num',
			'limit',
			'others',
			'showpostsby',
			'cachetype',
			'cachetime',
			'cacheunit',
			'locale',
			'storytags',
			'ajax',
			'offset',
			'account',
			'width',
			'widthresp',
			'height',
			'padding',
			'bgcolor',
			'showauthor',
			'showauthornew',
			'class',
			'type',
			'gdpr',
			'loadiframes',
			'eventsource',
			'eventoffset',
			'eventimage',
			'pastevents',
			'albumsource',
			'showalbumtitle',
			'showalbumnum',
			'albumcols',
			'photosource',
			'photocols',
			'videosource',
			'showvideoname',
			'showvideodesc',
			'videocols',
			'playlist',
			'disablelightbox',
			'filter',
			'exfilter',
			'layout',
			'enablenarrow',
			'oneimage',
			'mediaposition' => 'above',
			'include',
			'exclude',
			'masonry',
			'masonrycols',
			'masonrycolsmobile',
			'masonryjs',
			'cols',
			'colsmobile',
			'colsjs',
			'nummobile',
			'poststyle',
			'postbgcolor',
			'postcorners',
			'boxshadow',
			'textformat',
			'textsize',
			'textweight',
			'textcolor',
			'textlinkcolor',
			'textlink',
			'posttags',
			'linkhashtags',
			'lightboxcomments',
			'authorsize',
			'authorcolor',
			'descsize',
			'descweight',
			'desccolor',
			'linktitleformat',
			'linktitlesize',
			'linkdescsize',
			'linkurlsize',
			'linkdesccolor',
			'linktitlecolor',
			'linkurlcolor',
			'linkbgcolor',
			'linkbordercolor',
			'disablelinkbox',
			'eventtitleformat',
			'eventtitlesize',
			'eventtitleweight',
			'eventtitlecolor',
			'eventtitlelink',
			'eventdatesize',
			'eventdateweight',
			'eventdatecolor',
			'eventdatepos',
			'eventdateformat',
			'eventdatecustom',
			'timezoneoffset',
			'cff_enqueue_with_shortcode',
			'eventdetailssize',
			'eventdetailsweight',
			'eventdetailscolor',
			'eventlinkcolor',
			'datepos',
			'datesize',
			'dateweight',
			'datecolor',
			'dateformat',
			'datecustom',
			'timezone',
			'beforedate',
			'afterdate',
			'linksize',
			'linkweight',
			'linkcolor',
			'viewlinktext',
			'linktotimeline',
			'buttoncolor',
			'buttonhovercolor',
			'buttontextcolor',
			'buttontext',
			'nomoretext',
			'iconstyle',
			'socialtextcolor',
			'socialbgcolor',
			'sociallinkcolor',
			'expandcomments',
			'commentsnum',
			'hidecommentimages',
			'loadcommentsjs',
			'salesposts',
			'textlength',
			'desclength',
			'showlikebox',
			'likeboxpos',
			'likeboxoutside',
			'likeboxcolor',
			'likeboxtextcolor',
			'likeboxwidth',
			'likeboxfaces',
			'likeboxborder',
			'likeboxcover',
			'likeboxsmallheader',
			'likeboxhidebtn',
			'credit',
			'textissue',
			'disablesvgs',
			'restrictedpage',
			'hidesupporterposts',
			'privategroup',
			'nofollow',
			'timelinepag',
			'gridpag',
			'disableresize',
			'showheader',
			'headertype',
			'headercover',
			'headeravatar',
			'headername',
			'headerbio',
			'headercoverheight',
			'headerlikes',
			'headeroutside',
			'headertext',
			'headerbg',
			'headerpadding',
			'headertextsize',
			'headertextweight',
			'headertextcolor',
			'headericon',
			'headericoncolor',
			'headericonsize',
			'headerinc',
			'headerexclude',
			'loadmore',
			'fulllinkimages',
			'linkimagesize',
			'postimagesize',
			'videoheight',
			'videoaction',
			'videoplayer',
			'sepcolor',
			'sepsize',
			'seemoretext',
			'seelesstext',
			'photostext',
			'facebooklinktext',
			'sharelinktext',
			'showfacebooklink',
			'showsharelink',
			'buyticketstext',
			'maptext',
			'interestedtext',
			'goingtext',
			'previouscommentstext',
			'commentonfacebooktext',
			'likesthistext',
			'likethistext',
			'reactedtothistext',
			'andtext',
			'othertext',
			'otherstext',
			'noeventstext',
			'replytext',
			'repliestext',
			'learnmoretext',
			'shopnowtext',
			'messagepage',
			'getdirections',
			'secondtext',
			'secondstext',
			'minutetext',
			'minutestext',
			'hourtext',
			'hourstext',
			'daytext',
			'daystext',
			'weektext',
			'weekstext',
			'monthtext',
			'monthstext',
			'yeartext',
			'yearstext',
			'agotext',
			'multifeedactive',
			'daterangeactive',
			'featuredpostactive',
			'albumactive',
			'masonryactive',
			'carouselactive',
			'reviewsactive',
			'from',
			'until',
			'featuredpost',
			'album',
			'daterange',
			'lightbox',
			'reviewsrated',
			'starsize',
			'hidenegative',
			'reviewslinktext',
			'reviewshidenotext',
			'reviewsmethod',
			'feedtype',
			'likeboxcustomwidth',
			'colstablet',
			'feedlayout',
			'colorpalette',
			'custombgcolor1',
			'custombgcolor2',
			'textcolor1',
			'textcolor2',
			'posttextcolor',
			'misctextcolor',
			'misclinkcolor',
			'headericonenabled',
			'lightboxbgcolor',
			'lightboxtextcolor',
			'lightboxlinkcolor',
			'beforedateenabled',
			'afterdateenabled',
			'showpoststypes',
			'headerbiosize',
			'headerbiocolor',
			'apipostlimit',
			'carouselheight',
			'carouseldesktop_cols',
			'carouselmobile_cols',
			'carouselnavigation',
			'carouselpagination',
			'carouselautoplay',
			'carouselinterval',
		);

		return $public;
	}

    /* NEW 3.0 Methods */
	/**
	 * Whether or not this feed is meant to use the new settings
	 * or legacy settings
	 *
	 * @param array $feed_options
	 *
	 * @return bool
	 *
	 * @since 4.0
	 */
	public function using_legacy_feed( $feed_options ) {
		$cff_statuses = get_option( 'cff_statuses', array() );

		if ( isset( $cff_statuses['support_legacy_shortcode'] )
		     && is_array( $cff_statuses['support_legacy_shortcode'] )) {
			return empty( $feed_options['feed'] );
		}

		if ( empty( $cff_statuses['support_legacy_shortcode'] ) ) {
			return false;
		}

		return empty( $feed_options['feed'] );
	}

	/**
	 * If a single unique feed was detected when updating from version 3.x
	 * to version 4.0, a shortcode without a feed specified will be defaulted
	 * to feed=1
	 *
	 * @param $feed_options
	 *
	 * @return bool
	 */
	public function is_legacy_feed_one( $feed_options ) {
		$cff_statuses = get_option( 'cff_statuses', array() );

		if ( isset( $cff_statuses['support_legacy_shortcode'] )
		     && is_array( $cff_statuses['support_legacy_shortcode'] )) {
			return empty( $feed_options['feed'] );
		}

		return false;
	}

	/**
	 * For non-legacy feeds. Queries the new db tables to see if the feed
	 * exists and then converts the settings to what is usable by the plugin.
	 *
	 * @param array $feed_options
	 *
	 * @return array|bool
	 *
	 * @since 4.0
	 */
	function get_settings_for_feed( $feed_options ) {
		if ( ! is_array( $feed_options ) ) {
			$feed_options = array();
		}

		if ( $this->is_legacy_feed_one( $feed_options ) ) {
			$feed_options['feed'] = 1;
		}

		if ( ! $this->using_legacy_feed( $feed_options ) ) {

			$feed_id = isset( $feed_options['feed'] ) ? $feed_options['feed'] : false;

			if ( empty( $feed_id ) ) {
				$feed_list = \CustomFacebookFeed\Builder\CFF_Feed_Builder::get_feed_list();

				if ( count( $feed_list ) === 1 ) {
					$feed_saver = new \CustomFacebookFeed\Builder\CFF_Feed_Saver( $feed_list[0]['id'] );
					$settings   = $feed_saver->get_feed_settings();
				} else {
					if (( current_user_can('editor') || current_user_can('administrator') ) ) {
						echo "<span id='cff-no-id'>" . sprintf( __( "It looks like you have more than one feed. Go to %sthis page%s and enter the intended feed ID in your shortcode like this: [custom-facebook-feed feed=YOUR_FEED_ID_HERE].", 'custom-facebook-feed' ), '<a href="' . esc_url( admin_url( 'admin.php?page=cff-feed-builder' ) ) . '">', '</a>' ) . "</span><br /><br />";
					}
					return false;
				}

			} else {
				$feed_saver = new \CustomFacebookFeed\Builder\CFF_Feed_Saver( $feed_id );
				$settings   = $feed_saver->get_feed_settings();
			}

			if ( empty( $settings ) ) {
				if (( current_user_can('editor') || current_user_can('administrator') ) ) {
					$feed_list = \CustomFacebookFeed\Builder\CFF_Feed_Builder::get_feed_list();
					if ( empty( $feed_list ) ) {
						echo "<span id='cff-no-id'>" . sprintf( __( "It looks like you haven't set up a feed yet. Try going to %sthis page%s to create one and then enter the feed id in the shortcode like this [custom-facebook-feed feed=YOUR_FEED_ID_HERE].", 'custom-facebook-feed' ), '<a href="' . esc_url( admin_url( 'admin.php?page=cff-feed-builder' ) ) . '">', '</a>' ) . "</span><br /><br />";
					}
				}
				return false;
			} elseif ( empty( $settings['sources'] ) ) {
				if (( current_user_can('editor') || current_user_can('administrator') ) ) {
					echo "<span id='cff-no-id'>" . sprintf( __( "No source found for this feed. It looks like you may have removed the account this feed was using to display posts. Go to %sthis page%s, switch to the settings tab and click the sources menu item to manage sources for this feed.", 'custom-facebook-feed' ), '<a href="' . esc_url( admin_url( 'admin.php?page=cff-feed-builder&feed_id=' . (int) $feed_id ) ) . '">', '</a>' ) . "</span><br /><br />";
				}
				return $settings;
			}


			if ( empty( $settings['showpoststypes'] )
			     || $settings['showpoststypes'] === 'all' ) {
				$settings['type'] = 'links,events,videos,photos,albums,statuses';
			}

			if ( ! empty( $settings['feedtype'] ) && $settings['feedtype'] !== 'timeline' ) {
				$settings['type'] = $settings['feedtype'];
			}


		} else {
			$settings = CFF_FB_Settings::get_legacy_settings( $feed_options );

			if ( ! empty( $feed_options['type'] ) ) {
				$settings['feedtype'] = $feed_options['type'];
				$settings['type'] =  $feed_options['type'];

			} else {
				if ( empty( $settings['showpoststypes'] )
				     || $settings['showpoststypes'] === 'all' ) {
					$settings['type'] = 'links,events,videos,photos,albums,statuses';
				}

				if ( ! empty( $settings['feedtype'] ) && $settings['feedtype'] !== 'timeline' ) {
					$settings['type'] = $settings['feedtype'];
				}
			}

			$default_grid = [
				'albums',
				'videos',
				'photos',
				'singlealbum'
			];

			$type_setting_array = is_array( $settings['type'] ) ? array_filter( $settings['type'] ) : array_filter( explode( ',', $settings['type'] ) );

			$single_type = count( $type_setting_array ) === 1 ? $type_setting_array[0] : false;

			if ( ! empty( $feed_options['album'] ) ) {
				$single_type = 'singlealbum';
			}

			if ( $single_type ) {
				if ( in_array( $single_type, $default_grid ) ) {
					if ( empty( $feed_options['feedlayout'] ) ) {
						$settings['feedlayout'] = 'grid';
					}
					if ( empty( $feed_options['cols'] ) ) {
						$colskey = substr( $single_type, 0, -1 ) . 'cols';
						$options_val = isset( $settings[ $colskey ] ) ? $settings[ $colskey ] : 4;
						$settings['cols'] = isset( $settings[ $colskey ] ) ? $settings[ $colskey ] : $options_val;
					}
				}
				$settings['feedtype'] = $single_type;
			}

		}

		$cff_includes = $settings['include'];
		$cff_excludes = $settings['exclude'];

		$cff_show_like_box = false;
		if ( is_string( $cff_includes ) ) {
			if ( CFF_Utils::stripos($cff_includes, 'likebox') !== false ) $cff_show_like_box = true;
		} elseif ( in_array( 'likebox', $cff_includes ) ) {
			$cff_show_like_box = true;
		}
		if ( is_string( $cff_excludes ) ) {
			if ( CFF_Utils::stripos($cff_excludes, 'likebox') !== false ) $cff_show_like_box = false;
		} elseif ( in_array( 'likebox', $cff_excludes ) ) {
			$cff_show_like_box = false;
		}

		if ( ! isset( $feed_options['include'] ) && ! isset( $feed_options['exclude'] )  ) {
			if ( ! empty( $settings['showlikebox'] ) ) {
				$settings['showlikebox'] = $settings['showlikebox'] === false || $settings['showlikebox'] === 'off' ? false : true;
			} else {
				$settings['showlikebox'] = $cff_show_like_box;
			}
		} else {
			$settings['showlikebox'] = $cff_show_like_box;
		}

		if ( ! $settings['showlikebox'] ) {
			$settings['include'] = str_replace( 'likebox,', ',', $settings['include'] );
		}

		if ( ! empty( $settings['headericonenabled'] ) && $settings['headericonenabled'] === 'off' ) {
			$settings['headericon'] = '';
		}

		if ( ! empty( $settings['apipostlimit'] )
		     && $settings['apipostlimit'] === 'auto') {
			$settings['limit'] = '';
		}

		if ( $settings['poststyle'] === 'regular' ) {
			$settings['boxshadow'] = false;
		}

		if ( isset( $feed_options['ajax'] ) ) {
			$settings['ajax'] = $feed_options['ajax'];
		} else {
			$settings['ajax'] = get_option( 'cff_ajax', '' );
		}
		$settings['locale'] = get_option( 'cff_locale', 'en_US' );

		// Default Timezone
		$defaults = array(
			'cff_timezone' => 'America/Chicago',
			'gdpr' => 'auto',
			'cff_show_credit' => false,
			'cff_format_issue' => '',
			'disable_admin_notice' => false
		);
		$style_options = get_option( 'cff_style_settings', $defaults );
		$settings['timezone'] = (isset($style_options[ 'cff_timezone' ])) ?  $style_options[ 'cff_timezone' ] :  $defaults[ 'cff_timezone' ];
		$settings['gdpr'] = (isset($style_options[ 'gdpr' ])) ?  $style_options[ 'gdpr' ] :  $defaults[ 'gdpr' ];
		$settings['credit'] = (isset($style_options[ 'cff_show_credit' ])) ?  $style_options[ 'cff_show_credit' ] :  $defaults[ 'cff_show_credit' ];
		$settings['textissue'] = (isset($style_options[ 'cff_format_issue' ])) ?  $style_options[ 'cff_format_issue' ] :  $defaults[ 'cff_format_issue' ];
		$settings['likeboxheight'] = '';
		$settings['disablestyles'] = isset($style_options[ 'cff_disable_styles' ]) ? $style_options[ 'cff_disable_styles' ] : '';

		$settings['cachetime'] = isset($feed_options[ 'cachetime' ]) ? $feed_options[ 'cachetime' ] : get_option( 'cff_cache_time', '1' );
		$settings['cacheunit'] = isset($feed_options[ 'cacheunit' ]) ? $feed_options[ 'cacheunit' ] : get_option( 'cff_cache_time_unit', 'hours' );

		$maybe_legacy_shortcode = $feed_options;
		if ( isset( $maybe_legacy_shortcode['feed'] ) ) {
			unset( $maybe_legacy_shortcode['feed'] );
		}

		// Merge in legacy settings (shortcode only settings)
		if ( ! empty( $maybe_legacy_shortcode ) ) {
			$legacy_shortcode_settings = [
				'width',
				'widthresp',
				'mediaposition',
				'masonryjs',
				'colsjs',
				'textformat',
				//all text weight settings
				'textweight',
				'descweight',
				'eventtitleweight',
				'eventdateweight',
				'eventdetailsweight',
				'dateweight',
				'linkweight',
				'headertextweight',
				'posttags',
				'linkhashtags',
				'offset',
				'cff_enqueue_with_shortcode',
				'commentsnum',
				'restrictedpage',
				'hidesupporterposts',
				'privategroup',
				'fulllinkimages',
				'linkimagesize',
				'postimagesize',
				'videoheight',
				'videoaction',
				'videoplayer',
				'class',
				'padding'
			];

			foreach ( $maybe_legacy_shortcode as $maybe_legacy => $value ) {
				if ( in_array( $maybe_legacy, $legacy_shortcode_settings, true ) ) {
					$settings[ $maybe_legacy ] = $value;
				}
			}

			if ( $settings['posttags'] === 'false' ) {
				$settings['posttags'] = false;
			}

			if ( $settings['linkhashtags'] === 'false' ) {
				$settings['linkhashtags'] = false;
			}
		}

		if ( ! CFF_Utils::cff_is_pro_version() ) {
			$this->page_id = $settings['id'];
			$this->access_token = $settings['accesstoken'];
			$this->feed_id = ! empty( $feed_id ) ? $feed_id : 'default';
		}

		return \CustomFacebookFeed\Builder\CFF_Post_Set::builder_to_general_settings_convert( $settings );
	}

	/**********
	 * Ported from Pro version, could use cleanup
	 *
	 * TODO: Remove all or part of functions not needed for free
	 *************/

	/**
	 * this where you could take the feed options to get the feed data for the first set
	 * of posts or, if the $before and $after parameters are set, get the next set of posts
	 *
	 * @since 3.18
	 */
	static function cff_get_json_data( $feed_options, $next_urls_arr_safe, $data_att_html, $is_customizer = false ) {
		//Define vars
		$access_token = $feed_options['accesstoken'];
		//If the 'Enter my own Access Token' box is unchecked then don't use the user's access token, even if there's one in the field
		$feed_options['ownaccesstoken'] ? $cff_show_access_token = true : $cff_show_access_token = true;
		//Reviews Access Token
		$page_access_token = $feed_options['pagetoken'];
		$cff_show_access_token = true;
		$page_id = trim( $feed_options['id'] );
		$show_posts = isset( $feed_options['minnum'] ) ? $feed_options['minnum'] : $feed_options['num'];
		$show_posts_number = isset( $feed_options['minnum'] ) ? $feed_options['minnum'] : $feed_options['num'];

		$cff_post_limit = $feed_options['limit'];
		$cff_page_type = $feed_options[ 'pagetype' ];
		$show_others = $feed_options['others'];
		$show_posts_by = $feed_options['showpostsby'];
		$cff_caching_type = $feed_options['cachetype'];
		$cff_cache_time = $feed_options['cachetime'];
		$cff_cache_time_unit = $feed_options['cacheunit'];
		$cff_locale = $feed_options['locale'];
		//Post types
		$cff_types = $feed_options['type'];
		$cff_events_source = $feed_options[ 'eventsource' ];
		$cff_event_offset = $feed_options[ 'eventoffset' ];
		$cff_albums_source = $feed_options[ 'albumsource' ];
		$cff_photos_source = $feed_options[ 'photosource' ];
		$cff_videos_source = $feed_options[ 'videosource' ];
		//Past events
		$cff_past_events = $feed_options['pastevents'];
		//Active extensions
		$cff_ext_multifeed_active = $feed_options[ 'multifeedactive' ];
		#$cff_ext_date_active = $feed_options[ 'daterangeactive' ];
		$cff_ext_date_active = CFF_FB_Settings::check_active_extension( 'date_range' ) && CFF_Utils::check_if_on($feed_options['daterange']);

		$cff_featured_post_active = $feed_options[ 'featuredpostactive' ];
		$cff_album_active = $feed_options[ 'albumactive' ];
		$cff_masonry_columns_active = false; //Deprecated
		$cff_carousel_active = $feed_options[ 'carouselactive' ];
		$cff_reviews_active = $feed_options[ 'reviewsactive' ];
		//Extension settings
		$cff_album_id = $feed_options['album'];
		$cff_featured_post_id = $feed_options['featuredpost'];
		$include_extras = isset( $feed_options['include_extras'] );

		//Get show posts attribute. If not set then default to 25
		if (empty($show_posts)) $show_posts = 25;
		if ( $show_posts == 0 || $show_posts == 'undefined' ) $show_posts = 25;

		//Set the page type
		$cff_is_group = false;
		if ($cff_page_type == 'group') $cff_is_group = true;

		//Look for non-plural version of string in the types string in case user specifies singular in shortcode
		$cff_show_links_type = true;
		$cff_show_event_type = true;
		$cff_show_video_type = true;
		$cff_show_photos_type = true;
		$cff_show_status_type = true;
		$cff_show_albums_type = true;

		$cff_events_only = false;
		$cff_albums_only = false;
		$cff_photos_only = false;
		$cff_videos_only = false;

		//Is it SSL?
		$cff_ssl = '';
		if (is_ssl()) $cff_ssl = '&return_ssl_resources=true';

		//Use posts? or feed?
		$graph_query = 'posts';
		$cff_show_only_others = false;

		//If 'others' shortcode option is used then it overrides any other option
		if ($show_others) {
			//Show posts by everyone
			if ( $show_others == 'on' || $show_others == 'true' || $show_others == true || $cff_is_group ) $graph_query = 'feed';
			//Only show posts by me
			if ( $show_others == 'false' ) $graph_query = 'posts';
		} else {
			//Else use the settings page option or the 'showpostsby' shortcode option
			//Only show posts by me
			if ( $show_posts_by == 'me' ) $graph_query = 'posts';
			//Show posts by everyone
			if ( $show_posts_by == 'others' || $cff_is_group ) $graph_query = 'feed';
			//Show posts ONLY by others
			if ( $show_posts_by == 'onlyothers' && !$cff_is_group ) {
				$graph_query = 'visitor_posts';
				$cff_show_only_others = true;
			}
		}


		//Calculate the cache time in seconds
		if($cff_cache_time_unit == 'minutes') $cff_cache_time_unit = 60;
		if($cff_cache_time_unit == 'hour' || $cff_cache_time_unit == 'hours') $cff_cache_time_unit = 60*60;
		if($cff_cache_time_unit == 'days') $cff_cache_time_unit = 60*60*24;
		$cache_seconds = $cff_cache_time * $cff_cache_time_unit;


		//********************************************//
		//*****************GET POSTS******************//
		//********************************************//
		$FBdata_arr = array(); //Use an array to store the data for each page ID (for multifeed)
		$page_ids = array($page_id);


		//If the limit isn't set then set it to be 7 more than the number of posts defined
		if ( isset($cff_post_limit) && $cff_post_limit !== '' ) {
			$cff_post_limit = $cff_post_limit;
		} else {
			if( intval($show_posts) >= 50 ) $cff_post_limit = intval(intval($show_posts) + 7);
			if( intval($show_posts) < 50 ) $cff_post_limit = intval(intval($show_posts) + 5);
			if( intval($show_posts) < 25  ) $cff_post_limit = intval(intval($show_posts) + 4);
			if( intval($show_posts) < 10  ) $cff_post_limit = intval(intval($show_posts) + 3);
			if( intval($show_posts) < 6  ) $cff_post_limit = intval(intval($show_posts) + 2);
			if( intval($show_posts) < 2  ) $cff_post_limit = intval(intval($show_posts) + 1);

			//If using multifeed then set the limit dynamically based on the number of pages if it isn't set
			if( $cff_ext_multifeed_active && count($page_ids) > 1 ){
				$cff_post_limit = ( ceil(intval($show_posts) / count($page_ids)) ) + 1;
			}
		}
		if( $cff_post_limit >= 100 ) $cff_post_limit = 100;

		//If the number of posts is set to zero then don't show any and set limit to one
		if ( ($show_posts == '0' || $show_posts == 0) && $show_posts !== ''){
			$show_posts = 0;
			$cff_post_limit = 1;
		}

		//If the timeline pagination method is set to use the API paging method then set the limit to be the number of posts displayed so that posts aren't skipped when loading more
		if( $feed_options['timelinepag'] == 'paging' ) $cff_post_limit = $show_posts;


		//Loop through page IDs
		foreach ( $page_ids as $page_id ) {

			//********************************************//
			//********CREATE THE API REQUEST URL**********//
			//********************************************//

			//ALL POSTS

			//Add option to remove attachments description field to workaround Facebook "Unsupported Get Request" bug caused by sales posts in the API request
			$attachments_desc = ( $feed_options['salesposts'] == 'true' ) ? '' : ',description';

			//Add option to remove story_tags to workaround Facebook "Unknown Error" message returned by API for certain posts
			$story_tags = ( $feed_options['storytags'] == 'true' ) ? '' : ',story_tags';
			$cff_posts_json_url = 'https://graph.facebook.com/v4.0/' . $page_id . '/' . $graph_query . '?fields=id,updated_time,from{picture,id,name,link},message,message_tags,story'. $story_tags .',picture,full_picture,status_type,created_time,backdated_time,attachments{title'. $attachments_desc .',media_type,unshimmed_url,target{id},multi_share_end_card,media{source,image},subattachments},shares,call_to_action,privacy&access_token=' . $access_token . '&limit=' . $cff_post_limit . '&locale=' . $cff_locale . $cff_ssl;


			//********************************************//
			//*********CREATE THE TRANSIENT NAME**********//
			//********************************************//



			//ALL POSTS
			if (!$cff_events_only || ($cff_events_only && $cff_events_source == 'timeline') ){

				//If it's a playlist then use the playlist ID instead of the Page ID
				$page_id_caching = $page_id;
				if( $feed_options['playlist'] ){
					$page_id_caching = $feed_options['playlist'];
				}

				$trans_items_arr = array(
					'page_id' => $page_id_caching,
					'post_limit' => substr($cff_post_limit, 0, 3),
					'show_posts_by' => substr($show_posts_by, 0, 2),
					'locale' => $cff_locale
				);

				$trans_arr_item_count = 1;
				if( $cff_featured_post_active && !empty($cff_featured_post_id) ){
					$trans_items_arr['featured_post'] = $cff_featured_post_id;
					$trans_arr_item_count++;
				}
				if($cff_albums_only) $trans_items_arr['albums_source'] = $cff_albums_source;
				$trans_items_arr['albums_only'] = intval($cff_albums_only);
				$trans_items_arr['photos_only'] = intval($cff_photos_only);
				$trans_items_arr['videos_only'] = intval($cff_videos_only);

				$arr_item_max_length = floor( 28/$trans_arr_item_count ); //40 minus the 12 needed for the other 7 values shown below equals 28
				$arr_item_max_length_half = floor($arr_item_max_length/2);

				$transient_name = 'cff_';
				foreach ($trans_items_arr as $key => $value) {
					if($value !== false){
						if( $key == 'page_id' || $key == 'featured_post' || $key == 'from' || $key == 'until' ) $transient_name .= substr($value, 0, $arr_item_max_length_half) . substr($value, $arr_item_max_length_half*-1);  //-10
						if( $key == 'locale' ) $transient_name .= substr($value, 0, 2);
						if( $key == 'post_limit' || $key == 'show_posts_by' ) $transient_name .= substr($value, 0, 3);
						if( $key == 'albums_only' || $key == 'photos_only' || $key == 'videos_only' || $key == 'albums_source' || $key == 'reviews' ) $transient_name .= substr($value, 0, 1);
					}
				}
				//Make sure it's not more than 45 chars
				$transient_name = substr($transient_name, 0, 45);

				//ALBUM EMBED
				if( $cff_album_active && !empty($cff_album_id) ) {
					$transient_name = 'cff_album_' . $cff_album_id . '_' . $cff_post_limit;
					$transient_name = substr($transient_name, 0, 45);
				}

			} //END ALL POSTS



			//Are there more posts to get for this ID?
			$cff_more_posts = true;

			//If the cron caching is enabled then set the caching time to be long so that it doesn't expire before rechecked in the cron function
			if( false == 'background' ) $cache_seconds = 7 * DAY_IN_SECONDS;


			//ALL POSTS
			$posts_json = CFF_Utils::cff_get_set_cache($cff_posts_json_url, $transient_name, $cff_cache_time, $cache_seconds, $data_att_html, $cff_show_access_token, $access_token, true);
			if( $cff_is_group ){
				$groups_post = new CFF_Group_Posts($page_id, $feed_options, $cff_posts_json_url, $data_att_html, false);
				$groups_post_result = $groups_post->init_group_posts($posts_json, false, $show_posts_number);
				$posts_json = $groups_post_result['posts_json'];
			}
			//ALBUM EMBED
			if( $cff_album_active && !empty($cff_album_id) ) $album_json = $posts_json;

			//Interpret data with JSON
			$FBdata = json_decode($posts_json);

			if ( false /*$is_customizer*/ ) {
				//Get more data about single events since timelines don't have it
				$can_check_for_events = false;
				$event_supporting_access_tokens = array();
				if ( isset( $feed_options['sources'][0] ) ) {
					foreach ( $feed_options['sources'] as $source ) {
						#if ( $source['privilege'] === 'events' ) {
						$can_check_for_events = true;
						$event_supporting_access_tokens[ $source['account_id'] ] = $source['access_token'];
						# }
					}
				}


				if ( $can_check_for_events ) {
					if ( isset( $FBdata->data ) ) {
						$post_index = 0;
						foreach ( $FBdata->data as $post ) {
							$type = CFF_Parse::get_status_type( $post );

							if ( $type === 'created_event' ) {
								$account_id = CFF_Parse::get_from_id( $post );
								$post_id = CFF_Parse::get_post_id( $post );
								$event_id = explode( '_', $post_id );
								$event_id = $event_id[1];

								if ( ! empty( $event_supporting_access_tokens[ $account_id ] ) ) {
									$single_data = CFF_Shortcode::get_single_event_data( $event_id, $event_supporting_access_tokens[ $account_id ] );
									foreach( $single_data as $property => $value ) {
										$FBdata->data[ $post_index ]->$property = $value;
									}

								}
							}
							$post_index++;
						}
					}
				}
			}


			if( $cff_more_posts ){
				//Add the data to the array to be returned and parsed into HTML
				$FBdata_arr[$page_id] = $FBdata;
			} else {
				//Add something to the array for the ID if there's no posts to prevent any PHP notices
				$FBdata_arr[$page_id] = 'no_more_posts';
			}

			//Add the API URL to the json array so that we can grab it and add to the button if needed
			if( isset($FBdata_arr[$page_id]) ){
				if( !isset($FBdata_arr[$page_id]->api_url) && $FBdata_arr[$page_id] != 'no_more_posts' ){
					//Replace the actual token with the Access Token placeholder
					$cff_api_url = str_replace($access_token,"x_cff_hide_token_x",$cff_posts_json_url);
					//Add it to the json array
					$FBdata_arr[$page_id]->api_url = $cff_api_url;
				}
			}

		} //End page_id loop

		if($cff_is_group && isset($FBdata_arr[$page_id]) && $FBdata_arr[$page_id] != 'no_more_posts'){
			$FBdata_arr[$page_id]->is_load_cache = (isset($groups_post_result['latest_record_date'])) && $groups_post_result['latest_record_date'] !== 0 && $groups_post_result['load_from_cache'] !== false ? $groups_post_result['load_from_cache'] : false;
			$FBdata_arr[$page_id]->latest_record_date = $groups_post_result['latest_record_date'];
		}
		return $FBdata_arr;
	}

	/**
	 * this function breaks up the "next" url from the json data into an array of parts to load into
	 * the html to be retrieved on click and pieced back together
	 *
	 * @since 3.18
	 */
	static function cff_get_next_url_parts( $json_data_arr ) {
		$next_urls_arr_safe = '{';
		$next_urls_arr_safe .= '}';
		//If the array ends in a comma then remove the comma
		return $next_urls_arr_safe;
	}

	public static function get_single_event_data( $eventID, $access_token ) {
		//Is it SSL?
		$cff_ssl = '';
		if (is_ssl()) $cff_ssl = '&return_ssl_resources=true';

		//Get the contents of the event
		$event_json_url = 'https://graph.facebook.com/v3.3/'.$eventID.'?fields=cover,place,name,owner,start_time,timezone,id,comments.summary(true){message,created_time},description&access_token=' . $access_token . $cff_ssl;

		// Get any existing copy of our transient data
		$transient_name = 'cff_tle_' . $eventID;
		$transient_name = substr($transient_name, 0, 45);

		if ( false === ( $event_json = get_transient( $transient_name ) ) || $event_json === null ) {
			//Get the contents of the Facebook page
			$event_json = CFF_Utils::cff_fetchUrl($event_json_url);
			//Cache the JSON for 180 days as the timeline event info probably isn't going to change
			set_transient( $transient_name, $event_json, 60 * 60 * 24 * 180 );
		} else {
			$event_json = get_transient( $transient_name );
			//If we can't find the transient then fall back to just getting the json from the api
			if ($event_json == false) $event_json = CFF_Utils::cff_fetchUrl($event_json_url);
		}

		//Interpret data with JSON
		$event_object = json_decode($event_json);

		$description_text = '';
		if( isset($event_object->name) ) $description_text .= $event_object->name . ' ';
		if( isset($event_object->place->location->city) ) $description_text .= $event_object->place->location->city . ' ';
		if( isset($event_object->place->location->country) ) $description_text .= $event_object->place->location->country . ' ';
		if( isset($event_object->place->location->street) ) $description_text .= $event_object->place->location->street . ' ';
		if( isset($event_object->place->name) ) $description_text .= $event_object->place->name . ' ';
		if( isset($event_object->description) ) $description_text .= $event_object->description;
		$event_object->description_text = $description_text;

		return $event_object;

	}

	public static function add_translations( $atts ) {
		$translations = get_option( 'cff_style_settings', false );

		$final_translations = [
			'seemoretext' 				=> isset( $translations[ 'cff_see_more_text' ] ) ? stripslashes( esc_attr( $translations[ 'cff_see_more_text' ] ) ) : __( 'See More', 'custom-facebook-feed' ),
			'seelesstext' 				=> isset( $translations[ 'cff_see_less_text' ] ) ? stripslashes( esc_attr( $translations[ 'cff_see_less_text' ] ) ) : __( 'See Less', 'custom-facebook-feed' ),
			'facebooklinktext' 			=> isset( $translations[ 'cff_facebook_link_text' ] ) ? stripslashes( esc_attr( $translations[ 'cff_facebook_link_text' ] ) ) : __( 'View on Facebook', 'custom-facebook-feed' ),
			'sharelinktext' 			=> isset( $translations[ 'cff_facebook_share_text' ] ) ? stripslashes( esc_attr( $translations[ 'cff_facebook_share_text' ] ) ) : __( 'Share', 'custom-facebook-feed' ),

			'learnmoretext' 			=> isset( $translations[ 'cff_translate_learn_more_text' ] ) ? stripslashes( esc_attr( $translations[ 'cff_translate_learn_more_text' ] ) ) : __( 'Learn More', 'custom-facebook-feed' ),
			'shopnowtext' 				=> isset( $translations[ 'cff_translate_shop_now_text' ] ) ? stripslashes( esc_attr( $translations[ 'cff_translate_shop_now_text' ] ) ) : __( 'Shop Now', 'custom-facebook-feed' ),
			'messagepage' 				=> isset( $translations[ 'cff_translate_message_page_text' ] ) ? stripslashes( esc_attr( $translations[ 'cff_translate_message_page_text' ] ) ) : __( 'Message Page', 'custom-facebook-feed' ),
			'getdirections' 			=> isset( $translations[ 'cff_translate_get_directions_text' ] ) ? stripslashes( esc_attr( $translations[ 'cff_translate_get_directions_text' ] ) ) : __( 'Get Directions', 'custom-facebook-feed' ),

			'secondtext' 				=> isset( $translations[ 'cff_translate_second' ] ) ? stripslashes( esc_attr( $translations[ 'cff_translate_second' ] ) ) : 'second',
			'secondstext' 				=> isset( $translations[ 'cff_translate_seconds' ] ) ? stripslashes( esc_attr( $translations[ 'cff_translate_seconds' ] ) ) : 'seconds',
			'minutetext' 				=> isset( $translations[ 'cff_translate_minute' ] ) ? stripslashes( esc_attr( $translations[ 'cff_translate_minute' ] ) ) : 'minute',
			'minutestext' 				=> isset( $translations[ 'cff_translate_minutes' ] ) ? stripslashes( esc_attr( $translations[ 'cff_translate_minutes' ] ) ) : 'minutes',
			'hourtext' 					=> isset( $translations[ 'cff_translate_hour' ] ) ? stripslashes( esc_attr( $translations[ 'cff_translate_hour' ] ) ) : 'hour',
			'hourstext' 				=> isset( $translations[ 'cff_translate_hours' ] ) ? stripslashes( esc_attr( $translations[ 'cff_translate_hours' ] ) ) : 'hours',
			'daytext' 					=> isset( $translations[ 'cff_translate_day' ] ) ? stripslashes( esc_attr( $translations[ 'cff_translate_day' ] ) ) : 'day',
			'daystext' 					=> isset( $translations[ 'cff_translate_days' ] ) ? stripslashes( esc_attr( $translations[ 'cff_translate_days' ] ) ) : 'days',
			'weektext' 					=> isset( $translations[ 'cff_translate_week' ] ) ? stripslashes( esc_attr( $translations[ 'cff_translate_week' ] ) ) : 'week',
			'weekstext' 				=> isset( $translations[ 'cff_translate_weeks' ] ) ? stripslashes( esc_attr( $translations[ 'cff_translate_weeks' ] ) ) : 'weeks',
			'monthtext' 				=> isset( $translations[ 'cff_translate_month' ] ) ? stripslashes( esc_attr( $translations[ 'cff_translate_month' ] ) ) : 'month',
			'monthstext' 				=> isset( $translations[ 'cff_translate_months' ] ) ? stripslashes( esc_attr( $translations[ 'cff_translate_months' ] ) ) : 'months',
			'yeartext' 					=> isset( $translations[ 'cff_translate_year' ] ) ? stripslashes( esc_attr( $translations[ 'cff_translate_year' ] ) ) : 'year',
			'yearstext' 				=> isset( $translations[ 'cff_translate_years' ] ) ? stripslashes( esc_attr( $translations[ 'cff_translate_years' ] ) ) : 'years',
			'agotext' 					=> isset( $translations[ 'cff_translate_ago' ] ) ? stripslashes( esc_attr( $translations[ 'cff_translate_ago' ] ) ) : 'ago',

			'phototext' 			=> isset( $translations[ 'cff_translate_photo_text' ] ) ? stripslashes( esc_attr( $translations[ 'cff_translate_photo_text' ] ) ) : '',
			'videotext' 			=> isset( $translations[ 'cff_translate_video_text' ] ) ? stripslashes( esc_attr( $translations[ 'cff_translate_video_text' ] ) ) : '',
		];


		$final_translations['facebooklinktext'] = ! empty( $atts['facebooklinktext'] ) ? $atts['facebooklinktext'] : $final_translations['facebooklinktext'];
		$final_translations['sharelinktext'] = ! empty( $atts['sharelinktext'] ) ? $atts['sharelinktext'] : $final_translations['sharelinktext'];

		$atts = array_merge( $atts, $final_translations );

		return $atts;

	}

	function cff_add_translations() {
		$this->atts = CFF_Shortcode::add_translations( $this->atts );
	}


}