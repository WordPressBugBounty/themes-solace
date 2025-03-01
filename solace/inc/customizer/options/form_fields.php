<?php
/**
 * Form Fields section.
 *
 * @package Solace\Customizer\Options
 */

namespace Solace\Customizer\Options;

use HFG\Traits\Core;
use Solace\Core\Settings\Config;
use Solace\Core\Settings\Mods;
use Solace\Customizer\Base_Customizer;
use Solace\Customizer\Types\Control;
use Solace\Customizer\Types\Section;

/**
 * Class Form_Fields
 *
 * @package Solace\Customizer\Options
 */
class Form_Fields extends Base_Customizer {
	use Core;

	/**
	 * Customizer section slug.
	 *
	 * @var string
	 */
	private $section_id = 'solace_form_fields_section';

	/**
	 * Function that should be extended to add customizer controls.
	 *
	 * @return void
	 */
	public function add_controls() {
		$this->add_form_section();
		$this->add_form_fields_controls();
		$this->add_input_text_controls();
		$this->add_form_labels_controls();
		$this->add_button_controls();
	}

	/**
	 * Add section.
	 */
	private function add_form_section() {
		$this->add_section(
			new Section(
				$this->section_id,
				[
					'priority'           => 45,
					'description_hidden' => true,
					'description'        => __( 'Customize the general design of the form elements across the site.', 'solace' ),
					'title'              => esc_html__( 'Form Fields', 'solace' ),
				]
			)
		);
	}

	/**
	 * Form fields controls.
	 */
	private function add_form_fields_controls() {
		$this->add_control(
			new Control(
				'solace_form_fields_heading',
				[
					'sanitize_callback' => 'sanitize_text_field',
				],
				[
					'label'            => esc_html__( 'Form Fields', 'solace' ),
					'section'          => $this->section_id,
					'priority'         => 10,
					'class'            => 'form-fields-accordion',
					'accordion'        => true,
					'controls_to_wrap' => 5,
				],
				'Solace\Customizer\Controls\Heading'
			)
		);

		// Padding
		$default_padding = Mods::get_alternative_mod_default( Config::MODS_FORM_FIELDS_PADDING );
		$this->add_control(
			new Control(
				Config::MODS_FORM_FIELDS_PADDING,
				[
					'sanitize_callback' => [ $this, 'sanitize_spacing_array' ],
					'transport'         => $this->selective_refresh,
					'default'           => $default_padding,
				],
				[
					'label'                 => esc_html__( 'Field Padding', 'solace' ),
					'section'               => $this->section_id,
					'priority'              => 15,
					'units'                 => [ 'px', 'em', 'rem' ],
					'default'               => $default_padding,
					'live_refresh_selector' => true,
					'live_refresh_css_prop' => [
						'cssVar'      => [
							'selector' => 'body',
							'vars'     => '--formfieldpadding',
							'suffix'   => 'px',
						],
						'responsive'  => false,
						'directional' => true,
						'template'    =>
							'
							body form input:read-write,
							body form textarea,
							body form select,
							body form select option,
							body form.wp-block-search input.wp-block-search__input,
							.woocommerce-cart table.cart td.actions .coupon .input-text,
							.woocommerce-page .select2-container--default .select2-selection--single,
							.woocommerce-page .woocommerce form .form-row input.input-text,
							.woocommerce-page .woocommerce form .form-row textarea,
							.widget select,
							.wc-block-product-search form input.wc-block-product-search__field {
								 padding-top: {{value.top}};
								 padding-right: {{value.right}};
								 padding-bottom: {{value.bottom}};
								 padding-left: {{value.left}};
					        }
					        form.search-form input[type="search"],
					        form.woocommerce-product-search input[type="search"] {
					             padding-right: calc({{value.right}} + 33px);
					        }',
					],
				],
				'\Solace\Customizer\Controls\React\Nr_Spacing'
			)
		);

		// Background color
		$this->add_control(
			new Control(
				Config::MODS_FORM_FIELDS_BACKGROUND_COLOR,
				[
					'sanitize_callback' => 'solace_sanitize_colors',
					'default'           => 'var(--sol-color-background)',
					'transport'         => $this->selective_refresh,
				],
				[
					'label'                 => esc_html__( 'Field Background Color', 'solace' ),
					'section'               => $this->section_id,
					'priority'              => 17,
					'default'               => 'var(--sol-color-background)',
					'input_attrs'           => [
						'allow_gradient' => true,
					],
					'live_refresh_selector' => true,
					'live_refresh_css_prop' => [
						'cssVar'   => [
							'selector' => 'body',
							'vars'     => '--formfieldbgcolor',
						],
						'template' => '
							body form input:read-write,
							body form textarea,
							body form select,
							body form select option,
							body form.wp-block-search input.wp-block-search__input,
							.woocommerce-cart table.cart td.actions .coupon .input-text,
							.woocommerce-page .select2-container--default .select2-selection--single,
							.woocommerce-page .woocommerce form .form-row input.input-text,
							.woocommerce-page .woocommerce form .form-row textarea,
							.widget select,
							.wc-block-product-search form input.wc-block-product-search__field {
							    background-color: {{value}};
						    }',

					],
				],
				'Solace\Customizer\Controls\React\Color'
			)
		);

		// Border width
		$default_width = Mods::get_alternative_mod_default( Config::MODS_FORM_FIELDS_BORDER_WIDTH );
		$this->add_control(
			new Control(
				Config::MODS_FORM_FIELDS_BORDER_WIDTH,
				[
					'sanitize_callback' => [ $this, 'sanitize_spacing_array' ],
					'transport'         => $this->selective_refresh,
					'default'           => $default_width,
				],
				[
					'label'                 => esc_html__( 'Border Width', 'solace' ),
					'section'               => $this->section_id,
					'priority'              => 18,
					'units'                 => [ 'px', 'em', 'rem' ],
					'default'               => $default_width,
					'live_refresh_selector' => true,
					'live_refresh_css_prop' => [
						'cssVar'      => [
							'selector' => 'body',
							'vars'     => '--formfieldborderwidth',
							'suffix'   => 'px',
						],
						'responsive'  => false,
						'directional' => true,
						'template'    => '
							body form input:read-write,
							body form textarea,
							body form select,
							body form select option,
							body form.wp-block-search input.wp-block-search__input,
							.woocommerce-cart table.cart td.actions .coupon .input-text,
							.woocommerce-page .select2-container--default .select2-selection--single,
							.woocommerce-page .woocommerce form .form-row input.input-text,
							.woocommerce-page .woocommerce form .form-row textarea,
							.widget select,
							.wc-block-product-search form input.wc-block-product-search__field {
                                border-top-width: {{value.top}};
							    border-right-width: {{value.right}};
						        border-bottom-width: {{value.bottom}};
						        border-left-width: {{value.left}};
					         }',
					],
				],
				'\Solace\Customizer\Controls\React\Nr_Spacing'
			)
		);

		// Border radius
		$this->add_control(
			new Control(
				Config::MODS_FORM_FIELDS_BORDER_RADIUS,
				[
					'sanitize_callback' => [ $this, 'sanitize_spacing_array' ],
					'transport'         => $this->selective_refresh,
					'default'           => solace_is_new_skin() ? false : [
						'top'    => '',
						'right'  => '',
						'left'   => '',
						'bottom' => '',
						'unit'   => 'px',
					],
				],
				[
					'label'                 => esc_html__( 'Border Radius', 'solace' ),
					'section'               => $this->section_id,
					'priority'              => 19,
					'units'                 => [ 'px', 'em', 'rem' ],
					'default'               => [
						'top'    => '3',
						'right'  => '3',
						'left'   => '3',
						'bottom' => '3',
						'unit'   => 'px',
					],
					'live_refresh_selector' => true,
					'live_refresh_css_prop' => [
						'cssVar'      => [
							'selector' => 'body',
							'vars'     => '--formfieldborderradius',
							'suffix'   => 'px',
						],
						'responsive'  => false,
						'directional' => true,
						'template'    => '
							body form input:read-write,
							body form textarea,
							body form select,
							body form select option,
							body form.wp-block-search input.wp-block-search__input,
							.woocommerce-cart table.cart td.actions .coupon .input-text,
							.woocommerce-page .select2-container--default .select2-selection--single,
							.woocommerce-page .woocommerce form .form-row input.input-text,
							.woocommerce-page .woocommerce form .form-row textarea,
							.widget select,
							.wc-block-product-search form input.wc-block-product-search__field {
								border-top-right-radius: {{value.top}};
								border-bottom-right-radius: {{value.right}};
								border-bottom-left-radius: {{value.bottom}};
								border-top-left-radius: {{value.left}};
							}',
					],
				],
				'\Solace\Customizer\Controls\React\Nr_Spacing'
			)
		);

		// Border color
		$this->add_control(
			new Control(
				Config::MODS_FORM_FIELDS_BORDER_COLOR,
				[
					'sanitize_callback' => 'solace_sanitize_colors',
					'default'           => '#dddddd',
					'transport'         => $this->selective_refresh,
				],
				[
					'label'                 => esc_html__( 'Border Color', 'solace' ),
					'section'               => $this->section_id,
					'priority'              => 20,
					'default'               => '#dddddd',
					'live_refresh_selector' => true,
					'live_refresh_css_prop' => [
						'cssVar'   => [
							'selector' => 'body',
							'vars'     => '--formfieldbordercolor',
						],
						'template' => '
							body form input:read-write,
							body form textarea,
							body form select,
							body form select option,
							body form.wp-block-search input.wp-block-search__input,
							.woocommerce-cart table.cart td.actions .coupon .input-text,
							.woocommerce-page .select2-container--default .select2-selection--single,
							.woocommerce-page .woocommerce form .form-row input.input-text,
							.woocommerce-page .woocommerce form .form-row textarea,
							.widget select,
							.wc-block-product-search form input.wc-block-product-search__field {
								border-color: {{value}};
							}',
					],
				],
				'Solace\Customizer\Controls\React\Color'
			)
		);
	}

	/**
	 * Form inputs controls.
	 */
	private function add_input_text_controls() {
		$this->add_control(
			new Control(
				'solace_input_text_heading',
				[
					'sanitize_callback' => 'sanitize_text_field',
				],
				[
					'label'            => esc_html__( 'Input Text', 'solace' ),
					'section'          => $this->section_id,
					'priority'         => 30,
					'class'            => 'form-input-accordion',
					'accordion'        => true,
					'expanded'         => false,
					'controls_to_wrap' => 2,
				],
				'Solace\Customizer\Controls\Heading'
			)
		);

		// Field text color
		$this->add_control(
			new Control(
				Config::MODS_FORM_FIELDS_COLOR,
				[
					'sanitize_callback' => 'solace_sanitize_colors',
					'default'           => 'var(--sol-color-base-font)',
					'transport'         => $this->selective_refresh,
				],
				[
					'label'                 => esc_html__( 'Color', 'solace' ),
					'section'               => $this->section_id,
					'priority'              => 31,
					'default'               => 'var(--sol-color-base-font)',
					'live_refresh_selector' => true,
					'live_refresh_css_prop' => [
						'cssVar'   => [
							'selector' => 'body',
							'vars'     => '--formfieldcolor',
						],
						'template' => '
							body form input:read-write,
							body form textarea,
							body form select,
							body form select option,
							body form.wp-block-search input.wp-block-search__input,
							.woocommerce-cart table.cart td.actions .coupon .input-text,
							.woocommerce-page .select2-container--default .select2-selection--single,
							.woocommerce-page .woocommerce form .form-row input.input-text,
							.woocommerce-page .woocommerce form .form-row textarea,
							.widget select,
							.wc-block-product-search form input.wc-block-product-search__field {
								color: {{value}};
							}',
					],
				],
				'Solace\Customizer\Controls\React\Color'
			)
		);

		// Field typeface
		$this->add_control(
			new Control(
				Config::MODS_FORM_FIELDS_TYPEFACE,
				[
					'transport' => $this->selective_refresh,
				],
				[
					'priority'              => 32,
					'section'               => $this->section_id,
					'input_attrs'           => array(
						'disable_transform'      => true,
						'default_is_empty'       => true,
						'size_units'             => [ 'px', 'em' ],
						'weight_default'         => 'none',
						'size_default'           => array(
							'suffix'  => array(
								'mobile'  => 'px',
								'tablet'  => 'px',
								'desktop' => 'px',
							),
							'mobile'  => '',
							'tablet'  => '',
							'desktop' => '',
						),
						'line_height_default'    => array(
							'mobile'  => '',
							'tablet'  => '',
							'desktop' => '',
						),
						'letter_spacing_default' => array(
							'mobile'  => '',
							'tablet'  => '',
							'desktop' => '',
						),
					),
					'type'                  => 'solace_typeface_control',
					'font_family_control'   => 'solace_body_font_family',
					'refresh_on_reset'      => true,
					'live_refresh_selector' => '
						form input:read-write,
						form textarea,
						form select,
						form select option,
						form.wp-block-search input.wp-block-search__input,
						.woocommerce-cart table.cart td.actions .coupon .input-text,
						.woocommerce-page .select2-container--default .select2-selection--single,
						.woocommerce-page .woocommerce form .form-row input.input-text,
						.woocommerce-page .woocommerce form .form-row textarea,
						.widget select,
						.wc-block-product-search form input.wc-block-product-search__field
					',
					'live_refresh_css_prop' => [
						'cssVar' => [
							'vars'     => [
								'--formfieldtexttransform' => 'textTransform',
								'--formfieldfontweight'    => 'fontWeight',
								'--formfieldfontsize'      => [
									'key'        => 'fontSize',
									'responsive' => true,
								],
								'--formfieldlineheight'    => [
									'key'        => 'lineHeight',
									'responsive' => true,
								],
								'--formfieldletterspacing' => [
									'key'        => 'letterSpacing',
									'suffix'     => 'px',
									'responsive' => true,
								],
							],
							'selector' => 'body',
						],
					],
				],
				'\Solace\Customizer\Controls\React\Typography'
			)
		);
	}

	/**
	 * Form labels controls.
	 */
	private function add_form_labels_controls() {
		$this->add_control(
			new Control(
				'solace_form_labels_heading',
				[
					'sanitize_callback' => 'sanitize_text_field',
				],
				[
					'label'            => esc_html__( 'Form Labels', 'solace' ),
					'section'          => $this->section_id,
					'priority'         => 50,
					'class'            => 'form-labels-accordion',
					'accordion'        => true,
					'expanded'         => false,
					'controls_to_wrap' => 1,
				],
				'Solace\Customizer\Controls\Heading'
			)
		);

		$this->add_control(
			new Control(
				Config::MODS_FORM_FIELDS_LABELS_TYPEFACE,
				[
					'transport' => $this->selective_refresh,
				],
				[
					'priority'              => 52,
					'section'               => $this->section_id,
					'input_attrs'           => [
						'default_is_empty'       => true,
						'size_units'             => [ 'px', 'em' ],
						'weight_default'         => 'none',
						'size_default'           => [
							'suffix'  => [
								'mobile'  => 'px',
								'tablet'  => 'px',
								'desktop' => 'px',
							],
							'mobile'  => '',
							'tablet'  => '',
							'desktop' => '',
						],
						'line_height_default'    => [
							'mobile'  => '',
							'tablet'  => '',
							'desktop' => '',
						],
						'letter_spacing_default' => [
							'mobile'  => '',
							'tablet'  => '',
							'desktop' => '',
						],
					],
					'type'                  => 'solace_typeface_control',
					'font_family_control'   => 'solace_body_font_family',
					'refresh_on_reset'      => true,
					'live_refresh_selector' => 'form label, body .wpforms-container .wpforms-field-label, .woocommerce form .form-row label',
					'live_refresh_css_prop' => [
						'cssVar' => [
							'vars'     => [
								'--formlabeltexttransform' => 'textTransform',
								'--formlabelfontweight'    => 'fontWeight',
								'--formlabelfontsize'      => [
									'key'        => 'fontSize',
									'responsive' => true,
								],
								'--formlabellineheight'    => [
									'key'        => 'lineHeight',
									'responsive' => true,
								],
								'--formlabelletterspacing' => [
									'key'        => 'letterSpacing',
									'suffix'     => 'px',
									'responsive' => true,
								],
							],
							'selector' => 'body',
						],
					],
				],
				'\Solace\Customizer\Controls\React\Typography'
			)
		);
	}

	/**
	 * Form button controls.
	 */
	private function add_button_controls() {
		$this->add_control(
			new Control(
				'solace_form_button_heading',
				[
					'sanitize_callback' => 'sanitize_text_field',
				],
				array(
					'label'            => esc_html__( 'Button', 'solace' ),
					'section'          => $this->section_id,
					'priority'         => 70,
					'class'            => 'form-button-accordion',
					'accordion'        => true,
					'expanded'         => false,
					'controls_to_wrap' => 1,
				),
				'Solace\Customizer\Controls\Heading'
			)
		);

		$this->add_control(
			new Control(
				'solace_form_button_type',
				[
					'sanitize_callback' => 'solace_sanitize_button_type',
					'default'           => 'primary',
				],
				[
					'label'    => __( 'Button Style', 'solace' ),
					'priority' => 71,
					'section'  => $this->section_id,
					'type'     => 'solace_inline_select',
					'options'  => [
						'primary'   => __( 'Primary', 'solace' ),
						'secondary' => __( 'Secondary', 'solace' ),
					],
					'default'  => 'primary',
					'link'     => [
						'focus'  => [ 'section', 'solace_buttons_section' ],
						'string' => esc_html__( 'Customize the default button styles', 'solace' ),
					],
				],
				'Solace\Customizer\Controls\React\Inline_Select'
			)
		);
	}
}
