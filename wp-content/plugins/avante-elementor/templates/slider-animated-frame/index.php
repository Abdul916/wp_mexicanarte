<?php
	$widget_id = $this->get_id();
	$slides = $this->get_settings('slides');
	
	if(!empty($slides))
	{
		//Get all settings
		$settings = $this->get_settings();
?>
<div class="animated-frame-slider-wrapper slideshow" data-background="<?php echo esc_attr($settings['frame_color']); ?>">
	<div class="slides">
<?php
		$counter = 1;
		$last_slide = count($slides);
	
		foreach ($slides as $slide) 
		{
?>
			<div class="slide <?php if($counter == 1) { ?>slide-current<?php } ?>">
				<div class="slide-img" style="background-image:url(<?php echo esc_url($slide['slide_image']['url']); ?>);"></div>
				<div class="slide-content">
					<?php
						if(!empty($slide['slide_title']))
						{
					?>
			     		<h2 class="slide-title"><?php echo esc_html($slide['slide_title']); ?></h2>
			     	<?php
				     	}
				     	
				     	if(!empty($slide['slide_description']))
						{
					?>
						<p class="slide-desc"><?php echo esc_html($slide['slide_description']); ?></p>
					<?php 
						}
					?>
					<a class="slide-link" href="<?php echo esc_url($slide['slide_button_link']['url']); ?>"><?php echo esc_html($slide['slide_button_title']); ?></a>
				</div>
		</div>
<?php
			$counter++;
			$last_slide--;
		}
?>
	</div>
	<nav class="slidenav">
		<button class="slidenav-item slidenav-item--prev"><i class="fas fa-long-arrow-alt-left"></i></button>
		<button class="slidenav-item slidenav-item--next"><i class="fas fa-long-arrow-alt-right"></i></button>
	</nav>
</div>
<?php
	}
?>