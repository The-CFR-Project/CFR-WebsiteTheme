<div class="full-search-container">
<style type="text/css">   @import url("<?php echo get_template_directory_uri(); ?>/assets/css/homepage-css/footer.css"); </style>

<!-- Load icon library -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<form method = "get">
    <input type="text" placeholder="Search the CFR Blogs..." name="s" value="<?php the_search_query(); ?>">
    <button type="submit" formaction = "/">
        <img src="<?php echo get_template_directory_uri();?>/assets/images/search.svg">
    </button>
</form>

</div>
