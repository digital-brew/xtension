<?php

namespace DigitalBrew\Xtension;

use DigitalBrew\Xtension\Modules\Admin\Assets;
use DigitalBrew\Xtension\Modules\Admin\Bar;
use DigitalBrew\Xtension\Modules\Admin\Dashboard;
use DigitalBrew\Xtension\Modules\Admin\NetworkMenu;
use DigitalBrew\Xtension\Modules\Admin\Table;
use DigitalBrew\Xtension\Modules\Front\Emoji;
use DigitalBrew\Xtension\Modules\Admin\Footer;
use DigitalBrew\Xtension\Modules\Admin\Menu;
use DigitalBrew\Xtension\Modules\Comments;
use DigitalBrew\Xtension\Modules\Front\Feed;
use DigitalBrew\Xtension\Modules\Front\JQuery;
use DigitalBrew\Xtension\Modules\Front\Meta;
use DigitalBrew\Xtension\Modules\General;
use DigitalBrew\Xtension\Modules\LastLoginTimestamp;
use DigitalBrew\Xtension\Modules\Posts;

class Xtension
{
    public static function getServices(): array
    {
        return [
          Assets::class,
          Bar::class,
          Comments::class,
          Dashboard::class,
          Emoji::class,
          Feed::class,
          Footer::class,
          General::class,
          JQuery::class,
          LastLoginTimestamp::class,
          Menu::class,
          Meta::class,
          NetworkMenu::class,
          Posts::class,
          Table::class
        ];
    }

    public static function registerServices(): void
    {
        foreach (self::getServices() as $class) {
            $service = self::instantiate($class);
            if (method_exists($service, 'register')) {
                $service->register();
            }
        }
    }

    private static function instantiate($class)
    {
        return new $class();
    }
}
