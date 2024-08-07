<?php
	$widget_id = $this->get_id();
	$slides = $this->get_settings('slides');
	
	if(!empty($slides))
	{
		//Get all settings
		$settings = $this->get_settings();
?>
<div class="animated-slider-wrapper slideshow">
<?php
		$counter = 1;
		$last_slide = count($slides);
	
		foreach ($slides as $slide) 
		{
?>
		<div class="slideshow-slide js-slider-home-slide" data-slide="<?php echo esc_attr($counter); ?>">
			<div class="slideshow-slide-background-parallax background-absolute js-parallax">
				<div class="slideshow-slide-background-load-wrap background-absolute">
					<div class="slideshow-slide-background-load background-absolute">
						<div class="slideshow-slide-background-wrap background-absolute">
							<div class="slideshow-slide-background background-absolute">
								<div class="slideshow-slide-image-wrap background-absolute">
									<div class="slideshow-slide-image background-absolute" style="background-image:url(<?php echo esc_url($slide['slide_image']['url']); ?>);"></div>
								</div>
							</div>
						</div>			
					</div>
				</div>
			</div>
			
			<div class="slideshow-slide-caption">
		        <div class="slideshow-slide-caption-text">
		          <div class="container js-parallax">
			       <?php
						if(!empty($slide['slide_title']))
						{
					?>
		            	<h2 class="slideshow-slide-caption-title"><?php echo esc_html($slide['slide_title']); ?></h2>
		            <?php
			            }
			            
			            if(!empty($slide['slide_description']))
						{
			        ?>
		            <p class="slideshow-slide-caption-content"><?php echo $slide['slide_description']; ?></p>
		            <?php
			           	}
			           	
			           	if(!empty($slide['slide_button_title']))
						{
							$target = $slide['slide_button_link']['is_external'] ? 'target="_blank"' : '';
			        ?>
		            <a class="slideshow-slide-caption-subtitle -load o-hsub -link" href="<?php echo esc_url($slide['slide_button_link']['url']); ?>" <?php echo esc_attr($target); ?>><span class="slideshow-slide-caption-subtitle-label"><?php echo esc_html($slide['slide_button_title']); ?></span></a>
		            <?php
			            }
			        ?>
		          </div>
		        </div>
		    </div>
		</div>
<?php
			$counter++;
			$last_slide--;
		}
?>
	<div class="c-header-home-footer">
      <div class="o-container">
        <div class="c-header-home-controls -nomobile o-button-group">
          <div class="js-parallax is-inview">
	        <button class="js-slider-home-prev floating-btn ripple" type="button">
              <span class="ti-arrow-left"></span>
            </button>
            <button class="js-slider-home-next floating-btn ripple" type="button">
              <span class="ti-arrow-right"></span>
            </button>
          </div>
        </div>
      </div>
    </div>
</div>
<?php
	}
?>