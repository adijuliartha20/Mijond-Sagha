<div class="panel-filter-testimonial">
	<div class="middle clearfix">
		<label class="fleft"><?php echo pll__('What people say about our products');?></label>
		<div class="filter-testimonial gray-select fright">
			<?php 
				//args = array('post_type'=>'produk','posts_per_page'=>get_option( 'produk_view_val' ),'paged' => $paged);     
				$posts = get_posts(['post_type' => 'produk', 'post_status' => 'publish', 'numberposts' => -1]);
				if(!empty($posts)){ ?>
				<select id="filter-testimonial">
					<option value="<?php echo site_url().'/testimonial/'; ?>"><?php echo pll__('All Testimonial'); ?></option>
				<?php 
					foreach ($posts as $key => $dt) {
						$url = site_url().'/testimonial-produk/?v='.$dt->post_name; 
						?>
						<option <?php if(isset($_GET['v']) && $_GET['v']==$dt->post_name) echo 'selected'; ?> value="<?php echo $url; ?>"><?php echo $dt->post_title; ?></option>
						<?php
					}
				?>
				</select>
				<?php 
				}
				//print_r($posts);
			?>
			
		</div>
	</div>
</div>