<?php
/**
 * Template part for displaying results in search pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package NewsBook
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('nb-post-with-excerpt'); ?>>

	<?php newsbook_post_thumbnail(); ?>

	<div class="nb-card-content">

		<?php newsbook_cats_list(); ?>
		
		<header class="entry-header">
			<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

			<?php if ( 'post' === get_post_type() ) : ?>
			<div class="entry-meta">
				<?php
				newsbook_posted_on();
				newsbook_posted_by();
				?>
			</div><!-- .entry-meta -->
			<?php endif; ?>
		</header><!-- .entry-header -->

		<div class="entry-summary">
			<?php the_excerpt(); ?>
		</div><!-- .entry-summary -->
	</div>

</article><!-- #post-<?php the_ID(); ?> -->
