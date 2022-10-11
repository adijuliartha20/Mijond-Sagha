<?php
/**
* Template Name: Page Testimonial Product
*/
?>

<?php get_header();?>
<?php 
if (have_posts()) :
	?>
	<div id="content-testimonial-list" class="content content-page content-testimonial-list">
		<?php 
			set_query_var( 'title', pll__('Testimonial') );
			get_template_part( 'content', 'slide-default' ); 
			get_template_part( 'content', 'filter-testimonial' ); ?>
		<?php 	?>
		


		<?php 
		$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
		
		global $wpdb;
		//get list testimonial , a.post_title, b.meta_value
		/*$q = $wpdb->prepare("select a.ID from {$wpdb->prefix}posts a inner join {$wpdb->prefix}postmeta b on a.ID=b.post_ID
							where a.post_type=%s and a.post_status=%s and b.meta_key=%s and b.meta_value=%s ",'testimonial','publish','produk_related',$_GET['v']);		*/					
		//echo $paged;
		$view  =  get_option( 'testimonial_view_val' );

		$offset = ($paged==1? 0 : (($paged - 1) * $view));
		
		$q = $wpdb->prepare("select a.ID from {$wpdb->prefix}posts a inner join {$wpdb->prefix}postmeta b on a.ID=b.post_ID
							where a.post_type=%s and a.post_status=%s and b.meta_key=%s and b.meta_value=%s  limit %d,%d",'testimonial','publish','produk_related',$_GET['v'], $offset,$view);

		$qn = $wpdb->prepare("select COUNT(*) from {$wpdb->prefix}posts a inner join {$wpdb->prefix}postmeta b on a.ID=b.post_ID
							where a.post_type=%s and a.post_status=%s and b.meta_key=%s and b.meta_value=%s ",'testimonial','publish','produk_related',$_GET['v']);

		$nn = $wpdb->get_var($qn);
		$max_num_pages = ceil($nn/$view);
		//echo $nn.'#';
		$dtt = $wpdb->get_results($q,'ARRAY_A');
		
		if(!empty($dtt)){
			$arr = array();
			foreach ($dtt as $key => $tt) {
				$post_ID = $tt['ID'];
			    $image = wp_get_attachment_image_src( get_post_thumbnail_id($post_ID),'full');        
        		array_push($arr, array( 
                                'image'=>$image[0], 
                                'url'=> get_permalink($post_ID),
                                'produk_slug' => get_post_meta($post_ID,'produk_related',true)
        				));
			}

			//print_r($arr);

			if(!empty($arr)){
				?>
				<div class="content-list-testimonial flower-buttom clearfix">
					<div id="slick-testimonial-new" class="middle clearfix">
						<?php
							foreach ($arr as $key => $item) {
		                        ?>
		                        	<a href="<?php echo $item['image']; ?>"  class="item-testimonial fleft <?php echo $item['produk_slug']; ?>">
			                            <img src="<?php echo $item['image']; ?>">
			                        </a>	
		                        <?php 
		                    }
						?>
					</div>
					<div class="pagging">
			            <?php 
		                    $big = 999999999; // need an unlikely integer
		                    $translated = __( '', 'mytextdomain' ); // Supply translatable string
		                    
		                    echo paginate_links( array(
		                        'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
		                        'format' => '?paged=%#%',
		                        'current' => max( 1, get_query_var('paged') ),
		                        'total' => $max_num_pages,
		                        'prev_text'=>"",
		                        'next_text'=>"",
		                    ) );
			            ?>
			         </div>
				</div>
				<?php
			}


		}

		?>
	</div>		
	<?php
else :
	get_template_part( 'content', 'none' );		
endif;?>
<?php get_footer();?>	