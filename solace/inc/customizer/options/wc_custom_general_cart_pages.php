<?php
/**
 * Colors / Background section.
 *
 * Author:          
 * Created on:      20/08/2018
 *
 * @package Solace\Customizer\Options
 */

namespace Solace\Customizer\Options;

use Solace\Customizer\Base_Customizer;
use Solace\Customizer\Defaults\Layout;
use Solace\Customizer\Types\Control;
use Solace\Customizer\Types\Section;

/**
 * Class Colors_Background
 *
 * @package Solace\Customizer\Options
 */
class WC_Custom_General_Cart_Pages extends Base_Customizer {
	use Layout;

	/**
	 * Function that should be extended to add customizer controls.
	 *
	 * @return void
	 */
	public function add_controls() {
		$this->section_features();
		$this->add_main_controls();

	}

	/**
	 * Add customize section
	 */
	private function section_features() {
		$this->add_section(
			new Section(
				'solace_wc_custom_general_cart_pages',
				array(
					'priority' 	=> 108,
					'title'    	=> esc_html__( 'Cart Pages', 'solace' ),
					'panel' 	=> 'solace_wc_custom_general'
				)
			)
		);
	}

	private function add_main_controls() {
		$this->add_control(
			new Control(
				'solace_wc_custom_general_cart_coupon',
				[
					'sanitize_callback' => 'solace_sanitize_checkbox',
					'default'           => true,
					'transport'         => 'postMessage',

				],
				[
					'label'           => esc_html__( 'Coupon Codes', 'solace' ),
					'section'         => 'solace_wc_custom_general_cart_pages',
					'type'            => 'solace_toggle_control',
					'priority'        => 109,
				],
				'Solace\Customizer\Controls\Checkbox'
			)
		);
	}
	

}
