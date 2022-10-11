<?php 

$nn = 3;
$args = array('post_type'=>'post','posts_per_page'=>$nn,'paged' => $paged,'post__not_in'=>$id_current); 
//print_r($args);

$the_query = new WP_Query( $args );
if ( $the_query->have_posts() ) {
	$arr = array();
	while ( $the_query->have_posts() ) {
	    $the_query->the_post();
	    
	    $date = date_create($post->date);
        $image = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID ),'medium');        
        array_push($arr, array( 
                                'title' => $post->post_title,
                                'image'=>$image[0],
                                'date'=> date_format($date,'F d, Y'),
                                'url'=> get_permalink($post->ID)
        				));
	}



	if(!empty($arr)){
		?>
			<div id="other-blog" class="other-blog">
				<h2><?php echo pll__('Other Article'); ?></h2>
				<div class="middle clearfix">
					<?php foreach ($arr as $key => $blog) { ?>
					<a class="item-blog fleft" href="<?php echo $blog['url']; ?>">
				        <img src="<?php echo $blog['image']; ?>">
				        <p class="date-comment"><?php echo $blog['date']; ?> | <fb:comments-count href="<?php echo $blog['url']; ?>"></fb:comments-count> <?php echo pll__('Comment'); ?></p>
				        <h4><?php echo $blog['title']; ?></h4>
				    </a>
				    <?php } ?>

				</div>
			</div>
		<?php 
	}



}	

?>





