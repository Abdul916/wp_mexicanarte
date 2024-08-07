<?php
	$widget_id = $this->get_id();
	$slides = $this->get_settings('slides');
	
	if(!empty($slides))
	{
		//Get all settings
		$settings = $this->get_settings();
?>
<div class="flip-slide-container">
	<div class="container">
		<ul class="gallery">
<?php
		foreach ($slides as $slide) 
		{
?>
		<li onclick="void(0)">
			<div class="flip">
				<div class="front-side" style="background-image:url(<?php echo esc_url($slide['slide_image']['url']); ?>);"></div>
				<div class="back-side">
					<?php
					 	if(!empty($slide['slide_link']['url']))
					 	{
					 		$target = $slide['slide_link']['is_external'] ? 'target="_blank"' : '';
					?>
					<a class="split-slick-slide-link" href="<?php echo esc_url($slide['slide_link']['url']); ?>" <?php echo esc_attr($target); ?>>
					<?php
						}
					?>
						<div class="content">
							<div class="text">
								<?php
									if(!empty($slide['slide_title']))
									{
								?>
						          <h2><?php echo esc_html($slide['slide_title']); ?></h2>
								<?php
									}
								?>
								<?php
									if(!empty($slide['slide_description']) OR !empty($slide['slide_link_title']))
									{
								?>
								<p class="paragraph">
									<?php echo esc_html($slide['slide_description']); ?>
									<?php 
										if(!empty($slide['slide_link_title']) && !empty($slide['slide_link']['url']))
										{
									?>
									<div class="flip-slide-content-link"><?php echo esc_html($slide['slide_link_title']); ?></div>
									<?php
										}
									?>
								</p>
								<?php
							        }
							    ?>
							</div>
						</div>
					<?php
					 	if(!empty($slide['slide_link']['url']))
					 	{
					 		$target = $slide['slide_link']['is_external'] ? 'target="_blank"' : '';
					?>
					</a>
					<?php
						}
					?>
				</div>
			</div>
      	</li>
<?php
		}
?>
		</ul>
	</div>
</div>
<?php
	}
?>