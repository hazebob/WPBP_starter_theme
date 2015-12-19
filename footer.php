<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package WPBP
 */
?>

	</div><!-- #content -->

	<footer class="site-footer">
		<div class="footer-inner">
			<img src="<?php echo get_template_directory_uri(); ?>/assets/images/footlogo.png" alt="<?php bloginfo( 'name' ); ?>">
			<div class="site-info">
				WPBP
			</div><!-- .site-info -->
			<div class="site-copyright">
				Copyright(c), WPBP
			</div><!-- .site-copyright -->
		</div><!-- //footer-inner -->
	</footer><!-- //footer -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
