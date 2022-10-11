<div class="content-sidebar-menu fright">
	<div class="main-content"><?php echo $main_content; ?></div>
	<?php 
		global $wp_query; 
		//print_r($_GET);\
		//$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
		//print_r($qobj);
		$cat = '';
		if(isset($_GET['search']) && !empty($_GET['search']) 
			&& isset($_GET['post_type']) && !empty($_GET['post_type']) 
			){
			$title =  pll__('Search Result');
			$args = array( 'post_type'=>'faq', 's' => $_GET['search'] , 'posts_per_page'=>get_option( 'faq_view_val' ),'paged' => $paged);
		} 	
		else {
			//print_r($_GET);
			$qobj = $wp_query->queried_object;
			//print_r($wp_query);
			$title = $qobj->name;			
			$cat=$qobj->slug;
			$args = array('post_type'=>'faq','posts_per_page'=>get_option( 'faq_view_val' ),'paged' => $paged,
					'tax_query' => array(
									        array(
									          'taxonomy' => $qobj->taxonomy,
									          'field' => 'id',
									          'terms' => $qobj->term_id
									        )
									      ));    	
		}
	?>	
	<h2 class="title-category-faq"><?php echo $title ?></h2>

	<?php 
		//$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

		
		$the_query = new WP_Query( $args );
		if ( $the_query->have_posts() ) { ?>
			<div class="list-faq clearfix">
			<?php
			while ( $the_query->have_posts() ) {
			    $the_query->the_post();
			    ?>
			    <div class="item-faq">
			    	<div class="list-item-faq clearfix">
			    		<div class="left-lif fleft">Q:</div>
			    		<div class="right-lif fleft"><?php echo $post->post_title; ?></div>
			    	</div>
			    	<div class="list-item-faq clearfix">
			    		<div class="left-lif fleft">A:</div>
			    		<div class="right-lif fleft"><?php echo apply_filters('the_content', $post->post_content); ?></div>
			    	</div>
			    </div>
			    <?php 
			    //print_r($post);
			}
			?>
			</div>
			<?php
		}else{

		}
		
	?>
	<?php 
		if(!empty($cat)){
			global $wpdb;
			//get list testimonial , a.post_title, b.meta_value
			$q = $wpdb->prepare("select a.ID from {$wpdb->prefix}posts a inner join {$wpdb->prefix}postmeta b on a.ID=b.post_ID
								where a.post_type=%s and a.post_status=%s and b.meta_key=%s and b.meta_value=%s",'testimonial','publish','faqcat_related',$cat); //echo $q;
			$dtt = $wpdb->get_results($q,'ARRAY_A');
			//print_r($dtt);
			if(!empty($dtt)){
				?>
				<div id="testimonial-faq" class="item-spd-testimonial item-spd-testimonial-faq item-spd clearfix">
					<div class="lbl-item-spd"><h3><?php echo pll__('Testimonial'); ?>:</h3></div>
					<div class="desc-item-spd">
						<div id="slick-testimonial" class="slick-testimonial">
						<?php
							$dynamic_featured_image = new Dynamic_Featured_Image();
							foreach ($dtt as $key => $tt) {
								$image = wp_get_attachment_image_src( get_post_thumbnail_id($tt['ID'] ),'full'); 

								$image_2 = $dynamic_featured_image->get_all_featured_images($tt['ID']);
						        $url_image_2 = $image[0];

						        if(isset($image_2[1]) &&  !empty($image_2[1])){
						        	$url_image_2 = $image_2[1]['full'];
						        }
								if(!empty($image)){
									?>
									<a href="<?php echo $url_image_2; ?>" class="item-testimonial">
			                            <img src="<?php echo $image[0]; ?>">
			                        </a>
									<?php	
								}
							}
						 ?>
						</div>
					</div>
				</div>
				<?php 
			}	
		}
		
	?>


	<div class="testimonial-faq"></div>
</div>	