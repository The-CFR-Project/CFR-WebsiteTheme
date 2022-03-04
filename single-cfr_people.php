<?php get_header();?>

<?php
function get_first_paragraph(): string {
    $str = wpautop( get_the_content() );
    return '<p>' . substr( $str, 0, strpos( $str, '</p>' ) + 4 ) . '</p>';
}

function get_other_paragraphs(): string {
    $str = wpautop( get_the_content() );
    return '<p>' . substr( $str, strpos( $str, '</p>' ) + 4) . '</p>';
}
?>

<style type="text/css">@import url("<?php echo get_template_directory_uri(); ?>/assets/css/people-css/single-person.css");</style>

<section id="person-section">
    <div class="banner-container">
        <img class="banner" src="<?php echo get_template_directory_uri();?>/assets/images/banner/mountains.jpg">

        <div class="container" style="position: relative">
            <div class="row banner-row">
                <div class="col-md-4">
                    <div class="dp-container">
                        <img class="profile-picture" src="<?php the_field('photo');?>">
                    </div>
                </div>
                <div class="col-md-8"></div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="heading-row row">
            <div class="col-md-4" style="display: flex; flex-direction: column; justify-content: center">
                <div class="title-container">
                    <?php
                    $taxonomy = get_the_terms( get_the_ID(), "cfr_role")[0]->name;
                    if ( $taxonomy == "CFR Member" ) {
                        the_field('position');
                        $member = true;
                    }
                    else {
                        echo $taxonomy;
                        $member = false;
                    }
                    ?>
                </div>
                <div class="email-container">
                    <?php
                    if ($member) {
                        the_field('email');
                    }
                    ?>
                </div>
            </div>
            <div class="col-md-8">
                <div class="heading-container">
                    <?php echo "<div class='heading-overlay'>" . $post->post_title . "</div>";?>
                    <div class='heading-watermark'>CFR</div>
                </div>
            </div>
        </div>

        <div class="row" style="margin-top: -50px;">
            <div class="col-md-4" style="display: flex; justify-content: center; align-items: center">
                <div>
                    <div class="row">
                        <?php
                        foreach (["linkedin", "instagram", "facebook", "website"] as $site) {
                            $value = get_field( $site );
                            if ( strlen( $value ) > 0 ) {?>
                                <div class="col col-md-6 social-icon-container">
                                    <a href="<?php echo $value;?>">
                                        <img class="social-icon" src="<?php echo get_template_directory_uri();?>/assets/images/<?php echo $site?>-icon.svg">
                                    </a>
                                </div>
                                <?php
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>

            <div class="col-md-8 first-para" style="display: flex; flex-direction: column; justify-content: center; align-items: center">
                <div class="work-tags-container">
                    <?php
                    if ($member) {
                        foreach (get_field("aspect") as $aspect) {
                            echo "<div>" . $aspect . "</div>";
                        }
                    }
                    ?>
                </div>
                <?php echo get_first_paragraph(); ?>
            </div>
        </div>
    </div>
</section>

<?php
if ( has_term( "Gameshow Guest", "cfr_role" ) ) {
?>
<section id="gameshow" style="background-color: white">
    <div class="heading-container" style="height: 150px;">
        <div class='heading-overlay'>the cfr gameshow</div>
    </div>

    <div class="container">
        <div class="row justify-content-evenly">
            <?php
            if ( $member and get_field( "is_host" ) ) {
                foreach ( get_field( "hosted_episodes" ) as $episode ) {
                    $s = strtotime( get_field( "start_time", $episode ) );
                    $date = date('j F Y', $s);

                    $pieces = explode(' ', get_the_title( $episode));
                    $title = array_pop($pieces);?>
                    <div class="col-md-3 episode-container" onclick="location.href='<?php echo get_permalink( $episode )?>';"
                         style="background-color: <?php echo get_field( "colour1", $episode );?>">
                        <h2>HOST</h2>
                        <h3>the one with</h3>
                        <h1><?php echo $title;?></h1>
                        <h3><?php echo $date;?></h3>
                    </div>
                <?php
                }
            }

            if ( $member and get_field( "is_guest" ) ) {
                foreach ( get_field( "guest_episodes" ) as $episode ) {
                    $s = strtotime( get_field( "start_time", $episode ) );
                    $date = date('j F Y', $s);

                    $pieces = explode(' ', get_the_title( $episode));
                    $title = array_pop($pieces);?>
                    <div class="col-md-3 episode-container">
                        <div style="height: 40%">
                            <h2 style="color: <?php echo get_field( "colour1", $episode );?>">GUEST</h2>
                        </div>
                        <div onclick="location.href='<?php echo get_permalink( $episode )?>';"
                             style="background-color: <?php echo get_field( "colour1", $episode );?>; height:60%; width: 100%; border-radius: 0 0 20px 20px">
                            <h3>the one with</h3>
                            <h1><?php echo $title;?></h1>
                            <h3><?php echo $date;?></h3>
                        </div>
                    </div>
                <?php
                }
            }

            if ( !$member ) {
                foreach ( get_field( "episodes" ) as $episode ) {
                    $s = strtotime( get_field( "start_time", $episode ) );
                    $date = date('j F Y', $s);

                    $pieces = explode(' ', get_the_title( $episode));
                    $title = array_pop($pieces);?>
                <div class="col-md-3 episode-container">
                    <div style="height: 40%">
                        <h2 style="color: <?php echo get_field( "colour1", $episode );?>">EXPERT</h2>
                    </div>
                    <div onclick="location.href='<?php echo get_permalink( $episode )?>';"
                         style="background-color: <?php echo get_field( "colour1", $episode );?>; height:60%; width: 100%; border-radius: 0 0 20px 20px">
                        <h3>the one with</h3>
                        <h1><?php echo $title;?></h1>
                        <h3><?php echo $date;?></h3>
                    </div>
                </div>
                <?php
                }
            }
            ?>
        </div>
    </div>
</section>
<section></section>

<?php
}
$bio = get_other_paragraphs();
if ( strlen( $bio ) > 10) {?>
    <section>
        <div class="heading-container">
            <?php
            echo "<div class='heading-overlay'>" . "know more!" . "</div>";
            ?>
        </div>

        <div class="container description-container">
            <?php echo $bio;?>
        </div>

        <div class="instawall-section-container container-fluid" style="margin-top: 200px;">
            <div class="bedrock-container">
                <div>
                    <img class="bedrock-img" src="<?php echo get_template_directory_uri();?>/assets/images/404rock.svg">
                </div>
            </div>
        </div>

    </section>
<?php }
else {?>
    <div class="instawall-section-container container-fluid" style="margin-top: 200px;">
        <div class="bedrock-container">
            <div>
                <img class="bedrock-img" src="<?php echo get_template_directory_uri();?>/assets/images/404rock.svg">
            </div>
        </div>
    </div>
<?php }
get_footer();?>
