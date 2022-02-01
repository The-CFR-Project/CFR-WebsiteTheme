<section id="blogs-archive-series">
    <style type="text/css">   @import url("<?php echo get_template_directory_uri(); ?>/css/blogs-css/blog-series-archive.css"); </style>
    <div class="blogs-series-container">
        <div class="blogs-series-heading">series</div>
        <?php
            // Gets all the series names from the series taxonomy
            $terms = get_terms( array(
                'taxonomy' => 'series_name',
                'hide_empty' => false,
            ) );
            echo '';
            foreach ($terms as $term) { //Loops over each series name 
                echo '<h4 class="blogs-series-name">'.$term -> name.'</h4>';
                //query which gets posts from each series name
                $posts = get_posts([
                    'post_type' => 'blog_series',
                    'post_status' => 'publish',
                    'series_name' => $term->name,
                    'numberposts' => -1,
                    ]);
                $posts = array_reverse($posts);    
                $totalPosts = count($posts);  
                
                if ( $posts ) { //Checks if there are posts in the series name
                    
                    foreach ( $posts as $post ) : //Loops over all the posts
                        setup_postdata( $post ); 
                        if (get_post_meta($post->ID, 'blog_id', true) == 1): ?>
                            <div class="row blog-series-first-container">
                                <div class="col-lg-4 blog-series-tn">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php if(has_post_thumbnail()): ?>
                                            <img src="<?php the_post_thumbnail_url(); ?>" class= "img-fluid">
                                        <?php endif; ?>
                                    </a>
                                </div>
                                <div class="col-lg-8 blog-series-first-text">
                                    <?php echo '<h3>Part '.get_post_meta($post->ID, 'blog_id', true).' | '; echo the_title()."</h3>";?> 
                                    <?php the_excerpt(); ?>
                                    
                                    <a href=" <?php the_permalink() ?>"><p>Read More</p></a>
                                </div>
                            </div>
                        
                    <?php endif; endforeach;?>
                    <div class="row blog-series-rest-container" style='display:flex;'>
                        <?php
                        foreach ( $posts as $post ) : 
                            if (get_post_meta($post->ID, 'blog_id', true) != 1): ?>
                                <div class="col-lg-3 blog-series-rest"><?php //echo floor(12/($totalPosts-1)); ?>
                                    <div class="row">
                                        <div class="col-lg-12 blog-series-tn">
                                            <a href="<?php the_permalink(); ?>">
                                                <?php if(has_post_thumbnail()): ?>
                                                    <img src="<?php the_post_thumbnail_url(); ?>" class= "img-fluid blog-series-rest-img">
                                                <?php endif; ?>
                                            </a>
                                        </div>
                                        <div class="blog-series-rest-text col-lg-12">
                                            <h3>Part <?php echo get_post_meta($post->ID, 'blog_id', true); ?> | <?php echo the_title(); ?></h3>
                                            <a href=" <?php the_permalink() ?>"><p>Read More</p></a>
                                        </div>
                                    </div>    
                                </div>     
                        <?php endif; endforeach; 
                    echo '</div>';
                }

                wp_reset_postdata();  
                
            }    
        ?>
    </div>
</section>