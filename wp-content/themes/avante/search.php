<?php
/**
 * The main template file for display blog page.
 *
 * @package WordPress
*/

get_header(); 

//Include custom header feature
get_template_part("/templates/template-header");
?>

<?php
$page_sidebar = 'Search Sidebar';
?>

<!-- Begin content -->
    
    <div class="inner">

    	<!-- Begin main content -->
    	<div class="inner-wrapper">

    			<div class="sidebar-content <?php if(!have_posts() OR !is_active_sidebar('search-sidebar')) { ?>fullwidth<?php } ?>">
					
<?php
if (have_posts()) : while (have_posts()) : the_post();
?>

<!-- Begin each blog post -->
<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="post-wrapper">
	    
	    <div class="post-content-wrapper">
			<div class="post-header-wrapper">
				<div class="post-header">
			    	<div class="post-header_title">
				    	<h5><a href="<?php echo esc_url(get_permalink()); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h5>
			    	</div>
			    </div>
			    
			    <?php
			    	$tg_blog_display_full = get_theme_mod('tg_blog_display_full', false);
			    	
			    	if(!empty($tg_blog_display_full))
			    	{
			    		the_content();
			    	}
			    	else
			    	{
			    		the_excerpt();
			    	}
			    ?>
			    <div class="post-button-wrapper">
			    	<a class="readmore" href="<?php echo esc_url(get_permalink()); ?>"><?php echo esc_html_e('Read More', 'avante' ); ?><span class="ti-angle-right"></span></a>
			    </div>
			</div>
	    </div>
	    
	</div>

</div>
<br class="clear"/>
<!-- End each blog post -->

<?php endwhile; endif; ?>

		<?php
			//Hide page title if doesn't have any results
			if(!have_posts())
			{
		?>
			<h1><?php esc_html_e('Nothing Found', 'avante' ); ?></h1>
    	
	    	<div class="search-form-wrapper">
		    	<?php esc_html_e( "Sorry, but nothing matched your search terms. Please try again with some different keywords.", 'avante' ); ?>
		    	<br/><br/>
		    	
	    		<form class="searchform" method="get" action="<?php echo esc_url(home_url('/')); ?>">
		    		<p class="input-wrapper">
			    		<input type="text" class="input-effect field searchform-s" name="s" value="<?php the_search_query(); ?>" placeholder="<?php esc_attr_e('Type to search...', 'avante' ); ?>">
						<input type="submit" value="<?php esc_attr_e('Search', 'avante' ); ?>"/>
		    		</p>
			    </form>
    		</div>
		<?php
			}	
		?>

    	<?php
		    if($wp_query->max_num_pages > 1)
		    {
		    	if (function_exists("avante_pagination")) 
		    	{
		    	    avante_pagination($wp_query->max_num_pages);
		    	}
		    	else
		    	{
		    	?>
		    	    <div class="pagination"><p><?php posts_nav_link(' '); ?></p></div>
		    	<?php
		    	}
		    ?>
		    <div class="pagination-detail">
		     	<?php
		     		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
		     	?>
		     	<?php esc_html_e('Page', 'avante' ); ?> <?php echo esc_html($paged); ?> <?php esc_html_e('of', 'avante' ); ?> <?php echo esc_html($wp_query->max_num_pages); ?>
		     </div>
		     <?php
		     }
		?>
    	</div>
    	
    		<div class="sidebar-wrapper">
    		
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
    	</div>
    	
    </div>
    <!-- End main content -->
    </div>
	
</div>
</div>
<?php get_footer(); ?>