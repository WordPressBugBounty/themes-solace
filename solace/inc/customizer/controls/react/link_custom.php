<?php
/**
 * Inline Select Control. Handles data passing from args to JS.
 *
 * @package Solace\Customizer\Controls\React
 */

namespace Solace\Customizer\Controls\React;

/**
 * Class Link_Custom
 *
 * @package Solace\Customizer\Controls\React
 */
class Link_Custom extends \WP_Customize_Control {
	/**
	 * Control type.
	 *
	 * @var string
	 */
	public $type = 'solace_link_custom';

	/**
	 * Options.
	 *
	 * @var array
	 */
	public $options = [];

	/**
	 * Default.
	 *
	 * @var string|int
	 */
	public $default;

	/**
	 * Link.
	 *
	 * @var array
	 */
	public $link;

	/**
	 * Allows listening to other components.
	 *
	 * @var string
	 */
	public $changes_on;
	/**
	 * Send to JS.
	 */
	public function json() {
		$json               = parent::json();
		$json['options']    = $this->options;
		$json['defaultVal'] = $this->default;
		$json['link']       = $this->link;
		$json['changesOn']  = $this->changes_on;
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
