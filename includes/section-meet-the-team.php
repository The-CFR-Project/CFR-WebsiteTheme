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

      <div class="row large-row">
        <div class="col-md-3">
          <div>
            <div><img class="dp" src="<?php echo get_template_directory_uri() . '/images/' . $imgs[$i]->nodeValue;?>"></div>
            <div>
              <div><h6><?php echo $names[$i]->nodeValue?></h6></div>
              <div><p><?php echo $roles[$i]->nodeValue?></p></div>
            </div>
            <?php $i++;?>
          </div>
        </div>

        <div class="col-md-3">
          <div>
            <div><img class="dp" src="<?php echo get_template_directory_uri() . '/images/' . $imgs[$i]->nodeValue;?>"></div>
            <div>
              <div><h6><?php echo $names[$i]->nodeValue?></h6></div>
              <div><p><?php echo $roles[$i]->nodeValue?></p></div>
            </div>
            <?php $i++;?>
          </div>
        </div>

        <div class="col-md-3">
          <div>
            <div><img class="dp" src="<?php echo get_template_directory_uri() . '/images/' . $imgs[$i]->nodeValue;?>"></div>
            <div>
              <div><h6><?php echo $names[$i]->nodeValue?></h6></div>
              <div><p><?php echo $roles[$i]->nodeValue?></p></div>
            </div>
            <?php $i++;?>
          </div>
        </div>
      </div>

      <div class="row medium-row">
        <div class="col-md-3">
          <div>
            <div><img class="dp" src="<?php echo get_template_directory_uri() . '/images/' . $imgs[$i]->nodeValue;?>"></div>
            <div>
              <div><h6><?php echo $names[$i]->nodeValue?></h6></div>
              <div><p><?php echo $roles[$i]->nodeValue?></p></div>
            </div>
            <?php $i++;?>
          </div>
        </div>

        <div class="col-md-3">
          <div>
            <div><img class="dp" src="<?php echo get_template_directory_uri() . '/images/' . $imgs[$i]->nodeValue;?>"></div>
            <div>
              <div><h6><?php echo $names[$i]->nodeValue?></h6></div>
              <div><p><?php echo $roles[$i]->nodeValue?></p></div>
            </div>
            <?php $i++;?>
          </div>
        </div>

        <div class="col-md-3">
          <div>
            <div><img class="dp" src="<?php echo get_template_directory_uri() . '/images/' . $imgs[$i]->nodeValue;?>"></div>
            <div>
              <div><h6><?php echo $names[$i]->nodeValue?></h6></div>
              <div><p><?php echo $roles[$i]->nodeValue?></p></div>
            </div>
            <?php $i++;?>
          </div>
        </div>

      </div>

      <div class="row small-row">
        <div class="col-md-2">
          <div>
            <div><img class="dp" src="<?php echo get_template_directory_uri() . '/images/' . $imgs[$i]->nodeValue;?>"></div>
            <div>
              <div><h6><?php echo $names[$i]->nodeValue?></h6></div>
            </div>
            <?php $i++;?>
          </div>
        </div>

        <div class="col-md-2">
          <div>
            <div><img class="dp" src="<?php echo get_template_directory_uri() . '/images/' . $imgs[$i]->nodeValue;?>"></div>
            <div>
              <div><h6><?php echo $names[$i]->nodeValue?></h6></div>
            </div>
            <?php $i++;?>
          </div>
        </div>

        <div class="col-md-2">
          <div>
            <div><img class="dp" src="<?php echo get_template_directory_uri() . '/images/' . $imgs[$i]->nodeValue;?>"></div>
            <div>
              <div><h6><?php echo $names[$i]->nodeValue?></h6></div>
            </div>
            <?php $i++;?>
          </div>
        </div>

        <div class="col-md-2">
          <div>
            <div><img class="dp" src="<?php echo get_template_directory_uri() . '/images/' . $imgs[$i]->nodeValue;?>"></div>
            <div>
              <div><h6><?php echo $names[$i]->nodeValue?></h6></div>
            </div>
            <?php $i++;?>
          </div>
        </div>

        <div class="col-md-2">
          <div>
            <div><img class="dp" src="<?php echo get_template_directory_uri() . '/images/' . $imgs[$i]->nodeValue;?>"></div>
            <div>
              <div><h6><?php echo $names[$i]->nodeValue?></h6></div>
            </div>
            <?php $i++;?>
          </div>
        </div>

      </div>

      <div class="row small-row">
        <div class="col-md-2">
          <div>
            <div><img class="dp" src="<?php echo get_template_directory_uri() . '/images/' . $imgs[$i]->nodeValue;?>"></div>
            <div>
              <div><h6><?php echo $names[$i]->nodeValue?></h6></div>
            </div>
            <?php $i++;?>
          </div>
        </div>

        <div class="col-md-2">
          <div>
            <div><img class="dp" src="<?php echo get_template_directory_uri() . '/images/' . $imgs[$i]->nodeValue;?>"></div>
            <div>
              <div><h6><?php echo $names[$i]->nodeValue?></h6></div>
            </div>
            <?php $i++;?>
          </div>
        </div>

        <div class="col-md-2">
          <div>
            <div><img class="dp" src="<?php echo get_template_directory_uri() . '/images/' . $imgs[$i]->nodeValue;?>"></div>
            <div>
              <div><h6><?php echo $names[$i]->nodeValue?></h6></div>
            </div>
            <?php $i++;?>
          </div>
        </div>

        <div class="col-md-2">
          <div>
            <div><img class="dp" src="<?php echo get_template_directory_uri() . '/images/' . $imgs[$i]->nodeValue;?>"></div>
            <div>
              <div><h6><?php echo $names[$i]->nodeValue?></h6></div>
            </div>
            <?php $i++;?>
          </div>
        </div>

      </div>

  </div>
</section>
