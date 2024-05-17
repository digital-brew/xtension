<?php

namespace DigitalBrew\Xtension;

use DigitalBrew\Xtension\Modules\Admin\Assets;
use DigitalBrew\Xtension\Modules\Admin\Bar;
use DigitalBrew\Xtension\Modules\Admin\Dashboard;
use DigitalBrew\Xtension\Modules\Front\Emoji;
use DigitalBrew\Xtension\Modules\Admin\Footer;
use DigitalBrew\Xtension\Modules\Admin\Menu;
use DigitalBrew\Xtension\Modules\Comments;
use DigitalBrew\Xtension\Modules\Front\Feed;
use DigitalBrew\Xtension\Modules\Front\JQuery;
use DigitalBrew\Xtension\Modules\Front\Meta;
use DigitalBrew\Xtension\Modules\General;
use DigitalBrew\Xtension\Modules\Posts;
use Illuminate\Container\EntryNotFoundException;

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

  /**
   * @throws EntryNotFoundException
   */
  public function setup(): void
  {
    Assets::init();
    Bar::init();
    Comments::init();
    Dashboard::init();
    Emoji::init();
    Feed::init();
    Footer::init();
    General::init();
    JQuery::init();
    Menu::init();
    Meta::init();
    Posts::init();
  }
}