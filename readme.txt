=== WooCommerce VIT Payment Method ===
Contributors: alicryptomonhi,sagescrub, recrypto
Donate link:
Tags: woocommerce, woo commerce, payment method, vit, sbd, crypto
Requires at least: 4.1
Tested up to: 5.2.4
Stable tag: 1.0
Requires PHP: 5.2.4
License: GPLv3
License URI: https://www.gnu.org/licenses/gpl-3.0.html

Accept VIT payments in your WooCommerce store via a VIT wallet or WhaleVault. Automatically converts from fiat (USD, EUR, etc) to VIT. No transaction fees.

== Description ==

WooCommerce VIT Payment Method lets you accept VIT payments directly to your WooCommerce shop (Currencies: VIT).

= Details =

* There is no extra transaction fee. Payments are made directly between customer and store owner via the VIT Blockchain. 
* This plugin will automatically detect if payment was made once it is posted to the VIT Blockchain. 
* If payment is not completed within several minutes of submitting an order an automatic payment reminder email will be sent to the customer with instructions for submitting payment. This is a fallback for 1) the customer doesn't complete the transaction, and 2) the payment detection functionality in this plugin stops working for any reason.
* Currency exchange rate between FIAT and VIT is automatically calculated at time of checkout.
* Currency exchange rate between FIAT and VIT can be optionally displayed below the product price on the product page.

= Supported VIT Currencies =
- VIT (VIT)

= FIAT Currencies Supported =
- Currently supports fiat currencies such as: AUD, BGN, BRL, CAD, CHF, CNY, CZK, DKK, GBP, HKD, HRK, HUF, IDR, ILS, INR, JPY, KRW, MXN, MYR, NOK, NZD, PHP, PLN, RON, RUB, SEK, SGD, THB, TRY, ZAR, EUR
- If none of the fiat currency listed above, it will default 1:1 conversion rate between your store's currency and VIT.

= How it Works Behind The Scenes =
* Exchange rates are updated once an hour
* FIAT foreign exchange rates are gathered from the European Central Bank's free API
* VIT exchange rates are determined by querying a VIT exchange rate data feed at isfor.me/rates. The rate is derived from taking the average of three exchange markets: IDAX VIT_BTC, IDAX VIT_ETH, and Steem Engine Dex VITP_STEEMP.
* Your store's VIT wallet is scanned every 5 minutes for pending transactions (if there are any orders with pending payment)
* If an order is Pending Payment for too long it will be automatically canceled by WooCommerce default settings. You can change the timing or disable this feature in WooCommerce -> Settings -> Products -> Inventory -> Hold Stock (Minutes)

= Technical Requirements =
WooCommerce plugin must be installed before you install this plugin.

This plugin requires WordPress CRON jobs to be enabled. If CRON jobs are not enabled, currency exchange rates will not be updated and this plugin will not be able to search for VIT payment records. If your exchange rates are not updating or if orders were paid for but still say "Payment Pending" or are automatically canceled, it is likely that CRON jobs are not enabled on your server or are not functioning properly.

Order payments should normally be reflected in the order automatically within 5 to 10 minutes. If the order is is still status Payment Pending or becomes cancelled after more than 10 to 15 minutes, it is likely that your CRON jobs are not enabled.

An alternative to using WordPress CRON jobs is setting up a real Crontab. A real Crontab is more efficient than using WordPress CRON jobs, and so you may prefer this approach. You can find instructions for setting up a real Crontab here: https://helloacm.com/setting-up-a-real-crontab-for-wordpress/

= Security Note =
You will <strong>NOT</strong> be required to enter any VIT private keys into this plugin. You only have to provide your VIT username so that the plugin knows where payments should be sent.

= Thanks =
* Special thanks to [AnatoliyStrizhak](https://github.com/AnatoliyStrizhak/whaleshares) for developing the WooCommerce WLS plugin, based on the plugins below.

* Special thanks to [@sagescrub](https://steemit.com/@sagescrub) for forking the original "WooCommerce Steem" and making the "WooCommerce Steem Payment Method" plugin. Thank you @sagescrub!

* Special thanks to [@ReCrypto](https://steemit.com/@recrypto) for being the author and inventor of the original "WooCommerce Steem" plugin before it was forked and updated into this plugin "WooCommerce Steem Payment Method". Thank you @ReCrypto!

= Disclaimer =
Authors claim no responsibility for missed transactions, loss of your funds, loss of customer funds, incorrect or delayed exchange rates or any other issue you may encounter as a result of using this plugin. Use this plugin at your own risk.

The WooCommerce VIT Payment Method is a free, open-source extension for WooCommerce software. WooCommerce name and trademark are used to indentify purpose of this plugin software. There is no official partnership or endorsement between WooCommerce and WooCommerce VIT Payment Method.

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/woocommerce-vit-payment-method` directory, or install the plugin through the WordPress plugins screen directly.
1. Activate the plugin through the 'Plugins' screen in WordPress
1. Turn on VIT as a payment method in WooCommerce->Settings->Payments. Turn on the "Enabled" switch.
1. Update settings for this plugin in WooCommerce->Settings->Payments and clicking "Manage" next to "VIT"
1. Make sure to put your VIT username in the "Payee" box so that you will receive payments.

== Frequently Asked Questions ==

= How is customer payment made? =
When the customer initiates payment the order confirmation page includes VIT transaction information the buyer needs to complete the transaction (to, amount, memo). If they have WhaleVault installed they will be able to type their username into a field and click WhaleVault. WhaleVault window will be opened and contain all the transaction information. The automatically generated memo is a random key that is matched to the order.

= How does it confirm VIT Transfers? =
It queries the store's VIT wallet history every 2 minutes and checks for a transaction that matches the payment memo and amount. When the matching payment is found, the order is marked from "payment pending" to "completed".

= What is the payment reminder email? =
If the customer does not complete the payment within several minutes of initiating the payment, a confirmation email will be sent reminding the customer to make payment manually via VIT wallet on a VIT powered site such as Touchit Social. The payment reminder email will include instructions including the memo.

= How can I support this plugin? =
You can support this plugin by [creating a VIT account](https://join.vit.tube/) and using the network and plugin.

If you are a developer and would like to contribute, please let me know!

VIT: @mbs305
Discord: @Crypto Ali#2842 

== Screenshots ==

1. Product page showing optional exchange rate below product price.
2. VIT payment method option on checkout page. Exchange rate from FIAT is calculated automatically.
3. WhaleVault for processing payment. Note memo that is provided will be used to match the order.
4. Payment not received reminder email.
5. Payment method in WooCommerce
6. Settings for this plugin within WooCommerce Payments Settings

== Changelog ==

= 1.0 - 2019-11-7 =
* Initial release.