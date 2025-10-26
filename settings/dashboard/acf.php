<?php
if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array(
	'key' => 'group_5e8cba99d4a37',
	'title' => 'Resources fields',
	'fields' => array(
		array(
			'key' => 'field_5e8cbb906f926',
			'label' => 'Theme Resource id',
			'name' => 'theme_resource_id',
			'type' => 'number',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'min' => '',
			'max' => '',
			'step' => '',
		),
		array(
			'key' => 'field_5e8cbc542ed4a',
			'label' => 'Theme resource thumbnail url',
			'name' => 'theme_resource_thumbnail_url',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'ekwa_theme_resources',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
));

endif;