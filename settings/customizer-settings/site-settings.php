<?php

/***    add  panels   ***/
   
   Kirki::add_panel( 'site_settings', array(
    'priority'    => 20,
    'title'       => esc_html__( 'Site Settings', 'kirki' ),
    'description' => esc_html__( '', 'kirki' ),
) );
   
   
   /***** add section ******/
   
     Kirki::add_section( 'general_settings', array(
    'title'          => esc_html__( 'General', 'kirki' ),
    'description'    => esc_html__( '', 'kirki' ),
    'panel'          => 'site_settings',
    'priority'       => 1,
) );
     
     
   
     Kirki::add_section( 'social_media', array(
    'title'          => esc_html__( 'Social Media', 'kirki' ),
    'description'    => esc_html__( '', 'kirki' ),
    'panel'          => 'site_settings',
    'priority'       => 1,
) );
     

     
 Kirki::add_section( 'location', array(
    'title'          => esc_html__( 'Location', 'kirki' ),
    'description'    => esc_html__( '', 'kirki' ),
    'panel'          => 'site_settings',
    'priority'       => 1,
) );
     
     
 Kirki::add_section( 'working_hours', array(
    'title'          => esc_html__( 'Working Hours', 'kirki' ),
    'description'    => esc_html__( '', 'kirki' ),
    'panel'          => 'site_settings',
    'priority'       => 1,
) );
 
Kirki::add_section( 'popup_settings', array(
    'title'          => esc_html__( 'Popup Settings', 'kirki' ),
    'description'    => esc_html__( '', 'kirki' ),
    'panel'          => 'site_settings',
    'priority'       => 1,
) );
 
  Kirki::add_section( 'inner_pages', array(
    'title'          => esc_html__( 'Inner pages Settings', 'kirki' ),
    'description'    => esc_html__( '', 'kirki' ),
    'panel'          => 'site_settings',
    'priority'       => 1,
) );
     
 /*############################ GENERAL SECTION FIELDS ###########################*/    
     
     
Kirki::add_field( 'theme_config_id', [
	'type'     => 'text',
	'settings' => 'client_name',
	'label'    => esc_html__( 'Client Name', 'kirki' ),
	'section'  => 'general_settings',
	'default'  => esc_html__( '', 'kirki' ),
	'priority' => 10,
] );


Kirki::add_field( 'theme_config_id', [
	'type'     => 'text',
	'settings' => 'practise_name',
	'label'    => esc_html__( 'Practise Name', 'kirki' ),
	'section'  => 'general_settings',
	'default'  => esc_html__( '', 'kirki' ),
	'priority' => 10,
] );


Kirki::add_field( 'theme_config_id', [
	'type'        => 'select',
	'settings'    => 'organization_type',
	'label'       => esc_html__( 'Organization Type', 'kirki' ),
	'section'     => 'general_settings',
	'default'     => '',
	'placeholder' => esc_html__( 'Select an option...', 'kirki' ),
	'priority'    => 10,
	'multiple'    => 1,
	'choices'     => [
		'AccountingService' => esc_html__( 'AccountingService', 'kirki' ),
        'MedicalClinic' => esc_html__( 'MedicalClinic', 'kirki' ),
        'Physician' => esc_html__( 'Physician', 'kirki' ),
        'VeterinaryCare' => esc_html__( 'VeterinaryCare', 'kirki' ),
        'Store' => esc_html__( 'Store', 'kirki' ),
        'Attorney' => esc_html__( 'Attorney', 'kirki' ),
        'HealthAndBeautyBusiness' => esc_html__( 'HealthAndBeautyBusiness', 'kirki' ),
        'BeautySalon' => esc_html__( 'BeautySalon', 'kirki' ),
        'Dentist' => esc_html__( 'Dentist', 'kirki' ),
        'DaySpa' => esc_html__( 'DaySpa', 'kirki' ),
        'Hospital' => esc_html__( 'Hospital', 'kirki' ),
        'PetStore' => esc_html__( 'PetStore', 'kirki' ),
        'SelfStorage' => esc_html__( 'SelfStorage', 'kirki' ),
        'EmergencyService' => esc_html__( 'EmergencyService', 'kirki' ),
        'ProfessionalService' => esc_html__( 'ProfessionalService', 'kirki' ),
        'Winery' => esc_html__( 'Winery', 'kirki' ),
	],
] );


Kirki::add_field( 'theme_config_id', [
	'type'     => 'text',
	'settings' => 'call_tracking_number',
	'label'    => esc_html__( ' Call Tracking Number ', 'kirki' ),
	'section'  => 'general_settings',
	'default'  => esc_html__( '', 'kirki' ),
	'priority' => 10,
] );

Kirki::add_field( 'theme_config_id', [
	'type'     => 'text',
	'settings' => 'adsense_number',
	'label'    => esc_html__( ' Adsense Number ', 'kirki' ),
	'section'  => 'general_settings',
	'default'  => esc_html__( '', 'kirki' ),
	'priority' => 10,
] );

Kirki::add_field( 'theme_config_id', [
	'type'     => 'text',
	'settings' => 'existing_patients_phone',
	'label'    => esc_html__( '  Existing Patients Phone  ', 'kirki' ),
	'section'  => 'general_settings',
	'default'  => esc_html__( '', 'kirki' ),
	'priority' => 10,
] );

Kirki::add_field( 'theme_config_id', [
	'type'     => 'text',
	'settings' => 'email_address',
	'label'    => esc_html__( '  Email Address  ', 'kirki' ),
	'section'  => 'general_settings',
	'default'  => esc_html__( '', 'kirki' ),
	'priority' => 10,
] );


Kirki::add_field( 'theme_config_id', [
	'type'        => 'dropdown-pages',
	'settings'    => 'contact_page',
	'label'       => esc_html__( 'Contact Page', 'kirki' ),
	'section'     => 'general_settings',
	'priority'    => 10,
] );

Kirki::add_field( 'theme_config_id', [
	'type'        => 'dropdown-pages',
	'settings'    => 'author_page',
	'label'       => esc_html__( 'Author Page', 'kirki' ),
	'section'     => 'general_settings',
	'priority'    => 10,
] );

Kirki::add_field( 'theme_config_id', [
	'type'        => 'dropdown-pages',
	'settings'    => 'appointment_page',
	'label'       => esc_html__( 'Appointment Page', 'kirki' ),
	'section'     => 'general_settings',
	'priority'    => 10,
] );

Kirki::add_field( 'theme_config_id', [
	'type'        => 'image',
	'settings'    => 'publisher_logo',
	'label'       => esc_html__( 'Plublisher Logo', 'kirki' ),
	'description' => esc_html__( 'Need have width of 600px * 60px', 'kirki' ),
	'section'     => 'general_settings',
	'default'     => '',
] );

Kirki::add_field( 'theme_config_id', [
	'type'        => 'image',
	'settings'    => 'share_image',
	'label'       => esc_html__( 'Share Image', 'kirki' ),
	'description' => esc_html__( 'Need have width of 350px * 350px', 'kirki' ),
	'section'     => 'general_settings',
	'default'     => '',
] );


 /*############################ SOCIAL MEDIA SECTION FIELDS ###########################*/   

 

 
 
 Kirki::add_field( 'theme_config_id', [
	'type'        => 'repeater',
	'label'       => esc_html__( 'Social Media Links ', 'kirki' ),
	'section'     => 'social_media',
	'priority'    => 30,
	'row_label' => [
		'type'  => 'text',
		'value' => esc_html__( 'Link', 'kirki' ),
	],
	'button_label' => esc_html__('Add New', 'kirki' ),
	'settings'     => 'social_media_links',
	'fields' => [
        'profile_name' => [
            'type'        => 'text',
            'label'       => esc_html__( 'Profile Name', 'kirki' ),
            'description' => esc_html__( '', 'kirki' ),
            'default'     => '',
        ],
        'social_media_icon_font' => [
            'type'        => 'text',
            'label'       => esc_html__( 'Social Media Icon (Font)', 'kirki' ),
            'description' => esc_html__( '', 'kirki' ),
            'default'     => '',
        ],
        'social_media_icon_image' => [
            'type'        => 'image',
            'label'       => esc_html__( 'Social Media Icon (Image)', 'kirki' ),
            'description' => esc_html__( '', 'kirki' ),
            'default'     => '',
        ],
        'social_media_link' => [
            'type'        => 'link',
            'label'       => esc_html__( 'Social Media Link', 'kirki' ),
            'description' => esc_html__( '', 'kirki' ),
            'default'     => '',
        ],
		        
	],
    
] );
 
  /*############################ LOCATION  SECTION FIELDS ###########################*/
  
  
  Kirki::add_field( 'theme_config_id', [
	'type'        => 'select',
	'settings'    => 'country',
	'label'       => esc_html__( 'Country', 'kirki' ),
	'section'     => 'location',
	'default'     => 'United States',
	'placeholder' => esc_html__( 'Select a country ...', 'kirki' ),
	'priority'    => 10,
	'multiple'    => 1,
	'choices'     => [
		'United States' => esc_html__( 'United States', 'kirki' ),
		'Canada' => esc_html__( 'Canada', 'kirki' ),
		'Australia' => esc_html__( 'Australia', 'kirki' ),
		'England' => esc_html__( 'England', 'kirki' ),
        'Online Based' => esc_html__( 'Online Based', 'kirki' ),
	],
] );
  
  
  
 
 Kirki::add_field( 'theme_config_id', [
	'type'        => 'repeater',
	'label'       => esc_html__( 'Locations ', 'kirki' ),
	'section'     => 'location',
	'priority'    => 30,
	'row_label' => [
		'type'  => 'text',
		'value' => esc_html__( 'Location', 'kirki' ),
	],
	'button_label' => esc_html__('Add New Location', 'kirki' ),
	'settings'     => 'location_info',
	'fields' => [
        'phone' => [
            'type'        => 'text',
            'label'       => esc_html__( 'Phone New Patients', 'kirki' ),
            'description' => esc_html__( '', 'kirki' ),
            'default'     => '',
        ],
        'phone_ex' => [
            'type'        => 'text',
            'label'       => esc_html__( 'Phone Existing Patients', 'kirki' ),
            'description' => esc_html__( '', 'kirki' ),
            'default'     => '',
        ],
        'direction' => [
            'type'        => 'link',
            'label'       => esc_html__( 'Direction', 'kirki' ),
            'description' => esc_html__( '', 'kirki' ),
            'default'     => '',
        ],
        'street_address' => [
            'type'        => 'text',
            'label'       => esc_html__( 'Street Address', 'kirki' ),
            'description' => esc_html__( '', 'kirki' ),
            'default'     => '',
        ],
        'city' => [
            'type'        => 'text',
            'label'       => esc_html__( 'City', 'kirki' ),
            'description' => esc_html__( '', 'kirki' ),
            'default'     => '',
        ],
        
        'state' => [
            'type'        => 'text',
            'label'       => esc_html__( 'State', 'kirki' ),
            'description' => esc_html__( '', 'kirki' ),
            'default'     => '',
        ],
        
        'zip' => [
            'type'        => 'text',
            'label'       => esc_html__( 'Zip', 'kirki' ),
            'description' => esc_html__( '', 'kirki' ),
            'default'     => '',
        ],
        
        'latitude' => [
            'type'        => 'text',
            'label'       => esc_html__( 'Latitude', 'kirki' ),
            'description' => esc_html__( '', 'kirki' ),
            'default'     => '',
        ],
        
        'longitude' => [
            'type'        => 'text',
            'label'       => esc_html__( 'Longitude', 'kirki' ),
            'description' => esc_html__( '', 'kirki' ),
            'default'     => '',
        ],
		        
	],
    
] );



  /*############################ WORKING HOURS  SECTION FIELDS ###########################*/
  
  
  Kirki::add_field( 'theme_config_id', [
	'type'        => 'repeater',
	'label'       => esc_html__( 'Working hours ', 'kirki' ),
	'section'     => 'working_hours',
	'priority'    => 30,
	'row_label' => [
		'type'  => 'text',
		'value' => esc_html__( 'Day', 'kirki' ),
	],
	'button_label' => esc_html__('Add New', 'kirki' ),
	'settings'     => 'working_hrs',
	'fields' => [
        'day' => [
            'type'        => 'select',
            'label'       => esc_html__( 'Day', 'kirki' ),
            'description' => esc_html__( '', 'kirki' ),
            'default'     => '',
            'choices'     => [
                'Select Day' => esc_html__( 'Select Day', 'kirki' ),
                'Monday' => esc_html__( 'Monday', 'kirki' ),
                'Tuesday' => esc_html__( 'Tuesday', 'kirki' ),
                'Wednesday' => esc_html__( 'Wednesday', 'kirki' ),
                'Thursday' => esc_html__( 'Thursday', 'kirki' ),
                'Friday' => esc_html__( 'Friday', 'kirki' ),
                'Saturday' => esc_html__( 'Saturday', 'kirki' ),
                'Sunday' => esc_html__( 'Sunday', 'kirki' ),
            ],
        ],
        
        'closed' => [
            'type'        => 'checkbox',
            'label'       => esc_html__( 'Closed ?', 'kirki' ),
            'description' => esc_html__( '', 'kirki' ),
            'default'     => false,
        ],
        
        'opening' => [
            'type'        => 'text',
            'label'       => esc_html__( 'Opening', 'kirki' ),
            'description' => esc_html__( '', 'kirki' ),
            'default'     => '',
        ],
        
        'closing' => [
            'type'        => 'text',
            'label'       => esc_html__( 'Closing', 'kirki' ),
            'description' => '',
            'default'     => '',
        ],
        
        'extra_text' => [
            'type'        => 'text',
            'label'       => esc_html__( 'Extra text', 'kirki' ),
            'description' => '',
            'default'     => '',
        ],
        
		        
	],
    
] );
 

 
/*###################################  Popup Seetings #################################*/


Kirki::add_field( 'theme_config_id', [
	'type'        => 'checkbox',
	'settings'    => 'show_popup',
	'label'       => esc_html__( 'Show popup', 'kirki' ),
	'description' => esc_html__( '' ),
	'section'     => 'popup_settings',
	'default'     => '',
] );

Kirki::add_field( 'theme_config_id', [
	'type'        => 'select',
	'settings'    => 'select_popup',
	'label'       => esc_html__( 'Select a popup', 'kirki' ),
	'section'     => 'popup_settings',
	'default'     => 'custom',
	'placeholder' => esc_html__( 'Select a popup', 'kirki' ),
	'priority'    => 10,
	'multiple'    => 1,
	'choices'     => Kirki_Helper::get_posts(
                    array(
                        'numberposts' => -1,
                        'post_type'   => 'popup',
                      ) 
    
    ),
] );

Kirki::add_field( 'theme_config_id', [
	'type'        => 'select',
	'settings'    => 'select_mobile_popup',
	'label'       => esc_html__( 'Select Mobile popup', 'kirki' ),
	'section'     => 'popup_settings',
	'default'     => 'custom',
	'placeholder' => esc_html__( 'Select Mobile popup', 'kirki' ),
	'priority'    => 10,
	'multiple'    => 1,
	'choices'     => Kirki_Helper::get_posts(
                    array(
                        'numberposts' => -1,
                        'post_type'   => 'popup_mobile',
                      ) 
    
    ),
] );