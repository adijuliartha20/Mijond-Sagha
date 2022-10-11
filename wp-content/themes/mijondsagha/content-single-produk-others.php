<?php 
global $wp_query; 

$args = array('post_type'=>'produk','post__not_in' => array( $post->ID ),'posts_per_page'=>3);     

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
    ?>
    <div class="cont-single-produk-other">
        <h4><?php echo pll__('Other Products'); ?></h4>
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

        <a class="more-product-home btn-purple" href="<?php echo get_post_type_archive_link( 'produk' ); ?>"><?php echo pll__('See All'); ?></a>
    </div>
    <?php
    }
}
?>