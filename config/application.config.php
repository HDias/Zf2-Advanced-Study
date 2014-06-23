<?php
return array(
    'modules' => array(
        'Application',
        'DoctrineModule',
        'DoctrineORMModule',
        'DoctrineDataFixtureModule',
        'SONBase'
    ),
    'module_listener_options' => array(
        'module_paths' => array(
            './module',
            './vendor'
        ),
        
        'config_glob_paths' => array(
            'config/autoload/{,*.}{global,local}.php',
            // com essa linha a base de dados que será utilizada é a de test
            // retirando volta para o padrão
            __DIR__ . '/test.config.php'
        )
    )
);
