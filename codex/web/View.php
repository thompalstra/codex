<?php
namespace codex\web;

// use codex\base\Renderer;
use codex\exceptions\HttpNotFoundException;

class View extends \codex\base\Model{
    public static function render( $view, $layout, $data ){

        $baseDir = \Codex::$app->baseDir . DIRECTORY_SEPARATOR . \Codex::$app->environment->name;

        $baseView = $baseDir . DIRECTORY_SEPARATOR . 'html' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . \Codex::$app->controller->viewPath . DIRECTORY_SEPARATOR;
        $baseLayout = $baseDir . DIRECTORY_SEPARATOR . 'html' . DIRECTORY_SEPARATOR . 'layouts' . DIRECTORY_SEPARATOR;

        $viewFile = $baseView . $view . '.php';
        $layoutFile = $baseLayout . $layout . '.php';

        return self::renderFile( $layoutFile, [
            'view' => self::renderFile( $viewFile, $data )
        ] );

        return $content;
    }

    public static function renderFile( $file, $data = []){

        if( !is_dir( dirname( $file ) ) || !file_exists( $file ) ){
            if( $file[0] == '/' ){
                $file = \Codex::$app->baseDir . DIRECTORY_SEPARATOR . "$file.php" ;
            } else {
                $file = \Codex::$app->baseDir . DIRECTORY_SEPARATOR . \Codex::$app->environment->name . DIRECTORY_SEPARATOR . 'html' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . \Codex::$app->controller->viewPath . $file . ".php";
            }
        }

        if( !is_dir( dirname($file) ) ){
            return \Codex::$app->controller->runError( "Page not found <small>(4000)</small>" );
        } else if( !file_exists( $file ) ){
            return \Codex::$app->controller->runError( "Page not found <small>(4010)</small>" );
        }

        extract($data, EXTR_PREFIX_SAME, 'data');
        ob_start();
        include( $file );
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }
}
?>
