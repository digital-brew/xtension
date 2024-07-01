<?php

namespace DigitalBrew\Xtension\Modules\Front;

use DigitalBrew\Hooks\Action;
use Illuminate\Contracts\Container\BindingResolutionException;

class Emoji
{
  /**
   * @throws BindingResolutionException
   */
  public static function register(): void
  {
    if (!getConfig( 'xtension.frontend.emoji.enabled' )) {
      Action::remove( 'wp_print_styles', 'print_emoji_styles' );
      Action::remove( 'wp_head', 'print_emoji_detection_script', 7 );
    }
  }
}