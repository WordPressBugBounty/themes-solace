<?php
/**
 * Style generator based on settings.
 *
 * @package Solace\Core\Styles
 */

namespace Solace\Core\Styles;

use Solace\Core\Settings\Config;
use Solace\Core\Settings\Mods;

/**
 * Class Generator
 *
 * @package Solace\Core\Styles
 */
class Generator {
	/**
	 * Subscriber list used for CSS generation.
	 *
	 * @var array Subscriber list.
	 */
	protected $_subscribers   = [];
	const SUBSCRIBER_TYPE     = 'type';
	const SUBSCRIBER_MAP      = 'map';
	const SUBSCRIBER_KEY      = 'key';
	const SUBSCRIBER_DEFAULTS = 'defaults';
	/**
	 * Current context.
	 *
	 * @var string|null
	 */
	protected $context = null;

	/**
	 * Generate the dynamic CSS.
	 *
	 * @param bool $echo Should we write it or return it.
	 *
	 * @return string|void Css output.
	 */
	public function generate( $echo = false ) {
		$desktop_css = '';
		$tablet_css  = '';
		$all_css     = '';

		if ( $this->context === null ) {
			$this->context = Dynamic_Selector::CONTEXT_FRONTEND;
		}

		/**
		 * Solace try to build the CSS as mobile first.
		 * Based on this fact, the general CSS is considered the mobile one.
		 */
		$dynamic_selectors = new Dynamic_Selector( $this->_subscribers, $this->context );

		$all_css     .= $dynamic_selectors->for_mobile();
		$tablet_css  .= $dynamic_selectors->for_tablet();
		$desktop_css .= $dynamic_selectors->for_desktop();
		if ( ! empty( $tablet_css ) ) {
			$all_css .= sprintf( '@media(min-width: 576px){ %s }', $tablet_css );
		}
		if ( ! empty( $desktop_css ) ) {
			$all_css .= sprintf( '@media(min-width: 960px){ %s }', $desktop_css );
		}

		if ( ! $echo ) {
			return $all_css;
		}


		echo $all_css; //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	/**
	 * Set new subscribers.
	 *
	 * @param array $subscribers New generator list.
	 */
	public function set( $subscribers ) {
		$this->_subscribers = $subscribers;
	}

	/**
	 * Return current subscribers.
	 *
	 * @return array
	 */
	public function get() {
		return $this->_subscribers;
	}
}
