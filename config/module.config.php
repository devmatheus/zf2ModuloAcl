<?php

return array(
    'Acl' => array(
        'js_controller' => array(
            'admin/acl-permissoes' => array(
                'novo' => array(
                    '/js/form-permissoes.js'
                )
            )
        )
    ),
    'asset_manager' => array(
        'resolver_configs' => array(
            'paths' => array(
                'Acl' => __DIR__ . '/../assets'
            )
        )
    ),
    'entities' => array(
        'Acl\Entity\Grupo'     => 'Acl\Entity\Grupo',
        'Acl\Entity\Recurso'   => 'Acl\Entity\Recurso',
        'Acl\Entity\Permissao' => 'Acl\Entity\Permissao'
    ),
    'services' => array(
        'Acl\Service\Grupo'     => 'Acl\Service\Grupo',
        'Acl\Service\Recurso'   => 'Acl\Service\Recurso',
        'Acl\Service\Permissao' => 'Acl\Service\Permissao'
    ),
    'forms' => array(
        'Acl\Form\Grupo'     => 'Acl\Form\Grupo',
        'Acl\Form\Recurso'   => 'Acl\Form\Recurso',
        'Acl\Form\Permissao' => 'Acl\Form\Permissao'
    ),
    'router' => array(
        'routes' => array(
            'admin-acl-grupos' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/admin/acl-grupos/:action[/:id]',
                    'constraints' => array(
                        'id'     => '\d+',
                        'action' => '[a-zA-Z0-9_-]+'
                    ),
                    'defaults' => array(
                        'action'     => 'index',
                        'controller' => 'admin/acl-grupos'
                    )
                )
            ),
            'admin-acl-recursos' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/admin/acl-recursos/:action[/:id]',
                    'constraints' => array(
                        'id'     => '\d+',
                        'action' => '[a-zA-Z0-9_-]+',
                    ),
                    'defaults' => array(
                        'action'     => 'index',
                        'controller' => 'admin/acl-recursos'
                    )
                )
            ),
            'admin-acl-permissoes' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/admin/acl-permissoes/:action[/:id]',
                    'constraints' => array(
                        'id' => '\d+',
                        'action' => '[a-zA-Z0-9_-]+'
                    ),
                    'defaults' => array(
                        'action'     => 'index',
                        'controller' => 'admin/acl-permissoes'
                    )
                )
            )
        )
    ),
    'controllers' => array(
        'invokables' => array(
            'admin/acl-grupos'     => 'Acl\Controller\GruposController',
            'admin/acl-recursos'   => 'Acl\Controller\RecursosController',
            'admin/acl-permissoes' => 'Acl\Controller\PermissoesController'
        )
    ),
    'module_layouts' => array(
        'Acl' => 'layout/admin'
    ),
    'doctrine' => array(
        'driver' => array(
            'Acl_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/Acl/Entity')
            ),
            'orm_default' => array(
                'drivers' => array(
                    'Acl\Entity' => 'Acl_driver'
                )
            )
        )
    ),
    'navigation' => array(
        'default' => array(
            'configuracoes' => array(
                'pages' => array(
                    'usuarios' => array(
                        'pages' => array(
                            'grupos' => array(
                                'label' => 'Grupos',
                                'route' => 'admin-acl-grupos',
                                'pages' => array(
                                    'lista' => array(
                                        'label' => 'Lista de registros',
                                        'route' => 'admin-acl-grupos',
                                        'action' => 'index'
                                    ),
                                    'novo' => array(
                                        'label' => 'Novo registro',
                                        'route' => 'admin-acl-grupos',
                                        'action' => 'novo'
                                    )
                                )
                            )
                        )
                    ),
                    'acesso' => array(
                        'label' => 'Controle de acesso&nbsp;&nbsp;',
                        'route' => 'acl-recurso',
                        'pages' => array(
                            'recursos' => array(
                                'label' => 'Recursos',
                                'route' => 'admin-acl-recursos',
                                'pages' => array(
                                    'lista' => array(
                                        'label' => 'Lista de registros',
                                        'route' => 'admin-acl-recursos',
                                        'action' => 'index'
                                    ),
                                    'novo' => array(
                                        'label' => 'Novo registro',
                                        'route' => 'admin-acl-recursos',
                                        'action' => 'novo'
                                    )
                                )
                            ),
                            'permissao' => array(
                                'label' => 'Permissões',
                                'route' => 'admin-acl-permissoes',
                                'pages' => array(
                                    'lista' => array(
                                        'label' => 'Lista de registros',
                                        'route' => 'admin-acl-permissoes',
                                        'action' => 'index'
                                    ),
                                    'novo' => array(
                                        'label' => 'Novo registro',
                                        'route' => 'admin-acl-permissoes',
                                        'action' => 'novo'
                                    )
                                )
                            )
                        )
                    )
                )
            )
        )
    )
);
