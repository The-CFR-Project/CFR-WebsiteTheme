<section id="blogs-series-single">
    <style type="text/css">   @import url("<?php echo get_template_directory_uri(); ?>/css/blogs-css/blog-series-single.css"); </style>
    <div class="blogs-single-container">   
        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
            <?php
                $postCategories = get_the_category(); // Gets categories of the post
                foreach ($postCategories as $cat){ // Loops through the categories of the current post
                    $postCategory = $cat -> name;
                    echo $postCategory;
                }
            ?>

            <h3><?php the_title();?></h3>
            <?php echo get_the_date(); ?>

            <?php if(has_post_thumbnail()): ?>
                    <img src="<?php the_post_thumbnail_url(); ?>" class="img-fluid img-thumbnail">
            <?php endif; ?> 

            <?php the_content(); ?>
            <?php echo get_the_author_meta("first_name") . ' ' . get_the_author_meta("last_name"); ?>
            <?php echo get_post_meta($post -> ID, 'blog_id', true); ?>

            <?php comments_template(); ?>

        <?php endwhile; endif; ?>
    </div>
</section>
