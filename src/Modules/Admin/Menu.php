<?php

namespace DigitalBrew\Xtension\Modules\Admin;

use DigitalBrew\Hooks\Action;
use Illuminate\Container\EntryNotFoundException;

class Menu
{
  public static function init(): void
  {
    Action::add('admin_menu', [self::class, 'disableNodes'], 999);
    Action::add('admin_menu', [self::class, 'enableNodes'], 999);
    Action::add('admin_menu', [self::class, 'maybeDisableCustomizer']);
    Action::add('admin_head', [self::class, 'maybeDisableWooCommerceSeparator'], 999);
  }

  /**
   * @throws EntryNotFoundException
   */
  public function disableNodes(): void
  {
    $nodes = config('xtension.admin_menu', []);
    foreach ($nodes as $node) {
      if ( isset($value['disabled']) && $node['disabled'] === true ) {
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
    $nodes = config('xtension.admin_menu', []);
    foreach ($nodes as $node => $value ) {
      if ( !isset($value['disabled'])) {
        if ( isset($value['is_label'])) {
          add_menu_page(
            $value['label'],
            $value['label'],
            '',
            'admin_menu_label_'  . $node,
            '',
            '&nbsp;',
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
    $disabled = config('xtension.admin_menu.customizer.disabled', false);
    if (!isset($disabled) && $disabled === true) {
      $customize_url = add_query_arg( 'return', urlencode( remove_query_arg( wp_removable_query_args(), wp_unslash( $_SERVER['REQUEST_URI'] ) ) ), 'customize.php' );
      remove_submenu_page( 'themes.php', $customize_url );
    }
  }

  /**
   * @throws EntryNotFoundException
   */
  public function maybeDisableWooCommerceSeparator(): void
  {
    $disabled = config('xtension.admin_menu.woocommerce_separator.disabled', false);
    if (isset($disabled) && $disabled === true) {
      echo '<style> #adminmenu .wp-not-current-submenu.wp-menu-separator.woocommerce { display: none !important; }</style>';
    }
  }
}