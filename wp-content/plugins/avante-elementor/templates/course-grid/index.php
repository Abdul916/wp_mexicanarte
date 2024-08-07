<?php
	//Get all settings
	$settings = $this->get_settings();
?>

<div class="course-grid-container">
<?php
	$widget_id = $this->get_id();
	
	//For pagination
	if(is_front_page())
	{
	    $paged = (get_query_var('page')) ? get_query_var('page') : 1;
	}
	else
	{
	    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
	}

	$args = array( 
		'post_type' => 'lp_course',
		'suppress_filters' => false,
		'post_status' => 'publish',
		'posts_per_page' => $settings['posts_per_page']['size'],
		'paged' => $paged,
		'orderby' => 'menu_order',
		'order' => 'ASC',
		'tax_query' => array( 
			'relation' => 'AND',
	    ) 
	);
	
	if(isset($_GET['s']) && !empty($_GET['s']))
	{  
	 	$args['post_title_like'] = $_GET['s'];
	}
	
	if(!empty($settings['course_category']) && !isset($_GET['s']))
	{
		$term_exists = false;
		if(is_array($settings['course_category']))
		{
			foreach($settings['course_category'] as $course_term)
			{
				$term_array = term_exists($course_term, 'course_category');
				
				if(is_array($term_array))
				{
					$term_exists = true;
					exit;
				}
			}
		}
		
		if($term_exists)
		{
			$args['tax_query'][] = array( 
		        'taxonomy' => 'course_category',
		        'field' => 'id', 
		        'terms' => $settings['course_category']
		    );
		}
	}
	
	if(!empty($settings['course_tag']) && !isset($_GET['s']))
	{
		$args['tax_query'][] = array( 
	        'taxonomy' => 'course_tag',
	        'field' => 'id', 
	        'terms' => $settings['course_tag']
	    );
	}
	
	switch($settings['sort_by'])
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

	query_posts($args);
	$count = 0;
	
	//Get spacing class
	$spacing_class = '';
	if($settings['spacing'] != 'yes')
	{
		$spacing_class = 'has-no-space';
	}
	
	$hover_class= '';
	if(empty($settings['hover_effect']))
	{
		$hover_class = 'nohover';
	}
	
	$column_class = 1;
	$thumb_image_name = 'avante-gallery-grid';
	
	//Start displaying columns
	switch($settings['columns']['size'])
	{
		case 2:
	   		$column_class = 'avante-two-cols';
	   	break;
	   	
	   	case 3:
	   	default:
	   		$column_class = 'avante-three-cols';
	   	break;
	   	
	   	case 4:
	   		$column_class = 'avante-four-cols';
	   	break;
	   	
	   	case 5:
	   		$column_class = 'avante-five-cols';
	   	break;
	   	
	   	case 6:
	   		$column_class = 'tg_six_cols';
	   	break;
	}
?>
<div class="portfolio-classic-content-wrapper portfolio-classic layout-<?php echo esc_attr($column_class); ?> <?php echo esc_attr($spacing_class); ?> grid_template<?php echo esc_attr($settings['grid_template']); ?>" data-cols="<?php echo esc_attr($settings['columns']['size']); ?>">
<?php
	if (have_posts()) : while (have_posts()) : the_post();
		$post_ID = get_the_ID();		
		
		$last_class = '';
		$count++;
		
		if($count%$settings['columns']['size'] == 0)
		{
			$last_class = 'last';
		}
		
		$course_featured_img_url = get_the_post_thumbnail_url($post_ID, $thumb_image_name);
		$course_featured_img_alt = get_post_meta(get_post_thumbnail_id($post_ID), '_wp_attachment_image_alt', true);
		$course_url = get_permalink($post_ID);
		$course_title= get_the_title($post_ID);
		
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
			switch($settings['grid_template'])
			{
				case 1:
				default:
		?>
			<div class="card-img" style="background-image:url(<?php echo esc_url($course_featured_img_url); ?>);"></div>
			 
			<?php
				if($settings['show_price'] == 'yes')
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
					if(!empty($course_what_learn) && $settings['show_tooltip'] == 'yes')
					{
				?>
				<div class="tooltip-templates">
				    <div id="tooltip_content_<?php echo esc_attr($post_ID); ?>" class="course-tooltip-content">
					    <h5><?php esc_html_e("What you'll learn", 'avante-elementor' ); ?></h5>
					    <div class="tooltip-templates_content">
				        	<?php echo htmlspecialchars_decode($course_what_learn); ?>
					    </div>
				    </div>
				</div>
				<?php
					}
				?>
			    
				<h3 class="card-title"><a href="<?php echo esc_url($course_url); ?>"><?php echo esc_html($course_title); ?></a></h3>
				
				<div class="card-rating">
				<?php
					if($settings['show_rating'] == 'yes' && function_exists('learn_press_course_review_template') && !empty($course_rate))
					{
				?>
		    		<div class="review-stars-rated">
					    <div class="review-stars empty"></div>
					    <div class="review-stars filled" style="width:<?php echo $percent; ?>%;"></div>
					</div>
		    		
					<div class="card-rating-total">
						<?php echo number_format($course_rate, 1); ?> 
						(<?php echo intval($total); ?> 
						<?php
							if($total > 1)
							{
								echo esc_html_e('ratings', 'avante-elementor' );
							}
							else
							{
								echo esc_html_e('rating', 'avante-elementor' );	
							}
						?>)
					</div>
		    	<?php
			    	}
			    ?>
			    </div>
				
				<?php
					if(isset($settings['excerpt_length']['size']) && !empty($settings['excerpt_length']['size']))
					{
				?>
				<div class="card-excerpt"><?php echo avante_limit_get_excerpt(strip_tags(get_the_excerpt()), $settings['excerpt_length']['size'], '...'); ?></div>
				<?php
					}
				?>
				
				<?php
					$meta_class = '';
					if(function_exists('avante_get_course_curriculum_number') OR $settings['show_lesson'] != 'yes' OR $settings['show_student'] != 'yes')	
					{
						$meta_class = 'empty';
					}
				?>
				<div class="card-meta-wrapper <?php echo esc_attr($meta_class); ?>">
					<?php
					if(function_exists('avante_get_course_curriculum_number') && $settings['show_lesson'] == 'yes')
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
									echo esc_html_e('lessons', 'avante-elementor' );
								}
								else
								{
									echo esc_html_e('lesson', 'avante-elementor' );
								}
							?>
						</span>
					</div>
					<?php
						}
					}
					?>
					
					<?php
					if($settings['show_student'] == 'yes')
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
									echo esc_html_e('students', 'avante-elementor' );
								}
								else
								{
									echo esc_html_e('student', 'avante-elementor' );
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
					if(!empty($course_what_learn) && $settings['show_tooltip'] == 'yes')
					{
				?>
				<div class="tooltip-templates">
				    <div id="tooltip_content_<?php echo esc_attr($post_ID); ?>" class="course-tooltip-content">
					    <h5><?php esc_html_e("What you'll learn", 'avante-elementor' ); ?></h5>
					    <div class="tooltip-templates_content">
				        	<?php echo htmlspecialchars_decode($course_what_learn); ?>
					    </div>
				    </div>
				</div>
				<?php
					}
				?>
			    
				<h3 class="card-title"><a href="<?php echo esc_url($course_url); ?>"><?php echo esc_html($course_title); ?></a></h3>
				
				<div class="card-rating">
				<?php
					if($settings['show_rating'] == 'yes' && function_exists('learn_press_course_review_template') && !empty($course_rate))
					{
				?>
		    		<div class="review-stars-rated">
					    <div class="review-stars empty"></div>
					    <div class="review-stars filled" style="width:<?php echo $percent; ?>%;"></div>
					</div>
		    		
					<div class="card-rating-total">
						<?php echo number_format($course_rate, 1); ?> 
						(<?php echo intval($total); ?> 
						<?php
							if($total > 1)
							{
								echo esc_html_e('ratings', 'avante-elementor' );
							}
							else
							{
								echo esc_html_e('rating', 'avante-elementor' );	
							}
						?>)
					</div>
		    	<?php
			    	}
			    ?>
			    </div>
				
				<?php
					if(isset($settings['excerpt_length']['size']) && !empty($settings['excerpt_length']['size']))
					{
				?>
				<div class="card-excerpt"><?php echo avante_limit_get_excerpt(strip_tags(get_the_excerpt()), $settings['excerpt_length']['size'], '...'); ?></div>
				<?php
					}
				?>
				
				<div class="card-meta-wrapper two-col">
					<div class="card-meta-wrapper-half">
						<?php
							if($settings['show_price'] == 'yes')
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
						if(function_exists('avante_get_course_curriculum_number') && $settings['show_lesson'] == 'yes')
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
										echo esc_html_e('lessons', 'avante-elementor' );
									}
									else
									{
										echo esc_html_e('lesson', 'avante-elementor' );
									}
								?>
							</span>
						</div>
						<?php
							}
						}
						?>
						
						<?php
						if($settings['show_student'] == 'yes')
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
										echo esc_html_e('students', 'avante-elementor' );
									}
									else
									{
										echo esc_html_e('student', 'avante-elementor' );
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
				if($settings['show_price'] == 'yes')
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
					if(!empty($course_what_learn) && $settings['show_tooltip'] == 'yes')
					{
				?>
				<div class="tooltip-templates">
				    <div id="tooltip_content_<?php echo esc_attr($post_ID); ?>" class="course-tooltip-content">
					    <h5><?php esc_html_e("What you'll learn", 'avante-elementor' ); ?></h5>
					    <div class="tooltip-templates_content">
				        	<?php echo htmlspecialchars_decode($course_what_learn); ?>
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
						if($settings['show_rating'] == 'yes' && function_exists('learn_press_course_review_template') && !empty($course_rate))
						{
					?>
			    		<div class="review-stars-rated">
						    <div class="review-stars empty"></div>
						    <div class="review-stars filled" style="width:<?php echo $percent; ?>%;"></div>
						</div>
			    		
						<div class="card-rating-total">
							<?php echo number_format($course_rate, 1); ?> 
							(<?php echo intval($total); ?> 
							<?php
								if($total > 1)
								{
									echo esc_html_e('ratings', 'avante-elementor' );
								}
								else
								{
									echo esc_html_e('rating', 'avante-elementor' );	
								}
							?>)
						</div>
			    	<?php
				    	}
				    ?>
				    </div>
			    </div>
			    
			    <div class="card-meta-wrapper two-col">
					<div class="card-meta-wrapper-half">
						<?php
						if(function_exists('avante_get_course_curriculum_number') && $settings['show_lesson'] == 'yes')
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
										echo esc_html_e('lessons', 'avante-elementor' );
									}
									else
									{
										echo esc_html_e('lesson', 'avante-elementor' );
									}
								?>
							</span>
						</div>
						<?php
							}
						}
						?>
						
						<?php
						if($settings['show_student'] == 'yes')
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
										echo esc_html_e('students', 'avante-elementor' );
									}
									else
									{
										echo esc_html_e('student', 'avante-elementor' );
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
					if(isset($settings['excerpt_length']['size']) && !empty($settings['excerpt_length']['size']))
					{
				?>
				<div class="card-excerpt"><?php echo avante_limit_get_excerpt(strip_tags(get_the_excerpt()), $settings['excerpt_length']['size'], '...'); ?></div>
				<?php
					}
				?>
			</div>
		<?php		
				break; //End template 3
				
			} //End switch
		?>
		</div>
<?php
	endwhile; endif;
	
	if($settings['spacing'] == 'yes')
	{
?>
<br class="clear"/>
<?php
	}
?>
</div>
</div>
<?php
	if($settings['show_pagination'] == 'yes')
	{
		global $wp_query;
		if($wp_query->max_num_pages > 1)
	    {
	    	if (function_exists("avante_pagination")) 
	    	{
	    	    avante_pagination($wp_query->max_num_pages, 4, 'course-posts-grid' );
	    	}
	    	else
	    	{
?>
	    		<div class="pagination"><p><?php posts_nav_link(''); ?></p></div>
<?php
	    	}
?>
			<div class="pagination-detail">
		    	<?php esc_html_e('Page', 'avante-elementor' ); ?> <?php echo esc_html($paged); ?> <?php esc_html_e('of', 'avante-elementor' ); ?> <?php echo esc_html($wp_query->max_num_pages); ?>
		    </div>
<?php
	    }
	}
	
	wp_reset_query();	
?>
<br class="clear"/>