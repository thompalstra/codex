<?php
namespace codex\web;

class Environment extends \codex\base\Model{

    public $path = null;

    public function __construct( $environment ){
        $this->name = $environment;
        $this->path = \Codex::$app->baseDir . DIRECTORY_SEPARATOR . $environment . DIRECTORY_SEPARATOR;

        if( is_dir( $this->path ) ){

            if( file_exists( $this->path . 'config' . DIRECTORY_SEPARATOR . 'config.php' ) ){
                $this->config = (object) include( $this->path . 'config' . DIRECTORY_SEPARATOR . 'config.php' );
            }

            if( file_exists( $this->path . 'config' . DIRECTORY_SEPARATOR . 'params.php' ) ){
                $this->params = (object) include( $this->path . 'config' . DIRECTORY_SEPARATOR . 'params.php' );
            }
        }
    }
}
?>
