<?php
/**
 * Recent Recent Comments With Avatars Widget
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
if ( ! class_exists( 'wpex_recent_comments_avatars_widget' ) ) {
	class wpex_recent_comments_avatars_widget extends WP_Widget {

		/**
		 * Register widget with WordPress.
		 *
		 * @since 1.0.0
		 */
		public function __construct() {

			parent::__construct(
				'wpex_recent_comments_avatars_widget',
				$name = __( 'Recent Comments With Avatars', 'spartan' ),
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

			// Extract arguments
			extract( $args );

			// Declare setting variables
			$title  = isset( $instance['title'] ) ? $instance['title'] : '';
			$number = isset( $instance['number'] ) ? $instance['number'] : '';

			// Before widget hook
			echo $before_widget;

			// Display title
			if ( $title ) {
				echo $before_title . $title . $after_title;
			} ?>
			<ul class="wpex-recent-comments-widget clr">
				<?php
				// Query Comments
				$comments = get_comments( array (
					'number'        => $number,
					'status'        => 'approve',
					'post_status'   => 'publish',
					'type'          => 'comment'
				) );

				// If Comments exist display them
				if ( $comments ) {

					// Loop through comments and display them
					foreach ( $comments as $comment ) {
						$comment_id = $comment->comment_ID; ?>
						<li class="clr">
							<a href="<?php echo get_permalink( $comment->comment_post_ID ) . '#comment-' . $comment_id; ?>" title="<?php echo esc_attr( __( 'Read Comment', 'spartan' ) ); ?>" class="clr">
								<?php echo get_avatar( $comment->comment_author_email, '55' ); ?>
								<span class="title strong"><?php echo get_comment_author( $comment_id ); ?>:</span> <?php echo wp_trim_words( $comment->comment_content, '10' ); ?>...
							</a>
						</li>
					<?php } ?>
				<?php
				// If no comments are found display notice
				} else { ?>
					<li><?php _e( 'No comments yet.', 'spartan' ); ?></li>
				<?php } ?>
			</ul>
		<?php echo $after_widget;
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
			$instance['title']  = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
			$instance['number'] = ( ! empty( $new_instance['number'] ) ) ? strip_tags( $new_instance['number'] ) : '';
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
				'title'     => __( 'Recent Comments', 'spartan' ),
				'number'    => '3',

			) ) ); ?>
			
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title:', 'spartan' ); ?></label> 
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title','spartan' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>"><?php _e( 'Number to Show:', 'spartan' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'number' ) ); ?>" type="text" value="<?php echo esc_attr( $number ); ?>" />
			</p>
			
			<?php
		}
	}
}

// Register the WPEX_Tabs_Widget custom widget
if ( ! function_exists( 'wpex_register_recet_comments_avatar_widget' ) ) {
	function wpex_register_recet_comments_avatar_widget() {
		register_widget( 'wpex_recent_comments_avatars_widget' );
	}
}
add_action( 'widgets_init', 'wpex_register_recet_comments_avatar_widget' ); ?>