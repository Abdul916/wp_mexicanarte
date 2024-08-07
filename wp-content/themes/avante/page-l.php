<?php
/**
 * Template Name: Page Left Sidebar
 * The main template file for display page.
 *
 * @package WordPress
*/

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

$page_style = 'Right Sidebar';
$page_sidebar = get_post_meta($current_page_id, 'page_sidebar', true);

if(empty($page_sidebar))
{
	$page_sidebar = 'Page Sidebar';
}

$add_sidebar = TRUE;

get_header(); 

$page_sidebar = sanitize_title($page_sidebar);
?>

<?php
    //Include custom header feature
	get_template_part("/templates/template-header");
?>

    <div class="inner">
    
    <!-- Begin main content -->
    <div class="inner-wrapper">
        	
        <div class="sidebar-content left-sidebar <?php if(!is_active_sidebar($page_sidebar)) { ?>fullwidth<?php } ?>">
        	
        	 <?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
			 	<?php the_content(); ?>
			 <?php endwhile;
					wp_link_pages(
		    			array(
							'before'           => '<br class="clear"/><p>' . esc_html__( 'Pages:', 'avante' ),
							'after'            => '</p>',
						)
					);
				?>
			 
			 <?php
			if (comments_open($post->ID)) 
			{
			?>
			<div class="fullwidth-comment-wrapper sidebar theme-border">
				<?php comments_template( '', true ); ?>
			</div>
			<?php
			}
			?>
        	
        </div>
        
        <?php 
			if (is_active_sidebar($page_sidebar)) 
			{ 
		?>	
    		<div class="sidebar-wrapper left-sidebar">
    	
	    		<div class="sidebar_top"></div>
	    	
	    		<div class="sidebar">
	    		
	    			<div class="content">
	
		    	    	<ul class="sidebar-widget">
		    	    		<?php dynamic_sidebar($page_sidebar); ?>
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
    <br class="clear"/>
</div>
<?php get_footer(); ?>
