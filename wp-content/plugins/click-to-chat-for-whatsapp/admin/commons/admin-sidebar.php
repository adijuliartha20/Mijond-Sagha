<?php
/**
 * sidebar in admin area - plugin settings page.
 * 
 * @uses at settings_page.php
 * plan to use in sp_customize_styles.php
 * 
 */

if ( ! defined( 'ABSPATH' ) ) exit;

?>



<div class="wca-plugin">

        <div class="col s10 offset-s2 offset-m3 offset-xl2">
            <div class="card blue-grey darken-1" style="margin-bottom: 0;">
                <div class="card-content white-text">
                    <span class="card-title"><?php _e( 'Click - WordPress Plugin for WhatsApp' , 'click-to-chat-for-whatsapp' ) ?></span>
                    <br>
                    <p><?php _e( 'Add your own Style' , 'click-to-chat-for-whatsapp' ) ?> </p>
                    <br>
                    <p><?php _e( 'WooCommerce' , 'click-to-chat-for-whatsapp' ) ?></p>
                    <br>
                    <p><?php _e( 'WhatsApp Chat, Group chat, Share' , 'click-to-chat-for-whatsapp' ) ?></p>
                </div>
                <div class="card-action">
                    <a target="_blank" href="https://www.holithemes.com/go/click"><?php _e( 'Click - WordPress Plugin for WhatsApp' , 'click-to-chat-for-whatsapp' ) ?></a>
                </div>
            </div>
            <small class="admin_sidebar_hide_option" onclick="ccw_hide_admin_sidebar_card()" style="cursor: pointer;">Hide this card</small>
        </div>

</div>