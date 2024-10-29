<?php

/**
 * Plugin Name: Xtension
 * Plugin URI: https://digitalbrew.io
 * Plugin Prefix: xtension
 * Plugin ID: xtension
 * Description: Simply extend WP Admin.
 * Version: 2.0.3
 * Author: DigitalBrew
 * Author URI: https://digitalbrew.io
 * Text Domain: xtension
 * Domain Path: languages
 * Domain Var: PLUGIN_TD
 * License: GPL-2.0-or-later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 */

use DigitalBrew\Xtension\Xtension;

require __DIR__ . '/vendor/autoload.php';

if (class_exists('DigitalBrew\\Xtension\\Xtension')) {
    add_action('plugins_loaded', function () {
        Xtension::registerServices();
    }, 999);
}
