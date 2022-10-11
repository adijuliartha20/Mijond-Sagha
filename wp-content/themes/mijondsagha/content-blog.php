<div class="panel-blog"  name="section-scroll">
	<div class="middle">
		<div class="header-pp clearfix">
			<label class="lbl-blog-section fleft"><?php echo pll__('Popular'); ?></label>
			<div class="search-box fright">
				<form role="search" action="<?php echo site_url('/search'); ?>" method="get" id="searchform">
					<input type="text" name="keyword" placeholder="<?php echo pll__('Search Blog');?>">
					<button class="btn-search">
						<img class="" src="<?php echo get_template_directory_uri().'/images/search.png' ?>">  
					</button>
				    <input type="hidden" name="post_type" value="blog" /> <!-- // hidden 'products' value -->
			    </form>
			</div>
		</div>
		
	</div>
</div>	


<?php 

//echo $id_slide;
//find 4 popular artikel
global $wpdb;
$rp = array();
if(isset($id_not_latest) && !empty($id_not_latest)){
	if(is_tag() || is_category()){
		//echo 'fasfa';
		$queried_object = get_queried_object();
		$term_id = $queried_object->term_id;
		$rp = $wpdb->get_results("select a.ID, count(a.ID) num from {$wpdb->prefix}record_post a
									inner join {$wpdb->prefix}term_relationships b on a.ID = b.object_id
									inner join {$wpdb->prefix}terms c on b.term_taxonomy_id = c.term_id									
									where a.ID not IN (".implode(",",$id_not_latest).") and c.term_id=".$term_id."
									group by a.ID order by num desc limit 6",'ARRAY_A');

	}

	else{
		$rp = $wpdb->get_results("select ID, count(ID) num from {$wpdb->prefix}record_post where ID not IN (".implode(",",$id_not_latest).") group by ID order by num desc limit 6",'ARRAY_A');	
	}
}else if(isset($_GET['keyword']) && !empty($_GET['keyword'])){
	$id_not_latest  = array();
	$qp = $wpdb->prepare("select a.ID, count(a.ID) num from {$wpdb->prefix}record_post a 
								inner join {$wpdb->prefix}posts b on a.ID=b.ID
								where b.post_title like %s or b.post_content like %s
								group by ID order by num desc limit 5", "%".$_GET['keyword']."%", "%".$_GET['keyword']."%");
	$rp = $wpdb->get_results($qp,'ARRAY_A');

}else{
	$id_not_latest  = array();
	$rp = $wpdb->get_results("select ID, count(ID) num from {$wpdb->prefix}record_post group by ID order by num desc limit 5",'ARRAY_A'); 
}

$ids = array();
foreach ($rp as $key => $dt) {
	array_push($ids,$dt['ID']);
	
}

if(!empty($ids)){

	$args = array('post__in' => $ids);
	$posts = get_posts($args);
	$arr = array();
	foreach ($posts as $post) :
		$image = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID ),'medium');
		$date = date_create($post->date);

		array_push($arr, array( 
                            'title' => $post->post_title,
                            'image'=>$image[0], 
                            'date'=> date_format($date,'F d, Y'),
                            'url'=> get_permalink($post->ID)
    				));

		array_push($id_not_latest,$post->ID);
	endforeach;	

	//print_r($id_not_latest);
	
	if(!empty($arr)){
		?>
		<div class="list-popular clearfix">
			<div class="middle">
				<div id="slick-popular" class="slick-popular">
					<?php 
	                    foreach ($arr as $key => $pp) {
	                        ?>
	                        <div class="item-pp">
	                        	<a href="<?php echo $pp['url']; ?>" class="middle-pp">
	                        		<img src="<?php echo $pp['image']; ?>">
		                            <p class="date-comment"><?php echo $pp['date']; ?> | <fb:comments-count href="<?php echo $blog['url']; ?>"></fb:comments-count> <span class="span-comment"><?php echo pll__('Comment'); ?></span></p>
		                            <label><h4><?php echo $pp['title']; ?></h4></label>    
		                        </a>
	                        </div>
	                        <?php 
	                    }
	                ?>  
				</div>
			</div>
		</div>
		<?php
	}
}




//find latest


?>

<div class="cont-list-blog cont-list-blog-latest">
	<div class="middle clearfix">
		<?php 

		$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

		$nn = get_option('posts_per_page');
		//echo $paged;
		if(isset($qobj)){	
			//print_r($qobj);
			$args = array('post_type'=>'post', 'posts_per_page'=>$nn,'paged' => $paged,
							'tax_query' => array(
											        array(
											          'taxonomy' => $qobj->taxonomy,
											          'field' => 'id',
											          'terms' => $qobj->term_id
											        )
											      )
						); 
		}else if( isset($wp_query->query) && !empty($wp_query->query) && !empty($wp_query->query['search'])){
			$args = array( 'post_type'=>'post', 's' => $wp_query->query['search'] , 'posts_per_page'=>$nn,'paged' => $paged);
		}else if(is_tag() || is_category()){			
			$qobj = get_queried_object();
			$args = array('post_type'=>'post', 'posts_per_page'=>$nn,'paged' => $paged,'post__not_in'=>$id_not_latest,
							'tax_query' => array(
											        array(
											          'taxonomy' => $qobj->taxonomy,
											          'field' => 'id',
											          'terms' => $qobj->term_id
											        )
											      )
						);



		}else if(isset($_GET['keyword']) && !empty($_GET['keyword'])){
			//$orderby = get_query_var('orderby');print_r($orderby);

			$uri_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
			$uri_segments = explode('/', $uri_path);

			if($uri_segments[1]=='mijondsagha') $paged = $uri_segments[4];
			else $paged = $uri_segments[3];

			$args = array('post_type'=>'post','posts_per_page'=>$nn,'paged' => $paged,'post__not_in'=>$id_not_latest,'s' => $_GET['keyword']);
			//select * from wp_posts where (post_title like '%a%' or post_content like '%a%' )and 
			//(post_status='publish' and post_type='post' and ID not in (416,414,411,409)) 	
		}else{
			$args = array('post_type'=>'post','posts_per_page'=>$nn,'paged' => $paged,'post__not_in'=>$id_not_latest);     
		}

		//print_r($args);

		$the_query = new WP_Query( $args );
		if ( $the_query->have_posts() ) {
			$arr = array();
			while ( $the_query->have_posts() ) {
			    $the_query->the_post();
			    //print_r($post);
			    $date = date_create($post->date);
		        $image = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID ),'medium');        
		        array_push($arr, array( 
		                                'title' => $post->post_title,
		                                'image'=>$image[0], 
		                                'brief'=> get_post_meta($post->ID, 'brief', true ),
		                                'date'=> date_format($date,'F d, Y'),
		                                'url'=> get_permalink($post->ID)
		        				));
			}

			

			if(!empty($arr)){//print_r($the_query);
				//print_r($arr);
			?>
				<label class="fleft lbl-latest lbl-blog-section"><?php echo pll__('Latest'); ?></label>
				<div class="container-list-blog fleft">
					<div class="list-blog clearfix">
							<?php foreach ($arr as $key => $blog) { ?>
							<a class="item-blog fleft" href="<?php echo $blog['url']; ?>">
						        <img src="<?php echo $blog['image']; ?>">
						        <p class="date-comment"><?php echo $blog['date']; ?> | <fb:comments-count href="<?php echo $blog['url']; ?>"></fb:comments-count> <?php echo pll__('Comment'); ?></p>
						        <h4><?php echo $blog['title']; ?></h4>
						        <p class="brief"><?php echo $blog['brief']; ?></p>

						        <button><?php echo pll__('Read More'); ?></button>
						    </a>
						    <?php } ?>		
						
					</div>


					<div class="pagging">
			            <?php 
			                    $big = 999999999; // need an unlikely integer
			                    $translated = __( '', 'mytextdomain' ); // Supply translatable string
			                    
			                    $paged = get_query_var('paged');
			                    if(isset($_GET['keyword']) && !empty($_GET['keyword'])) {
			                    	$uri_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
									$uri_segments = explode('/', $uri_path);

									if($uri_segments[1]=='mijondsagha') $paged = $uri_segments[4];
									else $paged = $uri_segments[3];
			                    }

			                    echo paginate_links( array(
			                        'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
			                        'format' => '?paged=%#%',
			                        'current' => max( 1, $paged ),
			                        'total' => $the_query->max_num_pages,
			                        'prev_text'=>"",
			                        'next_text'=>"",
			                    ) );
			            ?>
			         </div>
				</div>
				

		    <?php
			}

		}else{//if empty blog

		}
		?>

		<div class="list-category-blog fright">
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

				//print_r($categories);

			?>	

			<div class="fb-page" data-href="https://www.facebook.com/MijondSagha/" data-tabs="post" data-small-header="false" data-adapt-container-width="true" data-hide-cover="true" data-show-facepile="true"><blockquote cite="https://www.facebook.com/MijondSagha/" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/MijondSagha/">Mijond Sagha</a></blockquote></div>
		</div>
	</div>
</div>