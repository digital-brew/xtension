<?php

namespace DigitalBrew\Xtension\Modules;

use DigitalBrew\Hooks\Action;
use Illuminate\Contracts\Container\BindingResolutionException;

class LastLoginTimestamp
{
  /**
   * @throws BindingResolutionException
   */
  public static function register(): void
  {
    if (getConfig('xtension.last_login_timestamp.enabled')) {
      Action::add( 'wp_login', function ( $user_login, $user ) {
        date_default_timezone_set('Europe/London');
        update_user_meta( $user->ID, 'last_login', date("Y-m-d h:i:s") );
      }, 20, 2 );
    }
  }
}