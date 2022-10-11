<?php
/**
* Template Name: Page Slide
*/

$gallery = get_post_meta( $post_id, 'images_1', true );
$brief = apply_filters('the_content', get_post_field('post_content', $post_id));


if(!empty($gallery)){
	$gallery = explode('ids="', $gallery);
	$gallery = explode('"]', $gallery[1]);
	$ids = explode(',',$gallery[0]);
}else return;

if(!empty($ids)){
	$list_input = '';
	foreach($ids as $id) : 
		$large = wp_get_attachment_image_src( $id, 'full');
		$img = $large[0];
		$list_input .= '
						<input type="hidden" value="'.$img.'">';	
	endforeach;
	?>
	<div class="wrap-slide">
		<div id="slide" class="slide">
			<?php echo $list_input; ?>
		</div>
		<?php
		if(!empty($brief)){
			?>
			<div class="brief-slide"><?php echo $brief; ?></div>
		<?php }
		?>

		<button class="scroll_down" onclick="scroll_down(event)"><?php echo pll__('Scroll Down'); ?></button>

	</div>	
	<?php 
}
?>
