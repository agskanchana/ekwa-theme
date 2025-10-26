<?php
/***    add  Section to panels   ***/

$section = 'before-after-section';
$prefix = 'before_after';


   Kirki::add_section( 'before-after-section', array(
    'title'          => esc_html__( 'Before After', 'kirki' ),
    'description'    => esc_html__( '', 'kirki' ),
    'panel'          => 'sections',
    'priority'       => 1,
) );



    Kirki::add_field( 'theme_config_id', [
    'type'        => 'multicolor',
    'settings'    => 'my__test_setting',
    'label'       => esc_html__( 'Label', 'kirki' ),
    'section'     => 'before-after-section',
    'priority'    => 10,
    'choices'     => [
        'link'    => esc_html__( 'Color', 'kirki' ),
        'hover'   => esc_html__( 'Hover', 'kirki' ),
        'active'  => esc_html__( 'Active', 'kirki' ),
    ],
    'default'     => [
        'link'    => '',
        'hover'   => '',
        'active'  => '',
    ],
] );





    Kirki::add_field( 'theme_config_id', [
        'type'        => 'select',
        'settings'    => 'before-after-styles',
        'label'       => esc_html__( 'Select Style', 'kirki' ),
        'section'     => 'before-after-section',
        'default'     => 'style-1',
        'placeholder' => esc_html__( 'Select an option...', 'kirki' ),
        'priority'    => 10,
        'multiple'    => 1,
        'choices'     => [
            'style-1' => esc_html__( 'Style 1', 'kirki' ),
            'style-2' => esc_html__( 'Style 2', 'kirki' ),
            'style-3' => esc_html__( 'Style 3', 'kirki' ),
        ],
    ] );
    
    return slider_settings($prefix, $section);

    
    /********   custom fields ***********/
    

