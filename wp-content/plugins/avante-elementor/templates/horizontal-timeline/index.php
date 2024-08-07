<?php
	$widget_id = $this->get_id();
	
	//Get all settings
	$settings = $this->get_settings();
	
	$slides = $this->get_settings('slides');

	if(!empty($slides))
	{
		//Get all settings
		$settings = $this->get_settings();
?>
<div class="tg_horizontal_timeline_wrapper cd-horizontal-timeline" data-spacing="<?php echo esc_attr($settings['timeline_spacing']['size']); ?>">
	<div class="timeline">
		<div class="events-wrapper">
			<div class="events">
				<ol>
					<?php
						$counter = 0;
						
						foreach ($slides as $slide)
						{
							$slide_date = $slide['slide_date'];
							$slide_date_format = $slide['slide_date_format'];
					?>
					<li><a href="#0" data-date="<?php echo esc_attr(date("d/m/Y", strtotime($slide_date))); ?>" <?php if($counter == 0){ ?>class="selected"<?php } ?>><?php echo esc_attr(date($slide_date_format, strtotime($slide_date))); ?></a></li>
					<?php
							$counter++;
						}
					?>
				</ol>

				<span class="filling-line" aria-hidden="true"></span>
			</div> <!-- .events -->
		</div> <!-- .events-wrapper -->
			
		<ul class="cd-timeline-navigation">
			<li><a href="#0" class="prev inactive"></a></li>
			<li><a href="#0" class="next"></a></li>
		</ul> <!-- .cd-timeline-navigation -->
	</div> <!-- .timeline -->
	
	<div class="events-content">
		<ol>
<?php
		$counter = 0;
	
		foreach ($slides as $slide)
		{	
			$slide_date = $slide['slide_date'];
			$slide_date_format = $slide['slide_date_format'];
			$slide_title = $slide['slide_title'];
			$slide_subtitle = $slide['slide_subtitle'];
			$slide_description = $slide['slide_description'];
?>
			<li <?php if($counter == 0){ ?>class="selected"<?php } ?> data-date="<?php echo esc_attr(date("d/m/Y", strtotime($slide_date))); ?>">
				<?php
					if(!empty($slide_title))
					{
				?>
					<h2><?php echo esc_html($slide_title); ?></h2>
				<?php
				 	}
				?>
				<?php
					if(!empty($slide_subtitle))
					{
				?>
					<em><?php echo esc_html($slide_subtitle); ?></em>
				<?php
				 	}
				?>
				<?php
					if(!empty($slide_description))
					{
				?>
					<div class="events-content-desc"><?php echo wp_kses_post($slide_description); ?></div>
				<?php
				 	}
				?>
			</li>
<?php
			$counter++;
		}
?>
		</ol>
	</div>
</div>
<?php
	}
?>