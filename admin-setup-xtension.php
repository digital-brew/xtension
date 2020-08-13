<?php

/*
Plugin Name: Admin Setup Xtension
Description: Custom setup for admin panel and site in general.
Author: Rafal Pajak
Version: 1.0.0
Author URI: https://www.burstofcode.com
*/


require __DIR__ . '/vendor/autoload.php';

add_action('plugins_loaded', function () {
    (\Rafflex\AdminSetupXtension\App::getInstance())->setup();
});
