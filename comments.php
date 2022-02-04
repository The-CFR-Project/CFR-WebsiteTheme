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
        
        <div class="comments-list">
            <?php 
            $args = array(
                'max-depth' => '3',
                'style' => 'ul', 
                'type' => 'all', 
                'reverse_top_level' => true,
                'echo' => true
            );
            wp_list_comments($args); 
            ?>
        </div>

    <?php endif;    ?>

    


    <script>
        var textArea = document.getElementById('comment');
        textArea.placeholder = "A penny for your thoughts?";
        
        var commentator = document.getElementById("author");
        commentator.placeholder = "Name";

        var commentatorMail = document.getElementById("email");
        commentatorMail.placeholder = "E-mail";

        var submitBtn = document.getElementById("submit");
        submitBtn.className += " btn btn-block";
    </script>
</div>
