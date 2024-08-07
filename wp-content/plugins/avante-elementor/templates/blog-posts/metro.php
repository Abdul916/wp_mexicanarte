<?php
	if(!isset($queue))
	{
		$queue = 1;	
	}
	
	if($queue > 3)
	{
		$queue = 1;
	}
	
	$animation_class = '';
	if(isset($settings['disable_animation']))
	{
		$animation_class = 'disable_'.$settings['disable_animation'];
	}
	
	$smoove_min_width = 1;
	switch($settings['disable_animation'])
	{
		case 'none':
			$smoove_min_width = 1;
		break;
		
		case 'tablet':
			$smoove_min_width = 769;
		break;
		
		case 'mobile':
			$smoove_min_width = 415;
		break;
		
		case 'all':
			$smoove_min_width = 5000;
		break;
	}
?>

<?php
	$blog_featured_image_size = 'avante-blog';
	
	if($counter == 1)
	{
?>
<div class="post-metro-left-wrapper">
<?php
	}
	else
	{
		$blog_featured_image_size = 'avante-blog';
	}
?>
<?php
	if($counter == 2)
	{
		
?>
<div class="post-metro-right-wrapper layout-metro_masonry">
<?php
	}
?>
<!-- Begin each blog post -->
<div <?php post_class('blog-posts-'.$settings['layout']); ?>>

	<div class="post-wrapper smoove <?php echo esc_attr($animation_class); ?>" data-move-y="450px" data-rotate-x="24deg" data-delay="<?php echo intval($queue*100); ?>">
		
		<?php
		    if(!empty($image_thumb))
		    {
		?>
		    <div class="post-featured-image static">
			    <?php
					$tg_enable_lazy_loading = get_theme_mod('tg_enable_lazy_loading');
				?>
			    <div class="post-featured-image-hover <?php if(!empty($tg_enable_lazy_loading)) { ?>lazy<?php } ?>">
			     	<?php 
				     	$blog_featured_img_url = get_the_post_thumbnail_url($post_ID, $blog_featured_image_size); 
				     	$blog_featured_img_data = wp_get_attachment_image_src(get_post_thumbnail_id($post_ID), $blog_featured_image_size );
				     	$blog_featured_img_alt = get_post_meta(get_post_thumbnail_id($post_ID), '_wp_attachment_image_alt', true);
				     	$return_attr = avante_get_lazy_img_attr();
				     	
				     	if(!empty($blog_featured_img_url))
				     	{
				     ?>
				     <img <?php echo avante_get_blank_img_attr(); ?> <?php echo esc_attr($return_attr['source']); ?>="<?php echo esc_url($blog_featured_img_url); ?>" class="lazy_masonry smoove <?php echo esc_attr($animation_class); ?>" alt="<?php echo esc_attr($blog_featured_img_alt); ?>"/>
				     <?php
					     }
					?>
			     	<?php echo avante_get_post_format_icon($post_ID); ?>
			     	<a href="<?php the_permalink(); ?>"></a>
			    </div>
		    </div>
		<?php
		    }
		?>
	    
	    <div class="post-content-wrapper text-<?php echo esc_attr($settings['text_align']); ?>">
		    
		    <div class="post-header">
			    <?php
				  	if($settings['show_categories'] == 'yes') 
				  	{
				?>
			    <div class="post-detail single-post">
				    
			    	<span class="post-info-cat">
						<?php
						   //Get Post's Categories
						   $post_categories = wp_get_post_categories($post_ID);
						   
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
				<div class="post-header-title">
				    <h5><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h5>
				</div>
			</div>
	    
			<div class="post-header-wrapper">
				<?php
					if($counter == 1)
					{
				    	switch($settings['text_display'])
				    	{
					    	case 'full_content':
					    		if($settings['strip_html'] == 'yes')
					    		{
						    		echo strip_tags(get_the_content());
					    		}
					    		else
					    		{
					    			echo get_the_content();
					    		}
					    	break;
					    	
					    	case 'excerpt':
					    		if($settings['strip_html'] == 'yes')
					    		{
						    		echo avante_limit_get_excerpt(strip_tags(get_the_excerpt()), $settings['excerpt_length']['size'], '...');
						    	}
						    	else
						    	{
					    			echo avante_limit_get_excerpt(get_the_excerpt(), $settings['excerpt_length']['size'], '...');
					    		}
					    	break;
				    	}
				    }
			    ?>
			    <div class="post-button-wrapper">
				    <a class="continue-reading" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php esc_html_e('Continue Reading', 'avante-elementor' ); ?><span></span></a>
				    
				    <?php
					  	if($settings['show_date'] == 'yes') 
					  	{
					?>
			    	<div class="post-attribute">
					    <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php echo date_i18n(AVANTE_THEMEDATEFORMAT, get_the_time('U')); ?></a>
					</div>
					<?php
						}
					?>
			    </div>
			    <br class="clear"/>
			</div>
	    </div>
	    
	</div>

</div>
<?php $queue++; ?>
<!-- End each blog post -->
<?php
	if($counter == 1)
	{
?>
</div>
<?php
	}
?>
<?php
	if($wp_query->current_post +1 == $wp_query->post_count)
	{
?>
</div><br class="clear"/>
<?php
	}
?>