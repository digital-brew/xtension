<?php

namespace DigitalBrew\Xtension\Modules\Admin;

use DigitalBrew\Hooks\Action;
use Illuminate\Container\EntryNotFoundException;

class Menu
{
  public static function init(): void
  {
    $instance = new self();

    Action::add('admin_menu', [ $instance, 'disableNodes'], 999);
    Action::add('admin_menu', [ $instance, 'enableNodes'], 999);
    Action::add('admin_menu', [ $instance, 'maybeDisableCustomizer']);
    Action::add('admin_head', [ $instance, 'maybeDisableWooCommerceSeparator'], 999);
  }

  /**
   * @throws EntryNotFoundException
   */
  public function disableNodes(): void
  {
    $nodes = config('xtension.admin.menu', []);

    foreach ($nodes as $node) {
      if ( isset($node['enabled']) && $node['enabled'] === false ) {
        if (isset($node['menu_slug']) && isset($node['submenu_slug'])) {
          remove_submenu_page( $node['menu_slug'], $node['submenu_slug'] );
        }
      }
    }
  }

  /**
   * @throws EntryNotFoundException
   */
  public function enableNodes(): void
  {
    $nodes = config('xtension.admin.menu', []);
    foreach ($nodes as $node => $value ) {
      if (isset($value['enabled']) && $value['enabled'] === true) {
        if ( isset($value['is_label'])) {
          add_menu_page(
            $value['label'],
            $value['label'],
            '',
            'admin_menu_label_'  . $node,
            '',
            'dashicons-minus',
            $value['position']
          );
        }
      }
    }
  }

  /**
   * @throws EntryNotFoundException
   */
  public function maybeDisableCustomizer(): void
  {
    $enabled = config('xtension.admin.menu.customizer.enabled', true);
    if (isset($enabled) && $enabled === false) {
      $customize_url = add_query_arg( 'return', urlencode( remove_query_arg( wp_removable_query_args(), wp_unslash( $_SERVER['REQUEST_URI'] ) ) ), 'customize.php' );
      remove_submenu_page( 'themes.php', $customize_url );
    }
  }

  /**
   * @throws EntryNotFoundException
   */
  public function maybeDisableWooCommerceSeparator(): void
  {
    $enabled = config('xtension.admin.menu.woocommerce_separator.enabled', true);
    if (isset($enabled) && $enabled === false) {
      echo '<style> #adminmenu .wp-not-current-submenu.wp-menu-separator.woocommerce { display: none !important; }</style>';
    }
  }
}