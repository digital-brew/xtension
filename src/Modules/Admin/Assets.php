<?php

namespace DigitalBrew\Xtension\Modules\Admin;

use DigitalBrew\Hooks\Action;
use Illuminate\Contracts\Container\BindingResolutionException;

class Assets
{
  public string $assets_path;

  public string $version;

  public function __construct()
  {
    if( !function_exists('get_plugin_data') ){
      require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
    }
    
    $plugin_data = get_plugin_data( WP_PLUGIN_DIR . '/xtension/xtension.php');
    $this->version = $plugin_data['Version'];
    $this->assets_path = plugins_url('xtension/dist/');
  }

  /**
   * @throws BindingResolutionException
   */
  public static function register(): void
  {
    $instance = new self();
    if (getConfig('xtension.admin.new_look', false)) {
      $instance->loadScripts();
      $instance->reloadStyles();
      $instance->loadFonts();
    }
  }

  /**
   * @throws BindingResolutionException
   */
  public function loadScripts(): void
  {
    if ($this->canLoadAssets()) {
      Action::add( 'admin_enqueue_scripts', function() {
        wp_enqueue_script( 'admin-scripts', $this->assets( 'scripts/app.js' ), [], $this->getVersion(), true );
      }, 999 );
    }
  }

  public function reloadStyles(): void
  {
    $styles = [
      'admin-bar',
      'admin-menu',
      'buttons',
      'common',
      'custom',
      'dashboard',
      'edit',
      'forms',
      'list-tables',
      'nav-menus',
      'block-editor',
      'wc-styles'
    ];

    $this->deregisterStyles($styles);
    $this->registerStyles($styles);
  }

  /**
   * @throws BindingResolutionException
   */
  public function deregisterStyles($styles): void
  {
    if ($this->canLoadAssets()) {
      Action::add('admin_init', function($hook) use ($styles) {
        foreach ( $styles as $style ) {
          wp_deregister_style( $style );
        }
      }, 999);
    }
  }

  /**
   * @throws BindingResolutionException
   */
  public function registerStyles($styles): void
  {
    if ($this->canLoadAssets()) {
      Action::add('admin_enqueue_scripts', function($hook) use ($styles) {
        foreach ( $styles as $style ) {
          wp_enqueue_style( $style, $this->assets( 'styles/' . $style . '.css' ), [], $this->getVersion() );
        }
      }, 999);
    }
  }

  /**
   * @throws BindingResolutionException
   */
  public function loadFonts(): void
  {
    if ($this->canLoadAssets()) {
      Action::add( 'admin_head', function($hook) {
        echo '
          <link rel="preconnect" href="https://fonts.googleapis.com">
          <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
          <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
        ';
      }, 999 );
    }
  }

  public function assets($asset): string
  {
    return $this->assets_path . $asset;
  }

  public function getVersion(): string
  {
    return $this->version;
  }

  /**
   * @throws BindingResolutionException
   */
  public function canLoadAssets(): bool
  {
    $url = $_SERVER['REQUEST_URI'];
    $is_post_enabled = true;
    if ( getConfig( 'xtension.cpt.activate_on' ) !== null && get_post_type() !== false) {
      $is_post_enabled = in_array(get_post_type(), getConfig('xtension.cpt.activate_on'));
    }
    return !((str_contains($url, 'post-new.php') or str_contains($url, 'action=edit')) and !str_contains($url, 'post_type=acf-field-group')) or $is_post_enabled;
  }
}
