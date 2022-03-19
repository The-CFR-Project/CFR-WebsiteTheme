<?php if (post_password_required()){return;} ?>

<div id="comments" class='comments-container'>
	<style type="text/css">   @import url("<?php echo get_template_directory_uri(); ?>/assets/css/blogs-css/blog-comments.css"); </style>

	<div class="comment-form-container">
		<?php comment_form(); ?>
		<div class="comments-graphics">
			<img src="<?php echo get_template_directory_uri(); ?>/assets/images/blog-comments-envelope.svg" alt="" class="open-close-envelope">
		</div>
	</div>
	
	<?php if (have_comments()): ?>

		<?php if (!comments_open() && get_comments_number()): ?>
			<p class="no-comments"><?php esc_html_e('oops! seems like the comments are closed :(', 'cfrtheme'); ?></p>
		<?php endif; ?>
		
		<?php
		function create_comments($comment, $args, $depth) {
			$GLOBALS['comment'] = $comment; ?>
			<li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
				<article id="comment-<?php comment_ID(); ?>" class = "comment-body">
					<footer class="comment-meta">
						<div class="comment-author vcard">
							<?php echo get_avatar($comment,$size='32'); ?>
							<?php printf(__('<b class="fn">%s</b> <span class="says">says:</span>'), get_comment_author()) ?>
						</div>
						<!-- .comment-author -->
						<?php if ($comment->comment_approved == '0') : ?>
							<em><?php _e('Your comment is awaiting moderation.') ?></em>
							<br>
						<?php endif; ?>
						<div class="comment-metadata">
							<a href="<?php echo htmlspecialchars(get_comment_link($comment->comment_ID)) ?>"><time><?php printf(__('%1$s at %2$s'), get_comment_date(), get_comment_time()) ?></time></a>
							<?php edit_comment_link(__('(Edit)'),'  ','') ?>
						</div>
						<!-- .comment-metadata -->
					</footer>
					<!-- .comment-meta -->
					<div class="comment-content">
							<p>
								<?php echo htmlentities(get_comment_text( $comment, $args )) ?>
							</p>
					</div>
					<!-- .comment-content -->
					<div class="reply">
						<?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
					</div>
				</article>
				<!-- .comment-body -->
			</li>
		<?php
		}
		?>
		<div class="comments-list">
			<?php 
			$args = array(
				'max-depth' => '3',
				'style' => 'ul',
				'callback' => 'create_comments',
				'type' => 'all',
				'reverse_top_level' => true,
				'echo' => false
			);
			echo wp_list_comments($args);
			?>
		</div>

	<?php endif;?>
	<script type = "text/javascript">
		$('#comment').attr("placeholder", "A penny for your thoughts?");
		<?php if (!is_user_logged_in()): ?>
		$("#author").attr("placeholder", "Name");
		$("#email").attr("placeholder", "E-mail");
		$("#submit").addClass("btn btn-block");
		<?php endif; ?>
	</script>
</div>
