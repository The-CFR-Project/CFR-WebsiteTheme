<!---------------------- Blogs Archive Page ---------------------->

<section id="blogs-archive">
<div class="blogs-archive-container">
        
    <!-- Handpicked Blogs on Archive Carousel-->


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

    <h3>Latest Posts</h3>
    <?php $i = 1; ?>
    <div class="row">
        <?php if ( have_posts() ) : while ( have_posts() ) : the_post();?>

            <!--  If the post is the latest one  -->  
            <?php if($i == 1): ?>
                <div class="blogs-archive-post-latest">
                    <div class="blogs-archive-post-latest-excerpt">
                        <h3><?php the_title();?></h3>
                        <?php the_excerpt(); ?> 
                        <a href="<?php the_permalink(); ?>" class="btn btn-success">Read more</a>
                    </div>

                    <div class="blogs-archive-post-latest-tn">
                        <?php if(has_post_thumbnail()): ?>
                            <img src="<?php the_post_thumbnail_url(); ?>" class= "img-fluid img-thumbnail">
                        <?php endif; ?> 
                    </div>
                </div>   
            <?php endif; ?> 

            <!--  Loops over next 4 latest posts  --> 
            <?php if($i >= 2 && $i <= 5): ?>

                <?php  echo "<div class='col-md-6 blogs-archive-post-grid-". ($i-1) ."' style='display: flex; position:relative;'>" ?>
                    <h3><?php the_title();?></h3>
                    <a href="<?php the_permalink(); ?>" class="btn btn-success">Read more</a>
                </div>


            <?php endif; ?> 

            <!--  Loops over all remaining posts  --> 
            <?php if($i > 5): ?>

                <div class="blogs-archive-posts-more col-md-3">
                    <h3><?php the_title();?></h3>
                    <a href="<?php the_permalink(); ?>" class="btn btn-success">Read more</a>   
                </div>
                
            <?php endif ?>    
    
        <?php $i++; endwhile; endif;?>
    </div>

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

