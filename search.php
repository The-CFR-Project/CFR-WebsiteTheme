<?php get_header(); ?>
<section>

</section>
 <section id="search-container">
    <style type="text/css">   @import url("<?php echo get_template_directory_uri(); ?>/assets/css/blogs-css/blog-search.css"); </style>
    <style type="text/css">   @import url("<?php echo get_template_directory_uri(); ?>/assets/css/blogs-css/latest-blogs.css"); </style>

    <div class="heading-container">
      <?php
        echo "<div class='heading-overlay'>search for a blog</div>";
        echo "<div class='heading-watermark'>search</div>";
      ?>
    </div>

    <div class="search-container">
        <?php // Add `,post_tag,series_name` to `fields` after blog series completion ?>
        <?php echo do_shortcode( '[searchandfilter fields="search" types="select" class="my-precious" submit_label="Go!"]' ); ?>
    </div>

    <?php if (get_search_query() != ''): ?>
      <?php echo '<h1 class="results-heading">Search Results for "'.get_search_query().'"</div>'; ?>
        <div class="blogs-sidebar-blogs" style="display:block;">
          <?php $counter = 0 ?>
          
            <?php if ( have_posts() ) : while ( have_posts() ) : the_post();?>

              <?php if ($counter == 0): ?>
                <div class="row" style="display:flex;align-items:center;justify-content:center;">
              <?php endif; $counter += 1; ?>
                  <div class="blogs-sidebar-blogs-blog col-sm-3" style="width:auto !important;">
                    <a href="<?php the_permalink(); ?>">
                      <?php if(has_post_thumbnail()): ?>
                          <img src="<?php the_post_thumbnail_url(); ?>" class="img-fluid">
                      <?php endif; ?>
                      <div class="blogs-archive-post-text">
                          <h3><?php the_title(); ?></h3>
                          <p style="color:var(--grey6);"><?php echo get_the_author_meta("first_name")." ".get_the_author_meta("last_name");?></p>
                      </div>
                    </a>
                  </div>
              <?php if ($counter == 4): ?>    
                </div>
              <?php  $counter = 0; endif; ?>
            
            <?php endwhile; endif;?>
          
        </div>
    <?php endif; ?>
</section>


<?php get_footer(); ?>
<script>
    function swapSibling(node1, node2) {
        node1.parentNode.replaceChild(node1, node2);
        node1.parentNode.insertBefore(node2, node1);
    }

    window.onload = () => {
        const searchForm = document.getElementsByClassName("my-precious")[0];
        swapSibling(searchForm.childNodes[1].childNodes[1].childNodes[2], searchForm.childNodes[1].childNodes[1].childNodes[3])
        swapSibling(searchForm.childNodes[1].childNodes[1].childNodes[1], searchForm.childNodes[1].childNodes[1].childNodes[2])

        const dropdownContainer = document.createElement("div");
        dropdownContainer.classList.add("dropdown-container");
        dropdownContainer.appendChild(searchForm.childNodes[1].childNodes[1].childNodes[2]);
        dropdownContainer.appendChild(searchForm.childNodes[1].childNodes[1].childNodes[2]);
        searchForm.childNodes[1].childNodes[1].appendChild(dropdownContainer);
    }

    var commonSearchBar = document.getElementsByClassName("full-search-container")[0];
    //console.log(commonSearchBar);
    commonSearchBar.style.display = 'none';

</script>
