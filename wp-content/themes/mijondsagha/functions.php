<?php 
add_action( 'admin_menu', 'custom_menu_page_removing' );


function custom_menu_page_removing() {
    //remove_menu_page('edit.php' );
    //remove_menu_page( 'edit-comments.php' );  
}

function temp_template_metabox($arr_meta = array(), $post){
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


//require_once('functions_product_knowledge.php');
//require_once('functions_agent.php');
//require_once('functions_qna.php');
require_once('functions_faq.php');
require_once('functions_testimonial.php');
require_once('functions_blog.php');


function nn_product(){
	return get_option( 'produk_view_val' );
}


function wpse_177068_videos_per_page( $wp_query ) {
	global $wp_query;  
	//print_r($wp_query);
	$qobj = get_queried_object();
	//get_option( 'produk_view_val' )
	$nn =  nn_product();
	//print_r($qobj);

	if ( is_post_type_archive('produk') && !is_admin() ){

        $wp_query->set( 'posts_per_page', $nn);
    }

    if ( $wp_query->is_main_query() && $wp_query->is_tax( 'produk_cat', $qobj->slug )    && !is_admin()) {
        $wp_query->set( 'posts_per_page', $nn);
    }

    $post_type = get_query_var('post_type');   
	if( $wp_query->is_search && $post_type == 'produk'   && !is_admin()){
		$wp_query->set( 'posts_per_page', $nn);
	}
}

add_action( 'pre_get_posts', 'wpse_177068_videos_per_page' );



function wpse_177068_testimonial_per_page( $wp_query ) {
	global $wp_query;  
	//print_r($wp_query);
	$qobj = get_queried_object();
	//get_option( 'produk_view_val' )
	$nn =  get_option( 'testimonial_view_val' );
	//print_r($qobj);

	if ( is_post_type_archive('testimonial') && !is_admin() ){

        $wp_query->set( 'posts_per_page', $nn);
    }

   
}

add_action( 'pre_get_posts', 'wpse_177068_testimonial_per_page' );




function template_chooser($template)   {    
  global $wp_query;   
  $post_type = get_query_var('post_type');
  if( $wp_query->is_search && $post_type == 'produk' ){
    return locate_template('archive-produk.php');  //  redirect to archive-search.php
  } else if($wp_query->is_search && $post_type == 'faq'){
  	return locate_template('taxonomyfaq_cat.php');
  }  
  return $template;   
}
add_filter('template_include', 'template_chooser');






require_once('functions_produk.php');


function theme_name_scripts() {
	$v = '1.0.0'.time();
	wp_enqueue_style( 'standardize', get_template_directory_uri().'/standardize.css' );
	wp_enqueue_style( 'vegas', get_template_directory_uri().'/js/vegas/vegas.min.css');
	wp_enqueue_style( 'select_2', get_template_directory_uri().'/js/select2/css/select2.min.css');
	wp_enqueue_style( 'slick', get_template_directory_uri().'/js/slick/slick.css' );
	wp_enqueue_style( 'slick-theme', get_template_directory_uri().'/js/slick/slick-theme.css' );
	wp_enqueue_style( 'magnificient_popup', get_template_directory_uri().'/js/magnific-popup/magnific-popup.css');
	/*
	
	
	
	wp_enqueue_style( 'jquery-ui', get_template_directory_uri().'/js/jquery-ui-1.12.1/jquery-ui.min.css');
	wp_enqueue_style( 'lightcase', get_template_directory_uri().'/js/lightcase-master/src/css/lightcase.css');*/
	wp_enqueue_style( 'style', get_stylesheet_uri() , array(), $v );

	wp_enqueue_script( 'jquery-js-v', get_template_directory_uri().'/js/jquery-3.2.1.min.js', array(), '1.0.0', true );
	wp_enqueue_script( 'slick-v', get_template_directory_uri().'/js/slick/slick.js', array(), '1.0.1', true );
	wp_enqueue_script( 'vegas-v', get_template_directory_uri().'/js/vegas/vegas.min.js', array(), '1.0.0', true );
	wp_enqueue_script( 'select2-v', get_template_directory_uri().'/js/select2/js/select2.min.js', array(), '1.0.1', true );
	wp_enqueue_script( 'isotope-v', get_template_directory_uri().'/js/isotope.pkgd.min.js', array(), '1.0.1', true );
	wp_enqueue_script( 'magnific-popup-v', get_template_directory_uri().'/js/magnific-popup/jquery.magnific-popup.min.js', array(), '1.0.1', true );
	
	wp_enqueue_script( 'script-v', get_template_directory_uri() . '/script.js', array( 'jquery' ), $v );


	$dt = array();
	$dt['url'] = admin_url('admin-ajax.php');
	$dt['please_wait'] = pll__('Please wait');

	wp_localize_script('script-v','d',$dt);
}



add_action( 'wp_enqueue_scripts', 'theme_name_scripts' );



/*add_action( 'pre_get_posts', function ( $q ) {

    if( !is_admin() && $q->is_main_query() && $q->is_post_type_archive( 'produk' ) ) {

        $q->set( 'posts_per_page', get_option( 'produk_view_val' ) );

    }

});*/







/*
Register Static Label
*/
//pll_register_string($name, $string, $multiline);
pll_register_string('scroll_down', 'Scroll Down', false);
pll_register_string('Read More', 'Read More', false);
pll_register_string('detail product', 'Detail Product', false);
pll_register_string('more product', 'More Product', false);
pll_register_string('more testimonial', 'More Testimonial', false);
pll_register_string('© Sagha Company', '© Sagha Company', false);

pll_register_string('Theraphy Oil', 'Theraphy Oil', false);
pll_register_string('Contact Us', 'Contact Us', false);
pll_register_string('Jimbaran, Denpasar, Bali, Indonesia', 'Jimbaran, Denpasar, Bali, Indonesia', false);
pll_register_string('Hotline', 'Hotline', false);
pll_register_string('0811-3980-770', '0811-3980-770', false);

pll_register_string('Operation Time', 'Operation Time', false);
pll_register_string('24 Hours Service', '24 Hours Service', false);
pll_register_string('Monday - Friday', 'Monday - Friday', false);
pll_register_string('08.00 am - 05.00 pm', '08.00 am - 05.00 pm', false);
pll_register_string('Saturday', 'Saturday', false);

pll_register_string('08.00 am - 02.00 pm', '08.00 am - 02.00 pm', false);

pll_register_string('There are n products available', 'There are n products available', false);
pll_register_string('Categories', 'Categories', false);
pll_register_string('Search', 'Search', false);
pll_register_string('Others', 'Others', false);
pll_register_string('All', 'All', false);


pll_register_string('Find Another Topic', 'Find Another Topic', false);
pll_register_string('What people say about our products', 'What people say about our products', false);
pll_register_string('All Testimonial', 'All Testimonial', false);
pll_register_string('Head Office', 'Head Office', false);
pll_register_string('Email', 'Email', false);


pll_register_string('Telephone', 'Telephone', false);
pll_register_string('Fax', 'Fax', false);
pll_register_string('Our Agents', 'Our Agents', false);
pll_register_string('Find the nearest Sales and Marketing Sagha Indonesia here.', 'Find the nearest Sales and Marketing Sagha Indonesia here.', false);
pll_register_string('Detail', 'Detail', false);


pll_register_string('Contact Form', 'Contact Form', false);
pll_register_string('Name', 'Name', false);
pll_register_string('Message', 'Message', false);
pll_register_string('No. Handphone', 'Fax', false);
pll_register_string('Subject', 'Subject', false);

pll_register_string('Send Message', 'Send Message', false);
pll_register_string('List Products', 'List Products', false);
pll_register_string('Order Product', 'Order Product', false);
pll_register_string('About Product', 'About Product', false);
pll_register_string('Benefits', 'Benefits', false);


pll_register_string('Privileges', 'Privileges', false);
pll_register_string('Testimonial', 'Testimonial', false);
pll_register_string('Other Products', 'Other Products', false);
pll_register_string('See All', 'See All', false);
pll_register_string('Search Result', 'Search Result', false);


pll_register_string('Please Wait', 'Please Wait', false);
pll_register_string('Success Send Message', 'Success Send Message', false);
pll_register_string('See Map', 'See Map', false);
pll_register_string('See Facebook', 'See Facebook', false);
pll_register_string('Social Media', 'Social Media', false);

pll_register_string('Order Product', 'Order Product', false);
pll_register_string('Like Our Facebook', 'Like Our Facebook', false);
pll_register_string('Country', 'Country', false);
pll_register_string('Province', 'Province', false);
pll_register_string('District', 'District', false);


pll_register_string('Load State', 'Load State', false);
pll_register_string('Load City', 'Load City', false);
pll_register_string('Please wait', 'Please wait', false);
pll_register_string('Looking for an agent in your area', 'Looking for an agent in your area', false);
pll_register_string('Please contact us use information below', 'Please contact us use information below', false);

pll_register_string('Popular', 'Popular', false);
pll_register_string('Search Blog', 'Search Blog', false);
pll_register_string('Latest', 'Latest', false);
pll_register_string('Comment', 'Comment', false);
pll_register_string('Other Article', 'Other Article', false);




function set_custom_post_types_admin_order($wp_query) {
  if (is_admin()) {

    // Get the post type from the query
    $post_type = $wp_query->query['post_type'];

    if ( $post_type == 'agent') {

      // 'orderby' value can be any column name
      $wp_query->set('orderby', 'title');

      // 'order' value can be ASC or DESC
      $wp_query->set('order', 'ASC');
    }
  }
}
add_filter('pre_get_posts', 'set_custom_post_types_admin_order');


function set_meta_image(){
	$url = "";
	if(is_singular( 'produk' )){
		$image = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID ),'full');
		$url = get_permalink( $post->ID );
	}else{
		$frontpage_id = get_option( 'page_on_front' );
		$image = wp_get_attachment_image_src( get_post_thumbnail_id($frontpage_id ),'medium');		
		$url = site_url();
	}

	if(!empty($image)){
		?>
		<meta property="og:image" content="<?php echo $image[0]; ?>"/>
		<meta property="og:url" content="<?php echo $url; ?>" /> 
		<?php
	}
}

?>