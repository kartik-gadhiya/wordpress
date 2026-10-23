<?php
/**
 * Single Product Rating
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/rating.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>

<?php
	global $product;

	$rating = $product->get_average_rating();
	$review_count = $product->get_review_count();

	$full_stars = floor($rating);
	$half_star  = ($rating - $full_stars) >= 0.5 ? 1 : 0;
	$empty_stars = 5 - $full_stars - $half_star;

	echo '<div class="star pb-3">';

	// Full stars
	for ( $i = 0; $i < $full_stars; $i++ ) {
		echo '<a href="#"><i class="fas fa-star"></i></a>';
	}

	// Half star
	if ( $half_star ) {
		echo '<a href="#"><i class="fas fa-star-half-alt"></i></a>';
	}

	// Empty stars
	for ( $i = 0; $i < $empty_stars; $i++ ) {
		echo '<a href="#"><i class="far fa-star"></i></a>';
	}

	// Review count
	if ( $review_count > 0 ) {
		echo '<span>(' . esc_html( $review_count ) . ' Customer Review' . ( $review_count > 1 ? 's' : '' ) . ')</span>';
	}

	echo '</div>';
?>


