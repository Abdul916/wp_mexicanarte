<!-- Begin mobile menu -->
<div class="mobile-menu-wrapper">
	<div class="fullmenu-wrapper">
		<div class="fullmenu_content">
		<a id="btn-close-mobile-menu" href="<?php echo esc_js('javascript:;'); ?>"><span class="ti-close"></span></a>
		<?php
			//get custom logo
		    $tg_retina_logo = get_theme_mod('tg_retina_logo', avante_get_demo_logo('tg_retina_logo'));
	
		    if(!empty($tg_retina_logo))
    	    {	
		    	//Get image width and height
	        	$image_id = avante_get_image_id($tg_retina_logo);
	        	
	        	if(!empty($image_id) && is_numeric($image_id))
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
		    	else if(!is_numeric($image_id))
			    {
				    $image_width = 1;
			    	$image_height = 1;
			    }
		    	else
		    	{
			    	$image_width = 0;
			    	$image_height = 0;
		    	}
		?>
		<div id="logo_normal" class="logo-container">
			<div class="logo-alignment">
	    	    <a id="custom_logo" class="logo-wrapper <?php if(!empty($page_menu_transparent)) { ?>hidden<?php } else { ?>default<?php } ?>" href="<?php echo esc_url(home_url('/')); ?>">
	    	    	<?php
						if($image_width > 1 && $image_height > 1)
						{
					?>
					<img src="<?php echo esc_url($tg_retina_logo); ?>" alt="<?php esc_attr(get_bloginfo('name')); ?>" width="<?php echo esc_attr($image_width); ?>" height="<?php echo esc_attr($image_height); ?>"/>
					<?php
						}
						else if($image_width == 1 && $image_height == 1 && $tg_retina_logo != avante_get_demo_logo('tg_retina_logo'))
						{
					?>
	    	    	<img src="<?php echo esc_url($tg_retina_logo); ?>" alt="<?php esc_attr(get_bloginfo('name')); ?>" class="custom-logo-auto-resize"/>
	    	    	<?php 
		    	    	}
						else
						{
					?>
	    	    	<img src="<?php echo esc_url($tg_retina_logo); ?>" alt="<?php esc_attr(get_bloginfo('name')); ?>" width="91" height="21"/>
	    	    	<?php 
		    	    	}
		    	    ?>
	    	    </a>
			</div>
		</div>
		<?php
		    }
		?>
	
	    <?php
	    	$avante_homepage_style = avante_get_homepage_style();
	    
	    	//Get main menu layout
			$tg_menu_layout = avante_menu_layout(); 
		
	    	//Get page ID
	    	if(is_object($post))
	    	{
	    	    $page = get_page($post->ID);
	    	}
	    	$current_page_id = '';
	    	
	    	if(isset($page->ID))
	    	{
	    	    $current_page_id = $page->ID;
	    	}
	    	elseif(is_home())
	    	{
	    	    $current_page_id = get_option('page_on_front');
	    	}
	    	
	        //If enable menu transparent
	        $page_menu_transparent = get_post_meta($current_page_id, 'page_menu_transparent', true);
	        
	        $pp_page_bg = '';
		    //Get page featured image
		    if(has_post_thumbnail($current_page_id, 'full'))
		    {
		        $image_id = get_post_thumbnail_id($current_page_id); 
		        $image_thumb = wp_get_attachment_image_src($image_id, 'full', true);
		        $pp_page_bg = $image_thumb[0];
		    }
	
	    	//Check if Woocommerce is installed	
	    	if(class_exists('Woocommerce') && avante_is_woocommerce_page())
	    	{
	    	    //Check if woocommerce page
	    		$shop_page_id = get_option( 'woocommerce_shop_page_id' );
	    		$page_menu_transparent = get_post_meta($shop_page_id, 'page_menu_transparent', true);
	    	}
	    	
	    	if($avante_homepage_style == 'fullscreen')
	        {
	            $page_menu_transparent = 1;
	        }
	        
	        if(is_search() OR is_404() OR is_front_page() OR is_archive() OR is_category() OR is_tag())
			{
			    $page_menu_transparent = 0;
			}
	    ?>
		
	    <?php 
	    	//Check if has custom menu
	    	if(is_object($post) && $post->post_type == 'page')
	    	{
	    	    $page_menu = get_post_meta($post->ID, 'page_menu', true);
	    	}	
	    	
	    	if ( has_nav_menu( 'side-menu' ) OR has_nav_menu( 'primary-menu' ) )
	    	{
		    	$side_menu_slug = 'primary-menu';
		    	if(has_nav_menu( 'side-menu' ))
		    	{
			    	$side_menu_slug = 'side-menu';
		    	}
		    	
	    	    //Get page nav
	    	    wp_nav_menu( 
	    	        array( 
	    	            'menu_id'			=> 'mobile_main_menu',
	                    'menu_class'		=> 'mobile-main-nav',
	    	            'theme_location' 	=> $side_menu_slug,
	    	        )
	    	    ); 
	    	}
			
			//Get Soical Icon
			get_template_part("/templates/template-socials");

			//Display copyright text
			$tg_footer_copyright_text = get_theme_mod('tg_footer_copyright_text', '© Copyright');
		
			if(!empty($tg_footer_copyright_text))
			{
			    echo '<div id="copyright">'.wp_kses_post(wp_specialchars_decode($tg_footer_copyright_text)).'</div><br class="clear"/>';
			}
		?>
	    </div>
	</div>
</div>
<?php
	$avante_page_menu_transparent = avante_get_page_menu_transparent();
	avante_set_page_menu_transparent($page_menu_transparent);
?>
<!-- End mobile menu -->