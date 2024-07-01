<?php

namespace DigitalBrew\Xtension\Modules;

use DigitalBrew\Hooks\Action;
use DigitalBrew\Hooks\Filter;
use Illuminate\Contracts\Container\BindingResolutionException;

class Comments
{
  /**
   * @throws BindingResolutionException
   */
  public static function register(): void
  {
    $instance = new self();

    if (!getConfig('xtension.comments.enabled')) {
      $instance->disableComments();
    }
  }

  public function disableComments(): void
  {
    Action::add( 'admin_init', function () {
      // Redirect any user trying to access comments page
      global $pagenow;

      if ( $pagenow === 'edit-comments.php' || $pagenow === 'options-discussion.php' ) {
        wp_redirect( admin_url() );
        exit;
      }

      // Remove comments metabox from dashboard
      remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );

      // Disable support for comments and trackbacks in post types
      foreach ( get_post_types() as $post_type ) {
        if ( post_type_supports( $post_type, 'comments' ) ) {
          remove_post_type_support( $post_type, 'comments' );
          remove_post_type_support( $post_type, 'trackbacks' );
        }
      }
    } );

    // Close comments on the front-end
    Filter::add( 'comments_open', '__return_false', 20, 2 );
    Filter::add( 'pings_open', '__return_false', 20, 2 );

    // Hide existing comments
    Filter::add( 'comments_array', '__return_empty_array', 10, 2 );

    // Remove comments page in menu
    Action::add( 'admin_menu', function () {
      remove_menu_page( 'edit-comments.php' );
      remove_submenu_page( 'options-general.php', 'options-discussion.php' );
    } );

    // Remove comments links from admin bar
    Action::add( 'init', function () {
      if ( is_admin_bar_showing() ) {
        Action::remove( 'admin_bar_menu', 'wp_admin_bar_comments_menu', 60 );
      }
    } );

    // Remove comments icon from admin bar
    Action::add( 'wp_before_admin_bar_render', function () {
      global $wp_admin_bar;
      $wp_admin_bar->remove_menu( 'comments' );
    } );

    // Return a comment count of zero to hide existing comment entry link.
    Filter::add( 'get_comments_number', function ( $count ) {
      return 0;
    } );

    // Multisite - Remove manage comments from admin bar
    Action::add( 'admin_bar_menu', function ( $bar ) {
      $sites = get_blogs_of_user( get_current_user_id() );
      foreach ( $sites as $site ) {
        $bar->remove_node( "blog-{$site->userblog_id}-c" );
      }
    }, PHP_INT_MAX - 1 );
  }
}