<?php
	$widget_id = $this->get_id();
	$slides = $this->get_settings('slides');
	$count_slides = count($slides);
	
	//Get all settings
	$settings = $this->get_settings();

	if(!empty($slides))
	{		
		$thumb_image_name = 'thumbnail';
		$songs_arr = array();
		
		foreach ( $slides as $slide ) 
		{
			$slide_id = $slide['_id'];
			
			if(is_numeric($slide['slide_image']['id']) && !empty($slide['slide_image']['id']))
			{
				if(is_numeric($slide['slide_image']['id']) && (!isset($_GET['elementor_library']) OR empty($_GET['elementor_library'])))
				{
					$image_url = wp_get_attachment_image_src($slide['slide_image']['id'], $thumb_image_name, true);
				}
				else
				{
					$image_url[0] = $slide['slide_image']['url'];
				}
				
				//Get image meta data
				$image_alt = get_post_meta($slide['slide_image']['id'], '_wp_attachment_image_alt', true);
			}
			else
			{
				$image_url[0] = $slide['slide_image']['url'];
				$image_alt = '';
			}
			
			$songs_arr[] = array(
				'title' => $slide['slide_title'],
				'artist' => $slide['slide_subtitle'],
				'mp3' => $slide['slide_audio'],
				'poster' => $image_url[0],
			);
		} 
?>
<input type="hidden" id="<?php echo esc_attr($widget_id); ?>_songlist" value="<?php echo esc_attr(json_encode($songs_arr)); ?>"/>
<div class="avante-music-player" data-songlist="<?php echo esc_attr($widget_id); ?>_songlist">
	<div class="player">
		<div class="player-background"></div>
		<img src="<?php bloginfo('template_directory'); ?>/images/default-image.jpg" alt="" class="player-img">
		<h2 class="player-title"></h2>
		<h3 class="player-artist"></h3>
		<div class="player-controls">
			<a href="javascript:;" class="player-controls__prev"><i class="fa fa-backward"></i></a>
			<a href="javascript:;" class="player-controls__play"><i class="fa fa-play"></i></a>
			<a href="javascript:;" class="player-controls__next"><i class="fa fa-forward"></i></a>
		</div>
		<div class="player-scrubber">
		  	<div class="player-scrubber__fill"></div>
		  	<div class="player-scrubber-handle"></div>
		</div>
		<div class="player-time">
		  	<div class="player-time__played">0:00</div>
		  	<div class="player-time__duration">-:--</div>
		</div>
	</div>
</div>
<?php
	} // End if slide is not empty
?>