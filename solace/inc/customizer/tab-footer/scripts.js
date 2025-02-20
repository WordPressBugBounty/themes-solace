(function ($) {

    // Append Presets Footer
    window.addEventListener('load', function () {
        // Append presets
        setTimeout(function(){

            const getBoxBeforePresetsFooter = '<li id="footer_presets_custom"><div class="box-presets-footer">';
            const getBtnPresetsFooter = $('li#customize-control-hfg_solace_footer_presets .solace-preset-selector').html();
            const resultsBtnPresetsFooter = getBtnPresetsFooter.replace(/(<button[^>]*)(>)/g, '$1 type="button">');
            const getBoxAfterPresetsFooter = '</div></li>';

            const html = getBoxBeforePresetsFooter + resultsBtnPresetsFooter + getBoxAfterPresetsFooter;

            const parser = new DOMParser();
            const doc = parser.parseFromString(html, "text/html");

            const buttons = doc.querySelectorAll("button");
            for (let i = 0; i < buttons.length; i++) {
            buttons[i].classList.add(`btn${i+1}`);
            }

            const result = doc.body.innerHTML;

            $('ul#sub-accordion-panel-hfg_footer').append(result);

            // Trigger presets
            $('li#footer_presets_custom ').on('click', '.box-presets-footer button', function (event) {
                let getClass = $(this).attr('class');
                getClass = getClass.replace("btn", "");
                getClass = getClass - 1
                $('#customize-control-hfg_solace_footer_presets .solace-preset-selector button:eq(' + getClass + ')').trigger('click');
            });
        }, 700);

        // Click presets
        $('li#accordion-section-solace_tabs_footer .right').click(function(){
            // Elements deactive
            $('li#accordion-section-solace_tabs_footer .left').removeClass('active');
            $('li#accordion-section-hfg_footer_layout_section').removeClass('active');

            // Presets active
            $(this).attr('data-toggle', 'active');
            $(this).addClass('active');
            $('li#footer_presets_custom').removeClass('deactive');
            $('li#footer_presets_custom').addClass('active');
        });

        // Click elements
        $('li#accordion-section-solace_tabs_footer .left').click(function(){
            // Presets deactive
            $('li#accordion-section-solace_tabs_footer .right').removeClass('active');
            $('li#footer_presets_custom').addClass('deactive');

            // Element active
            $(this).attr('data-toggle', 'active');
            $(this).addClass('active');
            $('li#accordion-section-hfg_footer_layout_section').removeClass('deactive');
            $('li#accordion-section-hfg_footer_layout_section').addClass('active');
        });
    });

})(jQuery);