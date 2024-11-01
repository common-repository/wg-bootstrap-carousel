<?php

function wg_bootstrap_update_edit_form() {
    echo ' enctype="multipart/form-data"';
}
add_action('post_edit_form_tag', 'wg_bootstrap_update_edit_form');

function wg_bootstrap_enqueue(){
    wp_enqueue_script( 'wgbc-jquery' , "//code.jquery.com/jquery-1.10.2.js" );
    wp_enqueue_style('wg_bootstrap_enqueue-bootstrap-css', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css');
    wp_enqueue_style('wg_bootstrap_enqueue-bootstrap-csstheme', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css');
    wp_enqueue_script('wg_bootstrap_enqueue-bootstrap-js', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js',  array( 'jquery' ));
}
add_action('wp_enqueue_scripts','wg_bootstrap_enqueue');

function wg_bootstrap_jscripts()
{
    $screen = get_current_screen();
    if("wgbc_carousels" == $screen->post_type ){
        wp_enqueue_script( 'wgbc-jquery' , "//code.jquery.com/jquery-1.10.2.js" );
        wp_enqueue_script( 'wgbc-jquery_ui' , "//code.jquery.com/ui/1.11.4/jquery-ui.js" );
        wp_enqueue_script( 'wgbc-script' , WGBCURL . '/scripts/wgbc.js' ,'jquery');
    }
}
add_action( 'admin_head', 'wg_bootstrap_jscripts', 15 );

function wg_bootstrap_dir( $dirs ) {
    $dirs['subdir'] = '/wgbc';
    $dirs['path'] = $dirs['basedir'] . '/wgbc';
    $dirs['url'] = $dirs['baseurl'] . '/wgbc';

    return $dirs;
}

function WGBC_admin_notice__error() {
	$class = 'notice notice-error';
	$message = __( 'Make sure All files are less than the upload max size', 'WGBC' );
	printf( '<div class="%1$s"><p>%2$s</p></div>', $class, $message ); 
}


function wg_bootstrap_table_head( $defaults ) {
    $defaults['title']  = 'Title';
    $defaults['shortcode']  = 'ShortCode';
    return $defaults;
}
add_filter('manage_wgbc_carousels_posts_columns', 'wg_bootstrap_table_head');

function wg_bootstrap_custom_column_content( $column, $post_id ) {
    global $post;

    switch( $column ) {

        case 'shortcode' :
            $wgbc_slides = get_post_meta( $post->ID );
            $wgbc_options = unserialize($wgbc_slides['options'][0]);
            echo "[show-wgbc name='".get_the_title( $post_id )."'";
            if(isset($wgbc_options['id']) && $wgbc_options['id'] != '' ){
                echo " id='".$wgbc_options['id']."'";
            }
            if(isset($wgbc_options['time']) && $wgbc_options['time'] != '' ){
                echo " interval='".$wgbc_options['time']."'";
            }
            echo " ]";
            break;
        default :
            break;
    }
}
add_action( 'manage_wgbc_carousels_posts_custom_column', 'wg_bootstrap_custom_column_content', 10, 2 );