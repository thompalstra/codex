<?php
use \codex\web\View;
$this->registerAsset(\common\assets\CodexAsset::className())
?>
<html>
    <head>
        <title><?=\Codex::$app->controller->title?></title>
        <!-- <link rel="stylesheet" href="/web/style/style.css"></link> -->
        <?=$this->head()?>
    </head>
    <body>
        <section>
            <?=$view?>
            <?php
            $moduleCollection = new \codex\template\ModuleCollection();
            $items = new \codex\template\SubModule('items', [
                [
                    'label' => 'Item a',
                    'url' => '/my-url',
                ],
                [
                    'label' => 'Item b',
                    'url' => ['/my-other-url', 'id' => 1, 'item' => 5]
                ],
                [
                    'label' => 'Item C',
                    'items' => [
                        [
                            'label' => 'item d',
                            'url' => '/item-d'
                        ],
                        [
                            'label' => 'item f',
                            'url' => '/item-f'
                        ]
                    ]
                ]
            ]);
            $options = new \codex\template\SubModule('options', [
                'class' => 'nav nav-default',
            ]);
            $module = new \codex\template\Module( '\codex\widgets\Nav', 'widget' );
            $module->addSubModule( $items );
            $module->addSubModule( $options );
            $moduleCollection->addModule( $module );
            echo $moduleCollection->output();
            ?>

        </section>
        <footer><?=$this->footer()?></footer>
    </body>
</html>
