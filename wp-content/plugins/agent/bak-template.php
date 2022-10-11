<?php

function temp($dt){
	$v = '?v=1.0.0'.time();
	wp_enqueue_style( 'agent-css', plugins_url( 'agent/style.css'.$v , dirname(__FILE__) ));
	//wp_enqueue_script( 'agent-js', plugins_url( 'agent/script.js'.$v , dirname(__FILE__) ) );

	$dtp = array(
					'url_pointer' => plugins_url( 'agent/pointer.png'.$v , dirname(__FILE__) )
				);
	wp_localize_script( 'agent-js', 'php_vars', $dtp );
?>
	<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD0xXo3NUASBvNWbfyJbZtKefw-1WzgLCw&&sensor=false&libraries=places"></script>

	<div class="custom-field-post">
		<div class="field-cp">
			<label>Address</label>
			<input type="text" id="address" name="address" value="<?php echo $dt['address']; ?>" size="70" />
			<input type="hidden" name="longitude">
			<input type="hidden" name="latitude">
			<input type="hidden" name="locality">
		</div>	
		<!--<div class="field-cp">
			<label>Longitude</label>
			<input type="text" id="longitude" name="longitude" value="<?php echo $dt['longitude']; ?>" size="70" />
		</div>	
		<div class="field-cp">
			<label>Latitude</label>
			<input type="text" id="latitude" name="latitude" value="<?php echo $dt['latitude']; ?>" size="70" />
		</div>-->	
		<div class="field-cp">
			<label>Country</label>
			<input type="text" id="country" name="country" value="<?php echo $dt['country']; ?>" size="70" />
		</div>
		<div class="field-cp">
			<label>City</label>
			<input type="text" id="city" name="city" value="<?php echo $dt['city']; ?>" size="70" />
		</div>
		<div class="field-cp">
			<label>Link Google Map</label>
			<input type="text" id="link_map" name="link_map" value="<?php echo $dt['link_map']; ?>" size="70" />
		</div>
		<div class="field-cp">
			<label>Account Facebook</label>
			<input type="text" id="account_facebook" name="account_facebook" value="<?php echo $dt['account_facebook']; ?>" size="70" />
		</div>
		<div class="field-cp">
			<label>Phone</label>
			<input type="text" id="phone" name="phone" value="<?php echo $dt['phone']; ?>" size="70" />
		</div>
		<!--<div class="field-cp">
			<label>Area</label>
			<input type="text" id="locality" name="locality" value="" size="70" />
			<input type="hidden" id="postal_code" name="postal_code">
		</div>

		<label style="margin-bottom:10px;display:block;">Exact Location</label>
		<div id="map_canvas" style="width: 755px; height: 310px;background: #000;"></div>-->

	</div>

	

<?php


}

?>
