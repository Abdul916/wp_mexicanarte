<?php
	$widget_id = $this->get_id();
	$slides = $this->get_settings('slides');
	
	if(!empty($slides))
	{
		//Get all settings
		$settings = $this->get_settings();
		$timer_arr = $this->get_settings('timer');
		$timer = intval($timer_arr['size']) * 1000;
?>
<div class="portfolio-timeline-vertical-content-wrapper" <?php if($settings['autoplay'] == 'yes') { ?>data-autoplay="<?php echo esc_attr($timer); ?>"<?php } ?> data-speed="<?php echo esc_attr($settings['transition_speed']['size']); ?>">
	<div class="timeline">
		<div class="swiper-container"  style="height:<?php echo intval($settings['height']['size']).$settings['height']['unit']; ?>;">
			<div class="swiper-wrapper">
			<?php		
					foreach ( $slides as $slide ) 
					{
						if(is_numeric($slide['slide_image']['id']) && !empty($slide['slide_image']['id']))
						{
							if(is_numeric($slide['slide_image']['id']) && (!isset($_GET['elementor_library']) OR empty($_GET['elementor_library'])))
							{
								$image_url = wp_get_attachment_image_src($slide['slide_image']['id'], 'full', true);
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
						
						$target = $slide['slide_link']['is_external'] ? 'target="_blank"' : '';
						
						$css_bg_img = '';
						if(isset($image_url[0]) && !empty($image_url[0]))
						{
							$css_bg_img = 'background-image: url('.$image_url[0].');';
						}
			?>
					<div class="swiper-slide" style="<?php echo esc_attr($css_bg_img); ?>" data-year="<?php echo $slide['slide_label']; ?>">
						<div class="swiper-slide-content"><span class="timeline-year"><?php echo esc_html($slide['slide_subtitle']); ?></span>
				            <h4 class="timeline-title"><?php echo esc_html($slide['slide_title']); ?></h4>
				            <div class="timeline-text"><?php echo wp_kses_post($slide['slide_description']); ?></div>
				        </div>
				        <a class="portfolio-timeline-vertical-link" href="<?php echo esc_url($slide['slide_link']['url']); ?>" <?php echo esc_attr($target); ?> ></a>
					</div>
			<?php
					}
			?>
			</div>
			<div class="swiper-button-prev"><span class="ti-angle-up"></span></div>
		    <div class="swiper-button-next"><span class="ti-angle-down"></span></div>
		    <div class="swiper-pagination"></div>
		</div>
	</div>
</div>
<?php
	}
?>