</div>

<?php wp_footer();?>
<style type="text/css">   @import url("<?php echo get_template_directory_uri(); ?>/css/homepage-css/footer.css"); </style>
<div id="footer-container">
	<div class="full-search-container">

		<!-- Load icon library -->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

		<form action="action_page.php">
			<input type="text" placeholder="Search the CFR website..." name="search">
			<button type="submit">
				<img src="<?php echo get_template_directory_uri();?>/images/search.svg">
			</button>
		</form>

	</div>

	<?php
	wp_nav_menu(
		array(
		"theme_location" => "footer",
		"menu_class" => "footer"
		)
		);
	?>

	<div id="footer-social-bar">
		<?php
			$socialItems = wp_get_nav_menu_items(get_nav_menu_locations()['footer-social']);
			foreach ( $socialItems as $footerItem ) {
			  echo "<a href='" . $footerItem->url . "'><img src='" . get_template_directory_uri() . "/images/" . $footerItem->title . "-icon.svg'></a>";
			}
		?>
	</div>

	<div id="copyright-bar">
		<small>© The Carbon Footprint Reduction Project</small>
	</div>

</div>

<script  type='text/javascript' src = "<?php echo get_template_directory_uri(); ?>/js/mobile.js"></script>
</body>
</html>
