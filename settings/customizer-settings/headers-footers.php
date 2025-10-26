<?php
/***    add  panels   ***/
   
   Kirki::add_panel( 'headers_footers', array(
    'priority'    => 20,
    'title'       => esc_html__( 'Headers & Footers', 'kirki' ),
    'description' => esc_html__( '', 'kirki' ),
) );

   
   /***    add  Section to panels   ***/
   Kirki::add_section( 'headers', array(
    'title'          => esc_html__( 'Headers', 'kirki' ),
    'description'    => esc_html__( '', 'kirki' ),
    'panel'          => 'headers_footers',
    'priority'       => 1,
) );
   
/***    add  Section to panels   ***/
   Kirki::add_section( 'mobile-header', array(
    'title'          => esc_html__( 'Mobile Header', 'kirki' ),
    'description'    => esc_html__( '', 'kirki' ),
    'panel'          => 'headers_footers',
    'priority'       => 12,
) );
   
   
   /***    add  Section to panels   ***/
   Kirki::add_section( 'footers', array(
    'title'          => esc_html__( 'Footers', 'kirki' ),
    'description'    => esc_html__( '', 'kirki' ),
    'panel'          => 'headers_footers',
    'priority'       => 12,
) );
   
   
   
   /***    add  Section to panels   ***/
   Kirki::add_section( 'mobile-icons', array(
    'title'          => esc_html__( 'Mobile icons set', 'kirki' ),
    'description'    => esc_html__( '', 'kirki' ),
    'panel'          => 'headers_footers',
    'priority'       => 12,
) );
   


   
   
   /*********** fields ************/
   


   
   Kirki::add_field( 'theme_config_id', [
	'type'        => 'select',
	'settings'    => 'select_header',
	'label'       => esc_html__( 'Select an Header', 'kirki' ),
	'section'     => 'headers',
	'default'     => 'custom',
	'placeholder' => esc_html__( 'Select an Header', 'kirki' ),
	'priority'    => 10,
	'multiple'    => 1,
	'choices'     => Kirki_Helper::get_posts(
                    array(
                        'numberposts' => -1,
                        'post_type'   => 'ekwa_theme_headers',
                      ) 
    
    ),
] );






  /******** footer builder **********/
  
  Kirki::add_field( 'theme_config_id', [
	'type'        => 'switch',
	'settings'    => 'enable_header_builder',
	'label'       => esc_html__( 'Enable Header builder', 'kirki' ),
	'section'     => 'header-builder',
    'description' => esc_html__( 'Enabling header builder will disable custom  and downloaded headers', 'kirki' ),
	'default'     => '0',
	'priority'    => 10,
	'choices'     => [
		'on'  => esc_html__( 'Enable', 'kirki' ),
		'off' => esc_html__( 'Disable', 'kirki' ),
	],
] );


/* ############## FOOTER FIELD ###################*/

/*

   Kirki::add_field( 'theme_config_id', [
	'type'        => 'select',
	'settings'    => 'select_footer',
	'label'       => esc_html__( 'Select Footer', 'kirki' ),
	'section'     => 'footers',
	'default'     => 'custom',
	'placeholder' => esc_html__( 'Select an Footer', 'kirki' ),
	'priority'    => 10,
	'multiple'    => 1,
	'choices'     => [
		'custom' => esc_html__( 'Custom', 'kirki' ),
		'footer-1' => esc_html__( 'Footer 1', 'kirki' ),
	],
] );
   */


   
   Kirki::add_field( 'theme_config_id', [
	'type'        => 'select',
	'settings'    => 'select_footer',
	'label'       => esc_html__( 'Select Footer', 'kirki' ),
	'section'     => 'footers',
	'default'     => 'custom',
	'placeholder' => esc_html__( 'Select an Footer', 'kirki' ),
	'priority'    => 10,
	'multiple'    => 1,
	'choices'     => Kirki_Helper::get_posts(
                    array(
                        'numberposts' => -1,
                        'post_type'   => 'ekwa_theme_footers',
                      ) 
    
    ),
] );


  // mobile header fields  

     Kirki::add_field( 'theme_config_id', [
	'type'        => 'select',
	'settings'    => 'select_mobile_logo',
	'label'       => esc_html__( 'Mobile logo method', 'kirki' ),
	'section'     => 'mobile-header',
	'default'     => 'same-as-desktop',
	'placeholder' => esc_html__( 'Select an option...', 'kirki' ),
	'priority'    => 10,
	'multiple'    => 1,
	'choices'     => [
		'same-as-desktop' => esc_html__( 'Same as Desktop', 'kirki' ),
		'svg' => esc_html__( 'Svg logo', 'kirki' ),
		'base64' => esc_html__( 'Base 64 Image', 'kirki' ),
		'webp' => esc_html__( 'Webp Image', 'kirki' ),
	],
] );
     
     
Kirki::add_field( 'theme_config_id', [
	'type'        => 'code',
	'settings'    => 'mobile_logo_svg',
	'label'       => esc_html__( 'Svg code', 'kirki' ),
	'section'     => 'mobile-header',
	'default'     => '',
	'choices'     => [
		'language' => 'html',
	],
    'active_callback' => [
	[
		'setting'  => 'select_mobile_logo',
		'operator' => '==',
		'value'    => 'svg',
	]
],
] );
Kirki::add_field( 'theme_config_id', [
	'type'        => 'code',
	'settings'    => 'mobile_logo_base64',
	'label'       => esc_html__( 'Base 64 code', 'kirki' ),
	'section'     => 'mobile-header',
	'default'     => '',
	'choices'     => [
		'language' => 'html',
	],
    'active_callback' => [
        [
            'setting'  => 'select_mobile_logo',
            'operator' => '==',
            'value'    => 'base64',
        ]
    ],
    
] );

  Kirki::add_field( 'theme_config_id', [
	'type'        => 'image',
	'settings'    => 'mobile_logo_webp',
	'label'       => esc_html__( 'Webp image', 'kirki' ),
	'description' => esc_html__( 'desktop logo will be used as fallback image', 'kirki' ),
	'section'     => 'mobile-header',
	'default'     => '',
    'active_callback' => [
        [
            'setting'  => 'select_mobile_logo',
            'operator' => '==',
            'value'    => 'webp',
        ]
    ],
] );

  
  
  
  
  Kirki::add_field( 'theme_config_id', [
	'type'        => 'color-palette',
	'settings'    => 'mobile-header-bg',
	'label'       => __( 'Header background', 'kirki' ),
	'description' => esc_html__( '', 'kirki' ),
	'section'     => 'mobile-header',
	'default'     => '',
    'choices'     => [
		'colors' => ekwa_theme_colors(),
        'size' => 25,
        'style' => 'round'
	],


] );
  Kirki::add_field( 'theme_config_id', [
	'type'        => 'color-palette',
	'settings'    => 'mobile-icon-bg',
	'label'       => __( 'Icon background', 'kirki' ),
	'description' => esc_html__( '', 'kirki' ),
	'section'     => 'mobile-header',
	'default'     => '',
    'choices'     => [
		'colors' => ekwa_theme_colors(),
        'size' => 25,
        'style' => 'round'
	],


] );
  Kirki::add_field( 'theme_config_id', [
	'type'        => 'color-palette',
	'settings'    => 'mobile-icon-color',
	'label'       => __( 'Icon color', 'kirki' ),
	'description' => esc_html__( '', 'kirki' ),
	'section'     => 'mobile-header',
	'default'     => '',
    'choices'     => [
		'colors' => ekwa_theme_colors(),
        'size' => 25,
        'style' => 'round'
	],


] );
  Kirki::add_field( 'theme_config_id', [
	'type'        => 'color-palette',
	'settings'    => 'slide-menu-bg',
	'label'       => __( 'Sliding menu background', 'kirki' ),
	'description' => esc_html__( '', 'kirki' ),
	'section'     => 'mobile-header',
	'default'     => '',
    'choices'     => [
		'colors' => ekwa_theme_colors(),
        'size' => 25,
        'style' => 'round'
	],


] );
  Kirki::add_field( 'theme_config_id', [
	'type'        => 'color-palette',
	'settings'    => 'slide-menu-text',
	'label'       => __( 'Sliding menu Text color', 'kirki' ),
	'description' => esc_html__( '', 'kirki' ),
	'section'     => 'mobile-header',
	'default'     => '',
    'choices'     => [
		'colors' => ekwa_theme_colors(),
        'size' => 25,
        'style' => 'round'
	],


] );
     Kirki::add_field( 'theme_config_id', [
	'type'        => 'color-palette',
	'settings'    => 'slide-menu-icon',
	'label'       => __( 'Sliding menu Icon color', 'kirki' ),
	'description' => esc_html__( '', 'kirki' ),
	'section'     => 'mobile-header',
	'default'     => '',
    'choices'     => [
		'colors' => ekwa_theme_colors(),
        'size' => 25,
        'style' => 'round'
	],


] );
     

    
   
   /******** Mobile icons set *******/
   
     Kirki::add_field( 'theme_config_id', [
	'type'        => 'color-palette',
	'settings'    => 'mobile-icons-bg',
	'label'       => __( 'Mobile icons background', 'kirki' ),
	'description' => esc_html__( '', 'kirki' ),
	'section'     => 'mobile-icons',
	'default'     => '',
    'choices'     => [
		'colors' => ekwa_theme_colors(),
        'size' => 25,
        'style' => 'round'
	],


] );
     Kirki::add_field( 'theme_config_id', [
	'type'        => 'color-palette',
	'settings'    => 'mobile-icons-bg-hover',
	'label'       => __( 'Mobile icons background Hover', 'kirki' ),
	'description' => esc_html__( '', 'kirki' ),
	'section'     => 'mobile-icons',
	'default'     => '',
    'choices'     => [
		'colors' => ekwa_theme_colors(),
        'size' => 25,
        'style' => 'round'
	],


] );
     
     
     
     Kirki::add_field( 'theme_config_id', [
	'type'        => 'color-palette',
	'settings'    => 'mobile-icons-color',
	'label'       => __( 'Mobile icons color', 'kirki' ),
	'description' => esc_html__( '', 'kirki' ),
	'section'     => 'mobile-icons',
	'default'     => '',
    'choices'     => [
		'colors' => ekwa_theme_colors(),
        'size' => 25,
        'style' => 'round'
	],


] );
     
     
     
  /******** footer builder **********/
  
  Kirki::add_field( 'theme_config_id', [
	'type'        => 'switch',
	'settings'    => 'enable_footer_builder',
	'label'       => esc_html__( 'Enable footer builder', 'kirki' ),
	'section'     => 'footer-builder',
    'description' => esc_html__( 'Enabling footer builder will', 'kirki' ),
	'default'     => '0',
	'priority'    => 10,
	'choices'     => [
		'on'  => esc_html__( 'Enable', 'kirki' ),
		'off' => esc_html__( 'Disable', 'kirki' ),
	],
] );
     
     
     
     
     