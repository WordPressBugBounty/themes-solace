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
use HFG\Main;
use Solace\Core\Dynamic_Css;
use Solace\Core\Styles\Dynamic_Selector;

/**
 * Class Footer
 *
 * @package HFG\Core\Components
 */
class FooterHtml4 extends Abstract_Component {
	const CONTENT_ID   = 'footer_content4';
	const COMPONENT_ID = 'footer_html4';
	const COLOR_ID     = 'color4';

	/**
	 * FooterHtml4 constructor.
	 *
	 * @since   1.0.0
	 * @access  public
	 */
	public function init() {
		$this->set_property( 'label', __( 'HTML Four', 'solace' ) );
		$this->set_property( 'id', $this->get_class_const( 'COMPONENT_ID' ) );
		$this->set_property( 'width', 3 );
		$this->set_property( 'component_slug', 'hfg-footer-html' );
		$this->set_property( 'icon', 'welcome-write-blog' );
		$this->set_property( 'has_typeface_control', true );
		$this->set_property( 'default_typography_selector', $this->default_typography_selector . '.builder-item--' . $this->get_id() . ' .nv-html-content' ); //phpcs:ignore WordPressVIPMinimum.Security.Vuejs.RawHTMLDirectiveFound
		$this->set_property( 'has_horizontal_alignment', true );
		add_filter( 'wp_kses_allowed_html', array( $this, 'allow_input_form_tags' ), 10, 2 );
		add_action( 'wp_enqueue_scripts', [ $this, 'load_scripts' ] );
	}

	/**
	 * Load Component Scripts
	 *
	 * @return void
	 */
	public function load_scripts() {
		if ( $this->is_component_active() || is_customize_preview() ) {
			wp_add_inline_style( 'solace-style', $this->toggle_style() );
		}
	}

	/**
	 * Get CSS to use as inline script
	 *
	 * @return string
	 */
	public function toggle_style() {
		$css = '.builder-item .item--inner.builder-item--footer_html4,
		.builder-item .item--inner.builder-item--footer_html4 h1,
		.builder-item .item--inner.builder-item--footer_html4 h2,
		.builder-item .item--inner.builder-item--footer_html4 h3,
		.builder-item .item--inner.builder-item--footer_html4 h4,
		.builder-item .item--inner.builder-item--footer_html4 h5,
		.builder-item .item--inner.builder-item--footer_html4 h6 {
			color: var(--footer-text-color-html4);
		}';

		return Dynamic_Css::minify_css( $css );
	}	

	/**
	 * Add form and input tag to allowed tags in header_footer_grid context.
	 *
	 * @param array        $tags HTML Tags.
	 * @param string|array $context The context for which to retrieve tags.
	 *
	 * @return array
	 */
	public function allow_input_form_tags( $tags, $context ) {
		if ( $context !== 'header_footer_grid' ) {
			return $tags;
		}
		$tags              = wp_kses_allowed_html( 'post' );
		$global_attributes = array(
			'accesskey'       => true,
			'class'           => true,
			'contenteditable' => true,
			'data-*'          => true,
			'dir'             => true,
			'draggable'       => true,
			'dropzone'        => true,
			'hidden'          => true,
			'id'              => true,
			'lang'            => true,
			'spellcheck'      => true,
			'style'           => true,
			'tabindex'        => true,
			'title'           => true,
			'translate'       => true,
		);
		$input_attributes  = array(
			'accept'         => true,
			'align'          => true,
			'alt'            => true,
			'autocomplete'   => true,
			'autofocus'      => true,
			'checked'        => true,
			'dirname'        => true,
			'disabled'       => true,
			'form'           => true,
			'formaction'     => true,
			'formenctype'    => true,
			'formmethod'     => true,
			'formnovalidate' => true,
			'formtarget'     => true,
			'height'         => true,
			'list'           => true,
			'max'            => true,
			'maxlength'      => true,
			'min'            => true,
			'multiple'       => true,
			'name'           => true,
			'pattern'        => true,
			'placeholder'    => true,
			'readonly'       => true,
			'required'       => true,
			'size'           => true,
			'src'            => true,
			'step'           => true,
			'type'           => true,
			'value'          => true,
			'width'          => true,
		);
		$form_attributes   = array(
			'accept'         => true,
			'accept-charset' => true,
			'action'         => true,
			'autocomplete'   => true,
			'enctype'        => true,
			'method'         => true,
			'name'           => true,
			'nonvalidate'    => true,
			'target'         => true,
		);

		$tags['input'] = array_merge( $input_attributes, $global_attributes );
		$tags['form']  = array_merge( $form_attributes, $global_attributes );
		$tags['span']  = array_merge( array(), $global_attributes );
		$tags['time']  = array(
			'datetime' => true,
			'class'    => true,
		);

		return $tags;
	}

	/**
	 * Called to register component controls.
	 *
	 * @since   1.0.0
	 * @access  public
	 */
	public function add_settings() {
		SettingsManager::get_instance()->add(
			[
				'id'                 => self::CONTENT_ID,
				'group'              => $this->get_class_const( 'COMPONENT_ID' ),
				'tab'                => SettingsManager::TAB_GENERAL,
				'transport'          => 'post' . $this->get_class_const( 'COMPONENT_ID' ),
				'sanitize_callback'  => 'solace_sanitize_js_and_php',
				// 'default'            => get_theme_mod( 'solace_top_bar_content', '' ),
				'default'            => '<div class="nv-html-content">
				<style>
				.sol-mce #mc-embedded-subscribe-form {
				}
				.sol-mce #mc-embedded-subscribe {
					border-radius: 8px 8px 8px 8px;
					letter-spacing: -.5px;
					font-weight: 500;
					font-size: 18px;
					padding: 15px 30px;
				}
				.sol-mce #mce-EMAIL {
					padding:15px;
					border:1px solid #dedede;
					border-radius:12px;
					margin-bottom:1em;</p>
				}
				@media(max-width:959px) {
					.footer--row .hfg-slot.right .item--inner {
						justify-content: center;
					}
				}
				</style>
			<div id="mc_embed_shell">
			<div class="sol-mce" id="mc_embed_signup">
			<form action="https://djavaweb.us20.list-manage.com/subscribe/post?u=9d1baaf7ecaf34ad1179ddb50&amp;id=2fb133fc3a&amp;f_id=009807eaf0" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_self" novalidate="">
			<div id="mc_embed_signup_scroll"><input type="email" name="EMAIL" class="required email" id="mce-EMAIL" required="" placeholder="Your email"><span id="mce-EMAIL-HELPERTEXT" class="helper_text"></span></div>
			<div id="mce-responses" class="clear foot">
			<div class="response" id="mce-error-response" style="display: none;"></div>
			<div class="response" id="mce-success-response" style="display: none;"></div>
			</div>
			<div aria-hidden="true" style="position: absolute; left: -5000px;">/* real people should not fill this in and expect good things – do not remove this or risk form bot signups */ <input type="text" name="b_9d1baaf7ecaf34ad1179ddb50_2fb133fc3a" value="" tabindex="-1"></div>
			<div class="optionalParent">
			<div class="clear foot"><input type="submit" name="subscribe" id="mc-embedded-subscribe" class="solace-mc-embedded-subscribe elementor-button elementor-button-link elementor-size-md" value="Subscribe"></div>
			</div>
			</form>
			</div>
			</div>
			</div>',
				'label'              => __( 'HTML', 'solace' ),
				'description'        => __( 'Arbitrary HTML code. It supports also shortcodes.', 'solace' ),
				'type'               => '\Solace\Customizer\Controls\React\Rich_Text',
				'section'            => $this->section,
				'options'            => array(
					'input_attrs' => array(
						'toolbars'             => array(
							'toolbar1' => 'formatselect,styleselect,bold,italic,bullist,numlist,link,alignleft,aligncenter,alignright,wp_adv',
							'toolbar2' => 'strikethrough,hr,forecolor,pastetext,removeformat,charmap,outdent,indent',
						),
						'allowedDynamicFields' => array( 'string', 'url' ),
					),
				),
				'conditional_header' => $this->get_builder_id() === 'header',
			]
		);

		SettingsManager::get_instance()->add(
			[
				'id'                    => self::COLOR_ID,
				'group'                 => $this->get_class_const( 'COMPONENT_ID' ),
				'tab'                   => SettingsManager::TAB_GENERAL,
				'transport'             => 'postMessage',
				'sanitize_callback'     => 'solace_sanitize_colors',
				'label'                 => __( 'Text Color', 'solace' ),
				'type'                  => 'solace_color_control',
				'section'               => $this->section,
				'live_refresh_selector' => true,
				'live_refresh_css_prop' => [
					'cssVar' => [
						'vars'     => '--footer-text-color-html4',
						'selector' => '.footer--row .builder-item .builder-item--' .  $this->get_id(),
					],
					[
						'selector' => $this->default_typography_selector . ', ' . $this->default_typography_selector . ' *:not(a)',
						'prop'     => 'color',
						'fallback' => 'inherit',
					],
				],
				'conditional_header'    => $this->get_builder_id() === 'header',
			]
		);
	}

	/**
	 * Method to add Component css styles.
	 *
	 * @param array $css_array An array containing css rules.
	 *
	 * @return array
	 * @since   1.0.0
	 * @access  public
	 */
	public function add_style( array $css_array = array() ) {
		if ( ! solace_is_new_skin() ) {
			$css_array[] = [
				Dynamic_Selector::KEY_SELECTOR => $this->default_typography_selector . ', ' . $this->default_typography_selector . ' *',
				Dynamic_Selector::KEY_RULES    => [
					\Solace\Core\Settings\Config::CSS_PROP_COLOR => [
						Dynamic_Selector::META_KEY     => $this->get_id() . '_' . self::COLOR_ID,
						Dynamic_Selector::META_DEFAULT => SettingsManager::get_instance()->get_default( $this->get_id() . '_' . self::COLOR_ID ),
					],
				],
			];

			return parent::add_style( $css_array );
		}

		$color = sanitize_hex_color(get_theme_mod('footer_html_color'));
		$css_array[] = [
			Dynamic_Selector::KEY_SELECTOR => '.builder-item--' . $this->get_id(),
			Dynamic_Selector::KEY_RULES    => [
				'--footer-text-color-html4'           => [
					Dynamic_Selector::META_KEY     => $this->get_id() . '_' . self::COLOR_ID,
					Dynamic_Selector::META_DEFAULT => 'var(--color)',
				],					
			],		
		];

		return parent::add_style( $css_array );
	}

	/**
	 * The render method for the component.
	 *
	 * @since   1.0.0
	 * @access  public
	 */
	public function render_component() {
		Main::get_instance()->load( 'components/component-footer-html4' );
	}
}
