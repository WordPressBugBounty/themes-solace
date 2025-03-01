<?php
/**
 * Page settings metabox.
 *
 * @package Solace
 */

namespace Solace\Admin\Metabox;

/**
 * Class Metabox
 *
 * @package Solace\Admin\Metabox
 */
class Main extends Controls_Base {

	/**
	 * Is new skin.
	 *
	 * @var bool
	 */
	private $new_skin;

	/**
	 * Main constructor.
	 */
	public function __construct() {
		$this->new_skin = solace_is_new_skin();
	}

	/**
	 * Add controls.
	 */
	public function add_controls() {
		$this->add_layout_controls();
		$this->add_control( new Controls\Separator( 'solace_meta_separator', array( 'priority' => 20 ) ) );
		$this->add_content_toggles();
		$this->add_control( new Controls\Separator( 'solace_meta_separator', array( 'priority' => 45 ) ) );
		$this->add_content_width();
	}

	/**
	 * Add layout controls.
	 */
	private function add_layout_controls() {
		$this->add_control(
			new Controls\Radio(
				'solace_meta_container',
				array(
					'default' => 'default',
					'choices' => array(
						'default'    => __( 'Customizer Setting', 'solace' ),
						'contained'  => __( 'Contained', 'solace' ),
						'full-width' => __( 'Full Width', 'solace' ),
					),
					'label'   => __( 'Container', 'solace' ),
				)
			)
		);

		$position_default = ( self::is_new_page() || self::is_checkout() ) ? 'full-width' : 'default';

		if ( $this->new_skin ) {
			$position_default = 'default';
		}

		$this->add_control(
			new Controls\Radio(
				'solace_meta_sidebar',
				array(
					'default'  => $position_default,
					'choices'  => array(
						'default'    => __( 'Customizer Setting', 'solace' ),
						'left'       => __( 'Left Sidebar', 'solace' ),
						'right'      => __( 'Right Sidebar', 'solace' ),
						'full-width' => __( 'No Sidebar', 'solace' ),
					),
					'label'    => __( 'SidebarA', 'solace' ),
					'priority' => 15,
				)
			)
		);
	}

	/**
	 * Add content toggles.
	 */
	private function add_content_toggles() {
		$content_controls = array(
			'solace_meta_disable_header'         => array(
				'default'     => 'off',
				'label'       => __( 'Components', 'solace' ),
				'input_label' => __( 'Disable Headerx', 'solace' ),
				'priority'    => 25,
			),
			'solace_meta_disable_title'          => array(
				'default'         => 'off',
				'input_label'     => __( 'Disable Titlex', 'solace' ),
				'active_callback' => array( $this, 'hide_on_single_product' ),
				'priority'        => 30,
			),
			'solace_meta_disable_featured_image' => array(
				'default'         => 'off',
				'input_label'     => __( 'Disable Featured Image', 'solace' ),
				'active_callback' => array( $this, 'hide_on_single_page_and_product' ),
				'priority'        => 35,
			),
			'solace_meta_disable_footer'         => array(
				'default'     => 'off',
				'input_label' => __( 'Disable Footer', 'solace' ),
				'priority'    => 40,
			),
		);

		$default_control_args = array(
			'default'         => 'off',
			'label'           => '',
			'input_label'     => '',
			'active_callback' => '__return_true',
			'priority'        => 10,
		);

		foreach ( $content_controls as $control_id => $args ) {
			$args = wp_parse_args( $args, $default_control_args );

			$this->add_control(
				new Controls\Checkbox(
					$control_id,
					array(
						'default'         => $args['default'],
						'label'           => $args['label'],
						'input_label'     => $args['input_label'],
						'active_callback' => $args['active_callback'],
						'priority'        => $args['priority'],
					)
				)
			);
		}
	}

	/**
	 * Add content width control.
	 */
	private function add_content_width() {

		$enabled_default = ( self::is_new_page() || self::is_checkout() ) ? 'on' : 'off';
		$width_default   = ( self::is_new_page() || self::is_checkout() ) ? 100 : 70;
		if ( $this->new_skin ) {
			$enabled_default = 'off';
			$width_default   = self::is_post() ? 70 : 100;
		}

		$this->add_control(
			new Controls\Checkbox(
				'solace_meta_enable_content_width',
				array(
					'default'     => $enabled_default,
					'label'       => __( 'Content Width', 'solace' ) . ' (%)',
					'input_label' => __( 'Enable Individual Content Width', 'solace' ),
					'priority'    => 50,
				)
			)
		);
		$this->add_control(
			new Controls\Range(
				'solace_meta_content_width',
				array(
					'default'    => $width_default,
					'min'        => 50,
					'max'        => 100,
					'hidden'     => self::hide_content_width(),
					'depends_on' => 'solace_meta_enable_content_width',
					'priority'   => 55,
				)
			)
		);
	}

	/**
	 * Hide content width.
	 *
	 * @return bool
	 */
	public static function hide_content_width() {
		if ( self::is_new_page() ) {
			return false;
		}

		if ( ! isset( $_GET['post'] ) ) {
			return true;
		}

		$meta = get_post_meta( (int) $_GET['post'], 'solace_meta_enable_content_width', true );

		if ( empty( $meta ) && self::is_checkout() ) {
			return false;
		}

		if ( empty( $meta ) || $meta === 'off' ) {
			return true;
		}

		return false;
	}

	/**
	 * Callback to hide on single product edit page.
	 *
	 * @return bool
	 */
	public function hide_on_single_product() {
		if ( isset( $_GET['post_type'] ) && $_GET['post_type'] === 'product' ) {
			return false;
		}

		if ( ! isset( $_GET['post'] ) ) {
			return true;
		}

		$post_type = get_post_type( (int) $_GET['post'] );

		if ( $post_type !== 'product' ) {
			return true;
		}

		return false;
	}

	/**
	 * Callback to hide on single product/page edit page
	 *
	 * @return bool
	 */
	public function hide_on_single_page_and_product() {
		if ( isset( $_GET['post_type'] ) && ( $_GET['post_type'] === 'page' || $_GET['post_type'] === 'product' ) ) {
			return false;
		}

		if ( ! isset( $_GET['post'] ) ) {
			return true;
		}

		$post_type = get_post_type( (int) $_GET['post'] );

		if ( $post_type !== 'page' && $post_type !== 'product' ) {
			return true;
		}

		return false;
	}

	/**
	 * Check if we're adding a new post of type `page`.
	 *
	 * @return bool
	 */
	public static function is_new_page() {
		global $pagenow;

		if ( $pagenow !== 'post-new.php' ) {
			return false;
		}

		if ( ! isset( $_GET['post_type'] ) ) {
			return false;
		}
		if ( ( $_GET['post_type'] !== 'page' ) ) {
			return false;
		}

		return true;
	}

	/**
	 * Check if is checkout.
	 */
	public static function is_checkout() {
		if ( ! class_exists( 'WooCommerce', false ) ) {
			return false;
		}
		if ( ! isset( $_GET['post'] ) ) {
			return false;
		}
		if ( $_GET['post'] === get_option( 'woocommerce_checkout_page_id' ) ) {
			return true;
		}

		return false;
	}

	/**
	 * Check if is post.
	 */
	public static function is_post() {
		global $pagenow;

		// New post.
		if ( $pagenow === 'post-new.php' && ! isset( $_GET['post_type'] ) ) {
			return true;
		}

		if ( ! isset( $_GET['post'] ) ) {
			return false;
		}

		if ( get_post_type( absint( $_GET['post'] ) ) === 'post' ) {
			return true;
		}

		return false;
	}
}
