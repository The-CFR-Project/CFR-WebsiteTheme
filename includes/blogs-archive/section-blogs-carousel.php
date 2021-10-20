<section id="blogs-carousel">
    <style type="text/css">   @import url("<?php echo get_template_directory_uri(); ?>/css/blogs-css/blog-carousel.css"); </style>
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
                                echo '<a href="';
                                echo the_permalink();
                                echo '"><h1>';
                                echo the_title();
                                echo '</h1></a>';
                                echo the_excerpt();
                                echo '<a class="readmore" href="';
                                echo the_permalink();
                                echo '"><h4 class="special-underline">Read More</h4><div class="blogs-carousel-readmore-arrow"></div></a>';
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

    <script>

        // Carousel Functionality 

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
                    allSlides[i].style.visibility = 'hidden';
                    allSlideIndicators[i].style.opacity = "0.5";
                }else {
                    allSlides[i].style.visibility = 'visible';
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