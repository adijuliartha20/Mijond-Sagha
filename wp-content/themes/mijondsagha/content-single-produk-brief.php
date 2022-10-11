<?php 
	$image = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID ),'full');   
?>

<div class="cont-single-produk-brief flower-section clearfix">
	<div class="middle">
		<div class="panel-cspb bdr-gray">
			<a href="<?php echo get_post_type_archive_link( 'produk' ); ?>" class="clearfix">
				<img class="fleft" src="<?php echo get_template_directory_uri().'/images/back.png'?>">	
				<span class="fleft"><?php echo pll__('List Products'); ?>	</span>				
			</a>
		</div>	
		<div class="single-produk-brief clearfix">
			<div class="thumb-spb fleft">
				<img src="<?php echo $image[0]; ?>">
			</div>
			<div class="desc-spb fright">
				<h1><?php echo $post->post_title; ?></h1>
				<div id="brief-spb" class="brief-spb"><?php echo apply_filters('the_content', get_post_meta($post->ID,'brief',true)); ?></div>
				<hr class="sort-hr">
				<div id="content-spb" class="content-spb"><?php echo apply_filters('the_content', $post->post_content);?></div>
				<a href="<?php echo get_permalink(172);?>" class="btn-purple"><?php echo pll__('Order Product'); ?></a>
				<input type="hidden" id="readmore-txt" value="<?php echo pll__('Read More'); ?>">
			</div>
		</div>
	</div>	
</div>