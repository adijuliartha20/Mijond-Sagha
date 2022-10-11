<?php
/**
* Template Name: Page Mattrass Home
*/
$image = wp_get_attachment_image_src( get_post_thumbnail_id($post_id ),'medium');
?>
<div class="mattrass-home flower-section clearfix">
	<div class="mattras-image">
		<img src="<?php echo $image[0]; ?>">
	</div>
	<div class="middle clearfix">
		<div class="content-mattras fright">
			<h2 class="title"><?php echo get_the_title( $post_id ); ?></h2>
			<div class="content-mattrass-inside"><?php echo apply_filters('the_content', get_post_field('post_content', $post_id)); ?></div>
		</div>
	</div>
</div>