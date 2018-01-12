<?php

use codex\web\Environment;

class Codex{

    public $baseDir;
    public static $app;

    static function start( $config ){
        include(__DIR__ . DIRECTORY_SEPARATOR . 'application.php');
        include(__DIR__ . DIRECTORY_SEPARATOR . 'autoload.php');
        Codex::$app = $app = new Application( $config );
        $app->baseDir = dirname( __DIR__ );

        $app->pdo = new PDO(
            $config['db']['dsn'],
            $config['db']['username'],
            $config['db']['passwd']
        );


        $ex = explode('.', $_SERVER['SERVER_NAME']);

        if( count($ex) >= 3 ){
            $app->environment = new Environment( $ex[0] );
        } else {
            $app->environment = new Environment( $app->environments['default'] );
        }
        return Codex::$app;
    }
}
