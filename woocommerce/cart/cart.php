<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

wc_print_notices();

do_action( 'woocommerce_before_cart' ); ?>

<form class="woocommerce-cart-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
	<?php do_action( 'woocommerce_before_cart_table' ); ?>

	<table class="shop_table shop_table_responsive cart woocommerce-cart-form__contents" cellspacing="0">
		<thead>
			<tr>
				<th class="product-remove"><?php _e( 'Remove', 'classify' ); ?></th>
				<th class="product-price"><?php _e( 'Price', 'classify' ); ?></th>
				<th class="product-price"><?php _e( 'Details', 'classify' ); ?></th>
				<th class="product-quantity"><?php _e( 'Quantity', 'classify' ); ?></th>
				<th class="product-subtotal"><?php _e( 'Total', 'classify' ); ?></th>				
			</tr>
		</thead>
		<tbody>
			<?php do_action( 'woocommerce_before_cart_contents' ); ?>

			<?php
			foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
				$classifyCustomData = $cart_item['wdm_user_custom_data_value'];
				//echo "shabir";
				//print_r($classifyCustomData);
				$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
				$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

				if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
					$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
					?>
					<tr class="woocommerce-cart-form__cart-item <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">

						<td class="product-remove">
							<?php
								echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf(
									'<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s">&times;</a>',
									esc_url( WC()->cart->get_remove_url( $cart_item_key ) ),
									__( 'Remove this item', 'classify' ),
									esc_attr( $product_id ),
									esc_attr( $_product->get_sku() )
								), $cart_item_key );
							?>
						</td>
						<td class="product-price" data-title="<?php esc_attr_e( 'Price', 'classify' ); ?>">
							<?php
								echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
							?>
						</td>
						<td class="product-price" data-title="<?php esc_attr_e( 'Details', 'classify' ); ?>">
							<?php 
							if(isset($classifyCustomData['days_to_expire'])){
								$days_to_expire = $classifyCustomData['days_to_expire'];
							}else{
								$days_to_expire = NULL;
							}
							foreach( $classifyCustomData as $key => $val ){	
								if(empty($days_to_expire)){
									if($key == 'plan_name'){ ?>
										<strong><?php esc_html_e('Plan name', 'classify'); ?> :&nbsp;<?php echo $val; ?></strong><br>
										<?php
									}
									if($key == 'total_featured'){ ?>
										<strong><?php esc_html_e('Total Featured Ads', 'classify'); ?> :&nbsp;<?php echo $val; ?></strong><br>
										<?php
									}
									if($key == 'total_regular'){ ?>
										<strong><?php esc_html_e('Total Regular Ads', 'classify'); ?> :&nbsp;<?php echo $val; ?></strong><br>
										<?php
									}
									if($key == 'plan_time'){ ?>
										<strong><?php esc_html_e('Ads will be featured for', 'classify'); ?> :&nbsp;<?php echo $val; ?></strong><br>
										<?php
									}
								}else{
									if($key == 'post_id'){ ?>
										<strong><?php esc_html_e('Your post ID', 'classify'); ?> : <?php echo $val; ?></strong><br>
										<?php
									}
									if($key == 'post_title'){ ?>
										<strong><?php esc_html_e('You are going to pay featured this post', 'classify'); ?> : <?php echo $val; ?></strong><br>
										<?php
									}
									if($key == 'days_to_expire'){ ?>
										<strong><?php esc_html_e('Your Post will be featured for', 'classify'); ?> : <?php echo $val; ?>&nbsp;<?php esc_html_e('days', 'classify'); ?></strong><br>
										<?php
									}
								}
							}
							?>							
							<p><strong><?php esc_html_e('Note: Dont update Quantity from here.', 'classify'); ?></strong></p>
						</td>

						<td class="product-quantity" data-title="<?php esc_attr_e( 'Quantity', 'classify' ); ?>">
							<?php
								if ( $_product->is_sold_individually() ) {
									$product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
								} else {
									$product_quantity = woocommerce_quantity_input( array(
										'input_name'  => "cart[{$cart_item_key}][qty]",
										'input_value' => $cart_item['quantity'],
										'max_value'   => $_product->get_max_purchase_quantity(),
										'min_value'   => '0',
									), $_product, false );
								}

								echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item );
							?>
						</td>

						<td class="product-subtotal" data-title="<?php esc_attr_e( 'Total', 'classify' ); ?>">
							<?php
								echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key );
							?>
						</td>
					</tr>
					<?php
				}
			}
			?>

			<?php do_action( 'woocommerce_cart_contents' ); ?>

			<tr>
				<td colspan="6" class="actions">

					<?php if ( wc_coupons_enabled() ) { ?>
						<div class="coupon">
							<label for="coupon_code"><?php _e( 'Coupon:', 'classify' ); ?></label> <input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="<?php esc_attr_e( 'Coupon code', 'classify' ); ?>" /> <input type="submit" class="button" name="apply_coupon" value="<?php esc_attr_e( 'Apply coupon', 'classify' ); ?>" />
							<?php do_action( 'woocommerce_cart_coupon' ); ?>
						</div>
					<?php } ?>

					<input type="submit" class="button" name="update_cart" value="<?php esc_attr_e( 'Update cart', 'classify' ); ?>" />

					<?php do_action( 'woocommerce_cart_actions' ); ?>

					<?php wp_nonce_field( 'woocommerce-cart' ); ?>
				</td>
			</tr>

			<?php do_action( 'woocommerce_after_cart_contents' ); ?>
		</tbody>
	</table>
	<?php do_action( 'woocommerce_after_cart_table' ); ?>
</form>

<div class="cart-collaterals">
	<?php
		/**
		 * woocommerce_cart_collaterals hook.
		 *
		 * @hooked woocommerce_cross_sell_display
		 * @hooked woocommerce_cart_totals - 10
		 */
	 	do_action( 'woocommerce_cart_collaterals' );
	?>
</div>

<?php do_action( 'woocommerce_after_cart' ); ?>
