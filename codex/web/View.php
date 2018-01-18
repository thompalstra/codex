<?php
namespace codex\web;

use codex\helpers\Html;
use codex\exceptions\HttpNotFoundException;

class View extends \codex\base\Model{

    public $head = [];
    public $footer = [];

    const POS_HEAD = 'head';
    const POS_FOOTER = 'footer';


    public function render( $view, $layout, $data ){

        $baseDir = \Codex::$app->baseDir . DIRECTORY_SEPARATOR . \Codex::$app->environment->name;

        $baseView = $baseDir . DIRECTORY_SEPARATOR . 'html' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . \Codex::$app->controller->viewPath . DIRECTORY_SEPARATOR;
        $baseLayout = $baseDir . DIRECTORY_SEPARATOR . 'html' . DIRECTORY_SEPARATOR . 'layouts' . DIRECTORY_SEPARATOR;

        $viewFile = $baseView . $view . '.php';
        $layoutFile = $baseLayout . $layout . '.php';

        return $this->renderFile( $layoutFile, [
            'view' => $this->renderFile( $viewFile, $data )
        ] );

        return $content;
    }

    public function registerAsset( $className ){
        $c = new $className();
        foreach( $c->js as $js ){
            if( is_array( $js ) ){
                $this->registerJsFile( array_keys($js)[0], $js[array_keys($js)[0]] );
            } else {
                $this->registerJsFile( $js, self::POS_HEAD );
            }
        }
        foreach( $c->css as $css ){
            if( is_array( $css ) ){
                $this->registerCssFile( array_keys($css)[0], $css[array_keys($css)[0]] );
            } else {
                $this->registerCssFile( $css, self::POS_HEAD );
            }
        }

        foreach( $c->assets() as $asset ){
            $this->registerAsset( $asset );
        }
    }

    public function registerJsFile( $file, $position ){
        $this->appendToPosition(Html::script("", [
            'type' => 'text/javascript',
            'src' => $file
        ]), $position );
    }
    public function registerCssFile( $file, $position ){
        $this->appendToPosition( Html::link([
            'type' => 'text/css',
            'rel' => 'stylesheet',
            'href' => $file
        ]), $position );
    }

    public function registerJs( $content, $position ){
        $this->appendToPosition( Html::script($content, [
            'type' => 'text/javascript'
        ]), $position );
    }

    public function registerCss( $content, $position ){
        $this->appendToPosition( Html::style($content, [
            'type' => 'text/css'
        ]), $position );
    }

    public function appendToPosition( $content, $position ){
        switch( $position ){
            case self::POS_HEAD:
                $this->head[] = $content;
            break;
            case self::POS_FOOTER:
                $this->footer[] = $content;
            break;
        }
    }



    public function head(){
        return implode($this->head);
    }
    public function footer(){
        return implode($this->footer);
    }

    public function renderFile( $file, $data = []){

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
        require($file);
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }
}
?>
