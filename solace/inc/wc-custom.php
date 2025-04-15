<?php
/**
 * WooCommerce Custom Customizer
 *
 * @link https://woocommerce.com/
 *
 * @package solace
 */

/**
 * WooCommerce setup function.
 *
 * @return void
 */

function solace_customizer_preview_disable_woocommerce_star_rating() {
    // Check if the customizer option is set to false
    if (get_theme_mod('solace_wc_custom_general_star_rating_show') === false) {
        // Ensure hooks are removed during customizer preview
        add_action('wp_head', function() {
            remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);
            remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10);
        });
    }
}

function customize_checkout_company_field($fields) {
    $company_field_setting = get_theme_mod('woocommerce_checkout_company_field', 'hidden');

    if ($company_field_setting === 'hidden') {
        $fields['billing']['billing_company']['required'] = false;
        $fields['billing']['billing_company']['class'][] = 'hidden';
    } elseif ($company_field_setting === 'required') {
        $fields['billing']['billing_company']['required'] = true;
        // Remove 'hidden' class if it exists
        if (($key = array_search('hidden', $fields['billing']['billing_company']['class'])) !== false) {
            unset($fields['billing']['billing_company']['class'][$key]);
        }
    } else {
        $fields['billing']['billing_company']['required'] = false;
        // Remove 'hidden' class if it exists
        if (($key = array_search('hidden', $fields['billing']['billing_company']['class'])) !== false) {
            unset($fields['billing']['billing_company']['class'][$key]);
        }
    }

    return $fields;
}



function solace_customizer_css() {
    $rating_color = get_theme_mod('solace_wc_custom_general_star_rating_color', 'var(--sol-color-selection-high)');
    $badge_shape = get_theme_mod('solace_wc_custom_general_product_badges_shape','badge-1');
    $badge_color = get_theme_mod('solace_wc_custom_general_product_badges_color', 'var(--sol-color-page-title-text)');
    $badge_background_color = get_theme_mod('solace_wc_custom_general_product_badges_background_color', 'transparent');
    
    $notice_status = get_theme_mod('solace_wc_custom_general_store_notice_show', false);
    $notice_font_color = get_theme_mod('solace_wc_custom_general_store_notice_font_color', 'var(--sol-color-selection-initial)');
    $notice_bg_color = get_theme_mod('solace_wc_custom_general_store_notice_background_color', 'var(--sol-color-selection-high)');

    ?>
    <style type="text/css">
        <?php if (get_theme_mod('solace_wc_custom_general_star_rating_show', true) === false) : ?>
            .woocommerce .product .star-rating, .woocommerce .woocommerce-product-rating {
                display: none;
            }
        <?php endif; ?>

        <?php if (get_theme_mod('solace_wc_custom_general_store_notice_show', true) === true) { ?>
            p.woocommerce-store-notice.demo_store, .rico_store_true {
                display: block !important;
            }
        <?php 
        } else {?>
            p.woocommerce-store-notice.demo_store,.rico_store_false {
                display: none !important;
            }
        <?php } ?>
	

        body.woocommerce.woocommerce-shop ul.products .star-rating,.rico_custom {
            color: <?php echo $rating_color;?>;
        }

        body.woocommerce.woocommerce-shop ul.products .img-wrap span.onsale {
            color: <?php echo $badge_color;?>;
        }

        

        <?php 

        if ( get_theme_mod( 'solace_wc_custom_general_cart_coupon', true ) === false ) {
            ?>
            .woocommerce-cart .coupon, .wp-block-woocommerce-cart-order-summary-coupon-form-block.wc-block-components-totals-wrapper {
                display: none;
            }
        <?php 
        } else {
            ?>
            .woocommerce-cart .coupon, .wp-block-woocommerce-cart-order-summary-coupon-form-block.wc-block-components-totals-wrapper {
                display: block;
            }
        <?php } ?>

        <?php
        $show_coupon_form = get_theme_mod('solace_wc_custom_general_checkout_coupon', true);

        if (!$show_coupon_form) {
            ?>
            
                .wp-block-woocommerce-checkout-order-summary-coupon-form-block,
                #solace-checkout-coupon {
                    display: none !important;
                }
            
            <?php
        } ?>

        <?php
        $field_option = get_option('woocommerce_checkout_company_field');?>
        <?php if ( $field_option === 'required' ) : ?>
            .wc-block-components-address-form__company label::after {
                content: none !important;
            }
        <?php elseif ( $field_option === 'hidden' ) : ?>
            .wc-block-components-address-form__company {
                display: none;
            }
        <?php endif;
        
        $field_option = get_option('woocommerce_checkout_phone_field');?>
        <?php if ( $field_option === 'required' ) : ?>
            .wc-block-components-address-form__phone label::after {
                content: none !important;
            }
        <?php elseif ( $field_option === 'hidden' ) : ?>
            .wc-block-components-address-form__phone {
                display: none;
            }
        <?php endif;

        $field_option = get_option('woocommerce_checkout_address_2_field');?>
        <?php if ( $field_option === 'required' ) : ?>
            .wc-block-components-address-form__address_2 label::after {
                content: none !important;
            }
        <?php elseif ( $field_option === 'hidden' ) : ?>
            .wc-block-components-address-form__address_2,
            .wc-block-components-address-form__address_2-toggle {
                display: none;
            }
        <?php endif; ?>

        .woocommerce-store-notice, p.demo_store {
            color: <?php echo $notice_font_color;?>
        }
        .woocommerce-store-notice, p.demo_store {
            background-color: <?php echo $notice_bg_color;?>
        }
    </style>
    <?php
}
add_action('wp_head', 'solace_customizer_css');

function solace_custom_product_badge_text() {
    $badge_label = get_theme_mod('solace_wc_custom_general_product_badges_label', 'Sale!');
    $badge_shape = get_theme_mod('solace_wc_custom_general_product_badges_shape','badge-1');


    if (!empty($badge_label)) {
        return '<span class="onsale '.$badge_shape.'">'.$badge_label.'</span>';
    }

    return 'Sale!';
}

add_filter('woocommerce_sale_flash', 'solace_custom_product_badge_text', 10, 3);

function solace_move_woocommerce_controls( $wp_customize ) {
    foreach ( $wp_customize->settings() as $setting ) {
        $control = $wp_customize->get_control( $setting->id );

        if ( $control && $control->section === 'woocommerce_checkout' ) {
            $control->section = 'solace_wc_custom_general_checkout';
        }
        if ( $control && $control->section === 'woocommerce_store_notice' ) {
            $control->section = 'solace_wc_custom_general_store_notice';
            $control->priority = 112;
            
        }
    }
    $store_notice_control = $wp_customize->get_control('woocommerce_demo_store_notice');

    if ( $store_notice_control ) {
        $store_notice_control->priority = 113;
        $store_notice_control->label = 'Text';
    }
}
add_action( 'customize_register', 'solace_move_woocommerce_controls', 20 );

add_action('init', 'solace_toggle_store_notice_based_on_setting');

function solace_toggle_store_notice_based_on_setting() {
    update_option('woocommerce_demo_store', 'yes');
}

add_action('customize_save_after', 'solace_toggle_store_notice_based_on_setting2');

function solace_toggle_store_notice_based_on_setting2() {

    $show_notice = get_theme_mod('solace_wc_custom_general_store_notice_show', false);

    if ($show_notice) {
        update_option('woocommerce_demo_store', 'yes');
    } else {
        update_option('woocommerce_demo_store', 'no');
    }
}


add_action('wp_ajax_update_store_notice', 'update_store_notice');
function update_store_notice() {
    if (isset($_POST['status']) && in_array($_POST['status'], array('yes', 'no'))) {
        update_option('woocommerce_demo_store', sanitize_text_field($_POST['status']));
        wp_send_json_success();
    } else {
        wp_send_json_error();
    }
}

function solace_enqueue_dokan_style() {
   
    
    wp_add_inline_script( 
        'jquery-core', 
        "
        jQuery(document).ready(function($) {
            if ($('body').hasClass('dokan-store') || $('body').hasClass('dokan-dashboard')) {
                // Apply the enqueued style by force
                $('link#solace-dokan-style').prop('disabled', false);
            } else {
                // Optionally, disable the style if the classes are not present
                $('link#solace-dokan-style').prop('disabled', true);
            }
        });
        "
    );

    if (in_array('dokan-store', get_body_class(), true)) {

        wp_enqueue_style(
            'solace-dokan-style',
            SOLACE_ASSETS_URL . 'css/solace-dokan.css',
            array(),
            SOLACE_VERSION
        );
        wp_enqueue_script(
            'solace-dokan-script',
            get_stylesheet_directory_uri() . '/js/dokan.js',
            array( 'jquery' )
        );
    }
}

add_action( 'wp_enqueue_scripts', 'solace_enqueue_dokan_style' );

/**
 * Add a wrapper div before the WooCommerce products shortcode output.
 *
 * This function hooks into `woocommerce_shortcode_before_products_loop` to
 * add a custom opening `<div>` wrapper with a specific class.
 *
 * @return void
 */
function solace_add_wrapper_before_products() {
    echo '<div class="solace-shortcode-wc">';
}

/**
 * Add a closing wrapper div after the WooCommerce products shortcode output.
 *
 * This function hooks into `woocommerce_shortcode_after_products_loop` to
 * close the custom `<div>` wrapper started by `solace_add_wrapper_before_products`.
 *
 * @return void
 */
function solace_add_wrapper_after_products() {
    echo '</div>';
}

add_action('woocommerce_shortcode_before_products_loop', 'solace_add_wrapper_before_products');

add_action('woocommerce_shortcode_after_products_loop', 'solace_add_wrapper_after_products');

add_action('init', function () {
    $custom_setting = get_option('solace_wc_custom_general_store_notice_show', false);

    if ($custom_setting) {
        update_option('woocommerce_demo_store', 'no'); 
    } else {
        update_option('woocommerce_demo_store', 'yes'); 
    }
});
