<?php

// Customize Example
function solace_blog_layout_custom_btn($wp_customize)
{
    // Setting
    $wp_customize->add_setting(
        'solace_blog_layout_custom_columns',
        array(
            'default'           => '4',
            'transport'         => 'refresh',
            'sanitize_callback' => 'absint'
        )
    );

    // Control
    $wp_customize->add_control(new Solace_Custom_Button_Plus_Minus(
        $wp_customize,
        'solace_blog_layout_custom_columns',
        array(
            'section' => 'solace_blog_archive_layout',
            'label'   => __('Columns', 'solace'),
            'priority' => 11,
            'min'     => 1,
            'max'     => 5,
        )
    ));

    // Partial
    $wp_customize->selective_refresh->add_partial(
        'solace_blog_layout_custom_columns',
        array(
            'selector'            => 'body.theme-solace',
            'container_inclusive' => true,
            'render_callback'     => 'solace_callback_blog_layout_custom',
        )
    );

    // Setting
    $wp_customize->add_setting(
        'solace_blog_layout_custom_posts',
        array(
            'default'           => '10',
            'transport'         => 'refresh',
            'sanitize_callback' => 'absint'
        )
    );

    // Control
    $wp_customize->add_control(new Solace_Custom_Button_Plus_Minus(
        $wp_customize,
        'solace_blog_layout_custom_posts',
        array(
            'section' => 'solace_blog_archive_layout',
            'label'   => __('Posts', 'solace'),
            'priority' => 11,
            'min'     => 1,
            'max'     => 20,
        )
    ));

    // Partial
    $wp_customize->selective_refresh->add_partial(
        'solace_blog_layout_custom_posts',
        array(
            'selector'            => 'body.theme-solace',
            'container_inclusive' => true,
            'render_callback'     => 'solace_callback_blog_layout_custom',
        )
    );
}
add_action('customize_register', 'solace_blog_layout_custom_btn');

function solace_customizer_custom_class_btn()
{
    wp_enqueue_style('solace-customizer-custom-class-btn-style', get_theme_file_uri('/inc/customizer/page-settings/style.css'), array(), '1.0.0', 'all');

    wp_enqueue_script('solace-customizer-custom-class-btn-script', get_theme_file_uri('/inc/customizer/page-settings/scripts.js'), array('jquery'), '1.0.0', true);
}
add_action('customize_controls_enqueue_scripts', 'solace_customizer_custom_class_btn', 99);
