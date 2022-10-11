<?php
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
		'taxonomies'          => array( 'category' )
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
    // Display code/markup goes here. Don't forget to include nonces!
    // Add an nonce field so we can check for it later.
  	wp_nonce_field( 'myplugin_inner_custom_box_price_list', 'myplugin_inner_custom_box_price_list_nonce' );

    $arr_meta = arr_agent_metabox();   
    temp_template_metabox($arr_meta, $post);
}










 
/**
 * Save meta box content.
 *
 * @param int $post_id Post ID
 */
function wpdocs_save_meta_box_agent( $post_id ) {
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

	$arr_meta = arr_agent_metabox() ;
	foreach ($arr_meta as $key => $title) {
		$value_meta = sanitize_text_field( $_POST[$key] );
		update_post_meta( $post_id, $key, $value_meta);
	}
}
add_action( 'save_post', 'wpdocs_save_meta_box_agent' );

function arr_agent_metabox(){
	$start = 1990;
	$end = date('Y');
	$year = array();
	for($i=$start; $i<=$end; $i++){
		$year[$i] = $i;
	}

	$arr_meta = array(
						'phone'=> array('type'=>'text','title'=>'Phone'),
						'year'=> array(	'type'=>'select','title' => 'Joined on','option'=> $year,'lbl_front'=>''),
						'address' => array('type'=>'textarea','title'=>'Address')
					);					
	return $arr_meta;
}


?>