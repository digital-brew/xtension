<?php

namespace DigitalBrew\Xtension\Modules\Admin;

use DigitalBrew\Hooks\Action;
use Illuminate\Container\EntryNotFoundException;

class Dashboard
{
  public static function init(): void
  {
    $instance = new self();

    Action::add('admin_init', [$instance, 'disableWidgets'], 999);
    Action::add('admin_init', [$instance, 'maybeDisableWelcomePanel']);
    Action::add( 'admin_init', [$instance, 'maybeDisableMultisiteRightNowWidget'] );
    Action::add( 'admin_init', [$instance, 'maybeDisableMultisiteWordPressEventsAndNewsWidget'] );
  }

  /**
   * @throws EntryNotFoundException
   */
  public function disableWidgets(): void
  {
    $nodes = config('xtension.admin.dashboard.widgets', []);
    foreach ($nodes as $widget => $value) {
      if ( $value['enabled'] === false ) {
        remove_meta_box( $widget, 'dashboard', 'normal' );
      }
    }
  }

  /**
   * @throws EntryNotFoundException
   */
  public function maybeDisableWelcomePanel(): void
  {
    if (config('xtension.admin.dashboard.widgets.wp_welcome_panel.enabled', true) === false) {
      Action::remove( 'welcome_panel', 'wp_welcome_panel' );
    }
  }

  /**
   * @throws EntryNotFoundException
   */
  public function maybeDisableMultisiteRightNowWidget(): void
  {
    if (config('xtension.admin.dashboard.widgets.network_dashboard_right_now.enabled', true) === false) {
      remove_meta_box( 'network_dashboard_right_now', 'dashboard-network', 'core' );
    }
  }

  /**
   * @throws EntryNotFoundException
   */
  public function maybeDisableMultisiteWordPressEventsAndNewsWidget(): void
  {
    if (config('xtension.admin.dashboard.widgets.network_dashboard_wordpress_events_and_news.enabled', true) === false) {
      remove_meta_box( 'dashboard_primary', 'dashboard-network', 'core' );
    }
  }
}