<?php
	//Check if using normal or transparent header
	if(is_page() OR is_single())
	{
		$page_menu_transparent = get_post_meta($post->ID, 'page_menu_transparent', true);
		
		//If normal header
		if(empty($page_menu_transparent))
		{
			$tg_header_content_default = get_post_meta($post->ID, 'page_header', true);
			
			if(empty($tg_header_content_default))
			{
				$tg_header_content_default = get_theme_mod('tg_header_content_default');
			}
			else
			{
				$tg_header_content_default = $tg_header_content_default;
			}
		}
		//if transparent header
		else
		{
			$tg_transparent_header_content_default = get_post_meta($post->ID, 'page_transparent_header', true);
		
			if(empty($tg_transparent_header_content_default))
			{
				$tg_header_content_default = get_theme_mod('tg_transparent_header_content_default');
			}
			else
			{
				$tg_header_content_default = $tg_transparent_header_content_default;
			}
		}
	}
	else
	{
		$page_menu_transparent = 0;
		
		//If normal header
		if(empty($page_menu_transparent))
		{
			$tg_header_content_default = get_theme_mod('tg_header_content_default');
		}
		//if transparent header
		else
		{
			$tg_header_content_default = get_theme_mod('tg_transparent_header_content_default');
		}
	}
	
	if(!empty($tg_header_content_default))
	{
		//Add Polylang plugin support
		if (function_exists('pll_get_post')) {
			$tg_header_content_default = pll_get_post($tg_header_content_default);
		}
		
		//Add WPML plugin support
		if (function_exists('icl_object_id')) {
			$tg_header_content_default = icl_object_id($tg_header_content_default, 'page', false, ICL_LANGUAGE_CODE);
		}
?>
	<div id="elementor-header" class="main-menu-wrapper">
		<?php 
			if (class_exists("\\Elementor\\Plugin")) {
                echo avante_get_elementor_content($tg_header_content_default);
            }
		?>
	</div>
<?php
	}
	
	//Check if sticky menu
	$tg_fixed_menu = get_theme_mod('tg_fixed_menu', true);
	
	if(!empty($tg_fixed_menu))
	{
		//Check if using normal or transparent header
		if(is_page() OR is_single())
		{
			$tg_header_content_default = get_post_meta($post->ID, 'page_sticky_header', true);
		
			if(empty($tg_header_content_default))
			{
				$tg_header_content_default = get_theme_mod('tg_sticky_header_content_default');
			}
		}
		else
		{
			$tg_header_content_default = get_theme_mod('tg_sticky_header_content_default');
		}
		
		//Add Polylang plugin support
		if (function_exists('pll_get_post')) {
			$tg_header_content_default = pll_get_post($tg_header_content_default);
		}
		
		//Add WPML plugin support
		if (function_exists('icl_object_id')) {
			$tg_header_content_default = icl_object_id($tg_header_content_default, 'page', false, ICL_LANGUAGE_CODE);
		}
?>
	<div id="elementor-sticky-header" class="main-menu-wrapper">
		<?php 
			if (class_exists("\\Elementor\\Plugin")) {
                echo avante_get_elementor_content($tg_header_content_default);
            }
		?>
	</div>
<?php
	}
?>