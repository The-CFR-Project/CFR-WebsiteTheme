<?php
$post = get_page_by_path("gameshow");
$doc = new DOMDocument();
$doc->loadHTML( apply_filters( 'the_content', $post->post_content ) );
$doc = new DOMXPath( $doc );
?>

<section id="gameshow-our-guests" style="padding: 0 5vw;">
    <style type="text/css">   @import url("<?php echo get_template_directory_uri(); ?>/assets/css/gameshow-page-css/gameshow-our-guests.css"); </style>
    <div class="heading-container">
        <?php
            echo "<div class='heading-overlay'>" . $doc->query("//h2")[1]->nodeValue . "</div>";
        ?>
    </div>

    <div class="guests">
        <?php
            function get_text_from_node($node){
                $html = '';
                $children = $node->childNodes;

                foreach ($children as $child) {
                    $tmp_doc = new DOMDocument();
                    $tmp_doc->appendChild($tmp_doc->importNode($child,true));
                    $html .= $tmp_doc->saveHTML();
                }
                return $html;
            }

            for ($i = 0; $i < count($doc->query("//h3")); $i++) {
                echo "<div class='guest'>";
                if ($i == 0 || $i==1) {
                    echo "<div class='episode-color' style='background: linear-gradient(to bottom right, #A577FF, #7A50CD)'></div>";
                } else if ($i == 2 || $i == 3) {
                    echo "<div class='episode-color' style='background: linear-gradient(to bottom right, #FFBD59, #C49042)'></div>";
                } else if ($i == 4 || $i == 5) {
                    echo "<div class='episode-color' style='background: linear-gradient(to bottom right, #88D172, #6AA858)'></div>";
                } else if ($i == 6 || $i == 7) {
                    echo "<div class='episode-color' style='background: linear-gradient(to bottom right, #FF5757, #B64141)'></div>";
                } else if ($i == 8 || $i == 9) {
                    echo "<div class='episode-color' style='background: linear-gradient(to bottom right, #6699CC, #4A84BD)'></div>";
                } else {
                    echo "<div class='episode-color' style='background: linear-gradient(to bottom right, #8092E6, #5365BF)'></div>";
                }
                echo "
                        <div class='about-guest'>
                            <img src='" . get_template_directory_uri() . "/assets/images/author-placeholder.svg' alt='' class='guest-pfp'>
                            <div class='guest-name'>" . get_text_from_node(($doc->query("//h3"))[$i]) . "</div>
                            <div class='guest-role'>" . get_text_from_node(($doc->query("//h4"))[$i]) . "</div>
                            <div class='guest-description'>" . get_text_from_node(($doc->query("//h5"))[$i]) . "</div>
                            <div class='row guest-socials'>
                ";
                echo "
                                <div class='col'>
                                    <a href='" . get_text_from_node(($doc->query("//a"))[$i*4]) . "' target='_blank'>
                                        <img src='" . get_template_directory_uri() . "/assets/images/facebook-icon.svg' alt='' width='35px'>
                                    </a>
                                </div>               
                ";
                echo "
                                <div class='col'>
                                    <a href='" . get_text_from_node(($doc->query("//a"))[($i*4) + 1]) . "' target='_blank'>
                                        <img src='" . get_template_directory_uri() . "/assets/images/linkedin-icon.svg' alt='' width='35px'>
                                    </a>
                                </div>
                ";
                echo "
                                <div class='col'>
                                    <a href='" . get_text_from_node(($doc->query("//a"))[($i*4) + 2]) . "' target='_blank'>
                                        <img src='" . get_template_directory_uri() . "/assets/images/instagram-icon.svg' alt='' width='35px'>
                                    </a>
                                </div>
                ";
                echo "
                                <div class='col'>
                                    <a href='" . get_text_from_node(($doc->query("//a"))[($i*4) + 3]) . "' target='_blank'>
                                        <img src='" . get_template_directory_uri() . "/assets/images/twitter-icon.svg' alt='' width='35px'>
                                    </a>
                                </div>
                ";
                echo "
                            </div>
                        </div>
                    </div>            
                ";
            }
        ?>
    </div>
</section>
