<?php
/*function delete_post_type(){
unregister_post_type( 'faq' );
}
add_action('init','delete_post_type');*/


add_action( 'init', 'create_post_type_faq' );
function create_post_type_faq() {
	$name = 'FAQ';
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
		'label'               => __( 'faq', 'text_domain' ),
		'description'         => __( $name.' information pages', 'text_domain' ),
		'labels'              => $labels,
		'supports' => array( 'title', 'editor', 'thumbnail' ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_icon'           => 'dashicons-format-status',
		'menu_position'       => 5,
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'post'
		//'taxonomies'          => array()
	);
	add_theme_support( 'post-thumbnails' );
	//add_theme_support( 'post-thumbnails', array( 'post','gallery') );
	
	register_post_type('faq', $args);	
}



function create_faq_taxonomies() {
    $labels = array(
        'name'              => _x( 'Categories', 'taxonomy general name' ),
        'singular_name'     => _x( 'Category', 'taxonomy singular name' ),
        'search_items'      => __( 'Search Categories' ),
        'all_items'         => __( 'All Categories' ),
        'parent_item'       => __( 'Parent Category' ),
        'parent_item_colon' => __( 'Parent Category:' ),
        'edit_item'         => __( 'Edit Category' ),
        'update_item'       => __( 'Update Category' ),
        'add_new_item'      => __( 'Add New Category' ),
        'new_item_name'     => __( 'New Category Name' ),
        'menu_name'         => __( 'Categories' ),
    );

    $args = array(
        'hierarchical'      => true, // Set this to 'false' for non-hierarchical taxonomy (like tags)
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'faq-categories' ),
    );

    register_taxonomy( 'faq_cat', array( 'faq' ), $args );
}
add_action( 'init', 'create_faq_taxonomies', 0 );


/*
add_action( 'template_redirect', 'slt_theme_filter_404', 0 );
function slt_theme_filter_404() {
    global $wp_query, $post;
    //print_r($wp_query);
    if ( $wp_query->post_count == 0 && $wp_query->query_vars['taxonomy'] == 'faq_cat' ) {
        $wp_query->is_404 = false;
        $wp_query->is_archive = true;
        $wp_query->is_post_type_archive = true;
        $post = new stdClass();
        $post->post_type = $wp_query->query['post_type'];

        echo 'fasfa';
    }
}

*/


if ( ! is_admin() )
    add_filter( 'pre_get_posts', 'slt_archive_listing_filters' );
function slt_archive_listing_filters( $query ) {
    // Theme filtering
   //if ( is_archive() && isset( $_REQUEST['locality_theme'] ) ) {echo 'fasfa';
	/*if(is_faq_cat()){
		$url = site_url().'/';
		$current_url = home_url(add_query_arg(array(),$wp->request));
		$path = str_replace($url, "", $current_url);
		$path = explode('/',$path);	



        $query->set( 'tax_query',  array( array(
            'taxonomy'  => 'faq_cat',
            'field'     => 'id',
            'terms' => $path[1]
        )));
    }
    return $query;*/
}


//add_action( 'template_redirect', 'slt_theme_filter_404_faq', 0 );
function slt_theme_filter_404_faq() {
    global $wp_query, $post;

    //print_r($wp_query);
    if ( $wp_query->post_count == 0 && is_faq_cat() ) {
        $wp_query->is_404 = false;
        $wp_query->is_archive = true;
        $wp_query->is_post_type_archive = true;
        $post = new stdClass();
        $post->post_type = $wp_query->query['post_type'];

        get_template_part('taxonomy','faq_cat');
    }
}


function is_faq_cat(){ 
	global $wp;
	$url = site_url().'/';
	$current_url = home_url(add_query_arg(array(),$wp->request));
	$path = str_replace($url, "", $current_url);
	$path = explode('/',$path);
print_r($path);	
	if($path[0]=='faq-categories' && !empty($path[1])){
		//
		$taxonomy_objects = get_object_taxonomies( 'faq', $path[1] );
		//echo $path[1];
		$term = get_term_by('slug', $path[1], 'faq_cat');

		if(!empty($term)) {
			set_query_var( 'term', $term);
			return true;
		}
	}
	
	//echo $path;
}



function title_faq( $title ){
     $screen = get_current_screen();
     if  ( 'faq' == $screen->post_type ) {
          $title = 'Enter question name here';
     } 
     return $title;
}
add_filter( 'enter_title_here', 'title_faq' );

add_filter('pll_get_post_types', 'my_pll_get_post_faq');
function my_pll_get_post_faq($types) {
	return array_merge($types, array('faq' => 'faq'));	
}


function setting_field_faq(){
	/**
	 * Class for adding a new field to the options-reading.php page
	 */
	class Add_Settings_Field_faq {

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
			register_setting( 'reading', 'faq_view_val', 'esc_attr' );
			add_settings_field(
				'faq_view',
				'<label for="faq_view">' . __( 'faq pages show at most' , 'faq_view_val' ) . '</label>',
				array( $this, 'fields_html' ),
				'reading'
			);
		}

		/**
		 * HTML for extra settings
		 */
		public function fields_html() {
			$value = get_option( 'faq_view_val', '' );
			echo '<input type="number" id="faq_view" name="faq_view_val" value="' . esc_attr( $value ) . '" class="small-text"/> items';
		}

	}
	new Add_Settings_Field_faq();	
	
}
add_action( 'init', 'setting_field_faq' );



/**
 * Register meta box(es).
 */
function wpdocs_register_meta_boxes_faq() {
	$screens = array('faq');
    foreach ( $screens as $screen ) {
    	add_meta_box( 'meta-box-id-'.$screen, __( 'Additional Field', 'textdomain' ), 'wpdocs_my_display_callback_faq', $screen );	
    }
}
add_action( 'add_meta_boxes_faq', 'wpdocs_register_meta_boxes_faq' );
 
/**
 * Meta box display callback.
 *
 * @param WP_Post $post Current post object.
 */
function wpdocs_my_display_callback_faq( $post ) {
    // Display code/markup goes here. Don't forget to include nonces!
    // Add an nonce field so we can check for it later.
  	wp_nonce_field( 'myplugin_inner_custom_box_price_list', 'myplugin_inner_custom_box_price_list_nonce' );
    
    //$arr_meta = arr_theme_metabox();   
    temp_template_metabox($arr_meta, $post);
}
 
/**
 * Save meta box content.
 *
 * @param int $post_id Post ID
 */
function wpdocs_save_meta_box_faq( $post_id ) {
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

	
	//$arr_meta = arr_theme_metabox() ;
	foreach ($arr_meta as $key => $title) {
		$value_meta = sanitize_text_field( $_POST[$key] );
		update_post_meta( $post_id, $key, $value_meta);
	}
}
add_action( 'save_post', 'wpdocs_save_meta_box_faq' );

function arr_theme_metabox_old(){
	$arr_meta = array(
						'brief'=> array('type'=>'text','title'=>'Brief')
					);					
	return $arr_meta;
}





?>