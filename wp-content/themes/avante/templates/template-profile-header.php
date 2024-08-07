<?php
	$profile = LP_Global::profile();
	$user = $profile->get_user();
	$profile_email = $user->get_email();
	$obj_user = get_user_by('email', $profile_email);
?>
<div id="page-header">
	<div class="page-title-wrapper">
		<div class="standard-wrapper">
			<div class="page-title-inner">
				<?php
					$tg_page_title_font_alignment = get_theme_mod('tg_page_title_font_alignment', 'left');
				?>
				<div class="page-title-content title_align_<?php echo esc_attr($tg_page_title_font_alignment); ?>">
					<div class="profile-avatar"><?php echo stripslashes($user->get_profile_picture()); ?></div>
					<div class="profile-name">
						<h1><?php echo esc_attr($user->get_display_name()); ?></h1>
					</div>
					<br class="clear"/>
					<div class="profile-description">
						<?php echo esc_html($user->get_description()); ?>
						<br class="clear"/>
						<div class="profile-course-count">
							<span class="ti-agenda"></span>
							<span class="profile-course-count-number">
								<?php 
									$profile-course-count = count_user_posts($obj_user->ID, 'lp_course');
									
									echo intval($profile-course-count).' '; 
									
									if($profile-course-count > 1)
									{
										echo esc_html_e('Course', 'avante' );
									}
									else
									{
										echo esc_html_e('Courses', 'avante' );	
									}
								?>
							</span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Begin content -->
<div id="page-content-wrapper">
		<?php
			//Include course grid template file
			get_template_part("/templates/template-course-grid");	

			$wp_query = avante_get_wp_query();
			if($wp_query->max_num_pages > 1)
			{
				if (function_exists("avante_pagination")) 
				{
				    avante_pagination($wp_query->max_num_pages, 4, 'course-posts-grid' );
				}
				else
				{
		?>
			    	<div class="pagination"><p><?php posts_nav_link(''); ?></p></div>
		<?php
			    }
		?>
				<div class="pagination-detail">
				    <?php esc_html_e('Page', 'avante' ); ?> <?php echo esc_html($paged); ?> <?php esc_html_e('of', 'avante' ); ?> <?php echo esc_html($wp_query->max_num_pages); ?>
				</div>
		<?php
			}
		?>
	</div>