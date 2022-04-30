<?php get_header('cfrtheme', ['title' => get_the_title() . ' - The CFR Project']);?>

    <!---------------------- Single Blog Page ---------------------->
    <section>

    </section>
    <section id="blogs-single">
        <style type="text/css">   @import url("<?php echo get_template_directory_uri(); ?>/assets/css/blogs-css/blog-single.css"); </style>
        <style type="text/css">   @import url("<?php echo get_template_directory_uri(); ?>/assets/css/blogs-css/latest-blogs.css"); </style>

        <div class="blogs-single-container">
            <?php $colors = ['#f7b595', '#f67280', '#c06c84', '#6f5980', '#35b0ab', '#246b81', '#004c65', '#ffcc66'] ?>
            <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                <?php $post_color = $colors[ array_rand( $colors ) ]; ?>
                <div class="blog-single-header">
                    <?php if(has_post_thumbnail()): ?>
                        <img src="<?php the_post_thumbnail_url(); ?>" class="img-fluid">
                    <?php endif; ?>
                    <div class="text">
                        <input type="text" class='blog-single-header-accessibility-input'>
                        <h3><?php the_title();?></h3>
                        <div class="line-lmao"></div>
                        <p><?php echo get_the_author_meta("first_name") . ' ' . get_the_author_meta("last_name"); ?></p>
                    </div>
                </div>
                <div id="link-copied-alert">
                    <strong>Link Copied To Clipboard!</strong>
                    <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                </div>

                <div class="blog-sidebar">
                    <div class="author-info">
                        <?php echo '<div class="blog-author-pic" style="background-color:'.$post_color.'"> '; ?>
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/author-placeholder.svg" alt="author">
                        <?php echo '</div>' ?>
                        <div class="blog-info-container">
                            <?php echo "<p class='status'>".get_post_status()."ed</p>"; ?>
                            <?php echo "<p class='date'>".get_the_date('j M. Y')."</p>"; ?>
                        </div>

                        <div id="sidebar-primary" class="sidebar">
                            <div class="socials row">
                                <?php
                                $socialItems = wp_get_nav_menu_items(get_nav_menu_locations()['footer-social']);
                                foreach ( $socialItems as $footerItem ) {
                                    echo "<div class='col-3 col-md-6'><a href='" . $footerItem->url . "' class='social-icon-link'><img src='" . get_template_directory_uri() . "/assets/images/" . $footerItem->title . "-icon.svg' class='sidebar-social-icon'></a></div>";
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="blog-content">
                    <hr style="max-width: 900px; width: 80%;margin: 50px auto;height: 2px;">
                    <div style="max-width: 900px;">
                        <div class="blog-content-text">
                            <h4><?php the_title();?></h4>
                            <h5><?php echo get_the_author_meta("first_name") . ' ' . get_the_author_meta("last_name");?></h5>
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

            </script>

        </div>
    </section>

    <div class="instawall-section-container container-fluid" style="margin-top: 200px;">
        <div class="bedrock-container">
            <div>
                <img class="bedrock-img" src="<?php echo get_template_directory_uri();?>/assets/images/404rock.svg">
            </div>
        </div>
    </div>

<?php get_footer();?>