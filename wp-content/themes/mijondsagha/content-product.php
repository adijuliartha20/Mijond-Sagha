<?php 
global $wp_query; 
//print_r($wp_query);

$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
$nn =  nn_product();
if(isset($qobj)){	
	//echo "string";
	$args = array('post_type'=>'produk', 'posts_per_page'=>$nn,'paged' => $paged,
					'tax_query' => array(
									        array(
									          'taxonomy' => $qobj->taxonomy,
									          'field' => 'id',
									          'terms' => $qobj->term_id
									        )
									      )
				); 
}else if( isset($wp_query->query) && !empty($wp_query->query)){
	$args = array( 'post_type'=>'produk', 's' => $wp_query->query['search'] , 'posts_per_page'=>$nn,'paged' => $paged);
}else{
	$args = array('post_type'=>'produk','posts_per_page'=>$nn,'paged' => $paged);     
}
//print_r($args);

$the_query = new WP_Query( $args );
if ( $the_query->have_posts() ) {
	$arr = array();
	while ( $the_query->have_posts() ) {
	    $the_query->the_post();
	    
        $image = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID ),'medium');        
        array_push($arr, array( 
                                'title' => $post->post_title,
                                'image'=>$image[0], 
                                'brief'=> get_post_meta($post->ID, 'brief', true ),
                                'url'=> get_permalink($post->ID)
        				));
	}
	
	if(!empty($arr)){
		//print_r($arr);
	?>
		<div class="list-product">
			<div class="middle clearfix">
				<?php foreach ($arr as $key => $product) { ?>
				<a class="item-product fleft" href="<?php echo $product['url']; ?>">
			        <img src="<?php echo $product['image']; ?>">
			        <h4><?php echo $product['title']; ?></h4>
			        <p class="brief"><?php echo $product['brief']; ?></p>
			        <button class="btn-white" ><?php echo pll__('Detail Product'); ?></button>
			    </a>
			    <?php } ?>		
			</div>
		</div>


		<div class="pagging">
            <?php 
                    $big = 999999999; // need an unlikely integer
                    $translated = __( '', 'mytextdomain' ); // Supply translatable string
                    
                    echo paginate_links( array(
                        'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                        'format' => '?paged=%#%',
                        'current' => max( 1, get_query_var('paged') ),
                        'total' => $the_query->max_num_pages,
                        'prev_text'=>"",
                        'next_text'=>"",
                    ) );
            ?>
         </div>

    <?php
	}
}
?>