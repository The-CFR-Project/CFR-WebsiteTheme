<?php get_header();?>

<style type="text/css">@import url("<?php echo get_template_directory_uri(); ?>/assets/css/homepage-css/home-banner.css");</style>
<style type="text/css">@import url("<?php echo get_template_directory_uri(); ?>/assets/css/blogs-css/blog-archive.css");</style>

<?php $recent_args = array(
"posts_per_page" => 5,
"orderby"        => "date",
"order"          => "DESC"
);
$recent_posts = new WP_Query( $recent_args );
?>

<section id="blogs-carousel">
    <div class="header-slideshow-container">
        <?php
        $j = 0;
        if( $recent_posts->have_posts() ): while( $recent_posts->have_posts() ): $recent_posts->the_post(); $j++;?>
            <div class="header-slide quick-fade">
                <?php the_post_thumbnail();?>
                <div>
                    <h3><?php the_title();?></h3>

                    <?php the_excerpt();?>

                    <form action=<?php the_permalink();?>>
                        <input id="read-more" type="submit" value="Read More"/>
                    </form>
                </div>

            </div>
        <?php endwhile; else: endif?>

        <a class="prev-slide" onclick="changeHeaderSlideshow(-1)">&#10094;</a>
        <a class="next-slide" onclick="changeHeaderSlideshow(1)">&#10095;</a>

        <div class="slideshow-dots-container">
            <?php for ($i = 0; $i < $j; $i++) {?>
                <button class="header-slideshow-dot<?php echo ($i == 0) ? ' header-slideshow-dot-active' : '';?>"
                        onclick="setHeaderSlideshow(<?php echo $i;?>)"></button>
            <?php }?>
        </div>

        <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/assets/js/banner.js"></script>
    </div>
</section>

<section id="blogs-archive">
    <?php $i = 1;?>
    <div>
        <?php if ( have_posts() ) : while ( have_posts() ) : the_post();?>

        <?php if($i == 1):?>
        <div class="spotlighted-post row">
            <div class="col-md-6 spotlighted-image">
                <a href="<?php the_permalink();?>"><?php the_post_thumbnail();?></a>
            </div>

            <div class="col-md-6 spotlighted-text">
                <div><a href="<?php the_permalink();?>">
                    <h2>Spotlighted</h2>
                    <h3><?php the_title();?></h3>
                    <h4><?php echo the_author_meta("first_name") . 'Bhavye Mathur' . get_the_author_meta("last_name");?></h4>
                </a></div>
            </div>
        </div>
        <div class="container blog-archive">
            <div class="row">
            <?php else:?>
                <a href="<?php the_permalink();?>" class="col-sm-6 col-md-4 blog-post">
                    <?php the_post_thumbnail();?>
                    <p><?php echo the_author_meta("first_name") . 'Bhavye Mathur' . get_the_author_meta("last_name");?></p>
                    <h3><?php the_title();?></h3>
                </a>
        <?php endif;?>
        <?php $i++; endwhile; endif;?>

            </div>
        </div>
    </div>
    <div class="pagination-container">
        <?php previous_posts_link();?>
        <?php next_posts_link();?>
    </div>
</section>

<?php get_footer();?>
