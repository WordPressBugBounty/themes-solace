<?php
/**
 * Global_Custom_Colors Control. Handles data passing from args to JS.
 *
 * @package Solace\Customizer\Controls\React
 */

namespace Solace\Customizer\Controls\React;

/**
 * Class Global_Custom_Colors
 *
 * @package Solace\Customizer\Controls\React
 */
class Global_Custom_Colors extends \WP_Customize_Control {
	/**
	 * Control type.
	 *
	 * @var string
	 */
	public $type = 'solace_global_custom_colors';
	/**
	 * Default values.
	 *
	 * @var string
	 */
	public $default_values = '';

	/**
	 * Additional arguments passed to JS.
	 *
	 * @var array
	 */
	public $input_attrs = [];

	/**
	 * Send to JS.
	 */
	public function json() {
		$json                  = parent::json();
		$json['defaultValues'] = $this->default_values;
		$json['input_attrs']   = $this->input_attrs;
		return $json;
	}

	/**
	 * This method overrides the default render
	 * so that nothing is rendered.
	 * Previously it would try to put an input element where the value was `esc_attr()`
	 * This would trigger notices in PHP
	 * It is not required to have a render as it is being handled by React.
	 */
	final public function render_content() {
		// this is rendered from React
	}
}
