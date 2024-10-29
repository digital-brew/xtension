<?php

namespace DigitalBrew\Xtension\Modules\Admin;

class Footer
{
    public static function register(): void
    {
        if (getConfig('xtension.admin.footer_text') !== null) {
            add_filter('admin_footer_text', function () {
                echo getConfig('xtension.admin.footer_text');
            });
        }
    }
}
