<?php

namespace DigitalBrew\Xtension\Modules\Front;

use DigitalBrew\Hooks\Action;
use Illuminate\Container\EntryNotFoundException;

class Emoji
{
  /**
   * @throws EntryNotFoundException
   */
  public static function init(): void
  {
    if (!config( 'xtension.frontend.emoji.enabled' )) {
      Action::remove( 'wp_print_styles', 'print_emoji_styles' );
      Action::remove( 'wp_head', 'print_emoji_detection_script', 7 );
    }
  }
}