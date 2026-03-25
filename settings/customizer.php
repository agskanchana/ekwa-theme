<?php

//require_once('kirki/kirki.php');



if (class_exists( 'Kirki' ) ) {


   Kirki::add_config( 'theme_config_id', array(
	'capability'    => 'edit_theme_options',
	'option_type'   => 'theme_mod',
) );

// Helper used by color-palette pickers in headers-footers.php
if ( ! function_exists( 'ekwa_theme_colors' ) ) {
	function ekwa_theme_colors() {
		return array(
			'#ffffff',
			get_theme_mod( 'color_one',   '#000000' ),
			get_theme_mod( 'color_two',   '#1e73be' ),
			get_theme_mod( 'color_three', '#30475e' ),
			get_theme_mod( 'color_four',  '#f2a365' ),
			get_theme_mod( 'color_five',  '#639a67' ),
		);
	}
}

require get_template_directory() . '/settings/kirki-common.php';


require get_template_directory() . '/settings/customizer-settings/headers-footers.php';
require get_template_directory() . '/settings/customizer-settings/site-settings.php';

}