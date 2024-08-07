<?php
	$is_learnpress_profile = false;
    
    if(class_exists('LP_Global'))
    {
    	$profile = LP_Global::profile();
    	$is_learnpress_profile = learn_press_is_profile();
    }
    
    //Get global settings for course grid
    $thumb_image_name = 'avante-gallery-grid';
	$column_class = 'tg-four-cols';
	$column_size = 4;
	
	$grid_template = get_theme_mod('tg_course_grid_template', 1);
	$hover_effect = get_theme_mod('tg_course_hover_effect', 1);
	$hover_class = '';
	if(empty($hover_effect))
	{
		$hover_class = 'nohover';
	}
	$show_rating = get_theme_mod('tg_course_rating', 1);
	$show_price = get_theme_mod('tg_course_pricing', 1);
	$show_tooltip = get_theme_mod('tg_course_tooltip', 1);
	$show_lesson = get_theme_mod('tg_course_lesson', 1);
	$show_student = get_theme_mod('tg_course_student', 1);
	$count = 0;
	
	$args = array();
	$course_grid_header = '';
    
	if($is_learnpress_profile && !is_single())
	{
		//Get profile course queries
		$profile = LP_Global::profile();
		$user = $profile->get_user();
		$profile_email = $user->get_email();
		$obj_user = get_user_by('email', $profile_email);
		
		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
		
		$args = array( 
			'post_type' => 'lp_course',
			'suppress_filters' => false,
			'post_status' => 'publish',
			'posts_per_page' => 12,
			'paged' => $paged,
			'author' => $obj_user->ID,
			'orderby' => 'date',
			'order' => 'DESC',
		);	
	}
	else if(is_single() && $post->post_type == 'lp_course')
	{
		//Get related course queries
		$tags = wp_get_post_tags($post->ID);
		$tag_in = array();
	  	//Get all tags
	  	foreach($tags as $tags)
	  	{
	      	$tag_in[] = $tags->term_id;
	  	}
	  	
		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
		
		$tg_course_related_sort = get_theme_mod('tg_course_related_sort', 'default');
		
		switch($tg_course_related_sort)
		{
			case 'default':
				$args['orderby'] = 'menu_order';
				$args['order'] = 'ASC';
			break;
			
			case 'random':
				$args['orderby'] = 'rand';
				$args['order'] = 'ASC';
			break;
			
			case 'published':
				$args['orderby'] = 'date';
				$args['order'] = 'DESC';
			break;
			
			case 'title':
				$args['orderby'] = 'title';
				$args['order'] = 'ASC';
			break;
			
			case 'price_low':
				$args['orderby'] = 'meta_value';
				$args['order'] = 'ASC';
				$args['meta_key'] = '_lp_price';
			break;
			
			case 'price_high':
				$args['orderby'] = 'meta_value';
				$args['order'] = 'DESC';
				$args['meta_key'] = '_lp_price';
			break;
		}
		
		$tg_course_related_item = get_theme_mod('tg_course_related_item', 4);
		
		//Start displaying columns
		switch($tg_course_related_item)
		{
			case 2:
		   		$column_class = 'tg-two-cols';
		   		$column_size = 2;
		   	break;
		   	
		   	case 3:
		   	default:
		   		$column_class = 'tg-three-cols';
		   		$column_size = 3;
		   	break;
		   	
		   	case 4:
		   		$column_class = 'tg-four-cols';
		   		$column_size = 4;
		   	break;
		}
		
		$args = array( 
			'post_type' => 'lp_course',
			'suppress_filters' => false,
			'post_status' => 'publish',
			'posts_per_page' => $column_size,
			'paged' => $paged,
			'tag__in' => $tag_in,
	      	'post__not_in' => array($post->ID),
	      	'showposts' => $column_size,
	      	'ignore_sticky_posts' => 1,
	      	'orderby' => 'rand',
	      	'order' => 'DESC'
		);
		
		$course_grid_header = esc_html__("More courses you might like", 'avante' );
	}
	
	query_posts($args);
	$wp_query = avante_get_wp_query();
	$course_count = $wp_query->found_posts;
?>
<div class="course-grid-container <?php if($course_count < 1) { ?>hidden<?php } ?>">
	<?php
		if(!empty($course_grid_header))	
		{
	?>
		<div class="course-grid-container-header"><h4><?php echo esc_html($course_grid_header); ?></h4></div>
	<?php		
		}
	?>
	
	<div class="portfolio_classic_content-wrapper portfolio_classic layout_<?php echo esc_attr($column_class); ?> grid_template<?php echo esc_attr($grid_template); ?>" data-cols="<?php echo esc_attr($column_size); ?>">
<?php
	if (have_posts()) : while (have_posts()) : the_post();
		$post_ID = get_the_ID();		
		
		$last_class = '';
		$count++;
		
		if($count%$column_size == 0)
		{
			$last_class = 'last';
		}
		
		$course_featured_img_url = get_the_post_thumbnail_url($post_ID, $thumb_image_name);
		$course_featured_img_alt = get_post_meta(get_post_thumbnail_id($post_ID), '_wp_attachment_image_alt', true);
		$course_url = get_permalink($post_ID);
		$course_title= get_the_title();
		
		$course_rate = 0;
		$total = 0;
		
		if(function_exists('learn_press_get_course_rate'))
		{
			$course_rate_res = learn_press_get_course_rate( $post_ID, false );
			$course_rate     = $course_rate_res['rated'];
			$total           = $course_rate_res['total'];
		}
		
		$percent = ( ! $course_rate ) ? 0 : min( 100, ( round( $course_rate * 2 ) / 2 ) * 20 );
		$course_what_learn = get_post_meta($post_ID, '_lp_what_learn', true);
?>
		 <div class="portfolio-classic-grid-wrapper <?php echo esc_attr($column_class); ?> <?php echo esc_attr($last_class); ?>  portfolio-<?php echo esc_attr($count); ?> tile scale-anm course_tooltip <?php echo esc_attr($hover_class); ?>" <?php if(!empty($course_what_learn)) { ?>data-tooltip-content="#tooltip_content_<?php echo esc_attr($post_ID); ?>"<?php } ?>>
		<?php
			//Display grid template
			switch($grid_template)
			{
				case 1:
				default:
		?>
			<div class="card-img" style="background-image:url(<?php echo esc_url($course_featured_img_url); ?>);"></div>
			 
			<?php
				if(!empty($show_price))
				{
					$course_price = avante_get_course_price_html($post_ID);
			?>
			<span class="card-price"><?php echo esc_html($course_price); ?></span>
			<?php
				}
			?>
			 
			<a href="<?php echo esc_url($course_url); ?>" class="card_link">
				<div class="card-img--hover" style="background-image:url(<?php echo esc_url($course_featured_img_url); ?>);"></div>
			</a>

			<div class="card-info">
				<?php 
					if(!empty($course_what_learn) && !empty($show_tooltip))
					{
				?>
				<div class="tooltip-templates">
				    <div id="tooltip_content_<?php echo esc_attr($post_ID); ?>" class="course-tooltip-content">
					    <h5><?php esc_html_e("What you'll learn", 'avante' ); ?></h5>
					    <div class="tooltip-templates_content">
				        	<?php echo wp_specialchars_decode($course_what_learn); ?>
					    </div>
				    </div>
				</div>
				<?php
					}
				?>
			    
				<h3 class="card-title"><a href="<?php echo esc_url($course_url); ?>"><?php echo esc_html($course_title); ?></a></h3>
				<div class="card-rating">
				<?php
					if(!empty($show_rating) && function_exists('learn_press_course_review_template') && !empty($course_rate))
					{
				?>
		    		<div class="review-stars-rated">
					    <div class="review-stars empty"></div>
					    <div class="review-stars filled" style="width:<?php echo intval($percent); ?>%;"></div>
					</div>
		    		
					<div class="card-rating-total">
						<?php echo number_format($course_rate, 1); ?> 
						(<?php echo intval($total); ?> 
						<?php
							if($total > 1)
							{
								echo esc_html_e('ratings', 'avante' );
							}
							else
							{
								echo esc_html_e('rating', 'avante' );	
							}
						?>)
					</div>
		    	<?php
			    	}
			    ?>
			    </div>
				
				<div class="card-meta-wrapper">
					<?php
					if(function_exists('avante_get_course_curriculum_number') && !empty($show_lesson))
					{
						$course_lessons = avante_get_course_curriculum_number($post_ID);
						
						if(!empty($course_lessons))
						{
					?>
					<div class="card-meta">
						<span class="ti-agenda"></span>&nbsp;
						<span class="card__lesson">
							<?php echo esc_html($course_lessons); ?>
							<?php
								if($course_lessons > 1)
								{
									echo esc_html_e('lessons', 'avante' );
								}
								else
								{
									echo esc_html_e('lesson', 'avante' );
								}
							?>
						</span>
					</div>
					<?php
						}
					}
					?>
					
					<?php
					if(!empty($show_student))
					{
						$course_enrolled_number = get_post_meta($post_ID, '_lp_students', true);
						
						if(!empty($course_enrolled_number))
						{
					?>
					<div class="card-meta">
						<span class="ti-user"></span>&nbsp;
						<span class="card__student">
							<?php echo esc_html($course_enrolled_number); ?>
							<?php
								if($course_enrolled_number > 1)
								{
									echo esc_html_e('students', 'avante' );
								}
								else
								{
									echo esc_html_e('student', 'avante' );
								}
							?>
						</span>
					</div>
					<?php
						}
					}
					?>
				</div>
		  	</div>
		<?php
				break; //End template 1
				
				case 2:
		?>
		
			<div class="card-img" style="background-image:url(<?php echo esc_url($course_featured_img_url); ?>);"></div>
			
			<a href="<?php echo esc_url($course_url); ?>" class="card_link">
				<div class="card-img--hover" style="background-image:url(<?php echo esc_url($course_featured_img_url); ?>);"></div>
			</a>
			
			<div class="card-info">
				
				<?php 
					if(!empty($course_what_learn) && !empty($show_tooltip))
					{
				?>
				<div class="tooltip-templates">
				    <div id="tooltip_content_<?php echo esc_attr($post_ID); ?>" class="course-tooltip-content">
					    <h5><?php esc_html_e("What you'll learn", 'avante' ); ?></h5>
					    <div class="tooltip-templates_content">
				        	<?php echo wp_specialchars_decode($course_what_learn); ?>
					    </div>
				    </div>
				</div>
				<?php
					}
				?>
			    
				<h3 class="card-title"><a href="<?php echo esc_url($course_url); ?>"><?php echo esc_html($course_title); ?></a></h3>
				<div class="card-rating">
				<?php
					if(!empty($show_rating) && function_exists('learn_press_course_review_template') && !empty($course_rate))
					{
				?>
		    		<div class="review-stars-rated">
					    <div class="review-stars empty"></div>
					    <div class="review-stars filled" style="width:<?php echo intval($percent); ?>%;"></div>
					</div>
		    		
					<div class="card-rating-total">
						<?php echo number_format($course_rate, 1); ?> 
						(<?php echo intval($total); ?> 
						<?php
							if($total > 1)
							{
								echo esc_html_e('ratings', 'avante' );
							}
							else
							{
								echo esc_html_e('rating', 'avante' );	
							}
						?>)
					</div>
		    	<?php
			    	}
			    ?>
				</div>
				
				<div class="card-meta-wrapper two-cols">
					<div class="card-meta-wrapper-half">
						<?php
							if(!empty($show_price))
							{
								$course_price = avante_get_course_price_html($post_ID);
						?>
						<span class="card-price"><?php echo esc_html($course_price); ?></span>
						<?php
							}
						?>
					</div>
					<div class="card-meta-wrapper-half">
						<?php
						if(function_exists('avante_get_course_curriculum_number') && !empty($show_lesson))
						{
							$course_lessons = avante_get_course_curriculum_number($post_ID);
							
							if(!empty($course_lessons))
							{
						?>
						<div class="card-meta">
							<span class="ti-agenda"></span>&nbsp;
							<span class="card__lesson">
								<?php echo esc_html($course_lessons); ?>
								<?php
									if($course_lessons > 1)
									{
										echo esc_html_e('lessons', 'avante' );
									}
									else
									{
										echo esc_html_e('lesson', 'avante' );
									}
								?>
							</span>
						</div>
						<?php
							}
						}
						?>
						
						<?php
						if(!empty($show_student))
						{
							$course_enrolled_number = get_post_meta($post_ID, '_lp_students', true);
							
							if(!empty($course_enrolled_number))
							{
						?>
						<div class="card-meta">
							<span class="ti-user"></span>&nbsp;
							<span class="card__student">
								<?php echo esc_html($course_enrolled_number); ?>
								<?php
									if($course_enrolled_number > 1)
									{
										echo esc_html_e('students', 'avante' );
									}
									else
									{
										echo esc_html_e('student', 'avante' );
									}
								?>
							</span>
						</div>
						<?php
							}
						}
						?>
					</div>
				</div>
			</div>
		<?php		
				break; //End template 2
				
				case 3:
		?>
		
			<div class="card-img" style="background-image:url(<?php echo esc_url($course_featured_img_url); ?>);"></div>
			
			<?php
				if(!empty($show_price))
				{
					$course_price = avante_get_course_price_html($post_ID);
			?>
			<span class="card-price"><?php echo esc_html($course_price); ?></span>
			<?php
				}
			?>
			
			<a href="<?php echo esc_url($course_url); ?>" class="card_link">
				<div class="card-img--hover" style="background-image:url(<?php echo esc_url($course_featured_img_url); ?>);"></div>
			</a>
			
			<div class="card-info">
				
				<?php 
					if(!empty($course_what_learn) && !empty($show_tooltip))
					{
				?>
				<div class="tooltip-templates">
				    <div id="tooltip_content_<?php echo esc_attr($post_ID); ?>" class="course-tooltip-content">
					    <h5><?php esc_html_e("What you'll learn", 'avante' ); ?></h5>
					    <div class="tooltip-templates_content">
				        	<?php echo wp_specialchars_decode($course_what_learn); ?>
					    </div>
				    </div>
				</div>
				<?php
					}
				?>
			    
			    <div class="card-title-wrapper">
					<h3 class="card-title"><a href="<?php echo esc_url($course_url); ?>"><?php echo esc_html($course_title); ?></a></h3>
					<div class="card-rating">
					<?php
						if(!empty($show_rating) && function_exists('learn_press_course_review_template') && !empty($course_rate))
						{
					?>
			    		<div class="review-stars-rated">
						    <div class="review-stars empty"></div>
						    <div class="review-stars filled" style="width:<?php echo intval($percent); ?>%;"></div>
						</div>
			    		
						<div class="card-rating-total">
							<?php echo number_format($course_rate, 1); ?> 
							(<?php echo intval($total); ?> 
							<?php
								if($total > 1)
								{
									echo esc_html_e('ratings', 'avante' );
								}
								else
								{
									echo esc_html_e('rating', 'avante' );	
								}
							?>)
						</div>
			    	<?php
				    	}
				    ?>
				    </div>
			    </div>
			    
			    <div class="card-meta-wrapper two-cols">
					<div class="card-meta-wrapper-half">
						<?php
						if(function_exists('avante_get_course_curriculum_number') && !empty($show_lesson))
						{
							$course_lessons = avante_get_course_curriculum_number($post_ID);
							
							if(!empty($course_lessons))
							{
						?>
						<div class="card-meta">
							<span class="ti-agenda"></span>&nbsp;
							<span class="card__lesson">
								<?php echo esc_html($course_lessons); ?>
								<?php
									if($course_lessons > 1)
									{
										echo esc_html_e('lessons', 'avante' );
									}
									else
									{
										echo esc_html_e('lesson', 'avante' );
									}
								?>
							</span>
						</div>
						<?php
							}
						}
						?>
						
						<?php
						if(!empty($show_student))
						{
							$course_enrolled_number = get_post_meta($post_ID, '_lp_students', true);
							
							if(!empty($course_enrolled_number))
							{
						?>
						<div class="card-meta">
							<span class="ti-user"></span>&nbsp;
							<span class="card__student">
								<?php echo esc_html($course_enrolled_number); ?>
								<?php
									if($course_enrolled_number > 1)
									{
										echo esc_html_e('students', 'avante' );
									}
									else
									{
										echo esc_html_e('student', 'avante' );
									}
								?>
							</span>
						</div>
						<?php
							}
						}
						?>
					</div>
				</div>
			</div>
		<?php		
				break; //End template 3
				
			} //End switch
		?>
		</div>
<?php
	endwhile; endif;
?>
	</div>
<br class="clear"/>
</div>