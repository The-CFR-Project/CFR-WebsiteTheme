<!---------------------- Blogs Archive Page ---------------------->

<section id="blogs-archive">
<div class="blogs-archive-container">
        
    <!-- Handpicked Blogs on Archive Carousel-->

    <?php $count = 0; if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
    <?php $count++; endwhile; endif;?>

    <div class="archive-carousel-container">
        <div class="archive-carousel-slides-container">
            <a class="archive-carousel-prevbtn" onclick="prevbtnClicked()">&#10094;</a>
            <a class="archive-carousel-nextbtn" onclick="nextbtnClicked()">&#10095;</a>
            <div class="archive-carousel-slides">
                <?php 
                $totalHandpicked = 0;
                if ( have_posts() ) : while ( have_posts() ) : the_post();
                    $handpicked = false;
                    $postCategories = get_the_category(); // Gets categories of the post
                    foreach ($postCategories as $cat){ // Loops through the categories of the current post
                        if ($cat->name == "Banner-Blogs"){ // Checks if the category of the selected post is "Banner-Blogs"
                            $handpicked = true; 
                        }
                    }
                    if ($handpicked){
                        $totalHandpicked ++;
                        $colors = ["--red2", "--red3", "--blue2", "--blue3"];
                        $randColor = array_rand($colors, 1);
                
                        echo '<div class="archive-carousel-slide" style="background-color:var('.$colors[$randColor].')">';
                            echo "<div class='blogs-archive-slide-image'>";
                            if(has_post_thumbnail()):
                                echo '<img src="';
                                echo the_post_thumbnail_url();
                                echo '" class="archive-carousel-image">';
                            endif;
                            echo "</div>";
                            echo "<div class='blogs-archive-slide-text'>";
                                echo '<h1>';
                                echo the_title();
                                echo '</h1>';
                                echo the_excerpt();
                                echo '<a href="';
                                echo the_permalink();
                                echo '">Read More<div class="blogs-carousel-readmore-arrow"></div></a>';
                            echo "</div>";

                        echo '</div>';

                    }
                endwhile; endif;
                ?>

  
                <div class="archive-carousel-slide-indicators">
                    <?php for($r=1; $r<=$totalHandpicked; $r++){
                        echo '<div id="'.$r.'-archive-carousel-indicator" class="archive-carousel-slide-indicator"></div>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    




    <!-- Latest Posts -->
    <section id="blogs-archive-latest">
    <?php $i = 1; ?>
    <div class="row blogs-archive-post">
        <?php if ( have_posts() ) : while ( have_posts() ) : the_post();?>

            <!--  If the post is the latest one  -->  
            <?php if($i == 1): ?>
                <a href="<?php the_permalink(); ?>" class="blogs-archive-permalink">
                    <div class="blogs-archive-post-latest">

                        <div class="blogs-archive-post-latest-tn col-md-3">
                            <?php if(has_post_thumbnail()): ?>
                                <img src="<?php the_post_thumbnail_url(); ?>" class= "img-fluid">
                            <?php endif; ?> 
                        </div>

                        <div class="blogs-archive-post-latest-excerpt col-md-6">
                            <p>Spotlighted</p>
                            <h3><?php the_title();?></h3>
                            <?php echo "<p>" . get_the_author_meta("first_name") . ' ' . get_the_author_meta("last_name") . "</p>";?>
                            <?php echo "<p>".get_the_date('j.m.Y')."</p>"; ?>
                        </div>

                    </div> 
                </a>  
            <?php endif; ?> 

            <!--  Loops over next 9 latest posts  --> 
            <?php if($i >= 2 && $i <= 10): ?>

                <a href="<?php the_permalink(); ?>" class="col-md-4">
                    <?php  echo "<div class='blogs-archive-post-grid-". ($i-1) ." blogs-archive-post-grid'>" ?>
                        <?php if(has_post_thumbnail()): ?>
                            <img src="<?php the_post_thumbnail_url(); ?>" class= "img-fluid">
                        <?php endif; ?> 
                        <div class="blogs-archive-post-text">
                            <h3><?php the_title();?></h3>
                            <p><?php echo "<p>" . get_the_author_meta("first_name") . ' ' . get_the_author_meta("last_name") . "</p>";?></p>
                        </div>
                    </div>
                </a>

            <?php endif; ?> 
    
        <?php $i++; endwhile; endif;?>

    </div>

    <div class="blogs-archive-sidebar">
        <div class="blogs-sidebar-socials-icons">
            <?php
                $socialItems = wp_get_nav_menu_items(get_nav_menu_locations()['footer-social']);
                    foreach ( $socialItems as $footerItem ) {
                    echo "<a href='" . $footerItem->url . "'><img src='" . get_template_directory_uri() . "/images/" . $footerItem->title . "-icon.svg' class='blogs-sidebar-socials-icon'></a>";
                    }   
            ?>
        </div>
        <div class="blogs-sidebar-blogs row">
            <h5 class='blogs-sidebar-blogs-title'>recommended</h5>    
            <?php $i = 0; if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                
                <?php if($i==$count-7): ?>
                    <div class="blogs-sidebar-blogs-blog col-sm-4">
                        <a href="<?php the_permalink(); ?>">
                            <h3><?php the_title() ?></h3>
                            <p style='color:var(--blue2)'><?php echo get_the_author_meta("first_name") . ' ' . get_the_author_meta("last_name") ;?></p>
                            <?php echo "<p style='color:var(--blue2)'>".get_the_date('d M')."</p>"; ?>
                        </a>
                    </div>
                <?php endif; ?>   

                <?php if($i==$count-4): ?>
                    <div class="blogs-sidebar-blogs-blog col-sm-4">
                        <a href="<?php the_permalink(); ?>">
                            <h3><?php the_title() ?></h3>
                            <p style='color:var(--red2)'><?php echo get_the_author_meta("first_name") . ' ' . get_the_author_meta("last_name") ;?></p>
                            <?php echo "<p style='color:var(--red2)'>".get_the_date('d M')."</p>"; ?>
                        </a>
                    </div>
                <?php endif; ?>  

                <?php if($i==$count-2): ?>
                    <div class="blogs-sidebar-blogs-blog col-sm-4">
                        <a href="<?php the_permalink(); ?>">
                            <h3><?php the_title() ?></h3>
                            <p style='color:var(--red3)'><?php echo get_the_author_meta("first_name") . ' ' . get_the_author_meta("last_name") ;?></p>
                            <?php echo "<p style='color:var(--red3)'>".get_the_date('d M')."</p>"; ?>
                        </a>
                    </div>
                <?php endif; ?>   

            <?php $i++;  endwhile; endif;?>
        </div>

    </div>

    </section> 
</div>
 

<script>

    const allSlides = document.getElementsByClassName("archive-carousel-slide");
    const allSlideIndicators = document.getElementsByClassName("archive-carousel-slide-indicator");
    var currentSlide = 0;
    function prevbtnClicked(){
        if (currentSlide == 0){
            currentSlide = allSlides.length-1;
        }else {
            currentSlide -= 1;
        }
        displaySlide(currentSlide);
    }
    function nextbtnClicked(){
        if (currentSlide == allSlides.length-1){
            currentSlide = 0;
        }else {
            currentSlide += 1;
        }
        displaySlide(currentSlide);
    }
    function displaySlide(slide){
        for (var i = 0; i <= allSlides.length-1; i++){
            if (i != slide){
                allSlides[i].style.display = 'none';
                allSlideIndicators[i].style.opacity = "0.5";
            }else {
                allSlides[i].style.display = 'block';
                allSlideIndicators[i].style.opacity = "1";
            }
        }
    }

    for (f = 0; f < allSlideIndicators.length; f++){
        allSlideIndicators[f].addEventListener('click', function(){
            currentSlide = parseInt(this.id)-1;
            displaySlide(currentSlide);
        });
    }
    displaySlide(currentSlide);




</script>



</section>

