<?php

/**
 * Plugin Name: Xtension
 * Plugin URI: https://digitalbrew.io
 * Plugin Prefix: xtension
 * Plugin ID: xtension
 * Description: Simply show or hide stuff in the admin area, and also... make it prettier.
 * Version: 3.0.0
 * Author: DigitalBrew
 * Author URI: https://digitalbrew.io
 * Text Domain: xtension
 * License: MIT
 */

use DigitalBrew\Xtension\Xtension;

require __DIR__ . '/vendor/autoload.php';

if (class_exists('DigitalBrew\\Xtension\\Xtension')) {
    add_action('init', function () {
        Xtension::registerServices();
    }, 999);
}
