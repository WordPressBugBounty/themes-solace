<?php
/**
 * Metabox radio button control.
 *
 * @package Solace\Admin\Metabox\Controls
 */

namespace Solace\Admin\Metabox\Controls;

/**
 * Class Radio
 *
 * @package Solace\Admin\Metabox\Controls
 */
class Radio extends Control_Base {
	/**
	 * Control type.
	 *
	 * @var string
	 */
	public $type = 'radio';

	/**
	 * Render control.
	 *
	 * @return void
	 */
	public function render_content( $post_id ) {
		$selected = $this->get_value( $post_id );
		$markup   = '<style>#solace-page-settings label{ display: block; margin-bottom: 5px;}</style>';

		$markup .= '<p>';
		foreach ( $this->settings['choices'] as $value => $choice ) {
			$markup .= '<label for="' . esc_attr( $this->id . '_' . $value ) . '">';
			$markup .= '<input type="radio" value="' . esc_attr( $value ) . '" id="' . esc_attr( $this->id . '_' . $value ) . '" name="' . esc_attr( $this->id ) . '"';
			$markup .= checked( $selected ? $selected : $this->settings['default'], $value, false );
			$markup .= '/>';
			$markup .= esc_html( $choice ) . '</label>';
		}
		$markup .= '</p>';

		echo $markup; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}
