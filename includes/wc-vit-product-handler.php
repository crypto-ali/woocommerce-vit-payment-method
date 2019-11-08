<?php
/**
 * WC_VIT_Product_Handler
 *
 * @package WooCommerce VIT Payment Method
 * @category Class Handler
 * @authors crypto-ali, AnatoliyStrizhak, sagescrub, ReCrypto
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

class WC_VIT_Product_Handler {

	/**
	 * Initialize
	 *
	 * @since 1.0.0
	 */
	public static function init() {
		$instance = __CLASS__;

		if (wc_vit_get_setting('show_insightful') == 'yes') {
			add_action('woocommerce_after_shop_loop_item_title', array($instance, 'display_single_product_prices'), 15);
			add_action('woocommerce_single_product_summary', array($instance, 'display_single_product_prices'), 15);

			add_filter('woocommerce_available_variation', array($instance, 'available_variation_prices'), 10, 3);
		}
	}

	/**
	 * Display prices in single product in different accepted vit currencies
	 *
	 * @since 1.0.0
	 */
	public static function display_single_product_prices() {
		global $product;

		self::display_prices($product);
	}

	/**
	 * Display prices in different accepted vit currencies
	 *
	 * @since 1.0.0
	 */
	public static function display_prices($product = null) {
		$from_currency_symbol = wc_vit_get_currency_symbol(); ?>

		<?php if ($currencies = wc_vit_get_accepted_currencies()) : ?>
			<div class="wc-vit wc-vit-prices">

				<?php if ($product->get_type() == 'variable') : ?>
					<?php $prices = $product->get_variation_prices(true); ?>

					<?php if ( ! empty($prices['price'])) : ?>
						<?php
							$min_price     = (float) current( $prices['price'] );
							$max_price     = (float) end( $prices['price'] );
							$min_reg_price = (float) current( $prices['regular_price'] );
							$max_reg_price = (float) end( $prices['regular_price'] ); 
						?>

						<?php foreach ($currencies as $to_currency_symbol) : ?>
							<?php if ($min_price !== $max_price) : ?>
								<div class="wc-vit-price">
									<?php self::display_price_range(
										wc_vit_rate_convert($min_price, $from_currency_symbol, $to_currency_symbol),
										wc_vit_rate_convert($max_price, $from_currency_symbol, $to_currency_symbol),
										$to_currency_symbol
									); ?>
								</div>
							<?php elseif ($product->is_on_sale() && $min_reg_price === $max_reg_price) : ?>
								<div class="wc-vit-price">
								<?php self::display_price_sale(
										wc_vit_rate_convert($min_reg_price, $from_currency_symbol, $to_currency_symbol),
										wc_vit_rate_convert($max_reg_price, $from_currency_symbol, $to_currency_symbol),
										$to_currency_symbol
									); ?>
								</div>
							<?php else : ?>
								<div class="wc-vit-price">
									<?php self::display_price(wc_vit_rate_convert($min_price, $from_currency_symbol, $to_currency_symbol), $to_currency_symbol); ?>
								</div>
							<?php endif; ?>
						<?php endforeach; ?>
					<?php endif; ?>

				<?php else : ?>

					<?php if ($product->get_price() > 0) : ?>
						<?php if ($product->is_on_sale()) : ?>
							<?php foreach ($currencies as $to_currency_symbol) : ?>
								<div class="wc-vit-price">
									<?php self::display_price_sale(
										wc_vit_rate_convert($product->get_regular_price(), $from_currency_symbol, $to_currency_symbol), 
										wc_vit_rate_convert($product->get_price(), $from_currency_symbol, $to_currency_symbol),
										$to_currency_symbol); 
									?>
								</div>
							<?php endforeach; ?>
						<?php else : ?>
							<?php foreach ($currencies as $to_currency_symbol) : ?>
								<div class="wc-vit-price">
									<?php self::display_price(wc_vit_rate_convert($product->get_price(), $from_currency_symbol, $to_currency_symbol), $to_currency_symbol); ?>
								</div>
							<?php endforeach; ?>
						<?php endif; ?>
					<?php endif; ?>
				<?php endif; ?>
			</div>
		<?php endif; ?>

		<?php
	}

	/**
	 * Attach the vit currency prices to a variation
	 *
	 * @since 1.0.0
	 * @param array $data
	 * @param WC_Product $product
	 * @param WC_Product_Variation $variaton
	 * @return array $data
	 */
	public static function available_variation_prices($data, $product, $variation) {

		ob_start();
		self::display_prices($variation);
		$prices_html = ob_get_contents();
		ob_end_clean();

		if (isset($prices_html)) {
			$data['prices_html'] = $prices_html;
		}

		return $data;
	}

	/**
	 * Display price
	 *
	 * @since 1.0.0
	 * @param float $price
	 * @param string $currency_symbol
	 * @return void
	 */
	public static function display_price($price, $currency_symbol) { ?>
		<span class="wc-vit-price-amount <?php echo sanitize_title(sprintf('wc-vit-price-%s', $currency_symbol)); ?>">
			<strong><?php echo $price; ?></strong>
			<?php if ( $currency_symbol ) { ?>						 
			<span class="wc-vit-price-amount-symbol"><?php echo $currency_symbol; ?></span>
			<?php } ?> 
		</span>
		<?php
	}

	/**
	 * Display price range
	 *
	 * @since 1.0.0
	 * @param float $min_price
	 * @param float $max_price
	 * @param string $currency_symbol
	 * @return void
	 */
	public static function display_price_range($min_price, $max_price, $currency_symbol) {
		echo self::display_price($min_price, $currency_symbol);
			echo '&ndash;';
		echo self::display_price($max_price, $currency_symbol);
	}

	/**
	 * Display price sale
	 *
	 * @since 1.0.0
	 * @param float $regular_price
	 * @param float $sale_price
	 * @param string $currency_symbol
	 * @return void
	 */
	public static function display_price_sale($regular_price, $sale_price, $currency_symbol) { ?>
		<ins>
			<?php self::display_price($sale_price, $currency_symbol); ?>
		</ins>
		
		<?php if (wc_vit_get_setting('show_discounted_price') == 'yes') { ?>
		<del>
			<?php self::display_price($regular_price, $currency_symbol); ?>
		</del>
		<?php }	?>

		<?php
	}
}

WC_VIT_Product_Handler::init();