<?php
	$widget_id = $this->get_id();
	$settings = $this->get_settings();
	
	$default_image = wp_get_attachment_image_src($settings['default_image']['id'], $settings['image_size'], true); 

	if(!isset($default_image[0]) OR empty($default_image[0]))
	{
		$default_image[0] = $settings['default_image']['url'];
	}
	
	$flip_image = wp_get_attachment_image_src($settings['flip_image']['id'], $settings['image_size'], true); 
	if(!isset($flip_image[0]) OR empty($flip_image[0]))
	{
		$flip_image[0] = $settings['flip_image']['url'];
	}
?>
<div class="flip-box-wrapper square-flip">
	<div class="square" data-image="<?php echo esc_url($default_image[0]); ?>">
		<div class="square-container">
			<?php
				if(isset($settings['default_icon']['url']) && !empty($settings['default_icon']['url']))
				{
			?>
				<img src="<?php echo esc_url($settings['default_icon']['url']); ?>" alt="<?php echo esc_html($settings['default_title']); ?>" class="flip_icon"/>
			<?php
				}
				
				if(!empty($settings['default_title']))
				{
			?>
				<h2><?php echo esc_html($settings['default_title']); ?></h2>
			<?php
				}

				if(!empty($settings['default_description']))
				{
			?>
				<div class="square-desc"><?php echo esc_html($settings['default_description']); ?></div>
			<?php
				}
			?>
		</div>
		<div class="flip-overlay"></div>
	</div>
	<div class="square2" data-image="<?php echo esc_url($flip_image[0]); ?>">
		<div class="square-container2">
			<div class="align-center"></div>
			<?php
				if(!empty($settings['flip_title']))
				{
			?>
				<h2><?php echo esc_html($settings['flip_title']); ?></h2>
			<?php
				}

				if(!empty($settings['flip_button_title']))
				{
					$target = $settings['flip_button_link']['is_external'] ? 'target="_blank"' : '';
			?>
				<a href="<?php echo esc_url($settings['flip_button_link']['url']); ?>"  <?php echo esc_attr($target); ?> class="boxshadow button"><?php echo esc_html($settings['flip_button_title']); ?></a>
			<?php
				}
			?>
		</div>
		<div class="flip-overlay"></div>
	</div>
</div>