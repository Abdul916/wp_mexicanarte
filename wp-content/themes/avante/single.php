<?php
/**
 * The main template file for display single post page.
 *
 * @package WordPress
*/

/**
*	Get current page id
**/

$current_page_id = @$post->ID;

if(@$post->post_type == 'galleries')
{
	$gallery_template = get_post_meta(@$post->ID, 'gallery_template', true);
	
	switch($gallery_template)
	{
		case 'Gallery 1 Column':
			get_template_part("single-gallery-1");
			exit;
		break;
		
		case 'Gallery 2 Columns':
			get_template_part("single-gallery-2");
			exit;
		break;
		
		case 'Gallery 3 Columns':
			get_template_part("single-gallery-3");
			exit;
		break;
		
		case 'Gallery 4 Columns':
			get_template_part("single-gallery-4");
			exit;
		break;
		
		case 'Gallery Kenburns':
			get_template_part("single-gallery-kenburns");
			exit;
		break;
		
		case 'Gallery Fullscreen':
		default:
			get_template_part("single-gallery-fullscreen");
			exit;
		break;
		
		case 'Gallery Flow':
			get_template_part("single-gallery-flow");
			exit;
		break;
		
		case 'Gallery Horizontal':
			get_template_part("single-gallery-horizontal");
			exit;
		break;
	}

	exit;
}
else if(@$post->post_type == 'lp_course')
{
	get_template_part("page");
	exit;
}
else if(isset($_GET['elementor_library']) && !empty($_GET['elementor_library']))
{
	get_template_part("page");
	exit;
}
else
{
	$post_layout = get_post_meta(@$post->ID, 'post_layout', true);
	
	switch($post_layout)
	{
		case 'With Right Sidebar':
		default:
			get_template_part("single-post-r");
			exit;
		break;
		
		case 'With Left Sidebar':
			get_template_part("single-post-l");
			exit;
		break;
		
		case 'Fullwidth':
			get_template_part("single-post-f");
			exit;
		break;
	}
}

?>