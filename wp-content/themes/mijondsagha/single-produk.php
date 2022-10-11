<?php get_header();?>
<?php 
if (have_posts()) :
	?>
	<div id="content-single-product" class="content-single-product flower-buttom clearfix">
		<?php 
			get_template_part('content','single-produk-brief');
			get_template_part('content','single-produk-detail');
			get_template_part('content','single-produk-others');
		?>	
	</div>
	<?php 
	
else :
	get_template_part( 'content', 'none' );		
endif;?>
<?php get_footer();?>	