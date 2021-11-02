<!---------------------- Single Blog Page ---------------------->

<div class="blogs-single-container">  
        
    <style type="text/css">   @import url("<?php echo get_template_directory_uri(); ?>/css/blogs-css/blog-single.css"); </style>
    <style type="text/css">   @import url("<?php echo get_template_directory_uri(); ?>/css/blogs-css/latest-blogs.css"); </style>

    <textarea id="the-permalink" style="display:none;"><?php the_permalink(); ?></textarea>
    <?php $colors = ['#f7b595', '#f67280', '#c06c84', '#6f5980', '#35b0ab', '#246b81', '#004c65', '#ffcc66'] ?>
    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
        <?php $post_color = $colors[ array_rand( $colors ) ]; ?>
            <div class="blog-single-header">
                <?php if(has_post_thumbnail()): ?>
                        <img src="<?php the_post_thumbnail_url(); ?>" class="img-fluid">
                <?php endif; ?>
                <div class="text">
                        <h3><?php the_title();?></h3>  
                        <div class="line-lmao"></div> 
                        <p><?php echo get_the_author_meta("first_name") . ' ' . get_the_author_meta("last_name"); ?></p>
                </div>
            </div>     
            <div id="link-copied-alert">
                <strong>Link Copied To Clipboard!</strong>
                <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
            </div>
            
            <div class="blog-content row">
                <div class="col-lg-3 blog-sidebar">
                        <div class="author-info">
                                <?php echo '<div class="blog-author-pic" style="background-color:'.$post_color.'"> '; ?>   
                                        <img src="<?php echo get_template_directory_uri(); ?>/images/author-placeholder.svg" alt="author">
                                <?php echo '</div>' ?>
                                <div class="blog-info-container">
                                        <?php echo "<p class='status'>".get_post_status()."ed</p>"; ?>
                                        <?php echo "<p class='date'>".get_the_date('j M. Y')."</p>"; ?>
                                </div>  
                                <div class="share-like-container">
                                        <div id="share-copy-link"><img src="<?php echo get_template_directory_uri(); ?>/images/share-icon.svg" alt="share"></div>
                                        <div id="like-heart">&#9829;</div> 
                                </div>  
                        </div>

                        <div id="sidebar-primary" class="sidebar">
                        <?php if ( is_active_sidebar( 'blog-single-sidebar' ) ) : ?>
                                <?php dynamic_sidebar( 'blog-single-sidebar' ); ?>
                        <?php endif; ?>
                        </div> 
                </div>
                <?php //if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                <div class="col-lg-9">
                        <div class="blog-content-text">
                        <?php the_content(); ?>
                        </div>
                </div>
            </div>

            <div class="comments-section-container">
                <?php  
                if ( comments_open() || get_comments_number() ) :
                        comments_template();
                endif;         
                ?>
            </div>


    <?php endwhile; endif; ?>

    <script>
            var alert = document.getElementById("link-copied-alert");
            alert.style.display = 'none';

            var shareButton = document.getElementById('share-copy-link');
            shareButton.onclick = function() {
                        let text = document.getElementById("the-permalink").value;
                        navigator.clipboard.writeText(text)
                        .then(() => {
                                alert.style.display = 'flex';
                        })
                        .catch(err => {
                                alert.style.content = "There was a problem, couldn't copy link :("
                                alert.style.display = 'flex';
                        });
                }

            var heart = document.getElementById('like-heart');
            var click = 0;
            heart.addEventListener('click', function(){
                click += 1;
                if (click % 2 == 1) {
                        heart.style.color = "var(--red2)";
                } else {
                        heart.style.color = "black";  
                }
            });    

    </script>

</div>