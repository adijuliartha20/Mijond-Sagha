<div id="cont-single-produk-detail" class="cont-single-produk-detail">
	<div class="middle">
		<div id="panel-spd" class="panel-spd clearfix bdr-gray">
			<button class="btn-panel-spd current fleft" onclick="scroll_to_detail_produk(event,'#about-product')"><?php echo pll__('About Product'); ?></button>
			<button class="btn-panel-spd fleft" onclick="scroll_to_detail_produk(event,'#benefits-product')"><?php echo pll__('Benefits'); ?></button>
			<button class="btn-panel-spd fleft" onclick="scroll_to_detail_produk(event,'#privileges-product')"><?php echo pll__('Privileges'); ?></button>
			<button class="btn-panel-spd fleft" onclick="scroll_to_detail_produk(event,'#testimonial-product')"><?php echo pll__('Testimonial'); ?></button>
		</div>

		<div id="about-product" class="item-spd bdr-gray clearfix">
			<div class="lbl-item-spd fleft"><h3><?php echo $post->post_title; ?>:</h3></div>
			<div class="desc-item-spd fleft">
				<?php 
					$about_product = apply_filters('the_content', get_post_meta($post->ID,'about_product',true));

					$input = '\nString Added\n';    
					$cc= preg_replace('/<\/iframe>[^\w](\w+)/' ,$input . '$1',$about_product);
					echo  $cc;
				?>
			</div>
		</div>
		<div id="benefits-product" class="item-spd bdr-gray clearfix">
			<div class="lbl-item-spd fleft"><h3><?php echo pll__('Benefits'); ?>:</h3></div>
			<div class="desc-item-spd fleft"><?php echo apply_filters('the_content', get_post_meta($post->ID,'benefits_product',true)); ?></div>
		</div>
		<div id="privileges-product" class="item-spd bdr-gray clearfix">
			<div class="lbl-item-spd fleft"><h3><?php echo pll__('Privileges'); ?>:</h3></div>
			<div class="desc-item-spd fleft"><?php echo apply_filters('the_content', get_post_meta($post->ID,'privileges_product',true)); ?></div>
		</div>
		<?php 
			global $wpdb;
			//get list testimonial , a.post_title, b.meta_value
			$q = $wpdb->prepare("select a.ID from {$wpdb->prefix}posts a inner join {$wpdb->prefix}postmeta b on a.ID=b.post_ID
								where a.post_type=%s and a.post_status=%s and b.meta_key=%s and b.meta_value=%s",'testimonial','publish','produk_related',$post->post_name);
			$dtt = $wpdb->get_results($q,'ARRAY_A');

			if(!empty($dtt)){
				?>
				<div id="testimonial-product" class="item-spd-testimonial item-spd bdr-gray clearfix">
					<div class="lbl-item-spd fleft"><h3><?php echo pll__('Testimonial'); ?>:</h3></div>
					<div class="desc-item-spd fleft">
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
		?>
	</div>
</div>