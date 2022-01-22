<?php
$post = get_page_by_path("meet-the-team");
$doc = new DOMDocument();
$doc->loadHTML( apply_filters( 'the_content', $post->post_content ) );
$doc = new DOMXPath( $doc );
?>

<section id="meet-the-team">
  <style type="text/css">   @import url("<?php echo get_template_directory_uri(); ?>/css/aboutus-css/meettheteam.css"); </style>

  <div class="meet-the-team-container container">

    <div class="heading-container">
      <?php echo "<div class='heading-overlay'>" . $post->post_title . "</div>";?>
    </div>

    <?php
    $names = $doc->query("//h2");
    $roles = $doc->query("//h3");
    $imgs = $doc->query("//p");
    ?>
    <?php for ($i=0; $i<=(count($names) - 1); $i++): ?>

      <?php if($i == 0): echo '<div class="row large-row">'; endif; ?>
        <?php if($i <= 2): ?>
        <div class="col-md-3">
          <div>
            <div><img class="dp" src="<?php echo get_template_directory_uri() . '/images/member-pics/' . $imgs[$i]->nodeValue;?>"></div>
            <div>
              <div><h6><?php echo $names[$i]->nodeValue?></h6></div>
              <div><p><?php echo $roles[$i]->nodeValue?></p></div>
            </div>
          </div>
        </div>
        <?php endif; ?>
      <?php if ($i == 2): echo '</div>'; endif; ?>

      <?php if($i == 3): echo '<div class="row medium-row">'; endif; ?>
        <?php if($i >= 3 && $i <= 5): ?>
        <div class="col-md-3">
          <div>
            <div><img class="dp" src="<?php echo get_template_directory_uri() . '/images/member-pics/' . $imgs[$i]->nodeValue;?>"></div>
            <div>
              <div><h6><?php echo $names[$i]->nodeValue?></h6></div>
              <div><p><?php echo $roles[$i]->nodeValue?></p></div>
            </div>
          </div>
        </div>
        <?php endif; ?>
      <?php if ($i == 5): echo '</div>'; endif; ?>

      
      <?php if ($i == 6): echo '<div class="row small-row">'; endif; ?>
        <?php if($i >= 6): ?>
        <div class="col-md-2">
          <div>
            <div><img class="dp" src="<?php echo get_template_directory_uri() . '/images/member-pics/' . $imgs[$i]->nodeValue;?>"></div>
            <div>
              <div><h6><?php echo $names[$i]->nodeValue?></h6></div>
            </div>
          </div>
        </div>
        <?php endif; ?>
      <?php if ($i == (count($names)-1)): echo "</div>"; endif; ?>
    <?php endfor; ?>  
  </div>
</section>
