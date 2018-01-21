<?php
namespace codex\web;

use codex\exceptions\HttpNotFoundException;

class Controller extends \codex\base\Model{

    public $layout = 'index';
    public $title = '';

    public function __construct( $args ){
        foreach($args as $k => $v){
            $this->$k = $v;
        }
    }

    public function runError( $message, $statusCode = 404 ){

        $exception = new HttpNotFoundException( $message, $statusCode );

        if( !method_exists($this, 'actionError') ){
            $defaultController = self::getDefaultController();
            if( method_exists($defaultController, 'actionError') ){
                return $defaultController->runAction('error', ['exception' => $exception]);
            }
        } else {
            return $this->runAction('error', ['exception' => $exception]);
        }
    }

    public static function getDefaultController(){
        $controllerClassName = \Codex::$app->environment->name . DIRECTORY_SEPARATOR . 'controllers' . DIRECTORY_SEPARATOR . ucwords( \Codex::$app->web->defaultController ) . 'Controller';
        return new $controllerClassName([
            'id' => \Codex::$app->web->defaultController,
            'path' => \Codex::$app->web->defaultAction,
            'viewPath' => \Codex::$app->web->defaultController,
            'name' => ucwords( \Codex::$app->web->defaultController ) . 'Controller',
            'namespace' => \Codex::$app->environment->name . DIRECTORY_SEPARATOR . 'controllers' . DIRECTORY_SEPARATOR,
            'className' => $controllerClassName,
            'actionId' => null
        ]);
    }

    public static function fromRoute( $route ){

        $url = $route[0];
        $params = $route[1];

        $parts = explode('/', $url);

        $actionId = $parts[count($parts)-1];
        array_pop($parts);
        $controllerId = $parts[count($parts)-1];

        $viewPath = ( count($parts) > 0 ) ? implode("\\", $parts) . DIRECTORY_SEPARATOR : "";
        array_pop($parts);
        $path = ( count($parts) > 0 ) ? implode("\\", $parts) . DIRECTORY_SEPARATOR : "";

        $controllerName = ucwords( $controllerId ) . 'Controller';
        $controllerNamespace = \Codex::$app->environment->name . DIRECTORY_SEPARATOR . 'controllers' . DIRECTORY_SEPARATOR;
        $controllerClassName = $controllerNamespace . $path . $controllerName;

        if( !class_exists( $controllerClassName ) ){
            return self::getDefaultController();
            // $controllerClassName = $controllerNamespace . ucwords( \Codex::$app->web->defaultController ) . 'Controller';
        }

        return new $controllerClassName([
            'id' => $controllerId,
            'viewPath' => $viewPath,
            'path' => $path,
            'name' => $controllerName,
            'namespace' => $controllerNamespace,
            'className' => $controllerClassName,
            'actionId' => $actionId
        ]);
    }

    public function runAction( $actionId, $parameters ){
        \Codex::$app->controller = $this;
        $action = 'action' . ucwords( $actionId );

        $actionParams = [];

        if( method_exists( $this, $action ) ){
            $reflectionMethod = new \ReflectionMethod($this, $action);
            foreach( $reflectionMethod->getParameters() as $param ){
                if( isset($parameters[ $param->name ]) ){
                    $actionParams[ $param->name ] = $parameters[ $param->name ] ;
                }
            }
            if( count($actionParams) == $reflectionMethod->getNumberOfRequiredParameters() ){
                return call_user_func_array( array($this, $action), $actionParams);
            } else {
                if( method_exists( $this, 'actionError' ) ) {
                    return $this->runError("Missing arguments");
                }
            }
        }
        return self::getDefaultController()->runError("Page not found <small>(4020)</small>");
    }

    public function render( $viewId, $data = [] ){
        $view = new View();
        return $view->render( $viewId, $this->layout, $data );
    }
}

?>
