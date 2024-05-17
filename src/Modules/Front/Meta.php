<?php

namespace DigitalBrew\Xtension\Modules\Front;

use DigitalBrew\Hooks\Action;
use Illuminate\Contracts\Container\BindingResolutionException;

class Meta
{
  /**
   * @throws BindingResolutionException
   */
  public static function init(): void
  {
    if (!getConfig( 'xtension.frontend.meta_tags.enabled' )) {
      Action::remove( 'wp_head', 'wp_generator' );
      Action::remove( 'wp_head', 'rsd_link' );
      Action::remove( 'wp_head', 'wlwmanifest_link' );
      Action::remove( 'wp_head', 'wp_shortlink_wp_head' );
    }
  }
}