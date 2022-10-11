<?php 
/**
 * Plugin Name: Countries
 * Plugin URI: http://www.locografis.com/
 * Description: Plugins countries management Locografis
 * Version: 1.0
 * Author URI: http://www.locografis.com/
 * Author : Adi Juliartha
 */
if ( ! class_exists( 'WP_List_Table' ) ) {
	require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

require_once('country.php');
require_once('state.php');
require_once('city.php');
?>