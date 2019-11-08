<?php
/**
 * WC_VIT_Transaction_Transfer
 *
 * @package WooCommerce VIT Payment Method
 * @category Class
 * @authors crypto-ali, AnatoliyStrizhak, sagescrub, ReCrypto
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

class WC_VIT_Transaction_Transfer {

        /**
         * Retrieve "VIT Transaction Transfer" via VIT API
         *
         * @since 1.0.0
         * @param WC_Order $order
         * @return $transfer
         */
	public static function get($order) {
		$transfer = null;

		if (is_int($order)) {
			$order = wc_get_order($order);
		}
		elseif (isset($order->post_type) && $order->post_type == 'shop_order') {
			$order = wc_get_order($order);
		}

		if (empty($order) || is_wp_error($order) || $order->get_payment_method() != 'wc_vit') {
			return $transfer;
		}

		$data = array(
			'to' => wc_order_get_vit_payee($order->get_id()),
			'memo' => wc_order_get_vit_memo($order->get_id()),
			'amount' => wc_order_get_vit_amount($order->get_id()),
			'amount_currency' => wc_order_get_vit_amount_currency($order->get_id()),
		);

		if (empty($data['to']) || empty($data['memo']) || empty($data['amount'] || empty($data['amount_currency']))) {
			// Initial transaction data not found in this order. Mark the order as searched so that it is not queried again.
			update_post_meta($order->get_id(), '_wc_vit_last_searched_for_transaction', date('m/d/Y h:i:s a', time()));
			
			return $transfer;
		}
		
		//step1
		$ch = curl_init(); 
		//step2
		curl_setopt($ch,CURLOPT_URL,"https://vitapi.isfor.me/account-history/transfers?account=".$data['to']);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
		curl_setopt($ch,CURLOPT_HEADER, false); 
		//step3
		$file_contents = curl_exec($ch);
		//step4
		curl_close($ch);
		
		//$file_contents = file_get_contents("https://vitapi.isfor.me/account-history/transfers?account=".$data['to']);
		//$file_contents = wp_remote_get("https://vitapi.isfor.me/account-history/transfers?account=".$data['to']);
		
		// If failure in retrieving url
		if ($file_contents === false)
			return $transfer;
		
		$tx = json_decode($file_contents, true);
		
		// If error decoding JSON
		if (JSON_ERROR_NONE !== json_last_error()) {
			return $transfer;
		}
				
		$tx_id = array_search($data['memo'], array_column($tx, 'memo'));
		
		//Format WooCommerce order amount to include three decimal places and strip thousands separator, if any.
		$amount = number_format( $data['amount'] , 3, "." , "" );
		
		    if (isset($tx[$tx_id]['memo']) && $data['memo'] === $tx[$tx_id]['memo'] && $tx[$tx_id]['type'] === 'transfer' && $amount === preg_replace("/ VIT/","",$tx[$tx_id]['amount']) && $tx[$tx_id]['to'] === $data['to'])
				{
					$transfer['memo']=$tx[$tx_id]['memo'];
					$transfer['time']=$tx[$tx_id]['timestamp'];

					$transfer['transaction']="Recieved " . $amount . " " . $data['amount_currency'] . " from " . $tx[$tx_id]['from'];

					$transfer['time_desc']=$tx[$tx_id]['timestamp'];
			}
		//}
		
		// Successfully (no errors in retrieving JSON) searched transaction history for the record.
		update_post_meta($order->get_id(), '_wc_vit_last_searched_for_transaction', date('m/d/Y h:i:s a', time()));
		
		return $transfer;
	}
}
