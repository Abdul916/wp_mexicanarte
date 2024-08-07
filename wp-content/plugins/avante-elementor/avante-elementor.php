<?php
/**
 * Plugin Name: Avante Theme Elements for Elementor
 * Description: Custom elements for Elementor using Avante theme
 * Plugin URI:  https://themegoods.com/
 * Version:     2.3
 * Author:      ThemGoods
 * Author URI:  https://themegoods.com/
 * Elementor tested up to: 3.2.1
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die();
}

define( 'AVANTE_ELEMENTOR_PATH', plugin_dir_path( __FILE__ ));

if (!defined('AVANTE_THEMEDATEFORMAT'))
{
	define("AVANTE_THEMEDATEFORMAT", get_option('date_format'));
}

if (!defined('AVANTE_THEMETIMEFORMAT'))
{
	define("AVANTE_THEMETIMEFORMAT", get_option('time_format'));
}

/**
 * Load the plugin after Elementor (and other plugins) are loaded.
 *
 * @since 1.0.0
 */
function avante_elementor_load() {
	load_plugin_textdomain( 'avante-elementor', FALSE, dirname( plugin_basename(__FILE__) ) . '/languages/' );
	
	// Require the main plugin file
	require(AVANTE_ELEMENTOR_PATH.'/tools.php');
	require(AVANTE_ELEMENTOR_PATH.'/actions.php');
	require(AVANTE_ELEMENTOR_PATH.'/templates.php' );
	require(AVANTE_ELEMENTOR_PATH.'/plugin.php' );
	require(AVANTE_ELEMENTOR_PATH.'/page-fields.php' );
	require(AVANTE_ELEMENTOR_PATH.'/post-fields.php' );
	require(AVANTE_ELEMENTOR_PATH.'/shortcode.php');
	require(AVANTE_ELEMENTOR_PATH.'/megamenu.php');
}
add_action( 'plugins_loaded', 'avante_elementor_load' );


function avante_post_type_header() {
	$labels = array(
    	'name' => _x('Headers', 'post type general name', 'avante-elementor'),
    	'singular_name' => _x('Header', 'post type singular name', 'avante-elementor'),
    	'add_new' => _x('Add New Header', 'avante-elementor'),
    	'add_new_item' => __('Add New Header', 'avante-elementor'),
    	'edit_item' => __('Edit Header', 'avante-elementor'),
    	'new_item' => __('New Header', 'avante-elementor'),
    	'view_item' => __('View Header', 'avante-elementor'),
    	'search_items' => __('Search Header', 'avante-elementor'),
    	'not_found' =>  __('No Header found', 'avante-elementor'),
    	'not_found_in_trash' => __('No Header found in Trash', 'avante-elementor'), 
    	'parent_item_colon' => ''
	);		
	$args = array(
    	'labels' => $labels,
    	'public' => true,
    	'publicly_queryable' => true,
    	'show_ui' => true, 
    	'query_var' => true,
    	'rewrite' => true,
    	'capability_type' => 'post',
    	'hierarchical' => false,
    	'show_in_nav_menus' => false,
    	'show_in_admin_bar' => true,
    	'menu_position' => 20,
    	'exclude_from_search' => true,
    	'supports' => array('title', 'content'),
    	'menu_icon' => 'dashicons-editor-insertmore'
	); 		

	register_post_type( 'header', $args );
} 
								  
add_action('init', 'avante_post_type_header');

add_action('elementor/widgets/widgets_registered', 'avante_unregister_elementor_widgets');

function avante_unregister_elementor_widgets($obj){
	$obj->unregister_widget_type('sidebar');
}

function avante_post_type_footer() {
	$labels = array(
    	'name' => _x('Footers', 'post type general name', 'avante-elementor'),
    	'singular_name' => _x('Footer', 'post type singular name', 'avante-elementor'),
    	'add_new' => _x('Add New Footer', 'avante-elementor'),
    	'add_new_item' => __('Add New Footer', 'avante-elementor'),
    	'edit_item' => __('Edit Footer', 'avante-elementor'),
    	'new_item' => __('New Footer', 'avante-elementor'),
    	'view_item' => __('View Footer', 'avante-elementor'),
    	'search_items' => __('Search Footer', 'avante-elementor'),
    	'not_found' =>  __('No Footer found', 'avante-elementor'),
    	'not_found_in_trash' => __('No Footer found in Trash', 'avante-elementor'), 
    	'parent_item_colon' => ''
	);		
	$args = array(
    	'labels' => $labels,
    	'public' => true,
    	'publicly_queryable' => true,
    	'show_ui' => true, 
    	'query_var' => true,
    	'rewrite' => true,
    	'capability_type' => 'post',
    	'hierarchical' => false,
    	'show_in_nav_menus' => false,
    	'show_in_admin_bar' => true,
    	'menu_position' => 20,
    	'exclude_from_search' => true,
    	'supports' => array('title', 'content'),
    	'menu_icon' => 'dashicons-editor-insertmore'
	); 		

	register_post_type( 'footer', $args );
} 
								  
add_action('init', 'avante_post_type_footer');


function avante_post_type_megamenu() {
	$labels = array(
    	'name' => _x('Mega Menus', 'post type general name', 'avante-elementor'),
    	'singular_name' => _x('Mega Menu', 'post type singular name', 'avante-elementor'),
    	'add_new' => _x('Add New Mega Menu', 'avante-elementor'),
    	'add_new_item' => __('Add New Mega Menu', 'avante-elementor'),
    	'edit_item' => __('Edit Mega Menu', 'avante-elementor'),
    	'new_item' => __('New Mega Menu', 'avante-elementor'),
    	'view_item' => __('View Mega Menu', 'avante-elementor'),
    	'search_items' => __('Search Mega Menu', 'avante-elementor'),
    	'not_found' =>  __('No Mega Menu found', 'avante-elementor'),
    	'not_found_in_trash' => __('No Mega Menu found in Trash', 'avante-elementor'), 
    	'parent_item_colon' => ''
	);		
	$args = array(
    	'labels' => $labels,
    	'public' => true,
    	'publicly_queryable' => true,
    	'show_ui' => true, 
    	'query_var' => true,
    	'rewrite' => true,
    	'capability_type' => 'post',
    	'hierarchical' => false,
    	'show_in_nav_menus' => false,
    	'show_in_admin_bar' => true,
    	'menu_position' => 20,
    	'exclude_from_search' => true,
    	'supports' => array('title', 'content'),
    	'menu_icon' => 'dashicons-welcome-widgets-menus'
	); 		

	register_post_type( 'megamenu', $args );
} 
								  
add_action('init', 'avante_post_type_megamenu');

add_action('add_meta_boxes', function () {
	global $post;

	// Check if its a correct post type/types to apply template
	if ( ! in_array( $post->post_type, [ 'header', 'footer', 'megamenu' ] ) ) {
		return;
	}

	// Check that a template is not set already
	if ( '' !== $post->page_template ) {
		return;
	}

	//Finally set the page template
	$post->page_template = 'elementor_canvas';
	update_post_meta($post->ID, '_wp_page_template', 'elementor_canvas');
}, 5 );


//Make widget support shortcode
add_filter('widget_text', 'do_shortcode');

/**
*	Begin Recent Posts Custom Widgets
**/

class Avante_Recent_Posts extends WP_Widget {
	function __construct() {
		$widget_ops = array('classname' => 'Avante_Recent_Posts', 'description' => 'The recent posts with thumbnails' );
		parent::__construct('Avante_Recent_Posts', 'Theme Recent Posts', $widget_ops);
	}

	function widget($args, $instance) {
		extract($args, EXTR_SKIP);

		echo stripslashes($before_widget);
		$items = empty($instance['items']) ? ' ' : apply_filters('widget_title', $instance['items']);
		$items = absint($items);
		
		$show_thumb = empty($instance['show_thumb']) ? ' ' : apply_filters('widget_title', $instance['show_thumb']);
		
		if(!is_numeric($items))
		{
			$items = 3;
		}
		
		if(!empty($items))
		{
			avante_posts('recent', $items, TRUE, trim($show_thumb));
		}
		
		echo stripslashes($after_widget);
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['items'] = strip_tags($new_instance['items']);
		$instance['show_thumb'] = strip_tags($new_instance['show_thumb']);

		return $instance;
	}

	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'items' => '', 'show_thumb' => '') );
		$items = strip_tags($instance['items']);
		$show_thumb = strip_tags($instance['show_thumb']);

?>
			<p><label for="<?php echo esc_attr($this->get_field_id('items')); ?>"><?php esc_html_e('Items (default 3)', 'avante-elementor' ); ?>: <input class="widefat" id="<?php echo esc_attr($this->get_field_id('items')); ?>" name="<?php echo esc_attr($this->get_field_name('items')); ?>" type="text" value="<?php echo esc_attr($items); ?>" /></label></p>
			
			<p><label for="<?php echo esc_attr($this->get_field_id('show_thumb')); ?>"><?php esc_html_e('Display Thumbnails', 'avante-elementor' ); ?>: <input class="widefat" id="<?php echo esc_attr($this->get_field_id('show_thumb')); ?>" name="<?php echo esc_attr($this->get_field_name('show_thumb')); ?>" type="checkbox" value="1" <?php if(!empty($show_thumb)) { ?>checked<?php } ?> /></label></p>
<?php
	}
}

add_action('widgets_init', 'avante_recent_posts_widget');
function avante_recent_posts_widget() {
    register_widget('Avante_Recent_Posts');
}

/**
*	End Recent Posts Custom Widgets
**/


/**
*	Begin Flickr Feed Custom Widgets
**/

class Avante_Flickr extends WP_Widget {
	function __construct() {
		$widget_ops = array('classname' => 'Avante_Flickr', 'description' => 'Display your recent Flickr photos' );
		parent::__construct('Avante_Flickr', 'Theme Flickr', $widget_ops);
	}

	function widget($args, $instance) {
		extract($args, EXTR_SKIP);

		echo stripslashes($before_widget);
		$flickr_id = empty($instance['flickr_id']) ? ' ' : apply_filters('widget_title', $instance['flickr_id']);
		$title = $instance['title'];
		$items = $instance['items'];
		$items = absint($items);
		
		if(!is_numeric($items))
		{
			$items = 9;
		}
		
		if(!empty($items) && !empty($flickr_id))
		{
			$photos_arr = avante_get_flickr(array('type' => 'user', 'id' => $flickr_id, 'items' => $items));

			if(!empty($photos_arr))
			{
				echo stripslashes($before_title);
				echo esc_html($title);
				echo stripslashes($after_title);
				
				echo '<ul class="flickr">';
				
				foreach($photos_arr as $photo)
				{
					echo '<li>';
					echo '<a class="no_effect" target="_blank" href="'.esc_url($photo['link']).'"><img src="'.esc_url($photo['thumb_url']).'" alt="'.esc_attr($photo['title']).'" width="75" height="75" /></a>';
					echo '</li>';
				}
				
				echo '</ul><br class="clear"/>';
			}
		}
		
		echo stripslashes($after_widget);
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['items'] = absint($new_instance['items']);
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['flickr_id'] = strip_tags($new_instance['flickr_id']);

		return $instance;
	}

	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'items' => '', 'flickr_id' => '', 'title' => '') );
		$items = strip_tags($instance['items']);
		$flickr_id = strip_tags($instance['flickr_id']);
		$title = strip_tags($instance['title']);

?>
			<p><label for="<?php echo esc_attr($this->get_field_id('flickr_id')); ?>"><?php esc_html_e('Flickr ID', 'avante-elementor' ); ?> <a href="http://idgettr.com/"><?php esc_html_e('Find your Flickr ID here', 'avante-elementor' ); ?></a>: <input class="widefat" id="<?php echo esc_attr($this->get_field_id('flickr_id')); ?>" name="<?php echo esc_attr($this->get_field_name('flickr_id')); ?>" type="text" value="<?php echo esc_attr($flickr_id); ?>" /></label></p>
			
			<p><label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title', 'avante-elementor' ); ?>: <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>

			<p><label for="<?php echo esc_attr($this->get_field_id('items')); ?>"><?php esc_html_e('Items (default 9)', 'avante-elementor' ); ?>: <input class="widefat" id="<?php echo esc_attr($this->get_field_id('items')); ?>" name="<?php echo esc_attr($this->get_field_name('items')); ?>" type="text" value="<?php echo esc_attr($items); ?>" /></label></p>
<?php
	}
}

add_action('widgets_init', 'avante_flickr_widget');
function avante_flickr_widget() {
    register_widget('Avante_Flickr');
}

/**
*	End Flickr Feed Custom Widgets
**/


/**
*	Begin Instagram Feed Custom Widgets
**/

class Avante_Instagram extends WP_Widget {
	function __construct() {
		$widget_ops = array('classname' => 'Avante_Instagram', 'description' => 'Display your recent Instagram photos' );
		parent::__construct('Avante_Instagram', 'Theme Instagram', $widget_ops);
	}

	function widget($args, $instance) {
		extract($args, EXTR_SKIP);

		echo stripslashes($before_widget);
		$title = $instance['title'];
		$items = $instance['items'];
		$items = absint($items);
		
		//Get Instagram Access Data
		$pp_instagram_username = get_option('pp_instagram_username');
		$pp_instagram_access_token = get_option('pp_instagram_access_token');
		
		if(!is_numeric($items))
		{
			$items = 9;
		}
		
		if(!empty($items) && !empty($pp_instagram_username) && !empty($pp_instagram_access_token))
		{
			$photos_arr = avante_get_instagram($pp_instagram_username, $pp_instagram_access_token, $items);

			if(!empty($photos_arr))
			{
				echo stripslashes($before_title);
				echo esc_html($title);
				echo stripslashes($after_title);
				
				echo '<ul class="flickr">';
				
				foreach($photos_arr as $photo)
				{
					echo '<li>';
					echo '<a class="no_effect" target="_blank" href="'.esc_url($photo['link']).'"><img src="'.esc_url($photo['thumb_url']).'" width="75" height="75" alt="'.esc_attr($photo['title']).'" /></a>';
					echo '</li>';
				}
				
				echo '</ul><br class="clear"/>';
			}
		}
		else
		{
			echo  esc_html__('Error: Please check if you enter Instagram username and Access Token in Theme Setting > Social Profiles', 'avante-elementor' );
		}
		
		echo stripslashes($after_widget);
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['items'] = absint($new_instance['items']);
		$instance['title'] = strip_tags($new_instance['title']);

		return $instance;
	}

	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'items' => '', 'title' => '') );
		$items = strip_tags($instance['items']);
		$title = strip_tags($instance['title']);

?>
			<p><label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title', 'avante-elementor' ); ?>: <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>

			<p><label for="<?php echo esc_attr($this->get_field_id('items')); ?>"><?php esc_html_e('Items (default 9)', 'avante-elementor' ); ?>: <input class="widefat" id="<?php echo esc_attr($this->get_field_id('items')); ?>" name="<?php echo esc_attr($this->get_field_name('items')); ?>" type="text" value="<?php echo esc_attr($items); ?>" /></label></p>
<?php
	}
}

add_action('widgets_init', 'avante_instagram_widget');
function avante_instagram_widget() {
    register_widget('Avante_Instagram');
}

/**
*	End Instagram Feed Custom Widgets
**/

/**
*	Begin Category Posts Custom Widgets
**/

class Avante_Cat_Posts extends WP_Widget {
	function __construct() {
		$widget_ops = array('classname' => 'Avante_Cat_Posts', 'description' => 'Display category\'s post' );
		parent::__construct('Avante_Cat_Posts', 'Theme Category Posts', $widget_ops);
	}

	function widget($args, $instance) {
		extract($args, EXTR_SKIP);

		echo stripslashes($before_widget);
		$cat_id = empty($instance['cat_id']) ? 0 : $instance['cat_id'];
		$items = empty($instance['items']) ? 0 : $instance['items'];
		$items = absint($items);
		
		$show_thumb = empty($instance['show_thumb']) ? ' ' : apply_filters('widget_title', $instance['show_thumb']);
		
		if(empty($items))
		{
			$items = 5;
		}
		
		if(!empty($cat_id))
		{
			avante_cat_posts($cat_id, $items, TRUE, trim($show_thumb));
		}

		echo stripslashes($after_widget);
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['cat_id'] = strip_tags($new_instance['cat_id']);
		$instance['items'] = strip_tags($new_instance['items']);
		$instance['show_thumb'] = strip_tags($new_instance['show_thumb']);

		return $instance;
	}

	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'cat_id' => '', 'items' => '', 'show_thumb' => '') );
		$cat_id = strip_tags($instance['cat_id']);
		$items = strip_tags($instance['items']);
		$show_thumb = strip_tags($instance['show_thumb']);
		
		$categories = get_categories('hide_empty=0&orderby=name');
		$wp_cats = array(
			0		=> "Choose a category"
		);
		foreach ($categories as $category_list ) {
			$wp_cats[$category_list->cat_ID] = $category_list->cat_name;
		}

?>
			
			<p><label for="<?php echo esc_attr($this->get_field_id('cat_id')); ?>"><?php esc_html_e('Category', 'avante-elementor' ); ?>: 
				<select  id="<?php echo esc_attr($this->get_field_id('cat_id')); ?>" name="<?php echo esc_attr($this->get_field_name('cat_id')); ?>">
				<?php
					foreach($wp_cats as $wp_cat_id => $wp_cat)
					{
				?>
						<option value="<?php echo esc_attr($wp_cat_id); ?>" <?php if(esc_attr($cat_id) == $wp_cat_id) { echo 'selected="selected"'; } ?>><?php echo esc_html($wp_cat); ?></option>
				<?php
					}
				?>
				</select>
			</label></p>
			
			<p><label for="<?php echo esc_attr($this->get_field_id('items')); ?>"><?php esc_html_e('Items (default 5)', 'avante-elementor' ); ?>: <input class="widefat" id="<?php echo esc_attr($this->get_field_id('items')); ?>" name="<?php echo esc_attr($this->get_field_name('items')); ?>" type="text" value="<?php echo esc_attr($items); ?>" /></label></p>
			
			<p><label for="<?php echo esc_attr($this->get_field_id('show_thumb')); ?>"><?php esc_html_e('Display Thumbnails', 'avante-elementor' ); ?>: <input class="widefat" id="<?php echo esc_attr($this->get_field_id('show_thumb')); ?>" name="<?php echo esc_attr($this->get_field_name('show_thumb')); ?>" type="checkbox" value="1" <?php if(!empty($show_thumb)) { ?>checked<?php } ?> /></label></p>
<?php
	}
}

add_action('widgets_init', 'avante_cat_posts_widget');
function avante_cat_posts_widget() {
    register_widget('Avante_Cat_Posts');
}

/**
*	End Category Posts Custom Widgets
**/
?>