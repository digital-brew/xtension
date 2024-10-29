<?php

namespace DigitalBrew\Xtension\Modules\Front;

use Illuminate\Contracts\Container\BindingResolutionException;

class Feed
{
    /**
     * @throws BindingResolutionException
     */
    public static function register(): void
    {
        if (!getConfig('xtension.frontend.feed.enabled')) {
            add_action('after_setup_theme', function () {
                remove_action('wp_head', 'feed_links_extra', 3);
                remove_action('wp_head', 'feed_links', 2);
            });
            add_filter('wp_resource_hints', function ($hints, $relation_type) {
                if ('dns-prefetch' === $relation_type) {
                    return array_diff(wp_dependencies_unique_hosts(), $hints);
                }

                return $hints;
            }, 10, 2);
        }
    }
}
