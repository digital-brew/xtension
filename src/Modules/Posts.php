<?php

namespace DigitalBrew\Xtension\Modules;

use DigitalBrew\Hooks\Action;
use Illuminate\Contracts\Container\BindingResolutionException;

class Posts
{
  /**
   * @throws BindingResolutionException
   */
  public static function init(): void
  {
    $instance = new self();

    if (!getConfig('xtension.posts.enabled')) {
      Action::add( 'init', [ $instance, 'deregisterPosts' ] );
    }
  }

  public function deregisterPosts(): void
  {
    // Unregister post type
    register_post_type('post', []);
    // Unregister categories
    register_taxonomy('category', []);
    // Unregister tags
    register_taxonomy('post_tag', []);
    // Unregister widget
    unregister_widget('WP_Widget_Categories');
  }
}