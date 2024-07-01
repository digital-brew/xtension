<?php

namespace DigitalBrew\Xtension\Modules\Admin;

use DigitalBrew\Hooks\Action;
use Illuminate\Contracts\Container\BindingResolutionException;

class NetworkMenu
{
  public static function register(): void
  {
    if (!is_multisite()) {
      return;
    }

    $instance = new self();

    Action::add('network_admin_menu', [ $instance, 'disableNodes'], 999);
    Action::add('network_admin_menu', [ $instance, 'enableNodes'], 999);
//    Action::add('network_admin_menu', [ $instance, 'maybeDisableCustomizer']);
//    Action::add('network_admin_head', [ $instance, 'maybeDisableWooCommerceSeparator'], 999);
  }

  /**
   * @throws BindingResolutionException
   */
  public function disableNodes(): void
  {
    $nodes = getConfig('xtension.admin.network_menu', []);

    foreach ($nodes as $node) {
      if ( isset($node['enabled']) && $node['enabled'] === false ) {
        if (isset($node['menu_slug']) && isset($node['submenu_slug'])) {
          remove_submenu_page( $node['menu_slug'], $node['submenu_slug'] );
        }
      }
    }
  }

  /**
   * @throws BindingResolutionException
   */
  public function enableNodes(): void
  {
    $nodes = getConfig('xtension.admin.network_menu', []);
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
   * @throws BindingResolutionException
   */
  public function maybeDisableCustomizer(): void
  {
    $enabled = getConfig('xtension.admin.menu.customizer.enabled', true);
    if ( $enabled === false ) {
      $customize_url = add_query_arg( 'return', urlencode( remove_query_arg( wp_removable_query_args(), wp_unslash( $_SERVER['REQUEST_URI'] ) ) ), 'customize.php' );
      remove_submenu_page( 'themes.php', $customize_url );
    }
  }

  /**
   * @throws BindingResolutionException
   */
  public function maybeDisableWooCommerceSeparator(): void
  {
    $enabled = getConfig('xtension.admin.menu.woocommerce_separator.enabled', true);
    if ( $enabled === false ) {
      echo '<style> #adminmenu .wp-not-current-submenu.wp-menu-separator.woocommerce { display: none !important; }</style>';
    }
  }
}