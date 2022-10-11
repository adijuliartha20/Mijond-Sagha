<?php 
/*
Plugin Name: Record Post 
Plugin URI: http://www.locografis.com
Description: Simple record view post from Loco Grafis
Author: Adi Juliartha
Author URI: http://www.locografis.com 
Version: 1.0.0/
*/

//************** START DB *************//
global $record_post_db_version;
$record_post_db_version = '1.0';

function record_post_install() {
	global $wpdb;
	global $record_post_db_version;

	$table_name = $wpdb->prefix . 'record_post';
	
	$charset_collate = $wpdb->get_charset_collate();

	$sql = "CREATE TABLE $table_name (
		id_record bigint(20) NOT NULL,
		ID bigint(20) NOT NULL,
		IP varchar(255),
		date_record DATETIME,
		
		PRIMARY KEY  (id_record)
	) $charset_collate;";

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );

	add_option( 'record_post_db_version', $record_post_db_version );
}

register_activation_hook( __FILE__, 'record_post_install' );



function new_id_record_post(){
	global $wpdb;

	$cid = $wpdb->get_results("select count(id_record)+1 as current_id from {$wpdb->prefix}record_post",'ARRAY_A');
	
	$current_id = $cid[0]['current_id'];
	//print_r($cid);
	return $current_id;
}


function is_new_view_user(){
	global $wpdb;

	$ii = $wpdb->prepare("select count(id_record) from {$wpdb->prefix}record_post where ID=%d and IP=%s",$_POST['pp'],$_POST['client_id']);
	$n = $wpdb->get_var($ii);
	return $n;
}






add_action( 'wp_ajax_nopriv_sci-now', 'save_client_id' );
add_action( 'wp_ajax_sci-now', 'save_client_id' );

function save_client_id(){
	global $wpdb;
	$n = is_new_view_user();

	if($n==0){
		$current_id = new_id_record_post();
		$q = $wpdb->prepare("insert into {$wpdb->prefix}record_post (id_record,ID,IP,date_record) values (%d , %d, %s, %s)",$current_id,$_POST['pp'],$_POST['client_id'],current_time('mysql'));
		
		$r = $wpdb->query($q);
		echo "done";
	}
	
	die();
}



function set_id_client(){
	global $post;
	if(is_single()) {
		?>
		<script> 
		  var _gaq = _gaq || [];
		  _gaq.push(['_setAccount', 'UA-42049662-4']);
		  _gaq.push(['_trackPageview']);
		  setTimeout("_gaq.push(['_trackEvent', '30_seconds', 'read'])",30000);  // --additional line

		  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

		  ga('create', 'UA-42049662-4', 'auto');
		  ga('send', 'pageview');


		  jQuery(document).ready(function(){
		    ga(function(tracker) {
		        var dt = new Object();
		            dt.action = 'sci-now';
		            dt.client_id = tracker.get('clientId');
		            dt.pp = <?php echo $post->ID;; ?>

		        console.log(dt);
		        var url = "<?php echo admin_url('admin-ajax.php');?>";

		        jQuery.post(url,dt,function(response){
		            console.log(response);
		        })
		    });
		  })
		</script> 

		<?php 
	}
}

add_action('wp_head','set_id_client');





?>