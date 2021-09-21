<!---------------------- Blogs Archive Page ---------------------->

<?php $i = 1; ?>

<div class="blogs-header-container">

    <img class="blogs-header-image" src="<?php echo get_template_directory_uri();?>/images//blog-images/blog-archive-header-image.jpeg">
    <div class="blogs-header-text">
        <h1>cfr  originals</h1>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
        <div class='heart-shape'></div>
    </div>
    

    

</div>
<div class="blogs-archive-container">

    <h3>Latest Posts</h3>

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
        <?php if($i >= 1 && $i <= 4): ?>

            <div class="row">
                <?php echo "<div class=col blogs-archive-post-grid-".$i; ?>
                    <h3><?php the_title();?></h3>
                    <?php the_excerpt(); ?> 
                    <a href="<?php the_permalink(); ?>" class="btn btn-success">Read more</a>
                <?php echo "</div>"; ?>
            </div>

        <?php endif; ?>    


        <!--  Loops over all remaining posts  --> 
        <?php if($i > 4): ?>

            <div class="row">
                <div class="blogs-archive-posts-more col-md-3">
                    <h3><?php the_title();?></h3>
                    <?php the_excerpt(); ?> 
                    <a href="<?php the_permalink(); ?>" class="btn btn-success">Read more</a>   
                </div>
            </div>
            
        <?php endif ?>    
 




    <?php  $i+=1;  endwhile; endif;?>

</div>  

