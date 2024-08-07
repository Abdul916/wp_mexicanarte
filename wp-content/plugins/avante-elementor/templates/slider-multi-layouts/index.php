<?php
	$widget_id = $this->get_id();
	$slides = $this->get_settings('slides');
	$count_slides = count($slides);

	if(!empty($slides))
	{
		//Get all settings
		$settings = $this->get_settings();
?>
<svg class="hidden">
	<defs>
		<symbol id="icon-arrow" viewBox="0 0 24 24">
			<title>arrow</title>
			<polygon points="6.3,12.8 20.9,12.8 20.9,11.2 6.3,11.2 10.2,7.2 9,6 3.1,12 9,18 10.2,16.8 "/>
		</symbol>
		<symbol id="icon-prev" viewBox="0 0 100 50">
			<title>prev</title>
			<polygon points="5.4,25 18.7,38.2 22.6,34.2 16.2,27.8 94.6,27.8 94.6,22.2 16.2,22.2 22.6,15.8 18.7,11.8"/>
		</symbol>
		<symbol id="icon-next" viewBox="0 0 100 50">
			<title>next</title>
			<polygon points="81.3,11.8 77.4,15.8 83.8,22.2 5.4,22.2 5.4,27.8 83.8,27.8 77.4,34.2 81.3,38.2 94.6,25 "/>
		</symbol>
	</defs>
</svg>
<?php
	//Custom style for width and height
	$custom_style = 'width:'.$settings['width']['size'].$settings['width']['unit'].';';
	
	if($settings['height']['unit'] == '%')
	{
		$custom_style.= 'height:'.$settings['height']['size'].'vh;';
	}
	else
	{
		$custom_style.= 'height:'.$settings['height']['size'].$settings['height']['unit'].';';
	}
	
	switch($settings['align'])
	{
		case 'left':
			$custom_style.= 'float:left;';
		break;
		
		case 'center':
			$custom_style.= 'margin: 0 auto;';
		break;
		
		case 'right':
			$custom_style.= 'float:right;';
		break;
	}
?>
<div class="multi-layouts-slider-wrapper slideshow" tabindex="0" style="<?php echo esc_attr($custom_style); ?>">
<?php
		//Create slide image
		$counter = 0;
	
		foreach ($slides as $slide)
		{	
			//Get slide images
			$count_slide_img = count($slide['slide_image']);
?>
		<div class="slide slide--layout-<?php echo esc_attr($slide['slide_layout']); ?>" data-layout="layout<?php echo esc_attr($slide['slide_layout']); ?>">
			<?php
				if($count_slide_img > 0)
				{
					switch($slide['slide_layout'])
					{
						case 1:
			?>
				<div class="slide-imgwrap">
				<?php
					if(isset($slide['slide_image'][0]['url']))		
					{
						if(isset($slide['slide_image'][0]['id']) && !empty($slide['slide_image'][0]['id']) && (!isset($_GET['elementor_library']) OR empty($_GET['elementor_library'])))
						{
							$image_url = wp_get_attachment_image_src($slide['slide_image'][0]['id'], $slide['image_size'], true);
						}
						else
						{
							$image_url[0] = $slide['slide_image'][0]['url'];
						}
				?>
					<div class="slide-img"><div class="slide-img-inner" style="background-image: url(<?php echo esc_url($image_url[0]); ?>);"></div></div>
				<?php
					}
				?>
				<?php
					if(isset($slide['slide_image'][1]['url']))		
					{
						if(isset($slide['slide_image'][1]['id']) && !empty($slide['slide_image'][1]['id']) && (!isset($_GET['elementor_library']) OR empty($_GET['elementor_library'])))
						{
							$image_url = wp_get_attachment_image_src($slide['slide_image'][1]['id'], $slide['image_size'], true);
						}
						else
						{
							$image_url[0] = $slide['slide_image'][1]['url'];
						}
				?>
					<div class="slide-img"><div class="slide-img-inner" style="background-image: url(<?php echo esc_url($image_url[0]); ?>);"></div></div>
				<?php
					}
				?>
				<?php
					if(isset($slide['slide_image'][2]['url']))		
					{
						if(isset($slide['slide_image'][2]['id']) && !empty($slide['slide_image'][2]['id']) && (!isset($_GET['elementor_library']) OR empty($_GET['elementor_library'])))
						{
							$image_url = wp_get_attachment_image_src($slide['slide_image'][2]['id'], $slide['image_size'], true);
						}
						else
						{
							$image_url[0] = $slide['slide_image'][2]['url'];
						}
				?>
					<div class="slide-img"><div class="slide-img-inner" style="background-image: url(<?php echo esc_url($image_url[0]); ?>);"></div></div>
				<?php
					}
				?>
				</div>
			<?php
						break;
						
						case 2:
			?>
				<div class="slide-imgwrap">
				<?php
					if(isset($slide['slide_image'][0]['url']))		
					{
						if(isset($slide['slide_image'][0]['id']) && !empty($slide['slide_image'][0]['id']) && (!isset($_GET['elementor_library']) OR empty($_GET['elementor_library'])))
						{
							$image_url = wp_get_attachment_image_src($slide['slide_image'][0]['id'], $slide['image_size'], true);
						}
						else
						{
							$image_url[0] = $slide['slide_image'][0]['url'];
						}
				?>
					<div class="slide-img"><div class="slide-img-inner" style="background-image: url(<?php echo esc_url($image_url[0]); ?>);"></div></div>
				<?php
					}
				?>
				<?php
					if(isset($slide['slide_image'][1]['url']))		
					{
						if(isset($slide['slide_image'][1]['id']) && !empty($slide['slide_image'][1]['id']) && (!isset($_GET['elementor_library']) OR empty($_GET['elementor_library'])))
						{
							$image_url = wp_get_attachment_image_src($slide['slide_image'][1]['id'], $slide['image_size'], true);
						}
						else
						{
							$image_url[0] = $slide['slide_image'][1]['url'];
						}
				?>
					<div class="slide-img"><div class="slide-img-inner" style="background-image: url(<?php echo esc_url($image_url[0]); ?>);"></div></div>
				<?php
					}
				?>
				<?php
					if(isset($slide['slide_image'][2]['url']))		
					{
						if(isset($slide['slide_image'][2]['id']) && !empty($slide['slide_image'][2]['id']) && (!isset($_GET['elementor_library']) OR empty($_GET['elementor_library'])))
						{
							$image_url = wp_get_attachment_image_src($slide['slide_image'][2]['id'], $slide['image_size'], true);
						}
						else
						{
							$image_url[0] = $slide['slide_image'][2]['url'];
						}
				?>
					<div class="slide-img"><div class="slide-img-inner" style="background-image: url(<?php echo esc_url($image_url[0]); ?>);"></div></div>
				<?php
					}
				?>
				<?php
					if(isset($slide['slide_image'][3]['url']))		
					{
						if(isset($slide['slide_image'][3]['id']) && !empty($slide['slide_image'][3]['id']) && (!isset($_GET['elementor_library']) OR empty($_GET['elementor_library'])))
						{
							$image_url = wp_get_attachment_image_src($slide['slide_image'][3]['id'], $slide['image_size'], true);
						}
						else
						{
							$image_url[0] = $slide['slide_image'][3]['url'];
						}
				?>
					<div class="slide-img"><div class="slide-img-inner" style="background-image: url(<?php echo esc_url($image_url[0]); ?>);"></div></div>
				<?php
					}
				?>
				<?php
					if(isset($slide['slide_image'][4]['url']))		
					{
						if(isset($slide['slide_image'][4]['id']) && !empty($slide['slide_image'][4]['id']) && (!isset($_GET['elementor_library']) OR empty($_GET['elementor_library'])))
						{
							$image_url = wp_get_attachment_image_src($slide['slide_image'][4]['id'], $slide['image_size'], true);
						}
						else
						{
							$image_url[0] = $slide['slide_image'][4]['url'];
						}
				?>
					<div class="slide-img"><div class="slide-img-inner" style="background-image: url(<?php echo esc_url($image_url[0]); ?>);"></div></div>
				<?php
					}
				?>
				</div>
			<?php
						break;
						
						case 3:
			?>
				<div class="slide-imgwrap">
				<?php
					if(isset($slide['slide_image'][0]['url']))		
					{
						if(isset($slide['slide_image'][0]['id']) && !empty($slide['slide_image'][0]['id']) && (!isset($_GET['elementor_library']) OR empty($_GET['elementor_library'])))
						{
							$image_url = wp_get_attachment_image_src($slide['slide_image'][0]['id'], $slide['image_size'], true);
						}
						else
						{
							$image_url[0] = $slide['slide_image'][0]['url'];
						}
				?>
					<div class="slide-img"><div class="slide-img-inner" style="background-image: url(<?php echo esc_url($image_url[0]); ?>);"></div></div>
				<?php
					}
				?>
				<?php
					if(isset($slide['slide_image'][1]['url']))		
					{
						if(isset($slide['slide_image'][1]['id']) && !empty($slide['slide_image'][1]['id']) && (!isset($_GET['elementor_library']) OR empty($_GET['elementor_library'])))
						{
							$image_url = wp_get_attachment_image_src($slide['slide_image'][1]['id'], $slide['image_size'], true);
						}
						else
						{
							$image_url[0] = $slide['slide_image'][1]['url'];
						}
				?>
					<div class="slide-img"><div class="slide-img-inner" style="background-image: url(<?php echo esc_url($image_url[0]); ?>);"></div></div>
				<?php
					}
				?>
				<?php
					if(isset($slide['slide_image'][2]['url']))		
					{
						if(isset($slide['slide_image'][2]['id']) && !empty($slide['slide_image'][2]['id']) && (!isset($_GET['elementor_library']) OR empty($_GET['elementor_library'])))
						{
							$image_url = wp_get_attachment_image_src($slide['slide_image'][2]['id'], $slide['image_size'], true);
						}
						else
						{
							$image_url[0] = $slide['slide_image'][2]['url'];
						}
				?>
					<div class="slide-img"><div class="slide-img-inner" style="background-image: url(<?php echo esc_url($image_url[0]); ?>);"></div></div>
				<?php
					}
				?>
				<?php
					if(isset($slide['slide_image'][3]['url']))		
					{
						if(isset($slide['slide_image'][3]['id']) && !empty($slide['slide_image'][3]['id']) && (!isset($_GET['elementor_library']) OR empty($_GET['elementor_library'])))
						{
							$image_url = wp_get_attachment_image_src($slide['slide_image'][3]['id'], $slide['image_size'], true);
						}
						else
						{
							$image_url[0] = $slide['slide_image'][3]['url'];
						}
				?>
					<div class="slide-img"><div class="slide-img-inner" style="background-image: url(<?php echo esc_url($image_url[0]); ?>);"></div></div>
				<?php
					}
				?>
				<?php
					if(isset($slide['slide_image'][4]['url']))		
					{
						if(isset($slide['slide_image'][4]['id']) && !empty($slide['slide_image'][4]['id']) && (!isset($_GET['elementor_library']) OR empty($_GET['elementor_library'])))
						{
							$image_url = wp_get_attachment_image_src($slide['slide_image'][4]['id'], $slide['image_size'], true);
						}
						else
						{
							$image_url[0] = $slide['slide_image'][4]['url'];
						}
				?>
					<div class="slide-img"><div class="slide-img-inner" style="background-image: url(<?php echo esc_url($image_url[0]); ?>);"></div></div>
				<?php
					}
				?>
				<?php
					if(isset($slide['slide_image'][5]['url']))		
					{
						if(isset($slide['slide_image'][5]['id']) && !empty($slide['slide_image'][5]['id']) && (!isset($_GET['elementor_library']) OR empty($_GET['elementor_library'])))
						{
							$image_url = wp_get_attachment_image_src($slide['slide_image'][5]['id'], $slide['image_size'], true);
						}
						else
						{
							$image_url[0] = $slide['slide_image'][5]['url'];
						}
				?>
					<div class="slide-img"><div class="slide-img-inner" style="background-image: url(<?php echo esc_url($image_url[0]); ?>);"></div></div>
				<?php
					}
				?>
				<?php
					if(isset($slide['slide_image'][6]['url']))		
					{
						if(isset($slide['slide_image'][6]['id']) && !empty($slide['slide_image'][6]['id']) && (!isset($_GET['elementor_library']) OR empty($_GET['elementor_library'])))
						{
							$image_url = wp_get_attachment_image_src($slide['slide_image'][6]['id'], $slide['image_size'], true);
						}
						else
						{
							$image_url[0] = $slide['slide_image'][6]['url'];
						}
				?>
					<div class="slide-img"><div class="slide-img-inner" style="background-image: url(<?php echo esc_url($image_url[0]); ?>);"></div></div>
				<?php
					}
				?>
				</div>
			<?php
						break;
						
						case 4:
			?>
				<div class="slide-imgwrap">
				<?php
					if(isset($slide['slide_image'][0]['url']))		
					{
						if(isset($slide['slide_image'][0]['id']) && !empty($slide['slide_image'][0]['id']) && (!isset($_GET['elementor_library']) OR empty($_GET['elementor_library'])))
						{
							$image_url = wp_get_attachment_image_src($slide['slide_image'][0]['id'], $slide['image_size'], true);
						}
						else
						{
							$image_url[0] = $slide['slide_image'][0]['url'];
						}
				?>
					<div class="slide-img"><div class="slide-img-inner" style="background-image: url(<?php echo esc_url($image_url[0]); ?>);"></div></div>
				<?php
					}
				?>
				<?php
					if(isset($slide['slide_image'][1]['url']))		
					{
						if(isset($slide['slide_image'][1]['id']) && !empty($slide['slide_image'][1]['id']) && (!isset($_GET['elementor_library']) OR empty($_GET['elementor_library'])))
						{
							$image_url = wp_get_attachment_image_src($slide['slide_image'][1]['id'], $slide['image_size'], true);
						}
						else
						{
							$image_url[0] = $slide['slide_image'][1]['url'];
						}
				?>
					<div class="slide-img"><div class="slide-img-inner" style="background-image: url(<?php echo esc_url($image_url[0]); ?>);"></div></div>
				<?php
					}
				?>
				<?php
					if(isset($slide['slide_image'][2]['url']))		
					{
						if(isset($slide['slide_image'][2]['id']) && !empty($slide['slide_image'][2]['id']) && (!isset($_GET['elementor_library']) OR empty($_GET['elementor_library'])))
						{
							$image_url = wp_get_attachment_image_src($slide['slide_image'][2]['id'], $slide['image_size'], true);
						}
						else
						{
							$image_url[0] = $slide['slide_image'][2]['url'];
						}
				?>
					<div class="slide-img"><div class="slide-img-inner" style="background-image: url(<?php echo esc_url($image_url[0]); ?>);"></div></div>
				<?php
					}
				?>
				<?php
					if(isset($slide['slide_image'][3]['url']))		
					{
						if(isset($slide['slide_image'][3]['id']) && !empty($slide['slide_image'][3]['id']) && (!isset($_GET['elementor_library']) OR empty($_GET['elementor_library'])))
						{
							$image_url = wp_get_attachment_image_src($slide['slide_image'][3]['id'], $slide['image_size'], true);
						}
						else
						{
							$image_url[0] = $slide['slide_image'][3]['url'];
						}
				?>
					<div class="slide-img"><div class="slide-img-inner" style="background-image: url(<?php echo esc_url($image_url[0]); ?>);"></div></div>
				<?php
					}
				?>
				</div>
			<?php
						break;
						
						case 5:
			?>
				<div class="slide-imgwrap">
				<?php
					if(isset($slide['slide_image'][0]['url']))		
					{
						if(isset($slide['slide_image'][0]['id']) && !empty($slide['slide_image'][0]['id']) && (!isset($_GET['elementor_library']) OR empty($_GET['elementor_library'])))
						{
							$image_url = wp_get_attachment_image_src($slide['slide_image'][0]['id'], $slide['image_size'], true);
						}
						else
						{
							$image_url[0] = $slide['slide_image'][0]['url'];
						}
				?>
					<div class="slide-img"><div class="slide-img-inner" style="background-image: url(<?php echo esc_url($image_url[0]); ?>);"></div></div>
				<?php
					}
				?>
				<?php
					if(isset($slide['slide_image'][1]['url']))		
					{
						if(isset($slide['slide_image'][1]['id']) && !empty($slide['slide_image'][1]['id']) && (!isset($_GET['elementor_library']) OR empty($_GET['elementor_library'])))
						{
							$image_url = wp_get_attachment_image_src($slide['slide_image'][1]['id'], $slide['image_size'], true);
						}
						else
						{
							$image_url[0] = $slide['slide_image'][1]['url'];
						}
				?>
					<div class="slide-img"><div class="slide-img-inner" style="background-image: url(<?php echo esc_url($image_url[0]); ?>);"></div></div>
				<?php
					}
				?>
				<?php
					if(isset($slide['slide_image'][2]['url']))		
					{
						if(isset($slide['slide_image'][2]['id']) && !empty($slide['slide_image'][2]['id']) && (!isset($_GET['elementor_library']) OR empty($_GET['elementor_library'])))
						{
							$image_url = wp_get_attachment_image_src($slide['slide_image'][2]['id'], $slide['image_size'], true);
						}
						else
						{
							$image_url[0] = $slide['slide_image'][2]['url'];
						}
				?>
					<div class="slide-img"><div class="slide-img-inner" style="background-image: url(<?php echo esc_url($image_url[0]); ?>);"></div></div>
				<?php
					}
				?>
				<?php
					if(isset($slide['slide_image'][3]['url']))		
					{
						if(isset($slide['slide_image'][3]['id']) && !empty($slide['slide_image'][3]['id']) && (!isset($_GET['elementor_library']) OR empty($_GET['elementor_library'])))
						{
							$image_url = wp_get_attachment_image_src($slide['slide_image'][3]['id'], $slide['image_size'], true);
						}
						else
						{
							$image_url[0] = $slide['slide_image'][3]['url'];
						}
				?>
					<div class="slide-img"><div class="slide-img-inner" style="background-image: url(<?php echo esc_url($image_url[0]); ?>);"></div></div>
				<?php
					}
				?>
				<?php
					if(isset($slide['slide_image'][4]['url']))		
					{
						if(isset($slide['slide_image'][4]['id']) && !empty($slide['slide_image'][4]['id']) && (!isset($_GET['elementor_library']) OR empty($_GET['elementor_library'])))
						{
							$image_url = wp_get_attachment_image_src($slide['slide_image'][4]['id'], $slide['image_size'], true);
						}
						else
						{
							$image_url[0] = $slide['slide_image'][4]['url'];
						}
				?>
					<div class="slide-img"><div class="slide-img-inner" style="background-image: url(<?php echo esc_url($image_url[0]); ?>);"></div></div>
				<?php
					}
				?>
				<?php
					if(isset($slide['slide_image'][5]['url']))		
					{
						if(isset($slide['slide_image'][5]['id']) && !empty($slide['slide_image'][5]['id']) && (!isset($_GET['elementor_library']) OR empty($_GET['elementor_library'])))
						{
							$image_url = wp_get_attachment_image_src($slide['slide_image'][5]['id'], $slide['image_size'], true);
						}
						else
						{
							$image_url[0] = $slide['slide_image'][5]['url'];
						}
				?>
					<div class="slide-img"><div class="slide-img-inner" style="background-image: url(<?php echo esc_url($image_url[0]); ?>);"></div></div>
				<?php
					}
				?>
				<?php
					if(isset($slide['slide_image'][6]['url']))		
					{
						if(isset($slide['slide_image'][6]['id']) && !empty($slide['slide_image'][6]['id']) && (!isset($_GET['elementor_library']) OR empty($_GET['elementor_library'])))
						{
							$image_url = wp_get_attachment_image_src($slide['slide_image'][6]['id'], $slide['image_size'], true);
						}
						else
						{
							$image_url[0] = $slide['slide_image'][6]['url'];
						}
				?>
					<div class="slide-img"><div class="slide-img-inner" style="background-image: url(<?php echo esc_url($image_url[0]); ?>);"></div></div>
				<?php
					}
				?>
				<?php
					if(isset($slide['slide_image'][7]['url']))		
					{
						if(isset($slide['slide_image'][7]['id']) && !empty($slide['slide_image'][7]['id']) && (!isset($_GET['elementor_library']) OR empty($_GET['elementor_library'])))
						{
							$image_url = wp_get_attachment_image_src($slide['slide_image'][7]['id'], $slide['image_size'], true);
						}
						else
						{
							$image_url[0] = $slide['slide_image'][7]['url'];
						}
				?>
					<div class="slide-img"><div class="slide-img-inner" style="background-image: url(<?php echo esc_url($image_url[0]); ?>);"></div></div>
				<?php
					}
				?>
				<?php
					if(isset($slide['slide_image'][8]['url']))		
					{
						if(isset($slide['slide_image'][8]['id']) && !empty($slide['slide_image'][8]['id']) && (!isset($_GET['elementor_library']) OR empty($_GET['elementor_library'])))
						{
							$image_url = wp_get_attachment_image_src($slide['slide_image'][8]['id'], $slide['image_size'], true);
						}
						else
						{
							$image_url[0] = $slide['slide_image'][8]['url'];
						}
				?>
					<div class="slide-img"><div class="slide-img-inner" style="background-image: url(<?php echo esc_url($image_url[0]); ?>);"></div></div>
				<?php
					}
				?>
				<?php
					if(isset($slide['slide_image'][9]['url']))		
					{
						if(isset($slide['slide_image'][9]['id']) && !empty($slide['slide_image'][9]['id']) && (!isset($_GET['elementor_library']) OR empty($_GET['elementor_library'])))
						{
							$image_url = wp_get_attachment_image_src($slide['slide_image'][9]['id'], $slide['image_size'], true);
						}
						else
						{
							$image_url[0] = $slide['slide_image'][9]['url'];
						}
				?>
					<div class="slide-img"><div class="slide-img-inner" style="background-image: url(<?php echo esc_url($image_url[0]); ?>);"></div></div>
				<?php
					}
				?>
				<?php
					if(isset($slide['slide_image'][10]['url']))		
					{
						if(isset($slide['slide_image'][10]['id']) && !empty($slide['slide_image'][10]['id']) && (!isset($_GET['elementor_library']) OR empty($_GET['elementor_library'])))
						{
							$image_url = wp_get_attachment_image_src($slide['slide_image'][10]['id'], $slide['image_size'], true);
						}
						else
						{
							$image_url[0] = $slide['slide_image'][10]['url'];
						}
				?>
					<div class="slide-img"><div class="slide-img-inner" style="background-image: url(<?php echo esc_url($image_url[0]); ?>);"></div></div>
				<?php
					}
				?>
				<?php
					if(isset($slide['slide_image'][11]['url']))		
					{
						if(isset($slide['slide_image'][11]['id']) && !empty($slide['slide_image'][11]['id']) && (!isset($_GET['elementor_library']) OR empty($_GET['elementor_library'])))
						{
							$image_url = wp_get_attachment_image_src($slide['slide_image'][11]['id'], $slide['image_size'], true);
						}
						else
						{
							$image_url[0] = $slide['slide_image'][11]['url'];
						}
				?>
					<div class="slide-img"><div class="slide-img-inner" style="background-image: url(<?php echo esc_url($image_url[0]); ?>);"></div></div>
				<?php
					}
				?>
				<?php
					if(isset($slide['slide_image'][12]['url']))		
					{
						if(isset($slide['slide_image'][12]['id']) && !empty($slide['slide_image'][12]['id']) && (!isset($_GET['elementor_library']) OR empty($_GET['elementor_library'])))
						{
							$image_url = wp_get_attachment_image_src($slide['slide_image'][12]['id'], $slide['image_size'], true);
						}
						else
						{
							$image_url[0] = $slide['slide_image'][12]['url'];
						}
				?>
					<div class="slide-img"><div class="slide-img-inner" style="background-image: url(<?php echo esc_url($image_url[0]); ?>);"></div></div>
				<?php
					}
				?>
				<?php
					if(isset($slide['slide_image'][13]['url']))		
					{
						if(isset($slide['slide_image'][13]['id']) && !empty($slide['slide_image'][13]['id']) && (!isset($_GET['elementor_library']) OR empty($_GET['elementor_library'])))
						{
							$image_url = wp_get_attachment_image_src($slide['slide_image'][13]['id'], $slide['image_size'], true);
						}
						else
						{
							$image_url[0] = $slide['slide_image'][13]['url'];
						}
				?>
					<div class="slide-img"><div class="slide-img-inner" style="background-image: url(<?php echo esc_url($image_url[0]); ?>);"></div></div>
				<?php
					}
				?>
				<?php
					if(isset($slide['slide_image'][14]['url']))		
					{
						if(isset($slide['slide_image'][14]['id']) && !empty($slide['slide_image'][14]['id']) && (!isset($_GET['elementor_library']) OR empty($_GET['elementor_library'])))
						{
							$image_url = wp_get_attachment_image_src($slide['slide_image'][14]['id'], $slide['image_size'], true);
						}
						else
						{
							$image_url[0] = $slide['slide_image'][14]['url'];
						}
				?>
					<div class="slide-img"><div class="slide-img-inner" style="background-image: url(<?php echo esc_url($image_url[0]); ?>);"></div></div>
				<?php
					}
				?>
				<?php
					if(isset($slide['slide_image'][15]['url']))		
					{
						if(isset($slide['slide_image'][15]['id']) && !empty($slide['slide_image'][15]['id']) && (!isset($_GET['elementor_library']) OR empty($_GET['elementor_library'])))
						{
							$image_url = wp_get_attachment_image_src($slide['slide_image'][15]['id'], $slide['image_size'], true);
						}
						else
						{
							$image_url[0] = $slide['slide_image'][15]['url'];
						}
				?>
					<div class="slide-img"><div class="slide-img-inner" style="background-image: url(<?php echo esc_url($image_url[0]); ?>);"></div></div>
				<?php
					}
				?>
				<?php
					if(isset($slide['slide_image'][16]['url']))		
					{
						if(isset($slide['slide_image'][16]['id']) && !empty($slide['slide_image'][16]['id']) && (!isset($_GET['elementor_library']) OR empty($_GET['elementor_library'])))
						{
							$image_url = wp_get_attachment_image_src($slide['slide_image'][16]['id'], $slide['image_size'], true);
						}
						else
						{
							$image_url[0] = $slide['slide_image'][16]['url'];
						}
				?>
					<div class="slide-img"><div class="slide-img-inner" style="background-image: url(<?php echo esc_url($image_url[0]); ?>);"></div></div>
				<?php
					}
				?>
				<?php
					if(isset($slide['slide_image'][17]['url']))		
					{
						if(isset($slide['slide_image'][17]['id']) && !empty($slide['slide_image'][17]['id']) && (!isset($_GET['elementor_library']) OR empty($_GET['elementor_library'])))
						{
							$image_url = wp_get_attachment_image_src($slide['slide_image'][17]['id'], $slide['image_size'], true);
						}
						else
						{
							$image_url[0] = $slide['slide_image'][17]['url'];
						}
				?>
					<div class="slide-img"><div class="slide-img-inner" style="background-image: url(<?php echo esc_url($image_url[0]); ?>);"></div></div>
				<?php
					}
				?>
				</div>
			<?php
						break;
						
						case 6:
			?>
				<div class="slide-imgwrap">
				<?php
					if(isset($slide['slide_image'][0]['url']))		
					{
						if(isset($slide['slide_image'][0]['id']) && !empty($slide['slide_image'][0]['id']) && (!isset($_GET['elementor_library']) OR empty($_GET['elementor_library'])))
						{
							$image_url = wp_get_attachment_image_src($slide['slide_image'][0]['id'], $slide['image_size'], true);
						}
						else
						{
							$image_url[0] = $slide['slide_image'][0]['url'];
						}
				?>
					<div class="slide-img"><div class="slide-img-inner" style="background-image: url(<?php echo esc_url($image_url[0]); ?>);"></div></div>
				<?php
					}
				?>
				<?php
					if(isset($slide['slide_image'][1]['url']))		
					{
						if(isset($slide['slide_image'][1]['id']) && !empty($slide['slide_image'][1]['id']) && (!isset($_GET['elementor_library']) OR empty($_GET['elementor_library'])))
						{
							$image_url = wp_get_attachment_image_src($slide['slide_image'][1]['id'], $slide['image_size'], true);
						}
						else
						{
							$image_url[0] = $slide['slide_image'][1]['url'];
						}
				?>
					<div class="slide-img"><div class="slide-img-inner" style="background-image: url(<?php echo esc_url($image_url[0]); ?>);"></div></div>
				<?php
					}
				?>
				<?php
					if(isset($slide['slide_image'][2]['url']))		
					{
						if(isset($slide['slide_image'][2]['id']) && !empty($slide['slide_image'][2]['id']) && (!isset($_GET['elementor_library']) OR empty($_GET['elementor_library'])))
						{
							$image_url = wp_get_attachment_image_src($slide['slide_image'][2]['id'], $slide['image_size'], true);
						}
						else
						{
							$image_url[0] = $slide['slide_image'][2]['url'];
						}
				?>
					<div class="slide-img"><div class="slide-img-inner" style="background-image: url(<?php echo esc_url($image_url[0]); ?>);"></div></div>
				<?php
					}
				?>
				</div>
			<?php
						break;
						
						case 7:
			?>
				<div class="slide-imgwrap">
				<?php
					if(isset($slide['slide_image'][0]['url']))		
					{
						if(isset($slide['slide_image'][0]['id']) && !empty($slide['slide_image'][0]['id']) && (!isset($_GET['elementor_library']) OR empty($_GET['elementor_library'])))
						{
							$image_url = wp_get_attachment_image_src($slide['slide_image'][0]['id'], $slide['image_size'], true);
						}
						else
						{
							$image_url[0] = $slide['slide_image'][0]['url'];
						}
				?>
					<div class="slide-img"><div class="slide-img-inner" style="background-image: url(<?php echo esc_url($image_url[0]); ?>);"></div></div>
				<?php
					}
				?>
				<?php
					if(isset($slide['slide_image'][1]['url']))		
					{
						if(isset($slide['slide_image'][1]['id']) && !empty($slide['slide_image'][1]['id']) && (!isset($_GET['elementor_library']) OR empty($_GET['elementor_library'])))
						{
							$image_url = wp_get_attachment_image_src($slide['slide_image'][1]['id'], $slide['image_size'], true);
						}
						else
						{
							$image_url[0] = $slide['slide_image'][1]['url'];
						}
				?>
					<div class="slide-img"><div class="slide-img-inner" style="background-image: url(<?php echo esc_url($image_url[0]); ?>);"></div></div>
				<?php
					}
				?>
				<?php
					if(isset($slide['slide_image'][2]['url']))		
					{
						if(isset($slide['slide_image'][2]['id']) && !empty($slide['slide_image'][2]['id']) && (!isset($_GET['elementor_library']) OR empty($_GET['elementor_library'])))
						{
							$image_url = wp_get_attachment_image_src($slide['slide_image'][2]['id'], $slide['image_size'], true);
						}
						else
						{
							$image_url[0] = $slide['slide_image'][2]['url'];
						}
				?>
					<div class="slide-img"><div class="slide-img-inner" style="background-image: url(<?php echo esc_url($image_url[0]); ?>);"></div></div>
				<?php
					}
				?>
				</div>
			<?php
						break;
					}
				}
			?>
			<div class="slide-title">
				<h2 class="slide-title-main"><?php echo esc_html($slide['slide_title']); ?></h2>
				<p class="slide-title-sub">
					<?php echo esc_html($slide['slide_description']); ?> 
					<?php
						if(!empty($slide['slide_link']['url']))
						{
							$target = $slide['slide_link']['is_external'] ? 'target="_blank"' : '';
					?>
					<a class="tg_multi_layouts_slide_link" href="<?php echo esc_url($slide['slide_link']['url']); ?>" <?php echo esc_attr($target); ?>><?php echo esc_html($slide['slide_link_title']); ?> </a>
					<?php
						}
					?>
				</p>
			</div>
		</div>
<?php
			$counter++;
		}
?>

<?php
		if($count_slides > 1)
		{
?>
		<nav class="slideshow-nav slideshow-nav--arrows">
			<button id="prev-slide" class="tg_multi_layouts_slider btn btn--arrow" aria-label="Previous slide"><svg class="icon icon--prev"><use xlink:href="#icon-prev"></use></svg></button>
			<button id="next-slide" class="tg_multi_layouts_slider btn btn--arrow" aria-label="Next slide"><svg class="icon icon--next"><use xlink:href="#icon-next"></use></svg></button>
		</nav>
<?php
		}
?>
</div>
<?php
	}
?>