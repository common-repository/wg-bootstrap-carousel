<?php
/**
Plugin Name: WG Bootstarp Carousel
Text Domain: WGBC
Description: Simple plugin to make carosuels based on boostrap and include it any where in your theme by shortcode. you can custom the style for each one . it defined by ID.
Author: Ghiath Alkhaled
Version: 1.5
Author URI: http://facebook.com/iyass.si
*/


define( 'WGBCDIR' , plugin_dir_path(  __FILE__ ) );
define( 'WGBCURL' , plugin_dir_url(  __FILE__ ) );
define( 'WGBC_INCLUDES' , plugin_dir_path(  __FILE__ ).'includes/' );


function wgbc_textdomain() {
  load_plugin_textdomain( 'WGBC', false, plugin_basename( dirname( __FILE__ ) ) . '/languages' );
}
add_action( 'plugins_loaded', 'wgbc_textdomain' );

require_once(WGBC_INCLUDES . 'wgbc-functions.php');
require_once(WGBC_INCLUDES . 'wgbc-shortcodes.php');
require_once(WGBC_INCLUDES . 'wgbc-metabox.php');
require_once(WGBC_INCLUDES . 'wgbc-init.php');


