<?php
/**
 * Radio Image Control. Handles data passing from args to JS.
 *
 * @package Solace\Customizer\Controls\React
 */

namespace Solace\Customizer\Controls\React;

/**
 * Class Radio_Image
 *
 * @package Solace\Customizer\Controls\React
 */
class Radio_Image extends \WP_Customize_Control {
	/**
	 * Control type.
	 *
	 * @var string
	 */
	public $type = 'solace_radio_image_control';
	/**
	 * Additional arguments passed to JS.
	 *
	 * @var array
	 */
	public $choices = [];
	/**
	 * Additional arguments passed to JS.
	 *
	 * @var array
	 */
	public $documentation = [];
	/**
	 * Send to JS.
	 */
	public function json() {
		$json                  = parent::json();
		$json['choices']       = $this->choices;
		$json['documentation'] = $this->documentation;
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
