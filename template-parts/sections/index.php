<?php
if (class_exists( 'Kirki' ) ) {
	// Get the parts.
	$template_parts = get_theme_mod( 'section_order', array( 'main-content') );
	
	// Loop parts.
	foreach ( $template_parts as $template_part ) {
		get_template_part( 'template-parts/sections/' . $template_part );
	}
}