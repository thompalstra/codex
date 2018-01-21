<?php
$moduleCollection = new \codex\template\ModuleCollection();
$items = new \codex\template\SubModule('items', [
    [
        'label' => 'Home',
        'url' => '/'
    ],
    [
        'label' => 'Users',
        'url' => '/users/index'
    ],
    [
        'label' => 'Products',
        'url' => '/products/index'
    ],
]);
$options = new \codex\template\SubModule('options', []);
$module = new \codex\template\Module( '\codex\widgets\Nav', 'widget' );
$module->addSubModule( $items );
$module->addSubModule( $options );
$moduleCollection->addModule( $module );
echo $moduleCollection->output();
?>
