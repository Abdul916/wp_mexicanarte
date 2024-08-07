<?php
/**
 * The main template file for display page.
 *
 * @package WordPress
*/

//Check if single attachment page
if($post->post_type == 'attachment')
{
	get_template_part("single-attachment");
	die;
}

/**
*	Get Current page object
**/
if(!is_null($post))
{
	$page_obj = get_page($post->ID);
}

$current_page_id = '';

/**
*	Get current page id
**/

if(!is_null($post) && isset($page_obj->ID))
{
    $current_page_id = $page_obj->ID;
}

get_header(); 
?>

<?php
    $is_current_user = false;
    $is_learn_press_profile = false;
    
    if(class_exists('LP_Global'))
    {
    	$profile = LP_Global::profile();
    	$is_current_user = $profile->is_current_user();
    	$is_learn_press_profile = learn_press_is_profile();
    }

    //Check if not enrolling course
    if(!isset($_GET['redirect_to']))
    {
	    if(isset($profile) && is_object($profile))
	    {
		    $user = $profile->get_user();
		    $profile_email = $user->get_email();
			$obj_user = get_user_by('email', $profile_email);
		}
		else
		{
			$obj_user = '';
		}
	    
		if($is_current_user OR !$is_learn_press_profile OR !is_object($obj_user))
		{
			get_template_part("/templates/template-header");
		}
		else
		{
			get_template_part("/templates/template-profile-header");
		}
	}
	else
	{
		get_template_part("/templates/template-header");
	}
?>
    <div class="inner">
    	<!-- Begin main content -->
    	<div class="inner-wrapper">
    		<div class="sidebar-content fullwidth">
    		<?php
    		if ( have_posts() && ($is_current_user OR !$is_learn_press_profile OR !is_object($obj_user)) ) {
    		    while ( have_posts() ) : the_post(); ?>		
    	
    		    <?php 
	    		    the_content(); 
	    		    break;  
	    		?>
	
	    		<?php endwhile; 
	    		
	    		wp_link_pages(
	    			array(
						'before'           => '<br class="clear"/><p>' . esc_html__( 'Pages:', 'avante' ),
						'after'            => '</p>',
					)
				);
    		}
    		
			//If enrolling course
			if(isset($_GET['redirect_to']))
			{
				 if(!is_user_logged_in() && function_exists('learn_press_get_template'))
				 {
				 	learn_press_get_template( 'global/form-login.php');
				 	learn_press_get_template( 'global/form-register.php');
				 }
			}
			
			if(!is_object($obj_user) && !is_object($obj_user))
			{
				if(function_exists('learn_press_get_template') && $is_learn_press_profile)
				{
				 	learn_press_get_template( 'global/form-login.php');
				 	learn_press_get_template( 'global/form-register.php');
				}
			}

			if (comments_open($post->ID)) 
			{
			?>
			<div class="fullwidth-comment-wrapper theme-border"><?php comments_template( '', true ); ?></div>
			<?php
			}
			else
			{
			?>
			<div class="comment_disable_clearer"></div>
			<?php
			}
			?>
    		</div>
    	</div>
    	<!-- End main content -->
    </div>
</div>
<?php get_footer(); ?>