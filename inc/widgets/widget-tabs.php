<?php
/**
 * Tabs Widget
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
if ( ! class_exists( 'wpex_tabs_widget' ) ) {
	class wpex_tabs_widget extends WP_Widget {

		/**
		 * Register widget with WordPress.
		 *
		 * @since 1.0.0
		 */
		public function __construct() {

			parent::__construct(
				'wpex_tabs_widget',
				$name = __( 'Tabs','spartan' )
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

			// Extract args
			extract( $args );

			// Setup setting variables
			$title              = $instance['title'];
			$popular_number     = isset( $instance['popular_number'] ) ? $instance['popular_number'] : '';
			$recent_number      = isset( $instance['recent_number'] ) ? $instance['recent_number'] : '';
			$comments_number    = isset( $instance['comments_number'] ) ? $instance['comments_number'] : '';
			$img_height         = isset( $instance['img_height'] ) ? $instance['img_height'] : '9999';
			$img_width          = isset( $instance['img_width'] ) ? $instance['img_width'] : '9999';

			// Get current post id to exclude it
			if ( is_singular() ) {
				$exclude = array( get_the_ID() );
			} else {
				$exclude = NULL;
			}

			// Before widget hook
			echo $before_widget;

			// Display title
			if ( $title ) {
				echo $before_title . $title . $after_title;
			}

			// Get global post
			global $post; ?>

			<div class="wpex-tabs-widget clr">
				<div class="wpex-tabs-widget-inner clr">
					<div class="wpex-tabs-widget-tabs clr">
						<ul>
							<?php if ( '0' != $popular_number ) { ?>
								<li><a href="#" data-tab="#wpex-widget-popular-tab" class="active"><?php _e( 'Popular', 'spartan' ); ?></a></li>
							<?php }
							if ( '0' != $recent_number ) { ?>
								<li><a href="#" data-tab="#wpex-widget-recent-tab" <?php if ( '0' == $popular_number ) echo 'class="active"'; ?>><?php _e( 'Recent', 'spartan' ); ?></a></li>
							<?php }
							if ( '0' != $comments_number ) { ?>
							<li><a href="#" data-tab="#wpex-widget-comments-tab" class="last"><?php _e( 'Comments', 'spartan' ); ?></a></li>
							<?php } ?>
						</ul>
					</div><!-- .wpex-tabs-widget-tabs -->
					<?php
					// Popular Tab
					if ( '0' != $popular_number ) {
						// Query Posts
						$wpex_query = new WP_Query( array(
							'post_type'             => 'post',
							'posts_per_page'        => $popular_number,
							'orderby'               => 'comment_count',
							'no_found_rows'         => true,
							'post__not_in'          => $exclude,
							'ignore_sticky_posts'   => true,
						) );
						if ( $wpex_query->have_posts() ) { ?>
							<div id="wpex-widget-popular-tab" class="wpex-tabs-widget-tab active-tab clr">
								<ul class="clr">
									<?php
									$count = '';
									foreach( $wpex_query->posts as $post ) : setup_postdata( $post );
										$count++; ?>
										<li class="clr">
											<a href="<?php the_permalink(); ?>" title="<?php wpex_esc_title(); ?>" class="clr">
												<span class="counter"><?php echo esc_html( $count ); ?></span>
												<span class="title strong"><?php the_title(); ?>:</span> <?php echo wp_trim_words( get_the_content(), '10', '&hellip;' ); ?>
											</a>
										</li>
									<?php endforeach; wp_reset_postdata(); ?>
								</ul>
							</div><!-- wpex-tabs-widget-tab -->
						<?php }
					}
					// Recent tab
					if ( '0' != $recent_number ) {
						// Query Posts
						$wpex_query = new WP_Query( array(
							'post_type'             => 'post',
							'posts_per_page'        => $recent_number,
							'orderby'               => 'date',
							'no_found_rows'         => true,
							'post__not_in'          => $exclude,
							'ignore_sticky_posts'   => true,
							'meta_key'              => '_thumbnail_id',
						) );
						if ( $wpex_query->have_posts() ) { ?>
							<div id="wpex-widget-recent-tab" class="wpex-tabs-widget-tab <?php if ( '0' == $popular_number ) echo 'active-tab'; ?> clr">
								<ul class="clr">
									<?php
									// Loop through Posts
									foreach( $wpex_query->posts as $post ) : setup_postdata( $post );
										// Image
										$image      = wpex_img_resize( wp_get_attachment_url( get_post_thumbnail_id() ), $img_width, $img_height, true, 'array' ); ?>
										<li class="clr">
											<a href="<?php the_permalink(); ?>" title="<?php wpex_esc_title(); ?>" class="clr">
												<img src="<?php echo esc_url( $image['url'] ); ?>" alt="<?php wpex_esc_title(); ?>" width="<?php echo esc_attr( $image['width'] ); ?>" height="<?php echo esc_attr( $image['height'] ); ?>" />
												<span class="title strong"><?php the_title(); ?>:</span> <?php echo wp_trim_words( get_the_content(), '10', '&hellip;' ); ?>
											</a>
										</li>
									<?php endforeach; wp_reset_postdata(); ?>
								</ul>
							</div><!-- wpex-tabs-widget-tab -->
					<?php }
					}
					// Comments tab
					if ( '0' != $comments_number ) { ?>
					<div id="wpex-widget-comments-tab" class="wpex-tabs-widget-tab clr">
						<ul class="clr">
							<?php
							// Query Posts
							$comments = get_comments( array (
								'number'        => $comments_number,
								'status'        => 'approve',
								'post_status'   => 'publish',
								'type'          => 'comment'
							) );
							if ( $comments ) {
								foreach ( $comments as $comment ) {
									$comment_excerpt = wp_trim_words( $comment->comment_content, '10' );
									if ( $comment_excerpt ) { ?>
										<li class="clr">
											<a href="<?php echo get_permalink( $comment->comment_post_ID ) . '#comment-' . $comment->comment_ID; ?>" title="<?php echo esc_attr( __( 'Read Comment', 'spartan' ) ); ?>" class="clr">
												<?php echo get_avatar( $comment->comment_author_email, $img_width ); ?>
												<span class="title strong"><?php echo get_comment_author( $comment->comment_ID ); ?>:</span> <?php echo wp_kses_post( $comment_excerpt ); ?>&hellip;
											</a>
										</li>
									<?php } ?>
								<?php }
							} else { ?>
								<li><?php _e( 'No comments yet.', 'spartan' ); ?></li>
							<?php } ?>
						</ul>
					</div><!-- .wpex-tabs-widget-tab -->
					<?php } ?>
				</div><!-- .wpex-tabs-widget-inner -->
			</div><!-- .wpex-tabs-widget -->
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
			$instance['title']              = strip_tags( $new_instance['title'] );
			$instance['popular_number']     = strip_tags( $new_instance['popular_number'] );
			$instance['recent_number']      = strip_tags( $new_instance['recent_number'] );
			$instance['comments_number']    = strip_tags( $new_instance['comments_number'] );
			$instance['order']              = strip_tags( $new_instance['order'] );
			$instance['img_height']         = strip_tags( $new_instance['img_height'] );
			$instance['img_width']          = strip_tags( $new_instance['img_width'] );
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
				'title'             => '',
				'popular_number'    => '5',
				'recent_number'     => '3',
				'comments_number'   => '3',
				'order'             => 'ASC',
				'img_height'        => '50',
				'img_width'         => '50',
			) ) ); ?>
			
			
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id('title') ); ?>"><?php _e( 'Title:', 'spartan' ); ?></label> 
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id('title') ); ?>" name="<?php echo esc_attr( $this->get_field_name('title','spartan' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'popular_number' ) ); ?>"><?php _e( 'Popular: Number To Show:', 'spartan' ); ?></label> 
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'popular_number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'popular_number' ) ); ?>" type="text" value="<?php echo esc_attr( $popular_number ); ?>" />
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'recent_number' ) ); ?>"><?php _e( 'Recent: Number To Show:', 'spartan' ); ?></label> 
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'recent_number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'recent_number' ) ); ?>" type="text" value="<?php echo esc_attr( $recent_number ); ?>" />
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'comments_number' ) ); ?>"><?php _e( 'Comments: Number To Show:', 'spartan' ); ?></label> 
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'comments_number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'comments_number' ) ); ?>" type="text" value="<?php echo esc_attr( $comments_number ); ?>" />
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id('img_height') ); ?>"><?php _e( 'Image Crop Height:', 'spartan' ); ?></label> 
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id('img_height') ); ?>" name="<?php echo esc_attr(  $this->get_field_name('img_height') ); ?>" type="text" value="<?php echo esc_attr( $img_height ); ?>" />
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id('img_width') ); ?>"><?php _e( 'Image Crop Width:', 'spartan' ); ?></label> 
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id('img_width') ); ?>" name="<?php echo esc_attr( $this->get_field_name('img_width') ); ?>" type="text" value="<?php echo esc_attr( $img_width ); ?>" />
			</p>

			<?php
		}
	}
}

// Register the widget
if ( ! function_exists( 'wpex_register_tabs_widget' ) ) {
	function wpex_register_tabs_widget() {
		register_widget( 'wpex_tabs_widget' );
	}
}
add_action( 'widgets_init', 'wpex_register_tabs_widget' ); ?>