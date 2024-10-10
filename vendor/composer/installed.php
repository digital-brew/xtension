<?php return array(
    'root' => array(
        'name' => 'digital-brew/xtension',
        'pretty_version' => 'dev-main',
        'version' => 'dev-main',
        'reference' => '375019bcce2a1740bf7ae41872bd320006cfc74b',
        'type' => 'wordpress-plugin',
        'install_path' => __DIR__ . '/../../',
        'aliases' => array(),
        'dev' => true,
    ),
    'versions' => array(
        'composer/installers' => array(
            'pretty_version' => 'v2.3.0',
            'version' => '2.3.0.0',
            'reference' => '12fb2dfe5e16183de69e784a7b84046c43d97e8e',
            'type' => 'composer-plugin',
            'install_path' => __DIR__ . '/./installers',
            'aliases' => array(),
            'dev_requirement' => false,
        ),
        'digital-brew/hooks' => array(
            'pretty_version' => 'dev-main',
            'version' => 'dev-main',
            'reference' => '094cba710c98f9790cfe626d0e3ebba222217fe5',
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
            'reference' => '375019bcce2a1740bf7ae41872bd320006cfc74b',
            'type' => 'wordpress-plugin',
            'install_path' => __DIR__ . '/../../',
            'aliases' => array(),
            'dev_requirement' => false,
        ),
    ),
);
