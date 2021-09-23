<?php
$post = get_page_by_path("meet-the-team");
$doc = new DOMDocument();
$doc->loadHTML( apply_filters( 'the_content', $post->post_content ) );
$doc = new DOMXPath( $doc );
?>

<section id="meet-the-team">
  <div class="meet-the-team-container container">

    <div class="heading-container">
      <?php echo "<div class='heading-overlay'>" . $post->post_title . "</div>";?>
    </div>

    <?php
    $names = $doc->query("//h3");
    $roles = $doc->query("//p[not(a)]");
    $imgs = $doc->query("//a");

    $i = 0;

    foreach ( $names as $name) {
      if ($i % 4 == 0) {
        echo "<div class='row'>";
      }
      echo "<div class='col-md-3'>";
      echo    "<div>";
      echo      "<div>";
      echo        "<img class='dp' src='" . $imgs[$i]->nodeValue . "'>";
      echo      "</div><div>";
      echo        $name->nodeValue;
      echo "<br>";
      echo        $roles[$i]->nodeValue;
      echo      "</div>";
      echo    "</div>";
      echo "</div>";

      if ($i % 4 == 3) {
        echo "</div>";
      }

      $i++;
    }
    ?>

  </div>
</section>
