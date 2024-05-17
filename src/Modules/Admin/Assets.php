<?php

namespace DigitalBrew\Xtension\Modules\Admin;

use DigitalBrew\Hooks\Action;
use Illuminate\Container\EntryNotFoundException;

class Assets
{
  public string $assets_path;

  public string $version;

  public function __construct()
  {
    $plugin_data = get_plugin_data( WP_PLUGIN_DIR . '/xtension/xtension.php');
    $this->version = $plugin_data['Version'];
    $this->assets_path = plugins_url('xtension/dist/');
  }

  /**
   * @throws EntryNotFoundException
   */
  public static function init(): void
  {
    $instance = new self();
    if (config('xtension.admin.new_look', false)) {
      $instance->loadScripts();
      $instance->reloadStyles();
      $instance->loadFonts();
    }
  }

  public function loadScripts(): void
  {
    Action::add( 'admin_enqueue_scripts', function() {
      if ($this->canLoadAssets()) {
        wp_enqueue_script( 'admin-scripts', $this->assets( 'scripts/app.js' ), [], $this->getVersion(), true );
      }
    }, 999 );
  }

  public function reloadStyles(): void
  {
    $styles = ['admin-bar', 'admin-menu', 'buttons', 'common', 'custom', 'dashboard', 'edit', 'forms', 'list-tables', 'nav-menus'];

    $this->deregisterStyles($styles);
    $this->registerStyles($styles);
  }

  public function deregisterStyles($styles): void
  {
    Action::add('admin_init', function($hook) use ($styles) {
      if ($this->canLoadAssets()) {
        foreach ( $styles as $style ) {
          wp_deregister_style( $style );
        }
      }
    }, 999);
  }

  public function registerStyles($styles): void
  {
    Action::add('admin_enqueue_scripts', function($hook) use ($styles) {
      if ($this->canLoadAssets()) {
        foreach ( $styles as $style ) {
          wp_enqueue_style( $style, $this->assets( 'styles/' . $style . '.css' ), [], $this->getVersion() );
        }
      }
    }, 999);
  }

  public function loadFonts(): void
  {
    Action::add( 'admin_head', function($hook) {
      if ($this->canLoadAssets()) {
        echo '
          <link rel="preconnect" href="https://fonts.googleapis.com">
          <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
          <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
        ';
      }
    }, 999 );
  }

  public function assets($asset): string
  {
    return $this->assets_path . $asset;
  }

  public function getVersion(): string
  {
    return $this->version;
  }

  public function canLoadAssets(): bool
  {
    $url = $_SERVER['REQUEST_URI'];

    return !((str_contains($url, 'post-new.php') or str_contains($url, 'action=edit')) and !str_contains($url, 'post_type=acf-field-group'));
  }
}