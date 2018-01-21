<?php
class Application{

    public $basePath;

    public function __construct( $params ){
        foreach($params as $k => $v){
            $this->$k = $v;
        }
    }

    function handle( $request ){
        $route = $this->parse( $request );

        $controller = $this->controller = \codex\web\Controller::fromRoute( $route );
        $this->controller->title = ucwords( $this->controller->actionId );
        return $controller->runAction( $controller->actionId, $route[1] );
    }
    function parse( $request ){
        $url = $this->environment->config->web['url'];

        if( strpos($request, '?') ){
            $request = substr($request, 0, strpos($request, '?') );
        }

        $route = [
            'site/index', $_GET
        ];

        foreach($url as $k => $line){
            if( is_array( $line ) && isset( $line['class'] ) ){
                $urlClass = $line['class'];
                if( $parsedRoute = $urlClass::parse( $request, $_GET ) ){
                    $route = $parsedRoute;
                }
            } else {
                $urlClass = $this->web->urlClass;
                if( $parsedRoute = $urlClass::parse( $request, $_GET ) ){
                    $route = $parsedRoute;
                }
            }
        }
        return $route;
    }
}

?>
