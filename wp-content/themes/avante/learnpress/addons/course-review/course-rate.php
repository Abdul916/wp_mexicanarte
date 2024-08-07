<?php
/**
 * Template for displaying course rate.
 *
 *
 * @author ThemeGoods
 * version  1.0
 */

// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

$course_id       = get_the_ID();
$course_rate_res = learn_press_get_course_rate( $course_id, false );
$course_rate     = $course_rate_res['rated'];
$total           = $course_rate_res['total'];
?>

<div class="course-rate">
	<div class="course_rate_summary">
	    <div class="review-number">
			<?php do_action( 'learn_press_before_total_review_number' ); ?>
			<?php echo number_format($course_rate, 1); ?>
			<?php do_action( 'learn_press_after_total_review_number' ); ?>
	    </div>
	    <?php
		learn_press_course_review_template( 'rating-stars.php', array( 'rated' => $course_rate ) );
		?>
		<div class="course_rating_title"><?php esc_html_e( 'Course Rating', 'avante' ); ?></div>
	</div>
    <div class="course_rate_breakdown">
		<?php
		if ( isset( $course_rate_res['items'] ) && ! empty( $course_rate_res['items'] ) ):
			foreach ( $course_rate_res['items'] as $item ):
			
			$star_width = $item['rated']*20;
		?>
                <div class="course-rate">
                    <div class="review-bar">
                        <div class="rating" style="width:<?php echo intval($item['percent']); ?>% "></div>
                    </div>
                    <span class="review-stars-rated">
					    <span class="review-stars empty"></span>
					    <span class="review-stars filled" style="width:<?php echo intval($star_width); ?>%;"></span>
					</span>
                    <span class="review-percent"><?php echo esc_html( $item['percent'] ); ?>%</span>
                </div>
			<?php
			endforeach;
		endif;
		?>
    </div>
</div>
