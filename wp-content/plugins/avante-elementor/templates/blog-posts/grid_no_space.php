<?php
	$blog_featured_img_url = '';
	if(!empty($image_thumb))
	{
		$blog_featured_img_url = get_the_post_thumbnail_url($post_ID, 'avante-gallery-list');
	}
	
	if(!isset($queue))
	{
		$queue = 1;	
	}
	
	if($queue > 4)
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

<!-- Begin each blog post -->
<div <?php post_class(array('blog-posts-'.$settings['layout'], 'blog-tilt', 'smoove', $animation_class)); ?> <?php if(!empty($blog_featured_img_url)) { ?>style="background-image:url(<?php echo esc_url($blog_featured_img_url); ?>);"<?php } ?> data-delay="<?php echo intval($queue*100); ?>" data-minwidth="<?php echo esc_attr($smoove_min_width); ?>">

	<div class="post-wrapper">
		
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
				
				<div class="post-header-wrapper">
				<?php
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
			</div>
			</div>
	    </div>
	    
	</div>

</div>
<?php $queue++; ?>
<!-- End each blog post -->