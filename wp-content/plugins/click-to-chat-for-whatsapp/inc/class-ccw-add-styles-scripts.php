<?php
/**
 * css, javascript files for front end.
 * if need to register for admin side at at add_stles_scripts_admin.php file
 * 
 * it may be better to make user can disable styles/ scripts .. 
 * 
 * mdjs.js - material design - js - style 1 only needed - added at template file style-1.php
 * app.js  -  autop issue solution, animtions - added for all styles
 * 
 * mainstyles.css  -  for all styles .. 
 * mdstyles.css  - style 1, 4, 8 needed - 
 *                  for floating style added with conditons - in this file
 *                  for shortcodes added at there related template files.. ( sc-style- .php )
 * for shortcode - if user faces issue, as style apply to elements later 
 *      - then uncomment a line, then works normal  
 *        - wp_enqueue_style('ccw_md_css'); - ( 46th line or near .. )
 * 
 * admin_mainstyles.css, admin_app-works.js - admin side
 * 
 * 
 * 
 * @package ccw
 * @since 1.0
 */
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'CCW_Add_Styles_Scripts' ) ) :
    
class CCW_Add_Styles_Scripts {


    /**
	 * Register styles - front end ( non admin )
	 *
	 * @since 1.0
	 */
    function ccw_register_files() {

        wp_register_style('ccw_main_css', plugins_url( 'assets/css/mainstyles.css', HT_CCW_PLUGIN_FILE ), '', HT_CCW_VERSION );
        wp_enqueue_style('ccw_main_css');
        
        
        wp_register_style('ccw_md_css', plugins_url( 'assets/css/required/mdstyles.css', HT_CCW_PLUGIN_FILE ), '', HT_CCW_VERSION );
        // needs - s1, s4, s8
        // wp_enqueue_style('ccw_md_css');
        
        
        // As now merging anstyles.css in mainstyles.css - as total is less then 10kb
        // wp_register_style('ccw_an_css', plugins_url( 'assets/css/anstyles.css', HT_CCW_PLUGIN_FILE ), '', HT_CCW_VERSION );
        // needs - only if animations are enable
        // wp_enqueue_style('ccw_an_css');


        
        wp_enqueue_script( 'ccw_app', plugins_url( 'assets/js/app.js', HT_CCW_PLUGIN_FILE ), array ( 'jquery' ), HT_CCW_VERSION, true );

        // only style-1 needed
        wp_register_script( 'ccw_md_js', plugins_url( 'assets/js/required/mdjs.js', HT_CCW_PLUGIN_FILE ), array ( 'jquery' ), HT_CCW_VERSION, true );
        // wp_register_script( 'ccw_md_js', plugins_url( 'assets/js/md.js', HT_CCW_PLUGIN_FILE ), array ( 'jquery' ), HT_CCW_VERSION, true );




        // As now - for floating style - enqueue md style added like this
        // but for shortcodes enqueue while calling that template file
        $mobile_style = ht_ccw()->variables->get_option['stylemobile'];
        $desktop_style = ht_ccw()->variables->get_option['style'];

        /**
         * is mobile or not
         * and then enqueue styles if selected style is 1, 4, 8
         */
        if ( 1 == ht_ccw()->device_type->is_mobile ) {
            if ( 1 == $mobile_style || 4 == $mobile_style || 8 == $mobile_style ) {
                wp_enqueue_style('ccw_md_css');
            }
        } else {
            if ( 1 == $desktop_style || 4 == $desktop_style || 8 == $desktop_style ) {
                wp_enqueue_style('ccw_md_css');
            }
        }


        
    }



    /**
     * enqueue only on style-1
     * @uses action hook - wp_enqueue_scripts - $this page.
     * 
     * now added directly in style-1.php
     * dont delte this easily - may need to enable from here 
     */
    // public function scripts_md_js() {
    //     wp_enqueue_script( 'ccw_md_js');
    // }


    /**
     * 
     * AS now merged animations with main.css .. as animations is less then 10kb
     * 
	 * Register Animations - front end ( non admin )
     * needs only if animations enable
     * adds - anstyles.css
	 *  
	 * @since 1.4
	 */
    // function register_animations() {

    //     wp_register_style('ccw_an_css', plugins_url( 'assets/css/anstyles.css', HT_CCW_PLUGIN_FILE ), '', HT_CCW_VERSION );
    //     wp_enqueue_style('ccw_an_css');

    //     // as now animation related javascript is merged with app.js 
    //     //  so no need to enable seperate 
    //     //  added seperatly also - it will be less then 3kb so merged with app.js
    // }



}

endif; // END class_exists check


$add_styles_scripts = new CCW_Add_Styles_Scripts();

add_action('wp_enqueue_scripts', array( $add_styles_scripts, 'ccw_register_files' ) );





// now added directly in style-1.php - script added there is not an issue
//    but css added there cause, styles apply to elements are getting late ..
// if ( 1 == ht_ccw()->device_type->is_mobile ) {
//     if ( 1 == ht_ccw()->variables->get_option['stylemobile'] ) {
//         add_action('wp_enqueue_scripts', array( $add_styles_scripts, 'scripts_md_js' ) );
//     }
// } else {
//     if ( 1 == ht_ccw()->variables->get_option['style'] ) {
//         add_action('wp_enqueue_scripts', array( $add_styles_scripts, 'scripts_md_js' ) );
//     }
// }



// AS now merged animations with main.css .. as animations is less then 10kb
// // enqueue animation related css file  
// //      an_enable  -  in ccw_options_cs, not in ccw_options
// //          so may need to move enable animations option to main page 
// if ( 'yes' == ht_ccw()->variables->get_option['an_enable'] ) {
//     wp_enqueue_style('ccw_an_css');
// }