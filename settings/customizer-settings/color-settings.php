<?php

/***    add  panels   ***/
   
   Kirki::add_panel( 'colors_panel', array(
    'priority'    => 10,
    'title'       => esc_html__( 'Colors', 'kirki' ),
    'description' => esc_html__( '', 'kirki' ),
) );

   
   /***    add  Section to panels   ***/
   Kirki::add_section( 'main_colors', array(
        'title'          => esc_html__( 'Main Colors', 'kirki' ),
        'description'    => esc_html__( '', 'kirki' ),
        'panel'          => 'colors_panel',
        'priority'       => 1,
    ));
   
   Kirki::add_section( 'text_colors', array(
        'title'          => esc_html__( 'Text Colors', 'kirki' ),
        'description'    => esc_html__( '', 'kirki' ),
        'panel'          => 'colors_panel',
        'priority'       => 1,
    ));

      /***    add  fields to Section   ***/
      
            
        Kirki::add_field( 'theme_config_id', [
            'type'        => 'custom',
            'settings'    => 'color_section_msg',
            'label'       => esc_html__( '', 'kirki' ),
            'section'     => 'main_colors',
            'default'     => '<div style="padding: 30px;background-color: #333; color: #fff;">' . esc_html__( 'Set All the site colors here so  that it can be selected (No need to set  White Color)', 'kirki' ) . '</div>',
            'priority'    => 10,
        ] );
   
        Kirki::add_field( 'theme_config_id', [
            'type'        => 'color',
            'settings'    => 'color_one',
            'label'       => __( 'Color 01', 'kirki' ),
            'description' => esc_html__( '', 'kirki' ),
            'section'     => 'main_colors',
            'default'     => '#000000',
        ] );
           
        Kirki::add_field( 'theme_config_id', [
            'type'        => 'color',
            'settings'    => 'color_two',
            'label'       => __( 'Color 02', 'kirki' ),
            'description' => esc_html__( '', 'kirki' ),
            'section'     => 'main_colors',
            'default'     => '#1e73be',
        ] );
        
        
         Kirki::add_field( 'theme_config_id', [
            'type'        => 'color',
            'settings'    => 'color_three',
            'label'       => __( 'Color 03', 'kirki' ),
            'description' => esc_html__( '', 'kirki' ),
            'section'     => 'main_colors',
            'default'     => '#30475e',
        ] );
         
         Kirki::add_field( 'theme_config_id', [
            'type'        => 'color',
            'settings'    => 'color_four',
            'label'       => __( 'Color 04', 'kirki' ),
            'description' => esc_html__( '', 'kirki' ),
            'section'     => 'main_colors',
            'default'     => '#f2a365',
        ] );
         
          Kirki::add_field( 'theme_config_id', [
            'type'        => 'color',
            'settings'    => 'color_five',
            'label'       => __( 'Color 05', 'kirki' ),
            'description' => esc_html__( '', 'kirki' ),
            'section'     => 'main_colors',
            'default'     => '#639a67',
        ] );
           
      
    /*----------------------------------------------------------------------------------
    ================== Adding colors to an array to be used everhwere ==================
    --------------------------------------------------------------------------------------*/
    
        function ekwa_theme_colors(){
            
            $colorsArray = array(
                '#ffffff',
                    get_theme_mod('color_one', '#000000'),
                    get_theme_mod('color_two', '#1e73be'),
                    get_theme_mod('color_three', '#30475e'),
                    get_theme_mod('color_four', '#f2a365'),
                    get_theme_mod('color_five', '#639a67'),
                );
            
           return $colorsArray;
            
        }
    
    
    
    
    
      
        Kirki::add_field( 'theme_config_id', [
            'type'        => 'color-palette',
            'settings'    => 'color_text',
            'label'       => __( 'Text Color', 'kirki' ),
            'description' => esc_html__( '', 'kirki' ),
            'section'     => 'text_colors',
            'default'     => '',
            'choices'     => [
                'colors' => ekwa_theme_colors(),
                'size' => 25,
                'style' => 'round'
            ],
        ] );
            
        Kirki::add_field( 'theme_config_id', [
            'type'        => 'color-palette',
            'settings'    => 'color_link',
            'label'       => __( 'Link Color', 'kirki' ),
            'description' => esc_html__( '', 'kirki' ),
            'section'     => 'text_colors',
            'default'     => '#1b315e',
            'choices'     => [
                'colors' => ekwa_theme_colors(),
                'size' => 25,
                'style' => 'round'
            ],
        ] );
            
            
        Kirki::add_field( 'theme_config_id', [
            'type'        => 'color-palette',
            'settings'    => 'color_link_hover',
            'label'       => __( 'Link Hover Color', 'kirki' ),
            'description' => esc_html__( '', 'kirki' ),
            'section'     => 'text_colors',
            'default'     => '#1b315e',
            'choices'     => [
                'colors' => ekwa_theme_colors(),
                'size' => 25,
                'style' => 'round'
            ],
        ]);
           
           
        Kirki::add_field( 'theme_config_id', [
            'type'        => 'color-palette',
            'settings'    => 'color_invert',
            'label'       => __( 'Invert Color', 'kirki' ),
            'description' => esc_html__( 'Text color that on darker background', 'kirki' ),
            'section'     => 'text_colors',
            'default'     => '#ffffff',
            'choices'     => [
                'colors' => ekwa_theme_colors(),
                'size' => 25,
                'style' => 'round'
            ],
        ]);
         
         
        Kirki::add_field( 'theme_config_id', [
            'type'        => 'color-palette',
            'settings'    => 'color_headings',
            'label'       => __( 'Headings Color', 'kirki' ),
            'description' => esc_html__( '', 'kirki' ),
            'section'     => 'text_colors',
            'default'     => '#000000',
            'choices'     => [
                'colors' => ekwa_theme_colors(),
                'size' => 25,
                'style' => 'round'
            ],
        ]);