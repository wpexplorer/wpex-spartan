<?php
/**
 * Flickr Widget
 *
 * @author Alexander Clarke
 * @copyright Copyright (c) 2014, Symple Workz LLC
 * @link http://www.wpexplorer.com
 */

// Prevent direct file access
if ( ! defined ( 'ABSPATH' ) ) {
	exit;
}

// Start widget class
if ( ! function_exists( 'wpex_flickr_widget' ) ) :
	class wpex_flickr_widget extends WP_Widget {

		/**
		 * Register widget with WordPress.
		 *
		 * @since 1.0.0
		 */
		public function __construct() {

			parent::__construct(
				'flickr_widget',
				$name = __( 'Flickr Stream', 'spartan' ),
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

			// Define output vars
			$title  = isset( $instance['title'] ) ? $instance['title'] : '';
			$title  = apply_filters( 'widget_title', $title );
			$number = isset( $instance['number'] ) ? $instance['number'] : '';
			$id     = isset( $instance['id'] ) ? $instance['id'] : '';

			// Before widget WP hook
			echo $before_widget;

			// Display widget title
			if ( $title ) {
				echo $before_title . $title . $after_title;
			} ?>

			<div class="wpex-flickr-widget">
				<script type="text/javascript" src="http://www.flickr.com/badge_code_v2.gne?count=<?php echo intval( $number ); ?>&amp;display=latest&amp;size=s&amp;layout=x&amp;source=user&amp;user=<?php echo esc_attr( $id ); ?>"></script>
			</div>

			<?php
			// After widget WP hook
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
			$instance           = $old_instance;
			$instance['title']  = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
			$instance['number'] = ( ! empty( $new_instance['number'] ) ) ? intval( strip_tags( $new_instance['number'] ) ) : '';
			$instance['id']     = ( ! empty( $new_instance['id'] ) ) ? strip_tags( $new_instance['id'] ) : '';
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

			extract( wp_parse_args( (array) $instance, array(
				'title'     =>'Flickr Feed',
				'id'        => '',
				'number'    => 8,
			) ) ); ?>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">
				<?php _e( 'Title:', 'spartan' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'id' ) ); ?>">
				<?php _e( 'Flickr ID ', 'spartan' ); ?>:</label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'id' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'id' ) ); ?>" type="text" value="<?php echo esc_attr( $id ); ?>" />
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>">
				<?php _e( 'Number:', 'spartan' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'number' ) ); ?>" type="text" value="<?php echo esc_attr( $number ); ?>" />
			</p>

		<?php
		}
	}
endif;

add_action( 'widgets_init', function() {
	register_widget( 'wpex_flickr_widget' );
} );