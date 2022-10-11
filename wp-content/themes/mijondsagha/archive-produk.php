<?php get_header();?>
<?php 
if (have_posts()) :
	?>
	<div id="content-product-list" class="content content-page content-product-list flower-buttom">
		<?php 

			$page = get_posts(array('name' => 'produk-kami','post_type' => 'page'));
			set_query_var( 'post_id', $page[0]->ID );
			get_template_part( 'content', 'slide' );
			get_template_part( 'content', 'panel-product' );
			get_template_part( 'content', 'product' );
		?>			
	</div>		
	<?php
else :
	get_template_part( 'content', 'none' );		
endif;?>
<?php get_footer();?>	