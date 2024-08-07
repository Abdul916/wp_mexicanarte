<?php
//avante_themegoods_action();
$is_verified_envato_purchase_code = false;

//Get verified purchase code data
$is_verified_envato_purchase_code = avante_is_registered();

//Layout demo importer
$demo_import_options_arr = array( 
	array('id'	=>	'demo1', 'title' => 'Main Demo', 'url' => 'http://themes.themegoods.com/avante/demo/', 'demo' => 1),
);

/*
	Begin creating admin options
*/

$getting_started_html = '';

if(!$is_verified_envato_purchase_code)
{
	$getting_started_html.= '<div class="theme-setting-notice">
			<span class="dashicons dashicons-warning"></span> 
			Please visit <a href="javascript:jQuery(\'#setting-panel-registration-a\').trigger(\'click\');">Product Registration page</a> and enter a valid Envato Token to import the full '.AVANTE_THEMENAME.' demos and single pages through Elementor.
		</div>
		';
}
else
{
	$getting_started_html.= '<div class="clear-height"></div>';
}

$getting_started_html.= '<div class="one-half">
		<div class="step-icon">
			<a href="'.esc_url(admin_url("themes.php?page=install-required-plugins")).'">
				<div class="step-number">Step <div class="int-number">1</div></div>
			</a>
		</div>
		<div class="step-info">
			<h3>Install the recommended plugins</h3>
			Theme has required and recommended plugins in order to build your website using layouts you saw on our demo site. We recommend you to install recommended plugins.
		</div>
	</div>
	
	<div class="one-half last">
		<div class="step-icon">
			<a href="'.esc_js('javascript:;').'" onclick="jQuery(\'#setting-panel-import-demo-a\').trigger(\'click\');">
				<div class="step-number">Step <div class="int-number">2</div></div>
			</a>
		</div>
		<div class="step-info">
			<h3>Import the demo data</h3>
			Here you can import the demo data to your site. Doing this will make your site look like the demo site. It helps you to understand better the theme and build something similar to our demo quicker.
		</div>
	</div>
	
	<div class="one-half">
		<div class="step-icon">
			<a href="'.esc_url(admin_url("customize.php")).'">
				<div class="step-number">Step <div class="int-number">3</div></div>
			</a>
		</div>
		<div class="step-info">
			<h3>Customize theme elements and options</h3>
			Start customize theme\'s layouts, typography, elements colors using WordPress customize and see your changes in live preview instantly.
		</div>
	</div>
	
	<div class="one-half last">
		<div class="step-icon">
			<a href="'.esc_url(admin_url("post-new.php?post_type=page")).'">
				<div class="step-number">Step <div class="int-number">4</div></div>
			</a>
		</div>
		<div class="step-info">
			<h3>Create pages</h3>
			'.AVANTE_THEMENAME.' support standard WordPress page option. You can also use Elementor page builder to create and organise page contents.
		</div>
	</div>
	
	<div class="one-half">
		<div class="step-icon">
			<a href="'.esc_url(admin_url("nav-menus.php")).'">
				<div class="step-number">Step <div class="int-number">5</div></div>
			</a>
		</div>
		<div class="step-info">
			<h3>Setting up navigation menu</h3>
			Once you imported demo or created your own pages. You can setup navigation menu and assign to your website main header or any other places.
		</div>
	</div>
	
	<div class="one-half last">
		<div class="step-icon">
			<a href="'.esc_url(admin_url("options-permalink.php")).'">
				<div class="step-number">Step <div class="int-number">6</div></div>
			</a>
		</div>
		<div class="step-info">
			<h3>Permalinks structure</h3>
			You can change your website permalink structure to better SEO result. Click here to setup WordPress permalink options.
		</div>
	</div>';

$getting_started_html.= '<br class="clear"/>
	
	<div class="one-half nomargin">
		<div class="step-icon">
			<a href="https://themegoods.ticksy.com/submit/" target="_blank">
				<i class="fas fa-life-ring"></i>
				<div class="step-title">Submit a Ticket</div>
			</a>
		</div>
		<div class="step-info">
			<h3>Theme support</h3>
			We offer excellent support through our ticket system. Please make sure you prepare your purchased code first to access our services.
		</div>
	</div>
	
	<div class="one-half last nomargin">
		<div class="step-icon">
			<a href="https://docs.themegoods.com/docs/avante" target="_blank">
				<i class="fas fa-book"></i>
				<div class="step-title">Theme Document</div>
			</a>
		</div>
		<div class="step-info">
			<h3>Online documentation</h3>
			This is the place to go find all reference aspects of theme functionalities. Our online documentation is resource for you to start using theme.
		</div>
	</div>
';

//Get product registration

//if verified envato purchase code
$check_icon = '';
$verification_desc = 'Thank you for choosing '.AVANTE_THEMENAME.'. Your product must be registered to receive many advantage features ex. demos import and support. We are sorry about this extra step but we built the activation system to prevent mass piracy of our themes. This will help us to better serve our paying customers.';
//Check if have any purchase code verification error
$response_html = '';
$purchase_code = '';
$register_button_html = '<input type="submit" name="submit" id="themegoods-envato-code-submit" class="button button-primary button-large" value="Register"/>';

//If already registered
if(!empty($is_verified_envato_purchase_code))
{
	$response_html.= '<br style="clear:both;"/><div class="registeration-valid"><span class="dashicons dashicons-yes"></span>Your product is registered.</div>';
	$register_button_html = '<input type="submit" name="submit" id="themegoods-envato-code-unregister" class="button button-primary button-large" value="Unregister"/>';
	$purchase_code = $is_verified_envato_purchase_code;
}

//Displays purchase code verification response
if(isset($_GET['response']) && !empty($_GET['response'])) {
	$response_arr = json_decode(stripcslashes($_GET['response']));
	$purchase_code = '';
	if(isset($_GET['purchase_code']) && !empty($_GET['purchase_code'])) {
		$purchase_code = $_GET['purchase_code'];
	}
	
	if(isset($response_arr->response_code)) {
		if(!$response_arr->response_code) {
			$response_html.= '<br style="clear:both;"/><div class="theme-setting-error"><span class="dashicons dashicons-warning"></span>'.$response_arr->response.'</div>';
		}
	}
	else {
		$response_html.= '<br style="clear:both;"/><div class="theme-setting-error"><span class="dashicons dashicons-warning"></span> We can\'t verify your purchase of '.AVANTE_THEMENAME.' theme. Please make sure you enter correct purchase code. If you are sure you enter correct one. <a href="https://themegoods.ticksy.com" target="_blank">Please open a ticket</a> to us so our support staff can help you. Thank you very much.</div>';
	}
}

$product_registration_html ='
		<h1>Product Registration</h1>
		<div class="getting_started_desc">'.$verification_desc.'</div>
		<br style="clear:both;"/>
		
		<div style="height:10px"></div>
		
		<label for="pp_envato_personal_token">'.$check_icon.'Purchase Code</label>
		<small class="description">Please enter your Purchase Code.</small>';
$product_registration_html.= $register_button_html;

$purchase_code_input_class = '';
if(!empty($is_verified_envato_purchase_code)) {
	$purchase_code_input_class = 'themegoods-verified';
}

$product_registration_html.= '<input name="pp_envato_personal_token" id="pp_envato_personal_token" type="text" value="'.esc_attr($purchase_code).'" class="'.esc_attr($purchase_code_input_class).'"/>
		<input name="themegoods-site-domain" id="themegoods-site-domain" type="hidden" value="'.esc_attr(avante_get_site_domain()).'"/>
	';
	
	$product_registration_html.= $response_html;
	
if(isset($_GET['action']) && $_GET['action'] == 'invalid-purchase')
{
	$product_registration_html.='<br class="clear"/><div class="theme-setting-error"><span class="dashicons dashicons-warning"></span> We can\'t find your purchase of '.AVANTE_THEMENAME.' theme. Please make sure you enter correct Envato Token. If you are sure you enter correct one. <a href="https://themegoods.ticksy.com" target="_blank">Please open a ticket</a> to us so our support staff can help you. Thank you very much.</div>';
}

if(!$is_verified_envato_purchase_code)
{
	$product_registration_html.='
	<br style="clear:both;"/>
	<div style="height:30px"></div>
	<h1>How to get Purchase Code</h1>
	<ol>
	 <li>You must be logged into the same Envato account that purchased '.AVANTE_THEMENAME.' theme.</li>
	 <li>Hover the mouse over your username at the top right corner of the screen.</li>
							<li>Click "Downloads" from the drop-down menu.</li>
							<li>Find '.AVANTE_THEMENAME.' theme your downloads list</li>
							<li>Click "Download" button and click "License certificate & purchase code" (available as PDF or text file).</li>
	</ol>
	<strong>You can see detailed article and video screencast about "how to find your purchase code" <a href="https://help.market.envato.com/hc/en-us/articles/202822600-Where-Is-My-Purchase-Code-" target="_blank">here</a>.</strong>
';
}

//If already registered and add a link to license manager
if(!empty($is_verified_envato_purchase_code))
{
	$product_registration_html.='<br style="clear:both;"/><div style="height:20px"></div>
	<h1>Manage Your License</h1>
	<div class="getting_started_desc">To manage all your purchase code. Please open an account or login on <a href="https://license.themegoods.com/manager/" target="_blank">ThemeGoods License Manager</a>.
	</div>
	';
}

//Check if Envato Market plugin is installed
$envato_market_activated = function_exists('envato_market');

if($is_verified_envato_purchase_code && !$envato_market_activated)
{
	$product_registration_html.='<br class="clear"/>
	<h2>Auto Update</h2>
	<div class="theme-setting-getting-started auto-update">To enable auto update feature. You first must <a href="'.esc_url(admin_url('themes.php?page=install-required-plugins')).'">install Envato Market plugin</a> and enter your purchase code there. <a href="https://help.market.envato.com/hc/en-us/articles/202822600-Where-Is-My-Purchase-Code-" target="_blank">Find your purchase code</a></div>
	<br class="clear"/>
	';
}

//Get system info
$has_red_status = false;


//Get memory_limit
$memory_limit = ini_get('memory_limit');
$memory_limit_class = 'registeration-valid';
$memory_limit_text = '';
if(intval($memory_limit) < 128)
{
    $memory_limit_class = 'theme-setting-error';
    $has_error = 1;
    $memory_limit_text = '*RECOMMENDED 128M';
    
    $has_red_status = true;
}

$memory_limit_text = '<div class="'.$memory_limit_class.'">'.$memory_limit.' '.$memory_limit_text.'</div>';

//Get post_max_size
$post_max_size = ini_get('post_max_size');
$post_max_size_class = 'registeration-valid';
$post_max_size_text = '';
if(intval($post_max_size) < 32)
{
    $post_max_size_class = 'theme-setting-error';
    $has_error = 1;
    $post_max_size_text = '*RECOMMENDED 32M';
    
    $has_red_status = true;
}
$post_max_size_text = '<div class="'.$post_max_size_class.'">'.$post_max_size.' '.$post_max_size_text.'</div>';

//Get max_execution_time
$max_execution_time = ini_get('max_execution_time');
$max_execution_time_class = 'registeration-valid';
$max_execution_time_text = '';
if($max_execution_time < 180)
{
    $max_execution_time_class = 'theme-setting-error';
    $has_error = 1;
    $max_execution_time_text = '*RECOMMENDED 180';
    
    $has_red_status = true;
}
$max_execution_time_text = '<div class="'.$max_execution_time_class.'">'.$max_execution_time.' '.$max_execution_time_text.'</div>';

//Get max_input_vars
$max_input_vars = ini_get('max_input_vars');
$max_input_vars_class = 'registeration-valid';
$max_input_vars_text = '';
if(intval($max_input_vars) < 2000)
{
    $max_input_vars_class = 'theme-setting-error';
    $has_error = 1;
    $max_input_vars_text = '*RECOMMENDED 2000';
    
    $has_red_status = true;
}
$max_input_vars_text = '<div class="'.$max_input_vars_class.'">'.$max_input_vars.' '.$max_input_vars_text.'</div>';

//Get upload_max_filesize
$upload_max_filesize = ini_get('upload_max_filesize');
$upload_max_filesize_class = 'registeration-valid';
$upload_max_filesize_text = '';
if(intval($upload_max_filesize) < 32)
{
    $upload_max_filesize_class = 'theme-setting-error';
    $has_error = 1;
    $upload_max_filesize_text = '*RECOMMENDED 32M';
    
    $has_red_status = true;
}
$upload_max_filesize_text = '<div class="'.$upload_max_filesize_class.'">'.$upload_max_filesize.' '.$upload_max_filesize_text.'</div>';

//Get GD library version
$php_gd_arr = gd_info();

$system_info_html = '';
if(!$is_verified_envato_purchase_code)
{
	$system_info_html = '
	<div class="theme-setting-notice">
					<span class="dashicons dashicons-warning"></span> 
					<span class="header">'.AVANTE_THEMENAME.' Demos can only be imported with a valid Envato Token</span><br/><br/>
					Please visit <a href="javascript:jQuery(\'#setting-panel-registration-a\').trigger(\'click\');">Product Registration page</a> and enter a valid Envato Token to import the full '.AVANTE_THEMENAME.' demos and single pages through Elementor.
				</div>
		';
}
else
{
	$system_info_html = '<table class="widefat" cellspacing="0">
			<thead>
				<tr>
					<th colspan="3">Server Environment</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td class="title">PHP Version:</td>
					<td class="help"><a href="'.esc_js('javascript:;').'" title="The version of PHP installed on your hosting server." class="tooltipster">[?]</a></td>
					<td class="value">'.phpversion().'</td>
				</tr>
				<tr>
					<td class="title">WP Memory Limit:</td>
					<td class="help"><a href="'.esc_js('javascript:;').'" title="The maximum amount of memory (RAM) that your site can use at one time." class="tooltipster">[?]</a></td>
					<td class="value">'.$memory_limit_text.'</td>
				</tr>
				<tr>
					<td class="title">PHP Post Max Size:</td>
					<td class="help"><a href="'.esc_js('javascript:;').'" title="The largest file size that can be contained in one post." class="tooltipster">[?]</a></td>
					<td class="value">'.$post_max_size_text.'</td>
				</tr>
				<tr>
					<td class="title">PHP Time Limit:</td>
					<td class="help"><a href="'.esc_js('javascript:;').'" title="The amount of time (in seconds) that your site will spend on a single operation before timing out (to avoid server lockups)" class="tooltipster">[?]</a></td>
					<td class="value">'.$max_execution_time_text.'</td>
				</tr>
				<tr>
					<td class="title">PHP Max Input Vars:</td>
					<td class="help"><a href="'.esc_js('javascript:;').'" title="The maximum number of variables your server can use for a single function to avoid overloads." class="tooltipster">[?]</a></td>
					<td class="value">'.$max_input_vars_text.'</td>
				</tr>
				<tr>
					<td class="title">Max Upload Size:</td>
					<td class="help"><a href="'.esc_js('javascript:;').'" title="The largest filesize that can be uploaded to your WordPress installation." class="tooltipster">[?]</a></td>
					<td class="value">'.$upload_max_filesize_text.'</td>
				</tr>
				<tr>
					<td class="title">GD Library:</td>
					<td class="help"><a href="'.esc_js('javascript:;').'" title="This library help resizing images and improve site loading speed" class="tooltipster">[?]</a></td>
					<td class="value">'.$php_gd_arr['GD Version'].'</td>
				</tr>
			</tbody>
		</table>';
		
		$system_info_html.= '
			<div class="theme-setting-notice">
				<span>If you have experience issue regarding import demo contents. <a href="https://docs.themegoods.com/docs/avante/demos/import-demo-issue/" target="_blank">Please see explanation and workaround for the issue here</a></span>
			</div>';
		
		//Check if required plugins is installed
		$elementor_activated = function_exists('elementor_load_plugin_textdomain');
		$avante_elementor_activated = function_exists('avante_elementor_load');
		$ocdi_activated = class_exists('OCDI_Plugin');
		
		if($elementor_activated && $avante_elementor_activated && $ocdi_activated)
		{
			if($has_red_status)
			{
				$system_info_html.= '
			<div class="theme-setting-notice">
				<span class="dashicons dashicons-warning"></span> 
				<span>There are some settings which are below theme recommendation values and it might causes issue importing demo contents.</span>
			</div>';
			
				$import_demo_button_label = 'I understand and want to process demo importing process';
			}
			else
			{
				$import_demo_button_label = 'Begin importing demo process';
			}
			
			$system_info_html.= '<div class="notice-begin-import"><a href="'.esc_url(admin_url('themes.php?page=tg-one-click-demo-import')).'" class="button button-primary button-large">'.$import_demo_button_label.'</a></div>';
		}
		else
		{
			$system_info_html.= '
			<div class="theme-setting-notice">
				<span class="dashicons dashicons-warning"></span> 
				<span class="header">One Click Demo Import, Elementor and '.AVANTE_THEMENAME.' Elementor plugins required</span><br/><br/>
				Please <a href="'.esc_url(admin_url("themes.php?page=install-required-plugins")).'">install and activate these required plugins.</a> first so demo contents can be imported properly.
			</div>';
		}
}

$avante_options = avante_get_options();

$avante_options = array (
 
//Begin admin header
array( 
		"name" => AVANTE_THEMENAME." Options",
		"type" => "title"
),
//End admin header


//Begin second tab "Home"
array( 	"name" => "Home",
		"type" => "section",
		"icon" => "dashicons-admin-home",
),
array( "type" => "open"),

array( "name" => "",
	"desc" => "",
	"id" => AVANTE_SHORTNAME."_home",
	"type" => "html",
	"html" => '
	<h1>Getting Started</h1>
	<div class="theme-setting-getting-started">Welcome to '.AVANTE_THEMENAME.' theme. '.AVANTE_THEMENAME.' is now installed and ready to use! Please follow below steps to getting started.</div>
	'.$getting_started_html.'
	',
),

array( "type" => "close"),
//End second tab "Home"


//Begin second tab "Registration"
array( 	"name" => "Registration",
		"type" => "section",
		"icon" => "dashicons-admin-network",	
),
array( "type" => "open"),

array( "name" => "",
	"desc" => "",
	"id" => AVANTE_SHORTNAME."_registration",
	"type" => "html",
	"html" => $product_registration_html,
),

array( "type" => "close"),
//End second tab "Registration"


//Begin second tab "Demo"
array( "name" => "Import-Demo",
	"type" => "section",
	"icon" => "dashicons-cloud",
),

array( "type" => "open"),

array( "name" => "",
	"desc" => "",
	"id" => AVANTE_SHORTNAME."_import_demo_notice",
	"type" => "html",
	"html" => '<h1>Checklist before Importing Demo</h1><br/><strong>IMPORTANT</strong>: Demo importer can vary in time. The included required plugins need to be installed and activated before you import demo. Please check the Server Environment below to ensure your server meets all requirements for a successful import. <strong>Settings that need attention will be listed in red</strong>.
	',
),
array( "name" => "",
	"desc" => "",
	"id" => AVANTE_SHORTNAME."_import_demo_content",
	"type" => "html",
	"html" => $system_info_html,
),
 
array( "type" => "close"),


//Begin second tab "Images"
array( "name" => "Images",
	"type" => "section",
	"icon" => "dashicons-format-image",
),

array( "type" => "open"),

array( "name" => "",
	"desc" => "",
	"id" => AVANTE_SHORTNAME."_gallery_image_dimensions_notice",
	"type" => "html",
	"html" => '<h1>Defined Image Size</h1>These settings affect the display and dimensions of images in your portfolio, gallery, blog pages – the display on the front-end will still be affected by CSS styles. After changing these settings you may need to <a href="https://wordpress.org/plugins/force-regenerate-thumbnails/" target="_blank">regenerate your thumbnails</a>
	',
),
array( "name" => "<h2>Gallery Grid Image Dimensions Settings</h2>Image Width",
	"desc" => "Enter gallery grid image width(in pixels).",
	"id" => AVANTE_SHORTNAME."_gallery_grid_image_width",
	"type" => "text",
	"std" => "700",
	"validation" => "text",
),
array( "name" => "Image Height",
	"desc" => "Enter gallery grid image height(in pixels). Please enter 9999 for auto height.",
	"id" => AVANTE_SHORTNAME."_gallery_grid_image_height",
	"type" => "text",
	"std" => "466",
	"validation" => "text",
),
array( "name" => "<h2>Gallery Masonry Image Dimensions Settings</h2>Image Width",
	"desc" => "Enter gallery masonry image width(in pixels).",
	"id" => AVANTE_SHORTNAME."_gallery_masonry_image_width",
	"type" => "text",
	"std" => "440",
	"validation" => "text",
),
array( "name" => "Image Height",
	"desc" => "Enter gallery masonry image height(in pixels). Please enter 9999 for auto height.",
	"id" => AVANTE_SHORTNAME."_gallery_masonry_image_height",
	"type" => "text",
	"std" => "9999",
	"validation" => "text",
),
array( "name" => "<h2>Gallery List Image Dimensions Settings</h2>Image Width",
	"desc" => "Enter gallery list image width(in pixels).",
	"id" => AVANTE_SHORTNAME."_gallery_list_image_width",
	"type" => "text",
	"std" => "610",
	"validation" => "text",
),
array( "name" => "Image Height",
	"desc" => "Enter gallery list image height(in pixels). Please enter 9999 for auto height.",
	"id" => AVANTE_SHORTNAME."_gallery_list_image_height",
	"type" => "text",
	"std" => "610",
	"validation" => "text",
),
array( "name" => "<h2>Blog Classic Featured Image Dimensions Settings</h2>Image Width",
	"desc" => "Enter blog classic featured image width(in pixels).",
	"id" => AVANTE_SHORTNAME."_blog_image_width",
	"type" => "text",
	"std" => "960",
	"validation" => "text",
),
array( "name" => "Image Height",
	"desc" => "Enter blog classic featured image height(in pixels). Please enter 9999 for auto height.",
	"id" => AVANTE_SHORTNAME."_blog_image_height",
	"type" => "text",
	"std" => "604",
	"validation" => "text",
),
array( "name" => "<h2>Blog Grid Featured Image Dimensions Settings</h2>Image Width",
	"desc" => "Enter blog grid featured image width(in pixels).",
	"id" => AVANTE_SHORTNAME."_blog_grid_image_width",
	"type" => "text",
	"std" => "480",
	"validation" => "text",
),
array( "name" => "Image Height",
	"desc" => "Enter blog grid featured image height(in pixels). Please enter 9999 for auto height.",
	"id" => AVANTE_SHORTNAME."_blog_grid_image_height",
	"type" => "text",
	"std" => "302",
	"validation" => "text",
),
 
array( "type" => "close"),


//Begin fifth tab "Social Profiles"
array( 	"name" => "Social-Profiles",
		"type" => "section",
		"icon" => "dashicons-facebook",
),
array( "type" => "open"),
	
array( "name" => "",
	"desc" => "",
	"id" => AVANTE_SHORTNAME."_social_profiles_title",
	"type" => "html",
	"html" => '<h1>Social Profiles Accounts</h1>Setup your social profiles accounts. It can be used for navigation bar, footer etc.',
),
array( "name" => "<h2>Accounts Settings</h2>Facebook page URL",
	"desc" => "Enter full Facebook page URL",
	"id" => AVANTE_SHORTNAME."_facebook_url",
	"type" => "text",
	"std" => "",
	"validation" => "text",
),
array( "name" => "Twitter profile URL",
	"desc" => "Enter Twitter profile URL",
	"id" => AVANTE_SHORTNAME."_twitter_username",
	"type" => "text",
	"std" => "",
	"validation" => "text",
),
array( "name" => "Flickr profile URL",
	"desc" => "Enter Flickr profile URL",
	"id" => AVANTE_SHORTNAME."_flickr_username",
	"type" => "text",
	"std" => "",
	"validation" => "text",
),
array( "name" => "Youtube profile URL",
	"desc" => "Enter Youtube profile URL",
	"id" => AVANTE_SHORTNAME."_youtube_url",
	"type" => "text",
	"std" => "",
	"validation" => "text",
),
array( "name" => "Vimeo profile URL",
	"desc" => "Enter Vimeo profile URL",
	"id" => AVANTE_SHORTNAME."_vimeo_username",
	"type" => "text",
	"std" => "",
	"validation" => "text",
),
array( "name" => "Dribbble profile URL",
	"desc" => "Enter Dribbble profile URL",
	"id" => AVANTE_SHORTNAME."_dribbble_username",
	"type" => "text",
	"std" => "",
	"validation" => "text",
),
array( "name" => "Linkedin URL",
	"desc" => "Enter full Linkedin URL",
	"id" => AVANTE_SHORTNAME."_linkedin_url",
	"type" => "text",
	"std" => "",
	"validation" => "text",
),
array( "name" => "Pinterest profile URL",
	"desc" => "Enter Pinterest profile URL",
	"id" => AVANTE_SHORTNAME."_pinterest_username",
	"type" => "text",
	"std" => "",
	"validation" => "text",
),
array( "name" => "Instagram profile URL",
	"desc" => "Enter Instagram profile URL",
	"id" => AVANTE_SHORTNAME."_instagram_username",
	"type" => "text",
	"std" => "",
	"validation" => "text",
),
array( "name" => "Behance profile URL",
	"desc" => "Enter Behance profile URL",
	"id" => AVANTE_SHORTNAME."_behance_username",
	"type" => "text",
	"std" => "",
	"validation" => "text",
),
array( "name" => "500px Profile URL",
	"desc" => "Enter 500px Profile URL",
	"id" => AVANTE_SHORTNAME."_500px_url",
	"type" => "text",
	"std" => "",
	"validation" => "text",
),

array( "name" => "Flickr ID",
	"desc" => "Enter Flickr ID. <a href=\"http://idgettr.com/\" target=\"_blank\">Find your Flickr ID here</a>",
	"id" => AVANTE_SHORTNAME."_flickr_id",
	"type" => "text",
	"std" => "",
	"validation" => "text",
),
array( "type" => "close"),

//End fifth tab "Social Profiles"

array( 	"name" => "Buy-Another-License",
"type" => "section",
"icon" => "",		
),
array( "type" => "open"),

array( "type" => "close"),

);
 
$avante_options[] = array( "type" => "close");

avante_set_options($avante_options);
?>