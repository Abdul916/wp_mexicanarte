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

$is_display_page_content = TRUE;
$is_standard_wp_post = FALSE;

if(is_tag())
{
    $is_display_page_content = FALSE;
    $is_standard_wp_post = TRUE;
} 
elseif(is_category())
{
    $is_display_page_content = FALSE;
    $is_standard_wp_post = TRUE;
}
elseif(is_archive())
{
    $is_display_page_content = FALSE;
    $is_standard_wp_post = TRUE;
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
    		
    		<div class="sidebar-content fullwidth">
					
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

<!-- Begin each blog post -->
<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="post-wrapper">
		
		<?php	
		    if(!empty($image_thumb))
		    {
		     	$small_image_url = wp_get_attachment_image_src($image_id, 'avante-blog-hd', true);
		?>
		    <div class="post-featured-image static">
			    <?php
					$tg_enable_lazy_loading = get_theme_mod('tg_enable_lazy_loading', true);
				?>
			    <div class="post-featured-image-hover classic blog_f <?php if(!empty($tg_enable_lazy_loading)) { ?>lazy<?php } ?>">
			     	<?php 
				     	$blog_featured_img_url = get_the_post_thumbnail_url($post, 'avante-blog-hd'); 
				     	$blog_featured_img_data = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), "avante-blog-hd" );
				     	$blog_featured_img_alt = get_post_meta(get_post_thumbnail_id($post->ID), '_wp_attachment_image_alt', true);
				     	$return_attr = avante_get_lazy_img_attr();
				     	
				     	if(!empty($blog_featured_img_url))
				     	{
				     ?>
				     <img <?php echo avante_get_blank_img_attr(); ?> <?php echo esc_attr($return_attr['source']); ?>="<?php echo esc_url($blog_featured_img_url); ?>" class="<?php echo esc_attr($return_attr['class']); ?>" alt="<?php echo esc_attr($blog_featured_img_alt); ?>"/>
				     <?php
					     }
					?>
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
		   
		   wp_reset_postdata();
		?>
    		
    	</div>
    	
    </div>
    <!-- End main content -->

</div>
<br class="clear"/> 
</div>
<?php get_footer(); ?>