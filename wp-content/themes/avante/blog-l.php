<?php
/**
 * The main template file for display blog page.
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

get_header();

$page_sidebar = get_post_meta($current_page_id, 'page_sidebar', true);

//If not select sidebar then select default one
if(empty($page_sidebar))
{
	$page_sidebar = 'blog-sidebar';
}

$is_display_page_content = TRUE;
$is_standard_wp_post = FALSE;

if(is_tag())
{
    $is_display_page_content = FALSE;
    $is_standard_wp_post = TRUE;
    $page_sidebar = 'tag-sidebar';
} 
elseif(is_category())
{
    $is_display_page_content = FALSE;
    $is_standard_wp_post = TRUE;
    $page_sidebar = 'category-sidebar';
}
elseif(is_archive())
{
    $is_display_page_content = FALSE;
    $is_standard_wp_post = TRUE;
    $page_sidebar = 'archives-sidebar';
} 

$avante_page_content_class = avante_get_page_content_class();
avante_set_page_content_class('blog-wrapper');

//Include custom header feature
get_template_part("/templates/template-header");
?>
    
    <div class="inner">

    	<!-- Begin main content -->
    	<div class="inner-wrapper">
    		
    			<?php if ( have_posts() && $is_display_page_content) while ( have_posts() ) : the_post(); ?>		

		    		<div class="page-content-wrapper"><?php the_content(); ?></div>
		
		    	<?php endwhile; ?>

    			<div class="sidebar-content" <?php if(!is_active_sidebar($page_sidebar)) { ?>fullwidth<?php } else { ?>left-sidebar<?php } ?>">
					
<?php

if(is_front_page())
{
    $paged = (get_query_var('page')) ? get_query_var('page') : 1;
}
else
{
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
}

//If theme built-in blog template then add query
if(!$is_standard_wp_post)
{
    $query_string ="post_type=post&paged=$paged&suppress_filters=0";
    query_posts($query_string);
}

$wp_query = avante_get_wp_query();
$post_counter = 0;
$post_counts = $wp_query->post_count;

if (have_posts()) : while (have_posts()) : the_post();

	$image_thumb = '';
								
	if(has_post_thumbnail(get_the_ID(), 'large'))
	{
	    $image_id = get_post_thumbnail_id(get_the_ID());
	    $image_thumb = wp_get_attachment_image_src($image_id, 'large', true);
	}
	
	$post_counter++;
?>

<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="post-wrapper">
		
		<?php
		    if(!empty($image_thumb))
		    {
		     $small_image_url = wp_get_attachment_image_src($image_id, 'avante-blog', true);
		?>
		    <div class="post-featured-image static">
			    <div class="post-featured-image-hover">
			     	<?php the_post_thumbnail('avante-blog'); ?>
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
						$tg_blog_date = get_theme_mod('tg_blog_date', true);
						if(!empty($tg_blog_date))
						{
					?>
			    	<div class="post-attribute">
					    <a href="<?php echo esc_url(get_permalink()); ?>" title="<?php the_title_attribute(); ?>"><?php echo date_i18n(AVANTE_THEMEDATEFORMAT, get_the_time('U')); ?></a>
					</div>
					<?php
					    }
					?>
			    </div>
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
    	
    	<div class="sidebar-wrapper left-sidebar">
    		
	    	<div class="sidebar_top"></div>
	    
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
    	
    </div>
    <!-- End main content -->

</div> 
<br class="clear"/> 
</div>
<?php get_footer(); ?>