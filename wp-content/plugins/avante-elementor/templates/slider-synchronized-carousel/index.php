<?php
	$widget_id = $this->get_id();
	$slides = $this->get_settings('slides');
	
	if(!empty($slides))
	{
		//Get all settings
		$settings = $this->get_settings();
		$count_slide = count($slides);
		
		$slide_titles = array();
		$slide_images = array();
		$slide_button_title = array();
		$slide_button_url = array();
		
		foreach ($slides as $slide) 
		{
			$slide_titles[] = $slide['slide_title'];
			$slide_images[] = $slide['slide_image']['url'];
			$slide_button_title[] = $slide['slide_button_title'];
			$slide_button_url[] = $slide['slide_button_link']['url'];
		}
?>
<div id="tg_synchronized_carousel_slider_<?php echo esc_attr($widget_id); ?>" data-pagination="synchronized-carousel-pagination_<?php echo esc_attr($widget_id); ?>" class="synchronized-carousel-slider-wrapper sliders-container" data-countslide="<?php echo esc_attr($count_slide); ?>" data-slidetitles="<?php echo esc_attr(json_encode($slide_titles)); ?>" data-slideimages="<?php echo esc_attr(json_encode($slide_images)); ?>" data-slidebuttontitles="<?php echo esc_attr(json_encode($slide_button_title)); ?>" data-slidebuttonurls="<?php echo esc_attr(json_encode($slide_button_url)); ?>">
	<ul id="synchronized-carousel-pagination_<?php echo esc_attr($widget_id); ?>" class="synchronized-carousel-pagination">
	
<?php
		foreach ($slides as $slide) 
		{
?>
		<li class="pagination-item"><a class="pagination-button"></a></li>
<?php
		}
?>
	</ul>
</div>
<br class="clear"/>
<?php
	}
?>