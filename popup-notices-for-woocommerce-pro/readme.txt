=== Popup Notices for WooCommerce Pro ===
Contributors: karzin
Tags: woocommerce,popup,notice,modal,notices
Requires at least: 4.4
Tested up to: 5.6
Stable tag: 1.3.3
Requires PHP: 5.6.0
License: GNU General Public License v3.0
License URI: http://www.gnu.org/licenses/gpl-3.0.html

Turn your WooCommerce Notices into Popups

== Description ==

Notices are important messages WooCommerce displays on your store for customers, like:

* Product has been added to cart
* Field Name is a required field
* Have a coupon
* And so on...

And sometimes, depending on the theme, they get so discreet customers don't see it or there are cases where they are just too ugly.

**Popup Notices for WooCommercee** adds WooCommerce Notices into beautiful Popups that will be noticed and appreciated.

== Frequently Asked Questions ==

= How can I contribute? Is there a github repository? =
If you are interested in contributing - head over to the [Popup Notices for WooCommerce plugin GitHub Repository](https://github.com/thanks-to-it/popup-notices-for-woocommerce) to find out how you can pitch in.

== Installation ==

1. Upload the entire 'popup-notices-for-woocommerce-pro' folder to the '/wp-content/plugins/' directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Start by visiting plugin settings at WooCommerce > Settings > Popup Notices.

== Screenshots ==

1. An example of a WooCommerce Notice message on the Popup
2. An example of WooCommerce Notice errors on the Popup
3. An example of a WooCommerce Notice info on the Popup

== Changelog ==

= 1.3.3 - 09/02/2021 =
* Create option to prevent closing if clicking outside the popup.

= 1.3.2 - 27/01/2021 =
* Messages - Add "Allow Shortcodes on Original HTML Content" option.
* Messages - Add `[ttt_pnwc_get_message]` shortcode with a `filter` parameter.
* Messages - Add "Comparison method" option.
* Messages - Remove Message Type option.

= 1.3.1 - 15/01/2021 =
* Update POT file.

= 1.3.0 - 12/01/2021 =
* Create Search method option for Ignore messages section.
* Fix raw_values options.
* Create an option to choose how to load the micromodal js.
* WC tested up to: 4.9
* Tested up to: 5.6

= 1.2.9 - 03/11/2020 =
* Add content option for internal close button.
* Fix empty customized message.
* Improve composer autoload call.
* WC tested up to: 4.6

= 1.2.8 - 16/10/2020 =
* Fix minified js.

= 1.2.7 - 13/10/2020 =
* Tested up to WP 5.5.
* WC tested up to: 4.5.
* Add Auto-close > Notice types option.

= 1.2.6 - 10/08/2020 =
* Add text-align style option

= 1.2.5 - 03/08/2020 =
* Create RTL style option
* WC tested up to: 4.3

= 1.2.4 - 17/06/2020 =
* Add 'Close on Click Inside' option
* WC tested up to: 4.2

= 1.2.3 - 23/05/2020 =
* WC tested up to: 4.1
* Add option to auto-close popup
* Fix Message Origin option from Cookie feature

= 1.2.2 - 17/04/2020 =
* Fix missing `{{post_title}}` template variable on add to cart messages
* Tested up to WP 5.4
* WC tested up to: 4.0

= 1.2.1 - 16/02/2020 =
* Check 'Customize Translated Text' option on `customize_translated_text()` function.

= 1.2.0 - 15/02/2020 =
* Add 'Customize Translated Text' option
* WC tested up to: 3.9

= 1.1.9 - 26/11/2019 =
* Improve 'Icons - Hide' option
* WC tested up to: 3.8
* Tested up to: 5.3

= 1.1.8 - 29/08/2019 =
* Fix 'Call to undefined method Admin_Settings::get_id()'

= 1.1.7 - 29/08/2019 =
* Improve empty messages validation
* Fix ternary operator
* Add option to remove message
* Add conditionals option on restrictive loading setting
* Fix "Cannot declare class WC_Settings_General" error
* WC tested up to: 3.7

= 1.1.6 - 12/08/2019 =
* Force notice hiding with `!important`

= 1.1.5 - 08/08/2019 =
* Improve close button style
* Add force option on customizer, allowing to override theme style
* Improve customized messages detection
* Change the way the Notice Hiding option works
* Improve description for some options
* Add Message Type option, allowing to customize messages by type, like add to cart, and so on...
* Add new option to allow shortcodes in messages

= 1.1.4 - 17/07/2019 =
* Enqueue micromodal with absolute https protocol
* Add option to style popup border
* Add option to style link colors
* Add spacing between additional content on messages

= 1.1.3 - 12/07/2019 =
* Add option to control close button border radius

= 1.1.2 - 28/06/2019 =
* Fix button not checking terms checkbox

= 1.1.1 - 24/06/2019 =
* Add new section allowing to modify WooCommerce messages

= 1.1.0 - 14/06/2019 =
* Add "Restrictive Loading" option to load the plugin at some specific moment or place

= 1.0.9 - 21/05/2019 =
* Check plugins array on updated_plugin rule
* Add option to prevent WooCommerce Scrolling
* WordPress Tested up to: 5.2
* WC tested up to: 3.6

= 1.0.8 - 11/02/2019 =
* Improve Ignored Messages field
* Add audio options
* Add default ignored messages preventing empty popups
* Improve readme

= 1.0.7 - 05/02/2019 =
* Add option to hide icons on small devices
* Improve alignment on small devices
* Add option to ignore messages
* Fix alignment on small screen
* Improve settings page
* Add option to enable/disable custom style

= 1.0.6 - 28/01/2019 =
* Add horizontal and vertical position options for close button
* Fix close button z-index
* Add option for customizing the modal template
* Add `ttt_pnwc_modal_template` filter
* Improve responsive CSS by hiding icons on small devices
* Add container for messages
* Open popup when accessing panel on customizer
* Add options for Font Awesome
* Improve button style inside message
* Add cookie options
* Add customizer js on a separate file

= 1.0.5 - 14/12/2018 =
* Avoid duplicated messages

= 1.0.4 - 10/12/2018 =
* Make 'Hide notices option' hide only checked notice types
* Update WooCommerce requirement
* Update WordPress requirement

= 1.0.3 - 17/10/2018 =
* Fix missing coupon error message

= 1.0.2 - 02/10/2018 =
* Force close button style preventing theme's overriding

= 1.0.1 - 09/09/2018 =
* Add plugin action link to customizer panel
* Add popup background style option
* Add close button background style option
* Add close button color style option
* Add notice background style option
* Add text color style option
* Add text size style option
* Add justify-content style option

= 1.0.0 - 31/08/2018 =
* Initial Release.

== Upgrade Notice ==

= 1.0.0 =
* Initial Release.