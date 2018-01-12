<?php include('/codex/codex.php') ?>
<?php
$app = Codex::start( [
    'urlClass' => 'codex\web\UrlHelper',
    'environments' => [
        'default' => 'frontend'
    ],
    'defaultController' => 'site',
    'defaultAction' => 'index',
    'db' => [
        'dsn' => 'mysql:dbname=sample_db;host=localhost',
        'username' => 'root',
        'passwd' => ''
    ]
] );
?>
<?=$app->handle( $_SERVER['REQUEST_URI'] );?>
