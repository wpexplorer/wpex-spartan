<?php
/**
 * Social Widget
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
if ( ! class_exists( 'wpex_social_widget' ) ) {
	class wpex_social_widget extends WP_Widget {

		/**
		 * Register widget with WordPress.
		 *
		 * @since 1.0.0
		 */
		public function __construct() {

			parent::__construct(
				'wpex_social_widget',
				$name = __( 'Social Widget', 'spartan' ),
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
			extract( $args );

			// Define vars
			$title              = isset( $instance['title'] ) ? $instance['title'] : '';
			$title              = apply_filters( 'widget_title', $title ); // Apply filters to the title
			$description        = isset( $instance['description'] ) ? $instance['description'] : '';
			$description        = wpex_sanitize_data( $description, 'html' ); // Make sure only allowed HTMl is added to the description
			$target             = isset( $instance['target'] ) ? $instance['target'] : 'blank';
			$style              = isset( $instance['style'] ) ? $instance['style'] : 'color';
			$type               = isset( $instance['type'] ) ? $instance['type'] : 'flat';
			$social_services    = $instance['social_services'];

			// Set html for target
			if ( 'blank' == $target ) {
				$target = 'target="_blank"';
			} else {
				$target = '';
			} ?>

			<?php
			// Before widget hook
			echo $before_widget; ?>

				<?php
				// Display title if defined
				if ( $title ) {
					echo $before_title . $title . $after_title;
				} ?>

				<?php
				// Display the description
				if ( $description ) { ?>
					<div class="social-widget-description clr">
						<?php echo do_shortcode( $description ); ?>
					</div><!-- .social-widget-description -->
				<?php } ?>

				<ul class="clr <?php echo $style; ?> <?php echo $type; ?>">
					<?php
					// Loop through social options and display them
					foreach( $social_services as $key => $service ) {

						// Define social item vars
						$link = ! empty( $service['url'] ) ? $service['url'] : null;
						$link = esc_url( $link );
						$name = esc_attr( $service['name'] );
						$icon = $service['icon'];

						// Display unique icon for youtube link
						if ( 'youtube' == $icon ) {
							$icon = 'youtube-play';
						}

						// If link is defined display the social icon
						if ( $link ) {
							$output = '<li class="'. $icon .'">';
								$output .= '<a href="'. esc_url( $link ) .'" title="'. esc_attr( $name ) .'" '. $target .'>';
									$output .= '<span class="fa fa-'. $icon .'"></span>';
								$output .= '</a>';
							$output .= '</li>';
							echo $output;
						}
					} ?>
				</ul>
			<?php echo $after_widget; ?>
			<?php
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
		public function update( $new, $old ) {
			$instance = $old;
			$instance['title']              = ! empty( $new['title'] ) ? strip_tags( $new['title'] ) : null;
			$instance['description']        = ! empty( $new['description'] ) ? $new['description'] : '';
			$instance['target']             = ! empty( $new['target'] ) ? strip_tags( $new['target'] ) : 'blank';
			$instance['style']              = ! empty( $new['style'] ) ? strip_tags( $new['style'] ) : 'color';
			$instance['type']               = ! empty( $new['type'] ) ? strip_tags( $new['type'] ) : 'flat';
			$instance['social_services']    = $new['social_services'];
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
			$defaults = array(
				'title'             => __( 'Follow Us', 'spartan' ),
				'description'       => '',
				'style'             => 'color',
				'target'            => 'blank',
				'type'              => 'flat',
				'social_services'   => array(
						'twitter'       => array(
							'name'      => 'Twitter',
							'url'       => '',
							'icon'      => 'twitter',
						),
						'facebook'      => array(
							'name'      => 'Facebook',
							'url'       => '',
							'icon'      => 'facebook',
						),
						'googleplus'    => array(
							'name'      => 'Google+',
							'url'       => '',
							'icon'      => 'google-plus',
						),
						'instagram'     => array(
							'name'      => 'Instagram',
							'url'       => '',
							'icon'      => 'instagram',
						),
						'linkedin'      => array(
							'name'      => 'LinkedIn',
							'url'       => '',
							'icon'      => 'linkedin',
						),
						'pinterest'     => array(
							'name'      => 'Pinterest',
							'url'       => '',
							'icon'      => 'pinterest',
						),
						'dribbble'      => array(
							'name'      => 'Dribbble',
							'url'       => '',
							'icon'      => 'dribbble',
						),
						'flickr'            => array(
							'name'      => 'Flickr',
							'url'       => '',
							'icon'      => 'flickr',
						),
						'github'        => array(
							'name'      => 'GitHub',
							'url'       => '',
							'icon'      => 'github',
						),
						'vimeo'         => array(
							'name'      => 'Vimeo',
							'url'       => '',
							'icon'      => 'vimeo-square',
						),
						'youtube'       => array(
							'name'      => 'Youtube',
							'url'       => '',
							'icon'      => 'youtube',
						),
						'rss'           => array(
							'name'      => 'RSS',
							'url'       => '',
							'icon'      => 'rss',
						),
				),
			);
			
				$instance = wp_parse_args( ( array ) $instance, $defaults ); ?>
			
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id('title') ); ?>"><?php _e( 'Title:', 'spartan' ); ?></label> 
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id('title') ); ?>" name="<?php echo esc_attr( $this->get_field_name('title') ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id('description') ); ?>"><?php _e( 'Description:', 'spartan' ); ?></label> 
				<textarea class="widefat" rows="5" cols="20" id="<?php echo esc_attr( $this->get_field_id('description') ); ?>" name="<?php echo esc_attr( $this->get_field_name('description') ); ?>"><?php echo esc_attr( $instance['description'] ); ?></textarea>
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id('style') ); ?>"><?php _e( 'Style', 'spartan'); ?></label>
				<br />
				<select class='wpex-widget-select' name="<?php echo esc_attr( $this->get_field_name('style') ); ?>" id="<?php echo esc_attr( $this->get_field_id('style') ); ?>">
					<option value="color" <?php if( $instance['style'] == 'color' ) { ?>selected="selected"<?php } ?>><?php _e( 'Color', 'spartan' ); ?></option>
					<option value="black" <?php if( $instance['style'] == 'black' ) { ?>selected="selected"<?php } ?>><?php _e( 'Black', 'spartan' ); ?></option>
					<option value="black-color-hover" <?php if($instance['style'] == 'black-color-hover') { ?>selected="selected"<?php } ?>><?php _e( 'Black With Color Hover', 'spartan' ); ?></option>
				</select>
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id('type') ); ?>"><?php _e( 'Type', 'spartan'); ?></label>
				<br />
				<select class='wpex-widget-select' name="<?php echo esc_attr( $this->get_field_name('type') ); ?>" id="<?php echo esc_attr( $this->get_field_id('type') ); ?>">
					<option value="flat" <?php if($instance['type'] == 'flat') { ?>selected="selected"<?php } ?>><?php _e( 'Flat', 'spartan' ); ?></option>
					<option value="graphical" <?php if($instance['type'] == 'graphical') { ?>selected="selected"<?php } ?>><?php _e( 'Graphical', 'spartan' ); ?></option>
				</select>
			</p>
			
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id('target') ); ?>"><?php _e( 'Link Target:', 'spartan' ); ?></label>
				<br />
				<select class='wpex-widget-select' name="<?php echo esc_attr( $this->get_field_name('target') ); ?>" id="<?php echo esc_attr( $this->get_field_id('target') ); ?>">
					<option value="blank" <?php if($instance['target'] == 'blank') { ?>selected="selected"<?php } ?>><?php _e( 'Blank', 'spartan' ); ?></option>
					<option value="self" <?php if($instance['target'] == 'self') { ?>selected="selected"<?php } ?>><?php _e( 'Self', 'spartan' ); ?></option>
				</select>
			</p>

			<h3 style="margin-top:20px;margin-bottom:0;"><?php _e( 'Social Links', 'spartan' ); ?></h3>  
			<small style="display:block;margin-bottom:10px;"><?php _e( 'Enter the full URL to your social profile. You can click and drag andy social profile to re-order it.', 'spartan' ); ?></small>
			<ul id="<?php echo esc_attr( $this->get_field_id( 'social_services' ) ); ?>" class="wpex-services-list">
				<input type="hidden" id="<?php echo esc_attr( $this->get_field_name( 'social_services' ) ); ?>" value="<?php echo esc_attr( $this->get_field_name( 'social_services' ) ); ?>">
				<input type="hidden" id="<?php echo wp_create_nonce('wpex_social_widget_nonce'); ?>">
				<?php
				$social_services = $instance['social_services'];
				$i=0;
				foreach( $social_services as $key => $service ) {
					$url=0;
					if( isset( $service['url'] ) ) $url = $service['url'];
					if( isset( $service['name'] ) ) $name = $service['name'];
					if( isset( $service['icon'] ) ) $icon = $service['icon'];
					$i++; ?>
					<li id="<?php echo esc_attr( $this->get_field_id( $service ) ); ?>_0<?php echo $i ?>">
						<p>
							<label for="<?php echo esc_attr( $this->get_field_id( 'social_services' ) ); ?>-<?php echo $i ?>-name"><?php echo $name; ?>:</label>
							<input type="hidden" id="<?php echo esc_attr( $this->get_field_id( 'social_services' ) ); ?>-<?php echo $i ?>-url" name="<?php echo esc_attr( $this->get_field_name( 'social_services' ) ) .'['.$i.'][name]'; ?>" value="<?php echo esc_attr( $name ); ?>">
							<input type="url" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'social_services' ) ); ?>-<?php echo $i ?>-url" name="<?php echo esc_attr( $this->get_field_name( 'social_services' ) ).'['.$i.'][url]'; ?>" value="<?php echo esc_attr( $url ); ?>" />
							<input type="icon" class="hidden" id="<?php echo esc_attr( $this->get_field_id( 'social_services' ) ); ?>-<?php echo $i ?>-icon" name="<?php echo esc_attr( $this->get_field_name( 'social_services' ) ).'['.$i.'][icon]'; ?>" value="<?php echo esc_attr( $icon ); ?>" />
						</p>
					</li>
				<?php } ?>
			</ul>
			
		<?php
		}
	}
}
add_action( 'widgets_init', function() {
	register_widget( 'wpex_social_widget' );
} );

/* Widget Ajax Function
/*-----------------------------------------------------------------------------------*/
if( ! function_exists( 'load_wpex_social_widget_scripts' ) ) {
	function load_wpex_social_widget_scripts() {
		global $pagenow;
		if ( is_admin() && $pagenow == "widgets.php" ) {
			add_action('admin_head', 'add_new_wpex_social_style');
			add_action('admin_footer', 'add_new_wpex_social_ajax_trigger');
			function add_new_wpex_social_ajax_trigger() { ?>
				<script type="text/javascript" >
					jQuery(document).ready(function($) {
						jQuery(document).ajaxSuccess(function(e, xhr, settings) {
							var widget_id_base = 'wpex_social_widget';
							if(settings.data.search('action=save-widget') != -1 && settings.data.search('id_base=' + widget_id_base) != -1) {
								wpexSortServices();
							}
						});
						function wpexSortServices() {
							jQuery('.wpex-services-list').each( function() {
								var id = jQuery(this).attr('id');
								$('#'+ id).sortable({
									placeholder: "placeholder",
									opacity: 0.6
								});
							});
						}
						wpexSortServices();
					});
				</script>
			<?php
			}
		}
		function add_new_wpex_social_style() { ?>
			<style> 
			.wpex-services-list li { cursor:move;background:#fcfcfc;padding:10px;border:1px solid #e3e3e3;margin-bottom:10px;box-shadow: inset 0 1px 0 #fff; }
			.wpex-sw-container label{ color: #666;font-weight:bold; }
			.wpex-services-list .placeholder { border:1px dashed #e3e3e3; }
			</style>
		<?php
		}
	}
}
add_action( 'admin_init', 'load_wpex_social_widget_scripts' );