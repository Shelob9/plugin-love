<?php
/*
Plugin Name: Plugin-love
Version: 0.1-alpha
Description: PLUGIN DESCRIPTION HERE
Author: YOUR NAME HERE
Author URI: YOUR SITE HERE
Plugin URI: PLUGIN SITE HERE
Text Domain: plugin-love
Domain Path: /languages
*/

define( 'PLUGIN_LOVE_DIR', dirname( __FILE__ ) );
if( is_admin() ) {
	add_action( 'admin_init', 'plugin_love_init' );
}

function plugin_love_init(){
	include_once( dirname( __FILE__ ) . '/Rating_Log.php' );
	include_once( dirname( __FILE__ ) . '/Rating_Choice.php' );

}
