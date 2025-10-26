<?php

use Kirki\Field\Color;

include(get_template_directory()."/settings/mobile-detect/Mobile_Detect.php");


function gen_uid($l=10){
    return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyz"), 0, $l);
}



function update_admin_css(){

	$path = get_template_directory().'/css/color-variables.css';

		$fp = fopen($path, 'w');
		if(!$fp){
		echo 'file is not opend';
		}
		$color_one = get_theme_mod('color_one', '#000000');
		$color_two = get_theme_mod('color_two', '#1e73be');
		$color_three = get_theme_mod('color_three', '#30475e');
		$color_four = get_theme_mod('color_four', '#f2a365');
		$color_five = get_theme_mod('color_five', '#639a67');
		$color_text = get_theme_mod('color_text', '#000000');
		$color_link = get_theme_mod('color_link', '#1b315e');
		$color_link_hover = get_theme_mod('color_link_hover', '#000000');
		$color_headings = get_theme_mod('color_headings', '#000000');
		$color_invert = get_theme_mod('color_invert', '#ffffff');
		$css_content = ':root {
			--color_one: '.$color_one.'; '
			.'--color_two: '.$color_two.'; '
			.'--color_three: '.$color_three.'; '
			.'--color_four: '.$color_four.'; '
			.'--color_five: '.$color_five.'; '
			.'--color_text: '.$color_text.'; '
			.'--color_link: '.$color_link.'; '
			.'--color_link_hover: '.$color_link_hover.'; '
			.'--color_headings: '.$color_headings.'; '
			.'--color_invert: '.$color_invert.';
		}';


		fwrite($fp, $css_content);
		fclose($fp);
}
add_action( 'customize_save_after', 'update_admin_css' );



// only mobile  without tabs
function is_mobile() {
$detect = new Mobile_Detect;

  if( $detect->isMobile() && !$detect->isTablet() ){
    return true;
  } else {
    return false;
  }

}


// only tabs
function is_tab(){
	$detect = new Mobile_Detect;
	if( $detect->isTablet() ){
		return true;
	}else{
		return false;
	}
}

// mobile or tablet
function is_device(){
	$detect = new Mobile_Detect;
	if ( $detect->isMobile() ) {
		return true;
	}else{
		return false;
	}
}


function is_ios(){
  $detect = new Mobile_detect;
  if( $detect->isiOS() ){
	return true;
  }else{
	return false;
  }

}

function is_ie(){
  $ua = htmlentities($_SERVER['HTTP_USER_AGENT'], ENT_QUOTES, 'UTF-8');
if (preg_match('~MSIE|Internet Explorer~i', $ua) || (strpos($ua, 'Trident/7.0') !== false && strpos($ua, 'rv:11.0') !== false)) {
   return true;
}else{
  return false;
}
}






add_filter( 'wpseo_title', 'do_shortcode' );
add_filter( 'wpseo_metadesc', 'do_shortcode' );


// Numbered Pagination
function ekwa_pagination() {
	global $wp_query;
		$big = 999999999; // need an unlikely integer
			echo paginate_links( array(
			'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
			'format' => '?paged=%#%',
			'current' => max( 1, get_query_var('paged') ),
			'total' => $wp_query->max_num_pages
		) );
}



/************Menus *******/

function ekwa_custom_menu() {
  register_nav_menu('main-menu',__( 'Main slug: main-menu' ));
  register_nav_menu('footer-menu',__( 'Footer Menu' ));
  register_nav_menu('service-menu',__( 'Service Menu' ));
  register_nav_menu('mobile-menu',__( 'Mobile Menu' ));
  register_nav_menu('mobile-menu-services',__( 'Mobile Menu Services' ));
  register_nav_menu('site-map',__( 'Site Map' ));
}


add_action( 'init', 'ekwa_custom_menu' );


/**************** Ekwa theme scripts / styles **********************/
// remove core jquery
function dereg_core_jquery() {
    if (!is_admin()) {
        wp_deregister_script('jquery');
        wp_register_script('jquery', false);
    }
}
add_action('init', 'dereg_core_jquery');

function ekwa_script_enqueue(){
    wp_enqueue_script('loadcss', get_template_directory_uri().'/js/loadcss.js', array(), '1.0.0', true);
    wp_enqueue_script('lazysizes', get_template_directory_uri().'/js/lazysizes.js', array(), '1.0.0', true);
    wp_enqueue_script('jqueryjs',get_template_directory_uri().'/js/jquery.js',array(),'1.0.0', true);
    wp_enqueue_script('customjs', get_template_directory_uri().'/js/custom.js', array(), '1.2.6', true);
     wp_enqueue_script('mmenu', get_template_directory_uri().'/plugins/mm-menu/mmenu-light.js', array(), '1.1.0', true);

	if(is_404()){
	  wp_enqueue_script('treeviewjs', get_template_directory_uri().'/plugins/treeview/treeview.js', array(), '1.0.0', true);
        wp_enqueue_style('treeview',get_template_directory_uri().'/plugins/treeview/treeview.css', array(),'1.0.0','all', true);
	}
}
add_action('wp_enqueue_scripts', 'ekwa_script_enqueue');

/*
function test_wp(){
	if(!is_mobile()){
		add_action('wp_head', function(){
			echo '<link rel="stylesheet" href="'.get_template_directory_uri().'/css/critical.css'.'">';

		});
	}
}
*/
add_action('wp_head', function(){
			get_template_part( 'template-parts/schema' );

});

/*
add_action('wp_head', function(){
			get_template_part( 'css/critical.css' );

});*/


function hook_critical_css() {
	// $critical_css = get_content_curl(get_template_directory(). '/css/critical.css' );
	echo '<style>';
	include(get_template_directory()."/css/critical.css");
	echo '</style>';
}
add_action('wp_head','hook_critical_css');


add_action( 'after_setup_theme', function(){
	global $links;
	$links  = array(

		array(
			'link' => 'css/desktop.css',
			'desktop_only' => true,
			'label' =>  'desktop'
		),
		array(
			'link' => 'plugins/fontawesome/css/all.min.css',
			'desktop_only' => true,
			'label' =>  'fontawesome'
		),
		array(
			'link' => 'plugins/mm-menu/mmenu-light.css',
			'desktop_only' => false,
			'label' =>  'mmenu'
		),
	);


	if(is_mobile()){

		add_action('wp_footer', function() {
			global $links;

			if($links){
				echo '<script>';
				foreach($links as $link){
					if(!$link['desktop_only']){
						echo 'loadCSS("'.get_template_directory_uri().'/'.$link['link'].'");';
					}
				}
				echo '</script>';
			}


		}, 100);
	}else{
		add_action('wp_enqueue_scripts', function(){
			global $links;
			if($links){
				foreach($links as $link){
					wp_enqueue_style($link['label'],get_template_directory_uri().'/'.$link['link'],array(),'1.0.0','all');
				}
			}


		});
	}




});


/*
add_filter('the_content','enqueue_script_if_there_is_block');

function enqueue_script_if_there_is_block($content = ""){
  if(has_block('lazyblock/treeview')){

        wp_enqueue_script('treeviewjs', get_template_directory_uri().'/plugins/treeview/treeview.js', array(), '1.0.0', true);
        wp_enqueue_style('treeview',get_template_directory_uri().'/plugins/treeview/treeview.css', array(),'1.0.0','all', true);

     }

   return $content;
}*/

//lazyblocks remove wrapper

//add_filter( 'lazyblock/my_block_slug/frontend_allow_wrapper', '__return_false' );



add_action( "customize_register", "remove_customizer_patnels" );
function remove_customizer_patnels( $wp_customize ) {

 //=============================================================
 // Remove header image and widgets option from theme customizer
 //=============================================================
 $wp_customize->remove_control("header_image");
 //$wp_customize->remove_panel("widgets");
 $wp_customize->remove_section( 'static_front_page' );


 //=============================================================
 // Remove Colors, Background image, and Static front page
 // option from theme customizer
 //=============================================================
 $wp_customize->remove_section("colors");
 $wp_customize->remove_section("background_image");


}



// unregister all widgets

function unregister_default_widgets() {

    unregister_widget('WP_Widget_Search');
    //unregister_widget('WP_Widget_Categories');
    //unregister_widget('WP_Widget_Recent_Posts');
    //unregister_widget('WP_Nav_Menu_Widget');

    unregister_widget('WP_Widget_Media_Gallery');
    unregister_widget('WP_Widget_Pages');
    unregister_widget('WP_Widget_Calendar');
    unregister_widget('WP_Widget_Archives');
    unregister_widget('WP_Widget_Links');
    unregister_widget('WP_Widget_Meta');

    unregister_widget('WP_Widget_Text');

    unregister_widget('WP_Widget_Recent_Comments');
    unregister_widget('WP_Widget_RSS');
    unregister_widget('WP_Widget_Tag_Cloud');

    unregister_widget('Twenty_Eleven_Ephemera_Widget');
    unregister_widget('WP_Widget_Media_Audio');
    unregister_widget('WP_Widget_Media_Image');
    unregister_widget('WP_Widget_Media_Video');
    unregister_widget('WP_Widget_Custom_HTML');
}
add_action('widgets_init', 'unregister_default_widgets', 11);

require get_template_directory() . '/inc/ekwa-widgets/index.php';

require get_template_directory(). '/settings/acf-code-field/acf-code-field.php';




/*********** Enqueue script for customizer (if needed ) ******/

add_action( 'customize_controls_enqueue_scripts', 'ekwa_customizer_control_scripts' );

function ekwa_customizer_control_scripts() {
	wp_enqueue_script( 'ekwa-customizer-script', get_template_directory_uri() . '/js/customizer-script.js', array( 'customize-controls' ) );
	wp_enqueue_script( 'ekwa-location-hours', get_template_directory_uri() . '/settings/customizer-settings/js/location-working-hours.js', array( 'jquery', 'customize-controls' ), '1.0.5', true );
    wp_enqueue_style('ekwa-customizer-styles',get_template_directory_uri().'/settings/customizer-settings/css/style.css',array(),'1.0.0','all');
}

add_image_size( 'featured_mobile', 360, 200, false );

function ekwa_print_styles($slug, $property){
   if(get_field($slug)){
	echo $property.": ".get_field($slug).";";
   }
}

function limit_content($limit) {
	$content = explode(' ', get_the_content(), $limit);
	if (count($content)>=$limit) {
	  array_pop($content);
	  $content = implode(" ",$content).'...';
	} else {
	  $content = implode(" ",$content);
	}
	$content = preg_replace('/[.+]/','', $content);
	$content = apply_filters('the_content', $content);
	$content = str_replace(']]>', ']]&gt;', $content);

	$content = wp_strip_all_tags($content);
	return $content;
}

function change_permalinks() {
    global $wp_rewrite;
    $wp_rewrite->set_permalink_structure('/%postname%/');
    $wp_rewrite->flush_rules();
}
add_action('init', 'change_permalinks');

function main_menu(){

    wp_nav_menu( array(
    'theme_location' => 'main-menu',
    'container' => false
     ));

}
function logo(){

     if ( function_exists( 'the_custom_logo' ) ) {
		$custom_logo_id = get_theme_mod( 'custom_logo' );
		$image = wp_get_attachment_image_src( $custom_logo_id , 'full' );
     }
	$practise_name =  get_theme_mod('practise_name', '');
     $site_url =  get_option( 'siteurl' );
     echo '<a href="'.$site_url.'"><img src="'.$image[0].'" alt="'.$practise_name.'"></a>';
}

function mobile_logo(){
  $type = get_theme_mod('select_mobile_logo', 'same-as-desktop');

  $practise_name =  get_theme_mod('practise_name', '');

  if($type == 'same-as-desktop' || $type == 'base64'){

	 if($type == 'base64'){
	  $logo = get_theme_mod('mobile_logo_base64');
	 }else{
	  if ( function_exists( 'the_custom_logo' ) ) {
		  $custom_logo_id = get_theme_mod( 'custom_logo' );
		  $logo = wp_get_attachment_image_src( $custom_logo_id , 'full' );
		}
	 }
	 if($logo){
	  echo '<img width="'.$logo[1].'" height="'.$logo[2].'" src="'.$logo[0].'" alt="'.$practise_name.'">';
	}

  }
  if($type == 'svg'){
	echo get_theme_mod('mobile_logo_svg');
  }

  if($type == 'webp'){

	if ( function_exists( 'the_custom_logo' ) ) {
		  $custom_logo_id = get_theme_mod( 'custom_logo' );
		  $logo_desktop = wp_get_attachment_image_src( $custom_logo_id , 'full' );
		}
	$logo = get_theme_mod('mobile_logo_webp');
	echo '<picture>
		  <source srcset="'.$logo.'" type="image/webp">
		  <img src="'.$logo_desktop[0].'" alt="'.$practise_name.'">
	</picture>';

  }

}





function get_location($sub_val, $which_location = 1){

	$location_rows  =  get_theme_mod( 'location_info', "" );

	if($location_rows){
		$location_row = $which_location - 1;
		return  $location_rows[$location_row][$sub_val];
	}

}

/**
 * Get working hours for a specific location
 *
 * @param int $which_location Location index (1-based)
 * @return array Array of working hours data
 */
function get_location_working_hours($which_location = 1) {
	$location_rows = get_theme_mod('location_info', '');

	if ($location_rows) {
		$location_row = $which_location - 1;
		if (isset($location_rows[$location_row]['working_hours_data'])) {
			$hours_json = $location_rows[$location_row]['working_hours_data'];
			$hours_data = json_decode($hours_json, true);
			return is_array($hours_data) ? $hours_data : array();
		}
	}

	return array();
}

/**
 * Display working hours for a specific location
 *
 * @param int $which_location Location index (1-based)
 * @param string $format Format: 'list', 'table', or 'schema'
 */
function display_location_working_hours($which_location = 1, $format = 'list') {
	$hours = get_location_working_hours($which_location);

	if (empty($hours)) {
		return;
	}

	if ($format === 'list') {
		echo '<ul class="working-hours-list">';
		foreach ($hours as $day_data) {
			echo '<li class="day-' . strtolower($day_data['day']) . '">';
			echo '<strong>' . esc_html($day_data['day']) . ':</strong> ';

			if ($day_data['closed']) {
				echo 'Closed';
			} else {
				echo esc_html($day_data['opening']) . ' - ' . esc_html($day_data['closing']);
				if (!empty($day_data['extra_text'])) {
					echo ' <span class="extra-text">(' . esc_html($day_data['extra_text']) . ')</span>';
				}
			}
			echo '</li>';
		}
		echo '</ul>';
	} elseif ($format === 'table') {
		echo '<table class="working-hours-table">';
		foreach ($hours as $day_data) {
			echo '<tr>';
			echo '<td class="day-name"><strong>' . esc_html($day_data['day']) . '</strong></td>';
			echo '<td class="hours">';

			if ($day_data['closed']) {
				echo 'Closed';
			} else {
				echo esc_html($day_data['opening']) . ' - ' . esc_html($day_data['closing']);
				if (!empty($day_data['extra_text'])) {
					echo ' <span class="extra-text">(' . esc_html($day_data['extra_text']) . ')</span>';
				}
			}
			echo '</td>';
			echo '</tr>';
		}
		echo '</table>';
	} elseif ($format === 'schema') {
		// Return Schema.org compatible format
		$schema_hours = array();
		foreach ($hours as $day_data) {
			if (!$day_data['closed']) {
				$schema_hours[] = $day_data['day'] . ' ' . $day_data['opening'] . '-' . $day_data['closing'];
			}
		}
		return $schema_hours;
	}
}

function get_address($which_location = 1){

	$location_rows = get_theme_mod("location_info", "");

	if($location_rows){
		$location_row = $which_location - 1;
		return "
		<span class='header-street-address'>".$location_rows[$location_row]['street_address'].", </span>
		<span class='header-city'>".$location_rows[$location_row]['city'].", </span>
		<span class='header-state'>".$location_rows[$location_row]['state']." </span>
		<span class='header-zip'>".$location_rows[$location_row]['zip']."</span>";

	}
}

function appointment_page_link(){
	$postID = get_theme_mod("appointment_page", '');
	$slug = get_post_field( 'post_name', $postID );
	$slug = get_option( 'siteurl' )."/".$slug;
	return $slug;
}


function get_page_slug_by_id($ID){
	$slug = get_post_field( 'post_name', $ID );
	$slug = get_option( 'siteurl' )."/".$slug;
	return $slug;
}




/*
function content_class(){
	global $page_id;
	$container = get_field('container', $page_id);
	if($container){
		echo "class='container'";
	}
}
*/
function get_page_slug($post_id){
	$slug =  get_post_field( 'post_name', $post_id );
	return get_option( 'siteurl' ).'/'.$slug;
}

function mobile_number($phone_number){

	$phone_number = preg_replace("/[^0-9]/", "", $phone_number);
	$country =  get_theme_mod('country', "United States");
	if($country == 'United States' || $country == 'Canada'){
		$phone_number ="+1".$phone_number;
	 }

	 return $phone_number;

}




function get_menu_label_by_post_id($post_id, $menu) {

    $menu_title = '';
    $nav = wp_get_nav_menu_items($menu);

	if($nav){
	  foreach ( $nav as $item ) {

		  if ( $post_id == $item->object_id ) {
			  $menu_title = $item->post_title;
			  break;
		  }

	  }
	}

    return ($menu_title !== '') ? $menu_title : get_the_title($post_id);

}


function ekwa_the_title($pageID){
        if(!is_front_page()){
			$menu_name = get_menu_label_by_post_id($pageID, 'main-menu');
			$title = get_the_title();
			if($menu_name!=$title){
				echo  '<h1>'.get_the_title().'</h1>';
			}
		}
}

function inner_page_heading($pageID){

	$menu_name = get_menu_label_by_post_id($pageID, 'main-menu');
    $title = get_the_title();
	if($menu_name==$title){
		echo  '<h1>'.get_the_title().'</h1>';
	}else{
		echo '<span class="inner-caption-heading"> '.get_menu_label_by_post_id($pageID, 'main-menu').'</span>';
	}
}

function page_class(){
	if(is_front_page()){
		echo 'home-page';
	}else{
		echo 'inner-page';
	}
}

// enable webp upload

function webp_file_and_ext( $mime, $file, $filename, $mimes ) {

    $wp_filetype = wp_check_filetype( $filename, $mimes );
    if ( in_array( $wp_filetype['ext'], [ 'webp' ] ) ) {
        $mime['ext']  = true;
        $mime['type'] = true;
    }

    return $mime;
}
add_filter( 'wp_check_filetype_and_ext', 'webp_file_and_ext', 10, 4 );

function add_webp_mime_type( $mimes ) {
    $mimes['webp'] = 'image/webp';
    return $mimes;
}
add_filter( 'upload_mimes', 'add_webp_mime_type' );

// print css variables if available


function ekwa_get_value($slug, $default, $arry_key = null ){

 if(get_theme_mod($slug, $default)){
  if($arry_key){
	echo get_theme_mod($slug, $default)[$arry_key];
  }else{
	echo get_theme_mod($slug, $default);
  }
 }else{
  echo $default;
 }

}

// remove wp-embed.js

function my_deregister_scripts(){
 wp_dequeue_script( 'wp-embed' );
}
add_action( 'wp_footer', 'my_deregister_scripts' );

// load css


remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );



function add_defer_attribute($tag, $handle) {

if ( is_user_logged_in() ) return $tag;
if ($handle !== 'loadcss') {

		if (false === stripos($tag, 'defer')) {

			$tag = str_replace(' src', ' defer="defer" src', $tag);

		}

}

	return $tag;

}
add_filter('script_loader_tag', 'add_defer_attribute', 10, 2);


include(get_template_directory()."/settings/short-codes-post-types.php");



add_filter( 'walker_nav_menu_start_el', 'ekwa_walker_nav_menu_start_el', 10, 4 );
function ekwa_walker_nav_menu_start_el( $item_output, $item, $depth, $args ) {

	if($args->theme_location == 'mobile-menu' || $args->theme_location == 'mobile-menu-services'){
	if ( empty( $item->url ) || '#' === $item->url ) {
        $item_output = $args->before;
        $item_output .= '<span>';
        $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
        $item_output .= '</span>';
        $item_output .= $args->after;
    }
  }
  return $item_output;

}



function lazy_thumbnail($size = 'full', $offset  = -10){

  $thumb_id = get_post_thumbnail_id();
  $thumb_url_array = wp_get_attachment_image_src($thumb_id, $size, true);
  $thumb_url = $thumb_url_array[0];
  $alt = get_post_meta ( $thumb_id, '_wp_attachment_image_alt', true );
  echo '<img class="lazyload" data-src="'.$thumb_url.'" alt="'.$alt.'" data-expand="'.$offset.'">';
}

function lazy_thumbnail_url($size = 'full'){
  $thumb_id = get_post_thumbnail_id();
  $thumb_url_array = wp_get_attachment_image_src($thumb_id, $size, true);
  $thumb_url = $thumb_url_array[0];
  return $thumb_url;
}



function responsive_banner($small, $webp, $large, $alt){

  if(is_mobile()){
	if(is_ios()){
	$img = $small;
	}else{
	  $img = $webp;
	}
  }else{
	$img = $large;
  }

  echo '<img  src="'.$img.'" alt="'.$alt.'">';

}




/* Exclude Multiple Content Types From Yoast SEO Sitemap */
add_filter( 'wpseo_sitemap_exclude_post_type', 'sitemap_exclude_post_type', 10, 2 );
function sitemap_exclude_post_type( $value, $post_type ) {
$post_type_to_exclude = array('ekwa_theme_resources','ekwa_before_after');
if( in_array( $post_type, $post_type_to_exclude ) ) return true;
}

/* Exclude Multiple Taxonomies From Yoast SEO Sitemap */
add_filter( 'wpseo_sitemap_exclude_taxonomy', 'sitemap_exclude_taxonomy', 10, 2 );
function sitemap_exclude_taxonomy( $value, $taxonomy ) {
$taxonomy_to_exclude = array('before-after-category','ekwa-theme-resources-category');
if( in_array( $taxonomy, $taxonomy_to_exclude ) ) return true;
}


// add the filter
		add_filter( 'wpseo_sitemap_exclude_author', function() {
			return [];
		}, 10, 1 );






// Disable REST API link tag
remove_action( 'wp_head','rest_output_link_wp_head');
// Disable oEmbed Discovery Links
remove_action('wp_head', 'wp_oembed_add_discovery_links', 10);
// Disable REST API link in HTTP headers
remove_action('template_redirect', 'rest_output_link_header', 11, 0);
// Disable rsd_link
remove_action ('wp_head', 'rsd_link');
// disable livewriter manifest
remove_action( 'wp_head', 'wlwmanifest_link');
// disable shortlink
remove_action( 'wp_head', 'wp_shortlink_wp_head');



/*********** ACF  Blocks ***********/




function encryptString($plainText, $key, $cipherMethod) {
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipherMethod));
    $encryptedText = openssl_encrypt($plainText, $cipherMethod, $key, 0, $iv);
    return base64_encode($iv . $encryptedText);
}


add_action('init', 'my_acf_init_block_types',999);
function my_acf_init_block_types() {

    // Check function exists.
    if( function_exists('acf_register_block_type') ) {

	$icon = '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="72" height="72" viewBox="0 0 72 72"><image id="ekwa" width="72" height="72" xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEgAAABICAYAAABV7bNHAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyFpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuNi1jMTQyIDc5LjE2MDkyNCwgMjAxNy8wNy8xMy0wMTowNjozOSAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENDIChXaW5kb3dzKSIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDo2OTJEQUEwMDhFNTExMUVDQTA2MkExRkIxOTM1ODZCOCIgeG1wTU06RG9jdW1lbnRJRD0ieG1wLmRpZDo2OTJEQUEwMThFNTExMUVDQTA2MkExRkIxOTM1ODZCOCI+IDx4bXBNTTpEZXJpdmVkRnJvbSBzdFJlZjppbnN0YW5jZUlEPSJ4bXAuaWlkOjY5MkRBOUZFOEU1MTExRUNBMDYyQTFGQjE5MzU4NkI4IiBzdFJlZjpkb2N1bWVudElEPSJ4bXAuZGlkOjY5MkRBOUZGOEU1MTExRUNBMDYyQTFGQjE5MzU4NkI4Ii8+IDwvcmRmOkRlc2NyaXB0aW9uPiA8L3JkZjpSREY+IDwveDp4bXBtZXRhPiA8P3hwYWNrZXQgZW5kPSJyIj8+Pdz1eQAAEz9JREFUeNrMXAl0FFW6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"/></svg>';
	include(get_template_directory()."/template-parts/default-ekwa-blocks.php");

    }
}


// Close comments on the front-end

add_filter('comments_open', '__return_false', 20, 2);

// Hide existing comments

add_filter('comments_array', '__return_empty_array', 10, 2);






add_filter( 'wp_lazy_loading_enabled', '__return_false' );



function ekwa_content($content){
	//-- Change src to data attributes.
	$content = preg_replace("/<img(.*?)(src=)(.*?)>/i", '<img$1data-$2$3>', $content);
    	//-- Change srcset to data attributes.
    	$content = preg_replace("/<img(.*?)(srcset=)(.*?)>/i", '<img$1data-$2$3>', $content);
	//-- Add .lazy-load class to each image that already has a class.
	$content = preg_replace('/<img(.*?)class=\"(.*?)\"(.*?)>/i', '<img$1class="$2 lazyload"$3>', $content);

	//-- Add .lazy-load class to each image that doesn't already have a class.
	$content = preg_replace('/<img((.(?!class=))*)\/?>/i', '<img class="lazyload"$1>', $content);
	return  $content;
}

/*
add_filter('the_content', function ($content) {
	//-- Change src to data attributes.
	$content = preg_replace("/<img(.*?)(src=)(.*?)>/i", '<img$1data-$2$3>', $content);

    	//-- Change srcset to data attributes.
    	$content = preg_replace("/<img(.*?)(srcset=)(.*?)>/i", '<img$1data-$2$3>', $content);

	//-- Add .lazy-load class to each image that already has a class.
	$content = preg_replace('/<img(.*?)class=\"(.*?)\"(.*?)>/i', '<img$1class="$2 lazyload"$3>', $content);

	//-- Add .lazy-load class to each image that doesn't already have a class.
	$content = preg_replace('/<img((.(?!class=))*)\/?>/i', '<img class="lazyload"$1>', $content);

	return $content;
});
*/


// Add this to your theme's functions.php file
function ekwa_protect_shortcodes_from_wpautop($content) {
    $array = array(
        '<p>[before_after_custom' => '[before_after_custom',
        '</p>[before_after_custom' => '[before_after_custom',
        '[before_after_custom]</p>' => '[before_after_custom]',
        '[/before_after_custom]<p>' => '[/before_after_custom]'
    );

    // Replace all instances of wpautop messing with the shortcode
    $content = strtr($content, $array);

    // Remove empty paragraphs created by wpautop
    $content = preg_replace('/<p>\s*<\/p>/', '', $content);

    return $content;
}

// Hook this function to run late in the content processing
add_filter('the_content', 'ekwa_protect_shortcodes_from_wpautop', 12);


add_filter( 'body_class','ekwa_body_classes_extra' );
function ekwa_body_classes_extra( $classes ) {
    $classes[] = 'ekwa-body';
    return $classes;

}


function short_codes_in_og_meta($presentation)
{
$presentation->open_graph_title = do_shortcode(get_post_meta(get_the_ID(), '_yoast_wpseo_title', true));
$presentation->open_graph_description = do_shortcode(get_post_meta(get_the_ID(), '_yoast_wpseo_metadesc', true));

return $presentation;
}
add_filter('wpseo_frontend_presentation', 'short_codes_in_og_meta', 200);


// Mobile menu icon
add_filter('wp_nav_menu_objects', 'my_wp_nav_menu_objects', 10, 2);

function my_wp_nav_menu_objects( $items, $args ) {
	// loop
	foreach( $items as &$item ) {
		// vars
		$icon = get_field('icon', $item);
		// append icon
		if( $icon ) {
			$item->title = '<span><i class="fas fa-'.$icon.'"></i></span> '.$item->title;
		}
	}
	// return
	return $items;
}



include(get_template_directory()."/settings/acf-common-block-styles.php");


add_action( 'after_setup_theme', 'enable_woocommerce_support' );

function enable_woocommerce_support() {
	add_theme_support( 'woocommerce' );
}



