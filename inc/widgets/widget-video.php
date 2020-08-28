<?php
/**
 * Video Widget
 *
 * @author		Alexander Clarke
 * @copyright	Copyright (c) 2014, Symple Workz LLC
 * @link		http://www.wpexplorer.com
 */

// Prevent direct file access
if ( ! defined ( 'ABSPATH' ) ) {
	exit;
}

// Start widget class
if ( ! class_exists( 'wpex_video_widget' ) ) {
	class wpex_video_widget extends WP_Widget {

		/**
		 * Register widget with WordPress.
		 *
		 * @since 1.0.0
		 */
		public function __construct() {

			parent::__construct(
				'wpex_video_widget',
				$name = __( 'Video','spartan' ),
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
		function widget( $args, $instance ) {

			// Extract arguments
			extract( $args );
			
			// Before widget hook
			echo $before_widget;
			
			// Define vars
			$title			= apply_filters( 'widget_title', $instance['title'] );
			$video			= isset( $instance['video_url'] ) ? $instance['video_url'] : '';
			$video			= esc_url( $video );
			$video			= wp_oembed_get( $video );
			$description	= isset( $instance['video_description'] ) ? $instance['video_description'] : '';

			// Display title
			if ( $title ) {
				echo $before_title . $title . $after_title;
			}
			
			// Show video
			if ( $video )  {
				echo '<div class="wpex-video-embed clr">'. $video .'</div>';
			}
			// Display error message
			else { 
				_e( 'You forgot to enter a video URL or you entered an incorrect URL.', 'spartan' );
			}
			
			// Show video description if field isn't empty
			if ( $description ) {
				echo '<div class="wpex-video-widget-description">'. wpex_sanitize_data( $description, 'html' ) .'</div>';
			}

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
			$instance['title']				= ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
			$instance['video_url']			= ( ! empty( $new_instance['video_url'] ) ) ? strip_tags( $new_instance['video_url'] ) : '';
			$instance['video_description']	= ( ! empty( $new_instance['video_description'] ) ) ? strip_tags( $new_instance['video_description'] ) : '';
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
			$instance			= wp_parse_args( (array) $instance, array(
				'title'				=> 'Video',
				'id'				=> '',
				'video_url'			=> '',
				'video_description'	=> ''
			) );
			$title				= strip_tags( $instance['title'] );
			$video_url			= strip_tags( $instance['video_url'] );
			$video_description	= strip_tags( $instance['video_description'] ); ?>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">
				<?php _e( 'Title', 'spartan' ); ?>:</label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'video_url' ) ); ?>">
				<?php _e( 'Video URL', 'spartan' ); ?>:</label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'video_url' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'video_url' ) ); ?>" type="text" value="<?php echo esc_attr( $video_url); ?>" />
				<span style="display:block;padding:5px 0" class="description"><?php _e( 'Enter in a video URL that is compatible with WordPress\'s built-in oEmbed feature.', 'spartan' ); ?></span>
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'video_description' ) ); ?>">
				<?php _e( 'Description', 'spartan' ); ?>:</label>
				<textarea rows="5" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'video_description' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'video_description' ) ); ?>" type="text"><?php echo stripslashes( $instance['video_description'] ); ?></textarea>
			</p>
			
		<?php }
		
	}
}

// Register the widget
if ( ! function_exists( 'wpex_register_video_widget' ) ) {
	function wpex_register_video_widget() {
		register_widget( 'wpex_video_widget' );
	}
}
add_action( 'widgets_init', 'wpex_register_video_widget' ); ?>