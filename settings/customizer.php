<?php

//require_once('kirki/kirki.php');



if (class_exists( 'Kirki' ) ) {


   Kirki::add_config( 'theme_config_id', array(
	'capability'    => 'edit_theme_options',
	'option_type'   => 'theme_mod',
) );


require get_template_directory() . '/settings/kirki-common.php';


require get_template_directory() . '/settings/customizer-settings/color-settings.php';
require get_template_directory() . '/settings/customizer-settings/headers-footers.php';
require get_template_directory() . '/settings/customizer-settings/site-settings.php';
require get_template_directory() . '/settings/customizer-settings/typography.php';

}