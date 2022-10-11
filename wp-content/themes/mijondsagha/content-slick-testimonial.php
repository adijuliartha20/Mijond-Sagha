<?php
$args = array('post_type'=>'testimonial','orderby' => 'menu_order', 'order'   => 'asc');
                            
$the_query = new WP_Query( $args );
if ( $the_query->have_posts() ) {
	$arr = array();

	$content = get_post_field('post_content', $post_id);
	if(!is_front_page()){
		$page = get_posts(array('name'      => 'testimonials','post_type' => 'page'));
		$content = $page[0]->post_content;
	}
	$content = apply_filters('the_content', $content);

	$dynamic_featured_image = new Dynamic_Featured_Image();
	while ( $the_query->have_posts() ) {
        $the_query->the_post();                
        $image = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID ),'full');  
        $image_2 = $dynamic_featured_image->get_all_featured_images($post->ID) ;

        $url_image_2 = $image[0];

        if(isset($image_2[1]) &&  !empty($image_2[1])){
        	$url_image_2 = $image_2[1]['full'];
        }
        //print_r($image_2);      
        array_push($arr, array( 
                                'image'=>$image[0], 
                                'url'=> get_permalink($post->ID),
                                'url_full'=> $url_image_2
        				));

        
    }
	?>
	<div id="testimonial" class="testimonial home-section">
		<h2><?php 		
					if(is_front_page()) echo get_the_title( $post_id ); 
					else echo pll__('Testimonial')	;
				?></h2>
		<hr>
		<div class="middle clearfix">
			<div class="brief"><?php echo $content;?></div>
			<div id="slick-testimonial" class="slick-testimonial">
				<?php 
                    foreach ($arr as $key => $item) {
                        ?>
                        <a href="<?php echo $item['url_full']; ?>" class="item-testimonial">
                            <img src="<?php echo $item['image']; ?>">
                        </a>
                        <?php 
                    }
                ?>   
			</div>
			<a class="more-testimonial btn-purple" href="<?php echo get_post_type_archive_link( 'testimonial' ); ?>"><?php echo pll__('More Testimonial'); ?></a>
		</div>
	</div>
	<?php
}
?>