<?php

namespace DigitalBrew\Xtension\Modules\Front;

use DigitalBrew\Hooks\Action;
use DigitalBrew\Hooks\Filter;
use Illuminate\Contracts\Container\BindingResolutionException;

class Feed
{
  /**
   * @throws BindingResolutionException
   */
  public static function register(): void
  {
    if (!getConfig( 'xtension.frontend.feed.enabled' )) {
      Action::add( 'after_setup_theme', function () {
        Action::remove( 'wp_head', 'feed_links_extra', 3 );
        Action::remove( 'wp_head', 'feed_links', 2 );
      } );
      Filter::add( 'wp_resource_hints', function ( $hints, $relation_type ) {
        if ( 'dns-prefetch' === $relation_type ) {
          return array_diff( wp_dependencies_unique_hosts(), $hints );
        }

        return $hints;
      }, 10, 2 );
    }
  }
}