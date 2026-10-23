<?php
/**
 * Product quantity inputs
 *
 * @package WooCommerce\Templates
 * @version 10.1.0
 */

defined( 'ABSPATH' ) || exit;

/* translators: %s: Quantity. */
$label = ! empty( $args['product_name'] ) ? sprintf( esc_html__( '%s quantity', 'finspire' ), wp_strip_all_tags( $args['product_name'] ) ) : esc_html__( 'Quantity', 'finspire' );
?>
<div class="cart-wrp">
	<div class="cart-quantity">
		<div id="myform" class="quantity"> 
			<?php do_action( 'woocommerce_before_quantity_input_field' ); ?>

			<label class="screen-reader-text" for="<?php echo esc_attr( $input_id ); ?>">
				<?php echo esc_attr( $label ); ?>
			</label>

			<!-- Quantity Input Field -->
			<input
				type="<?php echo esc_attr( $type ); ?>"
				<?php echo $readonly ? 'readonly="readonly"' : ''; ?>
				id="<?php echo esc_attr( $input_id ); ?>"
				class="qty <?php echo esc_attr( join( ' ', (array) $classes ) ); ?>"
				name="<?php echo esc_attr( $input_name ); ?>"
				value="<?php echo esc_attr( $input_value ); ?>"
				aria-label="<?php esc_attr_e( 'Product quantity', 'finspire' ); ?>"
				<?php if ( in_array( $type, array( 'text', 'search', 'tel', 'url', 'email', 'password' ), true ) ) : ?>
					size="4"
				<?php endif; ?>
				min="<?php echo esc_attr( $min_value ); ?>"
				max="<?php echo esc_attr( 0 < $max_value ? $max_value : '' ); ?>"
				<?php if ( ! $readonly ) : ?>
					step="<?php echo esc_attr( $step ); ?>"
					placeholder="<?php echo esc_attr( $placeholder ); ?>"
					inputmode="<?php echo esc_attr( $inputmode ); ?>"
					autocomplete="<?php echo esc_attr( isset( $autocomplete ) ? $autocomplete : 'on' ); ?>"
				<?php endif; ?>
			/>

			<?php do_action( 'woocommerce_after_quantity_input_field' ); ?>
		</div>
	</div>
</div>
