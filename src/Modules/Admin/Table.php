<?php

namespace DigitalBrew\Xtension\Modules\Admin;

use DigitalBrew\Hooks\Action;
use DigitalBrew\Hooks\Filter;
use Illuminate\Support\Str;

class Table
{
    public static function register(): void
    {
        $instance = new self;

        if (getConfig('xtension.admin.table') !== null) {
            $instance->removeTableColumns();
            $instance->addTableColumns();
            $instance->removeActionLinks();
        }
    }

    public function removeTableColumns(): void
    {
        $tables = getConfig('xtension.admin.table', []);

        foreach ($tables as $name => $value) {
            if (isset($value['columns']) && ! empty($value['columns']['remove'])) {
                Filter::add('manage_'.$name.'_columns', function ($column_headers) use ($value) {
                    $columns = $value['columns']['remove'];

                    foreach ($columns as $column) {
                        unset($column_headers[$column]);
                    }

                    return $column_headers;
                });
            }
        }
    }

    public function addTableColumns(): void
    {
        $tables = getConfig('xtension.admin.table', []);

        foreach ($tables as $name => $value) {
            $columns = $value['columns']['add'];

            foreach ($columns as $column) {
                if ($column === 'registration_date') {
                    $this->addRegistrationDateUsersSortableColumn();
                }
                if ($column === 'last_login') {
                    $this->addLastLoginUsersSortableColumn();
                }
                if ($column === 'total_sales') {
                    $this->addTotalSalesProductsSortableColumn();
                }
                if ($column === 'purchased') {
                    $this->addPurchasedProductsOrdersColumn();
                }
            }
        }
    }

    public function addRegistrationDateUsersSortableColumn(): void
    {
        /*
   * Creating a column (it is also possible to remove some default ones)
   */
        Filter::add('manage_users_columns', function ($columns) {
            $columns['registration_date'] = 'Registration date';

            return $columns;
        });

        /*
         * Fill our new column with registration dates of the users
         */
        Filter::add('manage_users_custom_column', function ($row_output, $column_id_attr, $user) {
            $date_format = get_option('date_format');
            $time_format = get_option('time_format');
            $date_time_format = $date_format.' '.$time_format;

            switch ($column_id_attr) {
                case 'registration_date' :
                    return date($date_time_format, strtotime(get_the_author_meta('registered', $user)));
                    break;

                default:
                    break;

            }

            return $row_output;
        }, 10, 3);

        /*
         * Make our "Registration date" column sortable
         */
        Filter::add('manage_users_sortable_columns', function ($columns) {
            return wp_parse_args(['registration_date' => 'registered'], $columns);
        });
    }

    public function addLastLoginUsersSortableColumn(): void
    {
        Filter::add('manage_users_columns', function ($columns) {
            $columns['last_login'] = 'Last Login'; // column ID / column Title

            return $columns;
        });

        Filter::add('manage_users_custom_column', function ($output, $column_id, $user_id) {
            if ($column_id == 'last_login') {
                $date_format = get_option('date_format');
                $time_format = get_option('time_format');
                $date_time_format = $date_format.' '.$time_format;

                $last_login = get_user_meta($user_id, 'last_login', true);

                $output = $last_login ? date($date_time_format, strtotime($last_login)) : '&mdash;';
            }

            return $output;
        }, 10, 3);

        Filter::add('manage_users_sortable_columns', function ($columns) {
            return wp_parse_args([
                'last_login' => 'last_login',
            ], $columns);
        });

        Action::add('pre_get_users', function ($query) {
            if (! is_admin()) {
                return $query;
            }
            $screen = get_current_screen();

            if (isset($screen->id) && $screen->id !== 'users') {
                return $query;
            }
            if (isset($_GET['orderby']) && $_GET['orderby'] == 'last_login') {

                $query->query_vars['meta_key'] = 'last_login';
                $query->query_vars['orderby'] = 'meta_value';
            }

            return $query;
        });
    }

    public function addTotalSalesProductsSortableColumn(): void
    {
        Filter::add('manage_edit-product_columns', function ($column_name) {
            return wp_parse_args(
                [
                    'total_sales' => 'Total Sales',
                ],
                $column_name
            );
        });

        Action::add('manage_posts_custom_column', function ($column_name, $product_id) {
            if ($column_name === 'total_sales') {
                echo get_post_meta($product_id, 'total_sales', true);
            }
        }, 25, 2);

        Filter::add('manage_edit-product_sortable_columns', function ($sortable_columns) {
            return wp_parse_args(
                [
                    'total_sales' => 'by_total_sales',
                ],
                $sortable_columns
            );
        });

        Action::add('pre_get_posts', function ($query) {
            if (! is_admin() || empty($_GET['orderby']) || empty($_GET['order'])) {
                return $query;
            }

            if ($_GET['orderby'] === 'by_total_sales') {
                $query->set('meta_key', 'total_sales');
                $query->set('orderby', 'meta_value_num');
                $query->set('order', $_GET['order']);
            }

            return $query;
        });
    }

    public function addPurchasedProductsOrdersColumn(): void
    {
        // legacy – for CPT-based orders
        //    add_filter( 'manage_edit-shop_order_columns', 'misha_order_items_column' );
        // for HPOS-based orders
        Filter::add('manage_woocommerce_page_wc-orders_columns', function ($columns) {

            // let's add our column before "Total"
            return array_slice($columns, 0, 4, true) // 4 columns before
                   + ['order_products' => 'Purchased products'] // our column is going to be 5th
                   + array_slice($columns, 4, null, true);

        });

        // legacy – for CPT-based orders
        //    add_action( 'manage_shop_order_posts_custom_column', 'misha_populate_order_items_column', 25, 2 );
        // for HPOS-based orders
        Action::add('manage_woocommerce_page_wc-orders_custom_column', function ($column_name, $order_or_order_id) {

            // legacy CPT-based order compatibility
            $order = $order_or_order_id instanceof WC_Order ? $order_or_order_id : wc_get_order($order_or_order_id);

            if ($column_name === 'order_products') {
                $items = $order->get_items();
                if (! is_wp_error($items)) {
                    foreach ($items as $item) {
                        echo $item['quantity'].' × <a href="'.get_edit_post_link($item['product_id']).'">'.$item['name'].'</a><br />';
                        // you can also use $order_item->variation_id parameter
                        // by the way, $item[ 'name' ] will display variation name too
                    }
                }
            }
        }, 25, 2);
    }

    public function removeActionLinks(): void
    {
        $tables = getConfig('xtension.admin.table', []);

        foreach ($tables as $name => $value) {
            if (isset($value['actions']) && ! empty($value['actions']['remove'])) {
                $nameSingular = Str::singular($name);

                Filter::add($nameSingular.'_row_actions', function ($actions, $object) use ($value) {
                    $options = $value['actions']['remove'];
                    foreach ($options as $option) {
                        if (isset($actions[$option])) {
                            unset($actions[$option]);
                        }
                    }

                    return $actions;
                });
            }
        }
    }
}

