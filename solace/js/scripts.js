(function ($) {

    // Close Sidebar Woocommerce
    $('.nv-sidebar-wrap aside .close svg').click(function(){
        $('html').attr('class', '');
        $('.nv-sidebar-wrap aside').removeClass('sidebar-open');
    });

    if ($(".wc-block-components-text-input").hasClass("has-error")) {
        $( ".wc-block-components-totals-coupon__button" ).css("bottom", "33px !important");
    }

    $(window).on('load', function() {
        // Use setTimeout to delay the check and execution.
        setTimeout(function() {
            // Check if elements with classes `woocommerce-product-gallery__trigger` and `flex-viewport` exist
            if ($('.single-product .woocommerce-product-gallery .woocommerce-product-gallery__trigger').length || $('.single-product .woocommerce-product-gallery .flex-viewport').length) {
                // Select the element with class `woocommerce-product-gallery__trigger`
                const triggerElement = $('.single-product .woocommerce-product-gallery .woocommerce-product-gallery__trigger');
                // Move the selected element to be a child of the element with class `flex-viewport`
                $('.single-product .woocommerce-product-gallery .flex-viewport').append(triggerElement);
                $('.single-product .woocommerce-product-gallery__image').append(triggerElement);
            }

            // Check if elements with classes `onsale` and `flex-viewport` exist
            if ($('.single-product .onsale').length || $('.single-product .flex-viewport').length) {
                // Select the element with class `onsale`
                const triggerElement = $('.single-product .onsale');
                // Move the selected element to be a child of the element with class `flex-viewport`
                $('.single-product .flex-viewport').append(triggerElement);
                $('.single-product .woocommerce-product-gallery__image').append(triggerElement);
            }
        }, 200);
    });

})(jQuery);