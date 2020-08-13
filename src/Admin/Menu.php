<?php

namespace Rafflex\AdminSetupXtension\Admin;

class Menu
{
    public function removePages()
    {
        remove_menu_page('index.php');
        remove_menu_page('themes.php');
    }

    public function removeSubPages()
    {
        remove_submenu_page('index.php', 'update-core.php');
        remove_submenu_page('themes.php', 'customize.php');
        remove_submenu_page('themes.php', 'nav-menus.php');
    }

    public function addPages()
    {
        // Overview
        add_menu_page(
            __('Overview', THEME_TD),
            __('Overview', THEME_TD),
            'edit_posts',
            'index.php',
            '',
            'dashicons-dashboard',
            4
        );
        // Menu Editor
        add_menu_page(
            __('Menu Editor', THEME_TD),
            __('Menu Editor', THEME_TD),
            'edit_posts',
            'nav-menus.php',
            '',
            'dashicons-menu',
            59
        );
        // Reusable Blocks
        add_menu_page(
            __('All Reusable Blocks', THEME_TD),
            __('Reusable Blocks', THEME_TD),
            'edit_posts',
            'edit.php?post_type=wp_block',
            '',
            'dashicons-editor-table',
            40
        );
        // Developer
        add_menu_page(
            __('Themes', THEME_TD),
            __('Developer', THEME_TD),
            'edit_posts',
            'themes.php',
            '',
            'dashicons-forms',
            120
        );
    }

    public function addReusableBlocks()
    {
        add_submenu_page( 'edit.php?post_type=wp_block', 'Add New Reusable Block', 'Add New',
            'edit_posts', 'post-new.php?post_type=wp_block');
    }
}
