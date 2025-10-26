<?php


function slider_settings($prefix, $section, $callback = 'no'){
    
    
    Kirki::add_field( 'theme_config_id', [
	'type'        => 'number',
	'settings'    => $prefix.'_offset',
	'label'       => esc_html__( 'Lazyload Offset', 'kirki' ),
	'section'     => $section,
	'default'     => -10,
] );
      
    Kirki::add_field( 'theme_config_id', [
        'type'        => 'switch',
        'settings'    => $prefix.'_navigation',
        'label'       => esc_html__( 'Navigation Buttons', 'kirki' ),
        'description' => esc_html__( '', 'kirki' ),
        'section'     => $section,
        'default'     => false,
        'choices'     => [
            'on'  => esc_html__( 'Enable', 'kirki' ),
            'off' => esc_html__( 'Disable', 'kirki' ),
        ],
        'active_callback' => [
            [
                'setting'  => $callback,
                'operator' => '==',
                'value'    => true,
            ]
        ],

    ] );

       Kirki::add_field( 'theme_config_id', [
        'type'        => 'switch',
        'settings'    => $prefix.'_dots',
        'label'       => esc_html__( 'Dots', 'kirki' ),
        'description' => esc_html__( '', 'kirki' ),
        'section'     => $section,
        'default'     => false,
        'choices'     => [
            'on'  => esc_html__( 'Enable', 'kirki' ),
            'off' => esc_html__( 'Disable', 'kirki' ),
        ],
        'active_callback' => [
            [
                'setting'  => $callback,
                'operator' => '==',
                'value'    => true,
            ]
        ],
    ] );
    
    Kirki::add_field( 'theme_config_id', [
        'type'        => 'slider',
        'settings'    => $prefix.'_gutter',
        'label'       => esc_html__( 'Gutter', 'kirki' ),
        'section'     => $section,
        'default'     => 10,
        'choices'     => [
            'min'  => 0,
            'max'  => 100,
            'step' => 1,
        ],
        'active_callback' => [
            [
                'setting'  => $callback,
                'operator' => '==',
                'value'    => true,
            ]
        ],
    ] );
    
       
    Kirki::add_field( 'theme_config_id', [
        'type'        => 'select',
        'settings'    => $prefix.'_per_page',
        'label'       => esc_html__( 'Per Page (Desktop)', 'kirki' ),
        'section'     => $section,
        'default'     => '3',
        'placeholder' => esc_html__( 'Select an option...', 'kirki' ),
        'priority'    => 10,
        'multiple'    => 1,
        'choices'     => [
            '1' => esc_html__( '1', 'kirki' ),
            '2' => esc_html__( '2', 'kirki' ),
            '3' => esc_html__( '3', 'kirki' ),
            '4' => esc_html__( '4', 'kirki' ),
            '5' => esc_html__( '5', 'kirki' ),
            '6' => esc_html__( '6', 'kirki' ),
        ],
        'active_callback' => [
            [
                'setting'  => $callback,
                'operator' => '==',
                'value'    => true,
            ]
        ],
    ] );
    
    
    Kirki::add_field( 'theme_config_id', [
        'type'        => 'select',
        'settings'    => $prefix.'_per_page_tab',
        'label'       => esc_html__( 'Per Page (Tab)', 'kirki' ),
        'section'     => $section,
        'default'     => '2',
        'placeholder' => esc_html__( 'Select an option...', 'kirki' ),
        'priority'    => 10,
        'multiple'    => 1,
        'choices'     => [
            '1' => esc_html__( '1', 'kirki' ),
            '2' => esc_html__( '2', 'kirki' ),
            '3' => esc_html__( '3', 'kirki' ),
            '4' => esc_html__( '4', 'kirki' ),
            '5' => esc_html__( '5', 'kirki' ),
            '6' => esc_html__( '6', 'kirki' ),
        ],
        'active_callback' => [
            [
                'setting'  => $callback,
                'operator' => '==',
                'value'    => true,
            ]
        ],
    ] );
    
    
    
    Kirki::add_field( 'theme_config_id', [
        'type'        => 'select',
        'settings'    => $prefix.'_per_page_mobile',
        'label'       => esc_html__( 'Per Page (Mobile)', 'kirki' ),
        'section'     => $section,
        'default'     => '1',
        'placeholder' => esc_html__( 'Select an option...', 'kirki' ),
        'priority'    => 10,
        'multiple'    => 1,
        'choices'     => [
            '1' => esc_html__( '1', 'kirki' ),
            '2' => esc_html__( '2', 'kirki' ),
            '3' => esc_html__( '3', 'kirki' ),
            '4' => esc_html__( '4', 'kirki' ),
            '5' => esc_html__( '5', 'kirki' ),
            '6' => esc_html__( '6', 'kirki' ),
        ],
        'active_callback' => [
            [
                'setting'  => $callback,
                'operator' => '==',
                'value'    => true,
            ]
        ],
    ] );
       
}




function secion_container_open($setting,$slug){
    if(get_theme_mod($setting)){
        $class=$slug."-area-container";
    }else{
        $class='container';
    }
    return '<div class="' .$class. '">';
}


function section_container_close(){
    return '</div>';
}

function section_carousel_open($setting, $carouselID){
    if(get_theme_mod($setting)){
         $output =  '<div class="owl-carousel owl-theme" id="'.$carouselID.'">';
    }else{
        $output = "<div class='row'>";
    }
    return $output;
}

function section_carousel_close($setting){
    if(get_theme_mod($setting)){
        $output =  '</div>';
    }else{
        $output = '</div>';
    }
    return $output;
}

function section_carousel_variables($setting,$slug){
   if(get_theme_mod($setting)){
    
    $desktopPerPage = get_theme_mod($slug.'_per_page', 3);
    $tabPerPage = get_theme_mod($slug.'_per_page_tab', 2);
    $mobilePerPage = get_theme_mod($slug.'_per_page_mobile', 1);
    $gutter = get_theme_mod($slug.'_gutter', 15);
    
    if(get_theme_mod($slug.'_navigation', false)){
        $navigation = 'true';
    }else{
        $navigation = 'false';
    }
  
    if(get_theme_mod($slug.'_dots', false)){
        $dots = 'true';
    }else{
        $dots = 'false';
    }
    
     $output = '<script>';
     $output  .= '
        Enable'.$slug.'Carousel = true;
        var '.$slug.'PerPage = '.$desktopPerPage.';
        var '.$slug.'PerPageTab = '.$tabPerPage.';
        var '.$slug.'PerPageMobile = '.$mobilePerPage.';
        var '.$slug.'Gutter = '.$gutter.';
        var '.$slug.'Navigation = '.$navigation.';
        var '.$slug.'Dots =  '.$dots.';';
     
     $output .='</script>';
   }else{
    $output  = false;
   }
   return $output;
}

function get_item_classes($setting, $class_setting, $slug){
    
    if(get_theme_mod($setting, false)){
        $itemClasses = $slug.'-item';
     }else{
       $itemClasses = get_theme_mod($class_setting, 'col-md-6');
    }
    return $itemClasses;
}


function carousel_image($setting){
    if($setting){
        if ( ! wp_attachment_is_image( $setting ) ){
            $carousel_img = $setting['url'];
        } else {
            $carousel_img = wp_get_attachment_url($setting);
        }
    }
    
    return $carousel_img;
}

function carousel_alt($setting){
   return   get_post_meta($setting, '_wp_attachment_image_alt', TRUE);
}


function theme_mod_echo($setting, $default){
    if(get_theme_mod($setting, $default)){
        echo get_theme_mod($setting, $default);
    }else{
        echo $default;   
    }
}


function pages_to_show($pages){
    if($pages == 'only-home'){
        if(is_front_page()){
            return true;
        }
    }
    if($pages == 'all-pages'){
        return true;
    }
    if($pages == 'exclude-some'){
        $excluded_page = get_theme_mod('excluded_pages', '');
        if(!is_page($excluded_page)){
            return true;
        }
    }
}
