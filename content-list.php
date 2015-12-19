<?php
/**
 * @package WPBP
 */
?>

<li id="post-<?php the_ID(); ?>" <?php post_class('lm'); ?>>
	<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
		<?php if(has_post_thumbnail()) { ?>
			<div class="img"><?php the_post_thumbnail('full'); ?></div>
		<?php } ?>
		<div class="cont">
			<h1><?php the_title(); ?></h1>
			<div class="txt">
				<?php the_excerpt(); ?>
			</div><!-- .entry-content -->
		</div>
	</a>
</li><!-- #post-## -->
