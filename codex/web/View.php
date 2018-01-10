<?php
namespace codex\web;

class View extends \codex\base\Model{
    public static function render( $view, $layout, $data ){


        $baseDir = \Codex::$app->baseDir . DIRECTORY_SEPARATOR . \Codex::$app->environment->name;
        $baseView = $baseDir . DIRECTORY_SEPARATOR . 'html' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR;
        $baseLayout = $baseDir . DIRECTORY_SEPARATOR . 'html' . DIRECTORY_SEPARATOR . 'layouts' . DIRECTORY_SEPARATOR;

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

        if (is_array($data)) {
            extract($data, EXTR_PREFIX_SAME, 'data');
        } else {
            $data = $this->data;
        }

        ob_start();
        include($viewFile);
        $view = ob_get_contents();
        ob_end_clean();
        ob_start();
        include ($layoutFile);
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }
}
?>
