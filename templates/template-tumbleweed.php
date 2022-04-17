<?php 
/*
Template Name: Tumbleweed Newsletter
*/
?>

<?php 
        $newsletters = get_posts([
            'post_type' => 'cfr_newsletters',
            'post_status' => 'publish',
            'numberposts' => -1,
            ]);   

        $all_titles = [];
        $all_content = [];
        $all_pdfs = [];
        $all_editions = [];
        $all_images = [];

        $total_newsletters = count($newsletters);
        $total_articles = 0;
        $total_words = 0;

        if ($newsletters):
            foreach ($newsletters as $newsletter):

                setup_postdata( $newsletter ); 

                array_push($all_titles, get_the_title($newsletter));
                array_push($all_content, get_the_content());
                array_push($all_pdfs, get_post_meta($newsletter->ID, 'upload-newsletter', true));
                array_push($all_editions, get_post_meta($newsletter->ID, 'edition', true));
                array_push($all_images, get_the_post_thumbnail_url($newsletter->ID, 'full'));

                $total_articles += get_post_meta($newsletter->ID, 'number_of_articles', true);
                $total_words += get_post_meta($newsletter->ID, 'number_of_words', true);

                wp_reset_query();

            endforeach;
        endif; 
        
        global $post;   
        $authors = get_post_meta(get_the_ID(), 'authors', true);
        wp_reset_query();
?>

<?php get_header();?>
<style type="text/css">   @import url("<?php echo get_template_directory_uri(); ?>/assets/css/newsletter/tumblweed-newsletter.css"); </style>
<style type="text/css">   @import url("<?php echo get_template_directory_uri(); ?>/assets/css/homepage-css/instawall.css"); </style>

<section id="latest-newsletter-container">
    <img src="<?php echo $all_images[0]; ?>" alt="" class="latest-newsletter-img">

    <div class="latest-newsletter-heading">
        <h3>#1 <?php echo $all_editions[0]; ?></h3>
        <h1><?php echo $all_titles[0]; ?></h1>
    </div>

    <a download='<?php echo $all_titles[0]; ?>-CFR-Newsletter' href='<?php echo wp_get_attachment_url($all_pdfs[0]); ?>' class="latest-newsletter-download">
        <button>
            download
        </button>
    </a>

    <div class="latest-newsletter-content">
        <p><?php echo $all_content[0]; ?></p>
    </div>
</section>




<section id="subscription-form-container">

    <div class="subscription-form-header">
        <div class="subscription-form-text">
            <h1>Tumbleweed</h1>
            <h3>Subscribe to CFR's Newsletter</h3>
        </div>
        <div class="subscription-form-image">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/placeholder-image.svg" alt="tumbleweed-logo">
        </div>
    </div>

    <div class="form-sidebar-container">
        <?php if ( is_active_sidebar( 'tw-subscription-form' ) ) : ?>
            <?php dynamic_sidebar( 'tw-subscription-form' ); ?>
        <?php endif; ?>
    </div>

    <script>
        document.getElementsByClassName('mailpoet_submit')[0].style = '';
        document.getElementsByClassName('mailpoet_text')[0].style = '';
    </script>

</section>



<section id="newsletter-stats-container">
    
    <div class="heading-container">
        <div class="heading-overlay">we've worked hard</div>
        <div class="heading-watermark">stats</div>
    </div>

    <div class="stats row">
        <div class="col-md-4">
            <div class="stat editions-stat">
                <h3><?php echo $total_newsletters; ?></h3>
                <p>editions</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat articles-stat">
                <h3><?php echo $total_articles; ?></h3>
                <p>articles</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat words-stat">
                <h3><?php echo $total_words; ?></h3>
                <p>words</p>
            </div>
        </div>
    </div>

</section>



<section></section>



<section id="newsletter-archive-container">
    <div class="heading-container">
        <div class="heading-overlay">you checkin' me out?</div>
        <div class="heading-watermark">editions</div>
    </div>
    <div class="row">
        <?php for($i = 0; $i < count($newsletters); $i++): ?>

                <div class="col-md-6 newsletter-container">
                    <div class="newsletter">
                        <img src="<?php echo $all_images[$i]; ?>" style="width:100%;" class="newsletter-tn">
                        <div class="newsletter-content">
                            <a download='<?php echo $all_titles[$i]; ?>-CFR-Newsletter' href='<?php echo wp_get_attachment_url($all_pdfs[$i]); ?>'>
                                <button class="download-newsletter-btn">
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/download-icon.svg" alt="">
                                </button>
                            </a>    
                            <div class="newsletter-text">
                                <h4><?php echo $all_titles[$i]; ?></h4>
                                <p><?php echo $all_editions[$i]; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
        
        <?php endfor; ?>    
    </div>
</section>




<section id="newsletter-authors-container">

    <div class="heading-container">
        <div class="heading-overlay">our wordsmiths</div>
    </div>

    <div class="authors-container">
        <div class="authors" id="authors">
            <?php foreach ($authors as $authorID): ?>
                <div class="author">
                    <img src="<?php echo wp_get_attachment_image_src(get_post_meta($authorID, 'photo', true))[0]; ?>" alt="">
                    <div class="author-deets">
                        <h3><?php echo get_the_title($authorID); ?></h3>
                        <p>Editor</p>
                    </div>

                </div>
            <?php endforeach; ?>
        </div>
        <button id="prev-author" onclick='prevAuthor()'>&#10094;</button>
        <button id="next-author" onclick='nextAuthor()'>&#10095;</button>
    </div>

    <div class="instawall-section-container container-fluid">
        <div class="bedrock-container">
            <div>
                <img class="bedrock-img" src="<?php echo get_template_directory_uri();?>/assets/images/instarock.svg">
            </div>
        </div>
    </div>



    <script>
        // Variables
        let authorsContainer = document.getElementById("authors");
        let authors = document.getElementsByClassName("author");
        let visibleAuthors = 3;

        // Functions
        function hideAuthors(){
            for (i=0;i<authors.length;i++){
                authors[i].classList.add("hidden-authors");
            }
        }
        function showAuthors(visibleAuthors){
            console.log("executed showAuthors");
            authors = document.getElementsByClassName("author");
            // console.log(authors[0], authors[1], authors[2]);
            for (i=0;i<authors.length;i++){
                if (i < visibleAuthors){
                    authors[i].classList.remove("hidden-authors");
                    authors[i].classList.add("visible-authors");
                } else {
                    authors[i].classList.add("hidden-authors");
                    authors[i].classList.remove("visible-authors");
                }
            }
        }
        function nextAuthor(){               
            authorsContainer.firstChild.before(authorsContainer.lastChild);
            showAuthors(visibleAuthors);
            console.log(authors);
        }
        function prevAuthor(){
            authorsContainer.lastChild.after(authorsContainer.firstChild);
            showAuthors(visibleAuthors);
            console.log(authors);
        }
        
        // Main
        hideAuthors(); 
        showAuthors(visibleAuthors);

    </script>

</section>

<?php get_footer();?>