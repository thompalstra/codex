<?php
$moduleCollection = new \codex\template\ModuleCollection();
$items = new \codex\template\SubModule('items', [
    [
        'label' => 'Home',
        'url' => '/'
    ],
    [
        'label' => 'Products',
        'items' => [
            [
                'label' => 'Digital',
                'items' => [
                    [
                        'label' => 'CMS',
                        'url' => '/products/digital/cms'
                    ]
                ]
            ],
        ],
        'options' => [
            'co-dropdown-bottom' => '',
            'co-dropdown-left' => '',
        ]
    ]
]);
$options = new \codex\template\SubModule('options', []);
$module = new \codex\template\Module( '\codex\widgets\Nav', 'widget' );
$module->addSubModule( $items );
$module->addSubModule( $options );
$moduleCollection->addModule( $module );
echo $moduleCollection->output();
?>
