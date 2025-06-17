<?php
namespace ValueSuggestUpdater;

return [
    'controllers' => [
        'invokables' => [
            'ValueSuggestUpdater\Controller\Admin\Index' => Controller\Admin\IndexController::class,
        ],
    ],
    'form_elements' => [
        'factories' => [
            Form\UpdateForm::class => Service\Form\UpdateFormFactory::class,
        ],
    ],
    'navigation' => [
        'AdminModule' => [
            [
                'label' => 'Value Suggest Updater',
                'route' => 'admin/value-suggest-updater',
                'resource' => 'ValueSuggestUpdater\Controller\Admin\Index',
                'privilege' => 'update',
                'pages' => [
                    [
                        'label' => 'Update values', // @translate
                        'route' => 'admin/value-suggest-updater',
                    ],
                ],
            ],
        ],
    ],
    'service_manager' => [
        'factories' => [
            'ValueSuggestUpdater\UpdaterManager' => Service\UpdaterManagerFactory::class,
        ],
    ],
    'translator' => [
        'translation_file_patterns' => [
            [
                'type' => 'gettext',
                'base_dir' => sprintf('%s/../language', __DIR__),
                'pattern' => '%s.mo',
                'text_domain' => null,
            ],
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            dirname(__DIR__) . '/view',
        ],
    ],
    'router' => [
        'routes' => [
            'admin' => [
                'child_routes' => [
                    'value-suggest-updater' => [
                        'type' => 'Literal',
                        'options' => [
                            'route' => '/value-suggest-updater',
                            'defaults' => [
                                '__NAMESPACE__' => 'ValueSuggestUpdater\Controller\Admin',
                                'controller' => 'Index',
                                'action' => 'update',
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
    'valuesuggestupdater_updaters' => [
        'factories' => [
            'valuesuggest:idref:all' => Service\IdRefUpdaterFactory::class,
            'valuesuggest:idref:person' => Service\IdRefUpdaterFactory::class,
            'valuesuggest:idref:corporation' => Service\IdRefUpdaterFactory::class,
            'valuesuggest:idref:conference' => Service\IdRefUpdaterFactory::class,
            'valuesuggest:idref:subject' => Service\IdRefUpdaterFactory::class,
            'valuesuggest:idref:rameau' => Service\IdRefUpdaterFactory::class,
            'valuesuggest:idref:fmesh' => Service\IdRefUpdaterFactory::class,
            'valuesuggest:idref:geo' => Service\IdRefUpdaterFactory::class,
            'valuesuggest:idref:family' => Service\IdRefUpdaterFactory::class,
            'valuesuggest:idref:title' => Service\IdRefUpdaterFactory::class,
            'valuesuggest:idref:authorTitle' => Service\IdRefUpdaterFactory::class,
            'valuesuggest:idref:trademark' => Service\IdRefUpdaterFactory::class,
            'valuesuggest:idref:ppn' => Service\IdRefUpdaterFactory::class,
            'valuesuggest:idref:library' => Service\IdRefUpdaterFactory::class,
        ],
    ],
];
