<?php 
class Data_List_State extends WP_List_Table {

	//Class constructor
	public function __construct() {

		parent::__construct( [
			'singular' => __( 'State', 'sp' ), //singular name of the listed records
			'plural'   => __( 'State', 'sp' ), //plural name of the listed records
			'ajax'     => false //does this table support ajax?
		] );

	}

	var $currtbl= "state";
	var $id_curr = "id_state";
	
	// Retrieve newsletter data from the database
	
	// @param int $per_page
	// @param int $page_number
	
	// @return mixed
	
	public static function get_current( $per_page = 30, $page_number = 1 ) {
		global $wpdb;
		
		$sql = "SELECT a.*, b.country FROM {$wpdb->prefix}state a inner join {$wpdb->prefix}country b on a.id_country=b.id_country";

		if (!empty( $_REQUEST['status'] ) && $_REQUEST['status']!='all' ) {
			$sql .= " where a.status='".esc_sql( $_REQUEST['status'])."'";
		}else{
			$sql .= " where a.status <> 'trash'";
		}
		if (!empty( $_REQUEST['s'] ) ) {
			$sql .= " and ( a.state like '%".esc_sql( $_REQUEST['s'])."%' or a.code_state like '%".esc_sql( $_REQUEST['s'])."%' or b.country like  '%".esc_sql( $_REQUEST['s'])."%' )";
		}

		if ( ! empty( $_REQUEST['orderby'] ) ) {
			$sql .= ' ORDER BY ' . esc_sql( $_REQUEST['orderby'] );
			$sql .= ! empty( $_REQUEST['order'] ) ? ' ' . esc_sql( $_REQUEST['order'] ) : ' ASC';
		}else {
			$sql .= ' ORDER BY a.menu_order';
		}

		$sql .= " LIMIT $per_page";
		$sql .= ' OFFSET ' . ( $page_number - 1 ) * $per_page; //echo $sql;
		
		$result = $wpdb->get_results( $sql, 'ARRAY_A' );

		//echo $sql;

		//print_r($result);

		return $result;
	}


	
	// Delete a customer record.	 
	// @param int $id customer ID	 
	public static function delete_current( $id ) {
		global $wpdb;

		$wpdb->delete(
			"{$wpdb->prefix}state",
			[ 'id_state' => $id ],
			[ '%d' ]
		);

		//echo 
	}

	public static function update_status_current($id,$status){
		global  $wpdb;

		$wpdb->update(
						"{$wpdb->prefix}state",
						['status' => $status],
						['id_state'=>$id]
					);
	}


	// Returns the count of records in the database.	
	// @return null|string	
	public static function record_count($status_fix="") {
		global $wpdb;
		$status = (isset($_REQUEST['status'])? $_REQUEST['status']: '');
		$status_fix = ($status_fix!=""? $status_fix : $status);
		//echo state.'#';

		$sql = "SELECT COUNT(*) FROM {$wpdb->prefix}state a inner join {$wpdb->prefix}country b on a.id_country=b.id_country

					".($status_fix!='' && $status_fix!='all'? "where a.status='".$status_fix."'": "where a.status<> 'trash'");


		if (!empty( $_REQUEST['s'] ) ) {
			$sql .= " and ( a.state like '%".esc_sql( $_REQUEST['s'])."%' or a.code_state like '%".esc_sql( $_REQUEST['s'])."%' or b.country like  '%".esc_sql( $_REQUEST['s'])."%') ";
		}			
		//echo $sql.'#';

		$return = $wpdb->get_var( $sql );
		if(empty($return)) $return = 0;
		return $return;
	}


	//Text displayed when no customer data is available 
	public function no_items() {
		_e( "No state avaliable.", 'sp' );
	}


	//Render a column when no column specific method exist.	
	// @param array $item
	// @param string $column_name	
	// @return mixed	
	public function column_default( $item, $column_name ) {
		//echo "$column_name#";
		switch ( $column_name ) {			
			case 'code_state':
				return $item[ $column_name ];
			case 'country':
				return $item[ $column_name ];
			case 'status':
				return $this->arr_status_current[$item[ $column_name ]]; 				
			case 'menu_order':
				return $item[ $column_name ];
			
			default:
				return print_r( $item, true ); //Show the whole array for troubleshooting purposes
		}
	}

	var $arr_type_current = array('Promo','News');
	var $arr_status_current = array('publish'=>'Publish','draft'=>'Draft','trash'=>'Trash');

	// Render the bulk edit checkbox	
	// @param array $item
	// @return string
	function column_cb( $item ) {
		return sprintf(
			'<input type="checkbox" name="bulk-delete[]" value="%s" />', $item['id_state']
		);
	}


	public function list_status(){
		global $wpdb;
		$arr_status = $this->arr_status_current;
		$return ="";
		$status = (isset($_REQUEST['status'])? $_REQUEST['status']: '');

		//if($this->record_count()>0){ ?>
			<ul class="subsubsub">
				<a href="<?php echo "?page=".esc_attr($_REQUEST['page']).""; ?>" class="<?php echo ($status=='all' || $status==''?'current':''); ?>">All<span class="count">(<?php echo $this->record_count('all'); ?>)</span></a>			
				<?php 
				$n = 0;
				foreach ($arr_status as $key => $value) {
					$link = "?page=".esc_attr($_REQUEST['page'])."&status=".$key;
					?>
					<li>
						| <a href="<?php echo $link; ?>" class="<?php echo ($status==$key?'current':''); ?>"><?php echo $value ?><span class="count">(<?php echo $this->record_count($key); ?>)</span></a>
					</li>
					<?php
					$n++;
				}
				?>			
			</ul>
			<?php 
		//}
		echo $return;
	}

	
	// Method for name column
	//
	// @param array $item an array of DB data
	// 
	// @return string 
	//
	// repalce column_(nameofcolum)

	function column_state( $item ) {
		//print_r($item);

		$edit_nonce = wp_create_nonce( 'sp_edit_current' );
		$delete_nonce = wp_create_nonce( 'sp_delete_current' );
		$trash_nonce = wp_create_nonce( 'sp_trash_current' );
		$title = '<strong>' . $item['state'] . '</strong>';

		$status = (isset($_GET['status'])? $_GET['status'] : '');
		$actions = array();
		
		if(isset($_GET['status']) && $_GET['status']=='trash'){
			$actions['untrash'] = sprintf( '<a href="?page=%s&action=%s&id=%s&_wpnonce=%s&paged=%s&status=%s">Restore</a>', esc_attr( $_REQUEST['page'] ), 'untrash', absint( $item['id_state'] ), $delete_nonce, $_GET['paged'], $status);
			$actions['delete'] = sprintf( '<a href="?page=%s&action=%s&id=%s&_wpnonce=%s&paged=%s&status=%s">Delete</a>', esc_attr( $_REQUEST['page'] ), 'delete', absint( $item['id_state'] ), $delete_nonce, $_GET['paged'], $status);
		}else{
			$actions['edit'] =  sprintf( '<a href="?page=%s&action=%s&id=%s&_wpnonce=%s&paged=%s&status=%s">Edit</a>', esc_attr( $_REQUEST['page'] ), 'edit', absint( $item['id_state'] ), $edit_nonce, $_GET['paged'], $status );
			$actions['trash'] = sprintf( '<a href="?page=%s&action=%s&id=%s&_wpnonce=%s&paged=%s&status=%s">Trash</a>', esc_attr( $_REQUEST['page'] ), 'trash', absint( $item['id_state'] ), $trash_nonce, $_GET['paged'], $status );
		}
		return $title . $this->row_actions( $actions );
	}


	//
	//  Associative array of columns
	//
	// @return array
	//
	function get_columns() {
		$columns = [
			'cb'      => '<input type="checkbox" />',
			'state'    => __( 'State', 'sp' ),
			'code_state'    => __( 'Code', 'sp' ),
			'country'    => __( 'Country', 'sp' ),
			'status'    => __( 'Status', 'sp' ),			
			'menu_order'    => __( 'Order ID', 'sp' )
		];

		return $columns;
	}


	//
	// Columns to make sortable.
	//
	// @return array
	//
	public function get_sortable_columns() {
		$sortable_columns = array(
			'state' => array( 'state', true ),			
			'code_state' => array( 'code_state', false ),
			'country' => array( 'country', true ),			
			'status' => array( 'status', false ),			
			'menu_order' => array( 'menu_order', true )
		);
		return $sortable_columns;
	}

	//
	// Returns an associative array containing the bulk action
	//
	// @return array
	//
	public function get_bulk_actions() {
		if(isset($_GET['status']) && $_GET['status']=='trash'){
			$actions = [
				'bulk-untrash' => 'Restore',
				'bulk-delete' => 'Delete'
			];
		}else{
			$actions = [
				//'bulk-edit' => 'Edit',
				'bulk-trash' => 'Trash'
			];
		}
		return $actions;
	}


	
	//Handles data query and filter, sorting, and pagination.	
	public function prepare_items() {
		// Process bulk action
		$this->process_bulk_action();

		$this->_column_headers = $this->get_column_info();		

		$per_page     = $this->get_items_per_page( 'country_per_page', 30 );
		
		$current_page = ( isset($_GET['paged']) && !empty($_GET['paged']) ? $_GET['paged'] : $this->get_pagenum()); 

		$total_items  = self::record_count();

		$this->set_pagination_args( [
			'total_items' => $total_items, //WE have to calculate the total number of items
			'per_page'    => $per_page //WE have to determine how many items to show on a page
		] );

		$this->items = self::get_current( $per_page, $current_page );
	}

	public function process_bulk_action() {
	}

	function extra_tablenav( $which ) {
	    global $wpdb, $testiURL, $tablename, $tablet;
	    $move_on_url = '&cat-filter=';
	    $tablename = "{$wpdb->prefix}terms";
	    $term_group = 0;
	    $term_id = 'term_id';
	    
	    if ( $which == "top" ){ //return;
	    	
	    }
	    if ( $which == "bottom" ){
	        //The code that goes after the table is there

	    }
	}

}


class SP_Plugin_State {
	// class instance
	static $instance;

	// customer WP_List_Table object
	public $obj;

	// class constructor
	public function __construct() {
		add_filter( 'set-screen-option', [ __CLASS__, 'set_screen' ], 10, 3 );
		add_action( 'admin_menu', [ $this, 'plugin_menu' ] );
	}


	public static function set_screen( $status, $option, $value ) {
		return $value;
	}

	public function plugin_menu() {
		//$hook = add_menu_page('State','State','manage_options','wp_list_table__custom',[ $this, 'plugin_settings_page' ]);		
		$hook = add_submenu_page( 'wp_list_table_country', 'State', 'State', 'manage_options', 'wp_list_table_state', [ $this, 'plugin_settings_page' ]);
		add_action( "load-$hook", [ $this, 'screen_option' ] );		
	}

	//
	// Plugin settings page
	//
	public function plugin_settings_page() {
		$Data_List = new Data_List_State();
		$action = $this->obj->current_action();
		
		if($action=='edit') $this->edit();
		else if($action=='sorting') $this->sorting() ;
		else if($action=='new') $this->add_new();
		else{//view list
			$status = 'publish';
			if($action=='trash' || $action=='bulk-trash') $status = 'trash';

			if(isset($_POST['bulk-delete']) && ($action=='bulk-trash' || $action=='bulk-untrash')){
				$delete_ids = esc_sql( $_POST['bulk-delete'] );
				foreach ( $delete_ids as $id ) {
					$Data_List->update_status_current($id,$status);
				}
			}

			if($action=='trash' || $action=='untrash'){
				$Data_List->update_status_current($_GET['id'],$status);
			}


			if(isset($_POST['bulk-delete']) && $action=='bulk-delete'){
				$delete_ids = esc_sql( $_POST['bulk-delete'] );
				foreach ( $delete_ids as $id ) {
					$Data_List->delete_current( $id );
				}
			}
			if($action=='delete'){
				$Data_List->delete_current($_GET['id']);
			}

			$this->view_list();
		}
	}

	function view_list(){
		$this->view($paged);
		$v = '?v=1.0.0.'.time();
		wp_enqueue_style( 'slider', plugins_url( 'loco_countries/css/default.css'.$v , dirname(__FILE__) ));
		wp_enqueue_script( 'jquery-ui-sortable' );
		wp_enqueue_script( 'custom-js', plugins_url( 'loco_countries/js/default.js'.$v , dirname(__FILE__) ) );	
	}


	function reset_menu_order($table_name){
		global $wpdb;
		$q = $wpdb->prepare("update $table_name set menu_order=menu_order+%d",1);
		$r = $wpdb->query($q);
	}
	
	function view(){
		$Data_List = new Data_List_State();
		$current_page = $Data_List->get_pagenum();
		?>
		<div class="wrap">
			<h1 class="wp-heading-inline">Country</h1> <?php echo sprintf( '<a href="?page=%s&action=%s" class="page-title-action">Add New</a>', esc_attr( $_REQUEST['page'] ), 'new') ?>
			<hr class="wp-header-end">
				
			<div id="poststuff">
				<div id="post-body" class="metabox-holder metabox-holder-full columns-2">
					<div id="post-body-content">
						<div class="meta-box-sortables ui-sortable">
							<form method="post">
								<?php
								$this->obj->prepare_items();
								$this->obj->search_box('Search', 'search_id');
								$this->obj->list_status();
								$this->obj->display(); ?>
							</form>
						</div>
					</div>
				</div>
				<br class="clear">
			</div>
			<input type="hidden" id="sorting_action" value="sorting_current_<?php echo $Data_List->currtbl; ?>">
			<input type="hidden" id="current_page" value="<?php echo $current_page; ?>">
			<input type="hidden" id="ajax-url" value="<?php echo admin_url('admin-ajax.php'); ?>">
		</div>
		<?php
	}

	//
	// Screen options
	//
	public function screen_option() {

		$option = 'per_page';
		$args   = [
			'label'   => 'state',
			'default' => 30,
			'option'  => 'state_per_page'
		];

		add_screen_option( $option, $args );

		$this->obj = new Data_List_State();
	}


	/// Singleton instance
	public static function get_instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}



	//Add & Edit Start//

	function add_new(){
		global $wpdb;
		$alert =  '';
		$dt = (object) array();
		//print_r($_POST);
		$label = 'State';


		if(isset($_POST['act']) && $_POST['act']=='new'){//edit process
			$error = 0;
			$first_notice = '<p>Failed Add New '.$label.'. </p>';
			$msg = '';
			$type_notice = 'error';
			if($_POST['country']==''){
				$msg .= '<p>State is require</p>';
				$error++;
			}


			if($error==0){

				//$author = get_current_user_id();
				$id = $this->get_max_id() + 1;
				//$created = date('Y-m-d H:i:s',time());
				$q = $wpdb->prepare("insert into {$wpdb->prefix}state (id_state, id_country, code_state, state, menu_order, status) 
									values (%d,%d,%s,%s,%d,%s)",
									$id, $_POST['country'], $_POST['code_state'], $_POST['state'],0, $_POST['status']);
				$r = $wpdb->query($q);
				if($r){
					$type_notice  = 'success';
					$first_notice = '<p>Success Add New '.$label.'. </p>';
					$this->sort_again();
					if($_POST['act']=='save-send-email') {
						if(!$this->obj->testing_email($id)) {
							$msg .= '<p>Failed send email testing</p>';
							$error++;
						}
					}
				}else $error++;
			}

			if($error>0){
				$dt->id_country 	= $_POST['id_country'];
				$dt->code_state 	= $_POST['code_state'];
				$dt->state 		= $_POST['state'];
				$dt->status 	= $_POST['status'];
			}

			$alert =  '	<div id="message" class="notice notice-'.$type_notice.' is-dismissible">
							'.$first_notice.'
							'.$msg.'
							<button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button>
						</div>';
		}
		$this->form_action('Add New',$dt,'new',$alert);
	}

	function sort_again(){
		global $wpdb;
		$q = $wpdb->prepare("update {$wpdb->prefix}state set menu_order = menu_order + 1 where id_state<>%d",0);
		$r = $wpdb->query($q);
	}

	

	function edit(){
		global $wpdb;
		$id = $_GET['id'];
		$label = 'State';
		
		$alert = '';
		if(isset($_POST['act']) && ($_POST['act']=='edit') ){//edit process
			$error = 0;
			$first_notice = '<p>Failed Update '.$label.'. </p>';
			$msg = '';
			$type_notice = 'error';
			
			if($_POST['country']==''){
				$msg .= '<p>Country is require</p>';
				$error++;
			}


			if($_POST['state']==''){
				$msg .= '<p>State is require</p>';
				$error++;
			}

			if($error==0){
				$q = $wpdb->prepare("update {$wpdb->prefix}state set id_country=%d, code_state=%s, state=%s, status=%s where id_state=%d",
									 $_POST['country'], $_POST['code_state'], $_POST['state'], $_POST['status'], $id);//echo $q;
				$r = $wpdb->query($q);
				//if($r){
					$type_notice  = 'success';
					$first_notice = '<p>Success Update '.$label.'. </p>';
				//}else $error++;
			}


			$alert =  '	<div id="message" class="notice notice-'.$type_notice.' is-dismissible">
							'.$first_notice.'
							'.$msg.'
							<button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button>
						</div>';
		}

		$qc = $wpdb->prepare("select * from {$wpdb->prefix}state where id_state=%d",$id);
		$dtc = $wpdb->get_results($qc);
		
		$this->form_action('Edit',$dtc[0],'edit',$alert);
	}

	
	
	

	function opt_generate($type, $selected){
		if($type=='type') $opts = $this->obj->arr_type_current;
		if($type=='status') $opts = $this->obj->arr_status_current;
		$return = "";
		foreach ($opts as $key => $value) {
			if($_GET['action']=='new' && $key=='trash') $return;
			else 	
			$return .= "<option  value=\"$key\"  ".($key==$selected?"selected":"").">$value</option>";
		}
		return $return;
	}


	function form_action($title="Add New",$dt = array(), $act='new',$alert=''){
		global $wpdb;
		require_once( ABSPATH . 'wp-admin/includes/meta-boxes.php' );
		$content = (isset($dt->content) ? wpautop($dt->content) :'');
		$type =  (isset($dt->type) ? $dt->type :'');
		$status = (isset($dt->status) ? $dt->status :'');
		wp_enqueue_style( 'slider', plugins_url( 'loco_countries/css/default.css'.$v , dirname(__FILE__) ));	
		$dtc = $wpdb->get_results("select id_country, country from {$wpdb->prefix}country order by country",'ARRAY_A');

		//print_r($dt);
		?>
		<div class="wrap">
				<h2><?php echo $title; ?> State</h2>
				<?php echo $alert;?>
				<div id="poststuff">
					<div id="post-body" class="metabox-holder columns-2">
						<div id="post-body-content">
							<div class="meta-box-sortables ui-sortable">
								<form class="form-action" method="post">
									<div class="fieldfc">
										<select id="country" name="country">
						                    <option value="">Country</option>
						                    <?php
						                        foreach ($dtc as $key => $cc) {
						                            ?>
						                            <option <?php if($cc['id_country']==$dt->id_country) echo "selected"; ?> value="<?php echo $cc['id_country']; ?>"><?php echo $cc['country']; ?></option>
						                            <?php
						                        }
						                    ?>
						                </select>
									</div>
									<div class="fieldfc">
										<input type="text" name="state" class="text" value="<?php echo (isset($dt->state) ? $dt->state :''); ?>" placeholder="State">
									</div>
									<div class="fieldfc">
										<input type="text" name="code_state" class="text small" value="<?php echo (isset($dt->code_state) ? $dt->code_state :''); ?>" placeholder="Code State">		
									</div>
									<br/>
									<select name="status"><?php echo $this->opt_generate('status',$status); ?></select>	
									<br/>
									<br/>									
									<p>
										<button class="button button-primary button-large" name="act" value="<?php echo $act; ?>">Save</button>
									</p>	
								</form>
							</div>
						</div>
					</div>
					<br class="clear">
				</div>
			</div>
		<?php
	}


	function custom_meta_box_markup($object){
	    wp_nonce_field(basename(__FILE__), "meta-box-nonce");

	    ?>
	        <div>
	            <label for="meta-box-text">Text</label>
	            <input name="meta-box-text" type="text" value="<?php echo get_post_meta($object->ID, "meta-box-text", true); ?>">
	            <br>
	            <label for="meta-box-dropdown">Dropdown</label>
	            <select name="meta-box-dropdown">
	                <?php 
	                    $option_values = array(1, 2, 3);

	                    foreach($option_values as $key => $value) 
	                    {
	                        if($value == get_post_meta($object->ID, "meta-box-dropdown", true))
	                        {
	                            ?>
	                                <option selected><?php echo $value; ?></option>
	                            <?php    
	                        }
	                        else
	                        {
	                            ?>
	                                <option><?php echo $value; ?></option>
	                            <?php
	                        }
	                    }
	                ?>
	            </select>

	            <br>

	            <label for="meta-box-checkbox">Check Box</label>
	            <?php
	                $checkbox_value = get_post_meta($object->ID, "meta-box-checkbox", true);

	                if($checkbox_value == "")
	                {
	                    ?>
	                        <input name="meta-box-checkbox" type="checkbox" value="true">
	                    <?php
	                }
	                else if($checkbox_value == "true")
	                {
	                    ?>  
	                        <input name="meta-box-checkbox" type="checkbox" value="true" checked>
	                    <?php
	                }
	            ?>
	        </div>
	    <?php  
	}

	//$currtbl= "state";
	//$id_curr = "id_state";

	function get_max_id(){
		global $wpdb;
		$return = 0;
		$Data_List = new Data_List_State();

		$q = "select max($Data_List->id_curr) from {$wpdb->prefix}$Data_List->currtbl";
		$return = $wpdb->get_var($q);

		return $return;
	}

	//Add & Edit END//
}


add_action('wp_ajax_sorting_current_state', 'sorting_current_state');

function sorting_current_state(){
	global $wpdb;
	
	$Data_List = new Data_List_State();
	$per_page     = $Data_List->get_items_per_page( 'country_per_page', 30 );
	$current_page = $_POST['current_page'];

	$start = (($current_page * $per_page) - $per_page) + 1;
	$end = ($start + $per_page) - 1;
	
	$n = 0;
	for($i=$start; $i<=$end; $i++){
		$q = $wpdb->prepare("update {$wpdb->prefix}$Data_List->currtbl set menu_order=%d where $Data_List->id_curr=%d",$i, $_POST['ids'][$n]);
		$r = $wpdb->query($q);
		$n++;
	}
	echo 'success';
	wp_die();
}


add_action( 'plugins_loaded', function () {
	SP_Plugin_State::get_instance();
} );

?>