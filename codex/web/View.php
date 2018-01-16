<?php
namespace codex\web;

use codex\base\Renderer;

class View extends \codex\base\Model{
    public static function render( $view, $layout, $data ){

        $baseDir = \Codex::$app->baseDir . DIRECTORY_SEPARATOR . \Codex::$app->environment->name;

        $baseView = $baseDir . DIRECTORY_SEPARATOR . 'html' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . \Codex::$app->controller->viewPath;
        $baseLayout = $baseDir . DIRECTORY_SEPARATOR . 'html' . DIRECTORY_SEPARATOR . 'layouts' . DIRECTORY_SEPARATOR;

        var_dump($baseView); die;

        if(!is_dir($baseView)){
            return "$baseView does not exist";
        }
        if(!is_dir($baseLayout)){
            return "$baseLayout does not exist";
        }

        $viewFile = $baseView . $view . '.php';
        $layoutFile = $baseLayout . $layout . '.php';

        if( !file_exists( $viewFile )){
            return "$viewFile does not exist";
        }
        if( !file_exists( $layoutFile )){
            return "$layoutFile does not exist";
        }

        return self::renderFile( $layoutFile, [
            'view' => self::renderFile( $viewFile, $data )
        ] );

        return $content;
    }

    public static function renderFile( $file, $data = []){
        extract($data, EXTR_PREFIX_SAME, 'data');
        ob_start();
        include( $file );
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }
}
?>
