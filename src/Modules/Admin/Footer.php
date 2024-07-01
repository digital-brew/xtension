<?php

namespace DigitalBrew\Xtension\Modules\Admin;

use DigitalBrew\Hooks\Filter;
use Illuminate\Contracts\Container\BindingResolutionException;

class Footer
{
  /**
   * @throws BindingResolutionException
   */
  public static function register(): void
  {
    if ( getConfig( 'xtension.admin.footer_text' ) !== null ) {
      Filter::add('admin_footer_text', function () {
        echo getConfig( 'xtension.admin.footer_text' );
      });
    }
  }
}