<?php
    $tg_blog_display_related = get_theme_mod('tg_blog_display_related', true);
    
    if($tg_blog_display_related)
    {
?>

<?php
//for use in the loop, list 9 post titles related to post's tags on current post
$tags = wp_get_post_tags($post->ID);

if ($tags) {

    $tag_in = array();
  	//Get all tags
  	foreach($tags as $tags)
  	{
      	$tag_in[] = $tags->term_id;
  	}
  	
  	$post_layout = get_post_meta($post->ID, 'post_layout', true);
  	$showposts = 3;
  	$column_tag = 'one-third';

  	$args=array(
      	  'tag__in' => $tag_in,
      	  'post__not_in' => array($post->ID),
      	  'showposts' => $showposts,
      	  'ignore_sticky_posts' => 1,
      	  'orderby' => 'rand',
      	  'order' => 'DESC'
  	 );
  	$my_query = new WP_Query($args);
  	$i_post = 1;
  	
  	if( $my_query->have_posts() ) {
 ?>
  	<div class="post-related">
	<h3><?php echo esc_html_e('Related Articles', 'avante' ); ?></h3><br class="clear"/>
    <?php
       while ($my_query->have_posts()) : $my_query->the_post();
       
       $last_class = '';
       if($i_post%$showposts==0)
       {
	       $last_class = 'last';
       }
       
       $image_thumb = '';
					
		if(has_post_thumbnail(get_the_ID(), 'avante-gallery-list'))
		{
		    $image_id = get_post_thumbnail_id(get_the_ID());
		    $image_thumb = wp_get_attachment_image_src($image_id, 'avante-gallery-list');
		}
    ?>
       <div class="<?php echo esc_attr($column_tag); ?> <?php echo esc_attr($last_class); ?>">
		   <!-- Begin each blog post -->
			<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			
				<div class="post-wrapper grid-layout <?php if(isset($image_thumb[0]) && !empty($image_thumb[0])) { ?>has-featured-img<?php } ?>">
					<a class="post-related-link" href="<?php echo esc_url(get_permalink()); ?>"></a>
					<?php
					    if(isset($image_thumb[0]) && !empty($image_thumb[0]))
					    {
						    $blog_featured_img_alt = get_post_meta(get_post_thumbnail_id($post->ID), '_wp_attachment_image_alt', true);
					?>
					    <img src="<?php echo esc_url($image_thumb[0]); ?>" class="post-related-featured-img" alt="<?php echo esc_attr($blog_featured_img_alt); ?>"/>
					<?php
					    }
					?>
				    
				    <div class="post-header-wrapper">
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
						<div class="post-header grid related">
							<h6><a href="<?php echo esc_url(get_permalink()); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h6>
						</div>
						
						<?php
							//Get blog date
							$tg_blog_date = get_theme_mod('tg_blog_date', true);
							if(!empty($tg_blog_date))
							{
						?>
						<div class="post-button-wrapper">
							<div class="post-attribute">
								<a href="<?php echo esc_url(get_permalink()); ?>" title="<?php the_title_attribute(); ?>"><?php echo date_i18n(AVANTE_THEMEDATEFORMAT, get_the_time('U')); ?></a>
						    </div>
						</div>
						<?php
							}
						?>
				    </div>
				    
				</div>
			
			</div>
			<!-- End each blog post -->
       </div>
     <?php
     		$i_post++;
	 		endwhile;
	 		
	 		wp_reset_postdata();
     ?>
  	</div>
<?php
  	}
}
    } //end if show related
?>