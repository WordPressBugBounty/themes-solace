<?php
/**
 * Responsive_Range Control. Handles data passing from args to JS.
 *
 * @package Solace\Customizer\Controls\React
 */

namespace Solace\Customizer\Controls\React;

/**
 * Class Responsive_Range
 *
 * @package Solace\Customizer\Controls\React
 */
class Responsive_Range extends \WP_Customize_Control {
	/**
	 * Control type.
	 *
	 * @var string
	 */
	public $type = 'solace_responsive_range_control';
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
		$json                = parent::json();
		$json['input_attrs'] = $this->input_attrs;
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
