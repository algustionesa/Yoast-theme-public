<?php
/**
 * @package Yoast\YoastCom
 */

namespace Yoast\YoastCom\Theme;
use Yoast\YoastCom\Menu\Menu_Structure;

/**
 * Handles the color scheme in the theme
 *
 * @package Yoast\YoastCom
 */
class Color_Scheme {

	const HOME = 'theme-home';
	const SEO_BLOG = 'theme-seo-blog';
	const PLUGINS = 'theme-plugins';
	const COURSES = 'theme-courses';
	const EBOOKS = 'theme-ebooks';
	const HIRE_US = 'theme-hire-us';
	const FAQ = 'theme-faq';

	/**
	 * Constructor, adds WordPress hooks
	 */
	public function __construct() {
		add_filter( 'body_class', array( $this, 'body_class' ) );
	}

	/**
	 * Adds the color scheme class to the body class
	 *
	 * @param array $classes The classes set by WordPress.
	 *
	 * @return array The new classes
	 */
	public function body_class( $classes ) {
		$color_scheme = $this->get_color_scheme();
		if ( '' !== $color_scheme ) {
			$classes[] = $color_scheme;
		}

		return $classes;
	}


	public function set_page_type( $page_type ) {
		$this->page_type = $page_type;
	}

	public function get_color_scheme() {
		$page_type = theme_object()->navigation->get_active_type();
		$map = [
			Menu_Structure::HOME_TYPE     => self::HOME,
			Menu_Structure::SEO_BLOG_TYPE => self::SEO_BLOG,
			Menu_Structure::PLUGINS_TYPE  => self::PLUGINS,
			Menu_Structure::COURSES_TYPE  => self::COURSES,
			Menu_Structure::EBOOKS_TYPE   => self::EBOOKS,
			Menu_Structure::HIRE_US_TYPE  => self::HIRE_US,
			Menu_Structure::FAQ_TYPE      => self::FAQ,
		];

		return $map[ $page_type ];
	}
}
