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
                            <div class="row">
                                <div class="col-lg-3">
                                    <?php if(has_post_thumbnail()): ?>
                                        <img src="<?php the_post_thumbnail_url(); ?>" class= "img-fluid">
                                    <?php endif; ?>
                                </div>
                                <div class="col-lg-9">
                                    <?php the_title() ?> 
                                    <?php the_excerpt(); ?>
                                    <?php get_post_meta($post->ID, 'blog_id', true); // Gets the Blog ID?>
                                    <a href=" <?php the_permalink() ?>">Read More</a>
                                </div>
                            </div>
                        
                    <?php endif; endforeach;?>
                    <div class="row" style='display:flex; justify-content:center;'>
                    <?php
                    foreach ( $posts as $post ) : 
                        if (get_post_meta($post->ID, 'blog_id', true) != 1): ?>
                            <div class="col-lg-<?php echo floor(12/($totalPosts-1)); ?>">
                                <?php if(has_post_thumbnail()): ?>
                                    <img src="<?php the_post_thumbnail_url(); ?>" class= "img-fluid">
                                <?php endif; ?>
                                 <?php the_title() ?> 
                                <?php get_post_meta($post->ID, 'blog_id', true); // Gets the Blog ID?>
                                <a href=" <?php the_permalink() ?>">Read More</a>
                            </div>     
                <?php endif; endforeach; 
                    echo '</div>';
                }

                wp_reset_postdata();  
                
            }    
        ?>
    </div>
</section>