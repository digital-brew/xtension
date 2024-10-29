<?php

namespace DigitalBrew\Xtension\Modules\Front;

use Illuminate\Contracts\Container\BindingResolutionException;

class Meta
{
    /**
     * @throws BindingResolutionException
     */
    public static function register(): void
    {
        if (!getConfig('xtension.frontend.meta_tags.enabled')) {
            remove_action('wp_head', 'wp_generator');
            remove_action('wp_head', 'rsd_link');
            remove_action('wp_head', 'wlwmanifest_link');
            remove_action('wp_head', 'wp_shortlink_wp_head');
        }
    }
}
