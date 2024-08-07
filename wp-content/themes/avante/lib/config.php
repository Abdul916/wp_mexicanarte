<?php
//Setup theme constant and default data
$theme_obj = wp_get_theme('avante');

define("AVANTE_THEMENAME", $theme_obj['Name']);
if (!defined('AVANTE_THEMEDEMO'))
{
	define("AVANTE_THEMEDEMO", false);
}
define("AVANTE_SHORTNAME", "pp");
define("AVANTE_THEMEVERSION", $theme_obj['Version']);
define("AVANTE_THEMEDEMOURL", $theme_obj['ThemeURI']);
define("AVANTE_MEGAMENU", true);

define("THEMEGOODS_API", 'https://license.themegoods.com/manager/wp-json/envato');
define("THEMEGOODS_PURCHASE_URL", 'https://1.envato.market/1LJ3a');

if (!defined('AVANTE_THEMEDATEFORMAT'))
{
	define("AVANTE_THEMEDATEFORMAT", get_option('date_format'));
}

if (!defined('AVANTE_THEMETIMEFORMAT'))
{
	define("AVANTE_THEMETIMEFORMAT", get_option('time_format'));
}

define("ENVATOITEMID", 25223481);

//Get default WP uploads folder
$wp_upload_arr = wp_upload_dir();
define("AVANTE_THEMEUPLOAD", $wp_upload_arr['basedir']."/".strtolower(sanitize_title(AVANTE_THEMENAME))."/");
define("AVANTE_THEMEUPLOADURL", $wp_upload_arr['baseurl']."/".strtolower(sanitize_title(AVANTE_THEMENAME))."/");

if(!is_dir(AVANTE_THEMEUPLOAD))
{
	wp_mkdir_p(AVANTE_THEMEUPLOAD);
}

/**
*  Begin Global variables functions
*/

//Get default WordPress post variable
function avante_get_wp_post() {
	global $post;
	return $post;
}

//Get default WordPress file system variable
function avante_get_wp_filesystem() {
	require_once(ABSPATH . 'wp-admin/includes/file.php');
	WP_Filesystem();
	global $wp_filesystem;
	return $wp_filesystem;
}

//Get default WordPress wpdb variable
function avante_get_wpdb() {
	global $wpdb;
	return $wpdb;
}

//Get default WordPress wp_query variable
function avante_get_wp_query() {
	global $wp_query;
	return $wp_query;
}

//Get default WordPress customize variable
function avante_get_wp_customize() {
	global $wp_customize;
	return $wp_customize;
}

//Get default WordPress current screen variable
function avante_get_current_screen() {
	global $current_screen;
	return $current_screen;
}

//Get default WordPress paged variable
function avante_get_paged() {
	global $paged;
	return $paged;
}

//Get default WordPress registered widgets variable
function avante_get_registered_widget_controls() {
	global $wp_registered_widget_controls;
	return $wp_registered_widget_controls;
}

//Get default WordPress registered sidebars variable
function avante_get_registered_sidebars() {
	global $wp_registered_sidebars;
	return $wp_registered_sidebars;
}

//Get default Woocommerce variable
function avante_get_woocommerce() {
	global $woocommerce;
	return $woocommerce;
}

//Get all google font usages in customizer
function avante_get_google_fonts() {
	$avante_google_fonts = array('tg_body_font', 'tg_header_font', 'tg_menu_font', 'tg_sidemenu_font', 'tg_sidebar_title_font', 'tg_button_font');
	
	global $avante_google_fonts;
	return $avante_google_fonts;
}

//Get menu transparent variable
function avante_get_page_menu_transparent() {
	global $avante_page_menu_transparent;
	return $avante_page_menu_transparent;
}

//Set menu transparent variable
function avante_set_page_menu_transparent($new_value = '') {
	global $avante_page_menu_transparent;
	$avante_page_menu_transparent = $new_value;
}

//Get no header checker variable
function avante_get_is_no_header() {
	global $avante_is_no_header;
	return $avante_is_no_header;
}

//Get deafult theme screen CSS class
function avante_get_screen_class() {
	global $avante_screen_class;
	return $avante_screen_class;
}

//Set deafult theme screen CSS class
function avante_set_screen_class($new_value = '') {
	global $avante_screen_class;
	$avante_screen_class = $new_value;
}

//Get theme homepage style
function avante_get_homepage_style() {
	global $avante_homepage_style;
	return $avante_homepage_style;
}

//Set theme homepage style
function avante_set_homepage_style($new_value = '') {
	global $avante_homepage_style;
	$avante_homepage_style = $new_value;
}

//Get page gallery ID
function avante_get_page_gallery_id() {
	global $avante_page_gallery_id;
	return $avante_page_gallery_id;
}

//Get default theme options variable
function avante_get_options() {
	global $avante_options;
	return $avante_options;
}

//Set default theme options variable
function avante_set_options($new_value = '') {
	global $avante_options;
	$avante_options = $new_value;
}

//Get top bar setting
function avante_get_topbar() {
	global $avante_topbar;
	return $avante_topbar;
}

//Set top bar setting
function avante_set_topbar($new_value = '') {
	global $avante_topbar;
	$avante_topbar = $new_value;
}

//Get is hide title option
function avante_get_hide_title() {
	global $avante_hide_title;
	return $avante_hide_title;
}

//Set is hide title option
function avante_set_hide_title($new_value = '') {
	global $avante_hide_title;
	$avante_hide_title = $new_value;
}

//Get theme page content CSS class
function avante_get_page_content_class() {
	global $avante_page_content_class;
	return $avante_page_content_class;
}

//Set theme page content CSS class
function avante_set_page_content_class($new_value = '') {
	global $avante_page_content_class;
	$avante_page_content_class = $new_value;
}

//Get Kirki global variable
function avante_get_kirki() {
	global $kirki;
	return $kirki;
}

//Get admin theme global variable
function avante_get_wp_admin_css_colors() {
	global $_wp_admin_css_colors;
	return $_wp_admin_css_colors;
}

//Get theme plugins
function avante_get_plugins() {
	global $avante_tgm_plugins;
	return $avante_tgm_plugins;
}

//Set theme plugins
function avante_set_plugins($new_value = '') {
	global $avante_tgm_plugins;
	$avante_tgm_plugins = $new_value;
}

$is_verified_envato_purchase_code = false;

//Get verified purchase code data
$pp_verified_envato_avante = get_option("pp_verified_envato_avante");
if(!empty($pp_verified_envato_avante))
{
	$is_verified_envato_purchase_code = true;
}

$is_imported_elementor_templates_avante = false;
$pp_imported_elementor_templates_avante = get_option("pp_imported_elementor_templates_avante");
if(!empty($pp_imported_elementor_templates_avante))
{
	$is_imported_elementor_templates_avante = true;
}
?>