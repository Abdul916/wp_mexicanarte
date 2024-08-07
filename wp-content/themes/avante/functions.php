<?php	
/*
Theme Name: Avante Theme
Theme URI: https://themes.themegoods.com/avante/landing
Author: ThemeGoods
Author URI: http://themeforest.net/user/ThemeGoods
License: GPLv2
*/

//Setup theme default constant and data
require_once get_template_directory() . "/lib/config.php";

//Setup theme translation
require_once get_template_directory() . "/lib/translation.php";

//Setup theme support and image size handler
require_once get_template_directory() . "/lib/theme-support.php";

//Get custom function
require_once get_template_directory() . "/lib/custom-functions.php";

//Setup menu settings
require_once get_template_directory() . "/lib/menu.php";

//Setup Sidebar
require_once get_template_directory() . "/lib/sidebar.php";

//Setup required plugin activation
require_once get_template_directory() . "/lib/tgmpa-extension.php";

//Setup theme admin settings
require_once get_template_directory() . "/lib/theme-setting.php";


/**
*	Begin Theme Setting Panel
**/ 

function avante_add_admin() 
{
	$avante_options = avante_get_options();
	$redirect_uri = '';
	 
	if (is_admin() && current_user_can('manage_options') && isset($_REQUEST['_wpnonce']) && wp_verify_nonce($_REQUEST['_wpnonce'], 'avante_save_theme_setting') && isset($_REQUEST['action']) && 'save' == $_REQUEST['action']) {
	
		//check if verify purchase code
		if(isset($_REQUEST['submit']) && $_REQUEST['submit'] == 'Register')
		{
			if(!empty($_REQUEST['pp_envato_personal_token']) && strlen($_REQUEST['pp_envato_personal_token']) == 36) {
				$url = THEMEGOODS_API.'/register-purchase';
				$data = array(
					'purchase_code' => $_REQUEST['pp_envato_personal_token'], 
					'domain' => $_REQUEST['themegoods-site-domain'],
					'item_id' => ENVATOITEMID,
				);
				$data = wp_json_encode( $data );
				$args = array( 
					'method'   	=> 'POST',
					'body'		=> $data,
				);
				//print '<pre>'; var_dump($args); print '</pre>';
				
				$response = wp_remote_post( $url, $args );
				$response_body = wp_remote_retrieve_body( $response );
				$response_obj = json_decode($response_body);
				
				$response_json = urlencode($response_body);
				//print '<pre>'; var_dump($response_body); print '</pre>';
				//print '<pre>'; var_dump("admin.php?page=functions.php&response=".$response_json."".$redirect_uri.$_REQUEST['current_tab']); print '</pre>';
				//die;
				
				if(is_bool($response_obj->response_code)) {
					if($response_obj->response_code) {
						$success_message = "Purchase code is registered.";
						
						if(!empty($response_obj->response)) {
							$error_message = $response_obj->response;
						}
						
						avante_register_theme($_REQUEST['pp_envato_personal_token']);
						wp_redirect(admin_url()."?page=functions.php&purchase_code=".$_REQUEST['pp_envato_personal_token']."&response=".$response_json."".$redirect_uri.$_REQUEST['current_tab']);
						
						die;
					}
					else {
						$error_message = "Purchase code is invalid.";
						
						wp_redirect(admin_url()."?page=functions.php&purchase_code=".$_REQUEST['pp_envato_personal_token']."&response=".$response_json."".$redirect_uri.$_REQUEST['current_tab']);
						
						die;
					}
				}
				else {
					$error_message = "Purchase code is invalid";
					
					wp_redirect(admin_url()."?page=functions.php&purchase_code=".$_REQUEST['pp_envato_personal_token']."&response=".$response_json."".$redirect_uri.$_REQUEST['current_tab']);
					
					die;
				}
			}
			else {
				$error_message = "Purchase code is invalid";
				wp_redirect(admin_url()."?page=functions.php&purchase_code=".$_REQUEST['pp_envato_personal_token']."&response=".$response_json."".$redirect_uri.$_REQUEST['current_tab']);
				
				die;
			}
		}
		
		//check if unregister purchase code
		if(isset($_REQUEST['submit']) && $_REQUEST['submit'] == 'Unregister')
		{
			if(!empty($_REQUEST['pp_envato_personal_token']) && strlen($_REQUEST['pp_envato_personal_token']) == 36) {
				$url = THEMEGOODS_API.'/unregister-purchase';
				$data = array(
					'purchase_code' => $_REQUEST['pp_envato_personal_token'], 
					'domain' => $_REQUEST['themegoods-site-domain'],
					'item_id' => ENVATOITEMID,
				);
				$data = wp_json_encode( $data );
				$args = array( 
					'method'   	=> 'POST',
					'body'		=> $data,
				);
				$response = wp_remote_post( $url, $args );
				$response_body = wp_remote_retrieve_body( $response );
				$response_obj = json_decode($response_body);
				
				$response_json = urlencode($response_body);
				/*print '<pre>'; var_dump($args); print '</pre>';
				print '<pre>'; var_dump($response_json); print '</pre>';
				die;*/
				if(is_bool($response_obj->response_code)) {
					if($response_obj->response_code) {
						$success_message = "Purchase code is unregistered.";
						
						if(!empty($response_obj->response)) {
							$error_message = $response_obj->response;
						}
						
						avante_unregister_theme();
						wp_redirect(admin_url()."?page=functions.php&response=".$response_json."".$redirect_uri.$_REQUEST['current_tab']);
						
						die;
					}
					else {
						$error_message = "Purchase code is invalid.";
						
						wp_redirect(admin_url()."?page=functions.php&purchase_code=".$_REQUEST['pp_envato_personal_token']."&response=".$response_json."".$redirect_uri.$_REQUEST['current_tab']);
						
						die;
					}
				}
				else {
					$error_message = "Purchase code is invalid";
					
					wp_redirect(admin_url()."?page=functions.php&purchase_code=".$_REQUEST['pp_envato_personal_token']."&response=".$response_json."".$redirect_uri.$_REQUEST['current_tab']);
					
					die;
				}
			}
			else {
				$error_message = "Purchase code is invalid";
				wp_redirect(admin_url()."?page=functions.php&purchase_code=".$_REQUEST['pp_envato_personal_token']."&response=".$response_json."".$redirect_uri.$_REQUEST['current_tab']);
				
				die;
			}
		}
	
		foreach ($avante_options as $value) 
		{
			if($value['type'] != 'image' && isset($value['id']) && isset($_REQUEST[ $value['id'] ]))
			{
				update_option( $value['id'], $_REQUEST[ $value['id'] ] );
			}
		}
		
		foreach ($avante_options as $value) {
		
			if( isset($value['id']) && isset( $_REQUEST[ $value['id'] ] )) 
			{ 
	
				if($value['id'] != AVANTE_SHORTNAME."_sidebar0" && $value['id'] != AVANTE_SHORTNAME."_ggfont0")
				{
					if(is_admin())
					{
						if($value['type']=='image')
						{
							update_option( $value['id'], esc_url($_REQUEST[ $value['id'] ])  );
						}
						elseif($value['type']=='textarea')
						{
							if(isset($value['validation']) && !empty($value['validation']))
							{
								update_option( $value['id'], esc_textarea($_REQUEST[ $value['id'] ]) );
							}
							else
							{
								update_option( $value['id'], $_REQUEST[ $value['id'] ] );
							}
						}
						elseif($value['type']=='iphone_checkboxes' OR $value['type']=='jslider')
						{
							update_option( $value['id'], $_REQUEST[ $value['id'] ]  );
						}
						else
						{
							if(isset($value['validation']) && !empty($value['validation']))
							{
								$request_value = $_REQUEST[ $value['id'] ];
								
								//Begin data validation
								switch($value['validation'])
								{
									case 'text':
									default:
										$request_value = sanitize_text_field($request_value);
									
									break;
									
									case 'email':
										$request_value = sanitize_email($request_value);
	
									break;
									
									case 'javascript':
										$request_value = sanitize_text_field($request_value);
	
									break;
									
								}
								update_option( $value['id'], $request_value);
							}
							else
							{
								update_option( $value['id'], $_REQUEST[ $value['id'] ]  );
							}
						}
					}
				}
				elseif(is_admin() && isset($_REQUEST[ $value['id'] ]) && !empty($_REQUEST[ $value['id'] ]))
				{
					if($value['id'] == AVANTE_SHORTNAME."_sidebar0")
					{
						//get last sidebar serialize array
						$current_sidebar = get_option(AVANTE_SHORTNAME."_sidebar");
						$request_value = $_REQUEST[ $value['id'] ];
						$request_value = sanitize_text_field($request_value);
						
						$current_sidebar[ $request_value ] = $request_value;
			
						update_option( AVANTE_SHORTNAME."_sidebar", $current_sidebar );
					}
					elseif($value['id'] == AVANTE_SHORTNAME."_ggfont0")
					{
						//get last ggfonts serialize array
						$current_ggfont = get_option(AVANTE_SHORTNAME."_ggfont");
						$current_ggfont[ $_REQUEST[ $value['id'] ] ] = $_REQUEST[ $value['id'] ];
			
						update_option( AVANTE_SHORTNAME."_ggfont", $current_ggfont );
					}
				}
			} 
			else 
			{ 
				if(is_admin() && isset($value['id']))
				{
					delete_option( $value['id'] );
				}
			} 
		}
	
		header("Location: admin.php?page=functions.php&saved=true".$redirect_uri.$_REQUEST['current_tab']);
	}
	 
	add_menu_page('Theme Setting', 'Theme Setting', 'administrator', 'functions.php', 'avante_admin', '', 3);
}

function avante_enqueue_admin_page_scripts() 
{
	$current_screen = avante_get_current_screen();
	
	//Enqueue CSS scripts for backend
	wp_enqueue_style('thickbox');
	wp_enqueue_style('avante-functions', get_template_directory_uri().'/backend/css/functions.css', false, '', 'all');

	wp_enqueue_style('switchery', get_template_directory_uri().'/backend/css/switchery.css', false, '', 'all');
	
	$is_elementor_edit_mode = false;
	$is_elementor_preview_mode = false;
	if (class_exists('\\Elementor\\Plugin')) {
		$is_elementor_edit_mode = \Elementor\Plugin::$instance->editor->is_edit_mode();
		$is_elementor_preview_mode = \Elementor\Plugin::$instance->preview->is_preview_mode();
	}
	
	if(!$is_elementor_edit_mode && !$is_elementor_preview_mode)
	{
		wp_enqueue_style('fontawesome', get_template_directory_uri().'/css/font-awesome.min.css', false, '', "all");
	}
	
	//Enqueue JS scripts for backend
	wp_enqueue_script('jquery-ui-core');
	wp_enqueue_script('jquery-ui-sortable');
	wp_enqueue_script('jquery-ui-tabs');
	wp_enqueue_script('media-upload');
	wp_enqueue_script('thickbox');
	wp_enqueue_script('jquery-ui-datepicker');
	
	$ap_vars = array(
	    'url' => esc_url(get_home_url('/')),
	    'includes_url' => esc_url(includes_url())
	);
	
	wp_enqueue_script('switchery', get_template_directory_uri().'/backend/switchery.js', false, '');
	
	wp_register_script('avante-theme-script', get_template_directory_uri().'/backend/main-script.js', false, '', true);
	$params = array(
	  	'ajaxurl' => esc_url(admin_url('admin-ajax.php')),
		'nonce' => wp_create_nonce( 'wp_rest' ),
		'tgurl' => THEMEGOODS_API,
		'itemid' => ENVATOITEMID,
		'purchaseurl' => THEMEGOODS_PURCHASE_URL,
	);
	wp_localize_script('avante-theme-script', 'tgAjax', $params );
	wp_enqueue_script('avante-theme-script');
}

add_action('admin_enqueue_scripts',	'avante_enqueue_admin_page_scripts' );

function avante_enqueue_front_page_scripts() 
{
	wp_enqueue_style('dashicons');
	wp_enqueue_style('avante-reset-css', get_template_directory_uri().'/css/core/reset.css', false, '');
	wp_enqueue_style('avante-wordpress-css', get_template_directory_uri().'/css/core/wordpress.css', false, '');
	wp_enqueue_style('avante-screen', get_template_directory_uri().'/css/core/screen.css', false, '', 'all');
	wp_enqueue_style('modulobox', get_template_directory_uri().'/css/modulobox.css', false, false, 'all' );
	
	//Check menu layout
	$tg_menu_layout = avante_menu_layout();
	
	switch($tg_menu_layout)
	{
		case 'leftalign':
			wp_enqueue_style('avante-left-align-menu', get_template_directory_uri().'/css/menus/left-align-menu.css', false, '', 'all');
		break;
		
		case 'full-burger-menu':
			wp_enqueue_style('avante-full-burger-menu', get_template_directory_uri().'/css/menus/full-burger-menu.css', false, '', 'all');
		break;
		
		case 'center-menu-logo':
			wp_enqueue_style('avante-center-menu-logo', get_template_directory_uri().'/css/menus/center-menu-logo.css', false, '', 'all');
		break;
	}
	
	//Add Font Awesome Support
	if (!class_exists('\\Elementor\\Plugin')) {
		wp_enqueue_style('fontawesome', get_template_directory_uri().'/css/font-awesome.min.css', false, '', 'all');
	}
	
	wp_enqueue_style('themify-icons', get_template_directory_uri().'/css/themify-icons.css', false, '', 'all');
	wp_enqueue_style('tooltipster', get_template_directory_uri().'/css/tooltipster.css', false, '', 'all');
    
    $tg_frame = get_theme_mod('tg_frame', false);
    if(!empty($tg_frame))
    {
    	wp_enqueue_style('avante-frame', get_template_directory_uri().'/css/core/frame.css', false, '', 'all');
    }
	
	if(AVANTE_THEMEDEMO)
    {
	    wp_enqueue_style('avante-demo', get_template_directory_uri().'/css/core/demo.css', false, '', 'all');
	}
	
	//If using child theme
	if(is_child_theme())
	{
	    wp_enqueue_style('avante-childtheme', get_stylesheet_directory_uri().'/style.css', false, '', 'all');
	}
	
	//Enqueue javascripts
	wp_enqueue_script('jquery-ui-core');
	wp_enqueue_script('jquery-effects-core');
	wp_enqueue_script('tweenmax', get_template_directory_uri().'/js/tweenmax.min.js', false, '', true);
	wp_enqueue_script('waypoints', get_template_directory_uri().'/js/waypoints.min.js', false, '', true);
	wp_enqueue_script('stellar', get_template_directory_uri().'/js/jquery.stellar.min.js', false, '', true);
	wp_enqueue_script('modulobox', get_template_directory_uri().'/js/modulobox.js', false, '', true);
	wp_enqueue_script('smoove', get_template_directory_uri().'/js/jquery.smoove.js', false, '', true);
	
	//Register theme javascript plugin file
	wp_register_script('avante-custom-plugins', get_template_directory_uri().'/js/core/custom_plugins.js', false, '', true);
	$params = array(
		'backTitle' 		=> esc_html__('Back', 'avante' ),
	);
	wp_localize_script( 'avante-custom-plugins', 'avantePluginParams', $params );
	wp_enqueue_script( 'avante-custom-plugins' );
	
	//Get settings params
	
	//Register theme main javascript file
	wp_register_script('avante-custom-script', get_template_directory_uri().'/js/core/custom.js', false, '', true);
	
	//Get settings params
	$tg_menu_layout = avante_menu_layout();
	$tg_fixed_menu = get_theme_mod('tg_fixed_menu', true);
	$tg_footer_reveal = get_theme_mod('tg_footer_reveal', false);
	$tg_header_content = get_theme_mod('tg_header_content', 'menu');
	$tg_topbar = get_theme_mod('tg_topbar', false);
	$tg_lightbox_thumbnails = get_theme_mod('tg_lightbox_thumbnails', 'thumbnail');
	$tg_lightbox_timer = get_theme_mod('tg_lightbox_timer', 7);
	
	$params = array(
		'menulayout' 		=> $tg_menu_layout,
		'fixedmenu' 		=> $tg_fixed_menu,
		'footerreveal' 		=> $tg_footer_reveal,
		'headercontent' 	=> $tg_header_content,
		'lightboxthumbnails' => $tg_lightbox_thumbnails,
		'lightboxtimer' 	=> intval($tg_lightbox_timer*1000),
	);
	wp_localize_script( 'avante-custom-script', 'avanteParams', $params );
	wp_enqueue_script( 'avante-custom-script' );
	
	//Check if disable right click
	$tg_enable_right_click = get_theme_mod('tg_enable_right_click', false);
	if(!empty($tg_enable_right_click))
	{
		$custom_right_click_script = '
		jQuery(function( $ ) {
			jQuery(document).bind("contextmenu", function(e) {
				jQuery("#right-click-content").addClass("visible");
				jQuery("body").addClass("right-clicked");
		    	e.preventDefault();
		    	
		    	jQuery(document).mousedown(function(event) {
			    	jQuery("#right-click-content").removeClass("visible");
					jQuery("body").removeClass("right-clicked");
			    });
		    });
		});
		';
		
		wp_add_inline_script( 'avante-custom-script', $custom_right_click_script );
	}
	
	$tg_enable_dragging = get_theme_mod('tg_enable_dragging', false);
	if(!empty($tg_enable_dragging))
	{
		$custom_drag_script = '
		jQuery(function( $ ) {
			jQuery("img").on("dragstart", function(event) { event.preventDefault(); });
		});
		';
		
		wp_add_inline_script( 'avante-custom-script', $custom_drag_script );
	}
	
	//Check if sticky sidebar
	$tg_sidebar_sticky = get_theme_mod('tg_sidebar_sticky', true);
	
	if(!empty($tg_sidebar_sticky))
	{
		wp_enqueue_script('sticky-kit', get_template_directory_uri().'/js/jquery.sticky-kit.min.js', false, '', true);
		
		$custom_sticky_kit_script = '
		jQuery(function( $ ) {
			jQuery("#page-content-wrapper .sidebar-wrapper").stick_in_parent({ offset_top: 100 });
			
			if(jQuery(window).width() < 768 || is_touch_device())
			{
				jQuery("#page-content-wrapper .sidebar-wrapper").trigger("sticky_kit:detach");
			}
		});
		';
		
		wp_add_inline_script( 'sticky-kit', $custom_sticky_kit_script );
	}
	
	//Check if enable lazy load image
	$tg_enable_lazy_loading = get_theme_mod('tg_enable_lazy_loading', true);
		
	if(!empty($tg_enable_lazy_loading))
	{
		wp_enqueue_script('lazy', get_template_directory_uri().'/js/jquery.lazy.js', false, '', true);
		$custom_lazy_script = '
		jQuery(function( $ ) {
			jQuery("img.lazy").each(function() {
				var currentImg = jQuery(this);
				
				jQuery(this).Lazy({
					onFinishedAll: function() {
						currentImg.parent("div.post-featured-image-hover").removeClass("lazy");
						currentImg.parent(".tg_gallery_lightbox").parent("div.gallery_grid_item").removeClass("lazy");
						currentImg.parent("div.gallery_grid_item").removeClass("lazy");
			        }
				});
			});
		});
		';
		
		wp_add_inline_script( 'lazy', $custom_lazy_script );
	}
	
	wp_enqueue_script('tooltipster', get_template_directory_uri().'/js/jquery.tooltipster.min.js', false, '', true);
	
	$custom_tooltipster_script = '
	jQuery(function( $ ) {
		jQuery(".demotip").tooltipster({
			position: "left",
			multiple: true,
			theme: "tooltipster-shadow",
			delay: 0
		});
	});
	';
	
	if(class_exists('LP_Global'))
	{
		$custom_tooltipster_script .= '
		jQuery("body.learnpress.profile .course_tooltip").tooltipster({
		    position: "right",
		    multiple: true,
		    contentCloning: true,
		    theme: "tooltipster-shadow",
		    minWidth: 300,
		    maxWidth: 300,
		    delay: 50,
		    interactive: true,
		});
		';
	}
	
	wp_add_inline_script( 'tooltipster', $custom_tooltipster_script );
	
}
add_action( 'wp_enqueue_scripts', 'avante_enqueue_front_page_scripts' );


//Enqueue mobile CSS after all others CSS load
function avante_register_mobile_css() 
{
	//Check if enable responsive layout
	wp_enqueue_style('avante-script-responsive-css', get_template_directory_uri().'/css/core/responsive.css', false, '', 'all');
}
add_action('wp_enqueue_scripts', 'avante_register_mobile_css', 99);


function avante_admin() 
{ 
	$avante_options = avante_get_options();
	
	if(function_exists( 'wp_enqueue_media' )){
	    wp_enqueue_media();
	}
	?>
		
		<form id="theme-setting-form" method="post" enctype="multipart/form-data">
		<div class="theme-setting-wrapper setting-wrapper">
		
		<div class="header-wrapper">
			<div class="header-logo">
			<?php
				//Display logo in theme setting
				$tg_retina_logo_for_admin = get_theme_mod('tg_retina_logo_for_admin');
				$tg_retina_logo = get_theme_mod('tg_retina_logo');
				
				if(empty($tg_retina_logo_for_admin))
				{
			?>
			<h2><?php esc_html_e('Theme Setting', 'avante' ); ?><span class="theme-version"><?php esc_html_e('Version', 'avante' ); ?> <?php echo AVANTE_THEMEVERSION; ?></span></h2>
			<?php
				}
				else if(!empty($tg_retina_logo))
				{
			?>
			<div class="theme-setting-logo-wrapper">
			<?php
					//Get image width and height
			    	$image_id = avante_get_image_id($tg_retina_logo);
			    	if(!empty($image_id))
			    	{
			    		$obj_image = wp_get_attachment_image_src($image_id, 'original');
			    		
			    		$image_width = 0;
				    	$image_height = 0;
				    	
				    	if(isset($obj_image[1]))
				    	{
				    		$image_width = intval($obj_image[1]/2);
				    	}
				    	if(isset($obj_image[2]))
				    	{
				    		$image_height = intval($obj_image[2]/2);
				    	}
			    	}
			    	else
			    	{
				    	$image_width = 0;
				    	$image_height = 0;
			    	}
						
					if($image_width > 0 && $image_height > 0)
					{
					?>
					<img src="<?php echo esc_url($tg_retina_logo); ?>" alt="<?php esc_attr(get_bloginfo('name')); ?>" width="<?php echo esc_attr($image_width); ?>" height="<?php echo esc_attr($image_height); ?>"/>
					<?php
					}
					else
					{
					?>
	    	    	<img src="<?php echo esc_url($tg_retina_logo); ?>" alt="<?php esc_attr(get_bloginfo('name')); ?>" width="126" height ="32"/>
	    	    <?php 
		    	    }
		    	?>
		    	<span class="theme-version"><?php esc_html_e('Version', 'avante' ); ?> <?php echo AVANTE_THEMEVERSION; ?></span>
			</div>
			<?php
				}
			?>
			</div>
			<div class="pp-wrap-save-setting">
				<input id="setting-save-options" class="button button-primary button-large" type="submit" value="<?php esc_html_e('Save', 'avante' ); ?>" />
				<br/><br/>
				<input type="hidden" name="action" value="save" />
				<input type="hidden" name="current_tab" id="current_tab" value="#setting-panel-general" />
				<?php wp_nonce_field('avante_save_theme_setting'); ?>
			</div>
			<input type="hidden" name="pp_admin_url" id="pp_admin_url" value="<?php echo get_template_directory_uri(); ?>"/>
			<br class="clear"/>
	
		</div>
		
		<div class="theme-setting-wrapper">
		<div id="theme-setting-panel">
		<?php 
			foreach ($avante_options as $value) {
				
				$active = '';
				
				if($value['type'] == 'section')
				{
					if($value['name'] == 'Home')
					{
						$active = 'nav-tab-active';
					}
					echo '<a id="setting-panel-'.strtolower($value['name']).'-a" href="#setting-panel-'.strtolower($value['name']).'" class="nav-tab '.esc_attr($active).'">'.str_replace('-', ' ', $value['name']).'</a>';
				}
			}
		?>
		</h2>
		</div>
	
		<div class="setting-options-content">
		
		<?php 
		foreach ($avante_options as $value) {
			
			//Change underscore to dash
			$option_section_class = '';
			if(isset($value['id']))
			{
				$option_section_id = $value['id'];
				$option_section_class = str_replace('_', '-', $option_section_id);
			}
				
			switch ( $value['type'] ) {
			 
			case "open":
		?> 
			
		<?php break;
			 
			case "close":
		?>
				
				</div>
				</div>
			
			
		<?php break;
			 
			case "title":
		?>
			
			
		<?php break;
			 
			case 'text':
				
				//if sidebar input then not show default value
				if($value['id'] != AVANTE_SHORTNAME."_sidebar0" && $value['id'] != AVANTE_SHORTNAME."_ggfont0")
				{
					$default_val = get_option( $value['id'] );
				}
				else
				{
					$default_val = '';	
				}
			?>
			
				<div id="<?php echo esc_attr($option_section_class); ?>-section" class="setting-options-input rm_text"><label for="<?php echo esc_attr($value['id']); ?>"><?php echo stripslashes($value['name']); ?></label>
				
				<small class="description"><?php echo stripslashes($value['desc']); ?></small>
				
				<input name="<?php echo esc_attr($value['id']); ?>"
					id="<?php echo esc_attr($value['id']); ?>" type="<?php echo esc_attr($value['type']); ?>"
					value="<?php if ($default_val != "") { echo esc_attr(get_option( $value['id'])) ; } else { echo esc_attr($value['std']); } ?>" />
				<div class="clearfix"></div>
			
				</div>
		<?php
			break;
			 
			case 'textarea':
			?>
			
				<div id="<?php echo esc_attr($option_section_class); ?>-section" class="setting-options-input rm_textarea"><label
					for="<?php echo esc_attr($value['id']); ?>"><?php echo stripslashes($value['name']); ?></label>
					
				<small class="description"><?php echo stripslashes($value['desc']); ?></small>
				
				<textarea id="<?php echo esc_attr($value['id']); ?>" name="<?php echo esc_attr($value['id']); ?>"
					type="<?php echo esc_attr($value['type']); ?>" cols="" rows=""><?php if ( get_option( $value['id'] ) != "") { echo stripslashes(get_option( $value['id']) ); } else { echo esc_html($value['std']); } ?></textarea>
				
				<div class="clearfix"></div>
			
				</div>
			
		<?php
			break;
			 
			case "checkbox":
		?>
			
				<div id="<?php echo esc_attr($option_section_class); ?>-section" class="setting-options-input rm_checkbox"><label
					for="<?php echo esc_attr($value['id']); ?>"><?php echo stripslashes($value['name']); ?></label><br/>
			
				<?php if(get_option($value['id'])){ $checked = "checked=\"checked\""; }else{ $checked = "";} ?>
				<input type="checkbox" name="<?php echo esc_attr($value['id']); ?>"
					id="<?php echo esc_attr($value['id']); ?>" value="true" <?php echo esc_html($checked); ?> />
			
			
				<small class="description"><?php echo stripslashes($value['desc']); ?></small>
				<div class="clearfix"></div>
				</div>
		<?php break; 
			
			case "iphone_checkboxes":
		?>
			
				<div id="<?php echo esc_attr($option_section_class); ?>-section" class="setting-options-input rm_checkbox"><label
					for="<?php echo esc_attr($value['id']); ?>"><?php echo stripslashes($value['name']); ?></label>
			
				<small class="description"><?php echo stripslashes($value['desc']); ?></small>
			
				<?php if(get_option($value['id'])){ $checked = "checked=\"checked\""; }else{ $checked = "";} ?>
				<input type="checkbox" class="iphone_checkboxes" name="<?php echo esc_attr($value['id']); ?>"
					id="<?php echo esc_attr($value['id']); ?>" value="true" <?php echo esc_html($checked); ?> />
			
				<div class="clearfix"></div>
				</div>
			
		<?php break; 
			
			case "html":
		?>
			
				<div id="<?php echo esc_attr($option_section_class); ?>-section" class="setting-options-input rm_checkbox"><label
					for="<?php echo esc_attr($value['id']); ?>"><?php echo stripslashes($value['name']); ?></label><br/>
			
				<small class="description"><?php echo stripslashes($value['desc']); ?></small>
			
				<?php echo stripslashes($value['html']); ?>
			
				<div class="clearfix"></div>
				</div>
			
		<?php break; 
				
			case "section":
			
		?>
			
				<div id="setting-panel-<?php echo strtolower($value['name']); ?>" class="setting-section">
				<div class="setting-options-title">
				<span class="submit"><input class="button-primary" name="save<?php echo esc_attr($i); ?>" type="submit"
					value="<?php esc_html_e('Save changes', 'avante' ); ?>" /> </span>
				<div class="clearfix"></div>
				</div>
				<div class="setting-options-wrapper"><?php break;
			 
			}
		}
		?>
	 	
	 	<div class="clearfix"></div>
	 	</form>
	 	</div>
	</div>
<?php
}

add_action('admin_menu', 'avante_add_admin');

/**
*	End Theme Setting Panel
**/ 

//Setup Theme Customizer
require_once get_template_directory() . "/modules/kirki/kirki.php";

//Setup theme custom filters
require_once get_template_directory() . "/lib/theme-filters.php";

//Setup theme learnpress plugin filters
require_once get_template_directory() . "/lib/leanpress.php";

//Setup Custom Font Support
require_once get_template_directory() . "/modules/fonts/section-fonts.php";
require_once get_template_directory() . "/modules/fonts/kirki-add-fonts.php";

require_once get_template_directory() . "/lib/customizer.php";


//Check if Woocommerce is installed	
if(class_exists('Woocommerce'))
{
	//Setup Woocommerce Config
	require_once get_template_directory() . "/modules/woocommerce.php";
}

/**
*	End add product to cart function
**/

add_action('wp_ajax_kirki_dynamic_css', 'kirki_dynamic_css');
add_action('wp_ajax_nopriv_kirki_dynamic_css', 'kirki_dynamic_css');

function kirki_dynamic_css() {
	$kirki = avante_get_kirki();

	die();
}

//Setup custom settings when theme is activated
if (isset($_GET['activated']) && $_GET['activated'] && is_admin() && current_user_can('manage_options')){
	$tg_custom_fonts = get_theme_mod('tg_custom_fonts');
	$is_added_default_font = FALSE;
	
	if(!empty($tg_custom_fonts) && is_array($tg_custom_fonts))
	{
		foreach($tg_custom_fonts as $tg_custom_font)
		{
			if(isset($tg_custom_font['font_name']))
			{
				$tg_custom_font['font_name'] == 'CircularStd';
				$is_added_default_font = TRUE;
				break;
			}
		}
	}
	$is_added_default_font = FALSE;
	if(!$is_added_default_font)
	{
		$default_custom_fonts = array(
			0 => array(
				'font_name' => 	'GlacialIndifference-Regular',
				'font_url' 	=>	get_template_directory_uri().'/fonts/GlacialIndifference-Regular.woff',
				'font_fallback'	=> 'sans-serif',
				'font_weight' => 400,
				'font_style' => 'normal',
			),
			1 => array(
				'font_name' => 	'GlacialIndifference-Bold',
				'font_url' 	=>	get_template_directory_uri().'/fonts/GlacialIndifference-Bold.woff',
				'font_fallback'	=> 'sans-serif',
				'font_weight' => 700,
				'font_style' => 'normal',
			),
		);
		set_theme_mod( 'tg_custom_fonts', $default_custom_fonts );
	}
	
	update_option('elementor_disable_color_schemes', 'yes');
	update_option('elementor_disable_typography_schemes', 'yes');
	update_option('elementor_page_title_selector', '#page-header');
	update_option('elementor_space_between_widgets', 0);
	update_option('elementor_container_width', 1170);
	update_option('elementor_cpt_support', array('post', 'page', 'footer', 'header', 'megamenu'));
	update_option('elementor_global_image_lightbox', 0);
	
	wp_safe_redirect(admin_url("admin.php?page=functions.php&activate=true"));
	exit;
}
?>