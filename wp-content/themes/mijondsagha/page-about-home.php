<?php
/**
* Template Name: Page About Home
*/

if(is_front_page()) {
?>
	<div id="about-home" class="about-home flower-buttom clearfix" name="section-scroll">
		<div class="middle clearfix">
			<div class="ah-left fleft">
				<h2><?php echo get_the_title( $post_id ); ?></h2>
				<h3><?php echo get_post_meta($post_id, 'sub_title', true ); ?></h3>
			</div>
			<div class="ah-right fright">
				<?php echo apply_filters('the_content', get_post_field('post_content', $post_id)); ?>
				<a href="<?php echo get_permalink($post_id);?>"><?php echo pll__('Read More'); ?></a>		
			</div>			
		</div>
	</div>
<?php
}else{
	get_header();?>
	<?php 
	if ( have_posts() ) :
		while ( have_posts() ) : the_post(); ?>
			<div class="content content-page<?php echo ' content-'.$post->post_name?>">
				<?php 
					get_template_part( 'content', 'slide' );
					get_template_part( 'content', 'about-brief' );
					get_template_part( 'content', 'about' );
					get_template_part( 'content', 'slick-testimonial' );
				?>
			</div>			
		<?php endwhile; 
	else :
		get_template_part( 'content', 'none' );		
	endif;?>
	<?php get_footer();
}
?>