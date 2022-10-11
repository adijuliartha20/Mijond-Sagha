<?php 
global $wpdb;


$qc = $wpdb->prepare("select b.ID, b.post_title name, a.country, a.city, a.link_map, a.account_facebook, a.phone from {$wpdb->prefix}agent_detail a inner join {$wpdb->prefix}posts b on a.ID=b.ID 
						where b.post_status=%s and a.country<>%s ","publish","");
$cc = $wpdb->get_results($qc, 'ARRAY_A');


$arr = array();
foreach ($cc as $key => $c) {
	$country = $c['country'];
	$city =  $c['city'];
	if(!isset($arr[$country])) $arr[$country] = array();
	if(!isset($arr[$country][$city] )) $arr[$country][$city] = array();


	$image = wp_get_attachment_image_src( get_post_thumbnail_id($c['ID'] ),'full');
	//print_r($image) ;
	$c['image'] = $image[0];
	array_push($arr[$country][$city],$c);	
}

if(!empty($arr)){
?>
<div class="content-agent">
	<div class="middle">
		<div class="brief-agent">
			<h3><?php echo pll__('Our Agents'); ?></h3>
			<p><?php echo pll__('Find the nearest Sales and Marketing Sagha Indonesia here.'); ?></p>
		</div>
		<div class="content-list-agent">
		<?php 
			foreach ($arr as $country => $ct) {
				?>
				<div class="item-country clearfix">
					<label class="bdr-gray"><?php echo $country; ?></label>
					<div class="list-city clearfix">

						<?php 
							foreach ($ct as $city => $agents) {
								?>
								<div class="item-city fleft clearfix">
									<label><?php echo $city; ?></label>
									<div class="list-agent">
										<?php foreach ($agents as $city => $agent) {
											?>
											<div class="item-agent clearfix">
												<label class="fleft"><?php echo $agent['name']; ?></label>
												<button class="btn-white-purple fright" data-name="<?php echo $agent['name']; ?>" data-country="<?php echo $agent['country']; ?>" 
															data-city="<?php echo $agent['city']; ?>" data-link_map="<?php echo $agent['link_map']; ?>" data-image="<?php echo $agent['image']; ?>"
															data-account_facebook="<?php echo $agent['account_facebook']; ?>" data-phone="<?php echo $agent['phone']; ?>"

															onClick="show_detail_agent(event)"
															>
													<?php echo pll__('Detail'); ?>
												</button>
											</div>
											<?php 
										} ?>
									</div>
								</div>
								<?php 
							}
						?>
					</div>			
				</div>
				<?php 
			}
		?>
		</div>
	</div>
</div>
<div id="overlay" class="overlay-black hide" onClick="hide_detail_agent(event)"></div>
<div id="popup" class="popup-agent popup hide">
	<button class="close-popup"  onClick="hide_detail_agent(event)">
		<img class="fleft" src="<?php echo get_template_directory_uri().'/images/close-purple.png' ?>"> 
	</button>
	<div class="content-popup">
		<img id="pp_agent" class="pp-agent" src="">
		<label id="name_agent" class="name-agent">ANI</label>
		<label class="phone-agent clearfix">
			<img class="fleft" src="<?php echo get_template_directory_uri().'/images/black-phone.png' ?>"> 
			<a href="tel:" id="phone_agent" class="phone-no-agent fleft">+62 0897 123456</a>
		</label>
		<div class="field-agent bdr-top-gray clearfix">
			<label id="city_country_agent" class="fleft">Aceh Indonesia</label>
			<a id="link_map_agent" target="_blank" class="btn-white-purple fright" href="#"><?php echo pll__('See Map') ?></a>
		</div>
		<div class="field-agent bdr-top-gray clearfix">
			<label class="fleft"><?php echo pll__('Social Media') ?></label>
			<a id="link_fb_agent"  target="_blank" class="btn-white-purple see-facebook fright clearfix" href="#">
				<img class="fleft" src="<?php echo get_template_directory_uri().'/images/fb-purple.png' ?>"> 
				<span class="fleft">
					<?php echo pll__('See Facebook') ?>			
				</span>
			</a>
		</div>
	</div>
</div>

<?php
}
?>