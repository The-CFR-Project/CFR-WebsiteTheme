<?php
$post = get_page_by_path("flight-calculator-preview");
$doc = new DOMDocument();
$doc->loadHTML( apply_filters( 'the_content', $post->post_content ) );
$doc = new DOMXPath( $doc );
?>

<section id="flight-calculator">
  <style type="text/css">   @import url("<?php echo get_template_directory_uri(); ?>/assets/css/homepage-css/flights-calc.css"); </style>
  <div class="home-post container-fluid">
    <div class="heading-container">
    <?php
      echo "<div class='heading-overlay'>calculator</div>";
      echo "<div class='heading-watermark'>" . $doc->query("//h1")[0]->nodeValue . "</div>";
    ?>
      <img src="<?php echo get_template_directory_uri();?>/assets/images/flight-symbol.svg">
    </div>

    <form action="<?php echo $doc->query('//a')[0]->nodeValue;?>">
      <input type="submit" value="<?php echo $doc->query("//h2")[0]->nodeValue;?>">
    </form>

    <div class="full-row">
      <img src="<?php echo get_template_directory_uri();?>/assets/images/balloon2.svg">
    </div>

    <div class="row">

      <div class="col-md-6">
        <div>
          <a href="<?php echo $doc->query('//a')[1]->nodeValue;?>">
            <div id='over-only-the-cat'></div>
          </a>
        </div>
        <img src="<?php echo get_template_directory_uri();?>/assets/images/balloon1.svg" id="flights-balloon1">

      </div>

      <div class="col-md-6 col-para text-justify">
        <?php
        $firstp = true;
        foreach ($doc->query('//p[not(a)]') as $node) {
          echo ($firstp ? "<p>" : "<br><br><p>") . $node->nodeValue . "</p>";
          $firstp = false;
        }?>
        <!-- <a href="<?php echo get_permalink( $post )?>" class='line-lmao'>Read More</a> -->
      </div>

      <div class="background-image">
        <img src="<?php echo get_template_directory_uri();?>/assets/images/flight-watermark.svg">
      </div>

    </div>

  </div>

  <script>
    var balloonImg = document.getElementById("flights-balloon1");
    var overOnlyTheCatDiv = document.getElementById("over-only-the-cat");
    overOnlyTheCatDiv.addEventListener('mouseover', function(){
      balloonImg.className = '';
      balloonImg.className += ' scale-1dot05 rotate-8d';
    });
    overOnlyTheCatDiv.addEventListener('mouseout', function(){
      balloonImg.className = '';
      balloonImg.className += ' reset-rotate';
    });
  </script>
</section>
