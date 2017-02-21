<?php


namespace Yoast\YoastCom\Theme;

/**
 * Adds a theme settings screen
 */
class Theme_Settings {
	/**
	 * Option key, and option page slug
	 * @var string
	 */
	private $key = 'yst_theme_options';

	/**
	 * Options page metabox id
	 * @var string
	 */
	private $metabox_id = 'yst_theme_option_metabox';

	/**
	 * Options Page title
	 * @var string
	 */
	protected $title = '';

	/**
	 * Options Page hook
	 * @var string
	 */
	protected $options_page = '';

	/**
	 * Adds WordPress hooks
	 */
	public function __construct() {
		$this->title = __( 'Yoast Theme Settings', 'yoastcom' );
	}

	/**
	 * Add WordPress hooks
	 */
	public function hooks() {
		add_action( 'admin_init', array( $this, 'init' ) );
		add_action( 'admin_menu', array( $this, 'add_options_page' ) );
		add_action( 'cmb2_admin_init', array( $this, 'add_options_page_metabox' ) );
		add_action( 'cmb2_save_options-page_fields', array( $this, 'settings_notices' ), 10, 3 );
	}

	/**
	 * Register our setting to WP
	 */
	public function init() {
		register_setting( $this->key, $this->key );
	}

	/**
	 * Add menu options page
	 */
	public function add_options_page() {
		$this->options_page = add_theme_page( $this->title, __( 'Settings', 'yoastcom' ), 'edit_posts', $this->key, array(
			$this,
			'admin_page_display',
		) );

		// Include CMB CSS in the head to avoid FOUT.
		add_action( "admin_print_styles-{$this->options_page}", array( 'CMB2_hookup', 'enqueue_cmb_css' ) );
	}

	/**
	 * Admin page markup. Mostly handled by CMB2
	 */
	public function admin_page_display() {
		?>
		<div class="wrap cmb2-options-page <?php echo $this->key; ?>">
			<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
			<?php cmb2_metabox_form( $this->metabox_id, $this->key ); ?>
		</div>
		<?php
	}

	/**
	 * Add the options metabox to the array of metaboxes
	 * @since  0.1.0
	 */
	function add_options_page_metabox() {
		$cmb = new_cmb2_box( array(
			'id'         => $this->metabox_id,
			'hookup'     => false,
			'cmb_styles' => false,
			'show_on'    => array(
				// These are important, don't remove.
				'key'   => 'options-page',
				'value' => array( $this->key, )
			),
		) );

		$cmb->add_field( array(
			'name'    => __( 'Footer HTML', 'yoastcom' ),
			'desc'    => __( 'Will be displayed in the footer', 'yoastcom' ),
			'id'      => 'footer',
			'type'    => 'wysiwyg',
			'default' => get_legacy_option( 'footer', 'child-settings' ),
		) );

		$cmb->add_field( array(
			'name'    => __( 'Show banner', 'yoastcom' ),
			'desc'    => __( 'Should the banner be shown?', 'yoastcom' ),
			'id'      => 'show_banner',
			'type'    => 'checkbox',
			'default' => get_theme_option( 'show_banner', 'child-settings' ),
		) );

		$cmb->add_field( array(
			'name'    => __( 'Banner theme', 'yoastcom' ),
			'desc'    => __( 'What theme/background color should the banner have?', 'yoastcom' ),
			'id'      => 'banner_theme_class',
			'type'    => 'select',
			'options' => [
				'home' => __( 'Home (green)', 'yoastcom' ),
				'seo-blog' => __( 'SEO blog (purple)', 'yoastcom' ),
				'plugins' => __( 'Plugins (blue)', 'yoastcom' ),
				'courses' => __( 'Courses (pink)', 'yoastcom' ),
				'ebooks' => __( 'eBooks (dark purple)', 'yoastcom' ),
				'hire-us' => __( 'Hire us (teal)', 'yoastcom' ),
				'faq' => __( 'FAQ (dark blue)', 'yoastcom' ),
				'new-years' => __( 'New years 2017', 'yoastcom' ),
			],
			'default' => get_theme_option( 'banner_theme_class', 'child-settings' ),
		) );

		$cmb->add_field( array(
			'name'    => __( 'Banner variation', 'yoastcom' ),
			'desc'    => __( 'What variation should the banner have?', 'yoastcom' ),
			'id'      => 'banner_theme_variation',
			'type'    => 'select',
			'options' => [
				'' => __( 'None', 'yoastcom' ),
				'site-structure' => __( 'Honeycomb and bee', 'yoastcom' ),
				'new-years' => __( 'Fireworks', 'yoastcom' ),
				'balloons' => __( 'Balloons', 'yoastcom' ),
			],
			'default' => get_theme_option( 'banner_theme_variation', 'child-settings' ),
		) );

		$cmb->add_field( array(
			'name'    => __( 'Banner HTML', 'yoastcom' ),
			'desc'    => __( 'Will be displayed in the banner above the Yoast logo', 'yoastcom' ),
			'id'      => 'banner',
			'type'    => 'wysiwyg',
			'default' => get_theme_option( 'banner', 'child-settings' ),
		) );

		$social_labels = array(
			'facebook_likes'      => __( 'Facebook likes', 'yoastcom' ),
			'instagram_followers' => __( 'Instagram followers', 'yoastcom' ),
			'pinterest_followers' => __( 'Pinterest followers', 'yoastcom' ),
			'linkedin_followers'  => __( 'LinkedIn followers', 'yoastcom' ),
			'twitter_subs'        => __( 'Twitter followers', 'yoastcom' ),
			'youtube_subs'        => __( 'YouTube subscribers', 'yoastcom' )
		);

		foreach ( $social_labels as $option => $label ) {
			$cmb->add_field( array(
				'name'    => $label,
				'desc'    => __( 'Keep to 3-4 chars', 'yoastcom' ),
				'id'      => $option,
				'type'    => 'text_small',
				'default' => get_legacy_option( $option, 'child-settings' ),
			) );
		}
	}

	/**
	 * Show Settings Notices
	 *
	 * @param $object_id
	 * @param $updated
	 * @param $cmb
	 */
	public function settings_notices( $object_id, $updated, $cmb ) {
		if ( $object_id !== $this->key ) {
			return;
		}
		add_settings_error( $this->key . '-notices', '', __( 'Settings updated.', 'myprefix' ), 'updated' );
		settings_errors( $this->key . '-notices' );
	}
}
