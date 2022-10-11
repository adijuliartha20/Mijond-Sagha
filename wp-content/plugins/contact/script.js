jQuery(document).ready(function(){
	contact_state()
})

function contact_state(){
   // jQuery('#jasa').select2();
   // jQuery("#date").datepicker({minDate:0, dateFormat: 'dd MM yy'});
}


function send_inquiry(event){
	var error = 0;
	var rfield = ['name','email','phone','subject','message'];
	
	default_reset_after_success(rfield,false);
	document.getElementById("notify-text").innerHTML = '';
   	
	var first_error = '';

   //validate required field
	for (i=0; i<rfield.length;i++){
		var el = document.getElementById(rfield[i]);
		if(trim(el.value)==''){
			el.classList.add("error");
			if(first_error=='') first_error = rfield[i]
			error++;
		} 
	}
	
	
	if(error==0){
		var el_email = document.getElementById('email');
		if(!valid_email(el_email.value)){
			error++;
			el_email.classList.add('error');
			document.getElementById("notify-text").innerHTML = "Format email salah";
			if(first_error=='') first_error = 'email'
		}
	}
	
	if(error==0){ 
		var el_res = document.getElementById('g-recaptcha-response');
		var response = el_res.value; 
		if(trim(response)==''){
			error++;
			document.getElementById("notify-text").innerHTML = "Silahkan verifikasi Google Capcha";			
		}
	}
	
	if(error==0){
		var dt =  new Object();
			dt.action 			= 'inquiry-now';
            dt.name     		= jQuery('#name').val();
            dt.email    		= jQuery('#email').val();
            dt.phone  			= jQuery('#phone').val();
            dt.subject 			= jQuery('#subject').val();
            dt.message 			= jQuery('#message').val();
            dt.recapcha 		= jQuery('#g-recaptcha-response').val();
        
        var txt_button = jQuery(event.target).attr('data-onprocess');
        jQuery(event.target).val(txt_button);
            
        jQuery.post(d.url,dt,function(response){
        	var res = jQuery.parseJSON(response);
            if(res.status=='success'){
                jQuery(event.target).val('Sukses Kirim Pesan');
                reset_form('form-contact');
                //default_reset_after_success(rfield,true);
            }else{
                jQuery(event.target).val('Sukses Kirim Pesan');
            }

            setTimeout(function(){
                txt_button = jQuery(event.target).attr('data-onfinish');
                jQuery(event.target).val(txt_button);
                grecaptcha.reset();
            },3000)
	    }) 
	}else{
		scroll_to_id(jQuery('#'+first_error),200,'')
	}

}

function scroll_to_id(target,mt,id){
    jQuery('html, body').stop().animate({
        scrollTop: target.offset().top - mt
    }, 1000,function (){
        //var strId = id.replace('#','');
        //setTimeout('scroll_hover_menu',150)
        
    });   
}

function reset_form(id_form){
   jQuery('#'+id_form).find("input[type=text], input[type=password], input[type=file],textarea").val("");
   jQuery('#'+id_form).find("input[type=checkbox], input[type=radio]").prop("checked", false);
   jQuery('#'+id_form).find("._input").val("")
   jQuery('#'+id_form).find('._select').val('').trigger('change')   
}

function clearError(){
	this.classList.remove("error");
}	

function valid_email(email) {
  var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  return regex.test(email);
}

function trim(str) {
	var	str = str.replace(/^\s\s*/, ''),
			ws = /\s/,
			i = str.length;
	while (ws.test(str.charAt(--i)));
	return str.slice(0, i + 1);
}

function remove_element_by_class(name){
	var list = document.getElementsByClassName(name);
   for(var i = list.length - 1; 0 <= i; i--)
   if(list[i] && list[i].parentElement)
   list[i].parentElement.removeChild(list[i]);
}

function default_reset_after_success(array_el,empty){
	for	(i = 0; i < array_el.length; i++) {
		var id = array_el[i];
		var el = document.getElementById(id); 
		if(el.value!="" && empty==true) el.value="";
		el.classList.remove("error");
	}
}


function validate_error(event){
    val = jQuery(event.target).val();
    if(jQuery(event.target).hasClass('error')) jQuery(event.target).removeClass('error');
}




