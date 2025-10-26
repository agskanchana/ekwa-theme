<?php
/* ########################### shortcodes ###################*/


     global $phone;
	 global $mobile_p;
	 global $existing_phone;
	 global $existing_mobile_p;
     global $ads_phone;

	 $phone = get_theme_mod('call_tracking_number', '');


	 $mobile_p = preg_replace("/[^0-9]/", "", $phone);

	 $country = get_theme_mod('country', 'United States');

	 if($country == 'United States' || $country == 'Canada'){
		$mobile_p ="+1".$mobile_p;
	 }


	 $existing_phone = get_theme_mod('existing_patients_phone', '');
	 $existing_mobile_p = preg_replace("/[^0-9]/", "", $existing_phone);

	 if($country == 'United States' || $country == 'Canada'){
		$existing_mobile_p ="+1".$existing_mobile_p;
	 }

     $ads_phone = get_theme_mod('adsense_number', '');



function phone($type = 'normal'){

    global $phone;
    global $mobile_p;

    if($type == 'plain'){
        echo $phone;
    }
    elseif($type == 'mobile'){
        echo $mobile_p;
    }else{
        echo '<a class="p_number" href="tel:'.$mobile_p.'">'.$phone.'</a>';
    }

}

function phone_ex($type = 'normal'){

    global $existing_phone;
     global $existing_mobile_p;

    if($type == 'plain'){
        echo $existing_phone;
    }
    elseif($type == 'mobile'){
        echo $existing_mobile_p;
    }else{
        echo '<a class="p_number" href="tel:'.$existing_mobile_p.'">'.$existing_phone.'</a>';
    }

}

/*

add_shortcode('phone',function(){
     global $phone;
     global $mobile_p;
      $phone_1 = '<a class="p_number" href="tel:'.$mobile_p.'">'.$phone.'</a>';
     return $phone_1;

});
*/
add_shortcode('phone', function ($atts = 1) {

    $atts = shortcode_atts( array(
        'location' => 1
    ), $atts);

	if (isset($_COOKIE['adward_number']) || isset($_GET['ads'])) {
        global $ads_phone;
		$phone_1 = '<a class="p_number" href="tel:'.mobile_number($ads_phone).'">'.$ads_phone.'</a>';
	} else {
        $phone_1  = get_location('phone', $atts['location']);
        $phone_1 = '<a class="p_number" href="tel:' . mobile_number($phone_1) . '">' . $phone_1 . '</a>';


	}
	return $phone_1;
});

add_shortcode('fa_icon', function($atts){
    ?>
    <i class="<?php echo $atts['class'];?>"></i>
    <?php
});


add_shortcode('phone_ex', function ($atts) {
    $atts = shortcode_atts( array(
        'location' => 1
    ), $atts);

	if (isset($_COOKIE['adward_number']) || isset($_GET['ads'])) {
        global $ads_phone;
		$existing_phone_number = '<a class="p_number" href="tel:'.mobile_number($ads_phone).'">'.$ads_phone.'</a>';
	} else {
		$existing_phone_number  = get_location('phone_ex', $atts['location']);
        $existing_phone_number = '<a class="p_number" href="tel:' . mobile_number($existing_phone_number) . '">' . $existing_phone_number . '</a>';
	}
	return $existing_phone_number;
});


add_shortcode('mobile_number',function(){
    global $mobile_p;
    global $ads_phone;
    $mn = $mobile_p;
     if (isset($_COOKIE['adward_number']) || isset($_GET['ads'])) {
        $mn = mobile_number($ads_phone);
     }
     return $mn;
});


add_shortcode('mobile_number_ex',function(){
     global $existing_mobile_p;
     global $ads_phone;
     $emn = $existing_mobile_p;
     if (isset($_COOKIE['adward_number']) || isset($_GET['ads'])) {
        $emn = mobile_number($ads_phone);
     }

     return $emn;
});





// require get_template_directory() . '/settings/before-after-plugin/index.php';
$show_popup_admin = false;
$show_popup_admin = get_theme_mod('show_popup');
if($show_popup_admin){

// desktop popup

function popup_post_type(){
    $labels = array(
            'name' => 'Popup',
            'singular_name' => 'Popup',
            'add_new' => 'Add New Popup Item'
    );

    $args = array(
                        'labels' => $labels,
                        'supports'              => array( 'title', 'editor',  ),
                        'show_in_rest' => true,
                        'hierarchical'          => false,
                        'public'                => false,
                        'show_ui'               => true,
                        'show_in_menu'          => true,
                        'menu_position'         => 5,
                        'menu_icon'             => 'dashicons-editor-expand',
                        'show_in_admin_bar'     => true,
                        'show_in_nav_menus'     => false,
                        'can_export'            => true,
                        'has_archive'           => false,
                        'exclude_from_search'   => true,
                        'publicly_queryable'    => false,
                        'query_var'             => false,
                        'capability_type'       => 'post'


    );
    register_post_type( 'popup', $args );
}

add_action( 'init', 'popup_post_type');

// mobile popup

function popup_mobile_post_type(){
    $labels = array(
            'name' => 'Popup Mobile',
            'singular_name' => 'Popup Mobile',
            'add_new' => 'Add New Popup Item'
    );

    $args = array(
                        'labels' => $labels,
                        'supports'              => array( 'title', 'editor',  ),
                        'show_in_rest' => true,
                        'hierarchical'          => false,
                        'public'                => false,
                        'show_ui'               => true,
                        'show_in_menu'          => true,
                        'menu_position'         => 5,
                        'menu_icon'             => 'dashicons-editor-expand',
                        'show_in_admin_bar'     => true,
                        'show_in_nav_menus'     => false,
                        'can_export'            => true,
                        'has_archive'           => false,
                        'exclude_from_search'   => true,
                        'publicly_queryable'    => false,
                        'query_var'             => false,
                        'capability_type'       => 'post'


    );
    register_post_type( 'popup_mobile', $args );
}

add_action( 'init', 'popup_mobile_post_type');


}

