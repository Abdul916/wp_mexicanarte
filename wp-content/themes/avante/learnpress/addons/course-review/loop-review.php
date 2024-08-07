<?php
/**
 * Template for displaying loop course review.
 *
 *
 * @author ThemeGoods
 * version  1.0
 */

// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;
?>

<li>
<?php #var_dump($review); ?>
    <div class="review-author">
		<?php echo get_avatar( $review->user_email ) ?>
		
		<div class="review-author-info">
			<span class="review-time"><?php echo avante_get_comment_time($review->comment_id); ?></span>
			
	        <h4 class="user-name">
				<?php do_action( 'learn_press_before_review_username' ); ?>
				<?php echo esc_html($review->display_name); ?>
				<?php do_action( 'learn_press_after_review_username' ); ?>
	        </h4>
	    </div>
    </div>
    <div class="review-text">
        <div class="review-content">
	        <?php learn_press_course_review_template( 'rating-stars.php', array( 'rated' => $review->rate ) ); ?>
	        <div class="review-title">
				<?php do_action( 'learn_press_before_review_title' ); ?>
				<?php echo esc_html($review->title); ?>
				<?php do_action( 'learn_press_after_review_title' ); ?>
	        </div>
	        
			<?php do_action( 'learn_press_before_review_content' ); ?>
			<?php echo esc_html($review->content); ?>
			<?php do_action( 'learn_press_after_review_content' ); ?>
        </div>
    </div>
</li>