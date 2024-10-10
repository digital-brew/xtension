<?php

namespace DigitalBrew\Xtension\Modules;

use DigitalBrew\Hooks\Action;

class Posts
{
    public static function register(): void
    {
        $instance = new self;

        if (! getConfig('xtension.posts.enabled')) {
            Action::add('init', [$instance, 'deregisterPosts']);
        }

        if (getConfig('xtension.admin.user.list.remove_columns') !== null) {
            add_filter('manage_users_columns', [$instance, 'removeUserArchiveColumn']);
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

