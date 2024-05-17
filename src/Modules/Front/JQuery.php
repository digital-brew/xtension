<?php

  namespace DigitalBrew\Xtension\Modules\Front;

  use DigitalBrew\Hooks\Action;
  use DigitalBrew\Hooks\Filter;
  use Illuminate\Contracts\Container\BindingResolutionException;

  class JQuery
  {
    /**
     * @throws BindingResolutionException
     */
    public static function init(): void
    {
      $instance = new self();

      $instance->deregister();
      $instance->deregisterMigrate();
      $instance->loadFromCDN();
    }

    /**
     * @throws BindingResolutionException
     */
    public function deregister(): void
    {
      if (!getConfig('xtension.frontend.jquery.main.enabled')) {
        Action::add( 'init', function () {
          if (! is_admin()) {
            wp_deregister_script('jquery');
            wp_register_script('jquery', false);
          }
        });
      }
    }

    /**
     * @throws BindingResolutionException
     */
    public function deregisterMigrate(): void
    {
      if (!getConfig('xtension.frontend.jquery.migrate.enabled')) {
        Action::add( 'wp_default_scripts', function ( $scripts ) {
          if ( ! is_admin() && isset( $scripts->registered['jquery'] ) ) {
            $script = $scripts->registered['jquery'];

            if ( $script->deps ) { // Check whether the script has any dependencies
              $script->deps = array_diff( $script->deps, [ 'jquery-migrate' ] );
            }
          }
        });
      }
    }

    /**
     * @throws BindingResolutionException
     */
    public function loadFromCDN(): void
    {
      if ((getConfig('xtension.frontend.jquery.main.enabled') && getConfig('xtension.frontend.jquery.main.use_cdn')) ||
          (getConfig('xtension.frontend.jquery.migrate.enabled') && getConfig('xtension.frontend.jquery.migrate.use_cdn'))) {
        Action::add( [ 'wp_enqueue_scripts', 'login_enqueue_scripts' ], function () {
          global $wp_version;

          if ( ! is_admin() ) {
            wp_enqueue_script( 'jquery' );

            // Get current version of jQuery from WordPress core
            $wp_jquery_ver         = $GLOBALS['wp_scripts']->registered['jquery-core']->ver;
            $wp_jquery_migrate_ver = $GLOBALS['wp_scripts']->registered['jquery-migrate']->ver;

            if (getConfig('xtension.frontend.jquery.main.custom_version') !== null) {
              $wp_jquery_ver = getConfig('xtension.frontend.jquery.main.custom_version');
            }

            if (getConfig('xtension.frontend.jquery.migrate.custom_version') !== null) {
              $wp_jquery_migrate_ver = getConfig('xtension.frontend.jquery.migrate.custom_version');
            }

            $jquery_cdn_url = '//ajax.googleapis.com/ajax/libs/jquery/' . $wp_jquery_ver . '/jquery.min.js';

            $jquery_migrate_cdn_url = '//cdnjs.cloudflare.com/ajax/libs/jquery-migrate/' . $wp_jquery_migrate_ver . '/jquery-migrate.min.js';

            // Register jQuery with CDN URL
            if (getConfig('xtension.frontend.jquery.main.enabled') && getConfig('xtension.frontend.jquery.main.use_cdn')) {
              wp_deregister_script( 'jquery-core' );
              wp_register_script( 'jquery-core', $jquery_cdn_url, '', null, true );
            }
            // Register jQuery Migrate with CDN URL
            if (getConfig('xtension.frontend.jquery.migrate.enabled') && getConfig('xtension.frontend.jquery.migrate.use_cdn')) {
              wp_deregister_script( 'jquery-migrate' );
              wp_register_script( 'jquery-migrate', $jquery_migrate_cdn_url, [ 'jquery-core' ], null, true );
            }
          }
        } );

        if (getConfig('xtension.frontend.jquery.main.enabled') && getConfig('xtension.frontend.jquery.main.use_cdn')) {
          Filter::add( 'script_loader_src', function ( $src, $handle = null ) {

            if ( ! is_admin() ) {

              static $add_jquery_fallback = false;

              if ( $add_jquery_fallback ) :
                echo '<script>window.jQuery || document.write(\'<script src="' . includes_url( 'js/jquery/jquery.js' ) . '"><\/script>\')</script>' . "\n";
                $add_jquery_fallback = false;
              endif;

              if ( $handle === 'jquery-core' ) {
                $add_jquery_fallback = true;
              }

              return $src;

            }

            return $src;

          }, 10, 2 );
        }
      }
    }
  }