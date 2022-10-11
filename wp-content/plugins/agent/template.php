<?php

function temp($dt){
	global $wpdb;
	$v = '?v=1.0.0'.time();
	wp_enqueue_style( 'agent-css', plugins_url( 'agent/style.css'.$v , dirname(__FILE__) ));
	wp_enqueue_script( 'agent-js', plugins_url( 'agent/script.js'.$v , dirname(__FILE__) ) );


	$dtj = array();
	$dtj['url'] = admin_url('admin-ajax.php');

	wp_localize_script( 'agent-js', 'd', $dtj );

	$dtc = $wpdb->get_results("select id_country, country from {$wpdb->prefix}country order by country",'ARRAY_A');
	$state = array();
	$city = array();
	//print_r($dtc);

	$curr_country = '';

	if(!empty($dt)){
		$curr_country = $dt['id_country'];
		$dts = $wpdb->prepare("select id_state, state from {$wpdb->prefix}state where id_country=%d order by state",$dt['id_country']);
		$state = $wpdb->get_results($dts);
		//print_r($state);

		$dtcc = $wpdb->prepare("select id_city, city from {$wpdb->prefix}city where id_state=%d order by city",$dt['id_state']);
		$city = $wpdb->get_results($dtcc);
		//print_r($city);
	}



?>

	<div class="custom-field-post">		
		<div class="field-cp">
			<label>Country</label>
			<select id="country" name="country" onchange="get_province(event);">
				<option value=""><?php echo pll__('Country'); ?></option>
				<?php
					foreach ($dtc as $key => $cc) {
						?>
						<option <?php if($cc['id_country']==$curr_country) echo "selected"; ?> value="<?php echo $cc['id_country']; ?>"><?php echo $cc['country']; ?></option>
						<?php
					}
				?>
			</select>
			
		</div>
		<div class="field-cp">
			<label>State</label>
			<select class="select2" name="province" id="province" onchange="get_city(event);">
				<option value=""><?php echo pll__('Province'); ?></option>
				<?php 
				if(!empty($state)){
					foreach ($state as $key => $ss) {
						?>
						<option <?php if($ss->id_state==$dt['id_state']) echo "selected"; ?> value="<?php echo $ss->id_state; ?>"><?php echo $ss->state; ?></option>
						<?php
					}
				}
				?>
			</select>
		</div>
		<div class="field-cp">
			<label>City</label>
			<select class="select2" name="city" id="city">
				<option value=""><?php echo pll__('City'); ?></option>
				<?php 
				if(!empty($city)){
					foreach ($city as $key => $cc) {
						?>
						<option <?php if($cc->id_city==$dt['id_city']) echo "selected"; ?> value="<?php echo $cc->id_city; ?>"><?php echo $cc->city; ?></option>
						<?php
					}
				}
				?>
			</select>
		</div>
		
		<div class="field-cp">
			<label>Account Facebook</label>
			<input type="text" id="account_facebook" name="account_facebook" value="<?php echo $dt['account_facebook']; ?>" size="70" />
		</div>
		<div class="field-cp">
			<label>Phone</label>
			<input type="text" id="phone" name="phone" value="<?php echo $dt['phone']; ?>" size="70" />
		</div>
	</div>

	

<?php


}

?>
