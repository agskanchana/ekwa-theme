<?php

function ekwa_before_after_post_type(){
        $labels = array(
                'name' => 'Before After',
                'singular_name' => 'Before After',
                'add_new' => 'Add New'
        );

        $args = array(
                            'labels' => $labels,
                            'supports'              => array( 'title', 'thumbnail',),
                            'hierarchical'          => false,
                            'public'                => false,
                            'show_ui'               => true,
                            'show_in_menu'          => true,
                            'menu_position'         => 5,
                            'menu_icon'             => 'dashicons-images-alt',
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
        register_post_type( 'ekwa_before_after', $args );
}

add_action( 'init', 'ekwa_before_after_post_type');




add_action( 'init', 'ekwa_ba_taxonomy', 30 );
function ekwa_ba_taxonomy() {

  $labels = array(
    'name'              => _x( 'Before after categories', 'taxonomy general name' ),
    'singular_name'     => _x( 'Before after category', 'taxonomy singular name' ),
    'search_items'      => __( 'Search Before after category' ),
    'all_items'         => __( 'All Before after categories' ),
    'parent_item'       => __( 'Parent Before after Category' ),
    'parent_item_colon' => __( 'Parent Before after Category:' ),
    'edit_item'         => __( 'Edit Before after Category' ),
    'update_item'       => __( 'Update Before after Category' ),
    'add_new_item'      => __( 'Add New Before after Category' ),
    'new_item_name'     => __( 'New Before after Category Name' ),
    'menu_name'         => __( 'Before after Category' ),
  );

  $args = array(
    'hierarchical'          => true,
    'labels'                => $labels,
    'show_ui'               => true,
    'show_admin_column'     => true,
    'query_var'             => true,
    'rewrite'               => array( 'slug' => 'before-after-category' ),
    'show_in_rest'          => true,
    'rest_base'             => 'before-after-category',
    'rest_controller_class' => 'WP_REST_Terms_Controller',
  );

  register_taxonomy( 'before-after-category', array( 'ekwa_before_after' ), $args );

}