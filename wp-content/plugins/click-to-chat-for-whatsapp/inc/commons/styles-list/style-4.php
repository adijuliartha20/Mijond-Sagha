<?php

if ( ! defined( 'ABSPATH' ) ) exit;

// wp_enqueue_style('ccw_md_css');

// $ccw_options_cs = get_option('ccw_options_cs');
$s4_text_color = esc_attr( $ccw_options_cs['s4_text_color'] );
$s4_background_color = esc_attr( $ccw_options_cs['s4_background_color'] );

?>
<div class="ccw_plugin chatbot" style="<?php echo $p1 ?>; <?php echo $p2 ?>;">
    <!-- style 4   chip - logo+text -->
    <div class="style4 animated <?php echo $an_on_load .' '. $an_on_hover ?>">
        <a target="_blank" href="<?php echo $redirect_a ?>" class="nofocus">
            <div class="chip ccw-analytics" id="style-4" data-ccw="style-4" style="color: <?php echo $s4_text_color ?>; background-color: <?php echo $s4_background_color ?>;" >
                <!-- <img class="" id="s4-icon" data-ccw="style-4" src="<?php echo plugins_url( './assets/img/whatsapp-logo.png', HT_CCW_PLUGIN_FILE ) ?>" alt="WhatsApp chat"> -->
                <img class="ccw-analytics" id="s4-icon" data-ccw="style-4" src="<?php echo plugins_url( './assets/img/whatsapp-logo-32x32.png', HT_CCW_PLUGIN_FILE ) ?>" alt="WhatsApp chat">
                <?php echo $val ?>
            </div>  
        </a>
    </div>
</div>
