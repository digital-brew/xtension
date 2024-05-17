<?php return array(
    'root' => array(
        'name' => 'digital-brew/xtension',
        'pretty_version' => 'dev-main',
        'version' => 'dev-main',
        'reference' => '75c397c29bd6805cfb5cf2888aaa76c3d63ddc78',
        'type' => 'wordpress-plugin',
        'install_path' => __DIR__ . '/../../',
        'aliases' => array(),
        'dev' => true,
    ),
    'versions' => array(
        'composer/installers' => array(
            'pretty_version' => 'v2.2.0',
            'version' => '2.2.0.0',
            'reference' => 'c29dc4b93137acb82734f672c37e029dfbd95b35',
            'type' => 'composer-plugin',
            'install_path' => __DIR__ . '/./installers',
            'aliases' => array(),
            'dev_requirement' => false,
        ),
        'digital-brew/hooks' => array(
            'pretty_version' => 'dev-main',
            'version' => 'dev-main',
            'reference' => '0be9ae73809be5f83e2bd5a789bef8539ccfa35f',
            'type' => 'library',
            'install_path' => __DIR__ . '/../digital-brew/hooks',
            'aliases' => array(
                0 => '9999999-dev',
            ),
            'dev_requirement' => false,
        ),
        'digital-brew/xtension' => array(
            'pretty_version' => 'dev-main',
            'version' => 'dev-main',
            'reference' => '75c397c29bd6805cfb5cf2888aaa76c3d63ddc78',
            'type' => 'wordpress-plugin',
            'install_path' => __DIR__ . '/../../',
            'aliases' => array(),
            'dev_requirement' => false,
        ),
    ),
);
