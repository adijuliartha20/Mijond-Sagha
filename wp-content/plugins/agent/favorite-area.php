<?php
/**
 * Adds a submenu page under a custom post type parent.
 */
//echo 'fasf';
add_action('admin_menu', 'favorite_area_register_ref_page');
function favorite_area_register_ref_page() {
    add_submenu_page(
        'edit.php?post_type=agent',
        __( 'List Favorite Area', 'textdomain' ),
        __( 'List Favorite Area', 'textdomain' ),
        'manage_options',
        'favorite-agent-area-ref',
        'favorite_area_ref_page_callback'
    );
}
 
/**
 * Display callback for the submenu page.
 */
function favorite_area_ref_page_callback() { 
    if(isset($_POST['submit'])){
        $dt = array();
        $dt['country_favorite'] = $_POST['country_favorite'];
        $dt['state_favorite'] = $_POST['state_favorite'];

        $val = json_encode($dt);
        update_option( 'favorite-area-agent', $val );
    }
    view_page_favorite_area();
}



function view_page_favorite_area(){
    global $wpdb;
    $v = '1.0.0'.time();
    wp_enqueue_style( 'style-favorite-area', plugin_dir_url( __FILE__ ) .'css/style-favorite-area.css' ,array(),$v);
    wp_enqueue_script( 'script-favorite',  plugin_dir_url( __FILE__ ) . 'js/favorite-area.js', array(), $v );

    $d = array();
    $d['url'] = admin_url('admin-ajax.php');
    wp_localize_script( 'script-favorite', 'd', $d );


    $dtc = $wpdb->get_results("select id_country, country from {$wpdb->prefix}country order by country",'ARRAY_A');
    ?>
    <div class="wrap">
        <h1><?php _e( 'Favorite Area', 'textdomain' ); ?></h1>
        


        <div class="custom-field-post">     
            <div class="field-cp">
                <label>Country</label>
                <select id="country" name="country" onchange="get_province(event);">
                    <option value=""><?php echo pll__('Country'); ?></option>
                    <?php
                        foreach ($dtc as $key => $cc) {
                            ?>
                            <option <?php if($cc['id_country']==$curr_country) echo "selected"; ?> value="<?php echo $cc['id_country']; ?>"><?php echo $cc['country']; ?></option>
                            <?php
                        }
                    ?>
                </select>
                
            </div>
            <div class="field-cp">
                <label>State</label>
                <select class="select2" name="province" id="province">
                    <option value=""><?php echo pll__('Province'); ?></option>
                    <?php 
                    if(!empty($state)){
                        foreach ($state as $key => $ss) {
                            ?>
                            <option <?php if($ss->id_state==$dt['id_state']) echo "selected"; ?> value="<?php echo $ss->id_state; ?>"><?php echo $ss->state; ?></option>
                            <?php
                        }
                    }
                    ?>
                </select>
            </div>
            <input type="button" id="add-favorite" value="Add State" onclick="add_favorite(event)">
            <div id="notify" class="notify-fav"></div>
        </div>    

        <form class="form-list-favorite" action="edit.php?post_type=agent&page=favorite-agent-area-ref" method="post">
             <div class="list-favorite clearfix">
                 <ul id="ul-list-favorite">
                    <?php
                    $fav_area = get_option('favorite-area-agent');
                    $fav_area = json_decode($fav_area);
                    if(!empty($fav_area)){
                        foreach ($fav_area->state_favorite as $key => $vv) {
                            $qs = $wpdb->prepare("select a.id_state, a.state, b.id_country, b.country from {$wpdb->prefix}state a inner join {$wpdb->prefix}country b on a.id_country=b.id_country where a.id_state=%d",$vv);
                            $rs = $wpdb->get_results($qs);

                            if(!empty($rs)){
                                $ar = $rs[0];
                                ?>
                                <li id="item-fav-<?php echo $ar->id_state.'-'.$ar->id_country; ?>">
                                    <div class="item-favorite-area">
                                        <input type="button" class="delete-fav-area" onclick="delete_current_area(event)" data-id="item-fav-<?php echo $ar->id_state.'-'.$ar->id_country; ?>">
                                        <span><?php echo $ar->state ?>,</span> <span><?php echo $ar->country; ?></span>
                                    </div>
                                    <input type="hidden" name="country_favorite[]" value="<?php echo $ar->id_country ?>" >
                                    <input type="hidden" name="state_favorite[]" value="<?php echo $ar->id_state ?>" >
                                </li>
                                <?php
                            } 
                        }
                    }
                    ?>
                 </ul>

             </div>  


            <input type="submit" class="button-primary" name="submit" value="SAVE">
        </form>
        
    </div>
    <?php
}
?>