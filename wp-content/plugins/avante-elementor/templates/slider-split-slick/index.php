<?php
	$widget_id = $this->get_id();
	$slides = $this->get_settings('slides');
	
	if(!empty($slides))
	{
		//Get all settings
		$settings = $this->get_settings();
?>
<div class="split-slick-slide-container split-slideshow">
	<div class="slideshow">
    	<div class="slider">
<?php
		foreach ($slides as $slide) 
		{
?>
		<div class="item">
			<?php
			 	if(!empty($slide['slide_link']['url']))
			 	{
			 		$target = $slide['slide_link']['is_external'] ? 'target="_blank"' : '';
			?>
			<a class="split-slick-slide-link" href="<?php echo esc_url($slide['slide_link']['url']); ?>" <?php echo esc_attr($target); ?>></a>
			<?php
				}
			?>
        	<img src="<?php echo esc_url($slide['slide_image']['url']); ?>" />
        	<div class="bg-overlay"></div>
      	</div>
<?php
		}
?>
    	</div>
	</div>
	
	<div class="slideshow-text">
<?php
	foreach ($slides as $slide) 
	{
		if(!empty($slide['slide_title']))
		{
?>
		<div class="item">
			<?php echo esc_html($slide['slide_title']); ?>
		</div>
<?php
		}
	}
?>
	</div>
</div>
<?php
	}
?>