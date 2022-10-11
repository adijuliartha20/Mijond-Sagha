jQuery(document).ready(function (){
	set_sorting_area()
})


function set_sorting_area(){
	jQuery( "#ul-list-favorite" ).sortable();
    //jQuery( "#ul-list-favorite" ).disableSelection();
}

function get_province(e){
    var country = jQuery(e.target).val()

    var dt =  new Object();
        dt.action           = 'get-province-now';
        dt.id               = jQuery(e.target).val();

    jQuery('#province option').remove();
    jQuery('#province').append('<option value="">Please wait...</option>'); 
       
    jQuery('#city option').remove();   
	//jQuery('#city').append('<option value="">City</option>'); 
    jQuery.post(d.url,dt,function(response){
        var res = jQuery.parseJSON(response);
        jQuery('#province option').remove();
        if(res.status=='success'){
            var opt = '<option value="">State</option>';
            jQuery.each(res.dt,function(i,v){
                opt += '<option value="'+v.id+'">'+v.state+'</option>';
            });
            jQuery('#province').append(opt);
        }
    })
}

function add_favorite(e){
	jQuery('#notify').slideUp(300)
	var country = jQuery('#country').val()
	var province = jQuery('#province').val()

	var error = 0;
	if(country=='') error++;
	if(province=='') error++;

	if(error==0){
		//console.log('#item-fav-'+province+'-'+country);
		if(jQuery('#item-fav-'+province+'-'+country).length>0){
			jQuery('#notify').html('<p>State already selected</p>');
			jQuery('#notify').slideDown(300)
			error++;	
		} 
	}

	if(error==0){
		var temp = temp_item_fav();
		jQuery("#ul-list-favorite").sortable("destroy");
		jQuery('#ul-list-favorite').append(temp);
		jQuery( "#ul-list-favorite" ).sortable();
	}
}


function temp_item_fav(){
	var country = jQuery('#country').val()
	var country_text = jQuery("#country :selected").text();
	var province = jQuery('#province').val()
	var province_text = jQuery("#province :selected").text();

	var temp = '<li id="">'+
                    '<div class="item-favorite-area"><span>'+province_text+',</span> <span>'+country_text+'</span></div>'+
                    '<input type="hidden" name="country_favorite[]" value="'+country+'" >'+
                    '<input type="hidden" name="state_favorite[]" value="'+province+'" >'+
                '</li>';
    return temp;            
}


function delete_current_area(e){
	var id = jQuery(e.target).attr('data-id');
	jQuery('#'+id).slideUp(300);

	setTimeout(function(){
		jQuery('#'+id).remove();		
	},300)
}