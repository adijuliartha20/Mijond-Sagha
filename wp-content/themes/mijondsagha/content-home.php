<?php 
	// Set up the objects needed
	$my_wp_query = new WP_Query();
	$all_wp_pages = $my_wp_query->query(array('post_type' => 'page', 'posts_per_page' => '-1' ,'orderby' => 'menu_order', 'order'   => 'asc'));

	$frontpage_id = get_option( 'page_on_front' );
	// Filter through all pages and find Page's children
	$page_children = get_page_children( $frontpage_id, $all_wp_pages );

	//print_r($page_children);
	if(!empty($page_children)){
		foreach ($page_children as $key => $pc) {
			$template = str_replace('.php','',get_page_template_slug( $pc->ID ));
			//echo $template.'#';
			$template = str_replace('page-', '', $template);
			//echo $template.'#';
			//print_r($pc);
			set_query_var( 'post_id', absint( $pc->ID ) );
			
			get_template_part( 'page', $template );
		}
	}

?>