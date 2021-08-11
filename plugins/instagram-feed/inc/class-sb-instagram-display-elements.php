<?php
/**
 * Class SB_Instagram_Display_Elements
 *
 * Used to make certain parts of the html in the feed templates
 * abstract.
 *
 * @since 2.0/5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

class SB_Instagram_Display_Elements
{
	/**
	 * Images are hidden initially with the new/transition classes
	 * except if the js image loading is disabled using the plugin
	 * settings
	 *
	 * @param array $settings
	 * @param array|bool $post
	 *
	 * @return string
	 *
	 * @since 2.0/5.0
	 */
	public static function get_item_classes( $settings, $post = false ) {
		$classes = '';
		if ( !$settings['disable_js_image_loading'] ) {
			$classes .= ' sbi_new sbi_transition';
		} else {
			$classes .= ' sbi_new sbi_no_js sbi_no_resraise sbi_js_load_disabled';
		}

		if ( $post && SB_Instagram_Parse::get_media_product_type( $post ) === 'igtv' ) {
			$classes .= ' sbi_igtv';
		}

		return $classes;
	}

	/**
	 * Overwritten in the Pro version.
	 *
	 * @param string $type key of the kind of icon needed
	 * @param string $icon_type svg or font
	 *
	 * @return string the complete html for the icon
	 *
	 * @since 2.0/5.0
	 */
	public static function get_icon( $type, $icon_type ) {
		return self::get_basic_icons( $type, $icon_type );
	}

	/**
	 * Returns the best media url for an image based on settings.
	 * By default a white placeholder image is loaded and replaced
	 * with the most optimal image size based on the actual dimensions
	 * of the image element in the feed.
	 *
	 * @param array $post data for an individual post
	 * @param array $settings
	 * @param array $resized_images (optional) not yet used but
	 *  can pass in existing resized images to use in the source
	 *
	 * @return string
	 *
	 * @since 2.0/5.0
	 */
	public static function get_optimum_media_url( $post, $settings, $resized_images = array() ) {
		$media_url = '';
		$optimum_res = $settings['imageres'];
		$account_type = isset( $post['images'] ) ? 'personal' : 'business';

		// only use the placeholder if it will be replaced using JS
		if ( !$settings['disable_js_image_loading'] ) {
			return trailingslashit( SBI_PLUGIN_URL ) . 'img/placeholder.png';
		} elseif ( $settings['imageres'] === 'auto' ) {
			$optimum_res = 'full';
			$settings['imageres'] = 'full';
		} else {
			if ( ! empty( $resized_images ) ) {
				$resolution = $settings['imageres'];
				$post_id = SB_Instagram_Parse::get_post_id( $post );
				if ( isset( $resized_images[ $post_id ] )
				     && $resized_images[ $post_id ]['id'] !== 'error'
				     && $resized_images[ $post_id ]['id'] !== 'pending'
				     && $resized_images[ $post_id ]['id'] !== 'video' ) {
					if ( $resolution === 'thumb' ) {
						if ( isset( $resized_images[ $post_id ]['sizes']['low'] ) ) {
							$suffix = 'low';
						} elseif ( isset( $resized_images[ $post_id ]['sizes']['full'] ) ) {
							$suffix = 'full';
						}
					} elseif ( $resolution === 'medium' ) {
						if ( isset( $resized_images[ $post_id ]['sizes']['low'] ) ) {
							$suffix = 'low';
						} elseif ( isset( $resized_images[ $post_id ]['sizes']['full'] ) ) {
							$suffix = 'full';
						}
					} elseif ( $resolution === 'full' ) {
						if ( isset( $resized_images[ $post_id ]['sizes']['full'] ) ) {
							$suffix = 'full';
						} elseif ( isset( $resized_images[ $post_id ]['sizes']['low'] ) ) {
							$suffix = 'low';
						}
					} elseif ( $resolution === 'lightbox' ) {
						if ( isset( $resized_images[ $post_id ]['sizes']['full'] ) ) {
							$suffix = 'full';
						}
					}
					if ( isset( $suffix ) ) {
						$media_url = sbi_get_resized_uploads_url() . $resized_images[ $post_id ]['id'] . $suffix . '.jpg';
						return $media_url;
					}
				}
			}
		}

		if ( $account_type === 'personal' ) {
			switch ( $optimum_res ) {
				case 'thumb' :
					$media_url = $post['images']['thumbnail']['url'];
					break;
				case 'medium' :
					$media_url = $post['images']['low_resolution']['url'];
					break;
				default :
					$media_url = $post['images']['standard_resolution']['url'];
			}
		} else {
			$post_id = SB_Instagram_Parse::get_post_id( $post );

			// use resized images if exists
			if ( $optimum_res === 'full' && isset( $resized_images[ $post_id ]['id'] )
			     && $resized_images[ $post_id ]['id'] !== 'pending'
			     && $resized_images[ $post_id ]['id'] !== 'video'
			     && $resized_images[ $post_id ]['id'] !== 'error' ) {
				$media_url = sbi_get_resized_uploads_url() . $resized_images[ $post_id ]['id'] . 'full.jpg';
			} else {
				if ( SB_Instagram_GDPR_Integrations::doing_gdpr( $settings ) ) {
					return trailingslashit( SBI_PLUGIN_URL ) . 'img/thumb-placeholder.png';
				}
				$media_type = $post['media_type'];
				if ( $media_type === 'CAROUSEL_ALBUM'
				     || $media_type === 'VIDEO'
				     || $media_type === 'OEMBED' ) {
					if ( isset( $post['thumbnail_url'] ) ) {
						return $post['thumbnail_url'];
					} elseif ( $media_type === 'CAROUSEL_ALBUM' && isset( $post['media_url'] ) ) {
						return $post['media_url'];
					} elseif ( isset( $post['children'] ) ) {
						$i = 0;
						$full_size = '';
						foreach ( $post['children']['data'] as $carousel_item ) {
							if ( $carousel_item['media_type'] === 'IMAGE' && empty( $full_size ) ) {
								if ( isset( $carousel_item['media_url'] ) ) {
									$full_size = $carousel_item['media_url'];
								}
							} elseif ( $carousel_item['media_type'] === 'VIDEO' && empty( $full_size ) ) {
								if ( isset( $carousel_item['thumbnail_url'] ) ) {
									$full_size = $carousel_item['thumbnail_url'];
								}
							}

							$i++;
						}
						return $full_size;
					} else {
						if ( ! class_exists( 'SB_Instagram_Single' ) ) {
							return trailingslashit( SBI_PLUGIN_URL ) . 'img/thumb-placeholder.png';
						}
						//attempt to get
						$permalink = SB_Instagram_Parse::fix_permalink( SB_Instagram_Parse::get_permalink( $post ) );
						$single = new SB_Instagram_Single( $permalink );
						$single->init();
						$post = $single->get_post();

						if ( isset( $post['thumbnail_url'] ) ) {
							return $post['thumbnail_url'];
						} elseif ( isset( $post['media_url'] ) && strpos( $post['media_url'], '.mp4' ) === false ) {
							return $post['media_url'];
						}

						return trailingslashit( SBI_PLUGIN_URL ) . 'img/thumb-placeholder.png';
					}
				} else {
					if ( isset( $post['media_url'] ) ) {
						return $post['media_url'];
					}

					return trailingslashit( SBI_PLUGIN_URL ) . 'img/thumb-placeholder.png';
				}
			}

		}

		return $media_url;
	}

	/**
	 * Images are normally styles with the imgLiquid plugin
	 * with JavaScript. If this is disabled, the plugin will
	 * attempt to square all images using CSS.
	 *
	 * @param array $post
	 * @param array $settings
	 * @param array $resized_images
	 *
	 * @return string
	 *
	 * @since 2.0/5.0
	 * @since 2.1.1/5.2.1 added support for resized images
	 */
	public static function get_sbi_photo_style_element( $post, $settings, $resized_images = array() ) {
		if ( !$settings['disable_js_image_loading'] ) {
			return '';
		} else {
			$full_res_image = SB_Instagram_Display_Elements::get_optimum_media_url( $post, $settings, $resized_images );
			/*
			 * By setting the height to "0" the bottom padding can be used
			 * as a percent to square the images. Since it needs to be a percent
			 * this guesses what the percent would be based on static padding.
			 */
			$padding_bottom = '100%';
			if ( $settings['imagepaddingunit'] === '%' ) {
				$padding_bottom = 100 - ($settings['imagepadding'] * 2) . '%';
			} else {
				$padding_percent = $settings['imagepadding'] > 0 ? 100 - ($settings['cols'] / 2 * $settings['imagepadding'] / 5) : 100;
				$padding_bottom = $padding_percent . '%';
			}
			return ' style="background-image: url(&quot;' . esc_url( $full_res_image ) . '&quot;); background-size: cover; background-position: center center; background-repeat: no-repeat; opacity: 1;height: 0;padding-bottom: ' . esc_attr( $padding_bottom ) . ';"';
		}
	}

	/**
	 * Creates a style attribute that contains all of the styles for
	 * the main feed div.
	 *
	 * @param $settings
	 *
	 * @return string
	 */
	public static function get_feed_style( $settings ) {

		$styles = '';
		if ( ! empty( $settings['imagepadding'] )
		     || ! empty( $settings['background'] )
		     || ! empty( $settings['width'] )
		     || ! empty( $settings['height'] ) ) {
			$styles = ' style="';
			if ( ! empty( $settings['imagepadding'] ) ) {
				$styles .= 'padding-bottom: ' . ((int)$settings['imagepadding'] * 2) . esc_attr( $settings['imagepaddingunit'] ) . ';';
			}
			if ( ! empty( $settings['background'] ) ) {
				$styles .= 'background-color: rgb(' . esc_attr( sbi_hextorgb( $settings['background'] ) ). ');';
			}
			if ( ! empty( $settings['width'] ) ) {
				$styles .= 'width: ' . (int)$settings['width'] . esc_attr( $settings['widthunit'] ) . ';';
			}
			if ( ! empty( $settings['height'] ) ) {
				$styles .= 'height: ' . (int)$settings['height'] . esc_attr( $settings['heightunit'] ) . ';';
			}
			$styles .= '"';
		}
		return $styles;
	}

	/**
	 * Creates a style attribute for the sbi_images div
	 *
	 * @param $settings
	 *
	 * @return string
	 */
	public static function get_sbi_images_style( $settings ) {
		if ( ! empty ( $settings['imagepadding'] ) ) {
			return 'style="padding: '.(int)$settings['imagepadding'] . esc_attr( $settings['imagepaddingunit'] ) . ';"';
		}
		return '';
	}

	/**
	 * Creates a style attribute for the header. Can be used in
	 * several places based on the header style
	 *
	 * @param $settings
	 *
	 * @return string
	 */
	public static function get_header_text_color_styles( $settings ) {
		if ( ! empty( $settings['headercolor'] ) ) {
			return 'style="color: rgb(' . esc_attr( sbi_hextorgb( $settings['headercolor'] ) ). ');"';
		}
		return '';
	}

	/**
	 * Header icon and text size is styled using the class added here.
	 *
	 * @param $settings
	 *
	 * @return string
	 *
	 * @since 2.0.1/5.0
	 */
	public static function get_header_size_class( $settings ) {
		$header_size_class = in_array( strtolower( $settings['headersize'] ), array( 'medium', 'large' ) ) ? ' sbi_'.strtolower( $settings['headersize'] ) : '';
		return $header_size_class;
	}

	/**
	 * Creates a style attribute for the follow button. Can be in
	 * the feed footer or in a boxed header.
	 *
	 * @param $settings
	 *
	 * @return string
	 */
	public static function get_follow_styles( $settings ) {
		$styles = '';
		if ( ! empty( $settings['followcolor'] ) || ! empty( $settings['followtextcolor'] ) ) {
			$styles = 'style="';
			if ( ! empty( $settings['followcolor'] ) ) {
				$styles .= 'background: rgb(' . esc_attr( sbi_hextorgb( $settings['followcolor'] ) ) . ');';
			}
			if ( ! empty( $settings['followtextcolor'] ) ) {
				$styles .= 'color: rgb(' . esc_attr( sbi_hextorgb( $settings['followtextcolor'] ) ). ');';
			}
			$styles .= '"';
		}
		return $styles;
	}

	/**
	 * Creates a style attribute for styling the load more button.
	 *
	 * @param $settings
	 *
	 * @return string
	 */
	public static function get_load_button_styles( $settings ) {
		$styles = '';
		if ( ! empty( $settings['buttoncolor'] ) || ! empty( $settings['buttontextcolor'] ) ) {
			$styles = 'style="';
			if ( ! empty( $settings['buttoncolor'] ) ) {
				$styles .= 'background: rgb(' . esc_attr( sbi_hextorgb( $settings['buttoncolor'] ) ) . ');';
			}
			if ( ! empty( $settings['buttontextcolor'] ) ) {
				$styles .= 'color: rgb(' . esc_attr( sbi_hextorgb( $settings['buttontextcolor'] ) ). ');';
			}
			$styles .= '"';
		}
		return $styles;
	}

	/**
	 * Returns the html for an icon based on the kind requested
	 *
	 * @param string $type kind of icon needed (ex "video" is a play button
	 * @param string $icon_type svg or font
	 *
	 * @return string
	 *
	 * @since 2.0/5.0
	 */
	protected static function get_basic_icons( $type, $icon_type ) {
		if ( $type === 'carousel' ) {
			if ( $icon_type === 'svg' ) {
				return '<svg class="svg-inline--fa fa-clone fa-w-16 sbi_lightbox_carousel_icon" aria-hidden="true" aria-label="Clone" data-fa-proƒcessed="" data-prefix="far" data-icon="clone" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
	                <path fill="currentColor" d="M464 0H144c-26.51 0-48 21.49-48 48v48H48c-26.51 0-48 21.49-48 48v320c0 26.51 21.49 48 48 48h320c26.51 0 48-21.49 48-48v-48h48c26.51 0 48-21.49 48-48V48c0-26.51-21.49-48-48-48zM362 464H54a6 6 0 0 1-6-6V150a6 6 0 0 1 6-6h42v224c0 26.51 21.49 48 48 48h224v42a6 6 0 0 1-6 6zm96-96H150a6 6 0 0 1-6-6V54a6 6 0 0 1 6-6h308a6 6 0 0 1 6 6v308a6 6 0 0 1-6 6z"></path>
	            </svg>';
			} else {
				return '<i class="fa fa-clone sbi_carousel_icon" aria-hidden="true"></i>';
			}

		} elseif ( $type === 'video' ) {
			if ( $icon_type === 'svg' ) {
				return '<svg style="color: rgba(255,255,255,1)" class="svg-inline--fa fa-play fa-w-14 sbi_playbtn" aria-label="Play" aria-hidden="true" data-fa-processed="" data-prefix="fa" data-icon="play" role="presentation" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M424.4 214.7L72.4 6.6C43.8-10.3 0 6.1 0 47.9V464c0 37.5 40.7 60.1 72.4 41.3l352-208c31.4-18.5 31.5-64.1 0-82.6z"></path></svg>';
			} else {
				return '<i class="fa fa-play sbi_playbtn" aria-hidden="true"></i>';
			}
		} elseif ( $type === 'instagram' ) {
			if ( $icon_type === 'svg' ) {
				return '<svg class="svg-inline--fa fa-instagram fa-w-14" aria-hidden="true" data-fa-processed="" aria-label="Instagram" data-prefix="fab" data-icon="instagram" role="img" viewBox="0 0 448 512">
	                <path fill="currentColor" d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z"></path>
	            </svg>';
			} else {
				return '<i class="fa fab fa-instagram" aria-hidden="true"></i>';
			}
		} elseif ( $type === 'newlogo' ) {
			if ( $icon_type === 'svg' ) {
				return '<svg class="sbi_new_logo fa-instagram fa-w-14" aria-hidden="true" data-fa-processed="" aria-label="Instagram" data-prefix="fab" data-icon="instagram" role="img" viewBox="0 0 448 512">
	                <path fill="currentColor" d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z"></path>
	            </svg>';
			} else {
				return '<i class="sbi_new_logo"></i>';
			}
		} else {
			return '';
		}
	}

}