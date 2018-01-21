<?php
use \codex\web\View;
$this->registerAsset(\common\assets\CodexAsset::className());
?>
<html>
    <head>
        <title><?=\Codex::$app->controller->title?></title>
        <?php
            $this->registerJsFile( '/web/script/script.js' );
            $this->registerCssFile( '/web/style/style.css' );
        ?>
        <?=$this->head()?>
    </head>
    <body>
        <?=$this::renderFile( '/backend/html/templates/nav-default' )?>
        <section>
            <?=$view?>
        </section>
        <footer><?=$this->footer()?></footer>
    </body>
</html>
