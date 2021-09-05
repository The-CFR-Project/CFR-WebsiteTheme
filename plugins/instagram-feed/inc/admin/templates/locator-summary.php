<?php
/**
 * Custom Feeds for Instagram Feed Locator Summary Template
 * Creates the HTML for the feed locator summary
 *
 * @version 5.11 Custom Feeds for Instagram Pro by Smash Balloon
 *
 */
// Don't load directly
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}
$database_settings = sbi_get_database_settings();
?>
<div class="sbi-feed-locator-summary-wrap">
    <h3><?php esc_html_e( 'Feed Finder Summary', 'instagram-feed' ); ?></h3>
    <p><?php esc_html_e( 'The table below shows a record of all feeds found on your site. A feed may not show up here immediately after being created.', 'instagram-feed' ); ?></p>
	<?php
	if ( ! empty( $locator_summary ) ) : ?>

		<?php foreach ( $locator_summary as $locator_section ) :
			if ( ! empty( $locator_section['results'] ) ) : ?>
                <div class="sbi-single-location">
                    <h4><?php echo esc_html( $locator_section['label'] ); ?></h4>
                    <table class="widefat striped">
                        <thead>
                        <tr>
                            <th><?php esc_html_e( 'Type', 'instagram-feed' ); ?></th>
                            <th><?php esc_html_e( 'Sources', 'instagram-feed' ); ?></th>
                            <th><?php esc_html_e( 'Shortcode', 'instagram-feed' ); ?></th>
                            <th><?php esc_html_e( 'Location', 'instagram-feed' ); ?></th>
                        </tr>
                        </thead>
                        <tbody>

						<?php

                        $atts_for_page = array();
                        foreach ($locator_section['results'] as $result) :
                            $should_add = true;
                            if (!empty($atts_for_page[$result['post_id']])) {
                                foreach ($atts_for_page[$result['post_id']] as $existing_atts) {
                                    if ($existing_atts === $result['shortcode_atts']) {
                                        $should_add = false;
                                    }
                                }
                            }
                            if ($should_add) {
                                $atts_for_page[$result['post_id']][] = $result['shortcode_atts'];

							$shortcode_atts = json_decode( $result['shortcode_atts'], true );
							$shortcode_atts = is_array( $shortcode_atts ) ? $shortcode_atts : array();

							if ( class_exists( 'SB_Instagram_Settings_Pro' ) ) {
								$settings_obj = new SB_Instagram_Settings_Pro( $shortcode_atts, $database_settings );
							} else {
								$settings_obj = new SB_Instagram_Settings( $shortcode_atts, $database_settings );
							}
							$settings = $settings_obj->get_settings();
							$settings_obj->set_feed_type_and_terms();
							$display_terms = $settings_obj->feed_type_and_terms_display();
							$comma_separated = implode(', ', $display_terms );
							$display = $comma_separated;
							if ( strlen( $comma_separated ) > 31 ) {
								$display = '<span class="sbi-condensed-wrap">' . esc_html( substr( $comma_separated, 0, 30 ) ) . '<a class="sbi-locator-more" href="JavaScript:void(0);">...</a></span>';
								$comma_separated = '<span class="sbi-full-wrap">' . esc_html( $comma_separated ) . '</span>';
							} else {
								$comma_separated = '';
							}
							$type = isset( $settings['type'] ) ? $settings['type'] : 'user';
							$full_shortcode_string = '[instagram-feed';
							foreach ( $shortcode_atts as $key => $value ) {
								$full_shortcode_string .= ' ' . esc_html( $key ) . '="' . esc_html( $value ) . '"';
							}
							$full_shortcode_string .= ']';
							?>
                            <tr>
                                <td><?php echo esc_html( $type ); ?></td>
                                <td><?php echo $display . $comma_separated; ?></td>
                                <td>
                                    <span class="sbi-condensed-wrap"><a class="sbi-locator-more" href="JavaScript:void(0);"><?php esc_html_e( 'Show', 'instagram-feed' ); ?></a></span>
                                    <span class="sbi-full-wrap"><?php echo $full_shortcode_string; ?></span>
                                </td>
                                <td><a href="<?php echo esc_url( get_the_permalink( $result['post_id'] ) ); ?>" target="_blank" rel="noopener"><?php echo esc_html( get_the_title( $result['post_id'] ) ); ?></a></td>
                            </tr>
						<?php 
                            }
                        endforeach; ?>


                        </tbody>
                    </table>
                </div>

			<?php endif;
		endforeach;
	else: ?>
        <p><?php esc_html_e( 'Locations of your feeds are currently being detected. You\'ll see more information posted here soon!', 'instagram-feed' ); ?></p>
	<?php endif; ?>
</div>