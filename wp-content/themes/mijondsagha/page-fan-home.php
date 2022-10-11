<?php
/**
* Template Name: Page Fan Home
*/


$image = wp_get_attachment_image_src( get_post_thumbnail_id($post_id ),'full');
//print_r($image);
$opt = get_option('my_option_name');
//print_r($opt);
?>
<div class="fanpage-home flower-buttom clearfix">
	<div class="middle clearfix">
		<div class="thumb-fanpage fleft"><img src="<?php echo $image[0]; ?>"></div>
		<div class="desc-fanpage fleft">
			<h4><?php echo  get_the_title( $post_id );  ?></h4>
			<a class="btn-purple btn-fanpage" href="<?php echo $opt['facebook']; ?>"><?php echo pll__('Like Our Facebook'); ?></a>
		</div>
	</div>
</div>