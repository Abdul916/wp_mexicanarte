<?php
add_action( 'wp_enqueue_scripts', 'load_child_theme_enqueue_scripts' );
function load_child_theme_enqueue_scripts(){
	//avante child theme stylesheet css file
	wp_enqueue_style('child-theme-css', get_stylesheet_uri());
	//avante child theme javascript js file
	wp_enqueue_script('child-theme-js', get_stylesheet_directory_uri() . '/script.js', array( 'jquery' ), '1.0', true );
}



add_action( 'admin_menu', 'xlogics_create_admin_pages', 1);
function xlogics_create_admin_pages() {
	add_menu_page( 'Amounts', 'Amounts', 'manage_options', 'mexican_paid_lists', 'view_mexican_paid_amount_function', 'dashicons-money-alt', 20 );
}


if(!class_exists('WP_List_Table')) {
	require_once( ABSPATH . 'wp-admin/includes/screen.php' );
	require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

class Xl_wp_list extends WP_List_Table {
	protected
	$_data = [],
	$db,
	$view_links = [];
	public
	$bulk_actions = [],
	$default_columns = [],
	$sortable_columns = [],
	$columns = [],
	$order_column = '';

	function __construct($args){
		parent::__construct($args);
	}

	private static $addedClosures = array();

	public function __set($name, $value) {
		if ($value instanceof \Closure) {
			self::$addedClosures[$name] = $value;
		} else {
			parent::__set($name, $value);
		}
	}

	public function __get($name) {
		return $this->$name;
	}

	public function __isset($name) {
		return isset($this->$name);
	}

	public function __call($method, $arguments) {
		if (isset(self::$addedClosures[$method]))
			return call_user_func_array(self::$addedClosures[$method], $arguments);
		return call_user_func_array($method, $arguments);
	}

	public function set_views($view_links = []) {
		$this->view_links = $view_links;
	}

	protected function get_views() {
		return $this->view_links;
	}

	public function column_default($item, $column_name) {
		if (in_array($column_name, $this->default_columns)) {
			return $item[$column_name];
		}
	}

	public function get_sortable_columns() {
		return $this->sortable_columns;
	}

	public function usort_reorder( $a, $b ) {
		$orderby = ( ! empty( $_GET['orderby'] ) ) ? $_GET['orderby'] : $this->order_column;
		$order = ( ! empty($_GET['order'] ) ) ? $_GET['order'] : 'asc';
		$result = strcmp( $a[$orderby], $b[$orderby] );
		return ( $order === 'asc' ) ? $result : -$result;
	}
	public function get_bulk_actions() {
		return $this->bulk_actions;
	}

	public function process_bulk_action($callback = '') {
		if (is_callable($callback)) {
			return $callback($this->current_action());
		}
	}

	public function get_columns() {
		return $this->columns;
	}

	public function prepare_items() {
		global $wpdb;
		$columns = $this->get_columns();
		$h_idden = [];
		$sortable = $this->get_sortable_columns();
		$this->_column_headers = [$columns, $h_idden, $sortable];
		$data = $this->table_data();
		$this->process_bulk_action();
		$per_page = 50;
		$current_page = $this->get_pagenum();
		$total_items = count($data);

		$this->_data = array_slice($data,(($current_page-1)*$per_page),$per_page);

		$this->items = $this->_data;

		$this->set_pagination_args([
			'total_items' => $total_items,
			'per_page'    => $per_page,
			'total_pages' => ceil($total_items/$per_page)
		]);
	}
	protected function table_data() {

	}
}

class Wp_custom_table extends Xl_wp_list {
	function __construct() {
		global $status, $page;

		parent::__construct( array(
			'singular'  => 'notification',
			'plural'    => 'notifications',
			'ajax'      => false
		) );
	}
	protected function get_views() {

	}
	protected function table_data() {
		global $wpdb;
		$table_name = 'qhr_mexican_paid';
		$results = $wpdb->get_results("SELECT * FROM $table_name ORDER BY id DESC", OBJECT);
		$data = array();
		foreach ($results as $post) {
			$data[] = array(
				'id'			=> $post->id,
				'amount'		=> $post->amount,
				'date'			=> $post->created_at,
			);

		}
		return $data;
	}
}


function view_mexican_paid_amount_function() {
	global $wpdb;
	$data = $_POST;
	// print_r($data);die;
	$table_name = 'qhr_mexican_paid';
	if($data['mexican_amount'] == "mexican_amount"){
		if(!empty($data['amount']) && is_numeric($data['amount'])){
			$wpdb->insert($table_name,
				array(
					"amount" => $data['amount'],
					"created_at" => date('Y-m-d H:i:s')
				)
			);
		}
	}
	if(isset($data['show_hide_amount'])){
		update_option( 'show_hide_amount_picker', 1);
	}else{
		update_option( 'show_hide_amount_picker', 0);
	}
	$table = new Wp_custom_table();
	$title = __("Amounts List", "mexican_paid_lists");
	$total = $wpdb->get_row("SELECT SUM(amount) as total_amount FROM $table_name");

	?>
	<div class="wrap">
		<h1><?php echo esc_html( $title );?></h1>
		<div class="card" style="margin: 0 auto; text-align: center; padding-bottom: 30px;">
			<h2>Add New Amount</h2>
			<div class="card-body">
				<form id="add_mexicon_amount_form" method="post" action="">
					<div class="mb-3">
						<strong class="form-label">Amount</strong>
						<input type="text" name="amount" class="form-control only_number" placeholder="Enter Amount">
						<button type="submit" id="btn_add_mexican_amount" name="mexican_amount" value="mexican_amount" class="btn btn-primary">Add</button>
						<br>
					</div>
				</form>
			</div>
		</div>


		<?php
		$table->default_columns = [
			'id',
			'amount',
			'date'
		];
		$table->columns = [
			'id'			=>__('ID'),
			'amount'		=>__('Amount'),
			'date'			=>__('Date')
		];
		?>
		<h1 style="text-align: center;">Total Amount: <?php echo '$'.number_format($total->total_amount, 2); ?></h1>

		<?php $table->views(); ?>
		<?php $table->prepare_items(); ?>
		<?php $table->display(); ?>
	</div>
<?php }
function mexican_paid_english_shortcode() { 
	global $wpdb;
	$table_name = 'qhr_mexican_paid';
	$total = $wpdb->get_row("SELECT SUM(amount) as total_amount FROM $table_name");
    $tick_price = @$total->total_amount;
	?>
		<div class="maxican_paid">
			<p class="upper_amount_div">Your Purchases Have Paid:</p>
			<p class="amount_div"><?php echo '$'.number_format($tick_price, 2); ?></p>
			<p class="lower_amount_div">To Traditional Mexican Vendors!</p>
		</div>
	<?php
}
add_shortcode( 'mexican_paid_english', 'mexican_paid_english_shortcode', 100 );

function mexican_paid_spanish_shortcode() { ?>
	<?php
	//ob_start();
	global $wpdb;
	$table_name = 'qhr_mexican_paid';
	$total = $wpdb->get_row("SELECT SUM(amount) as total_amount FROM $table_name");
	?>
	<?php $check = get_option('show_hide_amount_picker'); ?>
	<!-- <?php // if($check == 1){ ?> -->
		<div class="maxican_paid">
			<p class="upper_amount_div">¡Tus Compras Han Pagado:</p>
			<p class="amount_div"><?php echo '$'.number_format($total->total_amount, 2); ?></p>
			<p class="lower_amount_div">A Vendedores Tradicionales Mexicanos!</p>
		</div>
	<!-- <?php // } ?> -->
	<?php
}
add_shortcode( 'mexican_paid_spanish', 'mexican_paid_spanish_shortcode', 100 );
function webp_upload_mimes( $existing_mimes ) {
    // add webp to the list of mime types
    $existing_mimes['webp'] = 'image/webp';
    // return the array back to the function with our added mime type
    return $existing_mimes;
}
add_filter( 'mime_types', 'webp_upload_mimes' );
//** * Enable preview / thumbnail for webp image files.*/
function webp_is_displayable($result, $path) {
    if ($result === false) {
        $displayable_image_types = array( IMAGETYPE_WEBP );
        $info = @getimagesize( $path );
        if (empty($info)) {
            $result = false;
        } elseif (!in_array($info[2], $displayable_image_types)) {
            $result = false;
        } else {
            $result = true;
        }
    }
    return $result;
}
add_filter('file_is_displayable_image', 'webp_is_displayable', 10, 2);