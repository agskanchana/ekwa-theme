<?php
/***    add  panels   ***/
   
   Kirki::add_panel( 'typography', array(
    'priority'    => 20,
    'title'       => esc_html__( 'Typography', 'kirki' ),
    'description' => esc_html__( '', 'kirki' ),
) );
   
   
   
  Kirki::add_section( 'body', array(
    'title'          => esc_html__( 'Body', 'kirki' ),
    'description'    => esc_html__( '', 'kirki' ),
    'panel'          => 'typography',
    'priority'       => 1,
) );
  
    Kirki::add_section( 'typo_mobile', array(
    'title'          => esc_html__( 'Mobile', 'kirki' ),
    'description'    => esc_html__( '', 'kirki' ),
    'panel'          => 'typography',
    'priority'       => 1,
) );
  
    Kirki::add_section( 'typo_headings_h1', array(
    'title'          => esc_html__( 'Headings H1', 'kirki' ),
    'description'    => esc_html__( '', 'kirki' ),
    'panel'          => 'typography',
    'priority'       => 1,
) );  
  
      Kirki::add_section( 'typo_headings_h2', array(
    'title'          => esc_html__( 'Headings H2', 'kirki' ),
    'description'    => esc_html__( '', 'kirki' ),
    'panel'          => 'typography',
    'priority'       => 1,
) );
      
      
      Kirki::add_section( 'typo_headings_h3', array(
    'title'          => esc_html__( 'Headings H3', 'kirki' ),
    'description'    => esc_html__( '', 'kirki' ),
    'panel'          => 'typography',
    'priority'       => 1,
) );
      
       Kirki::add_section( 'additional_font_1', array(
    'title'          => esc_html__( 'Additional Font 1', 'kirki' ),
    'description'    => esc_html__( '', 'kirki' ),
    'panel'          => 'typography',
    'priority'       => 1,
) );
       
       Kirki::add_section( 'additional_font_2', array(
    'title'          => esc_html__( 'Additional Font 2', 'kirki' ),
    'description'    => esc_html__( '', 'kirki' ),
    'panel'          => 'typography',
    'priority'       => 1,
) );  
  
  
   Kirki::add_field( 'theme_config_id', [
	'type'        => 'typography',
	'settings'    => 'font_body',
	'label'       => esc_html__( 'Body Font Family', 'kirki' ),
	'section'     => 'body',
    'choices' => [
        'fonts' => [
            'google' => [ 'popularity' ],
            'standard' => [
			'Georgia,Times,"Times New Roman",serif',
			'Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif',
            'Arial'
		],
        ],
    ],

	'default'     => [
		'font-family'    => 'Roboto',
		'font-wieght'    => 'regular',
        'font-style'     => 'normal',
	],
	'priority'    => 10,
] );
   
   

  Kirki::add_field( 'theme_config_id', [
	'type'        => 'typography',
	'settings'    => 'font_mobile',
	'label'       => esc_html__( 'Mobile Font Family', 'kirki' ),
	'section'     => 'typo_mobile',
    'choices' => [
        'fonts' => [
            'google' => [ 'popularity' ],
            'standard' => [
			'Georgia,Times,"Times New Roman",serif',
			'Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif',
            'Arial'
		],
        ],
    ],

	'default'     => [
		'font-family'    => 'Helvetica Neue',
		'font-wieght'    => 'regular',
        'font-style'     => 'normal',
	],
	'priority'    => 10,
] );
   

  Kirki::add_field( 'theme_config_id', [
	'type'        => 'typography',
	'settings'    => 'typo_h1_fonts',
	'label'       => esc_html__( 'H1', 'kirki' ),
	'section'     => 'typo_headings_h1',
    'choices' => [
        'fonts' => [
            'google' => [ 'popularity' ],
            'standard' => [
			'Georgia,Times,"Times New Roman",serif',
			'Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif',
            'Arial'
		],
        ],
    ],
	'default'     => [
		'font-family'    => 'Helvetica Neue',
		'font-wieght'    => 'regular',
        'font-style'     => 'normal',
	],
	'priority'    => 10,
] );
   
   
  Kirki::add_field( 'theme_config_id', [
	'type'        => 'color',
	'settings'    => 'headings_h1_color',
	'label'       => __( 'Color Control (hex-only)', 'kirki' ),
	'section'     => 'typo_headings_h1',
	'default'     => '#000000',
    'css_vars'        => array(
            array( '--heading_h1_color', '$', 'font-color' ),
            
        ),
		'transport'       => 'postMessage',
] );
 
   
Kirki::add_field( 'theme_config_id', [
		'type'        => 'slider',
		'settings'    => 'font_size_h1',
		'label'       => esc_html__( 'Heading H1 Font-Size'),
		'section'     => 'typo_headings_h1',
		'default'     => 36,
		'priority'    => 60,
		'choices'     => [
			'min'    => 18,
			'max'    => 80,
			'step'   => 1,
		],
	] );

    
    
  
Kirki::add_field( 'theme_config_id', [
		'type'        => 'slider',
		'settings'    => 'body_font_size',
		'label'       => esc_html__( 'Body Font-Size'),
		'section'     => 'body',
		'default'     => 14,
		'priority'    => 60,
		'choices'     => [
			'min'    => 12,
			'max'    => 30,
			'step'   => 1,
		],
	] );
  
     Kirki::add_field( 'theme_config_id', [
	'type'        => 'color',
	'settings'    => 'body_color',
	'label'       => __( 'Color Control (hex-only)', 'kirki' ),
	'section'     => 'body',
	'default'     => '#000000',
    'css_vars'        => array(
            array( '--body-color', '$', 'color' ),
            
        ),
		'transport'       => 'postMessage',
] );
 
   
   
/* h2*/




  Kirki::add_field( 'theme_config_id', [
	'type'        => 'typography',
	'settings'    => 'typo_h2_fonts',
	'label'       => esc_html__( 'H2', 'kirki' ),
	'section'     => 'typo_headings_h2',
    'choices' => [
        'fonts' => [
            'google' => [ 'popularity' ],
            'standard' => [
			'Georgia,Times,"Times New Roman",serif',
			'Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif',
            'Arial'
		],
        ],
    ],

	'default'     => [
		'font-family'    => 'Helvetica Neue',
		'font-wieght'    => 'regular',
        'font-style'     => 'normal',
	],
	'priority'    => 10,
] );
   
   
  Kirki::add_field( 'theme_config_id', [
	'type'        => 'color',
	'settings'    => 'headings_h2_color',
	'label'       => __( 'Color Control (hex-only)', 'kirki' ),
	'section'     => 'typo_headings_h2',
	'default'     => '#000000',
    'css_vars'        => array(
            array( '--heading_h2_color', '$', 'font-color' ),
            
        ),
		'transport'       => 'postMessage',
] );
 
   
Kirki::add_field( 'theme_config_id', [
		'type'        => 'slider',
		'settings'    => 'font_size_h2',
		'label'       => esc_html__( 'Heading H2 Font-Size'),
		'section'     => 'typo_headings_h2',
		'default'     => 24,
		'priority'    => 60,
		'choices'     => [
			'min'    => 18,
			'max'    => 80,
			'step'   => 1,
		],
	] );
   
   
   
      
/* h2*/



   
  Kirki::add_field( 'theme_config_id', [
	'type'        => 'color',
	'settings'    => 'headings_h2_color',
	'label'       => __( 'Color Control (hex-only)', 'kirki' ),
	'section'     => 'typo_headings_h2',
	'default'     => '#000000',
    'css_vars'        => array(
            array( '--heading_h2_color', '$', 'font-color' ),
            
        ),
		'transport'       => 'postMessage',
] );
 
   
Kirki::add_field( 'theme_config_id', [
		'type'        => 'slider',
		'settings'    => 'font_size_h2',
		'label'       => esc_html__( 'Heading H2 Font-Size'),
		'section'     => 'typo_headings_h2',
		'default'     => 24,
		'priority'    => 60,
		'choices'     => [
			'min'    => 18,
			'max'    => 80,
			'step'   => 1,
		],
	] );
   
   
   

     
/* h3*/




  Kirki::add_field( 'theme_config_id', [
	'type'        => 'typography',
	'settings'    => 'typo_h3_fonts',
	'label'       => esc_html__( 'H3', 'kirki' ),
	'section'     => 'typo_headings_h3',
    'choices' => [
        'fonts' => [
            'google' => [ 'popularity' ],
            'standard' => [
			'Georgia,Times,"Times New Roman",serif',
			'Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif',
            'Arial'
		],
        ],
    ],

	'default'     => [
		'font-family'    => 'Arial',
		'variant'        => 'regular',
        'font-style'     => 'normal',
	],
	'priority'    => 10,

] );
   
   
  Kirki::add_field( 'theme_config_id', [
	'type'        => 'color',
	'settings'    => 'headings_h3_color',
	'label'       => __( 'Color Control (hex-only)', 'kirki' ),
	'section'     => 'typo_headings_h3',
	'default'     => '#000000',
    'css_vars'        => array(
            array( '--heading_h3_color', '$', 'font-color' ),
            
        ),
		'transport'       => 'postMessage',
] );
 
   
Kirki::add_field( 'theme_config_id', [
		'type'        => 'slider',
		'settings'    => 'font_size_h3',
		'label'       => esc_html__( 'Heading H3 Font-Size'),
		'section'     => 'typo_headings_h3',
		'default'     => 20,
		'priority'    => 60,
		'choices'     => [
			'min'    => 18,
			'max'    => 80,
			'step'   => 1,
		],
	] );
   
   
   /*********** Additional font **************/
   
   
   
  Kirki::add_field( 'theme_config_id', [
	'type'        => 'typography',
	'settings'    => 'addtional_font_1',
	'label'       => esc_html__( 'Additional Font 01', 'kirki' ),
    'description' => 'Use following CSS Variable  <br><br> <code> --font-1  </code> for font family <br> <code> --font-w-1 </code> for font weight <br> <code> --font-s-1 </code> for font style',
	'section'     => 'additional_font_1',
    
    'choices' => [
        'fonts' => [
            'google' => [ 'popularity' ],
            'standard' => [
			'Georgia,Times,"Times New Roman",serif',
			'Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif',
            'Arial'
		],
        ],
    ],

	'default'     => [
		'font-family'    => 'Arial',
		'variant'        => 'regular',
        'font-style'    => 'normal'
	],
	'priority'    => 10,
] );
   

   
   
     
   /*********** Additional font 02 **************/
   
   
   
  Kirki::add_field( 'theme_config_id', [
	'type'        => 'typography',
	'settings'    => 'addtional_font_2',
	'label'       => esc_html__( 'Additional Font 02', 'kirki' ),
    'description' => 'Use following CSS Variable  <br><br> <code> --font-2  </code> for font family <br> <code> --font-w-2 </code> for font weight <br> <code> --font-s-2 </code> for font style',
	'section'     => 'additional_font_2',
    
    'choices' => [
        'fonts' => [
            'google' => [ 'popularity' ],
            'standard' => [
			'Georgia,Times,"Times New Roman",serif',
			'Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif',
            'Arial'
		],
        ],
    ],

	'default'     => [
		'font-family'    => 'Arial',
		'variant'        => 'regular',
        'font-style'    => 'normal'
	],
	'priority'    => 10,
] );
   
