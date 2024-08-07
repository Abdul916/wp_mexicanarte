<?php
	$widget_id = $this->get_id();
	$slides = $this->get_settings('slides');

	if(!empty($slides))
	{
		//Get all settings
		$settings = $this->get_settings();
		
		$fullscreen = 0;
		if($settings['fullscreen'] == 'yes')
		{
			$fullscreen = 1;
		}
?>
<div class="split-carousel-slider-wrapper carousel" data-fullscreen="<?php echo intval($fullscreen); ?>">
		<div class="carousel-control"></div>
		
		<div class="carousel-stage">
        	<div class="spinner spinner--left">
<?php
		$counter = 0;
	
		foreach ($slides as $slide)
		{	
			//Get slide images
			$count_slide_img = count($slide['slide_image']);
?>
		<div class="spinner-face <?php if($counter == 0) { ?>js-active<?php } ?>" data-bg="<?php echo esc_attr($settings['content_background_color']); ?>">
			<div class="content">
				<div class="content-left" style="background-image: url(<?php echo esc_url($slide['slide_image']['url']); ?>)">
				<?php
					if(!empty($slide['slide_title']))
					{
				?>
					<h1><?php echo esc_html($slide['slide_title']); ?>
					<?php
						if(!empty($slide['slide_sub_title']))
						{
					?>
						<br/><span><?php echo esc_html($slide['slide_sub_title']); ?></span>
				<?php
						}
				?>
					</h1>
				<?php
				 	}
				?>
				</div>
                
                <div class="content-right">
	                <div class="content-main">
						<?php
							if(!empty($slide['slide_description']))
							{
						?>
							<p><?php echo esc_html($slide['slide_description']); ?></p>
						<?php 
							}
							if(!empty($slide['slide_link']['url']))
							{
								$target = $slide['slide_link']['is_external'] ? 'target="_blank"' : '';
						?>
							<p>
								<a class="split-carousel-slide-content-link" href="<?php echo esc_url($slide['slide_link']['url']); ?>" <?php echo esc_attr($target); ?>><?php echo esc_html($slide['slide_link_title']); ?></a>
							</p>
						<?php
							}
						?>
					</div>
                </div>
			</div>
			
		</div>
<?php
			$counter++;
		}
?>
		</div>
	</div>
</div>
<?php
	}
?>