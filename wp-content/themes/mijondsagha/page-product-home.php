<?php
/**
* Template Name: Page Product Home
*/


$args = array('post_type'=>'produk','orderby' => 'menu_order', 'order'   => 'asc');
                            
$the_query = new WP_Query( $args );
if ( $the_query->have_posts() ) {
	$arr = array();
    $title = get_post_field('post_title', $post_id);

     while ( $the_query->have_posts() ) {
        $the_query->the_post();        
        //print_r($post);
        $image = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID ),'medium');
        
        array_push($arr, array( 
                                'title' => $post->post_title,
                                'image'=>$image[0], 
                                'brief'=> get_post_meta($post->ID, 'brief', true ),
                                'url'=> get_permalink($post->ID)
        				));
    }



    if(!empty($arr)){
        ?>
        <div id="product-home" class="product-home home-section">
            <h2><?php echo $title; ?></h2>
            <hr>    
            <div id="slick-product" class="slick-product">
                <?php 
                    foreach ($arr as $key => $product) {
                        ?>
                        <div class="item-product">
                            <img src="<?php echo $product['image']; ?>">
                            <h4><?php echo $product['title']; ?></h4>
                            <p class="brief"><?php echo $product['brief']; ?></p>
                            <a class="btn-white" href="<?php echo $product['url']; ?>"><?php echo pll__('Detail Product'); ?></a>
                        </div>
                        <?php 
                    }

                ?>    
            </div>
            <a class="more-product-home btn-purple" href="<?php echo get_post_type_archive_link( 'produk' ); ?>"><?php echo pll__('More Product'); ?></a>

        </div>

        <?php
    }
}    
?>