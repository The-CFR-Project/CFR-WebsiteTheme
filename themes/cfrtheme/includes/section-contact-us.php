<?php
$post = get_page_by_path("contact-us");
$doc = new DOMDocument();
$doc->loadHTML( apply_filters( 'the_content', $post->post_content ) );
$doc = new DOMXPath( $doc );
?>

<section id="contact-us">
  <div class="contact-us-container">
    <div class="heading-container">
    <?php
      echo "<div class='heading-overlay' style='font-size:40px;'>" . $doc->query("//h2")[0]->nodeValue . "</div>";
      echo "<div class='heading-watermark'>" . $doc->query("//h1")[0]->nodeValue . "</div>";
    ?>
    </div>
    <div class='row contactus-card-container'>
    <?php
      for ($i = 0; $i <= 2; $i++):
      echo "<div class='contactus-card contactus-card-" . ($i+1) . " col-md-3 card'>";
        echo "<h3 class='contactus-card-heading'>" . $doc->query("//h3")[$i]->nodeValue . "</h3>";
        echo "<p class='contactus-card-text'>" . $doc->query("//p")[$i]->nodeValue . "</p>";
        if ($i == 0){
          echo "<a href=''><input type='button' class='contactus-card-button contactus-card-button-". ($i+1) ."' value='". $doc->query("//h4")[$i]->nodeValue ."'></a>";
        }
        else if ($i == 1){
          echo "<a href='#contact-form'><input type='button' class='contactus-card-button contactus-card-button-". ($i+1) ."' value='". $doc->query("//h4")[$i]->nodeValue ."'></a>";
        }else if ($i == 2) {
          echo "<a href=''><input type='button' class='contactus-card-button contactus-card-button-". ($i+1) ."' value='". $doc->query("//h4")[$i]->nodeValue ."'></a>";
        }
        
      echo "</div>";
      endfor;
    ?>
    </div>

  </div>
</section>
