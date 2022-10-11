<?php 
	$categories = get_categories( array(
	    'orderby' => 'name',
	    'order'   => 'ASC'
	) );
	//$terms = get_terms( 'post' );

	if(!empty($categories)){
		?>
		<label class="lbl-category"><?php echo pll__('Categories'); ?></label>
		<ul class="link-categories"> 
			<?php
			foreach ( $categories as $category ) {
				if($category->parent<>0){
				    printf( '<li><a href="%1$s">%2$s</a></li>',
				        esc_url( get_category_link( $category->term_id ) ),
				        esc_html( $category->name )
				    );
				}    
			}
			?>
		</ul>
		<?php 		
	}


	//echo $id_slide;
	//find 4 popular artikel
	global $wpdb;
	$rp = $wpdb->get_results("select ID, count(ID) num from {$wpdb->prefix}record_post where ID not IN (".$post->ID.") group by ID order by num desc limit 6",'ARRAY_A');
	$ids = array();
	foreach ($rp as $key => $dt) {
		array_push($ids,$dt['ID']);
	}

	

	if(!empty($ids)){

		$args = array('post__in' => $ids);
		$posts = get_posts($args);
		$arr = array();
		foreach ($posts as $post) :
			array_push($arr, array( 
	                            'title' => $post->post_title,
	                            'url'=> get_permalink($post->ID)
	    				));
		endforeach;

		?>
		<label class="lbl-popular-detail-blog"><?php echo pll__('Popular'); ?></label>
		<ul class="list-artikel-popular">
		<?php 
		foreach ($arr as $key => $pp) {
            ?>
            <li class="item-pp">
            	<a href="<?php echo $pp['url']; ?>" class="">
                    <label><?php echo $pp['title']; ?></label>    
                </a>
            </li>
            <?php 
        }
        ?>	
        </ul>
        <?php

	}	




	//print_r($categories);

?>	

<div class="fb-page" data-href="https://www.facebook.com/MijondSagha/" data-tabs="post" data-small-header="false" data-adapt-container-width="true" data-hide-cover="true" data-show-facepile="true"><blockquote cite="https://www.facebook.com/MijondSagha/" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/MijondSagha/">Mijond Sagha</a></blockquote></div>
