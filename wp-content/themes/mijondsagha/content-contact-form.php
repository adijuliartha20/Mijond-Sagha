<?php 
$recapcha = get_option('recapcha');
wp_enqueue_script('google-capcha','https://www.google.com/recaptcha/api.js',false,'1.1',true);

wp_enqueue_script('contact-form-js-1',plugin_dir_url('').'contact/script.js',false,'1.1',true);
wp_localize_script('contact-form-js-1','d',array('url'=>admin_url('admin-ajax.php'),));
?>

<div id="form-contact" class="contact-form">
	<h3 class="bdr-fray"><?php echo pll__('Contact Form'); ?></h3>
	<div class="container-contact-form flower-buttom clearix">
		<div class="middle-ccf middle container-content-half clearfix">
			<div class="content-half fleft">
				<label><?php echo pll__('Name'); ?><span class="error-lbl">*</span></label>
				<input type="text" id="name" onkeyup="validate_error(event)" onchange="validate_error(event)">
				<label><?php echo pll__('Email'); ?><span class="error-lbl">*</span></label>
				<input type="text" id="email" onkeyup="validate_error(event)" onchange="validate_error(event)">
			</div>
			<div class="content-half fleft">
				<label><?php echo pll__('No. Handphone'); ?><span class="error-lbl">*</span></label>
				<input type="text" id="phone" onkeyup="validate_error(event)" onchange="validate_error(event)">
				<label><?php echo pll__('Subject'); ?><span class="error-lbl">*</span></label>
				<input type="text" id="subject" onkeyup="validate_error(event)" onchange="validate_error(event)">
			</div>
			<div class="content-full fleft">
				<label><?php echo pll__('Message'); ?><span class="error-lbl">*</span></label>
				<textarea id="message" onkeyup="validate_error(event)" onchange="validate_error(event)"></textarea>
			</div>
			<div class="content-full fleft">
				<?php echo html_entity_decode($recapcha['snipset']);?>       
		        <input type="button" class="btn-purple" onclick="send_inquiry(event)" value="<?php echo pll__('Send Message'); ?>" data-onprocess="<?php echo pll__('Please Wait'); ?>..." data-onfinish="<?php echo pll__('Send Message'); ?>"  data-onsuccess="<?php echo pll__('Success Send Message'); ?>" />
		        <div id="notify" class="notify">
		        	<div id="notify-text"></div>
		        </div>				
			</div>


		</div>	
	</div>
</div>