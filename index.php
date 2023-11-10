<?php defined('ABSPATH') || exit;

/**
 * Plugin Name:  Account Switcher
 * Version:      1.0.0
 * Plugin URI:   https://beycanpress.com
 * Description:  Thanks to this plugin, more than one account can be registered on a wordpress site and the user can switch between accounts at any time.
 * Author URI:   https://beycanpress.com
 * Author:       BeycanPress LLC
 * Tags:         Multiple Accounts, Switching between accounts, Multiple Accounts for WordPress, Account switcher for WordPress
 * Text Domain:  accountSwitcher
 * License:      GPLv3
 * License URI:  https://www.gnu.org/licenses/gpl-3.0.tr.html
 * Domain Path:  /languages
 * Requires at least: 5.0
 * Tested up to: 6.4
 * Requires PHP: 7.4
*/

require __DIR__ . '/vendor/autoload.php';
new \BeycanPress\AccountSwitcher\Loader(__FILE__);