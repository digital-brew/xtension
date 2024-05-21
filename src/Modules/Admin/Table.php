<?php

namespace DigitalBrew\Xtension\Modules\Admin;

use DigitalBrew\Hooks\Action;
use DigitalBrew\Hooks\Filter;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Str;

class Table
{
  /**
   * @throws BindingResolutionException
   */
  public static function init(): void
  {
    $instance = new self();


    if ( getConfig( 'xtension.admin.table' ) !== null ) {
      $instance->removeTableColumns();
      $instance->addTableColumns();
      $instance->removeActionLinks();
    }
  }

  /**
   * @throws BindingResolutionException
   */
  public function removeTableColumns(): void
  {
    $tables = getConfig('xtension.admin.table', []);

    foreach($tables as $name => $value) {
      if ( isset( $value['columns'] ) && ! empty( $value['columns']['remove'] ) ) {
        Filter::add( 'manage_' . $name . '_columns', function ( $column_headers ) use ( $value ) {
          $columns = $value['columns']['remove'];

          foreach ( $columns as $column ) {
            unset( $column_headers[ $column ] );
          }

          return $column_headers;
        } );
      }
    }
  }

  /**
   * @throws BindingResolutionException
   */
  public function addTableColumns(): void
  {
    $tables = getConfig('xtension.admin.table', []);

    foreach($tables as $name => $value) {
      $columns = $value['columns']['add'];

      foreach ($columns as $column) {
        if ($column === 'registration_date') {
          $this->addRegistrationDateSortableColumn();
        }
        if ($column === 'last_login') {
          $this->addLastLoginSortableColumn();
        }
      }
    }
  }

  public function addRegistrationDateSortableColumn(): void
  {
    /*
   * Creating a column (it is also possible to remove some default ones)
   */
    Filter::add( 'manage_users_columns', function ( $columns ) {
      $columns[ 'registration_date' ] = 'Registration date';
      return $columns;
    } );

    /*
     * Fill our new column with registration dates of the users
     */
    Filter::add( 'manage_users_custom_column', function( $row_output, $column_id_attr, $user ) {
      $date_format = get_option( 'date_format' );
      $time_format = get_option( 'time_format' );
      $date_time_format = $date_format . ' ' . $time_format;

      switch( $column_id_attr ) {
        case 'registration_date' : {
          return date( $date_time_format, strtotime( get_the_author_meta( 'registered', $user ) ) );
          break;
        }
        default: {
          break;
        }
      }

      return $row_output;
    }, 10, 3 );

    /*
     * Make our "Registration date" column sortable
     */
    Filter::add( 'manage_users_sortable_columns', function ( $columns ) {
      return wp_parse_args( array( 'registration_date' => 'registered' ), $columns );
    } );
  }

  public function addLastLoginSortableColumn(): void
  {
    Filter::add( 'manage_users_columns', function ( $columns ) {
      $columns['last_login'] = 'Last Login'; // column ID / column Title
      return $columns;
    } );

    Filter::add( 'manage_users_custom_column', function ( $output, $column_id, $user_id ){
      if( $column_id == 'last_login' ) {
        $date_format = get_option( 'date_format' );
        $time_format = get_option( 'time_format' );
        $date_time_format = $date_format . ' ' . $time_format;

        $last_login = get_user_meta( $user_id, 'last_login', true );

        $output = $last_login ? date( $date_time_format, strtotime( $last_login )) : '&mdash;';
      }
      return $output;
    }, 10, 3 );

    Filter::add( 'manage_users_sortable_columns', function ( $columns ) {
      return wp_parse_args( array(
        'last_login' => 'last_login'
      ), $columns );
    } );

    Action::add( 'pre_get_users', function ( $query ) {
      if( !is_admin() ) {
        return $query;
      }
      $screen = get_current_screen();

      if( isset( $screen->id ) && $screen->id !== 'users' ) {
        return $query;
      }
      if( isset( $_GET[ 'orderby' ] ) && $_GET[ 'orderby' ] == 'last_login' ) {

        $query->query_vars['meta_key'] = 'last_login';
        $query->query_vars['orderby'] = 'meta_value';
      }
      return $query;
    } );
  }

  /**
   * @throws BindingResolutionException
   */
  public function removeActionLinks(): void
  {
    $tables = getConfig('xtension.admin.table', []);

    foreach($tables as $name => $value) {
      if (isset($value['actions']) && !empty($value['actions']['remove'])) {
        $nameSingular = Str::singular( $name );

        Filter::add( $nameSingular . '_row_actions', function ( $actions, $object ) use ( $value ) {
          $options = $value['actions']['remove'];
          foreach ( $options as $option ) {
            if ( isset( $actions[$option] ) ) {
              unset( $actions[$option] );
            }
          }

          return $actions;
        });
      }
    }
  }
}