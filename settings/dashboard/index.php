<?php

        
/*######  Creating Admin pages ********/

  
   /* function ekwa_admin_page(){
        
         // generate ekwa admin page
         add_menu_page("Ekwa Theme Options", 'Ekwa theme', 'manage_options', 'ekwa-theme-options', 'ekwa_theme_create_page',  get_template_directory_uri().'/settings/images/logo.png', 61);
         
         // generate ekwa admin sub pae header
        add_submenu_page('ekwa-theme-options', 'Blocks', 'Blocks', 'manage_options', 'ekwa-theme-options-blocks', 'ekwa_theme_blocks'); 
        add_submenu_page('ekwa-theme-options', 'Related Articles', 'Related Articles', 'manage_options', 'ekwa-theme-options-related-articles', 'ekwa_theme_related_articles');
        
         
        
    }
    
    add_action('admin_menu', 'ekwa_admin_page');
    
*/
    
    function ekwa_theme_create_page(){
           // echo '<h1 class="ekwa_admin_heading"> Ekwa theme Option </h1>';
            require_once( get_template_directory(). '/settings/dashboard/main-page.php');
            
    }
    
 
    
    function ekwa_theme_related_articles(){
            require_once( get_template_directory(). '/settings/dashboard/related-articles-page.php');
    }
    function ekwa_theme_blocks(){
            require_once( get_template_directory(). '/settings/dashboard/blocks-page.php');
    }
    
    
    

    
    
    /* Equeeing scripts and styles */
    
    function ekwa_load_admin_scripts($hook){
       //echo $hook;
       
       $ekwa_admin_pages = array(
                                 'ekwa-theme_page_ekwa-theme-options',
                                 'ekwa-theme_page_ekwa-theme-options-header',
                                 'ekwa-theme_page_ekwa-theme-options-footer',
                                 'toplevel_page_ekwa-theme-options',
                                 'ekwa-theme_page_ekwa-theme-options-related-articles',
                                 'ekwa-theme_page_ekwa-theme-options-blocks',
                                 );
       /*
        if('toplevel_page_ekwa-theme-options' != $hook){
            return;
        }*/

        
        
        if (!in_array($hook, $ekwa_admin_pages)){
            return;
        }
        wp_register_style('ekwa_admin_bs', get_template_directory_uri().'/settings/dashboard/css/bootstrap.min.css', array(), '1.0.0', 'all');
        wp_register_style('ekwa_admin_fa', get_template_directory_uri().'/settings/dashboard/css/all.min.css', array(), '1.0.0', 'all');
        wp_register_style('ekwa_admin', get_template_directory_uri().'/settings/dashboard/css/style.css', array(), '1.0.0', 'all');
        
        wp_enqueue_style('ekwa_admin_bs');
        wp_enqueue_style('ekwa_admin_fa');
        wp_enqueue_style('ekwa_admin');
        
        
        wp_register_script('ekwa_admin_jquery', get_template_directory_uri().'/settings/dashboard/js/jquery.js', array(), '1.0.0', true);
        wp_register_script('ekwa_admin_bsjs', get_template_directory_uri().'/settings/dashboard/js/bootstrap.min.js', array(), '1.0.0', true);
        wp_register_script('ekwa_admin_pagination', get_template_directory_uri().'/settings/dashboard/js/paginate.js', array('jquery'), '1.0.0', true);
        wp_register_script('ekwa_admin_script', get_template_directory_uri().'/settings/dashboard/js/script.js', array('jquery'), '1.1.1', true);
       
        
        wp_enqueue_script('ekwa_admin_jquery');
        wp_enqueue_script('ekwa_admin_bsjs');
        wp_enqueue_script('ekwa_admin_pagination');
        wp_enqueue_script('ekwa_admin_script');
        
    }
    
    add_action('admin_enqueue_scripts', 'ekwa_load_admin_scripts');


    function ekwa_responsive_editor($hook){

        wp_register_style('ekwa_rs_editor_css', get_template_directory_uri().'/settings/dashboard/css/ekwa-responsive-editor.css', array(), '1.0.0', 'all');
        
        wp_enqueue_style('ekwa_rs_editor_css');
/*
        wp_register_script('ekwa_rs_editor', get_template_directory_uri().'/settings/dashboard/js/editor-responsive.js', array('jquery'), '1.0.0', true);
        wp_enqueue_script('ekwa_rs_editor');*/
    }
    add_action('admin_enqueue_scripts', 'ekwa_responsive_editor');


    function editor_css_setup() {
        // Add support for editor styles.
        add_theme_support( 'editor-styles' );
      // Enqueue editor styles.
      add_editor_style( 'css/critical.css' );
      add_editor_style( 'css/color-variables.css' );
  }
  add_action( 'after_setup_theme', 'editor_css_setup' );

/*

    function myguten_enqueue() {
        wp_enqueue_script(
            'myguten-script',
            get_template_directory_uri().'/settings/dashboard/js/guternb.js'
        );
    }
    add_action( 'enqueue_block_editor_assets', 'myguten_enqueue' );
*/
    
/*********  Header Post type *************/
    
function ekwa_theme_headers_post_type(){
        $labels = array(
                'name' => 'Headers',
                'singular_name' => 'Header',
                'add_new' => 'Add New'
        );
        
        $args = array(
                            'labels' => $labels,
                            'supports'              => array( 'title','editor',),
                            'hierarchical'          => false,
                            'public'                => false,
                            'show_ui'               => true,
                            'show_in_menu'          => true,
                            'menu_position'         => 5,
                            'menu_icon'             => 'dashicons-block-default',
                            'show_in_admin_bar'     => true,
                            'show_in_nav_menus'     => false,
                            'can_export'            => true,
                            'has_archive'           => false,                
                            'exclude_from_search'   => true,
                            'publicly_queryable'    => false,
							'show_in_rest'          => true,
                            'query_var'             => false,
                            'capability_type'       => 'post'
							
               
                            
        );
        register_post_type( 'ekwa_theme_headers', $args );
}

add_action( 'init', 'ekwa_theme_headers_post_type');

/*********  Footer Post type *************/
    
function ekwa_theme_footers_post_type(){
        $labels = array(
                'name' => 'Footers',
                'singular_name' => 'Footer',
                'add_new' => 'Add New'
        );
        
        $args = array(
                            'labels' => $labels,
                            'supports'              => array( 'title','editor',),
                            'hierarchical'          => false,
                            'public'                => false,
                            'show_ui'               => true,
                            'show_in_menu'          => true,
                            'menu_position'         => 5,
                            'menu_icon'             => 'dashicons-block-default',
                            'show_in_admin_bar'     => true,
                            'show_in_nav_menus'     => false,
                            'can_export'            => true,
                            'has_archive'           => false,                
                            'exclude_from_search'   => true,
                            'publicly_queryable'    => false,
							'show_in_rest'          => true,
                            'query_var'             => false,
                            'capability_type'       => 'post'
							
               
                            
        );
        register_post_type( 'ekwa_theme_footers', $args );
}

add_action( 'init', 'ekwa_theme_footers_post_type');

/*********  sidebar Post type *************/
    
    /*
function ekwa_theme_sidebars_post_type(){
        $labels = array(
                'name' => 'Sidebars',
                'singular_name' => 'Sidebar',
                'add_new' => 'Add New'
        );
        
        $args = array(
                            'labels' => $labels,
                            'supports'              => array( 'title','editor',),
                            'hierarchical'          => false,
                            'public'                => false,
                            'show_ui'               => true,
                            'show_in_menu'          => true,
                            'menu_position'         => 5,
                            'menu_icon'             => 'dashicons-block-default',
                            'show_in_admin_bar'     => true,
                            'show_in_nav_menus'     => false,
                            'can_export'            => true,
                            'has_archive'           => false,                
                            'exclude_from_search'   => true,
                            'publicly_queryable'    => false,
							'show_in_rest'          => true,
                            'query_var'             => false,
                            'capability_type'       => 'post'
							
               
                            
        );
        register_post_type( 'ekwa_theme_sidebars', $args );
}

add_action( 'init', 'ekwa_theme_sidebars_post_type');
*/
    
/************************* Create Resources post Type ***************/  
    
    
function ekwa_theme_resources_post_type(){
        $labels = array(
                'name' => 'Theme Resources',
                'singular_name' => 'Theme Resources',
                'add_new' => 'Add New'
        );
        
        $args = array(
                            'labels' => $labels,
                            'supports'              => array( 'title', 'thumbnail',),
                            'hierarchical'          => false,
                            'public'                => false,
                            'show_ui'               => true,
                            'show_in_menu'          => false,
                            'menu_position'         => 5,
                            'menu_icon'             => 'dashicons-images-alt',
                            'show_in_admin_bar'     => false,
                            'show_in_nav_menus'     => false,
                            'can_export'            => true,
                            'has_archive'           => false,                
                            'exclude_from_search'   => true,
                            'publicly_queryable'    => false,
							'show_in_rest'          => true,
                            'query_var'             => false,
                            'capability_type'       => 'post'
							
               
                            
        );
        register_post_type( 'ekwa_theme_resources', $args );
}

add_action( 'init', 'ekwa_theme_resources_post_type');






add_action( 'init', 'ekwa_theme_resources_taxonomy', 30 );
function ekwa_theme_resources_taxonomy() {
 
  $labels = array(
    'name'              => _x( 'Theme Resources categories', 'taxonomy general name' ),
    'singular_name'     => _x( 'Theme Resources category', 'taxonomy singular name' ),
    'search_items'      => __( 'Search Theme Resources category' ),
    'all_items'         => __( 'All Theme Resources categories' ),
    'parent_item'       => __( 'Parent Theme Resources Category' ),
    'parent_item_colon' => __( 'Parent Theme Resources Category:' ),
    'edit_item'         => __( 'Edit Theme Resources Category' ),
    'update_item'       => __( 'Update Theme Resources Category' ),
    'add_new_item'      => __( 'Add New Theme Resources Category' ),
    'new_item_name'     => __( 'New Theme Resources Category Name' ),
    'menu_name'         => __( 'Theme Resources Category' ),
  );
 
  $args = array(
    'hierarchical'          => true,
    'labels'                => $labels,
    'show_ui'               => true,
    'show_admin_column'     => true,
    'query_var'             => true,
    'rewrite'               => array( 'slug' => 'ekwa-theme-resources-category' ),
    'show_in_rest'          => true,
    'rest_base'             => 'ekwa-theme-resources-category',
    'rest_controller_class' => 'WP_REST_Terms_Controller',
  );
 
  register_taxonomy( 'ekwa-theme-resources-category', array( 'ekwa_theme_resources' ), $args );
 
}


function set_default_terms(){

$terms = array('Headers', 'Footers', 'Before after section', 'Related articles sections', 'blocks');
    
    foreach($terms as $term){    
        if( !term_exists( $term, 'ekwa-theme-resources-category' ) ) {
                $slug = sanitize_title(sanitize_title($term, '', 'save'), '', 'query');
                wp_insert_term(
                        $term, // the term 
                        'ekwa-theme-resources-category', // the taxonomy
                        array(
                          'description'=> '',
                          'slug' => $slug                 // what to use in the url for term archive
                        )
                );
        }
        
    }
}

add_action( 'init', 'set_default_terms', 30 );

// setting custom fields to the post type
require_once( get_template_directory(). '/settings/dashboard/acf.php');
    
    
    
    
/************ function retrive list of installed  reserouce ********/    

function get_installed_resources($category){
       
        $args = array(
                'post_type' => 'ekwa_theme_resources',
                'posts_per_page' => -1,
                'tax_query' => array(
                                array(
                                    'taxonomy' => 'ekwa-theme-resources-category',
                                    'field' => 'id',
                                    'terms' => $category
                                )
                        )
        );
        
       $the_query =  new WP_Query($args);
        
       
       if ( $the_query->have_posts() ) {
       
           while ( $the_query->have_posts() ) {
               $the_query->the_post();
               
               $resources[] =
                array(
                      'title' => get_the_title(),
                      'thumbnail' => get_field('theme_resource_thumbnail_url'),
                      'id' => get_field('theme_resource_id'),
                      'json_file' => get_field('json_file'),
                      'block_slug' => get_field('block_slug'),
                      'block_name' => get_field('block_name'),
                      'post_id' => get_the_ID()
    
                );
           }
       }else{
        
          $resources = array();
        } 
       
       wp_reset_postdata();
       
       return $resources;
        
}
    
    

    
    
/**#################### Admin  Ajax Functions *************/
  

    
// inserting into the  resources post type


function insert_new_resource($resourceID, $categoryID, $thumbUrl,$acfJsonFileName, $resourceName, $blockName) {
	global $user_ID;
    if($blockName == 'no-acf-block'){
        $pTitle = 'template-'.$resourceID;
    }else{
        $pTitle = $blockName.'-'.$resourceID;
    }
    
	$new_post = array(
		'post_title' => $pTitle,
		'post_status' => 'publish',
		'post_date' => date('Y-m-d H:i:s'),
		'post_author' => $user_ID,
		'post_type' => 'ekwa_theme_resources',
        'tax_input'    => array(
            'ekwa-theme-resources-category' => array( $categoryID ),
        ),
	);
    $post_id = wp_insert_post($new_post);
    
    $term = get_term_by('term_id', $categoryID, 'ekwa-theme-resources-category');
    $resource_category = $term->slug;
    /*
    if($acfJsonFileName != 'no-file-name'){
        $acfJsonFileName = pathinfo($acfJsonFileName, PATHINFO_FILENAME);
        $acfJsonFileName = $filename.".json";
    }*/
    
    update_field( 'theme_resource_id', $resourceID, $post_id );
    update_field( 'theme_resource_thumbnail_url', $thumbUrl, $post_id );
    update_field( 'theme_resource_category', $resource_category, $post_id );
    update_field( 'json_file', $acfJsonFileName, $post_id );
    update_field( 'block_name', $resourceName, $post_id );
    update_field( 'block_slug', $blockName, $post_id );
	return $post_id;
}



add_action('wp_ajax_nopriv_delete_resource', 'delete_resource');
add_action('wp_ajax_delete_resource', 'delete_resource');

function delete_resource(){
        
        $postID = $_POST['post_id'];
        $directory  = $_POST['directory'];
        $resourceID = $_POST['resource_id'];
        $jsonFile = $_POST['json_file'];
        $blockSlug = $_POST['block_slug'];
        
        if(wp_delete_post($postID)){
                
                if($blockSlug == 'no-acf-block'){
                    $template_dir  = get_template_directory().'/template-parts/'.$directory.'/template-'.$resourceID.'/';
                }else{
                    $template_dir  = get_template_directory().'/template-parts/'.$directory.'/'.$blockSlug.'-'.$resourceID.'/';
                }
                
                
                
                
                WP_Filesystem();
                global $wp_filesystem;
                $wp_filesystem->rmdir($template_dir, true);
                echo "deleted";
                if($jsonFile != "no-file-name"){
                $jsonFile = pathinfo($jsonFile, PATHINFO_FILENAME);
                $jsonFile = $jsonFile.".json";
                $jsonFile = get_template_directory().'/acf-json/'.$jsonFile;
                
                        WP_Filesystem_Direct::delete($jsonFile, false, 'f');
                }
                
                
        }
   die();
}
    
    

//downloading and moving to relevent folder 
    
add_action('wp_ajax_nopriv_download_resources', 'download_resources');
add_action('wp_ajax_download_resources', 'download_resources');



function download_resources(){
    
   $downloadLink = $_POST['downloadLink'];
   $resourcesID = $_POST['id'];
   $resourcesType = $_POST['resourceType'];
   $resourceCategory = $_POST['resourceCategory'];
   $thumbUrl = $_POST['thumbUrl'];
   $downloadDirectory = $_POST['downloadDirectory'];
   $acfJsonFile = $_POST['dataJson'];
   $acfJsonFileName = $_POST['dataJsonFile'];
   $resourceName = $_POST['resourcesName'];
   $blockName = $_POST['blockName'];
   
        
        // download and unzip  json file 
        if($acfJsonFile != 'no-file'){
                
                $new_path = get_template_directory().'/acf-json/';
                if (!file_exists($new_path)) {
                    mkdir($new_path, 0755, true);
                }
                
                
                $permfile = get_template_directory().'/acf-json/'.$acfJsonFileName;
                $url = $acfJsonFile;
                $tmpfile = download_url( $url, $timeout = 300 );
                
                if(copy( $tmpfile, $permfile )){
                        
                        
                        WP_Filesystem();
                        $unzipfile = unzip_file( $permfile, $new_path);
                    
                        if (! $unzipfile ) {
                             echo 'error unziping file';   
                        }else{
                                unlink($permfile);
                        }
                 
                   $lastID = insert_new_resource($resourcesID, $resourceCategory, $thumbUrl, $acfJsonFileName, $resourceName, $blockName);
                    echo $lastID;
        
                }else{
                    echo 'unsuccessful';
                }
                
                unlink( $tmpfile );
                
                // download and unzip resources file of acf
                
                 $new_path = get_template_directory().'/template-parts/'.$downloadDirectory.'/'.$blockName.'-'.$resourcesID.'/';
                if (!file_exists($new_path)) {
                    mkdir($new_path, 0755, true);
                }
                
                
                $permfile = get_template_directory().'/template-parts/'.$downloadDirectory.'/'.$blockName.'-'.$resourcesID.'/'.'block.zip';
                $url = $downloadLink;
                $tmpfile = download_url( $url, $timeout = 300 );
                
                if(copy( $tmpfile, $permfile )){
                        
                        
                        WP_Filesystem();
                        $unzipfile = unzip_file( $permfile, $new_path);
                    
                        if (! $unzipfile ) {
                             echo 'error unziping file';   
                        }else{
                                unlink($permfile);
                        }
                 
                    //echo 'done';/
                    /*
                    $lastID = insert_new_resource($resourcesID, $resourceCategory, $thumbUrl, $acfJsonFileName);
                    echo $lastID;*/
        
                }else{
                    echo 'unsuccessful';
                }
                
                unlink( $tmpfile );
                
                
                
                
                
        }else{
                 $new_path = get_template_directory().'/template-parts/'.$downloadDirectory.'/template-'.$resourcesID.'/';
                if (!file_exists($new_path)) {
                    mkdir($new_path, 0755, true);
                }
                
                $permfile = get_template_directory().'/template-parts/'.$downloadDirectory.'/template-'.$resourcesID.'/'.'header.zip';
                $url = $downloadLink;
                $tmpfile = download_url( $url, $timeout = 300 );
                
                if(copy( $tmpfile, $permfile )){
                        
                        
                        WP_Filesystem();
                        $unzipfile = unzip_file( $permfile, $new_path);
                    
                        if (! $unzipfile ) {
                             echo 'error unziping file';   
                        }else{
                                unlink($permfile);
                        }
                 
                    //echo 'done';
                    $lastID = insert_new_resource($resourcesID, $resourceCategory, $thumbUrl, $acfJsonFileName, $resourceName, $blockName);
                    echo $lastID;
        
                }else{
                    echo 'unsuccessful';
                }
                
                unlink( $tmpfile );
        }
        // download and unzip json file  end 

    
    die();
}
    
 

 
add_action( 'admin_enqueue_scripts', 'ekwa_admin_style');
function ekwa_admin_style() {
  wp_enqueue_style( 'admin-fa-style', get_stylesheet_directory_uri() . '/plugins/fontawesome/css/all.min.css' );
  wp_enqueue_style( 'admin-bootstap-style', get_stylesheet_directory_uri() . '/layouts/bootstrap/css/bootstrap.css' );
  wp_enqueue_style( 'admin-bootstap-carousel', get_stylesheet_directory_uri() . '/layouts/bootstrap/css/carousel.css' );
  wp_enqueue_style( 'admin-card-style', get_stylesheet_directory_uri() . '/layouts/bootstrap/css/card.css' );
  wp_enqueue_style( 'admin-tab-style', get_stylesheet_directory_uri() . '/layouts/bootstrap/css/tab.css' );
}
 
 
 

function enqueue_ekwa_admin_scripts() {
   wp_enqueue_script('admin-lazysizes', get_template_directory_uri().'/js/lazysizes.js', array(), '1.0.0', true);
  // wp_enqueue_script('admin-bs-carousel', get_template_directory_uri().'/layouts/bootstrap/js/carousel.js', array(), '1.0.0', true);
}
add_action( 'admin_enqueue_scripts', 'enqueue_ekwa_admin_scripts' );


