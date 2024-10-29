<?php

return [
  /*
  |--------------------------------------------------------------------------
  | Admin Brewer plugin settings
  |--------------------------------------------------------------------------
  |
  | This array of conditions is used by the Admin Brewer plugin to enable or disable
  | WordPress options.
  |
  */
  'colors' => [
      'accent' => '#0fc0c0',
      'accent_light' => '#DCFCFC',
      'accent_dark' => '#053E3E',
      'accent_bg' => '#edf7f7'
  ],
  'admin' => [
    'dashboard' => [
      'widgets' => [
        'wp_welcome_panel' => [
          'enabled' => false
        ],
        'dashboard_site_health' => [
          'enabled' => false
        ],
        'dashboard_right_now' => [
          'enabled' => false
        ],
        'dashboard_activity' => [
          'enabled' => false
        ],
        'dashboard_primary' => [
          'enabled' => false
        ],
        'dashboard_quick_press' => [
          'enabled' => false
        ],
        'woocommerce_dashboard_recent_reviews' => [
          'enabled' => false
        ],
        'network_dashboard_right_now' => [
          'enabled' => false
        ],
        'network_dashboard_wordpress_events_and_news' => [
          'enabled' => false
        ]
      ]
    ],
    'footer_text' => 'Developed by <a href="https://www.digitalbrew.io" target="_blank">DigitalBrew</a>, WooCommerce and Shopify digital agency.',
    'menu' => [
      'customizer' => [
        'enabled' => false
      ],
      'widgets' => [
        'enabled' => false,
        'menu_slug' => 'themes.php',
        'submenu_slug' => 'widgets.php'
      ],
      'writing' => [
        'enabled' => false,
        'menu_slug' => 'options-general.php',
        'submenu_slug' => 'options-writing.php'
      ],
      'updates' => [
        'enabled' => false,
        'menu_slug' => 'index.php',
        'submenu_slug' => 'update-core.php'
      ],
      'wc_addons' => [
        'enabled' => false,
        'menu_slug' => 'woocommerce',
        'submenu_slug' => 'wc-admin&path=/extensions'
      ],
      'woocommerce_separator' => [
        'enabled' => false
      ],
      'administration' => [
        'enabled' => true,
        'label' => 'Administration',
        'position' => 59,
        'is_label' => true
      ],
      'development' => [
        'enabled' => true,
        'label' => 'Development',
        'position' => 80,
        'is_label' => true
      ]
    ],
    'new_look' => true,
    'network_menu' => [
      'updates' => [
        'enabled' => false,
        'menu_slug' => 'index.php',
        'submenu_slug' => 'update-core.php'
      ],
    ],
    'table' => [
      'users' => [
        'actions' => [
          'remove' => [] // available options: edit, remove, view
        ],
        'columns' => [
          'add' => ['last_login', 'registration_date'], // available options: registration_date, last_login
          'remove' => [] // available options: username, name, email, role, posts
        ]
      ],
      'pages' => [
        'actions' => [
          'remove' => [] // available options: edit, trash, view, inline hide-if-no-js
        ],
        'columns' => [
          'add' => [],
          'remove' => []
        ]
      ],
      'edit-product' => [
        'actions' => [
          'remove' => [] // available options: edit, trash, view, inline hide-if-no-js
        ],
        'columns' => [
          'add' => ['total_sales'],
          'remove' => ['product_tag', 'featured']
        ]
      ],
      'orders' => [
        'actions' => [
          'remove' => [] // available options: edit, trash, view, inline hide-if-no-js
        ],
        'columns' => [
          'add' => ['purchased'],
          'remove' => []
        ]
      ]
    ],
  ],
  'frontend' => [
    'emoji' => [
      'enabled' => false,
    ],
    'feed' => [
      'enabled' => false,
    ],
    'meta_tags' => [
      'enabled' => false,
    ],
    'jquery' => [
      'main' => [
        'enabled' => true,
        'use_cdn' => true,
        'custom_version' => null
      ],
      'migrate' => [
        'enabled' => true,
        'use_cdn' => true,
        'custom_version' => null
      ]
    ]
  ],
  'admin_bar' => [
    'nodes' => [
      'archive' => [
        'enabled' => false
      ],
      'comments' => [
        'enabled' => false
      ],
      'customize' => [
        'enabled' => false
      ],
      'edit' => [
        'enabled' => true
      ],
      'menu-toggle' => [
        'enabled' => false
      ],
      'my-account' => [
        'enabled' => true
      ],
      'new-content' => [
        'enabled' => false
      ],
      'site-name' => [
        'enabled' => true
      ],
      'widgets' => [
        'enabled' => false
      ],
      'wp-logo' => [
        'enabled' => false
      ]
    ],
    'show' => [
      'administrator' => true,
      'other_roles' => false
    ]
  ],
  'comments' => [
    'enabled' => false
  ],
  'posts' => [
    'enabled' => false
  ],
  'last_login_timestamp' => [
    'enabled' => true
  ]
];
