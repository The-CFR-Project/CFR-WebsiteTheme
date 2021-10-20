<!---------------------- Single Blog Page ---------------------->

<div class="blogs-single-container">  
        <!-- <div id="sidebar-primary" class="sidebar">
        <?php //if ( is_active_sidebar( 'general-sidebar' ) ) : ?>
                <?php //dynamic_sidebar( 'general-sidebar' ); ?>
        <?php //endif; ?>
        </div>  -->
    <style type="text/css">   @import url("<?php echo get_template_directory_uri(); ?>/css/blogs-css/blog-single.css"); </style>
    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
            <div class="blog-single-header">
                <?php if(has_post_thumbnail()): ?>
                        <img src="<?php the_post_thumbnail_url(); ?>" class="img-fluid">
                <?php endif; ?>
                <div class="text">
                        <h3><?php the_title();?></h3>   
                        <p><?php echo 'By ' . get_the_author_meta("first_name") . ' ' . get_the_author_meta("last_name"); ?></p>
                </div>
            </div>     
            
            <div class="blog-content row">
                    <div class="col-lg-3">

                    </div>
                    <div class="col-lg-9">
                            <div class="blog-content-text">
                                <?php the_content(); ?>
                                <?php echo get_the_date(); ?>   
                            </div>
                    </div>
            </div>
            



            
            

            <?php comments_template(); ?>

    <?php endwhile; endif; ?>
</div>