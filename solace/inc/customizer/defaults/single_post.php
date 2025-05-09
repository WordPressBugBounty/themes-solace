<?php
/**
 * Default settings traits, shared with other classes.
 *
 * @package Solace\Customizer\Defaults
 */

namespace Solace\Customizer\Defaults;

use Solace\Core\Settings\Config;
use Solace\Customizer\Options\Layout_Single_Post;

/**
 * Trait Single_Post_Defaults
 *
 * @package Solace\Customizer\Defaults
 */
trait Single_Post {

	/**
	 * Get default values for blog post featured image controls.
	 *
	 * @return array
	 */
	public function blog_post_single_featured_image_default() {
		$value = array(
			'desktop' => array(
				'imageRatio' 	   => 'original',
				'imageScale' 	   => 'contain',
				'imageSize'  	   => 'medium_large',
				'imageVisibility'  => true,
			),
			'tablet' => array(
				'imageRatio' 	   => 'original',
				'imageScale' 	   => 'contain',
				'imageSize'  	   => 'medium_large',
				'imageVisibility'  => true,
			),			
			'mobile' => array(
				'imageRatio' 	   => 'original',
				'imageScale' 	   => 'contain',
				'imageSize'  	   => 'medium_large',
				'imageVisibility'  => true,
			),			
		);

		return $value;
	}

	/**
	 * Get default values for padding controls.
	 *
	 * @return array
	 */
	public function padding_default( $param = '' ) {
		$map = [
			'mobile'       => [
				'top'    => 20,
				'right'  => 20,
				'bottom' => 20,
				'left'   => 20,
			],
			'tablet'       => [
				'top'    => 30,
				'right'  => 30,
				'bottom' => 30,
				'left'   => 30,
			],
			'desktop'      => [
				'top'    => 40,
				'right'  => 40,
				'bottom' => 40,
				'left'   => 40,
			],
			'mobile-unit'  => 'px',
			'tablet-unit'  => 'px',
			'desktop-unit' => 'px',
		];

		if ( $param === 'cover' ) {
			$map['mobile']['top']    = 40;
			$map['mobile']['right']  = 15;
			$map['mobile']['bottom'] = 40;
			$map['mobile']['left']   = 15;

			$map['tablet']['top']    = 60;
			$map['tablet']['right']  = 30;
			$map['tablet']['bottom'] = 60;
			$map['tablet']['left']   = 30;


			$map['desktop']['top']    = 60;
			$map['desktop']['right']  = 40;
			$map['desktop']['bottom'] = 60;
			$map['desktop']['left']   = 40;
		}

		return $map;
	}

	/**
	 * Get default values for margin divider controls.
	 *
	 * @return array
	 */
	public function margin_divider_default() {
		$map = [
			'mobile'       => [
				'top'    => 0,
				'right'  => 0,
				'bottom' => 0,
				'left'   => 0,
			],
			'tablet'       => [
				'top'    => 0,
				'right'  => 0,
				'bottom' => 0,
				'left'   => 0,
			],
			'desktop'      => [
				'top'    => 0,
				'right'  => 0,
				'bottom' => 0,
				'left'   => 0,
			],
			'mobile-unit'  => 'px',
			'tablet-unit'  => 'px',
			'desktop-unit' => 'px',
		];

		return $map;
	}

	/**
	 * Get default values for padding controls.
	 *
	 * @return array
	 */
	public function border_radius() {
		$map = [
			'mobile'       => [
				'top'    => 0,
				'right'  => 0,
				'bottom' => 0,
				'left'   => 0,
			],
			'tablet'       => [
				'top'    => 0,
				'right'  => 0,
				'bottom' => 0,
				'left'   => 0,
			],
			'desktop'      => [
				'top'    => 0,
				'right'  => 0,
				'bottom' => 0,
				'left'   => 0,
			],
			'mobile-unit'  => 'px',
			'tablet-unit'  => 'px',
			'desktop-unit' => 'px',
		];

		return $map;
	}

	/**
	 * Get the default value for title alignment.
	 *
	 * @return array
	 */
	public static function post_title_alignment() {
		$default_position = is_rtl() ? 'right' : 'left';
		return [
			'mobile'  => $default_position,
			'tablet'  => $default_position,
			'desktop' => $default_position,
		];
	}

	/**
	 * Get default values for ordering control
	 *
	 * @return array
	 */
	public function post_ordering() {
		$default_components = [
			'title-meta',
			'thumbnail',
			'content',
			'tags',
			'comments',
		];

		if ( Layout_Single_Post::is_cover_layout() ) {
			$default_components = [
				'content',
				'tags',
				'comments',
			];
		}

		return apply_filters( 'solace_single_post_elements_default_order', $default_components );
	}

	/**
	 * Return the custom post type context.
	 *
	 * @since 3.1.0
	 *
	 * @param string[] $allowed The default context to be allowed.
	 *
	 * @return array
	 */
	public function get_cpt_context( $allowed = [ 'post', 'page' ] ) {
		/**
		 * Filters the list of available post types to use as context for custom post type meta settings.
		 *
		 * @param string[] $allowed_context An array of allowed post types for context. E.g. [ 'post', 'page' ].
		 *
		 * @since 3.1.0
		 */
		$allowed_context = apply_filters( 'solace_allowed_custom_post_types', $allowed, 10, 1 );
		$context         = get_post_type();
		$context         = apply_filters( 'solace_context_filter', $context, 10, 1 );

		return [ $context, $allowed_context ];
	}


	/**
	 * Check the context for the single post is valid.
	 *
	 * @since 3.1.0
	 *
	 * @param string $context The post type context.
	 *
	 * @return boolean
	 */
	public function is_valid_context( $context ) {
		if ( ! solace_is_new_skin() ) {
			return false;
		}

		return is_singular( $context ) || is_single();
	}

	/**
	 * Checks that a dynamic meta is allowed in the provided context.
	 *
	 * @since 3.1.0
	 *
	 * @param string   $context The context to get the meta for.
	 * @param string[] $allowed_context The allowed contexts to check against.
	 *
	 * @return bool
	 */
	private function is_meta_context_allowed( $context, $allowed_context ) {
		if ( empty( $context ) ) {
			return false;
		}

		if ( ! in_array( $context, $allowed_context, true ) || ! $this->is_valid_context( $context ) ) {
			return false;
		}

		return true;
	}

	/**
	 * Return the sidebar content width meta based on context.
	 *
	 * @since 3.1.0
	 *
	 * @param string   $context            The context to get the meta for.
	 * @param string[] $allowed_context    The allowed contexts to check against.
	 *
	 * @return string
	 */
	public function get_sidebar_content_width_meta( $context, $allowed_context = [ 'post' ] ) {
		if ( ! $this->is_meta_context_allowed( $context, $allowed_context ) ) {
			return '';
		}

		return 'solace_single_' . $context . '_' . Config::MODS_CONTENT_WIDTH;
	}

	/**
	 * Return the meta to use as context.
	 *
	 * @since 3.1.0
	 *
	 * @param string $context            The context to get the meta for.
	 * @param string $meta               The meta key to get the final meta for.
	 * @param array  $allowed_context    The allowed contexts to check against.
	 *
	 * @return string
	 */
	public function get_cover_meta( $context, $meta, $allowed_context = [ 'post', 'page' ] ) {
		if ( ! $this->is_meta_context_allowed( $context, $allowed_context ) ) {
			return '';
		}

		$allowed_meta = [
			Config::MODS_COVER_HEIGHT,
			Config::MODS_COVER_PADDING,
			Config::MODS_COVER_BACKGROUND_COLOR,
			Config::MODS_COVER_OVERLAY_OPACITY,
			Config::MODS_COVER_TEXT_COLOR,
			Config::MODS_COVER_BLEND_MODE,
			Config::MODS_COVER_TITLE_ALIGNMENT,
			Config::MODS_COVER_TITLE_POSITION,
			Config::MODS_COVER_BOXED_TITLE_PADDING,
			Config::MODS_COVER_BOXED_TITLE_BACKGROUND,
		];
		if ( ! in_array( $meta, $allowed_meta, true ) ) {
			return '';
		}

		return 'solace_' . $context . '_' . $meta;
	}
}
