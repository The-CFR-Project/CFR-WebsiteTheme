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

<style type="text/css">   @import url("<?php echo get_template_directory_uri(); ?>/assets/css/people-css/single-person.css"); </style>

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
        <div class="row">
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

                    $gameshow_expert = in_array( "Gameshow Guest", get_the_terms( get_the_ID(), "cfr_role") ) and !$member;
                    $gameshow_member = in_array( "Gameshow Guest", get_the_terms( get_the_ID(), "cfr_role") ) and $member
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
                    <?php
                    echo "<div class='heading-overlay'>" . $post->post_title . "</div>";
                    echo "<div class='heading-watermark'>CFR</div>";
                    ?>
                </div>
            </div>
        </div>

        <div class="row" style="margin-top: -50px;">
            <div class="col-md-4" style="display: flex; justify-content: center; align-items: center">
                <div>
                    <div class="row">
                        <div class="col-md-6 social-icon-container">
                            <a href="<?php the_field('linkedin');?>">
                            <img class="social-icon" src="<?php echo get_template_directory_uri();?>/assets/images/linkedin-icon.svg">
                            </a>
                        </div>
                        <div class="col-md-6 social-icon-container">
                            <a href="<?php the_field('instagram');?>">
                            <img class="social-icon" src="<?php echo get_template_directory_uri();?>/assets/images/instagram-icon.svg">
                            </a>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 social-icon-container">
                            <a href="<?php the_field('facebook');?>">
                            <img class="social-icon" src="<?php echo get_template_directory_uri();?>/assets/images/facebook-icon.svg">
                            </a>
                        </div>
                        <div class="col-md-6 social-icon-container">
                            <a href="<?php the_field('website');?>">
                            <img class="social-icon" src="<?php echo get_template_directory_uri();?>/assets/images/share-icon.svg">
                            </a>
                        </div>
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

<section>
    <div class="heading-container">
        <?php
        echo "<div class='heading-overlay'>" . "know more!" . "</div>";
        ?>
    </div>

    <div class="container description-container">
        <?php echo get_other_paragraphs();?>
    </div>

    <div class="instawall-section-container container-fluid" style="margin-top: 200px;">
        <div class="bedrock-container">
            <div>
                <img class="bedrock-img" src="<?php echo get_template_directory_uri();?>/assets/images/404rock.svg">
            </div>
        </div>
    </div>
</section>

<?php get_footer();?>
