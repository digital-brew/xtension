<?php

namespace DigitalBrew\Xtension;

use DigitalBrew\Xtension\Modules\Admin\Menu;

class Xtension
{
  private static $instance;

  public static function getInstance(): Xtension
  {
    if(!self::$instance) {
      self::$instance = new self();
    }

    return self::$instance;
  }

  public function setup(): void
  {
    Menu::init();
  }
}