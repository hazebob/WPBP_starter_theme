<?php
/**
 * @package WPBP
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class('post-single'); ?>>
	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

		<div class="entry-meta">
			<span class="author">
				<i class="xe xi-user"></i>
				<?php the_author(); ?>
			</span>
			<span class="date">
				<i class="xe xi-time"></i>
				<?php the_date('Y.m.d'); ?>
			</span>
			<span class="hit">
				<i class="xe xi-check-boxout"></i>
				<?php //echo(ajax_hits_counter_get_hits(get_the_ID())); ?>
			</span>
		</div><!-- .entry-meta -->
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_content(); ?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<div class="footer-wg tags">
			<h4 class="tit"><i class="xe xi-tags"></i></h4>
			<?php echo taglist($post->ID); ?>
		</div>
		<div class="footer-wg uploads">
			<h4 class="tit">
				<i class="xe xi-download-my"></i>
				첨부 파일
			</h4>
			<?php echo display_uploads($post->ID); ?>
		</div>
	</footer><!-- .entry-footer -->

</article><!-- #post-## -->
