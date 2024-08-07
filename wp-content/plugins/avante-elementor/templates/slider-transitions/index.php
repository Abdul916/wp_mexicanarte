<?php
	$widget_id = $this->get_id();
	$slides = $this->get_settings('slides');
	
	if(!empty($slides))
	{
		//Get all settings
		$settings = $this->get_settings();
?>
<div class="transitions-slide-container">
	<div class="swiper-container">
		<div class="swiper-wrapper">
<?php
		$count = 1;
		$count_slide = count($slides);
		foreach ($slides as $slide) 
		{

?>
		<div class="swiper-slide">
			<div class="swiper-image" data-swiper-parallax-y="-20%">
	           	<div class="swiper-image-inner swiper-image-left" style="background-image:url(<?php echo esc_url($slide['slide_image_left']['url']); ?>);">
		           	<div class="bg-overlay"></div>
		           	<?php
						if(!empty($slide['slide_title']))
						{
					?>
			          <h1><?php echo esc_html($slide['slide_title']); ?></h1>
					<?php
						}
					?>
	            </div>
	        </div>

		    <div class="swiper-image" data-swiper-parallax-y="35%">
	            <div class="swiper-image-inner swiper-image-right" style="background-image:url(<?php echo esc_url($slide['slide_image_right']['url']); ?>);">
		            <div class="bg-overlay"></div>
		            <?php
						if(!empty($slide['slide_description']))
						{
					?>
					<p class="paragraph">
						<?php echo esc_html($slide['slide_description']); ?>
					
						<?php 
							if(!empty($slide['slide_link']['url']))
							{
								$target = $slide['slide_link']['is_external'] ? 'target="_blank"' : '';
						?>
						<br class="clear"/><a class="transitions-slide-content-link" href="<?php echo esc_url($slide['slide_link']['url']); ?>" <?php echo esc_attr($target); ?>><?php echo esc_html($slide['slide_link_title']); ?></a>
						<?php
							}
						?>	
					</p>
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
		<div class="swiper-pagination"></div>
	</div>
</div>
<?php
	}
?>