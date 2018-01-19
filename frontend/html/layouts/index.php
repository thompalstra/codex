<?php
use \codex\web\View;
$this->registerAsset(\common\assets\CodexAsset::className())
?>
<html>
    <head>
        <title><?=\Codex::$app->controller->title?></title>
        <?=$this->head()?>
    </head>
    <body>
        <?=$this::renderFile( '/frontend/html/templates/nav-default' )?>
        <section>
            <?=$view?>
        </section>
        <footer><?=$this->footer()?></footer>
    </body>
</html>
