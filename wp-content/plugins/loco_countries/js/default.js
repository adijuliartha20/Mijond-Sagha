jQuery(document).ready(function(){
	jQuery('.wp-list-table tbody').sortable({
		stop:function(event,ui){
			var url = jQuery('#ajax-url').val() //jQuery('[name=_wp_http_referer]').val()+'&action=sorting'
			//var values = 
			var dt = new Object()
				dt.action = jQuery('#sorting_action').val();
				dt._ajax_nonce = jQuery('#_wpnonce').val()
				dt.current_page = jQuery('#current_page').val()
				dt.ids = jQuery("input[name='bulk-delete[]']").map(function(){return jQuery(this).val();}).get();

			jQuery.post(url,dt,function(response){
				if(response=='success') location.reload();
			})
			//console.log(values)
		},
	});


	if(jQuery('.text-date').length>0){
		jQuery('.text-date').datepicker({minDate:0,dateFormat: "dd MM yy"});	
	}
});




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