<?php
/**
 * Template used for component rendering wrapper.
 *
 * Name:    Header Footer Grid
 *
 * @version 1.0.0
 * @package HFG
 */

namespace HFG;

use HFG\Core\Components\FooterHtml4;

$content           = component_setting( FooterHtml4::CONTENT_ID );
$content           = apply_filters( 'solace_translate_single_string', $content, FooterHtml4::CONTENT_ID );
$content           = apply_filters( 'solace_top_bar_content', $content );
$allowed_post_tags = wp_kses_allowed_html( 'header_footer_grid' );

?>
<div class="nv-html-content"> <?php //phpcs:ignore WordPressVIPMinimum.Security.Vuejs.RawHTMLDirectiveFound ?>
	<?php echo solace_sanitize_js_and_php( balanceTags( parse_dynamic_tags( $content ), true ) ); ?>
</div>
