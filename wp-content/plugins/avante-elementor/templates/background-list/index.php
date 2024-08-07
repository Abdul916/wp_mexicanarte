<?php
	$widget_id = $this->get_id();
	$slides = $this->get_settings('slides');
	
	if(!empty($slides))
	{
		$count_slides = count($slides);
		switch($count_slides)
		{
			case 1:
		   		$column_class = 'one-col';
		   	break;
		   	
			case 2:
		   		$column_class = 'two-col';
		   	break;
		   	
		   	case 3:
		   		$column_class = 'three-col';
		   	break;
		   	
		   	case 4:
		   	default:
		   		$column_class = 'four-cols';
		   	break;
		}
		
		//Get all settings
		$settings = $this->get_settings();
?>
<div class="background-list-wrapper <?php echo esc_attr($column_class); ?>">
<?php
		$last_class = '';
		$count = 1;
		
		foreach ($slides as $slide) 
		{
			$last_class = '';
			if($count%$count_slides == 0)
			{
				$last_class = 'last';
			}
?>
		<div class="background-list-column <?php echo esc_attr($last_class); ?>">
			<div class="background-list-content">
				<div class="background-list-title">
					<h3><?php echo esc_html($slide['slide_title']); ?></h3>
				</div>
				
				<div class="background-list-link">
					<div class="background-list-desc"><?php echo esc_html($slide['slide_description']); ?></div>
					<?php
						if(!empty($slide['slide_link']['url']))
						{
							$target = $slide['slide_link']['is_external'] ? 'target="_blank"' : '';
					?>
			        <a class="button ghost" href="<?php echo esc_url($slide['slide_link']['url']); ?>" <?php echo esc_attr($target); ?>><?php echo esc_html($slide['slide_link_title']); ?></a>
			        <?php
						}
					?>
				</div>
			</div>
		</div>
		<figure class="background-list-img <?php if($count == 1) { ?>hover<?php } ?>">
			<div class="background-list-overlay"></div>
			<img src="<?php echo esc_url($slide['slide_image']['url']); ?>" alt="" />
		</figure>
<?php
			$count++;
		}
?>
</div>
<?php
	}
?>