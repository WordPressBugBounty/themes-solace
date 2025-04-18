<?php
/**
 * Content none class.
 *
 * @package Solace\Views
 */

namespace Solace\Views;

/**
 * Class Content_None
 *
 * @package Solace\Views
 */
class Content_None extends Base_View {

	/**
	 * Init function.
	 */
	public function init() {
		add_filter( 'get_search_form', [ $this, 'add_instance_id' ] );
		add_action( 'solace_do_content_none', array( $this, 'render_content_none' ) );
	}

	/**
	 * Add input inside the HTML of search form to differentiate the instances.
	 *
	 * @param string $form Form HTML.
	 *
	 * @since   2.4.0
	 * @access  public
	 * @return string
	 */
	public function add_instance_id( $form ) {
		$form = str_replace( 'search-submit', 'search-submit nv-submit', $form );

		if ( ! isset( $_GET['form-instance'] ) ) {
			return $form;
		}

		$component_id = sanitize_text_field( $_GET['form-instance'] );
		$form         = str_replace( '</label>', '</label><input type="hidden" name="form-instance" value="' . esc_attr( $component_id ) . '">', $form );
		return $form;
	}

	/**
	 * Render content none;
	 */
	public function render_content_none() {
		echo '<div class="col-12 nv-content-none-wrap">';
		if ( is_home() && current_user_can( 'publish_posts' ) ) {
			echo '<p>';

			printf(
				/* translators: %s is Link to new post */
				esc_html__( 'Ready to publish your first post? %s.', 'solace' ),
				sprintf(
					/* translators: %1$s is Link to new post, %2$s is Get started here */
					'<a href="%1$s">%2$s</a>',
					esc_url( admin_url( 'post-new.php' ) ),
					esc_html__( 'Get started here', 'solace' )
				)
			);

			echo '</p>';
		} elseif ( is_search() ) {
			$this->render_search_none();
		}

		echo '</div>';
		comments_template();
	}

	/**
	 * Render Search 404.
	 */
	private function render_search_none() {
		echo '<p>';
		esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'solace' );
		echo '</p>';
		echo '<div class="nv-seach-form-wrap">';
		get_search_form();
		echo '</div>';
	}
}
