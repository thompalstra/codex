<?php

use codex\web\Environment;

class Codex{

    public $baseDir;
    public static $app;

    static function start( $config ){
        include(__DIR__ . DIRECTORY_SEPARATOR . 'application.php');
        include(__DIR__ . DIRECTORY_SEPARATOR . 'autoload.php');
        Codex::$app = new Application( $config );
        Codex::$app->baseDir = dirname( __DIR__ );

        $ex = explode('.', $_SERVER['SERVER_NAME']);

        if( count($ex) >= 3 ){
            Codex::$app->environment = new Environment( $ex[0] );
        } else {
            Codex::$app->environment = new Environment( Codex::$app->environments['default'] );
        }
        return Codex::$app;
    }
}
