<?php
	$widget_id = $this->get_id();
	
	//Get all settings
	$settings = $this->get_settings();
	
	if($settings['price_switching'] == 'yes')
	{
?>
<div class="pricing-plan-switch-wrap">
	<span class="pricing-plan-switch-month"><?php echo __( 'Bill month', 'avante-elementor' ); ?></span>
	<input type="checkbox" id="pricing-plan-switch" class="js-switch" data-switch-bg="<?php echo esc_attr($settings['switching_bg_color']); ?>" data-switch-button="<?php echo esc_attr($settings['switching_button_color']); ?>" />
	<span class="pricing-plan-switch-year"><?php echo __( 'Bill yearly', 'avante-elementor' ); ?></span>
</div>
<?php
	}
?>

<div class="pricing-table-container">
<?php
	$slides = $this->get_settings('slides');
	$count_slides = count($slides);
	
	if(!empty($slides))
	{		
		//Get entrance animation option
		$smoove_animation_attr = '';
		switch($settings['entrance_animation'])
		{
			case 'slide-up':
			default:
				$smoove_animation_attr = 'data-move-y="60px"';
				
			break;
			
			case 'popout':
				$smoove_animation_attr = 'data-scale="0"';
				
			break;
			
			case 'fade-in':
				$smoove_animation_attr = 'data-opacity="0"';
				
			break;
		}
		
		$column_class = 3;
		
		//Start displaying gallery columns
		switch($settings['columns']['size'])
		{
			case 1:
		   		$column_class = 'avante-one-col';
		   	break;
		   	
			case 2:
		   		$column_class = 'avante-two-cols';
		   	break;
		   	
		   	case 3:
		   	default:
		   		$column_class = 'avante-three-cols';
		   	break;
		   	
		   	case 4:
		   		$column_class = 'avante-four-cols';
		   	break;
		   	
		   	case 5:
		   		$column_class = 'avante-five-cols';
		   	break;
		   	
		   	case 6:
		   		$column_class = 'tg_six_cols';
		   	break;
		}
?>
<div class="pricing-table-content-wrapper layout-<?php echo esc_attr($column_class); ?> <?php echo esc_attr($spacing_class); ?>" data-cols="<?php echo esc_attr($settings['columns']['size']); ?>">
	
<?php		
		$animation_class = '';
		if(isset($settings['disable_animation']))
		{
			$animation_class = 'disable_'.$settings['disable_animation'];
		}
		
		$smoove_min_width = 1;
		switch($settings['disable_animation'])
		{
			case 'none':
				$smoove_min_width = 1;
			break;
			
			case 'tablet':
				$smoove_min_width = 769;
			break;
			
			case 'mobile':
				$smoove_min_width = 415;
			break;
			
			case 'all':
				$smoove_min_width = 5000;
			break;
		}
	
		$last_class = '';
		$count = 1;
		
		foreach ( $slides as $slide ) 
		{
			$last_class = '';
			if($count%$settings['columns']['size'] == 0)
			{
				$last_class = 'last';
			}
			
			//Calculation for animation queue
			if(!isset($queue))
			{
				$queue = 1;	
			}
			
			if($queue > $settings['columns']['size'])
			{
				$queue = 1;
			}
			
			//Check featured pricing plan
			$featured_pricing_plan = '';
			if(isset($slide['slide_featured']) && $slide['slide_featured'] == 'yes')
			{
				$featured_pricing_plan = 'featured-pricing-plan';
			}
?>
		<div class="pricing-table-wrapper <?php echo esc_attr($column_class); ?> <?php echo esc_attr($last_class); ?>  pricing-<?php echo esc_attr($count); ?> tile scale-anm all smoove <?php echo esc_attr($animation_class); ?> <?php echo esc_attr($featured_pricing_plan); ?> <?php echo esc_attr($settings['entrance_animation']); ?>" data-delay="<?php echo intval($queue*150); ?>" <?php echo $smoove_animation_attr; ?>>
			<div class="inner-wrap">
				<div class="overflow-inner">
					<div class="pricing-plan-wrap">
						<h2 class="pricing-plan-title"><?php echo esc_html($slide['slide_title']); ?></h2>
						
						<div class="pricing-plan-price-wrap">
							<h3 class="pricing-plan-price" data-price-month="<?php echo esc_attr($slide['slide_price_month']); ?>" data-price-year="<?php echo esc_attr($slide['slide_price_year']); ?>"><?php echo esc_attr($slide['slide_price_month']); ?></h3>
							<span class="pricing-plan-unit-month">/<?php echo __( 'Month', 'avante-elementor' ); ?></span>
							<span class="pricing-plan-unit-year hide">/<?php echo __( 'Year', 'avante-elementor' ); ?></span>
						</div>
					</div>
					
					<div class="pricing-plan-content">
						<?php 
							if(isset($slide['slide_features']) && !empty($slide['slide_features']))
							{
								$feature_lists = explode(PHP_EOL, $slide['slide_features']);
								
								if(!empty($feature_lists) && is_array($feature_lists))
								{
						?>
								<ul class="pricing-plan-content-list">
						<?php
									foreach($feature_lists as $feature_list)
									{
						?>
									<li><?php echo esc_html($feature_list); ?></li>
						<?php
									}
						?>
								</ul>
						<?php
								}
							}
						?>
						
						<?php 
							if(isset($slide['slide_button_title']) && !empty($slide['slide_button_title']))
							{
						?>
							<a class="pricing-plan-button button" href="<?php echo esc_url($slide['slide_button_link']['url']); ?>"><?php echo esc_html($slide['slide_button_title']); ?></a>
						<?php
							}
						?>
					</div>
				</div>
			</div>
		</div>
<?php
			$count++;
			$queue++;
		}
?>
<br class="clear"/>
</div>
<?php
	}
?>
</div>