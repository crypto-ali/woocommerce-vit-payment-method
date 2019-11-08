<?php
/**
 * WC_VIT_Order_Handler
 *
 * @package WooCommerce VIT Payment Method
 * @category Class Handler
 * @authors crypto-ali, AnatoliyStrizhak, sagescrub, ReCrypto 
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

class WC_VIT_Order_Handler {

	public static function init() {
		$instance = __CLASS__;

		add_action('wc_order_vit_status', array($instance, 'default_order_vit_status'));

		add_action('woocommerce_view_order', array($instance, 'payment_details'), 5);
		add_action('woocommerce_thankyou', array($instance, 'payment_details'), 5);

	}

	public static function default_order_vit_status($status) {
		return $status ? $status : 'pending';
	}


	public static function payment_details($order_id) {
		$order = wc_get_order($order_id);

		if ($order->get_payment_method() != 'wc_vit') 
			return; ?>

		<section class="woocommerce-vit-order-payment-details">

			<h2 class="woocommerce-vit-order-payment-details__title"><?php _e( 'VIT Payment details', 'wc-vit' ); ?></h2>

                        <?php
                            if(wc_order_get_vit_status($order_id)==='pending')
                            {
                        ?>
			        <p class="woocommerce-vit-payment-memo-prompt">
                                <strong>Now you must make a transfer through your Vision Industry Token (VIT) wallet.</strong><br/><br/>

                                    Please don't forget to include the <strong>"MEMO"</strong> for this transaction in VIT wallet.
                                    Also double check <strong>"TO"</strong> and <strong>"AMOUNT"</strong> fields when making a transfer.
                                    <br/><br/><a href="https://touchit.social" id='paybutton' class='button' target='_blank'>PAY through Touchit.Social VIT Wallet</a>
                                </p>

                                <script type="text/javascript">
                                if (window.whalevault) {
                                    function hidebutton()
                                    {
                                        jQuery("#forwhalevault").hide();
                                    }


                                    window.whalevault.requestHandshake("appId", function(response) {

                                        jQuery(".woocommerce-vit-payment-memo-prompt").html('<strong>After clicking "PAY through WhaleVault" button you must "CONFIRM" a transfer in your WhaleVault extension.<br/>Double check all transfer parameters before confirming.</strong><br/><br/><span id="forwhalevault">Enter your VIT username without @<br/><input type="text" id="username"><br/><br/><a href="javascript:void(0);" id="paybutton" class="button" >PAY through WhaleVault</a></span>');

                                        jQuery("#paybutton").click(function() {

                                            var ops = [ 
                                            ['transfer', 
                                             { from: jQuery("#username").val(), 
                                                to: '<?php echo wc_order_get_vit_payee($order_id); ?>', 
                                                amount: '<?php echo number_format(wc_order_get_vit_amount($order_id), 3, '.', ''); ?> VIT', 
                                                memo: '<?php echo wc_order_get_vit_memo($order_id); ?>'
                                             }
                                            ]
                                            ];

                                            whalevault.requestSignBuffer('woocommerce_vit', 'vit:'+jQuery("#username").val(), { url: 'https://peer.vit.tube/', operations: ops }, 'Active', 'transfer', 'tx', function(response) { hidebutton(); });
                                        });
                                    });
                                }
                                </script>


                        <?php
                            }
                        ?>


			
			<table class="woocommerce-table woocommerce-table--vit-order-payment-details shop_table vit_order_payment_details">
				<tbody>
					<tr>
						<th><?php _e('To', 'wc-vit'); ?></th>
						<td id='to'><?php echo wc_order_get_vit_payee($order_id); ?></td>
					</tr>
					<tr>
						<th><?php _e('Memo', 'wc-vit'); ?></th>
						<td id='memo'><?php echo wc_order_get_vit_memo($order_id); ?></td>
					</tr>
					<tr>
						<th><?php _e('Amount', 'wc-vit'); ?></th>
						<td id='amount'><?php echo wc_order_get_vit_amount($order_id); ?></td>
					</tr>
					<tr>
						<th><?php _e('Currency', 'wc-vit'); ?></th>
						<td><?php echo wc_order_get_vit_amount_currency($order_id); ?></td>
					</tr>
					<tr>
						<th><?php _e('Status', 'wc-vit'); ?></th>
						<td><?php echo wc_order_get_vit_status($order_id); ?></td>
					</tr>
				</tbody>
			</table>

			<?php do_action( 'wc_vit_order_payment_details_after_table', $order ); ?>

		</section>

		<?php if ($transfer = get_post_meta($order->get_id(), '_wc_vit_transaction_transfer', true)) : ?>
		<section class="woocommerce-vit-order-transaction-details">

			<h2 class="woocommerce-vit-order-transaction-details__title"><?php _e( 'vit Transfer details', 'wc-vit' ); ?></h2>

			<table class="woocommerce-table woocommerce-table--vit-order-transaction-details shop_table vit_order_payment_details">
				<tbody>
					<tr>
						<th><?php _e('VIT Transaction', 'wc-vit'); ?></th>
						<td><?php echo $transfer['transaction']; ?></td>
					</tr>
					<tr>
						<th><?php _e('Time', 'wc-vit'); ?></th>
						<td><?php echo $transfer['time']; ?></td>
					</tr>
					<tr>
						<th><?php _e('Memo', 'wc-vit'); ?></th>
						<td><?php echo $transfer['memo']; ?></td>
					</tr>					
				</tbody>
			</table>

			<?php do_action( 'wc_vit_order_transaction_details_after_table', $order ); ?>

		</section>
		<?php endif; ?>

		<?php
	}
}

WC_VIT_Order_Handler::init();
