<?php
/**
 * The main template file.
 *
 * @package WordPress
 */

get_header();

//Include custom header feature
get_template_part("/templates/template-header");

?>
    
    <div class="inner">

    	<!-- Begin main content -->
    	<div class="inner-wrapper">

    		<div class="sidebar-content <?php if(!is_active_sidebar('page-sidebar')) { ?>fullwidth<?php } ?>">
					
<?php
if (have_posts()) : while (have_posts()) : the_post();
	$image_thumb = '';
								
	if(has_post_thumbnail(get_the_ID(), 'large'))
	{
	    $image_id = get_post_thumbnail_id(get_the_ID());
	    $image_thumb = wp_get_attachment_image_src($image_id, 'large', true);
	}
?>

<!-- Begin each blog post -->
<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="post-wrapper">
		
		<?php
		    if(!empty($image_thumb))
		    {
		     $small_image_url = wp_get_attachment_image_src($image_id, 'avante-blog', true);
		?>
		    <div class="post-featured-image static">
			    <div class="post-featured-image-hover">
			     	<?php the_post_thumbnail('avante-blog', array('class' => 'smoove')); ?>
			     	<?php echo avante_get_post_format_icon(get_the_ID()); ?>
			     	<a href="<?php echo esc_url(get_permalink()); ?>"></a>
			    </div>
		    </div>
		<?php
		    }
		?>
	    
	    <div class="post-content-wrapper">
		    
		    <div class="post-header">
			    <?php
					//Get blog categories
					$tg_blog_cat = get_theme_mod('tg_blog_cat', true);
					if(!empty($tg_blog_cat))
					{
				?>
			    <div class="post-detail single-post">
			    	<span class="post-info-cat">
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
				<div class="post-header_title">
				    <h5><a href="<?php echo esc_url(get_permalink()); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h5>
				</div>
			</div>
	    
			<div class="post-header-wrapper">
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
				    <?php
					    $tg_blog_display_author = get_theme_mod('tg_blog_display_author', true);
					    
					    if($tg_blog_display_author)
					    {
					    	$author_name = get_the_author();
					?>
					<div class="post-author">
					    <div class="gravatar"><?php echo get_avatar( get_the_author_meta('email'), 200 ); ?></div>
					    <div class="post-author-detail">
					     	<span class="post-author-name-before"><?php esc_html_e('by', 'avante' ); ?></span>&nbsp;<span class="post-author-name"><?php echo esc_html($author_name); ?></span>
					    </div>
					    <br class="clear"/>
					</div>
					<?php
					    }
					?>
				    <?php
					    if(empty($tg_blog_display_full))
						{
					?>
					<a class="continue-reading" href="<?php echo esc_url(get_permalink()); ?>" title="<?php the_title_attribute(); ?>"><?php esc_html_e('Continue Reading', 'avante' ); ?><span></span></a>
					<?php
						}
					?>
				    
				    <?php
						//Get blog date
						$tg_blog_date = get_theme_mod('tg_blog_date', false);
						if(!empty($tg_blog_date))
						{
					?>
			    	<div class="post-attribute">
					    <a href="<?php echo esc_url(get_permalink()); ?>" title="<?php the_title_attribute(); ?>"><?php echo date_i18n(AVANTE_THEMEDATEFORMAT, get_the_time('U')); ?></a>
					</div>
					<?php
					    }
					?>
			    </div><br class="clear"/>
			</div>
	    </div>
	    
	</div>

</div>
<!-- End each blog post -->

<?php endwhile; endif; ?>

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
    	
    	
			<?php 
				if (is_active_sidebar('page-sidebar')) 
				{ 
			?>	
    			<div class="sidebar-wrapper">
    		
	    			<div class="sidebar_top"></div>
	    		
	    			<div class="sidebar">
	    			
	    				<div class="content">
	
			    	    	<ul class="sidebar-widget">
			    	    		<?php dynamic_sidebar('page-sidebar'); ?>
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
</div>
<?php get_footer(); ?>