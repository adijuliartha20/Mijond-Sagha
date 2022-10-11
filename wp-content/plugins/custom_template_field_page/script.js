jQuery(document).ready(function(){
	jQuery('#page_template').change(function(){
		var new_class = jQuery(this).val();
		new_class = new_class.replace('.php','');

		
		jQuery('#advanced-sortables > div').each(function(){
			var id = jQuery(this).attr('Id');
			if(id!='page-style') jQuery('#'+id).fadeOut(80)
		})
				
		jQuery('#'+new_class).fadeIn(80)
	})
})