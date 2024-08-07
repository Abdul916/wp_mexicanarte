<?php
	$widget_id = $this->get_id();
	$slides = $this->get_settings('slides');
	
	if(!empty($slides))
	{
		//Get all settings
		$settings = $this->get_settings();
		
		$pagination = 0;
		if($settings['pagination'] == 'yes')
		{
			$pagination = 1;
		}
?>
<div class="testimonials-card-wrapper" data-pagination="<?php echo intval($pagination); ?>" data-beginning-slide="<?php echo esc_attr($settings['beginning_slide']); ?>">
	<div class="slider">
		<ul>
<?php
		$counter = 1;
	
		foreach ($slides as $slide) 
		{
?>
			<li>
				<div class="testimonial-info">
					<div class="testimonial-info-title">
		            	<?php
						 	if(!empty($slide['slide_title']))
						 	{
						?>
				         	<h3><?php echo esc_html($slide['slide_title']); ?></h3>
				        <?php
					        }
					        
						 	if(!empty($slide['slide_name']))
						 	{
						?>
				         	<div class="author"><?php echo esc_html($slide['slide_name']); ?></div>
				        <?php
					        }
					    ?>
					</div>
					
					<?php
						if(is_numeric($slide['slide_image']['id']) && !empty($slide['slide_image']['id']))
						{
							if(is_numeric($slide['slide_image']['id']) && (!isset($_GET['elementor_library']) OR empty($_GET['elementor_library'])))
							{
								$image_url = wp_get_attachment_image_src($slide['slide_image']['id'], 'thumbnail', true);
							}
							else
							{
								$image_url[0] = $slide['slide_image']['url'];
							}
							
							//Get image meta data
							$image_alt = get_post_meta($slide['slide_image']['id'], '_wp_attachment_image_alt', true);
						}
						else
						{
							$image_url[0] = $slide['slide_image']['url'];
							$image_alt = '';
						}
						
						if(isset($image_url[0]) && !empty($image_url[0]))
						{
					?>
					<div class="testimonial-info-img">
						<img src="<?php echo esc_url($image_url[0]); ?>" alt="<?php echo esc_attr($image_alt);?>" />
					</div>
					<?php
						}
					?>
	          	</div>
	          	<?php
		          	if(!empty($slide['slide_description']))
					{
				?>
					<div class="testimonial-info-desc">
						<?php echo esc_html($slide['slide_description']); ?>
					</div>
				<?php
					}
				?>
			</li>
<?php
			$counter++;
		}
?>
		</ul>
	</div>
</div>
<?php
	}
?>