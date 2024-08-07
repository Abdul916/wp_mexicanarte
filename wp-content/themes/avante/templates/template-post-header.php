<?php
/**
*	Get Current page object
**/
$page = get_page($post->ID);

/**
*	Get current page id
**/

if(!isset($current_page_id) && isset($page->ID))
{
    $current_page_id = $page->ID;
}

$avante_topbar = avante_get_topbar();
$avante_screen_class = avante_get_screen_class();
$avante_page_content_class = avante_get_page_content_class();

$pp_page_bg = '';

//Check if display blog featured content
$tg_blog_feat_content = get_theme_mod('tg_blog_feat_content', true);

//Check if hide post featured
$hide_featured_image = get_post_meta($post->ID, 'hide_featured_image', true);
if(!empty($hide_featured_image))
{
	$tg_blog_feat_content = 0;
}

//Get page featured image
if(has_post_thumbnail($current_page_id, 'original') && !empty($tg_blog_feat_content))
{
    $image_id = get_post_thumbnail_id($current_page_id); 
    $image_thumb = wp_get_attachment_image_src($image_id, 'original', true);
    
    if(isset($image_thumb[0]) && !empty($image_thumb[0]))
    {
    	$pp_page_bg = $image_thumb[0];
    }
}
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
	<div class="page-title-wrapper">
		<div class="standard-wrapper">
			<div class="page-title-inner">
				<?php
					$tg_page_title_font_alignment = get_theme_mod('tg_page_title_font_alignment', 'left');	
				?>
				<div class="page-title-content title_align_<?php echo esc_attr($tg_page_title_font_alignment); ?>">
					<?php
						//Get blog categories
						$tg_blog_cat = get_theme_mod('tg_blog_cat', true);
						if(!empty($tg_blog_cat))
						{
					?>
					<div class="post-detail single-post">
				    	<span class="post-info-cat smoove" data-move-y="102%">
							<?php
							   //Get Post's Categories
							   $post_categories = wp_get_post_categories($post->ID);
							   
							   $count_categories = count($post_categories);
							   $i = 0;
							   
							   if(!empty($post_categories))
							   {
							      	foreach($post_categories as $key => $c)
							      	{
							      		$cat = get_category( $c );
							?>
							      	<a href="<?php echo esc_url(get_category_link($cat->term_id)); ?>"><?php echo esc_html($cat->name); ?></a>
							<?php
								   		if(++$i != $count_categories) 
								   		{
								   			echo '&nbsp;&middot;&nbsp;';
								   		}
							      	}
							   }
							?>
				    	</span>
				 	</div>
				 	<?php
					 	}
					?>
					<h1 <?php if(!empty($pp_page_bg) && !empty($avante_topbar)) { ?>class="withtopbar"<?php } ?>><span class="smoove" data-move-y="102%"><?php the_title(); ?></span></h1>
					<div class="post-attribute">
						
						<span class="smoove" data-move-y="102%"><?php esc_html_e('By', 'avante' ); ?>&nbsp;<?php echo get_the_author_meta('display_name', $post->post_author); ?></span>&nbsp;
						
						<?php
							//Get blog categories
							$tg_blog_date = get_theme_mod('tg_blog_date', true);
							if(!empty($tg_blog_date))
							{
						?>
							<span class="smoove" data-move-y="102%"><?php esc_html_e('Published On', 'avante' ); ?>&nbsp;<?php echo date_i18n(AVANTE_THEMEDATEFORMAT, get_the_time('U')); ?></span>
						<?php
							}
						?>
				    </div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Begin content -->
<div id="page-content-wrapper" class="blog-wrapper <?php if(!empty($pp_page_bg)) { ?>hasbg <?php } ?><?php if(!empty($pp_page_bg) && !empty($avante_topbar)) { ?>withtopbar <?php } ?><?php if(!empty($avante_page_content_class)) { echo esc_attr($avante_page_content_class); } ?>">
<?php
	//Check if custom post type plugin is installed	
	$avante_custom_post = ABSPATH . '/wp-content/plugins/avante-custom-post/avante-custom-post.php';
	
	$avante_custom_post_activated = file_exists($avante_custom_post);
	
	if($avante_custom_post_activated)
	{
		include_once( ABSPATH . '/wp-content/plugins/avante-custom-post/templates/template-share.php');
	}
?>