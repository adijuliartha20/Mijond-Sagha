<?php
global $wpdb;

$dtc = $wpdb->get_results("select id_country, country from {$wpdb->prefix}country order by country",'ARRAY_A');
?>
<div class="content-agent">
	<div class="middle">
		<div class="brief-agent">
			<h3><?php echo pll__('Our Agents'); ?></h3>
			<p><?php echo pll__('Find the nearest Sales and Marketing Sagha Indonesia here.'); ?></p>
		</div>
		<div class="panel-agent clearfix">
			<div class="field-pagent white-select fleft">
				<select class="select2" name="country" id="country" onchange="get_province(event);">
					<option value=""><?php echo pll__('Country'); ?></option>
					<?php
					foreach ($dtc as $key => $cc) {
						?>
						<option value="<?php echo $cc['id_country']; ?>"><?php echo $cc['country']; ?></option>
						<?php
					}
					 ?>
				</select>	
			</div>
			<div class="field-pagent white-select fleft">
				<select class="select2" name="province" id="province" onchange="get_city(event);">
					<option value=""><?php echo pll__('Province'); ?></option>
				</select>	
			</div>
			<div class="field-pagent white-select fleft">
				<select class="select2" name="city" id="city">
					<option value=""><?php echo pll__('District'); ?></option>
				</select>	
			</div>
			<div class="field-pagent fleft">
				<button class="btn-purple clearfix" onclick="search_agent(event)">
					<span class="fleft"><?php echo pll__('Search'); ?></span>
					<img class="fright" src="<?php echo get_template_directory_uri().'/images/search-white.png'?>">
				</button>
			</div>
		</div>
		<div id="result-agent" class="result-agent bdr-gray"></div>
		<div class="favorite-area-agent clearfix">
			<?php
	            $fav_area = get_option('favorite-area-agent');
	            $fav_area = json_decode($fav_area);
	            if(!empty($fav_area)){
	                foreach ($fav_area->state_favorite as $key => $vv) {
	                    $qs = $wpdb->prepare("select a.id_state, a.state, b.id_country, b.country from {$wpdb->prefix}state a inner join {$wpdb->prefix}country b on a.id_country=b.id_country where a.id_state=%d",$vv);
	                    $rs = $wpdb->get_results($qs);

	                    if(!empty($rs)){
	                        $ar = $rs[0];
	                        ?>
	                        <button class="item-fav-area fleft" data-country="<?php echo $ar->id_country ?>" data-state="<?php echo $ar->id_state ?>" onclick="search_agent_area(event)">
	                        	<?php echo $ar->state ?>	
	                        </button>
	                        <?php
	                    } 
	                }
	            }
	        ?>



			
			
		</div>
	</div>
</div>	


<div id="dtt-contact" class="dtt-contact hide">
<?php $opt = get_option('my_option_name');?>
	<h3><?php echo pll__('Please contact us use information below'); ?>:</h3>
	<p class="value-contact email-contact clearfix">
		<img class="fleft" src="<?php echo get_template_directory_uri().'/images/email-black.png'?>">
		<a href="mailto:<?php echo get_option( 'admin_email' ); ?>" class="fleft"><span ><?php echo get_option( 'admin_email' ); ?>	</span></a>
	</p>
	<p class="value-contact phone-contact clearfix">
		<img class="fleft" src="<?php echo get_template_directory_uri().'/images/phone-black.png'?>">
		<a href="tel:<?php echo $opt['phone']; ?>"><span class="fleft"><?php echo $opt['phone']; ?>	</span>	</a>
		
	</p>	
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
			<label id="city_country_agent" class="area-agent fleft">Aceh Indonesia</label>
			<!--<a id="link_map_agent" target="_blank" class="btn-white-purple fright" href="#"><?php echo pll__('See Map') ?></a>-->
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