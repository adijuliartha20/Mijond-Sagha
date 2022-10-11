<?php get_header();?>
<div id="page-blog" class="content content-page<?php echo ' content-'.$post->post_name?>">
	<?php 
		//get_template_part( 'content', 'slide' );
		get_template_part( 'content', 'blog' );
	?>
</div>
<?php get_footer();?>