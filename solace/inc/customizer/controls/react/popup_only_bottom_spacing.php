<?php
/**
 * Popup_Only_Bottom_Spacing control. Handles data passing from args to JS.
 *
 * @package Solace\Customizer\Controls\React
 */

namespace Solace\Customizer\Controls\React;

/**
 * Class Popup_Only_Bottom_Spacing
 *
 * @package Solace\Customizer\Controls\React
 */
class Popup_Only_Bottom_Spacing extends \WP_Customize_Control {
	/**
	 * Control type.
	 *
	 * @var string
	 */
	public $type = 'solace_popup_only_bottom_spacing_control';

	/**
	 * Additional arguments passed to JS.
	 *
	 * @var array|mixed
	 */
	public $input_attrs = [];

	/**
	 * Additional arguments passed to JS.
	 *
	 * @var null
	 */
	public $relation = null;	

	/**
	 * Refresh on reset flag.
	 *
	 * @var bool
	 */
	public $refresh_on_reset = false;

	/**
	 * Send to JS.
	 */
	public function json() {
		$json                        = parent::json();
		$json['input_attrs']         = $this->input_attrs;
		$json['relation']            = $this->relation;		
		$json['refresh_on_reset']    = $this->refresh_on_reset;
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
