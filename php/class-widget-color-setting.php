<?php
/**
 * @package Yoast\YoastCom
 */

namespace Yoast\YoastCom\Theme;

/**
 * Adds a setting to all widgets to change the color
 */
class Widget_Color_Setting {

	const COLOR_GREEN       = 'theme-home';
	const COLOR_PURPLE      = 'theme-seo-blog';
	const COLOR_BLUE        = 'theme-plugins';
	const COLOR_PINK        = 'theme-courses';
	const COLOR_GREEN_BLUE  = 'theme-hire-us';
	const COLOR_DARK_BLUE   = 'theme-faq';
	const COLOR_ORANGE      = 'link';
	const COLOR_DEFAULT     = self::COLOR_PURPLE;

	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'in_widget_form', array( $this, 'in_widget_form' ), 10, 3 );
		add_filter( 'widget_update_callback', array( $this, 'widget_update_callback' ), 10, 2 );
		add_filter( 'dynamic_sidebar_params', array( $this, 'dynamic_sidebar_params' ) );
	}

	/**
	 * Add a color setting to all widgets
	 *
	 * @param \WP_Widget $widget
	 * @param null       $return
	 * @param array      $instance
	 */
	public function in_widget_form( &$widget, &$return, $instance ) {
		$border_color = isset( $instance['border-color'] ) ? $instance['border-color'] : self::COLOR_DEFAULT;

		?>
			<p>
				<label for="<?php echo $widget->get_field_id( 'border-color' ); ?>">
					<?php _e( 'Border color (Used in the footer)', 'yoastcom' ); ?>
				</label>
				<select id="<?php echo $widget->get_field_id( 'border-color' ); ?>" name="<?php echo $widget->get_field_name( 'border-color' ); ?>" class="widefat">
					<option value="<?php echo esc_attr( self::COLOR_GREEN ); ?>"<?php selected( self::COLOR_GREEN, $border_color ); ?>>
						<?php _e( 'Green (home)', 'yoastcom' ); ?>
					</option>
					<option value="<?php echo esc_attr( self::COLOR_PURPLE ); ?>"<?php selected( self::COLOR_PURPLE, $border_color ); ?>>
						<?php _e( 'Purple (seo blog)', 'yoastcom' ); ?>
					</option>
					<option value="<?php echo esc_attr( self::COLOR_BLUE ); ?>"<?php selected( self::COLOR_BLUE, $border_color ); ?>>
						<?php _e( 'Blue (plugins)', 'yoastcom' ); ?>
					</option>
					<option value="<?php echo esc_attr( self::COLOR_PINK ); ?>"<?php selected( self::COLOR_PINK, $border_color ); ?>>
						<?php _e( 'Pink (courses)', 'yoastcom' ); ?>
					</option>
					<option value="<?php echo esc_attr( self::COLOR_GREEN_BLUE ); ?>"<?php selected( self::COLOR_GREEN_BLUE, $border_color ); ?>>
						<?php _e( 'Teal (hire us)', 'yoastcom' ); ?>
					</option>
					<option value="<?php echo esc_attr( self::COLOR_DARK_BLUE ); ?>"<?php selected( self::COLOR_DARK_BLUE, $border_color ); ?>>
						<?php _e( 'Dark blue (faq)', 'yoastcom' ); ?>
					</option>
					<option value="<?php echo esc_attr( self::COLOR_ORANGE ); ?>"<?php selected( self::COLOR_ORANGE, $border_color ); ?>>
						<?php _e( 'Orange', 'yoastcom' ); ?>
					</option>
				</select>
			</p>
		<?php

		$return = null;
	}

	/**
	 * Save the border color to the widget instance
	 *
	 * @param array $instance The to be saved widget instance.
	 * @param array $new_instance The widget instance as submitted in the form.
	 *
	 * @return array
	 */
	public function widget_update_callback( $instance, $new_instance ) {
		$border_color = isset( $new_instance['border-color'] ) ? $new_instance['border-color'] : self::COLOR_DEFAULT;

		if ( ! in_array( $border_color, array( self::COLOR_PURPLE, self::COLOR_BLUE, self::COLOR_GREEN, self::COLOR_PINK, self::COLOR_ORANGE, self::COLOR_DARK_BLUE, self::COLOR_GREEN_BLUE ) ) ) {
			$border_color = self::COLOR_DEFAULT;
		}

		$instance['border-color'] = $border_color;

		return $instance;
	}

	/**
	 * Change the params of the widget to include our border color classname
	 *
	 * @param array $params The sidebar+widget parameters.
	 *
	 * @return array The altered parameters
	 */
	public function dynamic_sidebar_params( $params ) {
		global $wp_registered_widgets;

		$sidebars = array( 'footer', 'footer-1', 'footer-2', 'footer-3', 'promo-homepage', 'promo-homepage-1', 'promo-homepage-2', 'promo-homepage-3' );

		// Don't bother if we are not in a sidebar where you can set colors.
		if ( ! in_array( $params[0]['id'], $sidebars ) ) {
			return $params;
		}

		// Retrieve the widget object from the parameters.
		$widget_info = $wp_registered_widgets[ $params[0]['widget_id'] ];
		/* @var \WP_Widget $widget */
		$widget = $widget_info['callback'][0];

		// Retrieve the current widget settings based on the settings and the number.
		$all_settings = $widget->get_settings();
		$widget_settings = $all_settings[ $params[1]['number'] ];

		// Replace the classname of the widget with our altered classname.
		if ( isset( $widget_settings['border-color'] ) ) {
			$params[0]['before_widget'] = str_replace(
				$widget->widget_options['classname'],
				$widget->widget_options['classname'] . ' ' . $widget_settings['border-color'],
				$params[0]['before_widget']
			);
		}

		return $params;
	}
}
