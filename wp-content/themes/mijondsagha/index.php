<?php 
get_header();
/*if(is_faq_cat()){
	get_template_part('taxonomy','faq_cat');	
}else{*/
	if ( have_posts() ) :
		
	endif;
//}
get_footer();	
?>