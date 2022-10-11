<?php
/**
 * Register meta box(es).
 */

function wpdocs_register_meta_boxes_blog() {
	$screens = array('post');
    foreach ( $screens as $screen ) {
    	add_meta_box( 'meta-box-id-'.$screen, __( 'Additional Field', 'textdomain' ), 'wpdocs_my_display_callback_blog', $screen );	
    }
}
add_action( 'add_meta_boxes', 'wpdocs_register_meta_boxes_blog' );
 
/**
 * Meta box display callback.
 *
 * @param WP_Post $post Current post object.
 */
function wpdocs_my_display_callback_blog( $post ) {
    // Display code/markup goes here. Don't forget to include nonces!
    // Add an nonce field so we can check for it later.
  	wp_nonce_field( 'myplugin_inner_custom_box_price_list', 'myplugin_inner_custom_box_price_list_nonce' );
    
    $arr_meta = arr_theme_metabox_blog();   
    temp_template_metabox($arr_meta, $post);
}
 
/**
 * Save meta box content.
 *
 * @param int $post_id Post ID
 */
function wpdocs_save_meta_box_blog( $post_id ) {
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

	
	$arr_meta = arr_theme_metabox_blog() ;
	foreach ($arr_meta as $key => $metabox) {
		if($metabox['type']=='wp_editor') $value_meta = $_POST[$key];
		else $value_meta = sanitize_text_field( $_POST[$key] );
		update_post_meta( $post_id, $key, $value_meta);
	}
}
add_action( 'save_post', 'wpdocs_save_meta_box_blog' );

function arr_theme_metabox_blog(){
	$arr_meta = array(
						'brief'=> array('type'=>'text','title'=>'Brief'),
						//'about_product'=> array('type'=>'wp_editor','title'=>'About Product','hide_button'=>false),
						//'benefits_product'=> array('type'=>'wp_editor','title'=>'Benefits','hide_button'=>false),
						//'privileges_product'=> array('type'=>'wp_editor','title'=>'Privileges','hide_button'=>false),
					);					
	return $arr_meta;
}


?>