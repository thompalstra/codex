<head>
    <title><?=\Codex::$app->controller->title?></title>
</head>
<section>
    <?=$view?>

    <?php
    $moduleCollection = new \codex\template\ModuleCollection();



    $items = new \codex\template\SubModule('items', [
        [
            'label' => 'Item a',
            'url' => '/my-url'
        ],
        [
            'label' => 'Item b',
            'url' => '/my-other-url'
        ]
    ]);
    $options = new \codex\template\SubModule('options', [
        'options' => [
            'class' => 'nav-menu default',
            'style' => [
                'font-size' => '30px',
                'color' => 'red',
                'background-color' => 'blue',
                'height' => '20px',
                'width' => '20px',
                'display' => 'inline-block'
            ]
        ]
    ]);
    $module = new \codex\template\Module( '\common\widgets\NavMenu', 'widget' );
    $module->addSubModule( $items );
    $module->addSubModule( $options );
    $moduleCollection->addModule( $module );

    echo $moduleCollection->output();

    ?>

</section>
