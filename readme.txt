=== Direction Toggle ===
Contributors: wisamessalwa
Tags: rtl, ltr, direction, toggle, admin
Requires PHP: 5.0
Requires at least: 5.0
Tested up to: 6.7
Stable tag: 1.4
License: GPL-2.0+
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Toggles the WordPress admin dashboard and website between RTL and LTR directions with a single click.

== Description ==

Direction Toggle is a lightweight WordPress plugin that allows you to switch the admin dashboard and front-end website between RTL (Right-to-Left) and LTR (Left-to-Right) directions with a single click. The direction preference is saved per user and persists across page reloads.

== Changelog ==

= 1.1 =
* Fixed flickering issue by setting the direction globally using `$wp_locale->text_direction` and `$wp_styles->text_direction`.
* Improved compatibility with themes and plugins.
* Added persistent direction settings for each user.

= 1.0 =
* Initial release.

== Installation ==

1. Upload the `direction_tgl` folder to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Use the "Toggle Direction" button in the admin bar to switch between RTL and LTR.

== Frequently Asked Questions ==

= What does this plugin do? =

This plugin adds a button to the WordPress admin bar that toggles the direction of the admin dashboard and front-end website between RTL and LTR.

= Does this plugin work with all themes? =

Yes, but some themes may require additional RTL-specific styles for optimal display.

= Can I customize the toggle button? =

Yes, you can modify the CSS in the `direction_tgl.css` file.

== Contributors ==

– [Your Name](https://github.com/yourusername)
– [DeepSeek-V3](https://github.com/DeepSeek-V3)

== License ==

This plugin is licensed under the GPL-2.0+ license. See the [LICENSE](license.txt) file for details.