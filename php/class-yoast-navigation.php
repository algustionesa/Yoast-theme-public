<?php
/**
 * @package Yoast\YoastCom\Theme\Navigation
 */

namespace Yoast\YoastCom\Theme;

use Yoast\YoastCom\Menu\Main_Menu_Item;
use Yoast\YoastCom\Menu\Menu_Item;
use Yoast\YoastCom\Menu\Menu_Structure;

class Yoast_Navigation {

	protected $menu_structure;
	protected $main_menu_items;
	protected $controls;
	protected $current_url;
	protected $scheme;

	/**
	 * Yoast_Navigation constructor.
	 *
	 * @param null $menu_structure
	 */
	public function __construct( $menu_structure = null ) {
		// We set this hard instead of using the $_SERVER global, as that's not reliable on WP Engine
		$this->scheme = 'https';
		if ( defined( 'YOAST_ENVIRONMENT' ) && YOAST_ENVIRONMENT === 'development' ) {
			$this->scheme = 'http';
		}

		$this->menu_structure  = ( is_null( $menu_structure ) ? new Menu_Structure() : $menu_structure );
		$this->main_menu_items = $this->menu_structure->getMenuItems();

		$this->current_url = '';
		if ( ! defined( 'WP_CLI' ) || ! WP_CLI ) {
			$this->current_url = $this->scheme . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		}

		// We use the wp filter here, so the post_id is available and the page isn't rendered yet, so we can change the active menu item.
		if ( ! is_admin() ) {
			add_filter( 'wp', function () {
				$this->set_active_menu_item();
			} );
		}

	}

	/**
	 * Run the template
	 */
	public function output_menu_bar() {
		get_template_part( 'html_includes/partials/navigation-menu', array(
			'menu_data' => $this->get_menu_data(),
		) );
	}

	/**
	 * Run footer menu output
	 */
	public function output_menu_footer() {
		get_template_part( 'html_includes/partials/footer-menu', array(
			'menu_data' => $this->get_menu_data(),
		) );
	}

	/**
	 * Get the template data of the entire menu
	 *
	 * @return array
	 */
	private function get_menu_data() {
		$data = array();

		/** @var Main_Menu_Item $main_menu_item */
		foreach ( $this->main_menu_items as $main_menu_item ) {
			$data[] = $this->get_main_menu_data( $main_menu_item );
		}

		return $data;
	}

	/**
	 * Build the menu data for the template
	 *
	 * @param Main_Menu_Item $main_menu_item The menu item to build the data of.
	 *
	 * @return array
	 */
	private function get_main_menu_data( Main_Menu_Item $main_menu_item ) {

		$data = [
			'classes'          => [ 'menu-item', 'menu-item__' . $main_menu_item->getType() ],
			'label'            => $main_menu_item->getLabel(),
			'url'              => $main_menu_item->getUrl(),
			'icon'             => $main_menu_item->getIcon(),
			'screenReaderText' => $main_menu_item->getScreenreaderText(),
			'anchor_classes'   => array(),
			'children'         => $this->get_children_menu_data( $main_menu_item ),
			'type'             => $main_menu_item->getType(),
		];

		if ( ! empty( $main_menu_item->getIcon() ) ) {
			$data['anchor_classes'][] = 'icon';
		}

		if ( ! empty( $main_menu_item->isActive() ) ) {
			$data['classes'][] = 'current-menu-parent';
		}

		return $data;
	}

	/**
	 * Build the child data for the template
	 *
	 * @param Main_Menu_Item $main_menu_item Menu item to get children of.
	 *
	 * @return array
	 */
	private function get_children_menu_data( Main_Menu_Item $main_menu_item ) {
		$children = array();

		/** @var Menu_Item $child */
		foreach ( $main_menu_item->getChildren() as $child ) {

			$child_data = [
				'classes'        => [ 'sub-menu-item' ],
				'label'          => $child->getLabel(),
				'url'            => $child->getUrl(),
				'icon'           => $child->getIcon(),
				'anchor_classes' => array()
			];

			if ( $this->menu_item_is_active( $child ) ) {
				$child_data['classes'][] = 'current-menu-item';
			}

			if ( ! empty ( $child->getIcon() ) ) {
				$child_data['anchor_classes'][] = 'icon';
			}

			$children[] = $child_data;
		}

		return $children;
	}

	/**
	 * Check if the child of a menu item is active.
	 *
	 * @param Menu_Item $sub_menu_item
	 *
	 * @return bool
	 */
	private function menu_item_is_active( Menu_Item $sub_menu_item ) {
		$is_primary_category = false;

		if ( is_singular() && function_exists( 'yoast_get_primary_term' ) ) {
			$primary_category = yoast_get_primary_term( 'category', get_the_ID() );

			$compare_to_primary_category = apply_filters( 'yoast_nav_label-primary_category', $sub_menu_item->getLabel() );
			$compare_to_primary_category = esc_html( $compare_to_primary_category );

			$is_primary_category = strcasecmp( $compare_to_primary_category, $primary_category ) === 0;
		}

		$is_same_url = ( $this->current_url === $sub_menu_item->getUrl() );

		return $is_primary_category || $is_same_url;
	}

	/**
	 * Determine if a menu item should be active because of matching URL
	 *
	 * @return bool
	 */
	private function set_active_by_url() {
		/** @var Main_Menu_Item $main_menu_item */
		foreach ( $this->main_menu_items as $main_menu_item ) {
			if ( $main_menu_item->getUrl() === $this->current_url ) {
				$main_menu_item->setActive();

				return true;
			}

			/** @var Menu_Item $child */
			foreach ( $main_menu_item->getChildren() as $child ) {
				if ( $child->getUrl() === $this->current_url ) {
					$main_menu_item->setActive();

					return true;
				}
			}
		}

		return false;
	}

	/**
	 * Determine if a menu item should be active based on the current page type
	 *
	 * @return bool
	 */
	private function set_active_by_page_type() {
		/** @var Main_Menu_Item $main_menu_item */
		foreach ( $this->main_menu_items as $main_menu_item ) {
			if ( $main_menu_item->getType() === Page_Menu_Type::get_page_type() ) {
				$main_menu_item->setActive();

				return true;
			}
		}

		return false;
	}

	/**
	 * Determine if a menu item should be active because of the current post type
	 *
	 * @return bool
	 */
	private function set_active_by_page() {
		/** @var Main_Menu_Item $main_menu_item */
		foreach ( $this->main_menu_items as $main_menu_item ) {
			$activeOn = $main_menu_item->getActiveOn();
			if ( ! is_array( $activeOn ) ) {
				continue;
			}

			$site_url = parse_url( get_site_url() );
			foreach ( $activeOn as $base_url => $post_types ) {

				$base_url_parsed = parse_url( $base_url );
				if ( $base_url_parsed['host'] === $site_url['host'] ) {
					if ( ! is_array( $post_types ) || empty( $post_types ) ) {
						$main_menu_item->setActive();

						return true;
					}

					if ( in_array( get_post_type(), $post_types, true ) ) {
						$main_menu_item->setActive();

						return true;
					}
				}
			}
		}

		return false;
	}

	/**
	 * Activate the first menu item
	 */
	private function set_active_by_default() {
		if ( empty( $this->main_menu_items ) ) {
			return;
		}

		$this->main_menu_items[0]->setActive(); // make the first main menu item active (Home)
	}

	/**
	 * Determine which main menu item should be activated
	 */
	private function set_active_menu_item() {
		if ( $this->set_active_by_url() ) {
			return;
		}

		if ( $this->set_active_by_page_type() ) {
			return;
		}

		if ( $this->set_active_by_page() ) {
			return;
		}

		$this->set_active_by_default();
	}

	/**
	 * Gets the type of the currently active menu item.
	 *
	 * @return mixed
	 */
	public function get_active_type() {
		foreach ( $this->main_menu_items as $main_menu_item ) {
			if ( $main_menu_item->isActive() ) {
				return $main_menu_item->getType();
			}
		}
	}
}
