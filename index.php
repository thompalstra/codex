<?php include('/codex/codex.php') ?>
<?php
$app = Codex::start( [
    'urlClass' => 'codex\web\UrlHelper',
    'environments' => [
        'default' => 'frontend'
    ],
    'defaultController' => 'site',
    'defaultAction' => 'index',
] );
?>
<?=$app->handle( $_SERVER['REQUEST_URI'] );?>
