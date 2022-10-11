<?php 
if(!isset($post_id)) $post_id = $post->ID;
$image = wp_get_attachment_image_src( get_post_thumbnail_id($post_id ),'full');

$list_input .= '<input type="hidden" value="'.$image[0].'">';
if(!empty($image)) :
?>
<div class="wrap-slide">
	<div id="slide" class="slide">
		<?php echo $list_input; ?>
	</div>

	<?php 
		if(is_archive() && !is_post_type_archive( 'produk' )) { 
			$category = get_the_category();
			$firstCategory = $category[0]->cat_name;
			set_query_var( 'id_not_latest', array($post_id));

			$url  = get_permalink($post_id);;
			?>
			<div class="brief-slide brief-slide-blog">
				<p class="category-slide"><?php echo $firstCategory; ?></p>
				<h1><?php echo get_the_title( $post_id ); ?></h1>
				<p class="cont-date-comm"><?php echo get_the_date('F j, Y'); ?> | <fb:comments-count href="<?php echo $url; ?>"></fb:comments-count> COMMENT</p>

				<a href="<?php echo $url;?>" class="btn-purple"><?php echo pll__('Read More'); ?></a>
			</div>
			
			<?php

		}else if(is_single()){
			$category = get_the_category();
			$firstCategory = $category[0]->cat_name;
			$url  = get_permalink($post_id);;
			?>
			<div class="brief-slide brief-slide-blog">
				<p class="category-slide"><?php echo $firstCategory; ?></p>
				<h1><?php echo get_the_title( $post_id ); ?></h1>
				<p class="cont-date-comm"><?php echo get_the_date('F j, Y'); ?> | <fb:comments-count href="<?php echo $url; ?>"></fb:comments-count> COMMENT</p>
				
			</div>			
			<?php
		}else{
			?>
			<div class="brief-slide">
				<h1><?php echo get_the_title( $post_id ); ?></h1>
				<hr>
				<p><?php echo get_post_meta($post_id, 'sub_title', true ); ?></p>
			</div>
			<button class="scroll_down" onclick="scroll_down(event)" ><?php echo pll__('Scroll Down'); ?></button>
			<?php
		}


	?>
	
	
	
	

</div>	

<?php 
endif;
?>