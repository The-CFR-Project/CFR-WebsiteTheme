<?php get_header(); ?>

<section id="search-container">
    <style type="text/css">   @import url("<?php echo get_template_directory_uri(); ?>/css/blogs-css/blog-search.css"); </style>

    <?php echo do_shortcode( '[searchandfilter fields="search,post_tag,series_name" types="multiselect" ]' ); ?>

    <?php if (get_search_query() != ''): ?>
    <?php echo '<h1>Search Results for "'.get_search_query().'"</h1>';?>

    <?php if ( have_posts() ) : while ( have_posts() ) : the_post();?>
        <?php if(has_post_thumbnail()): ?>
            <img src="<?php the_post_thumbnail_url(); ?>" class= "img-fluid">
        <?php endif; ?>
        <?php the_title(); ?>
        <?php echo get_the_author_meta("first_name")." ".get_the_author_meta("last_name");?>
    <?php endwhile; endif;?>
    <?php endif; ?>


</section>


<?php get_footer(); ?>