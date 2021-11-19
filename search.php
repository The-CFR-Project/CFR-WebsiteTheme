<?php get_header(); ?>
<style type="text/css">   @import url("<?php echo get_template_directory_uri(); ?>/css/blogs-css/blog-search.css"); </style>
<?php echo '<h1 style="margin-top:100px;">Search Results for "'.get_search_query().'"</h1>';?>
<?php if ( have_posts() ) : while ( have_posts() ) : the_post();?>
    <?php if(has_post_thumbnail()): ?>
        <img src="<?php the_post_thumbnail_url(); ?>" class= "img-fluid">
    <?php endif; ?>
    <h3><?php the_title();?></h3>
    <?php echo "<p>" . get_the_author_meta("first_name") . ' ' . get_the_author_meta("last_name") . "</p>";?>
    <?php echo "<p>".get_the_date('j.m.Y')."</p>"; ?>
<?php endwhile; endif;?>

<?php get_footer(); ?>