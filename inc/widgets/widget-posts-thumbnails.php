<?php
/**
 * Recent Posts w/ Thumbnails
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
if ( ! class_exists( 'wpex_recent_posts_thumb_widget' ) ) {
	class wpex_recent_posts_thumb_widget extends WP_Widget {

		/**
		 * Register widget with WordPress.
		 *
		 * @since 1.0.0
		 */
		public function __construct() {

			parent::__construct(
				'wpex_recent_posts_thumb_widget',
				$name = __( 'Posts With Thumbnails', 'spartan' ),
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

			// Extract args
			extract( $args );

			// Define vars
			$title		= $instance['title'];
			$number		= isset( $instance['number'] ) ? $instance['number'] : '3';
			$order		= isset( $instance['order'] ) ? $instance['order'] : 'DESC';
			$orderby	= isset( $instance['orderby'] ) ? $instance['orderby'] : 'date';
			$style		= isset( $instance['style'] ) ? $instance['style'] : 'left-thumbnail';
			$date		= isset( $instance['date'] ) ? $instance['date'] : '';
			$img_height	= isset( $instance['img_height'] ) ? $instance['img_height'] : '90';
			$img_width	= isset( $instance['img_width'] ) ? $instance['img_width'] : '140';
			$img_height	= $img_height ? $img_height : '9999';
			$img_width	= $img_width ? $img_width : '9999';
			$category	= isset( $instance['category'] ) ? $instance['category'] : 'all';
			$format		= isset( $instance['format'] ) ? $instance['format'] : 'all';

			// Exclude current post
			if ( is_singular() ) {
				$exclude = array( get_the_ID() );
			} else {
				$exclude = NULL;
			}

			// Before widget WP hook
			echo $before_widget;

				// Output title
				if ( $title ) {
					// Title
					echo $before_title . $title . $after_title;
				}
				// Create Category tax_query
				if ( !empty( $category ) && 'all' != $category ) {
					$taxonomy = array (
						'taxonomy'	=> 'category',
						'field'		=> 'id',
						'terms'		=> $category,
					);
				} else {
					$taxonomy = NUll;
				}
				// Create format tax_query
				if ( $format && 'all' != $format ) {
					$format_query = array (
						'taxonomy'	=> 'post_format',
						'field'		=> 'slug',
						'terms'		=> array( 'post-format-'. $format ),
					);
				} else {
					$format_query = NULL;
				}
				// Query Posts
				global $post;
				$wpex_query = new WP_Query( array(
					'post_type'				=> 'post',
					'posts_per_page'		=> $number,
					'orderby'				=> $orderby,
					'order'					=> $order,
					'no_found_rows'			=> true,
					'meta_key'				=> '_thumbnail_id',
					'post__not_in'			=> $exclude,
					'tax_query'				=> array(
						'relation' => 'AND',
						$taxonomy,
						$format_query,
					),
					'ignore_sticky_posts'	=> true
				) );
				// Loop through posts
				if ( $wpex_query->have_posts() ) { ?>
				
					<ul class="widget-recent-posts clr">
						<?php foreach( $wpex_query->posts as $post ) : setup_postdata( $post );
							// Image
							$image = wpex_img_resize( wp_get_attachment_url( get_post_thumbnail_id() ), $img_width, $img_height, true, 'array' ); ?>

							<li class="clr widget-recent-posts-li <?php echo $style; ?> format-<?php echo get_post_format(); ?>">
								<a href="<?php the_permalink(); ?>" title="<?php wpex_esc_title(); ?>" class="widget-recent-posts-thumbnail clr">
									<img src="<?php echo $image['url']; ?>" alt="<?php wpex_esc_title(); ?>" width="<?php echo $image['width']; ?>" height="<?php echo $image['height']; ?>" />
								</a>
								<div class="widget-recent-posts-content clr">
									<a href="<?php the_permalink(); ?>" title="<?php wpex_esc_title(); ?>" class="widget-recent-posts-title"><?php the_title(); ?></a>
									<?php if ( $date !== '1' ) { ?>
										<div class="widget-recent-posts-date"><?php echo get_the_date(); ?></div>
									<?php } ?>
									</div><!-- .widget-recent-posts-content -->
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
			$instance['title']		= ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
			$instance['number']		= ( ! empty( $new_instance['number'] ) ) ? strip_tags( $new_instance['number'] ) : '';
			$instance['style']		= ( ! empty( $new_instance['style'] ) ) ? strip_tags( $new_instance['style'] ) : '';
			$instance['order']		= ( ! empty( $new_instance['order'] ) ) ? strip_tags( $new_instance['order'] ) : '';
			$instance['orderby']	= ( ! empty( $new_instance['orderby'] ) ) ? strip_tags( $new_instance['orderby'] ) : '';
			$instance['date']		= ( ! empty( $new_instance['date'] ) ) ? strip_tags( $new_instance['date'] ) : '';;
			$instance['category']	= ( ! empty( $new_instance['category'] ) ) ? strip_tags( $new_instance['category'] ) : '';
			$instance['format']		= ( ! empty( $new_instance['format'] ) ) ? strip_tags( $new_instance['format'] ) : '';
			$instance['img_height']	= ( ! empty( $new_instance['img_height'] ) ) ? strip_tags( $new_instance['img_height'] ) : '';
			$instance['img_width']	= ( ! empty( $new_instance['img_width'] ) ) ? strip_tags( $new_instance['img_width'] ) : '';
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

			// Setup instance vars
			extract( wp_parse_args( (array) $instance, array(
				'title'			=> __( 'Recent Posts','spartan' ),
				'style'			=> 'left-thumbnail',
				'number'		=> '3',
				'order'			=> 'DESC',
				'orderby'		=> 'date',
				'date'			=> '',
				'img_height'	=> '90',
				'img_width'		=> '140',
				'category'		=> 'all',
				'format'		=> 'all',

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
				<label for="<?php echo esc_attr( $this->get_field_id( 'img_width' ) ); ?>"><?php _e( 'Image Crop Width', 'spartan' ); ?>:</label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'img_width' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'img_width' ) ); ?>" type="text" value="<?php echo esc_attr( $img_width ); ?>" />
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'img_height' ) ); ?>"><?php _e( 'Image Crop Height', 'spartan' ); ?>:</label> 
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'img_height' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'img_height' ) ); ?>" type="text" value="<?php echo esc_attr( $img_height ); ?>" />
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'style' ) ); ?>"><?php _e( 'Style', 'spartan' ); ?>:</label>
				<br />
				<select class='wpex-select' name="<?php echo esc_attr( $this->get_field_name( 'style' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'style' ) ); ?>">
				<option value="left-thumbnail" <?php if ($style == 'left-thumbnail' ) { ?>selected="selected"<?php } ?>><?php _e( 'Left Thumbnail', 'spartan' ); ?></option>
				<option value="top-thumbnail" <?php if ($style == 'top-thumbnail' ) { ?>selected="selected"<?php } ?>><?php _e( 'Top Thumbnail', 'spartan' ); ?></option>
				</select>
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
				<?php $orderby_array = array (
					'date'			=> __( 'Date', 'spartan' ),
					'title'			=> __( 'Title', 'spartan' ),
					'modified'		=> __( 'Modified', 'spartan' ),
					'author'		=> __( 'Author', 'spartan' ),
					'rand'			=> __( 'Random', 'spartan' ),
					'comment_count'	=> __( 'Comment Count', 'spartan' ),
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
				<option value="all" <?php if ($category == 'all' ) { ?>selected="selected"<?php } ?>><?php _e( 'All', 'spartan' ); ?></option>
				<?php $terms = get_terms( 'category' );
				foreach ( $terms as $term ) { ?>
					<option value="<?php echo esc_attr( $term->term_id ); ?>" <?php if ( $category == $term->term_id ) { ?>selected="selected"<?php } ?>><?php echo esc_attr( $term->name ); ?></option>
				<?php } ?>
				</select>
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'format' ) ); ?>"><?php _e( 'Format', 'spartan' ); ?>:</label>
				<br />
				<select class='wpex-select' name="<?php echo esc_attr( $this->get_field_name( 'format' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'format' ) ); ?>">
				<option value="all" <?php if ( $format == 'all' ) { ?>selected="selected"<?php } ?>><?php _e( 'All', 'spartan' ); ?></option>
				<?php $terms = array( 'video', 'audio', 'gallery' );
				foreach ( $terms as $term ) { ?>
					<option value="<?php echo esc_attr( $term ); ?>" <?php if ( $format == $term ) { ?>selected="selected"<?php } ?>><?php echo esc_attr( $term ); ?></option>
				<?php } ?>
				</select>
			</p>

			<p>
				<input id="<?php echo esc_attr( $this->get_field_id( 'date' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'date' ) ); ?>" type="checkbox" value="1" <?php checked( '1', $date ); ?> />
				<label for="<?php echo esc_attr( $this->get_field_id( 'date' ) ); ?>"><?php _e( 'Disable Date?', 'spartan' ); ?></label>
			</p>
			<?php
		}
	}
}

// Register the widget
if ( ! function_exists( 'wpex_register_recent_posts_thumb_widget' ) ) {
    function wpex_register_recent_posts_thumb_widget() {
        register_widget( 'wpex_recent_posts_thumb_widget' );
    }
}
add_action( 'widgets_init', 'wpex_register_recent_posts_thumb_widget' ); ?>