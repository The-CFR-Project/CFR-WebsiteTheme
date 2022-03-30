<section id="gameshow-our-guests" style="padding: 0 5vw;">
    <style type="text/css">   @import url("<?php echo get_template_directory_uri(); ?>/assets/css/gameshow-page-css/gameshow-our-guests.css"); </style>
    <div class="heading-container">
        <?php
            echo "<div class='heading-overlay'>our guests!</div>";
            echo "<div class='heading-watermark'>experts</div>";
        ?>
    </div>

    <div class="guests">

        <?php
            // Returns cfr-member and gameshow-guest 
            $roles = get_terms( array(
                'taxonomy' => 'cfr_role',
                'hide_empty' => false,
            ) );

            foreach ($roles as $role) { //Loops over each role
                if ($role->name == 'Gameshow Guest'){
                    $guests = get_posts([
                        'post_type' => 'cfr_people',
                        'post_status' => 'publish',
                        'cfr_role' => $role->name,
                        'numberposts' => -1,
                        ]);    
                    $totalGuests = count($guests);
                }
            }  
            
        ?>

        <?php
            $i = 0; 
            if ($guests){
                forEach ($guests as $guest) {
                    setup_postdata( $guest ); 
                    echo "<div class='guest'>";
                        if (get_post_field( 'guest_episodes', $guest->ID )[0] == "Magic") {
                            echo "<div class='episode-color' style='background: linear-gradient(to bottom right, #A577FF, #7A50CD)'></div>";
                        } else if (get_post_field( 'guest_episodes', $guest->ID )[0] == "Sci-Fi") {
                            echo "<div class='episode-color' style='background: linear-gradient(to bottom right, #FFBD59, #C49042)'></div>";
                        } else if (get_post_field( 'guest_episodes', $guest->ID )[0] == "Disney") {
                            echo "<div class='episode-color' style='background: linear-gradient(to bottom right, #88D172, #6AA858)'></div>";
                        } else if (get_post_field( 'guest_episodes', $guest->ID )[0] == "Dinosaurs") {
                            echo "<div class='episode-color' style='background: linear-gradient(to bottom right, #FF5757, #B64141)'></div>";
                        } else if (get_post_field( 'guest_episodes', $guest->ID )[0] == "Marvel") {
                            echo "<div class='episode-color' style='background: linear-gradient(to bottom right, #6699CC, #4A84BD)'></div>";
                        } else if (get_post_field( 'guest_episodes', $guest->ID )[0] == "Oceans") {
                            echo "<div class='episode-color' style='background: linear-gradient(to bottom right, #8092E6, #5365BF)'></div>";
                        } else {
                            echo "<div class='episode-color' style='background: linear-gradient(to bottom right, #8092E6, #5365BF)'></div>";
                        }

                        echo "
                                <div class='about-guest'>
                                    <img src='" . wp_get_attachment_image_src(get_post_meta($guest->ID, 'photo', true))[0] . "' alt='' class='guest-pfp'/>
                                    <div class='guest-name'>" . get_post_field( 'post_title', $guest->ID ) . "</div>
                                    <div class='guest-role'>" . get_post_meta($guest->ID, 'organisation', true) . "</div>
                                    <div class='guest-description'>" . get_post_field( 'post_content', $guest->ID ) . "</div>
                                    <div class='row guest-socials'>
                        ";

                        if (get_post_meta($guest->ID, 'facebook')[0]){
                            echo "
                                    <div class='col'>
                                        <a href='" . get_post_meta($guest->ID, 'facebook')[0] . "' target='_blank'>
                                            <img src='" . get_template_directory_uri() . "/assets/images/facebook-icon.svg' alt='' width='35px'>
                                        </a>
                                    </div>               
                            ";
                        }    
                        if (get_post_meta($guest->ID, 'linkedin')[0]) {
                            echo "
                                    <div class='col'>
                                        <a href='" . get_post_meta($guest->ID, 'linkedin')[0] . "' target='_blank'>
                                            <img src='" . get_template_directory_uri() . "/assets/images/linkedin-icon.svg' alt='' width='35px'>
                                        </a>
                                    </div>
                            ";
                        }    
                        if (get_post_meta($guest->ID, 'instagram')[0]) {
                            echo "
                                    <div class='col'>
                                        <a href='" . get_post_meta($guest->ID, 'instagram')[0] . "' target='_blank'>
                                            <img src='" . get_template_directory_uri() . "/assets/images/instagram-icon.svg' alt='' width='35px'>
                                        </a>
                                    </div>
                            ";
                        }
                        if (get_post_meta($guest->ID, 'website')[0]) { 
                            echo "
                                    <div class='col'>
                                        <a href='" . get_post_meta($guest->ID, 'website')[0] . "' target='_blank'>
                                            <img src='" . get_template_directory_uri() . "/assets/images/twitter-icon.svg' alt='' width='35px'>
                                        </a>
                                    </div>
                            ";
                        }    
                    echo "
                                </div>
                            </div>
                        </div>            
                    ";

                    $i++;
                    wp_reset_postdata();
                }
            }   
        ?>

    </div>
</section>
