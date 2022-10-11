<?php
/**
* Template Name: Page Product
*/
get_header();?>
<?php 
if ( have_posts() ) :
	while ( have_posts() ) : the_post(); ?>
		<div class="content content-page<?php echo ' content-'.$post->post_name?>">
			<?php 
				get_template_part( 'content', 'slide' );
				get_template_part( 'content', 'panel-product' );
			?>
		</div>			
	<?php endwhile; 
else :
	get_template_part( 'content', 'none' );		
endif;?>
<?php get_footer();
?>