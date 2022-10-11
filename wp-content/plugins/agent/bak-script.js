jQuery(document).ready(function(){
	var geocoder = new google.maps.Geocoder();
	var map_canvas = jQuery('#map_canvas').length;
	if (map_canvas > 0){
	  google.maps.event.addDomListener(window, 'load', initialize);
	}



	function initialize() {	
		var latitude = document.getElementById('latitude').value;
		var longitude = document.getElementById('longitude').value;
		
		var address = document.getElementById('address').value;
		var latLng = new google.maps.LatLng(latitude, longitude);

		if(longitude==''){
			var latLng = new google.maps.LatLng(-8.6704582, 115.2126293);
		}

		var mapOptions = {
	      center: latLng,
	      zoom: 12,
		  scaleControl: true,
	      mapTypeId: google.maps.MapTypeId.ROADMAP
	    };

	    var map = new google.maps.Map(document.getElementById('map_canvas'), mapOptions);
	    var input = document.getElementById('address');
	    var autocomplete = new google.maps.places.Autocomplete(input, { types: [ 'geocode' ] });
	    autocomplete.bindTo('bounds', map);
	    var infowindow = new google.maps.InfoWindow();

	    var image = new google.maps.MarkerImage(
			    php_vars.url_pointer,
				new google.maps.Size(40,35),
				new google.maps.Point(0,0),
				new google.maps.Point(8,35)
			);
	    var marker = new google.maps.Marker({
		    position: latLng,
		    title: 'Property location',
		    icon: image,
		    map: map,
		    draggable: true
		  });

	    // Update current position info.
		//updateMarkerPosition(latLng,"location");
		
		geocodePosition(latLng);
		// Add dragging event listeners.
		google.maps.event.addListener(marker, 'dragstart', function() {
			//updateMarkerAddress('Dragging...');
		});

		google.maps.event.addListener(marker, 'drag', function() {
			/*updateMarkerStatus('Dragging...');
			*/
			updateMarkerPosition(marker.getPosition(),'drag');
		});  	  

		google.maps.event.addListener(marker, 'dragend', function() {
			//updateMarkerStatus('Drag ended');			
			geocodePositionByMaker(marker.getPosition());
		});
		//*/
		
	    google.maps.event.addListener(autocomplete, 'place_changed', function() {
	      infowindow.close();
	      marker.setVisible(true);
	      input.removeClass = 'notfound';
	      var place = autocomplete.getPlace();
	      if (!place.geometry) {
	        // Inform the user that the place was not found and return.
	        input.addClass = 'notfound';
	        return;
	      }

	      fillInAddress(place);
	      // If the place has a geometry, then present it on a map.
	      if (place.geometry.viewport) {
	        map.fitBounds(place.geometry.viewport);
	      } else {
	        map.setCenter(place.geometry.location);
	        map.setZoom(17);  // Why 17? Because it looks good.
	      }
	      marker.setPosition(place.geometry.location);
	      latLng = marker.getPosition();
	      updateMarkerPosition(latLng,'location');

	    });
	}



	function updateMarkerPosition(latLng,status) {	
		var latitude = document.getElementById('latitude').value;
		var longitude = document.getElementById('longitude').value;
		var address = document.getElementById('address').value;
		console.log(latLng);

		//document.getElementById('info').innerHTML = [ latLng.lat(),   latLng.lng() ].join(', ');
		
		document.getElementById('latitude').value = latLng.lat();
		document.getElementById('longitude').value = latLng.lng();
		
	}

	function geocodePosition(pos) {
		geocoder.geocode({
			latLng: pos
			}, function(responses) {
			if (responses && responses.length > 0) {	
			  updateMarkerAddress(responses[0].formatted_address);
			} else {
			  updateMarkerAddress('Cannot determine address at this location.');
			}
		});
	}


	function updateMarkerAddress(str) {
	  	document.getElementById('address').innerHTML = str;
	}


	function updateMarkerStatus(str) {
	  	document.getElementById('markerStatus').innerHTML = str;
	}

	function geocodePositionByMaker(pos) {
		geocoder.geocode({
		latLng: pos
		}, function(responses) {
		if (responses && responses.length > 0) {
		  //console.log("responses = "+responses[0].formatted_address);
		  //console.log(responses);
		  fillInAddress(responses[0]); //OFF
		  updateMarkerAddress(responses[0].formatted_address);
		} else {
		  updateMarkerAddress('Cannot determine address at this location.');
		}
		});
	}

	function fillInAddress(place) {
		//console.log("place = "+place);
		//console.log(place.address_components);
		console.log(place);   

		for (var component in component_form) {
		  document.getElementById(component).value = "";
		  document.getElementById(component).disabled = false;
		}


		document.getElementById("address").value = place.formatted_address;

		var HTML = '';
		jQuery("#map_ac").html("");
		
		for (var j = 0; j < place.address_components.length; j++) {
			var att = place.address_components[j].types[0];
			//console.log(att);
			var value = place.address_components[j]['long_name'];
			HTML += '<input type="text" name="map_ac['+att+']" id="map_ac_'+att+'" class="text4" value="'+value+'">';
				
		  	if (component_form[att]) {
				//console.log(place.address_components);
				var val = place.address_components[j][component_form[att]];
				//console.log('val = '+val);
				document.getElementById(att).value = val;
				/*if(att=='country'){
					selectByText( $.trim( val ) );			       
				}*/
			}
		}
		//console.log('HTML = '+HTML);
		/*jQuery("#map_ac_temp").html(HTML);
		set_villalocation_temp();*/
	}

	function trim(str) {
	    var	str = str.replace(/^\s\s*/, ''),
	            ws = /\s/,
	            i = str.length;
	    while (ws.test(str.charAt(--i)));
	    return str.slice(0, i + 1);
	}

	var component_form = {
			    'locality': 'long_name',
			    'country': 'long_name',
			    //'administrative_area_level_1': 'long_name',
			    //'postal_code': 'short_name'
			  };





	set_villalocation_temp();
	function set_villalocation_temp(){
		var name = jQuery('[name=name]').val();
		var address = jQuery('#address').val();
		var postal_code = jQuery('#postal_code').val();
		var locality = jQuery('#locality').val();
		var country = jQuery('#country').val();
		if(trim(locality) != ''){
			locality = ', '+locality;
		}
		if(trim(country) != ''){
			country = ', '+country;
		}
		if(trim(postal_code) != ''){
			postal_code = ', '+postal_code;
		}

		var location = address+locality+country+postal_code+' <br />';
		var villalocation_temp = name+' : <br/> '+location
		jQuery('#villalocation_temp').html(villalocation_temp);
	}

	/*function fillInAddress(place) {
		//console.log("place = "+place);
		//console.log(place.address_components);
		console.log(place);   

		for (var component in component_form) {
		  document.getElementById(component).value = "";
		  document.getElementById(component).disabled = false;
		}

		document.getElementById("address").value = place.formatted_address;

		var HTML = '';
			jQuery("#map_ac").html("");
		for (var j = 0; j < place.address_components.length; j++) {
		  	var att = place.address_components[j].types[0];
		  	var value = place.address_components[j]['long_name'];
			  	console.log('att = '+att+',value = '+value);
				HTML += '<input type="text" name="map_ac['+att+']" id="map_ac_'+att+'" class="text4" value="'+value+'">';
		  	if (component_form[att]) {
				//console.log(place.address_components);
		    	var val = place.address_components[j][component_form[att]];
		    	//console.log('val = '+val);
		    document.getElementById(att).value = val;
		    if(att=='country'){
		    	selectByText( $.trim( val ) );			       
		    }
		  }
		}
		//console.log('HTML = '+HTML);
		jQuery("#map_ac_temp").html(HTML);
		set_villalocation_temp();

	}

	function selectByText( txt ) {
		jQuery('#selecto_country option')
		.filter(function() { return $.trim( jQuery(this).text() ) == txt; })
		.attr('selected',true);		

		jQuery(".chzn-select-selecto_country").removeClass('chzn-done');
		jQuery("#selecto_country_chzn").remove();
		jQuery(".chzn-select-selecto_country").chosen();
	}*/



})