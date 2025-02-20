(function ($) {

    // Append Presets Header
    window.addEventListener('load', function () {
        // Append presets
        setTimeout(function(){

            const getBoxBeforePresetsHeader = '<li id="header_presets_custom"><div class="box-presets-header">';
            const getBtnPresetsHeader = $('li#customize-control-hfg_solace_header_presets .solace-preset-selector').html();
            const resultsBtnPresetsHeader = getBtnPresetsHeader.replace(/(<button[^>]*)(>)/g, '$1 type="button">');
            const getBoxAfterPresetsHeader = '</div></li>';

            const html = getBoxBeforePresetsHeader + resultsBtnPresetsHeader + getBoxAfterPresetsHeader;

            const parser = new DOMParser();
            const doc = parser.parseFromString(html, "text/html");

            const buttons = doc.querySelectorAll("button");
            for (let i = 0; i < buttons.length; i++) {
            buttons[i].classList.add(`btn${i+1}`);
            }

            const result = doc.body.innerHTML;

            $('ul#sub-accordion-panel-hfg_header').append(result);

            // Trigger presets
            $('li#header_presets_custom ').on('click', '.box-presets-header button', function (event) {
                let getClass = $(this).attr('class');
                getClass = getClass.replace("btn", "");
                getClass = getClass - 1
                $('#customize-control-hfg_solace_header_presets .solace-preset-selector button:eq(' + getClass + ')').trigger('click');
            });
        }, 700);

        // Click presets
        $('li#accordion-section-solace_tabs_header .right').click(function(){
            // Elements deactive
            $('li#accordion-section-solace_tabs_header .left').removeClass('active');
            $('li#accordion-section-hfg_header_layout_section').removeClass('active');

            // Presets active
            $(this).attr('data-toggle', 'active');
            $(this).addClass('active');
            $('li#header_presets_custom').removeClass('deactive');
            $('li#header_presets_custom').addClass('active');
        });

        // Click elements
        $('li#accordion-section-solace_tabs_header .left').click(function(){
            // Presets deactive
            $('li#accordion-section-solace_tabs_header .right').removeClass('active');
            $('li#header_presets_custom').addClass('deactive');

            // Element active
            $(this).attr('data-toggle', 'active');
            $(this).addClass('active');
            $('li#accordion-section-hfg_header_layout_section').removeClass('deactive');
            $('li#accordion-section-hfg_header_layout_section').addClass('active');
        });
    });

})(jQuery);