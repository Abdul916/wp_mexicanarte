<?php
if ( function_exists( 'add_theme_support' ) ) {
	// Setup thumbnail support
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'custom-background' );
	add_theme_support( 'html5', array( 'search-form' ) );
}

if (class_exists('MultiPostThumbnails')) {
 
new MultiPostThumbnails(array(
		'label' => 'Video Preview Image',
		'id' => 'preview-image',
		'post_type' => 'lp_course'
	) 
);
 
}

if ( function_exists( 'add_image_size' ) ) { 
	//Setup video grid dimensions
	add_image_size( 'avante-video-grid', 700, 393, true );
	
	
	//Setup image grid dimensions
	$pp_gallery_grid_image_width = get_option('pp_gallery_grid_image_width');
	if(empty($pp_gallery_grid_image_width))
	{
		$pp_gallery_grid_image_width = 700;
	}
	$pp_gallery_grid_image_height = get_option('pp_gallery_grid_image_height');
	if(empty($pp_gallery_grid_image_height))
	{
		$pp_gallery_grid_image_height = 466;
	}
	$image_crop = true;
	if($pp_gallery_grid_image_height == 9999)
	{
		$image_crop = false;
	}
	add_image_size( 'avante-gallery-grid', intval($pp_gallery_grid_image_width), intval($pp_gallery_grid_image_height), $image_crop );
	
	
	//Setup image masonry dimensions
	$pp_gallery_masonry_image_width = get_option('pp_gallery_masonry_image_width');
	if(empty($pp_gallery_masonry_image_width))
	{
		$pp_gallery_masonry_image_width = 440;
	}
	$pp_gallery_masonry_image_height = get_option('pp_gallery_masonry_image_height');
	if(empty($pp_gallery_masonry_image_height))
	{
		$pp_gallery_masonry_image_height = 9999;
	}
	$image_crop = true;
	if($pp_gallery_masonry_image_height == 9999)
	{
		$image_crop = false;
	}
	add_image_size( 'avante-gallery-masonry', intval($pp_gallery_masonry_image_width), intval($pp_gallery_masonry_image_height), $image_crop );

	
	//Setup image grid list dimensions
	$pp_gallery_list_image_width = get_option('pp_gallery_list_image_width');
	if(empty($pp_gallery_list_image_width))
	{
		$pp_gallery_list_image_width = 610;
	}
	$pp_gallery_list_image_height = get_option('pp_gallery_list_image_height');
	if(empty($pp_gallery_list_image_height))
	{
		$pp_gallery_list_image_height = 610;
	}
	$image_crop = true;
	if($pp_gallery_list_image_height == 9999)
	{
		$image_crop = false;
	}
	add_image_size( 'avante-gallery-list', intval($pp_gallery_list_image_width), intval($pp_gallery_list_image_height), $image_crop );

	add_image_size( 'avante-album-grid', 660, 740, true );
	
	
	//Setup image blog classic dimensions
	$pp_blog_image_width = get_option('pp_blog_image_width');
	if(empty($pp_blog_image_width))
	{
		$pp_blog_image_width = 960;
	}
	$pp_blog_image_height = get_option('pp_blog_image_height');
	if(empty($pp_blog_image_height))
	{
		$pp_blog_image_height = 550;
	}
	$image_crop = true;
	if($pp_blog_image_height == 9999)
	{
		$image_crop = false;
	}
	add_image_size( 'avante-blog', intval($pp_blog_image_width), intval($pp_blog_image_height), $image_crop );
	
	
	//Setup image blog grid dimensions
	$pp_blog_grid_image_width = get_option('pp_blog_grid_image_width');
	if(empty($pp_blog_grid_image_width))
	{
		$pp_blog_grid_image_width = 480;
	}
	$pp_blog_grid_image_height = get_option('pp_blog_grid_image_height');
	if(empty($pp_blog_grid_image_height))
	{
		$pp_blog_grid_image_height = 302;
	}
	$image_crop = true;
	if($pp_blog_grid_image_height == 9999)
	{
		$image_crop = false;
	}
	add_image_size( 'avante-blog-grid', intval($pp_blog_grid_image_width), intval($pp_blog_grid_image_height), $image_crop );
}

add_action( 'after_setup_theme', 'avante_woocommerce_support' );

function avante_woocommerce_support() {
    add_theme_support( 'woocommerce' );
}

add_theme_support( 'post-formats', array('video') );

/* Flush rewrite rules for custom post types. */
add_action( 'after_switch_theme', 'flush_rewrite_rules' );
?>