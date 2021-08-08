    <?php $divs = 4;?>

      <div class="slideshow-container">

      <?php for ($i = 0; $i < $divs; $i++) {?>

        <div class="header-slide">

          <div class="header-slide-number"><?php echo $i + 1;?> / <?php echo $divs;?></div>

          <div class="header-slide-img">
            <img src="<?php echo get_template_directory_uri();?>/images/header-slideshow-image<?php echo $i?>.jpg">
          </div>

        </div>

      <?php }?>

        <a class="prev" onclick="changeHeaderSlideshow(-1)">&#10094;</a>
        <a class="next" onclick="changeHeaderSlideshow(1)">&#10095;</a>

        <div style="text-align:center">
        <?php for ($i = 0; $i < $divs; $i++) {?>
          <span class="dot" onclick="setHeaderSlideshow(<?php echo $i;?>)"></span>
        <?php }?>
        </div>
      </div>
