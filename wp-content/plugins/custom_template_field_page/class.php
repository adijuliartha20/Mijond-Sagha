<?php
/*
Plugin Name: Custom Field Template Page
Plugin URI: http://locografis.com/
Version: 1.0.0
Author: Adi Juliartha
Author URI: http://locografis.com/
*/


/**
 * Register meta box(es).
 */
function wpdocs_register_meta_boxes() {
	$screens = array('page');
    foreach ( $screens as $screen ) {
    	if($screen=='page'){
    		$v = '?v=1.0.0'.time();
    		wp_enqueue_style( 'css-admin-page', plugins_url( 'custom_template_field_page/style.css'.$v , dirname(__FILE__) ));
    		wp_enqueue_script( 'custom-js', plugins_url( 'custom_template_field_page/script.js'.$v , dirname(__FILE__) ) );

    		//add_meta_box( 'page-style', __( 'Style Page', 'style' ), 'metabox_style', $screen );
    		add_meta_box( 'page-slide', __( 'Slide Show', 'textdomain' ), 'wpdocs_my_display_callback', $screen );
    		add_meta_box( 'page-about-home', __( 'Additional field About', 'textdomain' ), 'metabox_about_home', $screen );
    		add_meta_box( 'page-product', __( 'Additional field About', 'textdomain' ), 'metabox_product', $screen );

    		
    	}    		
    }
}
add_action( 'add_meta_boxes', 'wpdocs_register_meta_boxes' );
 
/**
 * Meta box display callback.
 *
 * @param WP_Post $post Current post object.
 */
function wpdocs_my_display_callback( $post ) {
    // Display code/markup goes here. Don't forget to include nonces!
    // Add an nonce field so we can check for it later.
  	wp_nonce_field( 'myplugin_inner_custom_box_page_meta', 'myplugin_inner_custom_box_page_meta_nonce' );  

    $current_template = get_page_template_slug( $post->ID );
	$current_template = str_replace('.php', '', $current_template);
	show_custom_metabox($current_template);
	$arr_meta = arr_page_mockup() ;   
	return temp_template($arr_meta, $post);
}

function show_custom_metabox($current_template){
	echo '<script>
			jQuery(document).ready(function(){
				jQuery("#'.$current_template.'").fadeIn(80)
			})
		 </script>';
}


function metabox_about_home($post){
    $current_template = get_page_template_slug( $post->ID );
	$current_template = str_replace('.php', '', $current_template);
	
	$arr_meta = arr_page_about();				
	return temp_template($arr_meta, $post);
}

function metabox_product($post){
    $current_template = get_page_template_slug( $post->ID );
	$current_template = str_replace('.php', '', $current_template);
	
	$arr_meta = arr_page_product();				
	return temp_template($arr_meta, $post);
}



function metabox_style($post){
    $current_template = get_page_template_slug( $post->ID );
	$current_template = str_replace('.php', '', $current_template);
	
	$arr_meta = arr_page_style();				
	return temp_template($arr_meta, $post);
}


function temp_template($arr_meta = array(), $post){
	if(!empty($arr_meta)){
		foreach ($arr_meta as $key => $dt_field) {
			$type = $dt_field['type'];
			$title = $dt_field['title'];
			$value_meta = get_post_meta( $post->ID, $key, true );
			$unit_lable = (isset($dt_field['unit_lable'])? '&nbsp;'.$dt_field['unit_lable']:'');

			echo '<div style="margin-bottom:10px;"><label for="'.$key.'" style="width:100px; float:left; margin-top:5px">';
			   _e( $title, 'myplugin_textdomain' );
			echo '</label> ';

			if($type=='select'){
				$options = $dt_field['option'];
				echo '<select id="'.$key.'" name="'.$key.'" >';
				foreach ($options as $key_opt => $label) {
					echo '<option value="'.$key_opt.'" '.($key_opt==$value_meta?'selected':'').'>'.$label.'</option>';
				}
				echo '</select>'.$unit_lable;
			}else if($type=='textarea'){
				echo '<textarea class="" name="'.$key.'" style="width:50%; min-width:500px;min-height:100px;">' . esc_attr( $value_meta ) . '</textarea>';
			}else if($type=='number'){
				
				echo '<input type="number" id="'.$key.'" name="'.$key.'" value="' . esc_attr( $value_meta ) . '" size="70" />'.$unit_lable;
			}else if($type=='wp_editor'){
				 if(isset($dt_field['hide_button']) &&  $dt_field['hide_button']){
				 	echo '<style> 
				 				#wp-'.$key.'-wrap .mce-toolbar-grp {display: none;} 
				 				#wp-'.$key.'-wrap .wp-editor-tabs {display: none;}
				 	   </style>';	
				 }

				wp_editor( $value_meta, $key , $settings);
			}else{	
				echo '<input type="text" id="'.$key.'" name="'.$key.'" value="' . esc_attr( $value_meta ) . '" size="70" />';
			}
			echo '<br/></div>';
			
		}
	}
}
 
/**
 * Save meta box content.
 *
 * @param int $post_id Post ID
 */
function wpdocs_save_meta_box( $post_id ) {
    // Save logic goes here. Don't forget to include nonce checks!
    if ( ! isset( $_POST['myplugin_inner_custom_box_page_meta_nonce'] ) )return $post_id;  
	$nonce = $_POST['myplugin_inner_custom_box_page_meta_nonce'];  
	if (! wp_verify_nonce( $nonce, 'myplugin_inner_custom_box_page_meta' ))return $post_id;
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )  return $post_id;

	// Check the user's permissions.
	if ( 'price-list' == $_POST['post_type'] ) {
	if ( ! current_user_can( 'edit_page', $post_id ) ) return $post_id;
	} else { 
		if ( ! current_user_can( 'edit_post', $post_id ) ) return $post_id;
	}

	$arr_meta = arr_page_mockup() ;
	//array_push(arr_page_style(),$arr_meta);
	//print_r($_POST);
	foreach ($arr_meta as $key => $title) {
		$value_meta = sanitize_text_field( $_POST[$key] );
		update_post_meta( $post_id, $key, $value_meta);
	}

	$arr_meta = arr_page_about() ;
	foreach ($arr_meta as $key => $dt) {
		$value_meta = $_POST[$key];
		if($dt['type']!='wp_editor') $value_meta = sanitize_text_field( $_POST[$key] );
		update_post_meta( $post_id, $key, $value_meta);
	}

	/*$arr_meta = arr_page_style() ;
	foreach ($arr_meta as $key => $title) {
		$value_meta = sanitize_text_field( $_POST[$key] );
		update_post_meta( $post_id, $key, $value_meta);
	}*/

}
add_action( 'save_post_page', 'wpdocs_save_meta_box' );


function arr_page_mockup(){
	$arr_meta = array(
						'images_1'=> array('type'=>'wp_editor','title'=>'Images','hide_button'=>true),
						//'images_2'=> array('type'=>'wp_editor','title'=>'Images 2','hide_button'=>true),
						//'images_3'=> array('type'=>'wp_editor','title'=>'Images 3','hide_button'=>true)
					);					
	return $arr_meta;
}


function arr_page_about(){
	$arr_meta = array(
						'sub_title'=> array('type'=>'text','title'=>'Sub Title'),
						'long_content'=> array('type'=>'wp_editor','title'=>'Content','hide_button'=>false)
					);					
	return $arr_meta;	
}

function arr_page_product(){
	$arr_meta = array(
						'sub_title'=> array('type'=>'text','title'=>'Sub Title')
					);					
	return $arr_meta;	
}




function arr_page_style(){
	$style = array(
					'orange' => 'Orange',
					'white' => 'White',
					'soft-blue' => 'Soft blue',
					'gray' => 'Gray');
	$arr_meta = array(
						'page_style'=> array(	'type'=>'select','title' => 'Style','option'=> $style,'lbl_front'=>'')
					);					
	return $arr_meta;
}




 ?>