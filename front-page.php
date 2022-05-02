<?php get_header();?>

<div class="container-fluid">
    <div class="header-slideshow-container">
        <style type="text/css">   @import url("<?php echo get_template_directory_uri(); ?>/assets/css/homepage-css/home-banner.css"); </style>
        <?php

        $bannerItems = wp_get_nav_menu_items(get_nav_menu_locations()['home-banner']);

        $i = 0;
        foreach ( $bannerItems as $navItem ) {
            ?>
            <div class="header-slide quick-fade">
                <img src="<?php echo get_template_directory_uri();?>/assets/images/header-slideshow-image<?php echo $i?>.jpeg">

                <div>
                    <h3><?php echo $navItem->title;?></h3>

                    <form action=<?php echo $navItem->url;?>>
                        <?php if ($navItem->title == 'register for our gameshow'): ?>
                            <input id="read-more" type="submit" value="Register" />
                        <?php else: ?>
                            <input id="read-more" type="submit" value="Read More" />
                        <?php endif; ?>
                    </form>
                </div>

            </div>

            <?php
            $i += 1;
            if ($i > 3) {
                $i = 0;
            }
        }
        ?>

        <a class="prev-slide" onclick="changeHeaderSlideshow(-1)">&#10094;</a>
        <a class="next-slide" onclick="changeHeaderSlideshow(1)">&#10095;</a>

        <div class="slideshow-dots-container">
            <?php for ($i = 0; $i < sizeof($bannerItems); $i++) {?>
                <button class="header-slideshow-dot<?php echo ($i == 0) ? ' header-slideshow-dot-active' : '';?>"
                        onclick="setHeaderSlideshow(<?php echo $i;?>)"></button>
            <?php }?>
        </div>

        <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/assets/js/banner.js"></script>
    </div>
</div>

<?php get_template_part( "template-parts/home-page/section", "flight-calculator-preview" );?>
<?php get_template_part( "template-parts/home-page/section", "cards" );?>
<?php get_template_part( "template-parts/home-page/section", "faqs" );?>
<?php get_template_part( "template-parts/home-page/section", "instawall" );?>

<?php get_footer();?>
