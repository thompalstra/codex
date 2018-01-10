<?php
function __autoload( $className ){
    $dir = dirname( __DIR__ );
    $classDir = $dir . DIRECTORY_SEPARATOR . $className . '.php';

    if( is_dir( dirname($classDir) ) && file_exists( $classDir ) ){
        include( $classDir );
    }
}
?>
