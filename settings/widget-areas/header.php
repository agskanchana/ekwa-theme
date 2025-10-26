<?php

function ekwa_header_widgets_init() {
     register_sidebar( array(
        'name'          => 'Header top widget area',
        'id'            => 'ekwa-header-top-widget',
        'before_widget' => '<div class="header-widget-top">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="chw-title">',
        'after_title'   => '</h2>',
    ) );
 
    register_sidebar( array(
        'name'          => 'Header widget area',
        'id'            => 'ekwa-header-widget',
        'before_widget' => '<div class="header-widget">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="chw-title">',
        'after_title'   => '</h2>',
    ) );
    
    register_sidebar( array(
        'name'          => 'Header Bottom widget area',
        'id'            => 'ekwa-header-bottom-widget',
        'before_widget' => '<div class="header-widget-bottom">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="chw-title">',
        'after_title'   => '</h2>',
    ) );
    
    
 
}
add_action( 'widgets_init', 'ekwa_header_widgets_init' );