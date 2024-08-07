<?php
/**
 * The main template file for display single post page.
 *
 * @package WordPress
*/

get_header(); 

$avante_topbar = avante_get_topbar();

/**
*	Get current page id
**/

$current_page_id = $post->ID;

//Include custom header feature
get_template_part("/templates/template-post-header");
?>
    
    <div class="inner">

    	<!-- Begin main content -->
    	<div class="inner-wrapper">

    		<div class="sidebar-content left-sidebar <?php if(!is_active_sidebar('single-post-sidebar')) { ?>fullwidth blog_f<?php } ?>">
					
<?php
if (have_posts()) : while (have_posts()) : the_post();

	$image_thumb = '';
								
	if(!empty($tg_blog_feat_content) && has_post_thumbnail(get_the_ID(), 'large'))
	{
	    $image_id = get_post_thumbnail_id(get_the_ID());
	    $image_thumb = wp_get_attachment_image_src($image_id, 'large', true);
	}
?>
						
<!-- Begin each blog post -->
<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="post-wrapper">
		
		<?php
		    //Get video embed code
		    $post_video_embed = get_post_meta($post->ID, 'post_video_embed', true);
		    if(!empty($post_video_embed))
		    {
		?>
				<div class="video-wrapper"><?php echo trim($post_video_embed); ?></div>
		<?php
		    }
		    
		    the_content();
		?>
		<br class="clear"/>
		<?php
		    wp_link_pages();

			//Get share button
			get_template_part("/templates/template-post-tags");
		?>
	    
	</div>
	
	<?php
		//Get post author
		get_template_part("/templates/template-author");
				
	    //Get post related
		get_template_part("/templates/template-post-related");
	?>

</div>
<!-- End each blog post -->

<?php
if (comments_open($post->ID) OR avante_post_has('pings', $post->ID)) 
{
?>
<div class="fullwidth-comment-wrapper sidebar theme-border"><?php comments_template( '', true ); ?></div>
<?php
}
?>

<?php
//Get post navigation
get_template_part("/templates/template-post-navigation");
?>

<?php endwhile; endif; ?>
						
    	</div>

    		<?php 
				if (is_active_sidebar('single-post-sidebar')) 
				{ 
			?>	
    			<div class="sidebar-wrapper left-sidebar">
    		
	    			<div class="sidebar_top"></div>
	    		
	    			<div class="sidebar">
	    			
	    				<div class="content">
	
			    	    	<ul class="sidebar-widget">
			    	    		<?php dynamic_sidebar('single-post-sidebar'); ?>
			    	    	</ul>
	    				
	    				</div>
	    		
	    			</div>
	    			<br class="clear"/>
	    	
	    			<div class="sidebar_bottom"></div>
    			</div>
    		<?php 
	    		}
	    	?>
    
    </div>
    <!-- End main content -->
   
</div>

<br class="clear"/><br/>
</div>
<?php get_footer(); ?>