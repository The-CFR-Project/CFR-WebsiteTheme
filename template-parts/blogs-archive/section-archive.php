<!---------------------- Blogs Archive Page ---------------------->

<section id="blogs-archive">
<style type="text/css">   @import url("<?php echo get_template_directory_uri(); ?>/assets/css/blogs-css/latest-blogs.css"); </style>
<div class="blogs-archive-container">

    <?php $count = wp_count_posts()->publish;?>

    <!-- Latest Posts -->
    <div id="blogs-archive-latest">
    <?php $i = 1; ?>
    <div class="row blogs-archive-post">
        <?php
        $category_id = get_cat_ID('Blog');
        $q = ['cat' => $category_id, 'post_status' => 'publish'];
        $blogs = (query_posts($q));
        if ( have_posts() ) : while ( have_posts() ) : the_post();?>

            <!--  If the post is the latest one  -->
            <?php if($i == 1): ?>
                    <div class="blogs-archive-post-latest">

                        <a href="<?php the_permalink(); ?>" class="blogs-archive-permalink blogs-archive-post-latest-tn-link">
                            <div class="blogs-archive-post-latest-tn col-md-3">
                                <?php if(has_post_thumbnail()): ?>
                                    <img src="<?php the_post_thumbnail_url(); ?>" class= "img-fluid">
                                <?php endif; ?>
                            </div>
                        </a>    
                        <a href="<?php the_permalink(); ?>" class="blogs-archive-permalink blogs-archive-post-latest-excerpt-link">
                            <div class="blogs-archive-post-latest-excerpt col-md-6">
                                <p>Spotlighted</p>
                                <h3><?php the_title();?></h3>
                                <?php echo "<p>" . get_the_author_meta("first_name") . ' ' . get_the_author_meta("last_name") . "</p>";?>
                                <?php echo "<p>".get_the_date('j M Y')."</p>"; ?>
                            </div>
                        </a>

                    </div>
            <?php endif; ?>

            <!--  Loops over next 9 latest posts  -->
            <?php if($i >= 2 && $i <= 10): ?>

                <a href="<?php the_permalink(); ?>" class="col-md-4 blogs-archive-post-grid-container">
                    <?php  echo "<div class='blogs-archive-post-grid-". ($i-1) ." blogs-archive-post-grid'>" ?>
                        <?php if(has_post_thumbnail()): ?>
                            <div class="blogs-archive-post-grid-img-container">
                                <img src="<?php the_post_thumbnail_url(); ?>" class= "img-fluid">
                            </div>
                        <?php endif; ?>
                        <div class="blogs-archive-post-text">
                            <h3><?php the_title();?></h3>
                            <p><?php echo "<p>" . get_the_author_meta("first_name") . ' ' . get_the_author_meta("last_name") . "</p>";?></p>
                        </div>
                    </div>
                </a>

            <?php endif; ?>

        <?php $i++; endwhile; endif;?>
        <?php echo do_shortcode('[ajax_load_more container_type="div" post_type="post" posts_per_page="6" pause="true" images_loaded="true" scroll="false" transition_container_classes="row" button_label="Load More Blogs" button_loading_label="Loading..." button_done_label="Blubby is out of Posts"]'); ?>

    </div>

    <div class="blogs-archive-sidebar">
        <div class="blogs-sidebar-socials-icons">
            <?php
                $socialItems = wp_get_nav_menu_items(get_nav_menu_locations()['footer-social']);
                    foreach ( $socialItems as $footerItem ) {
                    echo "<a href='" . $footerItem->url . "' class='blogs-sidebar-socials-icon-link'><img src='" . get_template_directory_uri() . "/assets/images/" . $footerItem->title . "-icon.svg' class='blogs-sidebar-socials-icon'></a>";
                    }
            ?>
        </div>
        <div class="blogs-sidebar-blogs-container">
            <h5 class='blogs-sidebar-blogs-title'>recommended</h5>
            <div class="blogs-sidebar-blogs">
                <?php $query = new WP_Query( array ( 'orderby' => 'rand', 'posts_per_page' => '3' ) );?>
                <?php
                //Create WordPress Query with 'orderby' set to 'rand' (Random)
                $the_query = new WP_Query( array ( 'orderby' => 'rand', 'posts_per_page' => '3' ) );
                // output the random post
                while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
                <div class="blogs-sidebar-blogs-blog">
                    <a href="<?php the_permalink(); ?>">
                        <?php if(has_post_thumbnail()): ?>
                            <img src="<?php the_post_thumbnail_url(); ?>" class= "img-fluid">
                        <?php endif; ?>
                        <h3><?php the_title() ?></h3>
                        <p style='color:var(--red3)'><?php echo get_the_author_meta("first_name") . ' ' . get_the_author_meta("last_name") ;?></p>
                        <?php //echo "<p style='color:var(--red3)'>".get_the_date('d M')."</p>"; ?>
                    </a>
                </div>
                <?php endwhile;

                // Reset Post Data
                wp_reset_postdata();
                ?>
            </div>
        </div>

    </div>

    </div>
</div>

</section>
