<?php
/**
 * Template for displaying main user profile page.
 *
 * @author   ThemeGoods
 * @package  Learnpress/Templates
 * @version  3.0.0
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();

$profile = LP_Global::profile();

if ( $profile->is_public() ) {
	
	//Get current user
	$is_current_user = $profile->is_current_user();
?>

    <div id="learn-press-user-profile"<?php $profile->main_class(); ?>>

	<?php
	//Display dashboard if current user logged in
	if($is_current_user)
	{
		/**
		 * @since 3.0.0
		 */
		do_action( 'learn-press/before-user-profile', $profile );

		/**
		 * @since 3.0.0
		 */
		do_action( 'learn-press/user-profile', $profile );

		/**
		 * @since 3.0.0
		 */
		do_action( 'learn-press/after-user-profile', $profile );
	}
	?>

    </div>

<?php } else {
	_e( 'This user does not public their profile.', 'avante' );
}