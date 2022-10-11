<?php
/**
* Template Name: Page Contact
*/
https://maps.google.com/maps?q=115.23460195625,-8.66299134399497"
get_header();?>



<?php 
if (have_posts()) :
	?>
	<div id="content-contact" class="content content-page content-contact flower-bottom">
		<?php 
			set_query_var( 'title', $post->post_title );
			get_template_part( 'content', 'slide-default' );
			get_template_part( 'content', 'contact-brief' );
			get_template_part( 'content', 'contact-agent-form' );
			get_template_part( 'content', 'contact-form' );
		?>
	</div> 
	<?php

else :
	get_template_part( 'content', 'none' );		
endif;?>
<?php get_footer();?>	