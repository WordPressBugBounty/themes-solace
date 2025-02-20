<?php

/**
 * Singleton class for handling the theme's customizer integration.
 *
 * @since  1.0.0
 * @access public
 */
final class Solace_Register_Tab_Footer
{

	/**
	 * Returns the instance.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return object
	 */
	public static function get_instance()
	{

		static $instance = null;

		if (is_null($instance)) {
			$instance = new self;
			$instance->setup_actions();
		}

		return $instance;
	}

	/**
	 * Constructor method.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function __construct()
	{
	}

	/**
	 * Sets up initial actions.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function setup_actions()
	{

		// Register panels, sections, settings, controls, and partials.
		add_action('customize_register', array($this, 'sections'));

		// Register scripts and styles for the controls.
		add_action('customize_controls_enqueue_scripts', array($this, 'enqueue_control_scripts'), 99);
	}

	/**
	 * Sets up the customizer sections.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  object  $manager
	 * @return void
	 */
	public function sections($manager)
	{

		// Load custom sections.
		load_template(trailingslashit(get_template_directory()) . '/inc/customizer/tab-footer/render.php');

		// Register custom section types.
		$manager->register_section_type('Solace_Footer_Render');

		// Register sections.
		$manager->add_section(new Solace_Footer_Render($manager, 'solace_tabs_footer', array(
			'priority'   => 301,
			'panel' => 'hfg_footer',
			'title'    => esc_html__('Solace', 'solace'),
			'text_left' => esc_html__('Elements', 'solace'),
			'text_right'  => esc_html__('Presets', 'solace'),
		)));
	}

	/**
	 * Loads theme customizer CSS.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function enqueue_control_scripts()
	{
		wp_enqueue_script('solace-customize-controls-footer-script', get_theme_file_uri('/inc/customizer/tab-footer/scripts.js'), array('jquery'), '1.0.1', true);
	}
}

// Doing this customizer thang!
Solace_Register_Tab_Footer::get_instance();
