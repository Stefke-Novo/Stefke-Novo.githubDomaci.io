<?php
/**
 * NewsBook Add Simple Featured Posts Widget.
 *
 * @package NewsBook
 */

/**
 * Newsbook_Simple_Featured_Posts_Widget
 */
class Newsbook_Simple_Featured_Posts_Widget extends WP_Widget {

	/**
	 * __construct
	 *
	 * @return void
	 */
	public function __construct() {
		$widget_ops = array(
			'classname'                   => 'nb-widget-simple-featured-posts',
			'description'                 => __( 'Displays latest posts or posts of specific category. Suitable for content top area.', 'newsbook' ),
			'customize_selective_refresh' => true,
		);
		parent::__construct( false, $name = __( 'NB: Simple Featured Posts', 'newsbook' ), $widget_ops );
	}

	/**
	 * Widget Form
	 *
	 * @param  mixed $instance instance.
	 * @return void
	 */
	public function form( $instance ) {
		$tg_defaults['title']    = esc_html__( 'Featured Posts', 'newsbook' );
		$tg_defaults['number']   = 4;
		$tg_defaults['category'] = '';
		$instance                = wp_parse_args( (array) $instance, $tg_defaults );
		$title                   = $instance['title'];
		$number                  = $instance['number'];
		$category                = $instance['category'];
		?>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'newsbook' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>"><?php esc_html_e( 'Number of Posts to Display:', 'newsbook' ); ?></label>
			<input class="tiny-text" id="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'number' ) ); ?>" type="number" value="<?php echo esc_html( $number ); ?>" size="3" step="1" min="1" max="8" />
		</p>

		<p><?php esc_html_e( 'If no category is selected from below dropdown, latest posts will be displayed.', 'newsbook' ); ?></p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'category' ) ); ?>"><?php esc_html_e( 'Select Category: ', 'newsbook' ); ?></label>
			<?php
			wp_dropdown_categories(
				array(
					'show_option_none' => esc_html__( 'Select Category', 'newsbook' ),
					'name'             => $this->get_field_name( 'category' ),
					'selected'         => $category,
				)
			);
			?>
		</p>
		<?php
	}

	/**
	 * Update widget form.
	 *
	 * @param  mixed $new_instance New Instance.
	 * @param  mixed $old_instance Old instance.
	 * @return string
	 */
	public function update( $new_instance, $old_instance ) {
		$instance             = $old_instance;
		$instance['number']   = absint( $new_instance['number'] );
		$instance['title']    = sanitize_text_field( $new_instance['title'] );
		$instance['category'] = absint( $new_instance['category'] );

		return $instance;
	}

	/**
	 * Widget.
	 *
	 * @param  mixed $args arguments.
	 * @param  mixed $instance instance.
	 * @return void
	 */
	public function widget( $args, $instance ) {

		$title    = isset( $instance['title'] ) ? $instance['title'] : '';
		$number   = empty( $instance['number'] ) ? 4 : $instance['number'];
		$category = isset( $instance['category'] ) ? $instance['category'] : 0;

		if ( '-1' === $category || -1 === $category ) {
			$category = 0;
		}

		$query_args = array(
			'posts_per_page'      => $number,
			'post_type'           => 'post',
			'ignore_sticky_posts' => true,
			'post_status'         => 'publish',
			'no_found_rows'       => true,
			'cat'                 => $category,
		);

		$newsbook_featured_posts = new WP_Query( $query_args );

		if ( $newsbook_featured_posts->have_posts() ) :

			echo wp_kses_post( $args['before_widget'] );
			?>
				<div class="nb-simple-featured-posts">
					<?php if ( ! empty( $title ) ) : ?>
					<div class="nb-simple-featured-title">
						<?php
						echo wp_kses_post( $args['before_title'] );
						echo esc_html( $title );
						echo wp_kses_post( $args['after_title'] );
						?>
					</div>
					<?php endif; ?>

					<div class="nb-simple-featured-posts-wrap row">
						<?php
						while ( $newsbook_featured_posts->have_posts() ) :
							$newsbook_featured_posts->the_post();
							?>
							<article class="nb-featured-article col-md-3 post">
								<?php
								if ( has_post_thumbnail() ) {
									newsbook_post_thumbnail( 'medium' );
								}
								// newsbook_cats_list(); Use Widget settings to show/hide categories & other meta.
								?>
								<header class="entry-header">
									<?php
									the_title( '<h3 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' );
									?>
									<div class="entry-meta">
										<?php
										newsbook_posted_on();
										newsbook_posted_by();
										?>
									</div><!-- .entry-meta -->
								</header><!-- .entry-header -->
							</article>
							<?php
						endwhile;
						wp_reset_postdata();
						?>
					</div>

				</div>
			<?php
			echo wp_kses_post( $args['after_widget'] );
		endif;
	}

}
