<?php
/**
* Template Name: Page Thumbnail Rounded
*/
$gallery = get_post_gallery($post_id, false );
$ids = explode(',',$gallery['ids']);
if(!empty($ids)){
	?>
	<div class="our-excellence-home home-section">
		<h2><?php echo get_the_title( $post_id ); ?></h2>
		<hr>
		<div class="middle clearfix">
			<?php

			echo apply_filters('the_content', get_post_field('post_content', $post_id));
			
			?>					
		</div>
	</div>
<?php 
}
?>