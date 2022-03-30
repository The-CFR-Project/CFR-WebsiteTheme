<section></section>
<section id="blogs-series-single">
    <style type="text/css">   @import url("<?php echo get_template_directory_uri(); ?>/assets/css/blogs-css/blog-series-single.css"); </style>
    <textarea id="the-permalink" style="display:none;"><?php the_permalink(); ?></textarea>
    <?php $colors = ['#f7b595', '#f67280', '#c06c84', '#6f5980', '#35b0ab', '#246b81', '#004c65', '#ffcc66'] ?>    
    <div class="blogs-single-container">   
        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
            <?php
                $postCategories = get_the_category(); // Gets categories of the post
                foreach ($postCategories as $cat){ // Loops through the categories of the current post
                    $postCategory = $cat -> name;
                    echo $postCategory;
                }
            ?>

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
                                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/author-placeholder.svg" alt="author">
                                    <?php echo '</div>' ?>
                                    <div class="blog-info-container">
                                            <?php echo "<p class='status'>".get_post_status()."ed</p>"; ?>
                                            <?php echo "<p class='date'>".get_the_date('j M. Y')."</p>"; ?>
                                    </div>
                                    <div class="share-like-container">
                                            <div id="share-copy-link"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/share-icon.svg" alt="share"></div>
                                            <!-- <div id="like-heart">&#9829;</div> -->
                                    </div>
                            </div>

                            <div id="sidebar-primary" class="sidebar">
                                <div class="socials">
                                    <?php
                                    $socialItems = wp_get_nav_menu_items(get_nav_menu_locations()['footer-social']);
                                    foreach ( $socialItems as $footerItem ) {
                                        echo "<a href='" . $footerItem->url . "'><img src='" . get_template_directory_uri() . "/assets/images/" . $footerItem->title . "-icon.svg' class='sidebar-social-icon'></a>";
                                    }
                                    ?>
                                </div>
                                <div class="blogs">
                                    <ul>
                                    <?php
                                        // echo the_taxonomies();
                                        $terms = get_the_terms( $post->ID, 'series_name' );
                                        if ($terms) {
                                            foreach($terms as $term) {
                                                $thisSeries = $term->name;
                                            } 
                                        } 
                                        $thisBlogID = get_post_meta( $post->ID, 'blog_id', true );
                                        $args = array(
                                            'post_type' => 'blog_series',
                                            'order' => 'ASC',
                                            'tax_query' => array(
                                                array(
                                                    'taxonomy' => 'series_name',
                                                    'field'    => 'slug',
                                                    'terms'    => $thisSeries,
                                                ),
                                            ),
                                        );
                                        $query = new WP_Query( $args );

                                        $colors = ['--blue2','--blue3', '--red2', '--red3', '--red4'];
                                        $i = 0;

                                        while ( $query->have_posts() ) : $query->the_post();
                                        $blogBlogID = get_post_meta( get_the_ID(), 'blog_id', true );
                                        if ($blogBlogID != $thisBlogID){
                                            echo "<li>";
                                                if (has_post_thumbnail()){
                                                    echo "<a href='";
                                                    echo the_permalink();
                                                    echo "'>";
                                                        echo "<img src='";
                                                        echo the_post_thumbnail_url(); ;
                                                        echo "'>";
                                                    echo "</a>";
                                                }
                                                echo "<a class='sidebar-blog-title' href='";
                                                echo the_permalink();
                                                echo "'>Part ". $blogBlogID ." | ";
                                                    echo the_title();
                                                echo "</a>";
                                                echo "<p style='color:var(". $colors[$i] .")'>by ";
                                                    echo get_the_author_meta("first_name") . ' ' . get_the_author_meta("last_name");
                                                echo "</p>";    
                                                echo "<p style='color:var(". $colors[$i] .")'>";    
                                                    echo get_the_date('F, d Y');
                                                echo "</p>";
                                            echo "</li>";

                                            $i ++;
                                            if ($i == 4){$i = 0;}
                                        }
                                        endwhile;
                                    ?>
                                    </ul>
                                </div>
                            </div>
                    </div>
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
    </div>

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

            // var heart = document.getElementById('like-heart');
            // var click = 0;
            // heart.addEventListener('click', function(){
            //         click += 1;
            //         if (click % 2 == 1) {
            //                 heart.style.color = "var(--red2)";
            //         } else {
            //                 heart.style.color = "black";
            //         }
            // });

    </script>
</section>
