<?php
	$widget_id = $this->get_id();
	$slides = $this->get_settings('slides');

	if(!empty($slides))
	{
		//Get all settings
		$settings = $this->get_settings();
		$timer_arr = $this->get_settings('timer');
		$timer = intval($timer_arr['size']) * 1000;
		
		if($settings['autoplay'] != 'yes')
		{
			$timer = 0;
		}
		
		$loop = 0;
		if($settings['loop'] == 'yes')
		{
			$loop = 1;
		}
		
		$navigation = 0;
		if($settings['navigation'] == 'yes')
		{
			$navigation = 1;
		}
		
		$pagination = 0;
		if($settings['pagination'] == 'yes')
		{
			$pagination = 1;
		}
		
		$fullscreen = 0;
		if($settings['fullscreen'] == 'yes')
		{
			$fullscreen = 1;
		}
		
		$content_width = intval($settings['content_width']['size']);
		$gallery_width = intval(100 - $content_width);
?>
<div class="horizontal-slider-wrapper" data-autoplay="<?php echo esc_attr($timer); ?>" data-loop="<?php echo intval($loop); ?>" data-navigation="<?php echo intval($navigation); ?>" data-pagination="<?php echo intval($pagination); ?>" data-fullscreen="<?php echo intval($fullscreen); ?>">
<?php
		$counter = 0;
	
		foreach ($slides as $slide)
		{	
			//Get slide images
			$count_slide_img = count($slide['slide_image']);
?>
		<div class="horizontal-slider-cell" style="height:<?php echo intval($settings['height']['size']).$settings['height']['unit']; ?>;">
			<div class="horizontal-slider-content" style="padding:<?php echo intval($settings['spacing']['size']).$settings['spacing']['unit']; ?>;width:<?php echo intval($content_width); ?>%;">
				<div class="horizontal-slider-content-wrap">
					<div class="horizontal-slider-content-cell">
						<?php
							if(!empty($slide['slide_title']))
							{
						?>
				     		<div class="horizontal-slide-content-title"><h2><?php echo esc_html($slide['slide_title']); ?></h2></div>
				     	<?php
					     	}
					     	
					     	if(!empty($slide['slide_description']))
							{
						?>
							<div class="horizontal-slide-content-desc"><?php echo esc_html($slide['slide_description']); ?></div>
						<?php 
							}
							if(!empty($slide['slide_link']['url']))
							{
								$target = $slide['slide_link']['is_external'] ? 'target="_blank"' : '';
						?>
						<a class="horizontal-slide-content-link" href="<?php echo esc_url($slide['slide_link']['url']); ?>" <?php echo esc_attr($target); ?>><?php echo esc_html($slide['slide_link_title']); ?></a>
						<?php
							}
						?>
					</div>
				</div>
			</div>
			
			<?php
				switch($count_slide_img)
				{
					case 1:
			?>
			<div class="horizontal-slider-bg" style="padding:<?php echo intval($settings['spacing']['size']).$settings['spacing']['unit']; ?>;width:<?php echo intval($gallery_width); ?>%;">
				<div class="horizontal-slider-bg-one-cols" style="background-image:url(<?php echo esc_url($slide['slide_image'][0]['url']); ?>);"></div>
			</div>
			<?php
					break;
					
					case 2:
			?>
			<div class="horizontal-slider-bg" style="padding:<?php echo intval($settings['spacing']['size']).$settings['spacing']['unit']; ?>;width:<?php echo intval($gallery_width); ?>%;">
				<div class="horizontal-slider-bg-two-cols" style="background-image:url(<?php echo esc_url($slide['slide_image'][0]['url']); ?>);"></div>
				
				<div class="horizontal-slider-bg-two-cols last" style="background-image:url(<?php echo esc_url($slide['slide_image'][1]['url']); ?>);"></div>
			</div>
			<?php
					break;
					
					case 3:
			?>
			<div class="horizontal-slider-bg" style="padding:<?php echo intval($settings['spacing']['size']).$settings['spacing']['unit']; ?>;width:<?php echo intval($gallery_width); ?>%;">
				<div class="horizontal-slider-bg-two-cols" style="background-image:url(<?php echo esc_url($slide['slide_image'][0]['url']); ?>);"></div>
				
				<div class="horizontal-slider-bg-two-cols last">
					<div class="horizontal-slider-bg-two-rows" style="background-image:url(<?php echo esc_url($slide['slide_image'][1]['url']); ?>);"></div>
				
					<div class="horizontal-slider-bg-two-rows last" style="background-image:url(<?php echo esc_url($slide['slide_image'][2]['url']); ?>);"></div>
				</div>
			</div>
			<?php
					break;
					
					case 4:
			?>
			<div class="horizontal-slider-bg" style="padding:<?php echo intval($settings['spacing']['size']).$settings['spacing']['unit']; ?>;width:<?php echo intval($gallery_width); ?>%;">
				<div class="horizontal-slider-bg-two-cols">
					<div class="horizontal-slider-bg-two-rows" style="background-image:url(<?php echo esc_url($slide['slide_image'][0]['url']); ?>);"></div>
				
					<div class="horizontal-slider-bg-two-rows last" style="background-image:url(<?php echo esc_url($slide['slide_image'][1]['url']); ?>);"></div>
				</div>
				
				<div class="horizontal-slider-bg-two-cols last">
					<div class="horizontal-slider-bg-two-rows" style="background-image:url(<?php echo esc_url($slide['slide_image'][2]['url']); ?>);"></div>
				
					<div class="horizontal-slider-bg-two-rows last" style="background-image:url(<?php echo esc_url($slide['slide_image'][3]['url']); ?>);"></div>
				</div>
			</div>
			<?php
					break;
				}
			?>
			
		</div>
<?php
			$counter++;
		}
?>
</div>
<?php
	}
?>