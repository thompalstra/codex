<?php include('/codex/codex.php') ?>
<?php
$app = Codex::start( [
    'web' => [
        'urlClass' => 'codex\web\UrlHelper',
        'defaultController' => 'site',
        'defaultAction' => 'index',
    ],
    'environments' => [
        'default' => 'frontend'
    ],
    'db' => [
        'dsn' => 'mysql:dbname=sample_db;host=localhost',
        'username' => 'root',
        'passwd' => ''
    ]
] );
?>
<?=$app->handle( $_SERVER['REQUEST_URI'] );?>
