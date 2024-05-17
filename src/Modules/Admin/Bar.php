<?php

namespace DigitalBrew\Xtension\Modules\Admin;

use DigitalBrew\Hooks\Action;
use Illuminate\Contracts\Container\BindingResolutionException;

class Bar
{
  public static function init(): void
  {
    $instance = new self();

    Action::add('admin_bar_menu', [$instance, 'disableBarNodes'], 999);
    Action::add('admin_bar_menu', [$instance, 'enableBarNodes'], 100);
  }

  /**
   * @throws BindingResolutionException
   */
  public function disableBarNodes( $admin_bar ): void
  {
    $nodes = getConfig('xtension.admin.bar.nodes', []);
    foreach ($nodes as $node => $value) {
      if ( isset($value['enabled']) && $value['enabled'] === false ) {
        $admin_bar->remove_node($node);
      }
    }
  }

  /**
   * @throws BindingResolutionException
   */
  public function enableBarNodes( $admin_bar ): void
  {
    $nodes = getConfig('xtension.admin.bar.nodes', []);
    foreach ($nodes as $node => $value) {
      if (isset($value['enabled']) && $value['enabled'] === true && isset($value['title'])) {
        $props = [
          'id' => $node,
          'title' => $value['title'],
          'href' => $value['href'],
        ];

        if (isset($value['parent'])) {
          $props['parent'] = $value['parent'];
        }

        if (is_multisite() && str_contains($node, 'blog') ) {
          if (preg_match('/\d+/', $node, $matches)) {
            $blog_id = $matches[0]; // $matches[0] contains the first match found
            $domain = get_blogaddress_by_id($blog_id);
            $props['href'] = rtrim($domain, '/') . $value['href'];
          }
        }

        $admin_bar->add_node($props);
      }
    }
  }
}