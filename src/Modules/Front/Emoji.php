<?php

namespace DigitalBrew\Xtension\Modules\Front;

use Illuminate\Contracts\Container\BindingResolutionException;

class Emoji
{
    /**
     * @throws BindingResolutionException
     */
    public static function register(): void
    {
        if (!getConfig('xtension.frontend.emoji.enabled')) {
            remove_action('wp_print_styles', 'print_emoji_styles');
            remove_action('wp_head', 'print_emoji_detection_script', 7);
        }
    }
}
