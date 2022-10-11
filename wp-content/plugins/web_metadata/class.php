<?php 
/*
Plugin Name: Meta Data
Plugin URI: http://www.locografis.com
Description: Simple metadata post from Loco Grafis
Author: Adi Juliartha
Author URI: http://www.locografis.com 
Version: 1.0.0/
*/


function meta_data_blog(){
	global $post;
	if(is_single()) {
		$image = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID ),'full');
		?>
		<meta property="og:url" content="<?php echo get_permalink($post->ID); ?>" />
		<meta property="og:type" content="article" />
		<meta property="og:title" content="<?php echo $post->post_title; ?>" />
		<meta property="og:description" content="<?php echo get_post_meta($post->ID, 'brief', true ); ?>" />
		<meta property="og:image" content="<?php echo $image[0]; ?>" />
		<?php 	
	}
}
add_action('wp_head','meta_data_blog');

?>