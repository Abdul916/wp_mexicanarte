<?php
/**
 * Template for displaying rating stars.
 *
 *
 * @author ThemeGoods
 * version  1.0
 */

// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

$percent = ( ! $rated ) ? 0 : min( 100, ( round( $rated * 2 ) / 2 ) * 20 );
?>
<div class="review-stars-rated">
    <div class="review-stars empty"></div>
    <div class="review-stars filled" style="width:<?php echo intval($percent); ?>%;"></div>
</div>