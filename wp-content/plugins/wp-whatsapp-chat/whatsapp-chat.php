<?php
/*
Plugin Name: WhatsApp Chat WP
Plugin URI: https://caporalmktdigital.com.br/plataformas/plugin-whatsapp-chat-wp/
Description: Let your customers contact you with WhatsApp Chat directly from your website. Easy, fast and effective!
Author: Alexandre Caporal
Author URI: https://caporalmktdigital.com.br/
Version: 3.1
License: GPLv2
*/

if ( ! defined( 'ABSPATH' ) )
    exit;

add_action( 'plugins_loaded', 'whatsapp_load_textdomain' );
function whatsapp_load_textdomain() {
load_plugin_textdomain( 'wac', false, basename( dirname( __FILE__ ) ) . '/languages/' );
}

function whatsapp_chat_menu() {
    add_menu_page('WhatsApp Chat Settings', 'WhatsApp Chat', 'administrator', 'whatsapp-chat-settings', 'whatsapp_chat_settings_page', plugins_url( 'images/whatsappicon.png', __FILE__ ));
}
add_action('admin_menu', 'whatsapp_chat_menu');

add_action( 'admin_enqueue_scripts', 'load_admin_style_wac' );
      function load_admin_style_wac() {
        wp_register_style( 'admin_css', plugins_url( 'css/admin-style.css', __FILE__ ) );
        wp_enqueue_style( 'admin_css', plugins_url( 'css/admin-style.css', __FILE__ ) ); 
    }

function whatsapp_chat_settings_page() { ?>
<div class="whats-page">
    <div class="whats-title">
       <h1>WhatsApp Chat WP</h1>
       <span class="doar-link"><a href="https://app.caporalmktdigital.com.br/asset/1:whatsapp-chat-donation"><?php _e('Like it? Consider a Donation!', 'wac'); ?></a></span>
    </div>
    <h2 class="nav-tab-wrapper">
        <a href="#whats-box-1" class="nav-tab"><?php _e('Customize your button', 'wac'); ?></a>
        <a href="https://wordpress.org/support/plugin/wp-whatsapp-chat/" class="nav-tab" target="_blank"><?php _e('Support', 'wac'); ?></a>
        <a href="https://wordpress.org/support/plugin/wp-whatsapp-chat/reviews/?rate=5#new-post" class="nav-tab" target="_blank"><?php _e('Review', 'wac'); ?></a>
        <a href="#whats-box-16" class="nav-tab"><?php _e('Shortcode', 'wac'); ?></a>
        <a href="#whats-box-17" class="nav-tab"><?php _e('Developer', 'wac'); ?></a>
    </h2>
    <div class="page-container">
    <form method="post" action="options.php">
    <?php
        settings_fields( 'whatsapp-chat-settings' );
        do_settings_sections( 'whatsapp-chat-settings' );
    ?>
    <div class="div-whats" id="whats-box-1">
    <div class="image-container-whats">
    <img src="<?php echo plugins_url( 'images/ativo1.png', __FILE__ ) ?>" >
    </div>
    <div class="title-area-whats">
    <h3><?php _e('WhatsApp Phone Number', 'wac'); ?></h3>
    <p><?php _e('Full phone number in international format. Example:', 'wac'); ?><span class="codewa"><?php _e('+155523456789', 'wac'); ?></span></p>
    </div>
    <div class="onoffswitch-whats">
    <input type="text" size="60" name="whatsapp_chat_page" placeholder="+5512999999999" value="<?php echo esc_attr( get_option('whatsapp_chat_page') ); ?>" />
    </div>
    </div>
    <div class="div-whats" id="whats-box-2">
    <div class="image-container-whats">
    <img src="<?php echo plugins_url( 'images/ativo6.png', __FILE__ ) ?>" >
    </div>
    <div class="title-area-whats">
    <h3><?php _e('Message to start chat', 'wac'); ?></h3>
    <p><?php _e('Pre-filled message that will automatically appear in the text field of a chat. Example:', 'wac'); ?>
    <p><span class="codewa"><?php _e('Hello! I am interested in your service', 'wac'); ?></span></p>
    </div>
    <div class="onoffswitch-whats">
    <input type="text" size="60" name="whatsapp_chat_msg" placeholder="Olá, gostaria de saber mais sobre seu serviço/produto" value="<?php echo esc_attr( get_option('whatsapp_chat_msg') ); ?>" />
    </div>
    </div>
    <div class="div-whats" id="whats-box-3">
    <div class="image-container-whats">
    <img src="<?php echo plugins_url( 'images/ativo7.png', __FILE__ ) ?>" >
    </div>
    <div class="title-area-whats">
    <h3><?php _e('Edit button', 'wac'); ?></h3>
    <p><?php _e('Customize your whatsapp chat message. Example:', 'wac'); ?> <span class="codewa"><?php _e('Chat with me', 'wac'); ?></span></p>
    </div>
    <div class="onoffswitch-whats">
    <input type="text" size="60" name="whatsapp_chat_button" placeholder="WhatsApp" value="<?php echo esc_attr( get_option('whatsapp_chat_button') ); ?>" />
    </div>
    </div>
    <div class="div-whats" id="whats-box-4">
    <div class="image-container-whats">
    <img src="<?php echo plugins_url( 'images/ativo4.png', __FILE__ ) ?>" >
    </div>
    <div class="title-area-whats">
    <h3><?php _e('Hide button', 'wac'); ?></h3>
    <p><?php _e('Turn on to', 'wac'); ?> <span class="codewa"><?php _e('hide whatsapp chat', 'wac'); ?></span><?php _e('for all website.', 'wac'); ?></p>
    </div>
    <div class="onoffswitch-whats">
    <input type="checkbox" name="whatsapp_chat_hide_button" class="onoffswitch-whats-checkbox" id="whatsonoffswitch-4" value="true" <?php echo ( get_option('whatsapp_chat_hide_button') == true ) ? ' checked="checked" />' : ' />'; ?>
            <label class="whatsonoffswitch-label" for="whatsonoffswitch-4">
                <span class="whatsonoffswitch-inner"></span>
                <span class="whatsonoffswitch-switch"></span>
            </label>
    </div>
    </div>
    <div class="div-whats" id="whats-box-5">
    <div class="image-container-whats">
    <img src="<?php echo plugins_url( 'images/ativo2.png', __FILE__ ) ?>" >
    </div>
    <div class="title-area-whats">
    <h3><?php _e('Left Side', 'wac'); ?></h3>
    <p><?php _e('Turn on the switch to move whatsapp chat to the', 'wac'); ?> <span class="codewa"><?php _e('left side of the screen', 'wac'); ?></span></p>
    </div>
    <div class="onoffswitch-whats">
    <input type="checkbox" name="whatsapp_chat_left_side" class="onoffswitch-whats-checkbox" id="whatsonoffswitch-5" value="true" <?php echo ( get_option('whatsapp_chat_left_side') == true ) ? ' checked="checked" />' : ' />'; ?>

            <label class="whatsonoffswitch-label" for="whatsonoffswitch-5">
                <span class="whatsonoffswitch-inner"></span>
                <span class="whatsonoffswitch-switch"></span>
            </label>
    </div>
    </div>
    <div class="div-whats" id="whats-box-6">
    <div class="image-container-whats">
    <img src="<?php echo plugins_url( 'images/ativo3.png', __FILE__ ) ?>" >
    </div>
    <div class="title-area-whats">
    <h3><?php _e('Bottom', 'wac'); ?></h3>
    <p><?php _e('Turn on the switch to move whatsapp chat to the', 'wac'); ?> <span class="codewa"><?php _e('bottom of the screen', 'wac'); ?></span></p>
    <p><?php _e('If left side is ON than whatsapp chat will be', 'wac'); ?> <span class="codewa"><?php _e('on the bottom left.', 'wac'); ?></span></p>
    </div>
    <div class="onoffswitch-whats">
    <input type="checkbox" name="whatsapp_chat_down" class="onoffswitch-whats-checkbox" id="whatsonoffswitch-6" value="true" <?php echo ( get_option('whatsapp_chat_down') == true ) ? ' checked="checked" />' : ' />'; ?>

            <label class="whatsonoffswitch-label" for="whatsonoffswitch-6">
                <span class="whatsonoffswitch-inner"></span>
                <span class="whatsonoffswitch-switch"></span>
            </label>
    </div>
    </div>
    <div class="div-whats" id="whats-box-7">
    <div class="image-container-whats">
    <img src="<?php echo plugins_url( 'images/ativo5.png', __FILE__ ) ?>" >
    </div>
    <div class="title-area-whats">
    <h3><?php _e('Hide on Desktop', 'wac'); ?></h3>
    <p><?php _e('Turn on to keep visible for', 'wac'); ?> <span class="codewa"><?php _e('mobile only.', 'wac'); ?></span></p>
    </div>
    <div class="onoffswitch-whats">
    <input type="checkbox" name="whatsapp_chat_mobile" class="onoffswitch-whats-checkbox" id="whatsonoffswitch-7" value="true" <?php echo ( get_option('whatsapp_chat_mobile') == true ) ? ' checked="checked" />' : ' />'; ?>

            <label class="whatsonoffswitch-label" for="whatsonoffswitch-7">
                <span class="whatsonoffswitch-inner"></span>
                <span class="whatsonoffswitch-switch"></span>
            </label>
    </div>
    </div>
    <div class="div-whats" id="whats-box-8">
    <div class="image-container-whats">
    <img src="<?php echo plugins_url( 'images/ativo11.png', __FILE__ ) ?>" >
    </div>
    <div class="title-area-whats">
    <h3><?php _e('Teal Green.', 'wac'); ?></h3>
    <p><?php _e('Make whatsapp chat dark with color', 'wac'); ?> <span class="codewa"><?php _e('Teal Green', 'wac'); ?></span></p>
    </div>
    <div class="onoffswitch-whats">
    <input type="checkbox" name="whatsapp_chat_dark" class="onoffswitch-whats-checkbox" id="whatsonoffswitch-8" value="true" <?php echo ( get_option('whatsapp_chat_dark') == true ) ? ' checked="checked" />' : ' />'; ?>

            <label class="whatsonoffswitch-label" for="whatsonoffswitch-8">
                <span class="whatsonoffswitch-inner"></span>
                <span class="whatsonoffswitch-switch"></span>
            </label>
    </div>
    </div>
    <div class="div-whats" id="whats-box-9">
    <div class="image-container-whats">
    <img src="<?php echo plugins_url( 'images/ativo10.png', __FILE__ ) ?>" >
    </div>
    <div class="title-area-whats">
    <h3><?php _e('White', 'wac'); ?></h3>
    <p><?php _e('Make whatsapp chat light with color', 'wac'); ?> <span class="codewa"><?php _e('white.', 'wac'); ?></span>.</p>
    </div>
    <div class="onoffswitch-whats">
    <input type="checkbox" name="whatsapp_chat_white" class="onoffswitch-whats-checkbox" id="whatsonoffswitch-9" value="true" <?php echo ( get_option('whatsapp_chat_white') == true ) ? ' checked="checked" />' : ' />'; ?>

            <label class="whatsonoffswitch-label" for="whatsonoffswitch-9">
                <span class="whatsonoffswitch-inner"></span>
                <span class="whatsonoffswitch-switch"></span>
            </label>
    </div>
    </div>
    <div class="div-whats" id="whats-box-10">
    <div class="image-container-whats">
    <img src="<?php echo plugins_url( 'images/ativo12.png', __FILE__ ) ?>" >
    </div>
    <div class="title-area-whats">
    <h3><?php _e('Rounded border', 'wac'); ?></h3>
    <p><span class="codewa"><?php _e('Add rounnded border', 'wac'); ?></span> <?php _e('in whatsapp chat.', 'wac'); ?></p>
    </div>
    <div class="onoffswitch-whats">
    <input type="checkbox" name="whatsapp_chat_round" class="onoffswitch-whats-checkbox" id="whatsonoffswitch-10" value="true" <?php echo ( get_option('whatsapp_chat_round') == true ) ? ' checked="checked" />' : ' />'; ?>

            <label class="whatsonoffswitch-label" for="whatsonoffswitch-10">
                <span class="whatsonoffswitch-inner"></span>
                <span class="whatsonoffswitch-switch"></span>
            </label>
    </div>
    </div>
    <div class="div-whats" id="whats-box-11">
    <div class="image-container-whats">
    <img src="<?php echo plugins_url( 'images/ativo15.png', __FILE__ ) ?>" >
    </div>
    <div class="title-area-whats">
    <h3><?php _e('Hide in pages', 'wac'); ?></h3>
    <p><?php _e('Hide WhatsApp Chat in every', 'wac'); ?> <span class="codewa"><?php _e('page', 'wac'); ?></span></p>
    </div>
    <div class="onoffswitch-whats">
    <input type="checkbox" name="whatsapp_chat_hide_page" class="onoffswitch-whats-checkbox" id="whatsonoffswitch-11" value="true" <?php echo ( get_option('whatsapp_chat_hide_page') == true ) ? ' checked="checked" />' : ' />'; ?>

            <label class="whatsonoffswitch-label" for="whatsonoffswitch-11">
                <span class="whatsonoffswitch-inner"></span>
                <span class="whatsonoffswitch-switch"></span>
            </label>
    </div>
    </div>
    <div class="div-whats" id="whats-box-12">
    <div class="image-container-whats">
    <img src="<?php echo plugins_url( 'images/ativo14.png', __FILE__ ) ?>" >
    </div>
    <div class="title-area-whats">
    <h3><?php _e('Hide in post', 'wac'); ?></h3>
    <p><?php _e('Hide WhatsApp Chat in every', 'wac'); ?> <span class="codewa"><?php _e('post page', 'wac'); ?></span></p>
    </div>
    <div class="onoffswitch-whats">
    <input type="checkbox" name="whatsapp_chat_hide_post" class="onoffswitch-whats-checkbox" id="whatsonoffswitch-12" value="true" <?php echo ( get_option('whatsapp_chat_hide_post') == true ) ? ' checked="checked" />' : ' />'; ?>

            <label class="whatsonoffswitch-label" for="whatsonoffswitch-12">
                <span class="whatsonoffswitch-inner"></span>
                <span class="whatsonoffswitch-switch"></span>
            </label>
    </div>
    </div>
    <div class="div-whats" id="whats-box-13">
    <div class="image-container-whats">
    <img src="<?php echo plugins_url( 'images/ativo16.png', __FILE__ ) ?>" >
    </div>
    <div class="title-area-whats">
    <h3><?php _e('Hide in project', 'wac'); ?></h3>
    <p><?php _e('Hide WhatsApp Chat in every', 'wac'); ?> <span class="codewa"><?php _e('project page', 'wac'); ?></span></p>
    </div>
    <div class="onoffswitch-whats">
    <input type="checkbox" name="whatsapp_chat_hide_project" class="onoffswitch-whats-checkbox" id="whatsonoffswitch-13" value="true" <?php echo ( get_option('whatsapp_chat_hide_project') == true ) ? ' checked="checked" />' : ' />'; ?>

            <label class="whatsonoffswitch-label" for="whatsonoffswitch-13">
                <span class="whatsonoffswitch-inner"></span>
                <span class="whatsonoffswitch-switch"></span>
            </label>
    </div>
    </div>
    <div class="div-whats" id="whats-box-14">
    <div class="image-container-whats">
    <img src="<?php echo plugins_url( 'images/ativo13.png', __FILE__ ) ?>" >
    </div>
    <div class="title-area-whats">
    <h3><?php _e('Hide in product', 'wac'); ?></h3>
    <p><?php _e('Hide WhatsApp Chat in every', 'wac'); ?> <span class="codewa"><?php _e('product page', 'wac'); ?></span></p>
    </div>
    <div class="onoffswitch-whats">
    <input type="checkbox" name="whatsapp_chat_hide_product" class="onoffswitch-whats-checkbox" id="whatsonoffswitch-14" value="true" <?php echo ( get_option('whatsapp_chat_hide_product') == true ) ? ' checked="checked" />' : ' />'; ?>

            <label class="whatsonoffswitch-label" for="whatsonoffswitch-14">
                <span class="whatsonoffswitch-inner"></span>
                <span class="whatsonoffswitch-switch"></span>
            </label>
    </div>
    </div>
    <div class="div-whats" id="whats-box-15">
    <div class="image-container-whats">
    <img src="<?php echo plugins_url( 'images/ativo8.png', __FILE__ ) ?>" >
    </div>
    <div class="title-area-whats">
    <h3><?php _e('Discreet link', 'wac'); ?></h3>
    <p><?php _e('Leave a discreet link to developer to', 'wac'); ?> <span class="codewa"><?php _e('help and keep new updates and support', 'wac'); ?></span></p>
    </div>
    <div class="onoffswitch-whats">
    <input type="checkbox" name="whatsapp_chat_powered_by" class="onoffswitch-whats-checkbox" id="whatsonoffswitch-15" value="true" <?php echo ( get_option('whatsapp_chat_powered_by') == true ) ? ' checked="checked" />' : ' />'; ?>

            <label class="whatsonoffswitch-label" for="whatsonoffswitch-11">
                <span class="whatsonoffswitch-inner"></span>
                <span class="whatsonoffswitch-switch"></span>
            </label>
    </div>
    </div>
    <div class="div-whats" id="whats-box-16">
    <div class="image-container-whats">
    <img src="<?php echo plugins_url( 'images/ativo9.png', __FILE__ ) ?>" >
    </div>
    <div class="title-area-whats">
    <h3><?php _e('Shortcode', 'wac'); ?></h3>
    <p><?php _e('You can use shortcode to create WhatsApp Chat buttons wherever you want', 'wac'); ?></p>
    <p><?php _e('Just copy the shortcode bellow replacing with your phone number and text.', 'wac'); ?></p>
    <p><span class="codewa">[whatsapp phone="0000000000" blank="true"]<?php _e('Chat on WhatsApp', 'wac'); ?>[/whatsapp]</span></p>
    </div>
    </div>
    <div class="div-whats" id="whats-box-17">
    <div class="image-container-whats">
    <img src="<?php echo plugins_url( 'images/agencia.png', __FILE__ ) ?>" >
    </div>
    <div class="title-area-whats">
    <h3>Caporal Mkt Digital</h3>
    <p>Especialistas em performance, novas ferramentas e estratégias digitais para PME, empreendedores e profissionais liberais.</p>
    <p><span class="codewa">Está buscando ampliar seus resultados? Entre em contato para uma estratégia sob medida!</span></p>
    </div>
    <div class="onoffswitch-whats">
    <a href="https://app.caporalmktdigital.com.br/asset/2:contato"><img src="<?php echo plugins_url( 'images/mail.png', __FILE__ ) ?>" ></a>
    </div>
    </div>
     <?php submit_button( __('Save & Chat'), 'submit-whats' ); ?>
     </form>
</div>
</div>

<?php }

function whatsapp_chat_settings() {
    register_setting( 'whatsapp-chat-settings', 'whatsapp_chat_page' );
    register_setting( 'whatsapp-chat-settings', 'whatsapp_chat_msg' );
    register_setting( 'whatsapp-chat-settings', 'whatsapp_chat_hide_button' );
    register_setting( 'whatsapp-chat-settings', 'whatsapp_chat_left_side' );
    register_setting( 'whatsapp-chat-settings', 'whatsapp_chat_down' );
    register_setting( 'whatsapp-chat-settings', 'whatsapp_chat_button' );
    register_setting( 'whatsapp-chat-settings', 'whatsapp_chat_mobile' );
    register_setting( 'whatsapp-chat-settings', 'whatsapp_chat_dark' );
    register_setting( 'whatsapp-chat-settings', 'whatsapp_chat_white' );
    register_setting( 'whatsapp-chat-settings', 'whatsapp_chat_round' );
    register_setting( 'whatsapp-chat-settings', 'whatsapp_chat_hide_page' );
    register_setting( 'whatsapp-chat-settings', 'whatsapp_chat_hide_post' );
    register_setting( 'whatsapp-chat-settings', 'whatsapp_chat_hide_project' );
    register_setting( 'whatsapp-chat-settings', 'whatsapp_chat_hide_product' );
    register_setting( 'whatsapp-chat-settings', 'whatsapp_chat_powered_by' );
}
add_action( 'admin_init', 'whatsapp_chat_settings' );

function whatsapp_chat_deactivation() {
    delete_option( 'whatsapp_chat_page' );
    delete_option( 'whatsapp_chat_msg' );
    delete_option( 'whatsapp_chat_hide_button' );
    delete_option( 'whatsapp_chat_left_side' );
    delete_option( 'whatsapp_chat_down' );
    delete_option( 'whatsapp_chat_button' );
    delete_option( 'whatsapp_chat_mobile' );
    delete_option( 'whatsapp_chat_dark' );
    delete_option( 'whatsapp_chat_white' );
    delete_option( 'whatsapp_chat_round' );
    delete_option( 'whatsapp_chat_hide_page' );
    delete_option( 'whatsapp_chat_hide_post' );
    delete_option( 'whatsapp_chat_hide_project' );
    delete_option( 'whatsapp_chat_hide_product' );
    delete_option( 'whatsapp_chat_powered_by' );
}
register_deactivation_hook( __FILE__, 'whatsapp_chat_deactivation' );

function whatsapp_chat_dependencies() {
    wp_register_style( 'whatsapp-chat-style', plugins_url( 'css/style.css', __FILE__ ) );
    wp_enqueue_style( 'whatsapp-chat-style', plugins_url( 'css/style.css', __FILE__ ) );
}
add_action( 'wp_enqueue_scripts', 'whatsapp_chat_dependencies' );


function shortcode_whatsapp_chat( $atts, $content = null ) {
    extract(shortcode_atts(array(
        'phone'      => '#',
        'blank'     => 'false'
    ), $atts));

    $blank_link = '';

    if ( $blank == 'true' )
        $blank_link = "target=\"_blank\"";

    $out = "<a class=\"whatsapp\" href=\"https://api.whatsapp.com/send?phone=" .$phone. "\"" .$blank_link."><span>" .do_shortcode($content). "</span></a>";

    return $out;
}
add_shortcode('whatsapp', 'shortcode_whatsapp_chat');

function whatsapp_chat() { ?>

<?php if (get_option('whatsapp_chat_hide_button') != true) {
?>
<?php if( is_page() && get_option('whatsapp_chat_hide_page') ) {
} elseif( is_singular( 'post' ) && get_option('whatsapp_chat_hide_post') ) {
} elseif( is_singular( 'project' ) && get_option('whatsapp_chat_hide_project') ) {
} elseif( is_singular( 'product' ) && get_option('whatsapp_chat_hide_product') ) {
} elseif( is_admin() ) {
} else {
    ?>
<div id="wacht<?php if (get_option('whatsapp_chat_left_side') == true) { ?>-leftside<?php } ?><?php if (get_option('whatsapp_chat_down') == true) { ?>-baixo<?php } ?><?php if (get_option('whatsapp_chat_dark') == true) { ?>-dark<?php } ?><?php if (get_option('whatsapp_chat_white') == true) { ?>-white<?php } ?><?php if (get_option('whatsapp_chat_round') == true) { ?>-round<?php } ?><?php if (get_option('whatsapp_chat_mobile') == true) { ?>-mobile<?php } ?>">
<a href="https://<?php if (wp_is_mobile() ) {echo "api";} else {echo "web";}?>.whatsapp.com/send?phone=<?php echo esc_attr( get_option('whatsapp_chat_page')); ?>&text=<?php echo esc_attr( get_option('whatsapp_chat_msg') ); ?>" onclick="gtag('event', 'WhatsApp', {'event_action': 'whatsapp_chat', 'event_category': 'Chat', 'event_label': 'Chat_WhatsApp'});" target="_blank"><?php echo esc_attr( get_option('whatsapp_chat_button')); ?></a><?php if (get_option('whatsapp_chat_powered_by') == true) { ?><a href="https://caporalmktdigital.com.br/" title="Caporal Mkt Digital" class="agencia">agência de marketing digital especializada em estratégias e resultados</a><?php } ?>
</div>
<?php }//hide_button ?>
<?php
}
}
add_action( 'wp_footer', 'whatsapp_chat', 10 );

add_action( 'amp_post_template_css', 'amp_whatsapp_chat_css_styles' );
function amp_whatsapp_chat_css_styles( $amp_template ) { ?>
@font-face {font-family: 'IcoMoon-free'; src: url('<?php echo plugins_url( 'css/fonts/IcoMoon-free.ttf', __FILE__ ) ?>');}
#wacht a {position: fixed; z-index: 9999; right: 0; float:right; top: 40%; margin-top: -25px; cursor: pointer; min-width:50px; max-width:150px; color:#fff; text-align:center; padding:10px; margin:0 auto 0 auto; background:#20B038; -webkit-transition: All 0.5s ease; -moz-transition: All 0.5s ease; -o-transition: All 0.5s ease; -ms-transition: All 0.5s ease; transition: All 0.5s ease;}
#wacht-leftside a {position: fixed; z-index: 9999; left: 0; float:left; top: 40%; margin-top: -25px; cursor: pointer; min-width:50px; max-width:150px; color:#fff; text-align:center; padding:10px; margin:0 auto 0 auto; background:#20B038; -webkit-transition: All 0.5s ease; -moz-transition: All 0.5s ease; -o-transition: All 0.5s ease; -ms-transition: All 0.5s ease; transition: All 0.5s ease;}
#wacht-baixo a {position: fixed; z-index: 9999; right: 0; float:right; top: 90%; margin-top: -25px; cursor: pointer; min-width:50px; max-width:150px; color:#fff; text-align:center; padding:10px; margin:0 auto 0 auto; background:#20B038; -webkit-transition: All 0.5s ease; -moz-transition: All 0.5s ease; -o-transition: All 0.5s ease; -ms-transition: All 0.5s ease; transition: All 0.5s ease;}
#wacht-leftside-baixo a {position: fixed; z-index: 9999; left: 0; float:left; top: 90%; margin-top: -25px; cursor: pointer; min-width:50px; max-width:150px; color:#fff; text-align:center; padding:10px; margin:0 auto 0 auto; background:#20B038; -webkit-transition: All 0.5s ease; -moz-transition: All 0.5s ease; -o-transition: All 0.5s ease; -ms-transition: All 0.5s ease; transition: All 0.5s ease;}
#wacht-dark a {position: fixed; z-index: 9999; right: 0; float:right; top: 40%; margin-top: -25px; cursor: pointer; min-width:50px; max-width:150px; color:#fff; text-align:center; padding:10px; margin:0 auto 0 auto; background:#075E54; -webkit-transition: All 0.5s ease; -moz-transition: All 0.5s ease; -o-transition: All 0.5s ease; -ms-transition: All 0.5s ease; transition: All 0.5s ease;}
#wacht-leftside-dark a {position: fixed; z-index: 9999; left: 0; float:left; top: 40%; margin-top: -25px; cursor: pointer; min-width:50px; max-width:150px; color:#fff; text-align:center; padding:10px; margin:0 auto 0 auto; background:#075E54; -webkit-transition: All 0.5s ease; -moz-transition: All 0.5s ease; -o-transition: All 0.5s ease; -ms-transition: All 0.5s ease; transition: All 0.5s ease;}
#wacht-baixo-dark a {position: fixed; z-index: 9999; right: 0; float:right; top: 90%; margin-top: -25px; cursor: pointer; min-width:50px; max-width:150px; color:#fff; text-align:center; padding:10px; margin:0 auto 0 auto; background:#075E54; -webkit-transition: All 0.5s ease; -moz-transition: All 0.5s ease; -o-transition: All 0.5s ease; -ms-transition: All 0.5s ease; transition: All 0.5s ease;}
#wacht-leftside-baixo-dark a {position: fixed; z-index: 9999; left: 0; float:left; top: 90%; margin-top: -25px; cursor: pointer; min-width:50px; max-width:150px; color:#fff; text-align:center; padding:10px; margin:0 auto 0 auto; background:#075E54; -webkit-transition: All 0.5s ease; -moz-transition: All 0.5s ease; -o-transition: All 0.5s ease; -ms-transition: All 0.5s ease; transition: All 0.5s ease;}
#wacht-white a {position: fixed; z-index: 9999; right: 0; float:right; top: 40%; margin-top: -25px; cursor: pointer; min-width:50px; max-width:150px; color:#075E54; text-align:center; padding:10px; margin:0 auto 0 auto; background:#fff; -webkit-transition: All 0.5s ease; -moz-transition: All 0.5s ease; -o-transition: All 0.5s ease; -ms-transition: All 0.5s ease; transition: All 0.5s ease;}
#wacht-leftside-white a {position: fixed; z-index: 9999; left: 0; float:left; top: 40%; margin-top: -25px; cursor: pointer; min-width:50px; max-width:150px; color:#075E54; text-align:center; padding:10px; margin:0 auto 0 auto; background:#fff; -webkit-transition: All 0.5s ease; -moz-transition: All 0.5s ease; -o-transition: All 0.5s ease; -ms-transition: All 0.5s ease; transition: All 0.5s ease;}
#wacht-baixo-white a {position: fixed; z-index: 9999; right: 0; float:right; top: 90%; margin-top: -25px; cursor: pointer; min-width:50px; max-width:150px; color:#075E54; text-align:center; padding:10px; margin:0 auto 0 auto; background:#fff; -webkit-transition: All 0.5s ease; -moz-transition: All 0.5s ease; -o-transition: All 0.5s ease; -ms-transition: All 0.5s ease; transition: All 0.5s ease;}
#wacht-leftside-baixo-white a {position: fixed; z-index: 9999; left: 0; float:left; top: 90%; margin-top: -25px; cursor: pointer; min-width:50px; max-width:150px; color:#075E54; text-align:center; padding:10px; margin:0 auto 0 auto; background:#fff; -webkit-transition: All 0.5s ease; -moz-transition: All 0.5s ease; -o-transition: All 0.5s ease; -ms-transition: All 0.5s ease; transition: All 0.5s ease;}
#wacht-round a {position: fixed; z-index: 9999; right: 0; float:right; top: 40%; margin-top: -25px; cursor: pointer; min-width:50px; max-width:150px; color:#fff; text-align:center; padding:10px; margin:0 auto 0 auto; background:#20B038; -webkit-transition: All 0.5s ease; -moz-transition: All 0.5s ease; -o-transition: All 0.5s ease; -ms-transition: All 0.5s ease; transition: All 0.5s ease; border-radius: 50px;}
#wacht-leftside-round a {position: fixed; z-index: 9999; left: 0; float:left; top: 40%; margin-top: -25px; cursor: pointer; min-width:50px; max-width:150px; color:#fff; text-align:center; padding:10px; margin:0 auto 0 auto; background:#20B038; -webkit-transition: All 0.5s ease; -moz-transition: All 0.5s ease; -o-transition: All 0.5s ease; -ms-transition: All 0.5s ease; transition: All 0.5s ease; border-radius: 50px;}
#wacht-baixo-round a {position: fixed; z-index: 9999; right: 0; float:right; top: 90%; margin-top: -25px; cursor: pointer; min-width:50px; max-width:150px; color:#fff; text-align:center; padding:10px; margin:0 auto 0 auto; background:#20B038; -webkit-transition: All 0.5s ease; -moz-transition: All 0.5s ease; -o-transition: All 0.5s ease; -ms-transition: All 0.5s ease; transition: All 0.5s ease; border-radius: 50px;}
#wacht-leftside-baixo-round a {position: fixed; z-index: 9999; left: 0; float:left; top: 90%; margin-top: -25px; cursor: pointer; min-width:50px; max-width:150px; color:#fff; text-align:center; padding:10px; margin:0 auto 0 auto; background:#20B038; -webkit-transition: All 0.5s ease; -moz-transition: All 0.5s ease; -o-transition: All 0.5s ease; -ms-transition: All 0.5s ease; transition: All 0.5s ease; border-radius: 50px;}
#wacht-dark-round a {position: fixed; z-index: 9999; right: 0; float:right; top: 40%; margin-top: -25px; cursor: pointer; min-width:50px; max-width:150px; color:#fff; text-align:center; padding:10px; margin:0 auto 0 auto; background:#075E54; -webkit-transition: All 0.5s ease; -moz-transition: All 0.5s ease; -o-transition: All 0.5s ease; -ms-transition: All 0.5s ease; transition: All 0.5s ease; border-radius: 50px;}
#wacht-leftside-dark-round a {position: fixed; z-index: 9999; left: 0; float:left; top: 40%; margin-top: -25px; cursor: pointer; min-width:50px; max-width:150px; color:#fff; text-align:center; padding:10px; margin:0 auto 0 auto; background:#075E54; -webkit-transition: All 0.5s ease; -moz-transition: All 0.5s ease; -o-transition: All 0.5s ease; -ms-transition: All 0.5s ease; transition: All 0.5s ease; border-radius: 50px;}
#wacht-baixo-dark-round a {position: fixed; z-index: 9999; right: 0; float:right; top: 90%; margin-top: -25px; cursor: pointer; min-width:50px; max-width:150px; color:#fff; text-align:center; padding:10px; margin:0 auto 0 auto; background:#075E54; -webkit-transition: All 0.5s ease; -moz-transition: All 0.5s ease; -o-transition: All 0.5s ease; -ms-transition: All 0.5s ease; transition: All 0.5s ease; border-radius: 50px;}
#wacht-leftside-baixo-dark-round a {position: fixed; z-index: 9999; left: 0; float:left; top: 90%; margin-top: -25px; cursor: pointer; min-width:50px; max-width:150px; color:#fff; text-align:center; padding:10px; margin:0 auto 0 auto; background:#075E54; -webkit-transition: All 0.5s ease; -moz-transition: All 0.5s ease; -o-transition: All 0.5s ease; -ms-transition: All 0.5s ease; transition: All 0.5s ease; border-radius: 50px;}
#wacht-white-round a {position: fixed; z-index: 9999; right: 0; float:right; top: 40%; margin-top: -25px; cursor: pointer; min-width:50px; max-width:150px; color:#075E54; text-align:center; padding:10px; margin:0 auto 0 auto; background:#fff; -webkit-transition: All 0.5s ease; -moz-transition: All 0.5s ease; -o-transition: All 0.5s ease; -ms-transition: All 0.5s ease; transition: All 0.5s ease; border-radius: 50px;}
#wacht-leftside-white-round a {position: fixed; z-index: 9999; left: 0; float:left; top: 40%; margin-top: -25px; cursor: pointer; min-width:50px; max-width:150px; color:#075E54; text-align:center; padding:10px; margin:0 auto 0 auto; background:#fff; -webkit-transition: All 0.5s ease; -moz-transition: All 0.5s ease; -o-transition: All 0.5s ease; -ms-transition: All 0.5s ease; transition: All 0.5s ease; border-radius: 50px;}
#wacht-baixo-white-round a {position: fixed; z-index: 9999; right: 0; float:right; top: 90%; margin-top: -25px; cursor: pointer; min-width:50px; max-width:150px; color:#075E54; text-align:center; padding:10px; margin:0 auto 0 auto; background:#fff; -webkit-transition: All 0.5s ease; -moz-transition: All 0.5s ease; -o-transition: All 0.5s ease; -ms-transition: All 0.5s ease; transition: All 0.5s ease; border-radius: 50px;}
#wacht-leftside-baixo-white-round a {position: fixed; z-index: 9999; left: 0; float:left; top: 90%; margin-top: -25px; cursor: pointer; min-width:50px; max-width:150px; color:#075E54; text-align:center; padding:10px; margin:0 auto 0 auto; background:#fff; -webkit-transition: All 0.5s ease; -moz-transition: All 0.5s ease; -o-transition: All 0.5s ease; -ms-transition: All 0.5s ease; transition: All 0.5s ease; border-radius: 50px;}
#wacht a:before {font-family: "IcoMoon-free"; content: '\ea93'; margin-left: 5px; margin-right: 5px}
#wacht-leftside a:before {font-family: "IcoMoon-free"; content: '\ea93'; margin-left: 5px; margin-right: 5px}
#wacht-baixo a:before {font-family: "IcoMoon-free"; content: '\ea93'; margin-left: 5px; margin-right: 5px}
#wacht-leftside-baixo a:before {font-family: "IcoMoon-free"; content: '\ea93'; margin-left: 5px; margin-right: 5px}
#wacht-dark a:before {font-family: "IcoMoon-free"; content: '\ea93'; margin-left: 5px; margin-right: 5px}
#wacht-leftside-dark a:before {font-family: "IcoMoon-free"; content: '\ea93'; margin-left: 5px; margin-right: 5px}
#wacht-baixo-dark a:before {font-family: "IcoMoon-free"; content: '\ea93'; margin-left: 5px; margin-right: 5px}
#wacht-leftside-baixo-dark a:before {font-family: "IcoMoon-free"; content: '\ea93'; margin-left: 5px; margin-right: 5px}
#wacht-white a:before {font-family: "IcoMoon-free"; content: '\ea93'; margin-left: 5px; margin-right: 5px}
#wacht-leftside-white a:before {font-family: "IcoMoon-free"; content: '\ea93'; margin-left: 5px; margin-right: 5px}
#wacht-baixo-white a:before {font-family: "IcoMoon-free"; content: '\ea93'; margin-left: 5px; margin-right: 5px}
#wacht-leftside-baixo-white a:before {font-family: "IcoMoon-free"; content: '\ea93'; margin-left: 5px; margin-right: 5px}
#wacht-round a:before {font-family: "IcoMoon-free"; content: '\ea93'; margin-left: 5px; margin-right: 5px}
#wacht-leftside-round a:before {font-family: "IcoMoon-free"; content: '\ea93'; margin-left: 5px; margin-right: 5px}
#wacht-baixo-round a:before {font-family: "IcoMoon-free"; content: '\ea93'; margin-left: 5px; margin-right: 5px}
#wacht-leftside-baixo-round a:before {font-family: "IcoMoon-free"; content: '\ea93'; margin-left: 5px; margin-right: 5px}
#wacht-dark-round a:before {font-family: "IcoMoon-free"; content: '\ea93'; margin-left: 5px; margin-right: 5px}
#wacht-leftside-dark-round a:before {font-family: "IcoMoon-free"; content: '\ea93'; margin-left: 5px; margin-right: 5px}
#wacht-baixo-dark-round a:before {font-family: "IcoMoon-free"; content: '\ea93'; margin-left: 5px; margin-right: 5px}
#wacht-leftside-baixo-dark-round a:before {font-family: "IcoMoon-free"; content: '\ea93'; margin-left: 5px; margin-right: 5px}
#wacht-white-round a:before {font-family: "IcoMoon-free"; content: '\ea93'; margin-left: 5px; margin-right: 5px}
#wacht-leftside-white-round a:before {font-family: "IcoMoon-free"; content: '\ea93'; margin-left: 5px; margin-right: 5px}
#wacht-baixo-white-round a:before {font-family: "IcoMoon-free"; content: '\ea93'; margin-left: 5px; margin-right: 5px}
#wacht-leftside-baixo-white-round a:before {font-family: "IcoMoon-free"; content: '\ea93'; margin-left: 5px; margin-right: 5px}
a.whatsapp:before {font-family: "IcoMoon-free"; content: '\ea93'; margin-left: 5px; margin-right: 5px}
a.whatsapp {min-width:50px; max-width:150px; color:#fff; text-align:center; padding:10px; margin:0 auto 0 auto; background:#20B038; -webkit-transition: All 0.5s ease; -moz-transition: All 0.5s ease; -o-transition: All 0.5s ease; -ms-transition: All 0.5s ease; transition: All 0.5s ease;}
#wacht-mobile a {position: fixed; z-index: 9999; right: 0; float:right; top: 40%; margin-top: -25px; cursor: pointer; min-width:50px; max-width:150px; color:#fff; text-align:center; padding:10px; margin:0 auto 0 auto; background:#20B038; -webkit-transition: All 0.5s ease; -moz-transition: All 0.5s ease; -o-transition: All 0.5s ease; -ms-transition: All 0.5s ease; transition: All 0.5s ease;}
#wacht-leftside-mobile a {position: fixed; z-index: 9999; left: 0; float:left; top: 40%; margin-top: -25px; cursor: pointer; min-width:50px; max-width:150px; color:#fff; text-align:center; padding:10px; margin:0 auto 0 auto; background:#20B038; -webkit-transition: All 0.5s ease; -moz-transition: All 0.5s ease; -o-transition: All 0.5s ease; -ms-transition: All 0.5s ease; transition: All 0.5s ease;}
#wacht-baixo-mobile a {position: fixed; z-index: 9999; right: 0; float:right; top: 90%; margin-top: -25px; cursor: pointer; min-width:50px; max-width:150px; color:#fff; text-align:center; padding:10px; margin:0 auto 0 auto; background:#20B038; -webkit-transition: All 0.5s ease; -moz-transition: All 0.5s ease; -o-transition: All 0.5s ease; -ms-transition: All 0.5s ease; transition: All 0.5s ease;}
#wacht-leftside-baixo-mobile a {position: fixed; z-index: 9999; left: 0; float:left; top: 90%; margin-top: -25px; cursor: pointer; min-width:50px; max-width:150px; color:#fff; text-align:center; padding:10px; margin:0 auto 0 auto; background:#20B038; -webkit-transition: All 0.5s ease; -moz-transition: All 0.5s ease; -o-transition: All 0.5s ease; -ms-transition: All 0.5s ease; transition: All 0.5s ease;}
#wacht-dark-mobile a {position: fixed; z-index: 9999; right: 0; float:right; top: 40%; margin-top: -25px; cursor: pointer; min-width:50px; max-width:150px; color:#fff; text-align:center; padding:10px; margin:0 auto 0 auto; background:#075E54; -webkit-transition: All 0.5s ease; -moz-transition: All 0.5s ease; -o-transition: All 0.5s ease; -ms-transition: All 0.5s ease; transition: All 0.5s ease;}
#wacht-leftside-dark-mobile a {position: fixed; z-index: 9999; left: 0; float:left; top: 40%; margin-top: -25px; cursor: pointer; min-width:50px; max-width:150px; color:#fff; text-align:center; padding:10px; margin:0 auto 0 auto; background:#075E54; -webkit-transition: All 0.5s ease; -moz-transition: All 0.5s ease; -o-transition: All 0.5s ease; -ms-transition: All 0.5s ease; transition: All 0.5s ease;}
#wacht-baixo-dark-mobile a {position: fixed; z-index: 9999; right: 0; float:right; top: 90%; margin-top: -25px; cursor: pointer; min-width:50px; max-width:150px; color:#fff; text-align:center; padding:10px; margin:0 auto 0 auto; background:#075E54; -webkit-transition: All 0.5s ease; -moz-transition: All 0.5s ease; -o-transition: All 0.5s ease; -ms-transition: All 0.5s ease; transition: All 0.5s ease;}
#wacht-leftside-baixo-dark-mobile a {position: fixed; z-index: 9999; left: 0; float:left; top: 90%; margin-top: -25px; cursor: pointer; min-width:50px; max-width:150px; color:#fff; text-align:center; padding:10px; margin:0 auto 0 auto; background:#075E54; -webkit-transition: All 0.5s ease; -moz-transition: All 0.5s ease; -o-transition: All 0.5s ease; -ms-transition: All 0.5s ease; transition: All 0.5s ease;}
#wacht-white-mobile a {position: fixed; z-index: 9999; right: 0; float:right; top: 40%; margin-top: -25px; cursor: pointer; min-width:50px; max-width:150px; color:#075E54; text-align:center; padding:10px; margin:0 auto 0 auto; background:#fff; -webkit-transition: All 0.5s ease; -moz-transition: All 0.5s ease; -o-transition: All 0.5s ease; -ms-transition: All 0.5s ease; transition: All 0.5s ease;}
#wacht-leftside-white-mobile a {position: fixed; z-index: 9999; left: 0; float:left; top: 40%; margin-top: -25px; cursor: pointer; min-width:50px; max-width:150px; color:#075E54; text-align:center; padding:10px; margin:0 auto 0 auto; background:#fff; -webkit-transition: All 0.5s ease; -moz-transition: All 0.5s ease; -o-transition: All 0.5s ease; -ms-transition: All 0.5s ease; transition: All 0.5s ease;}
#wacht-baixo-white-mobile a {position: fixed; z-index: 9999; right: 0; float:right; top: 90%; margin-top: -25px; cursor: pointer; min-width:50px; max-width:150px; color:#075E54; text-align:center; padding:10px; margin:0 auto 0 auto; background:#fff; -webkit-transition: All 0.5s ease; -moz-transition: All 0.5s ease; -o-transition: All 0.5s ease; -ms-transition: All 0.5s ease; transition: All 0.5s ease;}
#wacht-leftside-baixo-white-mobile a {position: fixed; z-index: 9999; left: 0; float:left; top: 90%; margin-top: -25px; cursor: pointer; min-width:50px; max-width:150px; color:#075E54; text-align:center; padding:10px; margin:0 auto 0 auto; background:#fff; -webkit-transition: All 0.5s ease; -moz-transition: All 0.5s ease; -o-transition: All 0.5s ease; -ms-transition: All 0.5s ease; transition: All 0.5s ease;}
#wacht-round-mobile a {position: fixed; z-index: 9999; right: 0; float:right; top: 40%; margin-top: -25px; cursor: pointer; min-width:50px; max-width:150px; color:#fff; text-align:center; padding:10px; margin:0 auto 0 auto; background:#20B038; -webkit-transition: All 0.5s ease; -moz-transition: All 0.5s ease; -o-transition: All 0.5s ease; -ms-transition: All 0.5s ease; transition: All 0.5s ease; border-radius: 50px;}
#wacht-leftside-round-mobile a {position: fixed; z-index: 9999; left: 0; float:left; top: 40%; margin-top: -25px; cursor: pointer; min-width:50px; max-width:150px; color:#fff; text-align:center; padding:10px; margin:0 auto 0 auto; background:#20B038; -webkit-transition: All 0.5s ease; -moz-transition: All 0.5s ease; -o-transition: All 0.5s ease; -ms-transition: All 0.5s ease; transition: All 0.5s ease; border-radius: 50px;}
#wacht-baixo-round-mobile a {position: fixed; z-index: 9999; right: 0; float:right; top: 90%; margin-top: -25px; cursor: pointer; min-width:50px; max-width:150px; color:#fff; text-align:center; padding:10px; margin:0 auto 0 auto; background:#20B038; -webkit-transition: All 0.5s ease; -moz-transition: All 0.5s ease; -o-transition: All 0.5s ease; -ms-transition: All 0.5s ease; transition: All 0.5s ease; border-radius: 50px;}
#wacht-leftside-baixo-round-mobile a {position: fixed; z-index: 9999; left: 0; float:left; top: 90%; margin-top: -25px; cursor: pointer; min-width:50px; max-width:150px; color:#fff; text-align:center; padding:10px; margin:0 auto 0 auto; background:#20B038; -webkit-transition: All 0.5s ease; -moz-transition: All 0.5s ease; -o-transition: All 0.5s ease; -ms-transition: All 0.5s ease; transition: All 0.5s ease; border-radius: 50px;}
#wacht-dark-round-mobile a {position: fixed; z-index: 9999; right: 0; float:right; top: 40%; margin-top: -25px; cursor: pointer; min-width:50px; max-width:150px; color:#fff; text-align:center; padding:10px; margin:0 auto 0 auto; background:#075E54; -webkit-transition: All 0.5s ease; -moz-transition: All 0.5s ease; -o-transition: All 0.5s ease; -ms-transition: All 0.5s ease; transition: All 0.5s ease; border-radius: 50px;}
#wacht-leftside-dark-round-mobile a {position: fixed; z-index: 9999; left: 0; float:left; top: 40%; margin-top: -25px; cursor: pointer; min-width:50px; max-width:150px; color:#fff; text-align:center; padding:10px; margin:0 auto 0 auto; background:#075E54; -webkit-transition: All 0.5s ease; -moz-transition: All 0.5s ease; -o-transition: All 0.5s ease; -ms-transition: All 0.5s ease; transition: All 0.5s ease; border-radius: 50px;}
#wacht-baixo-dark-round-mobile a {position: fixed; z-index: 9999; right: 0; float:right; top: 90%; margin-top: -25px; cursor: pointer; min-width:50px; max-width:150px; color:#fff; text-align:center; padding:10px; margin:0 auto 0 auto; background:#075E54; -webkit-transition: All 0.5s ease; -moz-transition: All 0.5s ease; -o-transition: All 0.5s ease; -ms-transition: All 0.5s ease; transition: All 0.5s ease; border-radius: 50px;}
#wacht-leftside-baixo-dark-round-mobile a {position: fixed; z-index: 9999; left: 0; float:left; top: 90%; margin-top: -25px; cursor: pointer; min-width:50px; max-width:150px; color:#fff; text-align:center; padding:10px; margin:0 auto 0 auto; background:#075E54; -webkit-transition: All 0.5s ease; -moz-transition: All 0.5s ease; -o-transition: All 0.5s ease; -ms-transition: All 0.5s ease; transition: All 0.5s ease; border-radius: 50px;}
#wacht-white-round-mobile a {position: fixed; z-index: 9999; right: 0; float:right; top: 40%; margin-top: -25px; cursor: pointer; min-width:50px; max-width:150px; color:#075E54; text-align:center; padding:10px; margin:0 auto 0 auto; background:#fff; -webkit-transition: All 0.5s ease; -moz-transition: All 0.5s ease; -o-transition: All 0.5s ease; -ms-transition: All 0.5s ease; transition: All 0.5s ease; border-radius: 50px;}
#wacht-leftside-white-round-mobile a {position: fixed; z-index: 9999; left: 0; float:left; top: 40%; margin-top: -25px; cursor: pointer; min-width:50px; max-width:150px; color:#075E54; text-align:center; padding:10px; margin:0 auto 0 auto; background:#fff; -webkit-transition: All 0.5s ease; -moz-transition: All 0.5s ease; -o-transition: All 0.5s ease; -ms-transition: All 0.5s ease; transition: All 0.5s ease; border-radius: 50px;}
#wacht-baixo-white-round-mobile a {position: fixed; z-index: 9999; right: 0; float:right; top: 90%; margin-top: -25px; cursor: pointer; min-width:50px; max-width:150px; color:#075E54; text-align:center; padding:10px; margin:0 auto 0 auto; background:#fff; -webkit-transition: All 0.5s ease; -moz-transition: All 0.5s ease; -o-transition: All 0.5s ease; -ms-transition: All 0.5s ease; transition: All 0.5s ease; border-radius: 50px;}
#wacht-leftside-baixo-white-round-mobile a {position: fixed; z-index: 9999; left: 0; float:left; top: 90%; margin-top: -25px; cursor: pointer; min-width:50px; max-width:150px; color:#075E54; text-align:center; padding:10px; margin:0 auto 0 auto; background:#fff; -webkit-transition: All 0.5s ease; -moz-transition: All 0.5s ease; -o-transition: All 0.5s ease; -ms-transition: All 0.5s ease; transition: All 0.5s ease; border-radius: 50px;}
#wacht-mobile a:before {font-family: "IcoMoon-free"; content: '\ea93'; margin-left: 5px; margin-right: 5px}
#wacht-leftside-mobile a:before {font-family: "IcoMoon-free"; content: '\ea93'; margin-left: 5px; margin-right: 5px}
#wacht-baixo-mobile a:before {font-family: "IcoMoon-free"; content: '\ea93'; margin-left: 5px; margin-right: 5px}
#wacht-leftside-baixo-mobile a:before {font-family: "IcoMoon-free"; content: '\ea93'; margin-left: 5px; margin-right: 5px}
#wacht-dark-mobile a:before {font-family: "IcoMoon-free"; content: '\ea93'; margin-left: 5px; margin-right: 5px}
#wacht-leftside-dark-mobile a:before {font-family: "IcoMoon-free"; content: '\ea93'; margin-left: 5px; margin-right: 5px}
#wacht-baixo-dark-mobile a:before {font-family: "IcoMoon-free"; content: '\ea93'; margin-left: 5px; margin-right: 5px}
#wacht-leftside-baixo-dark-mobile a:before {font-family: "IcoMoon-free"; content: '\ea93'; margin-left: 5px; margin-right: 5px}
#wacht-white-mobile a:before {font-family: "IcoMoon-free"; content: '\ea93'; margin-left: 5px; margin-right: 5px}
#wacht-leftside-white-mobile a:before {font-family: "IcoMoon-free"; content: '\ea93'; margin-left: 5px; margin-right: 5px}
#wacht-baixo-white-mobile a:before {font-family: "IcoMoon-free"; content: '\ea93'; margin-left: 5px; margin-right: 5px}
#wacht-leftside-baixo-white-mobile a:before {font-family: "IcoMoon-free"; content: '\ea93'; margin-left: 5px; margin-right: 5px}
#wacht-round-mobile a:before {font-family: "IcoMoon-free"; content: '\ea93'; margin-left: 5px; margin-right: 5px}
#wacht-leftside-round-mobile a:before {font-family: "IcoMoon-free"; content: '\ea93'; margin-left: 5px; margin-right: 5px}
#wacht-baixo-round-mobile a:before {font-family: "IcoMoon-free"; content: '\ea93'; margin-left: 5px; margin-right: 5px}
#wacht-leftside-baixo-round-mobile a:before {font-family: "IcoMoon-free"; content: '\ea93'; margin-left: 5px; margin-right: 5px}
#wacht-dark-round-mobile a:before {font-family: "IcoMoon-free"; content: '\ea93'; margin-left: 5px; margin-right: 5px}
#wacht-leftside-dark-round-mobile a:before {font-family: "IcoMoon-free"; content: '\ea93'; margin-left: 5px; margin-right: 5px}
#wacht-baixo-dark-round-mobile a:before {font-family: "IcoMoon-free"; content: '\ea93'; margin-left: 5px; margin-right: 5px}
#wacht-leftside-baixo-dark-round-mobile a:before {font-family: "IcoMoon-free"; content: '\ea93'; margin-left: 5px; margin-right: 5px}
#wacht-white-round-mobile a:before {font-family: "IcoMoon-free"; content: '\ea93'; margin-left: 5px; margin-right: 5px}
#wacht-leftside-white-round-mobile a:before {font-family: "IcoMoon-free"; content: '\ea93'; margin-left: 5px; margin-right: 5px}
#wacht-baixo-white-round-mobile a:before {font-family: "IcoMoon-free"; content: '\ea93'; margin-left: 5px; margin-right: 5px}
#wacht-leftside-baixo-white-round-mobile a:before {font-family: "IcoMoon-free"; content: '\ea93'; margin-left: 5px; margin-right: 5px}
@media only screen and (min-width: 980px) {#wacht-mobile, #wacht-leftside-mobile, #wacht-baixo-mobile, #wacht-leftside-baixo-mobile, #wacht-dark-mobile, #wacht-leftside-dark-mobile, #wacht-baixo-dark-mobile, #wacht-leftside-baixo-dark-mobile, #wacht-white-mobile, #wacht-leftside-white-mobile, #wacht-baixo-white-mobile, #wacht-leftside-baixo-white-mobile, #wacht-leftside-baixo-white-round-mobile, #wacht-baixo-white-round-mobile, #wacht-leftside-white-round-mobile, #wacht-white-round-mobile, #wacht-leftside-baixo-dark-round-mobile, #wacht-baixo-dark-round-mobile, #wacht-leftside-dark-round-mobile, #wacht-dark-round-mobile, #wacht-leftside-baixo-round-mobile, #wacht-baixo-round-mobile, #wacht-leftside-round-mobile, #wacht-round-mobile a {display: none;}}
<?php }

add_action( 'amp_post_template_footer', 'amp_whatsapp_chat' );

function amp_whatsapp_chat( $amp_template ) { ?>
<div id="wacht<?php if (get_option('whatsapp_chat_left_side') == true) { ?>-leftside<?php } ?><?php if (get_option('whatsapp_chat_down') == true) { ?>-baixo<?php } ?><?php if (get_option('whatsapp_chat_dark') == true) { ?>-dark<?php } ?><?php if (get_option('whatsapp_chat_white') == true) { ?>-white<?php } ?><?php if (get_option('whatsapp_chat_round') == true) { ?>-round<?php } ?><?php if (get_option('whatsapp_chat_mobile') == true) { ?>-mobile<?php } ?>">
<a href="https://<?php if (wp_is_mobile() ) {echo "api";} else {echo "web";}?>.whatsapp.com/send?phone=<?php echo esc_attr( get_option('whatsapp_chat_page')); ?>&text=<?php echo esc_attr( get_option('whatsapp_chat_msg') ); ?>" onclick="gtag('event', 'WhatsApp', {'event_action': 'whatsapp_chat', 'event_category': 'Chat', 'event_label': 'Chat_WhatsApp'}); fbq('track', 'WhatsAppChat');" target="_blank"><?php echo esc_attr( get_option('whatsapp_chat_button')); ?></a>
</div>

<?php }