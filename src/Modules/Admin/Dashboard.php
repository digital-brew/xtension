<?php

namespace DigitalBrew\Xtension\Modules\Admin;

class Dashboard
{
    public static function register(): void
    {
        $instance = new self();

        add_action('admin_init', [ $instance, 'disableWidgets' ], 999);
        add_action('admin_init', [ $instance, 'maybeDisableWelcomePanel' ]);
        add_action('admin_init', [ $instance, 'maybeDisableMultisiteRightNowWidget' ]);
        add_action('admin_init', [ $instance, 'maybeDisableMultisiteWordPressEventsAndNewsWidget' ]);
    }

    public function disableWidgets(): void
    {
        $nodes = getConfig('xtension.admin.dashboard.widgets', []);
        foreach ($nodes as $widget => $value) {
            if ($value['enabled'] === false) {
                remove_meta_box($widget, 'dashboard', 'normal');
            }
        }
    }

    public function maybeDisableWelcomePanel(): void
    {
        if (getConfig('xtension.admin.dashboard.widgets.wp_welcome_panel.enabled', true) === false) {
            remove_action('welcome_panel', 'wp_welcome_panel');
        }
    }

    public function maybeDisableMultisiteRightNowWidget(): void
    {
        if (getConfig('xtension.admin.dashboard.widgets.network_dashboard_right_now.enabled', true) === false) {
            remove_meta_box('network_dashboard_right_now', 'dashboard-network', 'core');
        }
    }

    public function maybeDisableMultisiteWordPressEventsAndNewsWidget(): void
    {
        if (getConfig('xtension.admin.dashboard.widgets.network_dashboard_wordpress_events_and_news.enabled', true) === false) {
            remove_meta_box('dashboard_primary', 'dashboard-network', 'core');
        }
    }
}
