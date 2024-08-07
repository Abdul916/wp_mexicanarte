<?php
/**
 * The Header for the template.
 *
 * @package WordPress
 */

if ( ! isset( $content_width ) ) $content_width = 960;

if(session_id() == '') {
	session_start();
}
 
$avante_homepage_style = avante_get_homepage_style();

$tg_menu_layout = avante_menu_layout();
?><!DOCTYPE html>
<html <?php language_attributes(); ?> <?php if(isset($avante_homepage_style) && !empty($avante_homepage_style)) { echo 'data-style="'.esc_attr($avante_homepage_style).'"'; } ?> data-menu="<?php echo esc_attr($tg_menu_layout); ?>">
<head>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-209666390-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-209666390-1');
	gtag('config', 'G-W20PB0EK4P');
</script>

	
<link rel="profile" href="//gmpg.org/xfn/11" />

<link rel="alternate" hreflang="x-default" href="https://mexicanarte.com/">

<?php
	//Fallback compatibility for favicon
	if(!function_exists( 'has_site_icon' ) || ! has_site_icon() ) 
	{
		/**
		*	Get favicon URL
		**/
		$tg_favicon = get_theme_mod('tg_favicon');
		
		if(!empty($tg_favicon))
		{
?>
			<link rel="shortcut icon" href="<?php echo esc_url($tg_favicon); ?>" />
<?php
		}
	}
?> 

<?php
	/* Always have wp_head() just before the closing </head>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to add elements to <head> such
	 * as styles, scripts, and meta tags.
	 */
	wp_head();
?>
</head>

<body <?php body_class(); ?>>
	<?php
		$post = avante_get_wp_post();
		$custom_bg_style = '';
		
		//if password protected
		if(post_password_required())
		{
			$image_thumb = '';				
			if(has_post_thumbnail(get_the_ID(), 'full'))
			{
			    $image_id = get_post_thumbnail_id(get_the_ID());
			    $image_thumb = wp_get_attachment_image_src($image_id, 'full', true);
			}
			
			if(isset($image_thumb[0]) && !empty($image_thumb[0]))
			{
				$custom_bg_style.='background-image:url('.esc_url($image_thumb[0]).');';
			}
		}	
	?>
	<div id="perspective" style="<?php echo esc_attr($custom_bg_style); ?>">
	
	<?php
		switch($tg_menu_layout)
		{
			case 'centeralign':
			case 'hammenuside':
			case 'leftalign':
			case 'leftmenu':
			default:
				get_template_part("/templates/template-sidemenu");
			break;
			
			case 'full-burger-menu':
				get_template_part("/templates/template-fullmenu");
			break;
		}
	?>

	<!-- Begin template wrapper -->
	<?php
		
		$avante_page_menu_transparent = avante_get_page_menu_transparent();

		if(isset($post->ID))
		{
			$current_page_id = $post->ID;
		}
		else
		{
			$current_page_id = '';
		}
		
		//Get Page Menu Transparent Option
		$page_menu_transparent = get_post_meta($current_page_id, 'page_menu_transparent', true);
	
	    $pp_page_bg = '';
	    
	    //Get page featured image
	    if(has_post_thumbnail($current_page_id, 'full'))
	    {
	        $image_id = get_post_thumbnail_id($current_page_id); 
	        $image_thumb = wp_get_attachment_image_src($image_id, 'full', true);
	        $pp_page_bg = $image_thumb[0];
	    }
	    
	   if(!empty($pp_page_bg) && basename($pp_page_bg)=='default.png')
	    {
	    	$pp_page_bg = '';
	    }
		
		//Check if Woocommerce is installed	
		if(class_exists('Woocommerce') && avante_is_woocommerce_page())
		{
			$shop_page_id = get_option('woocommerce_shop_page_id');
			$page_menu_transparent = get_post_meta($shop_page_id, 'page_menu_transparent', true);
		}
		
		if(is_search() OR is_404() OR is_archive() OR is_category() OR is_tag())
		{
		    $page_menu_transparent = 0;
		}
		
		//Check if default WordPress homepage
		if(is_front_page() && is_home())
		{
			$page_menu_transparent = 0;
		}
	?>
	<div id="wrapper" class="<?php if(!empty($avante_page_menu_transparent)) { ?>hasbg<?php } ?> <?php if(!empty($page_menu_transparent)) { ?>transparent<?php } ?>">
	
	<?php
		$tg_header_content = get_theme_mod('tg_header_content', 'menu');
		
		if($tg_header_content == 'content')
		{
			get_template_part("/templates/template-elementor-header");
		}
		else
		{
			//Get main menu layout
			$tg_menu_layout = avante_menu_layout();
			
			switch($tg_menu_layout)
			{
				case 'centeralign':
				case 'hammenuside':
				case 'full-burger-menu':
				default:
					get_template_part("/templates/template-topmenu");
				break;
				
				case 'leftalign':
					get_template_part("/templates/template-topmenu-left");
				break;
				
				case 'center-menu-logo':
					get_template_part("/templates/template-topmenu-center-menus");
				break;
			}
		}
	?>