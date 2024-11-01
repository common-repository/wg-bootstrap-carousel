<?php
add_action('init', 'wgbc_carousels');

function wgbc_carousels(){

    $wgbc_carousels_lables = array(
        'name' => __('WGBC Carousels', 'WGBC'),
        'singular_name' => __('WGBC Carousel', 'w_dalil', 'WGBC'),
        'add_new' => __('Add New WGBC Carousel', 'WGBC'),
        'add_new_item' => __('Add New WGBC Carousel', 'WGBC'),
        'edit_item' => __('Edit WGBC Carousel', 'WGBC'),
        'new_item' => __('Add New WGBC Carousel', 'WGBC'),
        'all_items' => __('View WGBC Carousels', 'WGBC'),
        'view_item' => __('View WGBC Carousel', 'WGBC'),
        'search_items' => __('Search WGBC Carousels', 'WGBC'),
        'not_found' =>  __('No Items found', 'WGBC'),
        'not_found_in_trash' => __('No Items found in Trash', 'WGBC'),
        'parent_item_colon' => '',
        'menu_name' =>  __('WGBC Carousels', 'WGBC')
    );

    $wgbc_carousels = array(
        'labels' => $wgbc_carousels_lables,
        'public' => true,
        'query_var' => true,
        'rewrite' =>  array( 'slug' => 'wgbc-carousel' ),
        'capability_type' => 'post',
        'has_archive' => false,
        'hierarchical' => true,
        'map_meta_cap' => true,
        'menu_position' => null,
        'supports' => array('title')
    );

  register_post_type('wgbc_carousels', $wgbc_carousels);

}