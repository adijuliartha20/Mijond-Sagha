<?php
/**
* Template Name: Page Search
*/
get_header();?>
<?php 
if ( have_posts() ) :
	while ( have_posts() ) : the_post(); 
		get_template_part( 'content', 'slide' );
		get_template_part( 'content', 'blog' );
	endwhile; 
else :
	get_template_part( 'content', 'none' );		
endif;?>
<?php get_footer();
?>