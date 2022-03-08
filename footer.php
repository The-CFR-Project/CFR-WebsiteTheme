</div>

<?php wp_footer();?>
<style type="text/css">   @import url("<?php echo get_template_directory_uri(); ?>/assets/css/homepage-css/footer.css"); </style>
<div id="footer-container">
	
	<?php get_search_form();?>

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
			  echo "<a href='" . $footerItem->url . "'><img src='" . get_template_directory_uri() . "/assets/images/" . $footerItem->title . "-icon.svg'></a>";
			}
		?>
	</div>

	<div id="copyright-bar">
		<small>© The Carbon Footprint Reduction Project</small>
	</div>

</div>
</body>
</html>
