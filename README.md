![wc-plus-vit.png](https://cdn.steemitimages.com/DQmb3YZp3uNzrVG4rrHbq6SAkMpMod9PHf8gbL643bhQFQa/wc-plus-vit.png)

# VIT Payment Method for WooCommerce
Accept VIT payments in your WooCommerce store via a VIT wallet or [WhaleVault](https://github.com/alexpmorris/WhaleVault). Automatically converts from fiat (USD, EUR, etc) to VIT. No transaction fees.

## Supported VIT Currencies
- VIT (VIT)

## Details
* There is no extra transaction fee. Payments are made directly between customer and store owner via the VIT Blockchain.
* This plugin will automatically detect if payment was made once it is posted to the VIT Blockchain. 
* If payment is not completed within several minutes of submitting an order an automatic payment reminder email will be sent to the customer with instructions for submitting payment. This is a fallback for 1) the customer doesn't complete the transaction, and 2) the payment detection functionality in this plugin stops working for any reason.
* Currency exchange rate between FIAT and VIT is automatically calculated at time of checkout.
* Currency exchange rate between FIAT and VIT can be optionally displayed below the product price on the product page.

## Currency Limitations
- Currently supports different fiat currencies such as: AUD, BGN, BRL, CAD, CHF, CNY, CZK, DKK, GBP, HKD, HRK, HUF, IDR, ILS, INR, JPY, KRW, MXN, MYR, NOK, NZD, PHP, PLN, RON, RUB, SEK, SGD, THB, TRY, ZAR, EUR
- If none of the fiat currency listed above, it will default 1:1 conversion rate.

## How it Works Behind The Scenes
* Exchange rates are updated once an hour
* FIAT foreign exchange rates are gathered from the European Central Bank's free API
* VIT exchange rates are determined by querying a VIT exchange rate data feed at isfor.me/rates. The rate is derived from taking the average of three exchange markets: IDAX VIT_BTC, IDAX VIT_ETH, and Steem Engine Dex VITP_STEEMP.
* Your store's VIT wallet is scanned every 5 minutes for pending transactions (if there are any orders with pending payment)
* If an order is Pending Payment for too long it will be automatically canceled by WooCommerce default settings. You can change the timing or disable this feature in WooCommerce -> Settings -> Products -> Inventory -> Hold Stock (Minutes)

## Technical Requirements
WooCommerce plugin must be installed before you install this plugin.

This plugin requires WordPress CRON jobs to be enabled. If CRON jobs are not enabled, currency exchange rates will not be updated and this plugin will not be able to search for VIT payment records. If your exchange rates are not updating or if orders were paid for but still say "Payment Pending" or are automatically canceled, it is likely that CRON jobs are not enabled on your server or are not functioning properly.

Order payments should normally be reflected in the order automatically within 5 to 10 minutes. If the order is is still status Payment Pending or becomes cancelled after more than 10 to 15 minutes, it is likely that your CRON jobs are not enabled.

An alternative to using WordPress CRON jobs is setting up a real Crontab. A real Crontab is more efficient than using WordPress CRON jobs, and so you may prefer this approach. You can find instructions for setting up a real Crontab here: https://helloacm.com/setting-up-a-real-crontab-for-wordpress/

## Security Note
You will <strong>NOT</strong> be required to enter any VIT private keys into this plugin. You only have to provide your VIT username so that the plugin knows where payments should be sent.

## Screenshots
![vit-pmt-plugin-1.png](https://cdn.steemitimages.com/DQmee4NyUUgMgsfKftTsj9Kf7jrabYQookrHShnDJgXpnyv/vit-pmt-plugin-1.png)

![vit-pmt-plugin-2.png](https://cdn.steemitimages.com/DQmf9L127hxVdhKZDHvfAKuCkXJgaHwVdk9o1VyKiuN21Ss/vit-pmt-plugin-2.png)

![vit-pmt-plugin-3.png](https://cdn.steemitimages.com/DQmd9gXy5ubjGvv26QTv42thNut91fJkLkMvyz7jsmLaY11/vit-pmt-plugin-3.png)

![vit-pmt-plugin-4.png](https://cdn.steemitimages.com/DQmX1iFwzcxW9gWnaCYEmbCCjpJmWBpdtVzkk62EsNoabkH/vit-pmt-plugin-4.png)

![vit-pmt-plugin-5.png](https://cdn.steemitimages.com/DQmdzvkJbATSNQWWNVWpLbNmY5zVgBd9kYus7gmxyzoTtHo/vit-pmt-plugin-5.png)

![vit-pmt-plugin-6.png](https://cdn.steemitimages.com/DQmawfoCxUxmWnxrMu6VHwWWvX1Qc8YNyendNsPFEit7bSF/vit-pmt-plugin-6.png)

## Thanks
* Special thanks to [AnatoliyStrizhak](https://github.com/AnatoliyStrizhak/whaleshares) for developing the WooCommerce WLS plugin, based on the plugins below.

* Special thanks to [@sagescrub](https://steemit.com/@sagescrub) for forking the original "WooCommerce Steem" and making the "WooCommerce Steem Payment Method" plugin. Thank you @sagescrub!

* Special thanks to [@ReCrypto](https://steemit.com/@recrypto) for being the author and inventor of the original "WooCommerce Steem" plugin. Thank you @ReCrypto!

## Disclaimers
Authors claim no responsibility for missed transactions, loss of your funds, loss of customer funds, incorrect or delayed exchange rates or any other issue you may encounter as a result of using this plugin. Use this plugin at your own risk.

The VIT Payment Method for WooCommerce is a free, open-source extension for WooCommerce software. WooCommerce name and trademark are used to indentify purpose of this plugin software. There is no official partnership or endorsement between WooCommerce and VIT Payment Method for WooCommerce.

## Installation

1. Upload the plugin files to the `/wp-content/plugins/woocommerce-vit-payment-method` directory, or install the plugin through the WordPress plugins screen directly.
1. Activate the plugin through the 'Plugins' screen in WordPress
1. Turn on VIT as a payment method in WooCommerce->Settings->Payments. Turn on the "Enabled" switch.
1. Update settings for this plugin in WooCommerce->Settings->Payments and clicking "Manage" next to "VIT"
1. Make sure to put your VIT username in the "Payee" box so that you will receive payments.
1. Make sure that WordPress CRON jobs are enabled. If you are not sure how, you should ask your web host to help.
1. Recommended: Try some sample test transactions with small amounts to make sure payments are received and they are registered in the order. 

