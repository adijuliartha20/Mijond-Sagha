<div class="brief-contact">
	<div class="middle container-content-half clearfix bdr-gray">
		<div class="content-half fleft">
			<div class="brief-contact-desc"><?php echo apply_filters('the_content', $post->post_content); ?></div>	
			<div class="operational-contact-desc">
				<label><?php echo pll__('Operation Time'); ?></label>
				<ul class="opdd clearfix">
					<li class="fleft">
						<p><?php echo pll__('Monday - Friday'); ?></p>
						<p><?php echo pll__('08.00 am - 05.00 pm'); ?></p>
					</li>
					<li class="fleft">
						<p><?php echo pll__('Saturday'); ?></p>
						<p><?php echo pll__('08.00 am - 02.00 pm'); ?></p>
					</li>
				</ul>
			</div>	

		</div>
		<div class="address-detail-contact content-half fleft">
			<?php $opt = get_option('my_option_name');?>
			<label><?php echo pll__('Head Office'); ?></label>
			<p class="address-contact"><?php echo pll__('Jimbaran, Denpasar, Bali, Indonesia'); ?></p>

			
			<p class="value-contact email-contact clearfix">
				<img class="fleft" src="<?php echo get_template_directory_uri().'/images/email-black.png'?>">
				<a href="mailto:<?php echo get_option( 'admin_email' ); ?>" class="fleft"><span ><?php echo get_option( 'admin_email' ); ?>	</span></a>
			</p>
			<p class="value-contact phone-contact clearfix">
				<img class="fleft" src="<?php echo get_template_directory_uri().'/images/phone-black.png'?>">
				<a href="tel:<?php echo $opt['phone']; ?>"><span class="fleft"><?php echo $opt['phone']; ?>	</span>	</a>
				
			</p>	
			
			
			<!--<p class="fax-contact">
				<b><?php echo pll__('Fax'); ?>: </b>
				<?php echo $opt['fax'];?>
			</p>-->
		</div>	
	</div>
</div>