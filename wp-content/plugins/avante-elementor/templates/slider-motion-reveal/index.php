<?php
	$widget_id = $this->get_id();
	$slides = $this->get_settings('slides');
	
	if(!empty($slides))
	{
?>
<svg class="hidden">
	<symbol id="icon-caret" viewBox="0 0 24 13">
		<title>caret</title>
		<path d="M23.646.328a.842.842 0 0 0-1.19 0l-10.459 10.48L1.517.328a.842.842 0 0 0-1.189 1.19L11.382 12.57c.164.164.369.246.595.246.205 0 .43-.082.594-.246L23.625 1.518a.824.824 0 0 0 .02-1.19z"/>
	</symbol>
</svg>
<?php
		//Get all settings
		$settings = $this->get_settings();
?>
<div class="motion-reveal-slider-wrapper slideshow">
<?php
		$counter = 1;
		$last_slide = count($slides);
	
		foreach ($slides as $slide) 
		{
?>
		<div class="slide">
			<div class="preview">
				<div class="preview-img-wrap">
					<div class="preview-img"></div>
					<div class="preview-img-reveal"></div>
				</div>
			    <h3 class="preview-title"><?php echo esc_html($slide['slide_title']); ?></h3>
			    <div class="preview-content"><?php echo wp_kses_post($slide['slide_description']); ?></div>
			</div>
			<div class="slide-img-wrap">
				<div class="slide-img" style="background-image:url(<?php echo esc_url($slide['slide_image']['url']); ?>);"></div>
				<div class="slide-img-reveal"></div>
			</div>
			<span class="slide-number"></span>
			<h3 class="slide-title"><?php echo esc_html($slide['slide_title']); ?></h3>
		</div>
<?php
			$counter++;
			$last_slide--;
		}
?>
	<nav class="slidenav">
		<button class="slidenav-item slidenav-item--prev"><?php echo esc_html($settings['previous_title']); ?></button>
		<button class="slidenav-item slidenav-item--next"><?php echo esc_html($settings['next_title']); ?></button>
		<button class="slidenav-preview">
			<svg class="icon icon--caret">
				<use xlink:href="#icon-caret"></use>
			</svg>
		</button>
	</nav>
</div>
<?php
	}
?>