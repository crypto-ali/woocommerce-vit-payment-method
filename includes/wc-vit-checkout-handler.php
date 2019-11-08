<?php
/**
 * WC_VIT_Checkout_Handler
 *
 * @package WooCommerce VIT Payment Method
 * @category Class Handler
 * @authors crypto-ali, AnatoliyStrizhak, sagescrub, ReCrypto
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

class WC_VIT_Checkout_Handler {

	public static function init() {
		$instance = __CLASS__;

		add_action('wp_enqueue_scripts', array($instance, 'enqueue_scripts'));
	}

	public static function enqueue_scripts() {
		// Plugin
		//wp_enqueue_script('wc-vit', WC_VIT_DIR_URL . '/assets/js/plugin.js', array('jquery'), WC_VIT_VERSION);

		// Localize plugin script data
		wp_localize_script('wc-vit', 'wc_vit', array(
			'cart' => array(
				'base_currency' => wc_vit_get_base_fiat_currency(),
				'amounts' => WC_VIT::get_amounts(),
			),
		));


        function add_checkout_script() {
        ?>
            <script type="text/javascript">
            //jQuery(document).on( "updated_checkout", function(){

            //    jQuery("#place_order").click(function() {
            //        window.open('https://touchit.social', '_blank');
            //    });
            //});

        </script>

        <?php
        }

        add_action( 'woocommerce_after_checkout_form', 'add_checkout_script' );
    }
}

WC_VIT_Checkout_Handler::init();

