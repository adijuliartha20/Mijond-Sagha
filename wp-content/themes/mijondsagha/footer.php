<!-- Footer Start -->
<div class="footer">
	<div class="middle clearfix">
		<div class="sosmed-footer fleft clearfix">
			<h4><?php echo pll__('© Sagha Company'); ?></h4>
			<p><?php echo pll__('Theraphy Oil'); ?></p>
			<?php
			 	$arr = array('facebook','instagram','twitter');
			 	$opt = get_option('my_option_name');
			 	$n = 0;
			 	foreach ($arr as $key => $value) {
			 		if(isset($opt[$value]) && !empty($opt[$value])) $n++;
			 	}
			 	if($n>0){
			 		?>
			 		<div class="list-sosmed">
			 				<?php
			 				foreach ($arr as $key => $value) {

			 					if($opt[$value]!=''){
			 						?>
								    <a class="<?php echo $value;?>" href="<?php echo $opt[$value];?>" >
								    	<img class="" src="<?php echo get_template_directory_uri().'/images/'.$value.'.png' ?>">
								    </a>
								    <?php 
			 					}
			 					
			 				}
			 				?>
			 		</div>
			 		<?php
			 	}	
			 ?>
		</div>	
		<div class="contact-footer fleft">
			<h4><?php echo pll__('Contact Us'); ?></h4>
			<p><?php echo pll__('Jimbaran, Denpasar, Bali, Indonesia'); ?></p>	
			<div class="hotline clearfix">
				<img class="img-phone fleft" src="<?php echo get_template_directory_uri().'/images/phone.png'?>">
				<div class="desc-hotline fleft">
					<label><?php echo pll__('Hotline'); ?></label>
					<p><?php echo pll__('0811-3980-770'); ?></p>
				</div>
			</div>
			<hr>
			<div class="email clearfix">
				<img class="fleft" src="<?php echo get_template_directory_uri().'/images/email.png'?>">
				<div class="desc-email fleft"><a href="mailto:<?php echo get_option( 'admin_email' ); ?>"><?php echo get_option( 'admin_email' ); ?></a></div>
			</div>
		</div>	
		<div class="operation-time fleft">
			<h4><?php echo pll__('Operation Time'); ?></h4>
			<!--<p><?php echo pll__('24 Hours Service'); ?></p>-->
			<div class="operation-1 clearfix">
				<label><?php echo pll__('Monday - Friday'); ?></label>
				<div><?php echo pll__('08.00 am - 05.00 pm'); ?></div>
			</div>
			<hr>
			<div class="operation-2 clearfix">
				<label><?php echo pll__('Saturday'); ?></label>
				<div><?php echo pll__('08.00 am - 02.00 pm'); ?></div>
			</div>
		</div>	
	</div>
	
	<button class="scroll-up" onClick="scroll_up(event)">
		<img class="" src="<?php echo get_template_directory_uri().'/images/scroll_up.png'?>">
	</button>
	<input type="hidden" id="site_url" value="<?php echo site_url() ?>">
	<input type="hidden" id="please_wait" value="<?php echo pll__('Please Wait'); ?>">
	<input type="hidden" id="state_txt" value="<?php echo pll__('Province'); ?>">
	<input type="hidden" id="city_txt" value="<?php echo pll__('District'); ?>">
	<input type="hidden" id="detail_txt" value="<?php echo pll__('Detail'); ?>">
	<input type="hidden" id="looking_agent_txt" value="<?php echo pll__('Looking for an agent in your area'); ?>">
</div>
<!-- Footer End -->  
<?php wp_footer(); ?>
</body>
</html>