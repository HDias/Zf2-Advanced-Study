<?php
namespace Application;

return array(
    'doctrine' => array(
        'driver' => array(
            __NAMESPACE__ . '_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(
                    __DIR__ . '/../src/' . __NAMESPACE__ . '/Entity'
                )
            ),
            'orm_default' => array(
                'drivers' => array(
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
                )
            )
        )
    ),
    
    'controllers' => array(
        'invokables' => array(
            'Application\Controller\Index' => 'Application\Controller\IndexController'
        )
    ),
    
    'router' => array(
        'routes' => array(
            'home' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action' => 'index'
                    )
                )
            ),
            'application' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/application',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller' => 'Index',
                        'action' => 'index'
                    )
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/[:controller[/:action]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*'
                            ),
                            'defaults' => array()
                        )
                    )
                )
            ),
            /*
            'article' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/article',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action' => 'article'
                    )
                )
            ),
            'article-regex' => array(
                'type' => 'Zend\Mvc\Router\Http\Regex',
                'options' => array(
                    'regex' => '/regex/article/(?P<id>\d+)',
                    'spec' => '/regex/article/%id%',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action' => 'article'
                    )
                )
            ),
            'article-wildcard' => array(
                'type' => 'Zend\Mvc\Router\Http\Wildcard',
                'options' => array(
                    'route' => '/wild/article/',
                    // http://zf2.advanced.h/wild/article/id-1/name-Horecio
                    'key_value_delimiter' => '-',
                    'param_delimiter' => '/',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action' => 'article'
                    )
                )
            ),
            'article-segment' => array(
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => array(
                    'route' => '/segment/article[/:id]',
                    'constraints' => array(
                        'id' => '\d+'
                    ),
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action' => 'article'
                    )
                )
            ),
            'article-treeroute' => array(
            		'type' => 'Zend\Mvc\Router\Http\Literal',
            		'options' => array(
            				'route' => '/tree/article',
            				'defaults' => array(
            						'controller' => 'Application\Controller\Index',
            				)
            		),
                    'may_terminate' => true,
                    'child_routes' => array(
                        'article' => array(
            				'type' => 'Zend\Mvc\Router\Http\Segment',
                            'options' => array(
                                'route' => '/:id',
                                'constraints' => array(
                                    'id' => '\d+'
                                ),
                                'defaults' => array(
                                		'action' => 'article',
                                )
            				)
                        )
                    )   
                )*/
            )
    ),
    'service_manager' => array(
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory'
        ),
        'aliases' => array(
            'translator' => 'MvcTranslator'
        )
    ),
    /*
     * tranlator com phparray e gettext
     */
    'translator' => array(
        'locale' => 'pt_BR',
        'translation_file_patterns' => array(
            array(
                'type' => 'gettext',
                // 'type' => 'phparray',
                // 'base_dir' => __DIR__ . '/../language',
                // 'base_dir' => __DIR__ . '/../languageArray',
                'base_dir' => __DIR__ . '/../languageGetText',
                'pattern' => '%s.mo'
            // 'pattern' => '%s.php',
                        )
        )
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions' => true,
        'doctype' => 'HTML5',
        'not_found_template' => 'error/404',
        'exception_template' => 'error/index',
        'template_map' => array(
            'layout/layout' => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404' => __DIR__ . '/../view/error/404.phtml',
            'error/index' => __DIR__ . '/../view/error/index.phtml'
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view'
        )
    ),
    // Placeholder for console routes
    'console' => array(
        'router' => array(
            'routes' => array()
        )
    )
)











;




