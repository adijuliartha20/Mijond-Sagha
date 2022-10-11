<?php get_header();?>
<?php 
if (have_posts()) :
	?>
	<div id="content-testimonial-list" class="content content-page content-testimonial-list">
		<?php 
			set_query_var( 'title', pll__('Testimonial') );
			get_template_part( 'content', 'slide-default' );
			get_template_part( 'content', 'filter-testimonial' );
		 ?>
		
		<?php 
		$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
		//echo get_option( 'testimonial_view_val' );

		$args = array('post_type'=>'testimonial','posts_per_page'=>get_option( 'testimonial_view_val' ),'paged' => $paged);

		$the_query = new WP_Query( $args );
		if ( $the_query->have_posts() ) {
			$arr = array();
			while ( $the_query->have_posts() ) {
			    $the_query->the_post();
			    $image = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID ),'full');    

			    $image_2 = $dynamic_featured_image->get_all_featured_images($post->ID);
		        $url_image_2 = $image[0];

		        if(isset($image_2[1]) &&  !empty($image_2[1])){
		        	$url_image_2 = $image_2[1]['full'];
		        }

        		array_push($arr, array( 
                                'image'=>$image[0], 
                                'url'=> get_permalink($post->ID),
                                'produk_slug' => get_post_meta($post->ID,'produk_related',true),
                                'url_full'=> $url_image_2
        				));
			}

			if(!empty($arr)){
				?>
				<div class="content-list-testimonial flower-buttom clearfix">
					<div id="slick-testimonial-new" class="middle clearfix">
						<?php
							foreach ($arr as $key => $item) {
		                        ?>
		                        	<a href="<?php echo $item['url_full']; ?>"  class="item-testimonial fleft <?php echo $item['produk_slug']; ?>">
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
		                        'total' => $the_query->max_num_pages,
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