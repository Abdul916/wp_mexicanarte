<?php
	$widget_id = $this->get_id();
	$slides = $this->get_settings('slides');
	$count_slides = count($slides);
	
	//Get all settings
	$settings = $this->get_settings();
?>
<div class="swiper-container portfolio-coverflow" data-initial="<?php echo esc_attr($settings['initial_slide']['size']); ?>">
<?php
	if(!empty($slides))
	{		
		$thumb_image_name = 'avante-gallery-grid';
?>
<div class="swiper-wrapper">
<?php		
		$last_class = '';
		$count = 0;
		
		foreach ( $slides as $slide ) 
		{
			$slide_id = $slide['_id'];
			
			if(is_numeric($slide['slide_image']['id']) && !empty($slide['slide_image']['id']))
			{
				if(is_numeric($slide['slide_image']['id']) && (!isset($_GET['elementor_library']) OR empty($_GET['elementor_library'])))
				{
					$image_url = wp_get_attachment_image_src($slide['slide_image']['id'], $thumb_image_name, true);
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
?>
		<div class="swiper-slide" data-id="<?php echo esc_attr($count); ?>">
			<div class='swiper-content'>
				<div class="article">
					<div class='article-preview'>
						<div class="controls">
							<?php
								if(isset($slide['slide_link']['url']) && !empty($slide['slide_link']['url']))
								{
							?>
							<label class="lbl-btn-reset" data-audio="audio_<?php echo esc_attr($slide_id); ?>" data-link="<?php echo esc_url($slide['slide_link']['url']); ?>" data-external="<?php echo esc_attr($slide['slide_link']['is_external']); ?>"><span>
								<?php echo esc_html($slide['slide_link-label']); ?>
							</span></label>
							<?php
								}
							?>
						</div>
				  	</div>
				  	<div class='article-thumbnail' style='background-image: url(<?php echo esc_url($image_url[0]); ?>)'>
				    <h2>
				      <span><?php echo esc_html($slide['slide_subtitle']); ?></span>
				      <?php echo esc_html($slide['slide_title']); ?>
				    </h2>
				  </div>
				</div>
			</div>
		</div>
<?php
			$count++;
		}
?>
</div>
<?php
	}
?>
<div class="swiper-pagination"></div>
</div>