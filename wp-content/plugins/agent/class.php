<?php 
/*
Plugin Name: Agent 
Plugin URI: http://www.locografis.com
Description: Simple Agent admin from Loco Grafis
Author: Adi Juliartha
Author URI: http://www.locografis.com 
Version: 1.0.0/
*/

require_once('template.php');

//************** START DB *************//
global $agent_db_version;
$agent_db_version = '1.0';

function agent_install() {
	global $wpdb;
	global $agent_db_version;

	$table_name = $wpdb->prefix . 'agent_detail';
	
	$charset_collate = $wpdb->get_charset_collate();

	$sql = "CREATE TABLE $table_name (
		ID bigint(20) NOT NULL,
		address tinytext NOT NULL,
		longitude tinytext NOT NULL,
		latitude tinytext NOT NULL,
		country tinytext NOT NULL,
		city tinytext NOT NULL,
		PRIMARY KEY  (id)
	) $charset_collate;";

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );

	add_option( 'agent_db_version', $agent_db_version );
}

register_activation_hook( __FILE__, 'agent_install' );

//************** END DB *************//

add_action( 'init', 'create_post_type_agent' );
function create_post_type_agent() {
	$name = 'Agent';
	$labels = array(
		'name'                => _x( $name, 'Post Type General Name', 'text_domain' ),
		'singular_name'       => _x( $name, 'Post Type Singular Name', 'text_domain' ),
		'menu_name'           => __( $name, 'text_domain' ),
		'parent_item_colon'   => __( 'Parent '.$name.':', 'text_domain' ),
		'all_items'           => __( 'All '.$name, 'text_domain' ),
		'view_item'           => __( 'View '.$name, 'text_domain' ),
		'add_new_item'        => __( 'Add New '.$name, 'text_domain' ),
		'add_new'             => __( 'Add New', 'text_domain' ),
		'edit_item'           => __( 'Edit '.$name, 'text_domain' ),
		'update_item'         => __( 'Update '.$name, 'text_domain' ),
		'search_items'        => __( 'Search '.$name, 'text_domain' ),
		'not_found'           => __( 'No '.$name.' found', 'text_domain' ),
		'not_found_in_trash'  => __( 'No '.$name.' found in Trash', 'text_domain' ),
	);
	$args = array(
		'label'               => __( 'agent', 'text_domain' ),
		'description'         => __( $name.' information pages', 'text_domain' ),
		'labels'              => $labels,
		'supports' => array( 'title', 'editor', 'thumbnail' ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_icon'           => 'dashicons-admin-users',
		'menu_position'       => 5,
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'post',
		'taxonomies'          => array( )
	);
	add_theme_support( 'post-thumbnails' );
	//add_theme_support( 'post-thumbnails', array( 'post','gallery') );
	
	register_post_type('agent', $args);	
}

function title_agent( $title ){
     $screen = get_current_screen();
     if  ( 'agent' == $screen->post_type ) {
          $title = 'Enter agent name here';
     } 
     return $title;
}
add_filter( 'enter_title_here', 'title_agent' );

add_filter('pll_get_post_types', 'my_pll_get_post_agent');
function my_pll_get_post_agent($types) {
	return array_merge($types, array('agent' => 'agent'));	
}


function setting_field_agent(){
	/**
	 * Class for adding a new field to the options-reading.php page
	 */
	class Add_Settings_Field_agent {

		/**
		 * Class constructor
		 */
		public function __construct() {
			add_action( 'admin_init' , array( $this , 'register_fields' ) );
		}

		/**
		 * Add new fields to wp-admin/options-reading.php page
		 */
		public function register_fields() {
			register_setting( 'reading', 'agent_view_val', 'esc_attr' );
			add_settings_field(
				'agent_view',
				'<label for="agent_view">' . __( 'agent pages show at most' , 'agent_view_val' ) . '</label>',
				array( $this, 'fields_html' ),
				'reading'
			);
		}

		/**
		 * HTML for extra settings
		 */
		public function fields_html() {
			$value = get_option( 'agent_view_val', '' );
			echo '<input type="number" id="agent_view" name="agent_view_val" value="' . esc_attr( $value ) . '" class="small-text"/> items';
		}

	}
	new Add_Settings_Field_agent();	
	
}
add_action( 'init', 'setting_field_agent' );



/**
 * Register meta box(es).
 */
function wpdocs_register_meta_boxes_agent() {
	$screens = array('agent');
    foreach ( $screens as $screen ) {
    	add_meta_box( 'meta-box-id-'.$screen, __( 'Additional Field', 'textdomain' ), 'wpdocs_my_display_callback_agent', $screen );	
    }
}
add_action( 'add_meta_boxes_agent', 'wpdocs_register_meta_boxes_agent' );
 
/**
 * Meta box display callback.
 *
 * @param WP_Post $post Current post object.
 */
function wpdocs_my_display_callback_agent( $post ) {
	global $wpdb;
    // Display code/markup goes here. Don't forget to include nonces!
    // Add an nonce field so we can check for it later.
  	wp_nonce_field( 'myplugin_inner_custom_box_price_list', 'myplugin_inner_custom_box_price_list_nonce' );


  	$dt = array();

  	$q = $wpdb->prepare("select * from {$wpdb->prefix}agent_detail WHERE ID = %s", $post->ID);
	$dt = $wpdb->get_results($q, 'ARRAY_A');

  	temp($dt[0]);
  	//print_r($dt);
}


/**
 * Save meta box content.
 *
 * @param int $post_id Post ID
 */
function wpdocs_save_meta_box_agent( $post_id ) {
	global $wpdb;

    // Save logic goes here. Don't forget to include nonce checks!
    if ( ! isset( $_POST['myplugin_inner_custom_box_price_list_nonce'] ) )return $post_id;  
	$nonce = $_POST['myplugin_inner_custom_box_price_list_nonce'];  
	if (! wp_verify_nonce( $nonce, 'myplugin_inner_custom_box_price_list' ))return $post_id;
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )  return $post_id;

	// Check the user's permissions.
	if ( 'price-list' == $_POST['post_type'] ) {
	if ( ! current_user_can( 'edit_page', $post_id ) ) return $post_id;
	} else { 
		if ( ! current_user_can( 'edit_post', $post_id ) ) return $post_id;
	}

	$meta_ids = $wpdb->get_col( $wpdb->prepare( "SELECT ID FROM {$wpdb->prefix}agent_detail WHERE ID = %s", $post_id ) );
	if ( empty( $meta_ids ) ) {
		$q = $wpdb->prepare("insert into {$wpdb->prefix}agent_detail (ID, id_country, id_state, id_city, account_facebook, phone ) values 
																		(%d, %d, %d, %d, %s, %s)",
																		$post_id, $_POST['country'], $_POST['province'], $_POST['city'], $_POST['account_facebook'], $_POST['phone']);
	}else{
		$q = $wpdb->prepare("update {$wpdb->prefix}agent_detail set id_country=%d, id_state=%d, id_city=%d, account_facebook=%s, phone=%s
									where ID=%s",
									$_POST['country'], $_POST['province'], $_POST['city'], $_POST['account_facebook'], $_POST['phone'],
									$post_id);
	}
	$r = $wpdb->query($q);
}
add_action( 'save_post', 'wpdocs_save_meta_box_agent' );

/**
 * Delete meta box content.
 *
 * @param int $pid Post ID
 */

function codex_agent_sync( $pid ) {
    global $wpdb;

    if ( $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM {$wpdb->prefix}agent_detail WHERE ID = %d", $pid ) ) ) {
        $wpdb->query( $wpdb->prepare( "DELETE FROM {$wpdb->prefix}agent_detail WHERE ID = %d", $pid ) );
    }
}
add_action( 'delete_post', 'codex_agent_sync');





add_action( 'wp_ajax_nopriv_get-province-now', 'get_province' );
add_action( 'wp_ajax_get-province-now', 'get_province' );

function get_province(){
	global $wpdb;

	$q = $wpdb->prepare("select id_state id, state from {$wpdb->prefix}state where id_country=%d order by state",$_POST['id']); //echo $q;
	$pp = $wpdb->get_results($q,'ARRAY_A');

	$r = array('status'=>'empty');

	if(!empty($pp)){
		$r['status'] = 'success';
		$r['dt'] = $pp;
	}


	echo json_encode($r);
	//print_r($pp);
	die();
}


add_action( 'wp_ajax_nopriv_get-city-now', 'get_city' );
add_action( 'wp_ajax_get-city-now', 'get_city' );

function get_city(){
	global $wpdb;

	$q = $wpdb->prepare("select id_city id, city from {$wpdb->prefix}city where id_state=%d order by city",$_POST['id']); //echo $q;
	$pp = $wpdb->get_results($q,'ARRAY_A');

	$r = array('status'=>'empty');

	if(!empty($pp)){
		$r['status'] = 'success';
		$r['dt'] = $pp;
	}


	echo json_encode($r);
	//print_r($pp);
	die();
}




add_action( 'wp_ajax_nopriv_get-agent-now', 'get_agent' );
add_action( 'wp_ajax_get-agent-now', 'get_agent' );

function get_agent(){
	global $wpdb;

	$country 	= $_POST['country'];
	$state 		= $_POST['state'];
	$city 		= $_POST['city'];
	
	if(empty($city)){
		$qc = $wpdb->prepare("select b.ID, b.post_title name, a.account_facebook, a.phone, c.country, d.state, e.city from {$wpdb->prefix}agent_detail a 
							inner join {$wpdb->prefix}posts b on a.ID=b.ID 
							inner join {$wpdb->prefix}country c on a.id_country=c.id_country
							inner join {$wpdb->prefix}state d on a.id_state=d.id_state
							inner join {$wpdb->prefix}city e on a.id_city=e.id_city
							where b.post_status=%s and a.id_country=%d and a.id_state=%s order by e.city","publish",$country,$state);
	}else{
		$qc = $wpdb->prepare("select b.ID, b.post_title name, a.account_facebook, a.phone, c.country, d.state, e.city from {$wpdb->prefix}agent_detail a 
							inner join {$wpdb->prefix}posts b on a.ID=b.ID 
							inner join {$wpdb->prefix}country c on a.id_country=c.id_country
							inner join {$wpdb->prefix}state d on a.id_state=d.id_state
							inner join {$wpdb->prefix}city e on a.id_city=e.id_city
							where b.post_status=%s and a.id_country=%d and a.id_state=%s and a.id_city=%d  order by e.city","publish",$country,$state,$city);

	}


	$cc = $wpdb->get_results($qc, 'ARRAY_A');
	

	$arr = array();
	foreach ($cc as $key => $c) {

		$curr_country = $c['country'];
		$curr_state =  $c['state'];
		$curr_city =  $c['city'];
		/*if(!isset($arr[$curr_country])) $arr[$curr_country] = array();
		if(!isset($arr[$curr_country][$curr_city] )) $arr[$curr_country][$curr_city] = array();*/
		if(!isset($arr['data'])) $arr['data'] = array();
		if(!isset($arr['data'][$curr_city] )) $arr['data'][$curr_city] = array();


		$arr['name'] = $c['state'].' - '.$c['country'];

		$image = wp_get_attachment_image_src( get_post_thumbnail_id($c['ID'] ),'full');
		$c['image'] = $image[0];
		array_push($arr['data'][$curr_city],$c);	
	}


	$r = array('status'=>'empty');

	if(!empty($arr)){
		$r['status'] = 'success';
		$r['dt'] = $arr;
	}


	//echo json_encode($r);

	/*$arr = array();
	foreach ($cc as $key => $c) {
		$country = $c['country'];
		$city =  $c['city'];
		if(!isset($arr[$country])) $arr[$country] = array();
		if(!isset($arr[$country][$city] )) $arr[$country][$city] = array();


		$image = wp_get_attachment_image_src( get_post_thumbnail_id($c['ID'] ),'full');
		//print_r($image) ;
		$c['image'] = $image[0];
		array_push($arr[$country][$city],$c);	
	}*/


	
	/*$q = $wpdb->prepare("select id_city id, city from {$wpdb->prefix}city where id_state=%d",$_POST['id']); //echo $q;
	$pp = $wpdb->get_results($q,'ARRAY_A');

	$r = array('status'=>'empty');

	if(!empty($pp)){
		$r['status'] = 'success';
		$r['dt'] = $pp;
	}*/


	echo json_encode($r);
	//print_r($pp);
	die();
}





require_once('favorite-area.php');

?>