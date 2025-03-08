<?php

declare(strict_types=1);

defined('ABSPATH') || exit;

// @phpcs:disable PSR1.Files.SideEffects
// @phpcs:disable PSR12.Files.FileHeader
// @phpcs:disable Generic.Files.LineLength

/**
 * Plugin Name:  Account Switcher
 * Version:      1.0.1
 * Plugin URI:   https://beycanpress.com/our-plugins/
 * Description:  Thanks to this plugin, more than one account can be registered on a wordpress site and the user can switch between accounts at any time.
 * Author URI:   https://beycanpress.com
 * Author:       BeycanPress LLC
 * Tags:         Multiple Accounts, Switching between accounts, Multiple Accounts for WordPress, Account switcher for WordPress
 * Text Domain:  account-switcher
 * License:      GPLv3
 * License URI:  https://www.gnu.org/licenses/gpl-3.0.tr.html
 * Domain Path:  /languages
 * Requires at least: 5.0
 * Tested up to: 6.7.2
 * Requires PHP: 8.1
*/

require __DIR__ . '/vendor/autoload.php';
new \BeycanPress\AccountSwitcher\Loader(__FILE__);
