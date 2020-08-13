<?php

namespace Rafflex\AdminSetupXtension;

use Rafflex\AdminSetupXtension\Admin\DashboardWidgets;
use Rafflex\AdminSetupXtension\Admin\Footer;
use Rafflex\AdminSetupXtension\Admin\Menu;
use Rafflex\AdminSetupXtension\Admin\Notification;
use Rafflex\AdminSetupXtension\Front\Emoji;
use Rafflex\AdminSetupXtension\Front\Head;

class App
{
    private static $instance;

    /**
     * Singleton constructor.
     *
     * @return App
     */
    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new App();
        }

        return self::$instance;
    }

    /**
     * Setup the hooks, urls filtering etc
     *
     * @return void
     */
    public function setup() : void
    {
        // Admin
        $this->defineMenuHooks();
        $this->defineNotificationHooks();
        $this->defineDashboardWidgets();

        // Front
        $this->defineFrontHead();
        $this->defineFrontEmoji();
    }

    public function defineMenuHooks()
    {
        $menu = new Menu();

        // Remove default pages
        add_action('admin_menu', [$menu, 'removePages']);

        // Remove default sub pages
        add_action('admin_menu', [$menu, 'removeSubPages']);

        // Add new pages
        add_action('admin_menu', [$menu, 'addPages']);

        // Add Reusable Blocks menu subpage
        add_action('admin_menu', [$menu, 'addReusableBlocks']);
    }

    public function defineNotificationHooks()
    {
        $notification = new Notification();

        // Remove various notifications
        add_action('admin_head', [$notification, 'removeNotifications']);
    }

    public function defineDashboardWidgets()
    {
        $dashboard_widgets = new DashboardWidgets();

        // Remove default dashboard widgets
        add_action('wp_dashboard_setup', [$dashboard_widgets, 'removeWidgets']);

        // Remove Welcome dashboard widget
        remove_action('welcome_panel', 'wp_welcome_panel');
    }

    public function defineFrontHead()
    {
        $font_head = new Head();

        add_action('init', [$font_head, 'clean']);
    }

    public function defineFrontEmoji()
    {
        $front_emoji = new Emoji();

        add_action('init', [$front_emoji, 'clean']);
    }
}
