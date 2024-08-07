<?php
/**
 * The main template file for display page.
 *
 * @package WordPress
*/

/**
*	Get current page id
**/
$current_page_id = get_option( 'woocommerce_shop_page_id' );

get_header();

//Get Shop Sidebar
$page_sidebar = '';

//Get Shop Sidebar Display Settting
$tg_shop_layout = get_theme_mod('tg_shop_layout', 'fullwidth');

if(AVANTE_THEMEDEMO && isset($_GET['sidebar']))
{
	$tg_shop_layout = 'sidebar';
}

if($tg_shop_layout == 'sidebar')
{
	$page_sidebar = 'Shop Sidebar';
}

//Check if woocommerce page
$shop_page_id = get_option( 'woocommerce_shop_page_id' );

//Get Page Menu Transparent Option
$page_menu_transparent = get_post_meta($shop_page_id, 'page_menu_transparent', true);

$page_show_title = get_post_meta($shop_page_id, 'page_show_title', true);

//If single product page then hide page header
if(is_product())
{
	$page_show_title = 0;
	$page_menu_transparent = 0;
}

if(empty($page_show_title))
{
	$query_term = get_query_var('term');
	
	if(is_archive() && !empty($query_term))
	{
		$ob_term = get_term_by('slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
	    $page_taxonomy = get_taxonomy($ob_term->taxonomy);
	    $page_title = $ob_term->name;
	}
	else
	{
		$page_title = get_the_title($shop_page_id);
	}
	
	//Get current page tagline
	$page_tagline = get_post_meta($current_page_id, 'page_tagline', true);

	$pp_page_bg = '';
	
	//Get page featured image
	if(has_post_thumbnail($current_page_id, 'full'))
    {
        $image_id = get_post_thumbnail_id($current_page_id); 
        $image_thumb = wp_get_attachment_image_src($image_id, 'full', true);
        
        if(isset($image_thumb[0]) && !empty($image_thumb[0]))
        {
        	$pp_page_bg = $image_thumb[0];
        	$pp_page_bg = '';
        }
    }
    
    if(is_product())
    {
	    $page_title = get_the_title();
	    $page_tagline = '<a href="'.esc_url(get_permalink($shop_page_id)).'"><span class="ti-arrow-left"></span>&nbsp;'.esc_html__('Back to shop', 'avante' ).'</a>';
    }
    else
    {
	    $cart_page_id = get_option( 'woocommerce_cart_page_id' );
    }
    
    $avante_topbar = avante_get_topbar();
?>
<div id="page-header" class="<?php if(!empty($pp_page_bg)) { ?>hasbg <?php } ?> <?php if(!empty($avante_topbar)) { ?>withtopbar<?php } ?> <?php if(!empty($avante_screen_class)) { echo esc_attr($avante_screen_class); } ?> <?php if(!empty($avante_page_content_class)) { echo esc_attr($avante_page_content_class); } ?>" <?php if(!empty($pp_page_bg)) { ?>style="background-image:url(<?php echo esc_url($pp_page_bg); ?>);"<?php } ?>>
	
	<?php 
		if(!empty($pp_page_bg)) 
		{
	?>
		<div id="page-header-overlay"></div>
	<?php
		}
	?>

	<?php
		if(empty($page_show_title))
		{
	?>
	<div class="page-title-wrapper">
		<div class="standard-wrapper">
			<div class="page-title-inner">
				<div class="page-title-content">
					<h1 <?php if(!empty($pp_page_bg) && !empty($avante_topbar)) { ?>class ="withtopbar"<?php } ?>><?php echo esc_html($page_title); ?></h1>
					<?php
				    	if(!empty($page_tagline))
				    	{
				    ?>
				    	<div class="page-tagline">
				    		<?php echo nl2br($page_tagline); ?>
				    	</div>
				    <?php
				    	}
				    ?>
				</div>
			</div>
		</div>
	</div>
	<?php
		}
	?>
</div>
<?php
	}
?>

<!-- Begin content -->
<div id="page-content-wrapper" <?php if(!empty($pp_page_bg)) { ?>class="hasbg"<?php } ?>>
    <div class="inner ">
    	<!-- Begin main content -->
    	<div class="inner-wrapper">
    		<div class="sidebar-content <?php if(empty($page_sidebar)) { ?>fullwidth<?php } ?>">
				
				<?php woocommerce_content();  ?>
				
    		</div>
    		<?php if(!empty($page_sidebar)) { ?>
    		<div class="sidebar-wrapper">
	            <div class="sidebar">
	            
	            	<div class="content">
	            
	            		<?php 
						$page_sidebar = sanitize_title($page_sidebar);
						
						if (is_active_sidebar($page_sidebar)) { ?>
		    	    		<ul class="sidebar-widget">
		    	    		<?php dynamic_sidebar($page_sidebar); ?>
		    	    		</ul>
		    	    	<?php } ?>
	            	
	            	</div>
	        
	            </div>
            <br class="clear"/>
        
            <div class="sidebar_bottom"></div>
			</div>
    		<?php } ?>
    	</div>
    	<!-- End main content -->
    </div>
</div>
<!-- End content -->
<br class="clear"/><br/>
<?php get_footer(); ?>