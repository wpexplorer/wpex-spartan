<?php
/**
 * Recent posts with icons widget
 *
 * @author      Alexander Clarke
 * @copyright   Copyright (c) 2014, Symple Workz LLC
 * @link        http://www.wpexplorer.com
 */

// Prevent direct file access
if ( ! defined ( 'ABSPATH' ) ) {
	exit;
}

// Start widget class
if ( ! class_exists( 'wpex_recent_posts_icons_widget' ) ) {
	class wpex_recent_posts_icons_widget extends WP_Widget {
	
		/**
		 * Register widget with WordPress.
		 *
		 * @since 1.0.0
		 */
		public function __construct() {

			parent::__construct(
				'wpex_recent_posts_icons_widget',
				$name = __( 'Recent Posts With Icons', 'spartan' ),
				array(
					'customize_selective_refresh' => true,
				)
			);

		}

		/**
		 * Front-end display of widget.
		 *
		 * @see WP_Widget::widget()
		 * @since 1.0.0
		 *
		 *
		 * @param array $args     Widget arguments.
		 * @param array $instance Saved values from database.
		 */
		public function widget( $args, $instance ) {

			// Extract widget args
			extract( $args );

			// Set vars
			$title    = $instance['title'];
			$number   = isset( $instance['number'] ) ? $instance['number'] : '5';
			$order    = isset( $instance['order'] ) ? $instance['order'] : 'DESC';
			$orderby  = isset( $instance['orderby'] ) ? $instance['orderby'] : 'date';
			$category = isset( $instance['category'] ) ? $instance['category'] : 'all';

			// Exclude current post ID
			if ( is_singular() ) {
				$exclude = array( get_the_ID() );
			} else {
				$exclude = NULL;
			}

			 // Before widget WP hook
			echo $before_widget;

			// Title
			if ( $title ) {
				echo $before_title . $title . $after_title;
			}
				// Category
				if ( ! empty( $category ) && 'all' != $category ) {
					$taxonomy = array( array (
						'taxonomy'  => 'category',
						'field'     => 'id',
						'terms'     => $category
					) );
				} else {
					$taxonomy = NUll;
				}

				// Query Posts
				global $post;
				$wpex_query = new WP_Query( array(
					'post_type'           => 'post',
					'posts_per_page'      => $number,
					'orderby'             => $orderby,
					'order'               => $order,
					'no_found_rows'       => true,
					'post__not_in'        => $exclude,
					'tax_query'           => $taxonomy,
					'ignore_sticky_posts' => 1,
				) );

				// Loop through posts
				if ( $wpex_query->have_posts() ) { ?>
					<ul class="widget-recent-posts-icons clr">
						<?php foreach( $wpex_query->posts as $post ) : setup_postdata( $post ); ?>
							<li class="clr">
								<a href="<?php the_permalink() ?>" title="<?php wpex_esc_title(); ?>">
									<span class="fa <?php wpex_post_format_icon(); ?>"></span><?php the_title(); ?>
								</a>
							</li>
						<?php endforeach; ?>
					</ul>
				<?php }

			// Reset post data
			wp_reset_postdata();

			// After widget hook
			echo $after_widget;
		}

		/**
		 * Sanitize widget form values as they are saved.
		 *
		 * @see WP_Widget::update()
		 * @since 1.0.0
		 *
		 * @param array $new_instance Values just sent to be saved.
		 * @param array $old_instance Previously saved values from database.
		 *
		 * @return array Updated safe values to be saved.
		 */
		public function update( $new_instance, $old_instance ) {
			$instance = $old_instance;
			$instance['title']      = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
			$instance['number']     = ( ! empty( $new_instance['number'] ) ) ? strip_tags( $new_instance['number'] ) : '';
			$instance['order']      = ( ! empty( $new_instance['order'] ) ) ? strip_tags( $new_instance['order'] ) : '';
			$instance['orderby']    = ( ! empty( $new_instance['orderby'] ) ) ? strip_tags( $new_instance['orderby'] ) : '';
			$instance['category']   = ( ! empty( $new_instance['category'] ) ) ? strip_tags( $new_instance['category'] ) : '';
			return $instance;
		}

		/**
		 * Back-end widget form.
		 *
		 * @see WP_Widget::form()
		 * @since 1.0.0
		 *
		 * @param array $instance Previously saved values from database.
		 */
		public function form( $instance ) {
			extract( wp_parse_args( ( array ) $instance, array(
				'title'    => __( 'Recent Posts','spartan' ),
				'number'   => '5',
				'order'    => 'DESC',
				'orderby'  => 'date',
				'category' => 'all',
			) ) ); ?>
			
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title', 'spartan' ); ?>:</label> 
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title','spartan' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>"><?php _e( 'Number to Show', 'spartan' ); ?>:</label> 
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'number' ) ); ?>" type="text" value="<?php echo esc_attr( $number ); ?>" />
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'order' ) ); ?>"><?php _e( 'Order', 'spartan' ); ?>:</label>
				<br />
				<select class='wpex-select' name="<?php echo esc_attr( $this->get_field_name( 'order' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'order' ) ); ?>">
				<option value="DESC" <?php if ( $order == 'DESC' ) { ?>selected="selected"<?php } ?>><?php _e( 'Descending', 'spartan' ); ?></option>
				<option value="ASC" <?php if ( $order == 'ASC' ) { ?>selected="selected"<?php } ?>><?php _e( 'Ascending', 'spartan' ); ?></option>
				</select>
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'orderby' ) ); ?>"><?php _e( 'Order By', 'spartan' ); ?>:</label>
				<br />
				<select class='wpex-select' name="<?php echo esc_attr( $this->get_field_name( 'orderby' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'orderby' ) ); ?>">
				<?php $orderby_array = array(
					'date'          => __( 'Date', 'spartan' ),
					'title'         => __( 'Title', 'spartan' ),
					'modified'      => __( 'Modified', 'spartan' ),
					'author'        => __( 'Author', 'spartan' ),
					'rand'          => __( 'Random', 'spartan' ),
					'comment_count' => __( 'Comment Count', 'spartan' ),
				);
				foreach ( $orderby_array as $key => $value ) { ?>
					<option value="<?php echo esc_attr( $key ); ?>" <?php if ( $orderby == $key ) { ?>selected="selected"<?php } ?>>
						<?php echo esc_attr( $value ); ?>
					</option>
				<?php } ?>
				</select>
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'category' ) ); ?>"><?php _e( 'Category', 'spartan' ); ?>:</label>
				<br />
				<select class='wpex-select' name="<?php echo esc_attr( $this->get_field_name( 'category' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'category' ) ); ?>">
				<option value="all" <?php if ( $category == 'all' ) { ?>selected="selected"<?php } ?>><?php _e( 'All', 'spartan' ); ?></option>
				<?php
				$terms = get_terms( 'category' );
				foreach ( $terms as $term ) { ?>
					<option value="<?php echo esc_attr( $term->term_id ); ?>" <?php if ( $category == $term->term_id ) { ?>selected="selected"<?php } ?>><?php echo esc_attr( $term->name ); ?></option>
				<?php } ?>
				</select>
			</p>

			<?php
		}
	}
}
// Register the widget
if ( ! function_exists( 'wpex_register_recent_posts_icons_widget' ) ) {
	function wpex_register_recent_posts_icons_widget() {
		register_widget( 'wpex_recent_posts_icons_widget' );
	}
}
add_action( 'widgets_init', 'wpex_register_recent_posts_icons_widget' ); ?>