<?php
	$widget_id = $this->get_id();
	$slides = $this->get_settings('slides');
	
	if(!empty($slides))
	{
		//Get all settings
		$settings = $this->get_settings();
?>
<div class="mouse-driven-vertical-carousel-wrapper">
<?php
	if(!empty($slides))	
	{
?>
<header class="c-header c-header--archive c-header--project-list">
	<div class="c-mouse-vertical-carousel js-carousel u-media-wrapper">
		
		<?php
			if(!empty($settings['header']))	
			{
		?>
			<div class="carousel-header">
				<h2><?php echo esc_html($settings['header']); ?></h2>
				<?php
					if(!empty($settings['sub_header']))	
					{
				?>
				<div class="carousel__sub_header"><?php echo esc_html($settings['sub_header']); ?></div>
				<?php
					}
				?>
			</div>
		<?php
			}
		?>
		
		<ul class="c-mouse-vertical-carousel-list js-carousel-list">
<?php
	}
		$counter = 0;
	
		foreach ($slides as $slide) 
		{
			$target = $slide['slide_button_link']['is_external'] ? 'target="_blank"' : '';
	?>
		<li class="c-mouse-vertical-carousel-list-item js-carousel-list-item" data-item-id="<?php echo esc_attr($counter); ?>">
			<a href="<?php echo esc_url($slide['slide_button_link']['url']); ?>" <?php echo esc_attr($target); ?>>
				<?php
					if(!empty($slide['slide_sub_title']))
					{
				?>
				<p class="c-mouse-vertical-carousel-eyebrow">
					<?php echo esc_html($slide['slide_sub_title']); ?>
				</p>
				<?php
				  	}
				  	
				  	if(!empty($slide['slide_title']))
					{
				?>
				<p class="c-mouse-vertical-carousel-title">
					<?php echo esc_html($slide['slide_title']); ?>
				</p>
				<?php
					}
				?>
			</a>
		</li>
	<?php
			$counter++;
		}
	?>
<?php
	if(!empty($slides))	
	{
?>
		</ul>
<?php
		//Display background image
		foreach ($slides as $slide) 
		{
?>
	<i class="c-mouse-vertical-carousel-bg-img js-carousel-bg-img" style="background-image: url(<?php echo esc_url($slide['slide_image']['url']); ?>)"></i>
<?php	
		}
?>
	<i class="c-gradient-overlay"></i>
<?php
	}
?>
	</div>
</header>
</div>
<?php
	}
?>