<?php
/**
 * Template part for displaying posts
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
			<?php
			if ( is_singular() ) :
				the_title( '<h1 class="entry-title">', '</h1>' );
			else :
				the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
			endif;
	
			if ( 'post' === get_post_type() ) :
				?>
				<div class="entry-meta">
					<?php
					newsbook_posted_on();
					newsbook_posted_by();
					newsbook_comments_link();
					?>
				</div><!-- .entry-meta -->
			<?php endif; ?>
		</header><!-- .entry-header -->
	
		<div class="entry-summary">
			<?php the_excerpt(); ?>
		</div><!-- .entry-summary -->
	
		<footer class="entry-footer">
			<!-- <?php newsbook_entry_footer(); ?> -->
		</footer><!-- .entry-footer -->
	</div>

</article><!-- #post-<?php the_ID(); ?> -->
