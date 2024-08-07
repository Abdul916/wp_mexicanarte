<?php
/**
*	Get Current page object
**/
if(!is_null($post))
{
	$page_obj = get_page($post->ID);
}

$current_page_id = '';

/**
*	Get current page id
**/

if(!is_null($post) && isset($page_obj->ID))
{
    $current_page_id = $page_obj->ID;
}

//Get Page Menu Transparent Option
$page_menu_transparent = get_post_meta($current_page_id, 'page_menu_transparent', true);

//Get Boxed Layout Option
$page_boxed_layout = get_post_meta($current_page_id, 'page_boxed_layout', true);

//Get page header display setting
$page_title = get_the_title();
$page_show_title = get_post_meta($current_page_id, 'page_show_title', true);

if(is_tag())
{
	$page_show_title = 0;
	$page_title = single_cat_title( '', false );
	$page_title = ucfirst($page_title);
	$term = 'tag';
} 
elseif(is_category())
{
    $page_show_title = 0;
	$page_title = single_cat_title( '', false );
	$term = 'category';
}
elseif(is_archive())
{
	$page_show_title = 0;

	if ( is_day() ) : 
		$page_title = get_the_date(); 
    elseif ( is_month() ) : 
    	$page_title = get_the_date('F Y'); 
    elseif ( is_year() ) : 
    	$page_title = get_the_date('Y'); 
    elseif ( !empty($term) ) : 
    	$obj_term = get_term_by('slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
    	$page_taxonomy = get_taxonomy($obj_term->taxonomy);
    	$page_title = $obj_term->name;
    else :
    	$page_title = esc_html__('Blog Archives', 'avante'); 
    endif;
    
    $term = 'archive';
}
else if(is_search())
{
	$page_show_title = 0;
	$page_title = esc_html__('Search', 'avante' );
	$term = 'search';
	
	//Hide page title if doesn't have any results
	if(!have_posts())
	{
		$page_show_title = 1;
	}
}
else if(is_home())
{
	$page_show_title = 0;
	$page_title = esc_html__('Blog', 'avante' );
	$term = 'home';
}

$avante_page_content_class = avante_get_page_content_class();

$avante_hide_title = avante_get_hide_title();
if($avante_hide_title == 1)
{
	$page_show_title = 1;
}

$avante_screen_class = avante_get_screen_class();
if($avante_screen_class == 'split' OR $avante_screen_class == 'single_client')
{
	$page_show_title = 0;
}
if($avante_screen_class == 'single_client')
{
	$page_show_title = 1;
}

if(isset($_GET['elementor_library']) && !empty($_GET['elementor_library']))
{
	$page_show_title = 1;
}

//Check Elementor page hide title option
$elementor_page_settings = get_post_meta($current_page_id, '_elementor_page_settings');
if(isset($elementor_page_settings[0]['hide_title']))
{
	$page_show_title = 1;
}

if(is_single() && $post->post_type == 'lp_course')
{
	$page_show_title = 1;
}

if(empty($page_show_title))
{
	//Get current page tagline
	$page_tagline = get_post_meta($current_page_id, 'page_tagline', true);
	
	if(is_category())
	{
		$page_tagline = category_description();
	}
	
	if(is_tag())
	{
		$page_tagline = category_description();
	}
	
	if(is_archive() && !is_category() && !is_tag() && empty($term))
	{
		$page_tagline = esc_html__('Archive posts in ', 'avante' );
		
		if ( is_day() ) : 
			$page_tagline.= get_the_date(); 
	    elseif ( is_month() ) : 
	    	$page_tagline.= get_the_date('F Y'); 
	    elseif ( is_year() ) : 
	    	$page_tagline.= get_the_date('Y');
	    endif;
	}
	
	//If on gallery post type page
	if(is_single() && $post->post_type == 'galleries')
	{
		$page_tagline = get_the_excerpt();
	}
	
	if(is_search())
	{
		$page_tagline = esc_html__('Search Results for ', 'avante' ).get_search_query();
	}

	if(!empty($term) && !is_tag())
	{
		$ob_term = get_term_by('slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
		
		if(isset($ob_term->description))
		{
			$page_tagline = $ob_term->description;
		}
	}

	$pp_page_bg = '';
	
	//Get page featured image
	if(has_post_thumbnail($current_page_id, 'full') && empty($term))
    {
        $image_id = get_post_thumbnail_id($current_page_id); 
        $image_thumb = wp_get_attachment_image_src($image_id, 'full', true);
        
        if(isset($image_thumb[0]) && !empty($image_thumb[0]))
        {
        	$pp_page_bg = $image_thumb[0];
        }
    }
	
	$avante_topbar = avante_get_topbar();
	$page_header_type = '';
?>
<div id="page-header" class="<?php if(!empty($pp_page_bg) ) { ?>hasbg <?php if(!empty($tg_page_header_bg_parallax)) { ?>parallax<?php } ?> <?php } ?> <?php if(!empty($avante_topbar)) { ?>withtopbar<?php } ?> <?php if(!empty($avante_screen_class)) { echo esc_attr($avante_screen_class); } ?> <?php if(!empty($avante_page_content_class)) { echo esc_attr($avante_page_content_class); } ?>" <?php if(!empty($pp_page_bg)) { ?>style="background-image:url(<?php echo esc_url($pp_page_bg); ?>);"<?php } ?>>

	<?php
		if(empty($page_show_title))
		{
	?>
		<?php 
			if(!empty($pp_page_bg) OR $page_header_type == 'Youtube Video' OR $page_header_type == 'Vimeo Video') 
			{
		?>
			<div id="page-header-overlay"></div>
		<?php
			}
		?>
	<div class="page-title-wrapper">
		<div class="standard-wrapper">
			<div class="page-title-inner">
				<?php
					$tg_page_title_font_alignment = get_theme_mod('tg_page_title_font_alignment', 'left');	
				?>
				<div class="page-title-content title_align_<?php echo esc_attr($tg_page_title_font_alignment); ?>">
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
<div id="page-content-wrapper" class="<?php if(!empty($page_boxed_layout)) { ?>blog-wrapper <?php } ?><?php if(!empty($pp_page_bg)) { ?>hasbg <?php } ?><?php if(!empty($pp_page_bg) && !empty($avante_topbar)) { ?>withtopbar <?php } ?><?php if(!empty($avante_page_content_class)) { echo esc_attr($avante_page_content_class); } ?>">