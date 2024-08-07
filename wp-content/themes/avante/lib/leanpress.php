<?php
function avante_get_course_curriculum_number($course_id = '')
{
	$course_lessons = 0;
	if(function_exists('learn_press_get_course') && !empty($course_id))
	{
		$course = learn_press_get_course($course_id);
		$sections = $course->get_curriculum_raw();
		
		if(is_array($sections) && !empty($sections))
		{
			foreach($sections as $section_item)
			{
				if(isset($section_item['items']) && is_array($section_item['items']) && !empty($section_item['items']))
				{
					foreach($section_item['items'] as $section_item)
					{
						$course_lessons++;
					}
				}
			}
		}
	}
	
	return $course_lessons;
}
	
add_action( 'learn-press/before-single-course', 'avante_single_course_header' );
function avante_single_course_header() {
	$obj_post = avante_get_wp_post();
	if(class_exists('LP_Global'))
	{
		$obj_course = LP_Global::course();
	}
	
	//Get single course template
	$tg_course_template = avante_get_single_course_template($obj_post->ID);
?>
<div id="single-course_wrapper" class="course_template_<?php echo esc_attr($tg_course_template); ?>">
	
<?php 
	//Get course ddata which will be used
	$current_user_id = get_current_user_id();
	$is_enrolled = learn_press_is_enrolled_course($obj_post->ID, $current_user_id);
	
	$has_image_class = '';
	$pp_page_bg = '';
	
	//Get course featured image
	if(has_post_thumbnail($obj_post->ID, 'full'))
    {
        $image_id = get_post_thumbnail_id($obj_post->ID); 
        $image_thumb = wp_get_attachment_image_src($image_id, 'full', true);
        
        if(isset($image_thumb[0]) && !empty($image_thumb[0]))
        {
        	$pp_page_bg = $image_thumb[0];
        }
        
        if(!empty($pp_page_bg))
        {
	        $has_image_class = 'has_image';
	    }
	}
	
	//Get course previe video image
	$video_preview_image = '';
	if(class_exists('MultiPostThumbnails'))
	{
		$video_preview_image = MultiPostThumbnails::get_post_thumbnail_url('lp_course', 'preview-image', $obj_post->ID);
	}
	if(empty($video_preview_image))
	{
		$video_preview_image = $pp_page_bg;
	}
	
	//Get course metadata
	$course_duration = avante_get_course_duration_string($obj_post->ID);
	$course_skill_level = get_post_meta($obj_post->ID, '_lp_skill_level', true);
	$course_lessons = '';
	
	if(function_exists('avante_get_course_curriculum_number'))
	{
		$course_lessons = avante_get_course_curriculum_number($obj_post->ID);
	}
	
	$course_enrolled_number = get_post_meta($obj_post->ID, '_lp_students', true);
	$course_price = get_post_meta( $obj_post->ID, '_lp_price', true );
	$course_sale_price = get_post_meta( $obj_post->ID, '_lp_sale_price', true );
	
	//Get single course included list
	$tg_course_include = get_theme_mod('tg_course_include');
	
	$course_rate = 0;
	$total = 0;
	
	if(function_exists('learn_press_get_course_rate'))
	{
		$course_rate_res = learn_press_get_course_rate( $obj_post->ID, false );
		$course_rate     = $course_rate_res['rated'];
		$total           = $course_rate_res['total'];
	}
	
	switch($tg_course_template)
	{
		case 1:
		default:
?>
<div id="single-course-header">
	<div class="standard-wrapper">
		<div class="single-course-title">
			<h1><?php the_title(); ?></h1>
			
			<?php
				if(function_exists('learn_press_course_review_template') && !empty($course_rate))
				{
					learn_press_course_review_template( 'rating-stars.php', array( 'rated' => $course_rate ) );	
			?>
			<span class="single-course_rating_total">
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
			</span>
			<?php
				}
			?>
			
			<div class="single-course-excerpt">
				<?php the_excerpt(); ?>
			</div>
		</div>
		<?php
			if(!$is_enrolled)
			{
		?>
		<div class="single-course_price_wrapper">
			<?php if ( isset($obj_course) && $price_html = $obj_course->get_price_html() ) { ?>

				<?php if ( $obj_course->get_origin_price() != $obj_course->get_price() ) { ?>
		
					<?php $origin_price_html = $obj_course->get_origin_price_html(); ?>
		
		            <span class="origin-price"><?php echo stripslashes($origin_price_html); ?></span>
		
				<?php } ?>
		
		        <span class="price"><?php echo stripslashes($price_html); ?></span>
		
			<?php } ?>
		</div>
		<div class="single-course-join">
			<a id="single-course-enroll" href="<?php echo esc_js('javascript:;'); ?>" class="button"><?php esc_html_e('Enroll This Course', 'avante' ); ?></a>
		</div>
		<?php
			}
		?>
	</div>
</div>
<br class="clear"/>
<?php
	//Get course featured image
	if(!empty($pp_page_bg))
    {
?>
<div id="single-course-bgimage" style="background-image:url(<?php echo esc_url($pp_page_bg); ?>);"></div>
<?php
    }
?>
<div id="single-course-meta" class="standard-wrapper">
	<ul class="single-course-meta-data">
		<?php
			if(!empty($course_duration))
			{
		?>
		<li>
			<div class="single-course-meta-data-icon">
				<span class="ti-alarm-clock"></span>
			</div>
			<div class="single-course-meta-data-text">
				<span class="single-course-meta-data-title">
					<?php esc_html_e('Duration', 'avante' ); ?>
				</span>
				<span class="single-course-meta-data-content">
					<?php echo esc_html($course_duration); ?>
				</span>
			</div>
		</li>
		<?php
			}
		?>
		
		<li class="single-course-meta-data-separator"></li>
		<?php
			if(!empty($course_skill_level))
			{
		?>
		<li>
			<div class="single-course-meta-data-icon">
				<span class="ti-thumb-up"></span>
			</div>
			<div class="single-course-meta-data-text">
				<span class="single-course-meta-data-title">
					<?php esc_html_e('Skill Level', 'avante' ); ?>
				</span>
				<span class="single-course-meta-data-content">
					<?php echo esc_html($course_skill_level); ?>
				</span>
			</div>
		</li>
		<?php
			}
		?>
		
		<li class="single-course-meta-data-separator"></li>
		
		<?php
		if(!empty($course_lessons))
		{
		?>
		<li>
			<div class="single-course-meta-data-icon">
				<span class="ti-agenda"></span>
			</div>
			<div class="single-course-meta-data-text">
				<span class="single-course-meta-data-title">
					<?php esc_html_e('Lectures', 'avante' ); ?>
				</span>
				<span class="single-course-meta-data-content">
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
		</li>
		<?php
		}
		?>
		<li class="single-course-meta-data-separator"></li>
		
		<?php
			if(!empty($course_enrolled_number))
			{
		?>
		<li>
			<div class="single-course-meta-data-icon">
				<span class="ti-user"></span>
			</div>
			<div class="single-course-meta-data-text">
				<span class="single-course-meta-data-title">
					<?php esc_html_e('Enrolled', 'avante' ); ?>
				</span>
				<span class="single-course-meta-data-content">
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
		</li>
		<?php
			}
		?>
		
		<li class="single-course-meta-data-separator"></li>
	</ul>
</div>
<?php
		break; //end default style 1 template
		
		case 2:
		
			//Get course featured image
			if(!empty($pp_page_bg))
		    {

?>
		<div id="single-course-bgimage" style="background-image:url(<?php echo esc_url($pp_page_bg); ?>);">
			<div class="standard-wrapper single-course">
				<div class="single-course-title">
					<h1><?php the_title(); ?></h1>
					
					<?php
						if(function_exists('learn_press_course_review_template') && !empty($course_rate))
						{
							learn_press_course_review_template( 'rating-stars.php', array( 'rated' => $course_rate ) );	
					?>
					<span class="single-course_rating_total">
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
					</span>
					<?php
						}
					?>
					
					<ul class="single-course-meta-data">
						<?php
							if(!empty($course_duration))
							{
						?>
						<li>
							<div class="single-course-meta-data-icon">
								<span class="ti-alarm-clock"></span>
							</div>
							<div class="single-course-meta-data-text">
								<span class="single-course-meta-data-title">
									<?php esc_html_e('Duration', 'avante' ); ?>
								</span>
								<span class="single-course-meta-data-content">
									<?php echo esc_html($course_duration); ?>
								</span>
							</div>
						</li>
						<?php
							}

							if(!empty($course_skill_level))
							{
						?>
						<li>
							<div class="single-course-meta-data-icon">
								<span class="ti-thumb-up"></span>
							</div>
							<div class="single-course-meta-data-text">
								<span class="single-course-meta-data-title">
									<?php esc_html_e('Skill Level', 'avante' ); ?>
								</span>
								<span class="single-course-meta-data-content">
									<?php echo esc_html($course_skill_level); ?>
								</span>
							</div>
						</li>
						<?php
							}
						?>
						
						<?php
							if(!empty($course_enrolled_number))
							{
						?>
						<li>
							<div class="single-course-meta-data-icon">
								<span class="ti-user"></span>
							</div>
							<div class="single-course-meta-data-text">
								<span class="single-course-meta-data-title">
									<?php esc_html_e('Enrolled', 'avante' ); ?>
								</span>
								<span class="single-course-meta-data-content">
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
						</li>
						<?php
							}
						?>
					</ul>
				</div>
			</div>
		</div>
<?php
	    	}
		break; //end default style 2 template
		
		case 3:
?>

		<div id="single-course-header">
			<div class="standard-wrapper">
				<div class="single-course-title">
					<h1><?php the_title(); ?></h1>
					
					<?php
						if(function_exists('learn_press_course_review_template') && !empty($course_rate))
						{
							learn_press_course_review_template( 'rating-stars.php', array( 'rated' => $course_rate ) );	
					?>
					<span class="single-course_rating_total">
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
					</span>
					<?php
						}
					?>
				</div>
				<br class="clear"/>
				<?php
					$preview_video_embed = get_post_meta($obj_post->ID, '_lp_preview_video_embed', true);
			
					if(!empty($video_preview_image) && !empty($preview_video_embed))
					{	
				?>
				<div class="video-grid-wrapper">
					<a href="<?php echo esc_js('javascript:;'); ?>" class="video-card" data-video-id="<?php echo esc_attr($obj_post->ID); ?>">
						<img src="<?php echo esc_url($video_preview_image); ?>" alt="<?php echo esc_attr(get_the_title());?>" class="video-card-image" />
						<span class="preview-video-title"><?php esc_html_e('Preview this course', 'avante' ); ?></span>
					</a>
					<div class="video-iframe-wrapper"><?php echo stripslashes($preview_video_embed); ?></div>
				</div>
				<?php
					}
				?>
				
				<div class="single-course-include">
					<div class="single-course_price_wrapper">
						<?php if ( isset($obj_course) && $price_html = $obj_course->get_price_html() ) { ?>
			
							<?php if ( $obj_course->get_origin_price() != $obj_course->get_price() ) { ?>
					
								<?php $origin_price_html = $obj_course->get_origin_price_html(); ?>
					
					            <span class="origin-price"><?php echo stripslashes($origin_price_html); ?></span>
					
							<?php } ?>
					
					        <span class="price"><?php echo stripslashes($price_html); ?></span>
					
						<?php } ?>
					</div>
					
					<div class="single-course-join">
						<a id="single-course-enroll" href="<?php echo esc_js('javascript:;'); ?>" class="button"><?php esc_html_e('Enroll This Course', 'avante' ); ?></a>
					</div>
					
					<br class="clear"/>
					
					<h4><?php esc_html_e('This course include', 'avante' ); ?></h4>
					
					<ul class="single-course-include_list">
						<?php
							if(!empty($course_duration))
							{
						?>
						<li>
							<span class="single-course-include_icon">
								<span class="ti-alarm-clock"></span>
							</span>
							<span class="single-course-include_title">
								<?php esc_html_e('Duration', 'avante' ); ?> <?php echo esc_html($course_duration); ?>
							</span>
						</li>
						<?php
							}
						?>
						
						<?php
							if(!empty($course_skill_level))
							{
						?>
						<li>
							<span class="single-course-include_icon">
								<span class="ti-thumb-up"></span>
							</span>
							<span class="single-course-include_title">
								<?php esc_html_e('Skill Level', 'avante' ); ?> <?php echo esc_html($course_skill_level); ?>
							</span>
						</li>
						<?php
							}
						?>
						
						<?php
							if(!empty($course_lessons))
							{
						?>
						<li>
							<span class="single-course-include_icon">
								<span class="ti-agenda"></span>
							</span>
							<span class="single-course-include_title">
								<?php esc_html_e('Lectures', 'avante' ); ?> 
								<?php 
									echo esc_html($course_lessons); 
								?>
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
						</li>
						<?php
							}
						?>
						
						<?php
							if(!empty($course_enrolled_number))
							{
						?>
						<li>
							<span class="single-course-include_icon">
								<span class="ti-user"></span>
							</span>
							<span class="single-course-include_title">
								<?php esc_html_e('Enrolled', 'avante' ); ?> 

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
						</li>
						<?php
							}
						?>
						
						<?php
							foreach($tg_course_include as $tg_course_include_item)
							{
								$icon_thumb = wp_get_attachment_image_src($tg_course_include_item['course_include_icon'], 'full', true);
						?>
						<li>
							<?php
								if(isset($icon_thumb[0]))
								{
							?>
								<span class="single-course-include_icon"><img src="<?php echo esc_url($icon_thumb[0]); ?>" alt="<?php echo esc_attr($tg_course_include_item['course_include_title']); ?>"/></span>
							<?php
								}
							?>
							<span class="single-course-include_title"><?php echo esc_html($tg_course_include_item['course_include_title']); ?></span>
						</li>
						<?php
							}
						?>
					</ul>
				</div>
			</div>
		</div>
		<br class="clear"/>
		
<?php		
		break; //end default style 3 template
		
		case 4:
?>

		<div id="single-course-header" <?php if(!empty($pp_page_bg)) { ?>style="background-image:url(<?php echo esc_url($pp_page_bg); ?>);"<?php } ?>>
			<div class="standard-wrapper">
				<div class="single-course-title">
					<h1><?php the_title(); ?></h1>
					
					<?php
						if(function_exists('learn_press_course_review_template') && !empty($course_rate))
						{
							learn_press_course_review_template( 'rating-stars.php', array( 'rated' => $course_rate ) );	
					?>
					<span class="single-course_rating_total">
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
					</span>
					<?php
						}
					?>
					
					<div class="single-course-excerpt">
						<?php the_excerpt(); ?>
					</div>
					
					<?php
						if(!$is_enrolled)
						{
					?>
					<div class="single-course-join">
						<a id="single-course-enroll" href="<?php echo esc_js('javascript:;'); ?>" class="button"><?php esc_html_e('Enroll This Course', 'avante' ); ?></a>
					</div>
					<?php
						}
					?>
				</div>
			</div>
		</div>
		
		<div id="single-course-meta" class="standard-wrapper">
			<ul class="single-course-meta-data">
				<?php
					if(!empty($course_duration))
					{
				?>
				<li>
					<div class="single-course-meta-data-icon">
						<span class="ti-alarm-clock"></span>
					</div>
					<div class="single-course-meta-data-text">
						<span class="single-course-meta-data-title">
							<?php esc_html_e('Duration', 'avante' ); ?>
						</span>
						<span class="single-course-meta-data-content">
							<?php echo esc_html($course_duration); ?>
						</span>
					</div>
				</li>
				<?php
					}
				?>
				
				<li class="single-course-meta-data-separator"></li>
				<?php
					if(!empty($course_skill_level))
					{
				?>
				<li>
					<div class="single-course-meta-data-icon">
						<span class="ti-thumb-up"></span>
					</div>
					<div class="single-course-meta-data-text">
						<span class="single-course-meta-data-title">
							<?php esc_html_e('Skill Level', 'avante' ); ?>
						</span>
						<span class="single-course-meta-data-content">
							<?php echo esc_html($course_skill_level); ?>
						</span>
					</div>
				</li>
				<?php
					}
				?>
				
				<li class="single-course-meta-data-separator"></li>
				
				<?php
				if(!empty($course_lessons))
				{
				?>
				<li>
					<div class="single-course-meta-data-icon">
						<span class="ti-agenda"></span>
					</div>
					<div class="single-course-meta-data-text">
						<span class="single-course-meta-data-title">
							<?php esc_html_e('Lectures', 'avante' ); ?>
						</span>
						<span class="single-course-meta-data-content">
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
				</li>
				<?php
				}
				?>
				<li class="single-course-meta-data-separator"></li>
				
				<?php
					if(!empty($course_enrolled_number))
					{
				?>
				<li>
					<div class="single-course-meta-data-icon">
						<span class="ti-user"></span>
					</div>
					<div class="single-course-meta-data-text">
						<span class="single-course-meta-data-title">
							<?php esc_html_e('Enrolled', 'avante' ); ?>
						</span>
						<span class="single-course-meta-data-content">
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
				</li>
				<?php
					}
				?>
				
				<li class="single-course-meta-data-separator"></li>
			</ul>
		</div>

<?php
		break; //end default style 4 template
		
	} //end switch case
?>

</div>
<?php
}

add_action( 'learn-press/single-course-summary', 'avante_single_course_footer' );
function avante_single_course_footer() {
	$obj_post = avante_get_wp_post();
	if(class_exists('LP_Global'))
	{
		$obj_course = LP_Global::course();
	}
	
	//Get course ddata which will be used
	$current_user_id = get_current_user_id();
	$is_enrolled = learn_press_is_enrolled_course($obj_post->ID, $current_user_id);
	
	//Get single course template
	$tg_course_template = avante_get_single_course_template($obj_post->ID);
	
	$has_image_class = '';
	$pp_page_bg = '';
	
	//Get course featured image
	if(has_post_thumbnail($obj_post->ID, 'full'))
    {
        $image_id = get_post_thumbnail_id($obj_post->ID); 
        $image_thumb = wp_get_attachment_image_src($image_id, 'full', true);
        
        if(isset($image_thumb[0]) && !empty($image_thumb[0]))
        {
        	$pp_page_bg = $image_thumb[0];
        }
        
        if(!empty($pp_page_bg))
        {
	        $has_image_class = 'has_image';
	    }
	}
	
	//Get course previe video image
	$video_preview_image = '';
	if(class_exists('MultiPostThumbnails'))
	{
		$video_preview_image = MultiPostThumbnails::get_post_thumbnail_url('lp_course', 'preview-image', $obj_post->ID);
	}
	if(empty($video_preview_image))
	{
		$video_preview_image = $pp_page_bg;
	}
	
	//Get related posts setting
	$tg_course_related = get_theme_mod('tg_course_related', true);
	
	switch($tg_course_template)
	{
		case 1:
		case 3:
		case 4:
			
			if(!empty($tg_course_related))
			{
				//Include related course grid template file
				get_template_part("/templates/template-course-grid");
			}
		
		break;
		
		case 2:
		
		if(!$is_enrolled)
		{
?>

<div class="single-course_sidebar <?php echo esc_attr($has_image_class); ?>">
	<?php
		$preview_video_embed = get_post_meta($obj_post->ID, '_lp_preview_video_embed', true);

		if(!empty($video_preview_image) && !empty($preview_video_embed))
		{	
	?>
	<div class="video-grid-wrapper">
		<a href="<?php echo esc_js('javascript:;'); ?>" class="video-card" data-video-id="<?php echo esc_attr($obj_post->ID); ?>">
			<img src="<?php echo esc_url($video_preview_image); ?>" alt="<?php echo esc_attr(get_the_title());?>" class="video-card-image" />
			<span class="preview-video-title"><?php esc_html_e('Preview this course', 'avante' ); ?></span>
		</a>
		<div class="video-iframe-wrapper"><?php echo stripslashes($preview_video_embed); ?></div>
	</div>
	<?php
		}
	?>
	<div class="single-course_info_wrapper">
		<div class="single-course_price_wrapper">
			<?php if ( isset($obj_course) && $price_html = $obj_course->get_price_html() ) { ?>

				<?php if ( $obj_course->get_origin_price() != $obj_course->get_price() ) { ?>
		
					<?php $origin_price_html = $obj_course->get_origin_price_html(); ?>
		
		            <span class="origin-price"><?php echo stripslashes($origin_price_html); ?></span>
		
				<?php } ?>
		
		        <span class="price"><?php echo stripslashes($price_html); ?></span>
		
			<?php } ?>
		</div>
		
		<div class="single-course-join">
			<a id="single-course-enroll" href="<?php echo esc_js('javascript:;'); ?>" class="button"><?php esc_html_e('Enroll This Course', 'avante' ); ?></a>
		</div>
		
		<?php
			//Get single course template
			$tg_course_include = get_theme_mod('tg_course_include');
			
			if(!empty($tg_course_include))
			{
		?>
		<div class="single-course-include">
			<h4><?php esc_html_e('This course include', 'avante' ); ?></h4>
			
			<ul class="single-course-include_list">
				<?php
					foreach($tg_course_include as $tg_course_include_item)
					{
						$icon_thumb = wp_get_attachment_image_src($tg_course_include_item['course_include_icon'], 'full', true);
				?>
				<li>
					<?php
						if(isset($icon_thumb[0]))
						{
					?>
						<span class="single-course-include_icon"><img src="<?php echo esc_url($icon_thumb[0]); ?>" alt="<?php echo esc_attr($tg_course_include_item['course_include_title']); ?>"/></span>
					<?php
						}
					?>
					<span class="single-course-include_title"><?php echo esc_html($tg_course_include_item['course_include_title']); ?></span>
				</li>
				<?php
					}
				?>
			</ul>
		</div>
		<?php
			}
		?>
		
		<div class="sidebar">
    			
    		<div class="content">

    			<?php 
				if (is_active_sidebar('single-course-sidebar')) { ?>
		    		<ul class="sidebar-widget theme-border">
		    		<?php dynamic_sidebar('single-course-sidebar'); ?>
		    		</ul>
		    	<?php } ?>
    		
    		</div>
    	
    	</div>
	</div>
</div>
<br class="clear"/>
<?php
	    if(!empty($tg_course_related))
		{
			//Include related course grid template file
			get_template_part("/templates/template-course-grid");
		}	
			
		} //End if user is not yet enrolled to this course
		
		break;	
	}
}
?>