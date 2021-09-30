<?php
/**
 * Copy & Delete Posts – default menu.
 *
 * @package CDP
 * @subpackage SendingVariables
 * @author CopyDeletePosts
 * @since 1.0.0
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

// Exit if accessed directly.
if (!defined('ABSPATH')) exit;

/** –– **\
 * There are constant (but dynamic per blog) variables.
 * @since 1.0.0
 */
function cdp_vars($hideTT = false, $cdp_plug_url = 'x', $post_id = false, $parent = false, $notify = false) {
  ?>

  <script>
    if (typeof ajaxurl === 'undefined') ajaxurl = '<?php echo esc_url(admin_url('admin-ajax.php')); ?>';
  </script>
  <div class="cdp-copy-alert-success" style="top: -28px; opacity: 0; display: none;">
    <img src="<?php echo $cdp_plug_url ?>/assets/imgs/copy.png" alt="<?php _e('Successfull copy image', 'copy-delete-posts'); ?>">
  </div>
  <div class="cdp-copy-loader-overlay" style="opacity: 0">
    <div class="cdp-text-overlay">
      <h1 style="color: white; font-size: 25px;"><?php _e('Please wait, copying in progress...', 'copy-delete-posts'); ?></h1>
      <p>
        <?php _e('If you’re making a lot of copies it can take a while
        <br>(up to 5 minutes if you’re on a slow server).', 'copy-delete-posts'); ?>
      </p>
      <span><?php _e('Average time is 8 copies per second.', 'copy-delete-posts'); ?></span>
    </div>
    <div class="cdp-spinner"></div>
  </div>
  <input type="text" hidden id="cdp-purl" style="display: none; visibility: hidden;" value="<?php echo $cdp_plug_url ?>">
  <?php if ($hideTT == true): ?>
  <input type="text" hidden id="cdp-hideTT" style="display: none; visibility: hidden;" value="true">
  <?php endif; ?>

  <?php if ($post_id != false): ?>
  <input type="text" hidden id="cdp-current-post-id" style="display: none; visibility: hidden;" value="<?php echo $post_id ?>">
  <?php endif;?>

  <?php if ($parent != false): ?>
  <input type="text" hidden id="cdp-original-post" style="display: none; visibility: hidden;" data-cdp-parent="<?php echo $parent['title'] ?>" data-cdp-parent-url="<?php echo $parent['link'] ?>">
  <?php endif;?>

  <?php
}
/** –– **/
