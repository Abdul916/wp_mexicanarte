<?php
	$widget_id = $this->get_id();
	$slides = $this->get_settings('slides');
	$count_slides = count($slides);

	if(!empty($slides))
	{
		//Get all settings
		$settings = $this->get_settings();
?>
<div class="room-slider-wrapper">
	<div class="bg-overlay"></div>
	
	<div class="container">
		<div class="scroller">
<?php
		//Create slide image
		$counter = 0;
	
		foreach ($slides as $slide)
		{	
			//Get slide images
			$count_slide_img = count($slide['slide_image']);
?>
		<div class="room <?php if($counter == 0) { ?>room--current<?php }?>">
			<?php
				if($count_slide_img > 0)
				{
					switch($count_slide_img)
					{
						case 1:
						case 2:
			?>
				<div class="room-side room-side--back">
				<?php
					if(isset($slide['slide_image'][0]['url']))		
					{
						$image_id = avante_get_image_id($slide['slide_image'][0]['url']);
						
						if(is_numeric($image_id))
						{
							$image_url = wp_get_attachment_image_src($image_id, 'medium_large', true);
						}
						else
						{
							$image_url[0] = $image_id;
						}
						
						//Get image meta data
						$image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
				?>
					<img class="room-img" src="<?php echo esc_url($image_url[0]); ?>" alt="<?php echo esc_attr($image_alt);?>"/>
				<?php
					}
				?>
				<?php
					if(isset($slide['slide_image'][1]['url']))		
					{
						$image_id = avante_get_image_id($slide['slide_image'][1]['url']);
						
						if(is_numeric($image_id))
						{
							$image_url = wp_get_attachment_image_src($image_id, 'medium_large', true);
						}
						else
						{
							$image_url[0] = $image_id;
						}
						
						//Get image meta data
						$image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
				?>
					<img class="room-img" src="<?php echo esc_url($image_url[0]); ?>" alt="<?php echo esc_attr($image_alt);?>"/>
				<?php
					}
				?>
				</div>
				<div class="room-side room-side--left"></div>
				<div class="room-side room-side--right"></div>
				<div class="room-side room-side--bottom"></div>
			<?php
						break;
						
						case 3:
						case 4:
						case 5:
			?>
				<div class="room-side room-side--back">
				<?php
					if(isset($slide['slide_image'][3]['url']))		
					{
						$image_id = avante_get_image_id($slide['slide_image'][3]['url']);
						
						if(is_numeric($image_id))
						{
							$image_url = wp_get_attachment_image_src($image_id, 'medium_large', true);
						}
						else
						{	
							$image_url[0] = $image_id;
						}
						
						//Get image meta data
						$image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
				?>
					<img class="room-img" src="<?php echo esc_url($image_url[0]); ?>" alt="<?php echo esc_attr($image_alt);?>"/>
				<?php
					}
				?>
				<?php
					if(isset($slide['slide_image'][4]['url']))		
					{
						$image_id = avante_get_image_id($slide['slide_image'][4]['url']);
						
						if(is_numeric($image_id))
						{
							$image_url = wp_get_attachment_image_src($image_id, 'medium_large', true);
						}
						else
						{
							$image_url[0] = $image_id;
						}
						
						//Get image meta data
						$image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
				?>
					<img class="room-img" src="<?php echo esc_url($image_url[0]); ?>" alt="<?php echo esc_attr($image_alt);?>"/>
				<?php
					}
				?>
				</div>
				<div class="room-side room-side--left">
					<?php
						if(isset($slide['slide_image'][0]['url']))		
						{
							$image_id = avante_get_image_id($slide['slide_image'][0]['url']);
							
							if(is_numeric($image_id))
							{
								$image_url = wp_get_attachment_image_src($image_id, 'medium_large', true);
							}
							else
							{
								$image_url[0] = $image_id;
							}
							
							//Get image meta data
							$image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
					?>
						<img class="room-img" src="<?php echo esc_url($image_url[0]); ?>" alt="<?php echo esc_attr($image_alt);?>"/>
					<?php
						}
					?>
					<?php
						if(isset($slide['slide_image'][1]['url']))		
						{
							$image_id = avante_get_image_id($slide['slide_image'][1]['url']);
							
							if(is_numeric($image_id))
							{
								$image_url = wp_get_attachment_image_src($image_id, 'medium_large', true);
							}
							else
							{
								$image_url[0] = $image_id;
							}
							
							//Get image meta data
							$image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
					?>
						<img class="room-img" src="<?php echo esc_url($image_url[0]); ?>" alt="<?php echo esc_attr($image_alt);?>"/>
					<?php
						}
					?>
					<?php
						if(isset($slide['slide_image'][2]['url']))		
						{
							$image_id = avante_get_image_id($slide['slide_image'][2]['url']);
							
							if(is_numeric($image_id))
							{
								$image_url = wp_get_attachment_image_src($image_id, 'medium_large', true);
							}
							else
							{
								$image_url[0] = $image_id;
							}
							
							//Get image meta data
							$image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
					?>
						<img class="room-img" src="<?php echo esc_url($image_url[0]); ?>" alt="<?php echo esc_attr($image_alt);?>"/>
					<?php
						}
					?>
				</div>
				<div class="room-side room-side--right"></div>
				<div class="room-side room-side--bottom"></div>
			<?php
						break;
						
						case 6:
						case 7:
						case 8:
			?>
				<div class="room-side room-side--back">
				<?php
					if(isset($slide['slide_image'][3]['url']))		
					{
						$image_id = avante_get_image_id($slide['slide_image'][3]['url']);
						
						if(is_numeric($image_id))
						{
							$image_url = wp_get_attachment_image_src($image_id, 'medium_large', true);
						}
						else
						{
							$image_url[0] = $image_id;
						}
						
						//Get image meta data
						$image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
				?>
					<img class="room-img" src="<?php echo esc_url($image_url[0]); ?>" alt="<?php echo esc_attr($image_alt);?>"/>
				<?php
					}
				?>
				<?php
					if(isset($slide['slide_image'][4]['url']))		
					{
						$image_id = avante_get_image_id($slide['slide_image'][4]['url']);
						
						if(is_numeric($image_id))
						{
							$image_url = wp_get_attachment_image_src($image_id, 'medium_large', true);
						}
						else
						{
							$image_url[0] = $image_id;
						}
						
						//Get image meta data
						$image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
				?>
					<img class="room-img" src="<?php echo esc_url($image_url[0]); ?>" alt="<?php echo esc_attr($image_alt);?>"/>
				<?php
					}
				?>
				</div>
				<div class="room-side room-side--left">
					<?php
						if(isset($slide['slide_image'][0]['url']))		
						{
							$image_id = avante_get_image_id($slide['slide_image'][0]['url']);
							
							if(is_numeric($image_id))
							{
								$image_url = wp_get_attachment_image_src($image_id, 'medium_large', true);
							}
							else
							{
								$image_url[0] = $image_id;
							}
							
							//Get image meta data
							$image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
					?>
						<img class="room-img" src="<?php echo esc_url($image_url[0]); ?>" alt="<?php echo esc_attr($image_alt);?>"/>
					<?php
						}
					?>
					<?php
						if(isset($slide['slide_image'][1]['url']))		
						{
							$image_id = avante_get_image_id($slide['slide_image'][1]['url']);
							
							if(is_numeric($image_id))
							{
								$image_url = wp_get_attachment_image_src($image_id, 'medium_large', true);
							}
							else
							{
								$image_url[0] = $image_id;
							}
							
							//Get image meta data
							$image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
					?>
						<img class="room-img" src="<?php echo esc_url($image_url[0]); ?>" alt="<?php echo esc_attr($image_alt);?>"/>
					<?php
						}
					?>
					<?php
						if(isset($slide['slide_image'][2]['url']))		
						{
							$image_id = avante_get_image_id($slide['slide_image'][2]['url']);
							
							if(is_numeric($image_id))
							{
								$image_url = wp_get_attachment_image_src($image_id, 'medium_large', true);
							}
							else
							{
								$image_url[0] = $image_id;
							}
							
							//Get image meta data
							$image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
					?>
						<img class="room-img" src="<?php echo esc_url($image_url[0]); ?>" alt="<?php echo esc_attr($image_alt);?>"/>
					<?php
						}
					?>
				</div>
				<div class="room-side room-side--right">
					<?php
						if(isset($slide['slide_image'][5]['url']))		
						{
							$image_id = avante_get_image_id($slide['slide_image'][5]['url']);
							
							if(is_numeric($image_id))
							{
								$image_url = wp_get_attachment_image_src($image_id, 'medium_large', true);
							}
							else
							{
								$image_url[0] = $image_id;
							}
							
							//Get image meta data
							$image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
					?>
						<img class="room-img" src="<?php echo esc_url($image_url[0]); ?>" alt="<?php echo esc_attr($image_alt);?>"/>
					<?php
						}
					?>
					<?php
						if(isset($slide['slide_image'][6]['url']))		
						{
							$image_id = avante_get_image_id($slide['slide_image'][6]['url']);
							
							if(is_numeric($image_id))
							{
								$image_url = wp_get_attachment_image_src($image_id, 'medium_large', true);
							}
							else
							{
								$image_url[0] = $image_id;
							}
							
							//Get image meta data
							$image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
					?>
						<img class="room-img" src="<?php echo esc_url($image_url[0]); ?>" alt="<?php echo esc_attr($image_alt);?>"/>
					<?php
						}
					?>
					<?php
						if(isset($slide['slide_image'][7]['url']))		
						{
							$image_id = avante_get_image_id($slide['slide_image'][7]['url']);
							
							if(is_numeric($image_id))
							{
								$image_url = wp_get_attachment_image_src($image_id, 'medium_large', true);
							}
							else
							{
								$image_url[0] = $image_id;
							}
							
							//Get image meta data
							$image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
					?>
						<img class="room-img" src="<?php echo esc_url($image_url[0]); ?>" alt="<?php echo esc_attr($image_alt);?>"/>
					<?php
						}
					?>
				</div>
				<div class="room-side room-side--bottom"></div>
			<?php
						break;
					}
				}
			?>
		</div>
<?php
			$counter++;
		}
?>

		</div>
	</div>
	
	<div class="content">
		<div class="slides">
<?php
		//Create slide content
		$counter = 0;
		
		foreach ($slides as $slide)
		{	
?>
		<div class="slide">
			<h2 class="slide-name"><?php echo esc_html($slide['slide_title']); ?></h2>
			<div class="slide-title">
				<?php echo esc_html($slide['slide_description']); ?>
			</div>
			<?php 
				$target = $slide['slide_link']['is_external'] ? 'target="_blank"' : '';
			?>
			<p class="slide-date"><a class="button" href="<?php echo esc_url($slide['slide_link']['url']); ?>" <?php echo esc_attr($target); ?>><?php echo esc_html($slide['slide_link_title']); ?></a></p>
		</div>
<?php
			$counter++;
		}
?>
		</div>
		<?php
			if($count_slides > 1)
			{
		?>
			<nav class="nav">
				<button class="btn btn--nav btn--nav-left">
					<i class="fas fa-long-arrow-alt-left"></i>
				</button>
				<button class="btn btn--nav btn--nav-right">
					<i class="fas fa-long-arrow-alt-right"></i>
				</button>
			</nav>
		<?php
			}
		?>
	</div>
	<div class="overlay overlay--loader overlay--active">
		<div class="loader">
			<div></div>
			<div></div>
			<div></div>
		</div>
	</div>
</div>
<?php
	}
?>