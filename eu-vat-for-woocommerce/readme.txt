=== EU VAT Validator & Assistant for WooCommerce ===
Contributors: omardabbas
Tags: woocommerce, eu, vat, eu vat, woo commerce
Requires at least: 4.4
Tested up to: 5.8
Stable tag: 2.4.3
License: GNU General Public License v3.0
License URI: http://www.gnu.org/licenses/gpl-3.0.html

Manage EU VAT in WooCommerce, validate VAT numbers, exempt or preserve VAT with various settings & cases.

== Description ==

With the latest EU VAT regulations and its following updates, any physical or digital goods that are sold to consumers in the European Union countries are liable to EU VAT, regardless of the seller location.
**EU VAT for WooCommerce** plugin will let you collect VAT number on checkout, and optionally validate VAT against the official EU VAT database to confirm the VAT number, then automatically exempt VAT for the validated number.
The plugin also includes a tax tool, within a single click you will be able to add all EU country VAT standard rates to your WooCommerce store.

= Main Features =

* Set **frontend options**: You can customize field label, placeholder, description to the text/language of your preference, take control of position, CSS class as well.
* Set if EU VAT field **is required** on checkout: It will give you the option to make the field mandatory or optional, and even when it's left optional, you can still show the customer a confirmation notice to make sure they didn't leave it blank by mistake.
* Set if EU VAT field needs to be **validated**: This option will let your store validate the EU VAT number using VIES SOAP in real-time to guarantee a valid VAT number.
* Automatically **exempt VAT** for valid VAT numbers.
* Optionally check for **matching billing country code**.
* Optionally allow VAT number **input without country code**.
* Customize **progress messages**.
* Set **display options** (after order table and/or in billing address).
* Optionally always **show zero VAT**.
* **WPML/Polylang** compatible.
* Automatically exempt/not exempt VAT for selected **user roles**.
* EU VAT **report**.

= Premium Version =

Our extended [EU VAT for WooCommerce Pro](https://wpfactory.com/item/eu-vat-for-woocommerce/) plugin allows you to:

* **Preserve VAT** in selected countries.
* Check **country by IP**.
* **Show field** for selected **countries** only.
* **Show field** for selected **user roles** only.
* Validate **company name**.

= Demo Store =

If you want to try the plugin features and play around with its settings before installing it on your live website, feel free to do so on this demo store:
URL: https://wpwhale.com/demo/wp-admin/
User: demo
Password: G6_32e!r@

== Screenshots ==

1. Main Page - General
2. Validation & Progress
3. Admin settings & Advanced options

= Feedback =

* We are open to your suggestions and feedback. Thank you for using or trying out one of our plugins!
* [Visit plugin site](https://wpfactory.com/item/eu-vat-for-woocommerce/).

== Installation ==

1. Upload the entire plugin folder to the `/wp-content/plugins/` directory.
2. Activate the plugin through the "Plugins" menu in WordPress.
3. Start by visiting plugin settings at "WooCommerce > Settings > EU VAT".

== Changelog ==

= 2.4.3 - 06/08/2021 =
* Fixed a warning message regarding AJAX being broken

= 2.4.2 - 26/07/2021 =
* Added an option to hide validation messages in preserved countries
* Fixed a bug in removing VAT if shipping address is a forwarding address
* Verified compatibility with WordPress 5.8

= 2.4.1 - 13/07/2021 =
* Added an option to validate VAT based on final destination (if order is sent to a forwarding address)
* Fixed undefined index & order ID warning messages
* Verified compatibilty with WooCommerce 5.5 

= 2.4 - 24/06/2021 =
* Added a popup section to open official VIES website in orders backend (to verify VAT info on order)
* Verified compatibilty with WooCommerce 5.4 

= 2.3.3 - 16/05/2021 =
* Fixed a bug was showing "Undefined index" errors when connecting through SSH
* Verified compatibilty with WooCommerce 5.3

= 2.3.2 - 03/05/2021 =
* Fixed a bug in session not firing in store
* Added tolerance for dash (-) in case VAT number was entered with a dash

= 2.3.1 - 30/04/2021 =
* Enhanced session configuration
* Added a feature to preserve tax if valid VAT number holders are not exempted (useful in Belgium)
* Tested compatibility with WooCommerce 5.2

= 2.3 - 20/04/2021 =
* Added new option to allow user to select VAT option
* Added banners on the sidebar
* Added a filter to control changes updates
* Checked compatibility with WC 5.1 & WP 5.7

= 2.2.5 - 28/02/2021 =
* Tested compatibilty with WC 5.0

= 2.2.4 - 27/01/2020 =
* Tested compatibility with WC 4.9

= 2.2.3 - 30/12/2020 =
* Tested compatibility with WC 4.8 & WP 5.6
* Changed default session type to WooCommerce session

= 2.2.2 - 21/11/2020 =
* Tested compatibility with WC 4.7
* Plugin name updated

= 2.2.1 - 14/10/2020 =
* Fixed a warning message that was appearing the Site Health Check

= 2.2 - 02/10/2020 =
* Added more strings to be translatable using multi-language sites
* Tested compatibility with WC 4.5

= 2.1 - 20/08/2020 =
* Fixed a bug that wasn't exempting VAT on manual orders (WP backend)

= 2.0.1 - 15/08/2020 =
* Tested compatibility with WP 5.5
* Tested compatibility with WC 4.3

= 2.0 - 25/06/2020 =
* Fixed a bug that prevented showing the correct message (valid successful) for compatibility with some themes JS
* Enhanced the SOAP method via using better communication method with EU VAT servers

= 1.9 - 17/06/2020 =
* Stopped calling the main JS file on all pages and keep it only on checkout for better performance
* Removed the string from a deprecated argument to get list of countries
* Fixed a minor issue that was causing error (failed to load external entity ) in communicating with VIES servers in some cases

= 1.8.1 - 25/03/2020 =
* Checked all plugin features compatibility with WC 4

= 1.8.0 - 23/12/2019 =
* Dev - Plugin author updated.

= 1.7.2 - 12/12/2019 =
* Dev - General - Frontend Options - "Max length" option added.
* Dev - Validation - "Skip VAT validation for selected countries" option moved from to "Advanced" section.
* Dev - Code refactoring.

= 1.7.1 - 05/12/2019 =
* Fix - Validation - Check for matching billing country code - Fixed for Greece (`EL` is replaced with `GR` when comparing country codes).
* Dev - Admin & Advanced - "Force VAT recheck on checkout" option added.
* Dev - Debug - "Error: VAT is not valid" message added to the log.
* Dev - Code refactoring.
* Tested up to: 5.3.

= 1.7.0 - 08/11/2019 =
* Dev - Validation - "Always exempt VAT for selected user roles" and "Always not exempt VAT for selected user roles" options added.
* Dev - Admin & Advanced - Debug - "Country code does not match" message added to the log.
* Dev - Admin & Advanced - Session type - "WC session" option marked as "recommended".
* Dev - Code refactoring.
* WC tested up to: 3.8.

= 1.6.1 - 16/10/2019 =
* Dev - Validation - Check company name - Now converting all values to uppercase before comparing.
* Dev - JavaScript - Better event for company validation.

= 1.6.0 - 15/10/2019 =
* Dev - General - Frontend Options - "Show field for selected user roles only" option added.
* Dev - Validation - "Check company name" option added.
* Dev - Admin & Advanced - Advanced Options - "Debug" option added.
* Dev - Code refactoring.

= 1.5.0 - 13/08/2019 =
* Dev - Admin - Order List - "EU VAT" column added.
* Dev - Admin - Reports - Taxes - "EU VAT" report added.
* Dev - Admin - EU country VAT Rates Tool - Duplicates are no longer added for the country.
* Dev - Admin settings split into sections.
* Dev - Allow VAT number input without country code - Additional country fallback added.
* Dev - Functions - General - `alg_wc_eu_vat_session_start()` - Additional `headers_sent()` check added.
* WC tested up to: 3.7.
* Tested up to: 5.2.

= 1.4.1 - 04/05/2019 =
* Fix - Preserve VAT in selected countries - Bug (when "Allow VAT number input without country code" is enabled) fixed.
* Fix - Show field for selected countries only - Bug (when "Required" is enabled) fixed.
* Dev - Frontend Options - "Confirmation notice" options added.
* Dev - Code refactoring.
* Dev - "WC tested up to" updated.

= 1.4.0 - 06/03/2019 =
* Fix - "Preserve VAT in selected countries" fixed when "Allow VAT number input without country code" is enabled.
* Dev - Frontend Options - "Always show zero VAT" option added.
* Dev - `[alg_wc_eu_vat_translate]` shortcode added.
* Dev - Shortcodes are now also processed in field label, placeholder, description and validation message options.
* Dev - Validation - Preserve VAT in selected countries - "Comma separated list" option added.
* Dev - Frontend Options - "Show field for selected countries only" option added.

= 1.3.0 - 31/01/2019 =
* Fix - Default field value on the checkout fixed.
* Dev - Display Options - Display - Multiple positions are now allowed (i.e. multiselect).
* Dev - Display Options - Display - In billing address - Field is now editable ("My Account > Addresses").
* Dev - Frontend Options - "Label CSS class" option added.
* Dev - Code refactoring.

= 1.2.1 - 30/01/2019 =
* Dev - Advanced Options - "Session type" option added.
* Dev - Admin settings - "Your settings have been reset" notice added.

= 1.2.0 - 12/11/2018 =
* Fix - AJAX - Possible "undefined index" PHP notice fixed.
* Dev - General - "Priority (i.e. position)" option added.
* Dev - General - "Raw" input is now allowed in textarea admin settings.
* Dev - Code refactoring.
* Dev - Plugin URI updated.

= 1.1.0 - 07/06/2018 =
* Dev - General - "Check for matching billing country code" option added.
* Dev - General - "Allow VAT number input without country code" option added.

= 1.0.1 - 05/06/2018 =
* Dev - `%eu_vat_number%` replaced value added to "Message on not valid" option. "Message on not valid" now doesn't check for required (i.e. empty) field.

= 1.0.0 - 24/05/2018 =
* Initial Release.

== Upgrade Notice ==

= 1.0.0 =
This is the first release of the plugin.
