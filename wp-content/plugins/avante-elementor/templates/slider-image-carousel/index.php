<?php
	$widget_id = $this->get_id();
	$slides = $this->get_settings('slides');
	
	if(!empty($slides))
	{
		//Get all settings
		$settings = $this->get_settings();
?>
<div class="image-carousel-slider-wrapper carousel">
	<div class="carousel-nav">
	   	<span id="moveLeft" class="carousel-arrow">
	    	<svg class="carousel-icon" width="24" height="24" viewBox="0 0 24 24">
				<path d="M20,11V13H8L13.5,18.5L12.08,19.92L4.16,12L12.08,4.08L13.5,5.5L8,11H20Z"></path>
			</svg>
			</span>
	    <span id="moveRight" class="carousel-arrow" >
	      	<svg class="carousel-icon"  width="24" height="24" viewBox="0 0 24 24">
		  		<path d="M4,11V13H16L10.5,18.5L11.92,19.92L19.84,12L11.92,4.08L10.5,5.5L16,11H4Z"></path>
			</svg>    
	    </span>
	</div>
<?php
		$counter = 1;
		$last_slide = count($slides);
	
		foreach ($slides as $slide) 
		{
?>
		<div class="carousel-item carousel-item--<?php echo esc_attr($counter); ?>">
			<div class="carousel-item-image" style="background-image:url(<?php echo esc_url($slide['slide_image']['url']); ?>);"></div>
			<div class="carousel-item-info">
		      	<div class="carousel-item__container">
			      	<?php
						if(!empty($slide['slide_sub_title']))
						{
					?>
			  			<h2 class="carousel-item-subtitle"><?php echo esc_html($slide['slide_sub_title']); ?></h2>
			  		<?php
				  		}
				  		
				  		if(!empty($slide['slide_title']))
						{
				  	?>
			  		<h1 class="carousel-item-title"><?php echo esc_html($slide['slide_title']); ?></h1>
			  		<?php
				  		}
				  		
				  		if(!empty($slide['slide_description']))
						{
				  	?>
			  		<div class="carousel-item-description"><?php echo esc_html($slide['slide_description']); ?></div>
			  		<?php
				  		}
					  		
					  	if(!empty($slide['slide_button_title']))
						{
							$target = $slide['slide_button_link']['is_external'] ? 'target="_blank"' : '';
				  	?>
			  		<a href="<?php echo esc_url($slide['slide_button_link']['url']); ?>" class="carousel-item-btn" <?php echo esc_attr($target); ?>><?php echo esc_html($slide['slide_button_title']); ?></a>
			  		<?php
				  		}
				  	?>
		        </div>
		    </div>
		</div>
<?php
			$counter++;
			$last_slide--;
		}
?>
</div>
<?php
	}
?>