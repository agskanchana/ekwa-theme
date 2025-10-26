<?php

function ekwa_footer_widgets_init() {
     register_sidebar( array(
        'name'          => 'Footer top widget area',
        'id'            => 'ekwa-footer-top-widget',
        'before_widget' => '<div class="footer-widget-top">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="chw-title">',
        'after_title'   => '</h2>',
    ) );
 
    register_sidebar( array(
        'name'          => 'Footer widget area',
        'id'            => 'ekwa-footer-widget',
        'before_widget' => '<div class="footer-widget">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="chw-title">',
        'after_title'   => '</h2>',
    ) );
    
    register_sidebar( array(
        'name'          => 'Footer Bottom widget area',
        'id'            => 'ekwa-footer-bottom-widget',
        'before_widget' => '<div class="footer-widget-bottom">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="chw-title">',
        'after_title'   => '</h2>',
    ) );
    
    
 
}
add_action( 'widgets_init', 'ekwa_footer_widgets_init' );