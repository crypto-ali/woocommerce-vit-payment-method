<?php
/**
 * Plugin Name: VIT Payment Method for WooCommerce
 * Plugin URI: https://github.com/crypto-ali/woocommerce-vit-payment-method
 * Description: Accept VIT payments directly to your shop (Currencies: VIT).
 * Version: 1.0.0
 * Author: <a href="https://github.com/crypto-ali/woocommerce-vit-payment-method">crypto-ali</a>, <a href="https://github.com/AnatoliyStrizhak/whaleshares">AnatoliyStrizhak</a>, <a href="https://github.com/sagescrub/woocommerce-steem-payment-method">sagescrub</a>, ReCrypto
 * Requires at least: 4.1
 * Tested up to: 5.3
 *
 * WC requires at least: 3.1
 * WC tested up to: 3.8
 *
 * Text Domain: wc-vit-payment-method
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

define('WC_VIT_VERSION', '1.0');
define('WC_VIT_DIR_PATH', trailingslashit(plugin_dir_path(__FILE__)));
define('WC_VIT_DIR_URL', trailingslashit(plugin_dir_url(__FILE__)));

register_activation_hook(__FILE__, 'wc_vit_activate');
register_deactivation_hook(__FILE__, 'wc_vit_deactivate');

/** 
 * Plugin activation
 *
 * @since 1.0.0
 */
function wc_vit_activate() {
	do_action('wc_vit_activated');

	$settings = get_option('woocommerce_wc_vit_settings', array());

	if ( ! isset($settings['accepted_currencies'])) {
		$settings['accepted_currencies'] = array(
			'VIT',
		);
	}

	update_option('woocommerce_wc_vit_settings', $settings);

	// Make sure to have fresh currency rates
	update_option('wc_vit_rates', array());
}

/**
 * Plugin deactivation
 *
 * @since 1.0.0
 */
function wc_vit_deactivate() {
	do_action('wc_vit_deactivated');

	// Make sure to have fresh currency rates
	//update_option('wc_vit_rates', array());
}

/**
 * Plugin init
 * 
 * @since 1.0.0
 */
function wc_vit_init() {

	/**
	 * Fires before including the files
	 *
	 * @since 1.0.0
	 */
	do_action('wc_vit_pre_init');

	require_once(WC_VIT_DIR_PATH . 'libraries/wordpress.php');
	require_once(WC_VIT_DIR_PATH . 'libraries/woocommerce.php');

	require_once(WC_VIT_DIR_PATH . 'includes/wc-vit-functions.php');
	require_once(WC_VIT_DIR_PATH . 'includes/class-wc-vit.php');
	require_once(WC_VIT_DIR_PATH . 'includes/class-wc-vit-transaction-transfer.php');

	require_once(WC_VIT_DIR_PATH . 'includes/class-wc-gateway-vit.php');

	require_once(WC_VIT_DIR_PATH . 'includes/wc-vit-handler.php');
	require_once(WC_VIT_DIR_PATH . 'includes/wc-vit-cart-handler.php');
	require_once(WC_VIT_DIR_PATH . 'includes/wc-vit-checkout-handler.php');
	require_once(WC_VIT_DIR_PATH . 'includes/wc-vit-order-handler.php');
	require_once(WC_VIT_DIR_PATH . 'includes/wc-vit-product-handler.php');

	/**
	 * Fires after including the files
	 *
	 * @since 1.0.0
	 */
	do_action('wc_vit_init');
}
add_action('plugins_loaded', 'wc_vit_init');



/**
 * Register "WooCommerce vit" as payment gateway in WooCommerce
 *
 * @since 1.0.0
 *
 * @param array $gateways
 * @return array $gateways
 */
function wc_vit_register_gateway($gateways) {
	$gateways[] = 'WC_Gateway_VIT';

	return $gateways;
}
add_filter('woocommerce_payment_gateways', 'wc_vit_register_gateway');
