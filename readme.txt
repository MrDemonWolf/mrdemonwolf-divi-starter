=== MrDemonWolf Divi Starter ===
Contributors: mrdemonwolf
Requires at least: 5.0
Tested up to: 6.7
Requires PHP: 7.4
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Text Domain: mrdemonwolf-divi-starter
Version: 1.0.2

A minimal Divi child theme providing a clean slate for custom development and design by MrDemonWolf, Inc.

== Description ==

MrDemonWolf Divi Starter is a lightweight child theme for the Divi theme by Elegant Themes. It provides a clean foundation for custom development and design work.

== Changelog ==

= 1.0.2 =
* Added ABSPATH guard to functions.php
* Unified function prefixes to mrdemonwolf_
* Fixed script handle name
* Used wp_date() instead of date()
* Fixed oEmbed filter registration order
* Used add_action for admin_bar_menu hook
* Added Text Domain to style.css header
* Removed debug console.log from script.js

= 1.0.1 =
* Added Facebook-style console warning to deter social engineering attacks

= 1.0.0 =
* Initial release of MrDemonWolf Divi Starter child theme
* Parent and child theme style enqueueing with cache-busting
* Child theme script enqueueing
* Custom admin bar greeting based on time of day
* Disabled author info from oEmbed response data
