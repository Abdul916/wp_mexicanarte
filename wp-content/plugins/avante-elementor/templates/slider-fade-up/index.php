<?php
	$widget_id = $this->get_id();
	$slides = $this->get_settings('slides');
	
	if(!empty($slides))
	{
		//Get all settings
		$settings = $this->get_settings();
?>
<div class="fadeup-slider-wrapper cd-slider">
	<ul>
<?php
		$counter = 1;
		$last_slide = count($slides);
	
		foreach ($slides as $slide) 
		{
?>
		<li>
			<div class="image" style="background-image:url(<?php echo esc_url($slide['slide_image']['url']); ?>);"></div>
			<div class="content">
	          	<?php
					if(!empty($slide['slide_title']))
					{
				?>
		        	<h2><?php echo esc_html($slide['slide_title']); ?></h2>
		        <?php
			        }
			        
			        if(!empty($slide['slide_description']))
					{
			    ?>
		        <div class="description"><?php echo esc_html($slide['slide_description']); ?></div>
		        <?php
			       	}
			       	
			       	if(!empty($slide['slide_button_title']))
					{
						$target = $slide['slide_button_link']['is_external'] ? 'target="_blank"' : '';
			    ?>
		        <a class="slide_link" href="<?php echo esc_url($slide['slide_button_link']['url']); ?>" <?php echo esc_attr($target); ?>><?php echo esc_html($slide['slide_button_title']); ?></a>
		        <?php
			        }
			    ?>
	        </div>
		</li>
<?php
			$counter++;
			$last_slide--;
		}
?>
	</ul>
</div>
<?php
	}
?>