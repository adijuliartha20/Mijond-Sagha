jQuery(document).ready(function(){
})



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





function get_city(e){
    var dt =  new Object();
        dt.action           = 'get-city-now';
        dt.id               = jQuery(e.target).val();

    jQuery('#city option').remove();
    jQuery('#city').append('<option value="">Please wait...</option>');    

    jQuery.post(d.url,dt,function(response){
        var res = jQuery.parseJSON(response);
        jQuery('#city option').remove();
        if(res.status=='success'){
            var opt = '<option value="">City</option>';
            jQuery.each(res.dt,function(i,v){
                opt += '<option value="'+v.id+'">'+v.city+'</option>';
                //console.log('i='+v.id+', v='+v.state);
            });
            jQuery('#city').append(opt);
        }
    })
}
