<?php

namespace DigitalBrew\Xtension\Modules\Front;

use DigitalBrew\Hooks\Action;
use Illuminate\Container\EntryNotFoundException;

class Meta
{
  /**
   * @throws EntryNotFoundException
   */
  public static function init(): void
  {
    if (!config( 'xtension.frontend.meta_tags.enabled' )) {
      Action::remove( 'wp_head', 'wp_generator' );
      Action::remove( 'wp_head', 'rsd_link' );
      Action::remove( 'wp_head', 'wlwmanifest_link' );
      Action::remove( 'wp_head', 'wp_shortlink_wp_head' );
    }
  }
}