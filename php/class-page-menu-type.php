<?php

namespace Yoast\YoastCom\Theme;


class Page_Menu_Type {
	const HOME = 'home';
	const SEO_BLOG = 'seo-blog';
	const PLUGINS = 'plugins';
	const COURSES = 'courses';
	const EBOOKS = 'ebooks';
	const HIRE_US = 'hire-us';
	const FAQ = 'faq';

	/**
	 * Constructor, adds WordPress hooks
	 */
	public function __construct() {
		add_action( 'cmb2_init', array( $this, 'page_color_selection' ) );
	}


	/**
	 * Adds the custom meta boxes for the page color selection
	 */
	public function page_color_selection() {
		$meta_box = new_cmb2_box( array(
			'id'           => 'yoastcom_page_type_selection',
			'title'        => __( 'Page type', 'yoastcom' ),
			'object_types' => array( 'page' ),
		) );

		$meta_box->add_field( array(
			'name'             => __( 'Page type', 'yoastcom' ),
			'id'               => 'yoastcom_page_type',
			'type'             => 'select',
			'show_option_none' => __( 'Inherit', 'yoastcom' ),
			'options'          => array(
				self::HOME     => __( 'Home', 'yoastcom' ),
				self::SEO_BLOG => __( 'Seo blog', 'yoastcom' ),
				self::PLUGINS  => __( 'Plugins', 'yoastcom' ),
				self::COURSES  => __( 'Courses', 'yoastcom' ),
				self::EBOOKS   => __( 'eBooks', 'yoastcom' ),
				self::HIRE_US  => __( 'Hire us', 'yoastcom' ),
				self::FAQ      => __( 'FAQ', 'yoastcom' ),
			),
		) );
	}


	/**
	 * Returns the page type of the current page.
	 *
	 * @param $post_id
	 *
	 * @return string
	 */
	public static function get_page_type( $post_id = null ) {
		if ( null === $post_id ) {
			$post_id = get_the_ID();
		}
		$page_type = get_post_meta( $post_id, 'yoastcom_page_type', true );

		if ( ! $page_type ) {
			$page_type = self::get_parent_page_type( $post_id );
		}

		return $page_type;
	}

	/**
	 * Returns the page type of the parent.
	 *
	 * @param $post_id
	 *
	 * @return string
	 */
	private static function get_parent_page_type( $post_id ) {
		$parent_id    = wp_get_post_parent_id( $post_id );
		$page_type = '';

		// If there is a parent return the parents color scheme.
		if ( $parent_id ) {
			$page_type = self::get_page_type( $parent_id );
		}

		return $page_type;
	}
}
