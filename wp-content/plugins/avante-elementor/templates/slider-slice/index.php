<?php
	$widget_id = $this->get_id();
	$slides = $this->get_settings('slides');
	$count_slides = count($slides);
	
	if(!empty($slides))
	{
		//Get all settings
		$settings = $this->get_settings();

?>
<section class="slice-slide-container slides">
	<?php
		if($count_slides > 1)
		{
	?>
		<section class="slides-nav">
		    <nav class="slides-nav-nav">
		      	<button class="slides-nav__prev js-prev"><?php esc_html_e( 'Prev' , 'avante-elementor' ); ?></button>
			  	<button class="slides-nav__next js-next"><?php esc_html_e( 'Next' , 'avante-elementor' ); ?></button>
		    </nav>
	  	</section>
	<?php
		}
	?>
<?php
	$count = 1;
	
	foreach ($slides as $slide) 
	{
?>
	<section class="slide <?php if($count == 1) { ?>is-active<?php } ?>">
		<div class="slide-content">
			<figure class="slide-figure"><div class="slide-img" style="background-image: url(<?php echo esc_url($slide['slide_image']['url']); ?>)"></div></figure>
		
			<header class="slide-header">
			<?php 
				if(!empty($slide['slide_title']))
				{
			?>
				<h2 class="slide-title"><span class="title-line"><span><?php echo esc_html($slide['slide_title']); ?></span></span></h2>
			<?php
				}
				
			 	if(!empty($slide['slide_link']['url']))
			 	{
			 		$target = $slide['slide_link']['is_external'] ? 'target="_blank"' : '';
			?>
				<a class="slice-slide-link" href="<?php echo esc_url($slide['slide_link']['url']); ?>" <?php echo esc_attr($target); ?>></a>
			<?php
				}
			?>
			</header>
		</div>
    </section>
<?php
		$count++;
	}
?>
</section>
<?php
	}
?>