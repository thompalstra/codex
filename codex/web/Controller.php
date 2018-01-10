<?php
namespace codex\web;

class Controller extends \codex\base\Model{

    public $layout = 'index';

    public function __construct( $args ){
        foreach($args as $k => $v){
            $this->$k = $v;
        }
    }

    public static function getDefaultController(){
        $controllerClassName = \Codex::$app->environment->name . DIRECTORY_SEPARATOR . 'controllers' . DIRECTORY_SEPARATOR . ucwords( \Codex::$app->defaultController ) . 'Controller';
        return new $controllerClassName([
            'id' => \Codex::$app->defaultController,
            'name' => ucwords( \Codex::$app->defaultController ) . 'Controller',
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
        $controllerName = ucwords( $controllerId ) . 'Controller';
        $controllerNamespace = \Codex::$app->environment->name . DIRECTORY_SEPARATOR . 'controllers' . DIRECTORY_SEPARATOR;
        $controllerClassName = $controllerNamespace . $controllerName;

        if( !class_exists( $controllerClassName ) ){
            $controllerClassName = $controllerNamespace . ucwords( \Codex::$app->defaultController ) . 'Controller';
        }

        return new $controllerClassName([
            'id' => $controllerId,
            'name' => $controllerName,
            'namespace' => $controllerNamespace,
            'className' => $controllerClassName,
            'actionId' => $actionId
        ]);
    }

    public function runAction( $actionId, $parameters ){
        $action = 'action' . ucwords( $actionId );

        $actionParams = [];

        if( method_exists( $this, $action ) ){
            $reflectionMethod = new \ReflectionMethod($this, $action);
            foreach( $reflectionMethod->getParameters() as $param ){
                if( isset($parameters[ $param->name ]) ){
                    $actionParams[ $param->name ] = $parameters[ $param->name ] ;
                }
            }
            if( count($actionParams) == $reflectionMethod->getNumberOfParameters() ){
                return call_user_func_array( array($this, $action), $actionParams);
            } else if( method_exists( $this, 'actionError' ) ) {
                return call_user_func_array( array($this, 'actionError' ), ['exception' => new \Exception('Params do not match', 500) ] );
            } else {
                $defaultController = self::getDefaultController();
                if( method_exists( $defaultController, 'actionError' ) ){
                    return call_user_func_array( array($defaultController, 'actionError'), ['exception' => new \Exception('Error executing error', 500)]);
                } else {
                    return 'error executing error';
                }
            }
        } else {
            $defaultController = self::getDefaultController();
            if( method_exists( $defaultController, 'actionError' ) ){
                return call_user_func_array( array($defaultController, 'actionError'), ['exception' => new \Exception('no such action', 404)]);
            } else {
                return 'no such action';
            }
        }
    }

    public function render( $viewId, $data ){
        $view = $this->id . DIRECTORY_SEPARATOR . $viewId;
        return View::render( $view, $this->layout, $data );
    }
}

?>
