<?php
/**
 * Custom Component class for Header Footer Grid.
 *
 * Name:    Header Footer Grid
 * Author:  
 *
 * @version 1.0.0
 * @package HFG
 */

namespace HFG\Core\Components;

use HFG\Core\Settings\Manager as SettingsManager;

/**
 * Class FooterWidgetFour
 *
 * @package HFG\Core\Components
 */
class FooterWidgetFour extends Abstract_FooterWidget {

	const COMPONENT_ID = 'footer-four-widgets';

	/**
	 * FooterWidgetFour constructor.
	 *
	 * @since   1.0.0
	 * @access  public
	 */
	public function init() {
		$this->set_property( 'label', __( 'Footer Four', 'solace' ) );

		$this->set_property( 'id', self::COMPONENT_ID );
		$this->set_property( 'width', 3 );

		$this->set_property( 'section', 'sidebar-widgets-footer-four-widgets' );
		if ( solace_is_new_widget_editor() ) {
			if ( strpos( $this->section, 'widgets-footer' ) !== false ) {
				$this->set_property( 'section', 'solace_' . $this->section );
			}
		}

		add_filter( 'customize_section_active', array( $this, 'footer_widgets_show' ), 15, 2 );
	}

	/**
	 * Called to register component controls.
	 *
	 * @since   1.0.0
	 * @access  public
	 */
	public function add_settings() {
		if ( ! solace_is_new_widget_editor() ) {
			SettingsManager::get_instance()->add_controls_to_tabs(
				self::COMPONENT_ID,
				array(
					SettingsManager::TAB_GENERAL => array(
						'sidebars_widgets-footer-four-widgets' => array(),
					),
				)
			);
		}
	}
}
