<?php

namespace DigitalBrew\Xtension\Modules\Admin;

use DigitalBrew\Hooks\Filter;
use Illuminate\Container\EntryNotFoundException;

class Footer
{
  /**
   * @throws EntryNotFoundException
   */
  public static function init(): void
  {
    if ( config( 'xtension.admin.footer_text' ) !== null ) {
      Filter::add('admin_footer_text', function () {
        echo config( 'xtension.admin_footer_text' );
      });
    }
  }
}