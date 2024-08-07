<?php
	$widget_id = $this->get_id();
	$slides = $this->get_settings('slides');
	$count_slides = count($slides);
	
	if(!empty($slides))
	{
		//Get all settings
		$settings = $this->get_settings();
?>
<div class="slider-glitch-slideshow content">
	<div class="slides slides--contained effect-2">
		<?php		
				$count = 1;
				
				foreach ( $slides as $slide ) 
				{	
					//Get image URL
					if(is_numeric($slide['slide_image']['id']) && !empty($slide['slide_image']['id']))
					{
						if(is_numeric($slide['slide_image']['id']) && (!isset($_GET['elementor_library']) OR empty($_GET['elementor_library'])))
						{
							$image_url = wp_get_attachment_image_src($slide['slide_image']['id'], 'original', true);
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
		?>
				<div class="slide <?php if($count == 1) { ?>slide-current<?php } ?>">
					<div class="slide-img glitch" style="background-image: url(<?php echo esc_url($image_url[0]); ?>);height:<?php echo intval($settings['height']['size']).$settings['height']['unit']; ?>;"></div>
					<div class="slide-text">
						<h2 class="slide-title"><?php echo esc_html($slide['slide_title']); ?></h2>
						<div class="slide-description">
							<?php echo esc_html($slide['slide_description']); ?>
							<?php 
								if(!empty($slide['slide_link']['url']))
								{
									$target = $slide['slide_link']['is_external'] ? 'target="_blank"' : '';
							?>
							<br class="clear"/>
							<a class="button" href="<?php echo esc_url($slide['slide_link']['url']); ?>" <?php echo esc_attr($target); ?>>
								<?php echo esc_html($slide['slide_link_title']); ?>
							</a>
							<?php
								}
							?>
						</div>
					</div>
		        </div>
		<?php
					$count++;
				}
		?>
	</div>
	<nav class="slide-nav">
		<button class="slide-nav-button"><span class="ti-angle-up"></span></button>
		<button class="slide-nav-button"><span class="ti-angle-down"></span></button>
	</nav>
</div>
<?php
	}
?>