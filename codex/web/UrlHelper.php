<?php
namespace codex\web;

class UrlHelper extends \codex\base\Model implements UrlHelperInterface{
    public static function parse( $request, $parameters = [] ){
        $request = trim($request, '/');
        $parts = explode('/', $request);

        if( count($parts) == 1 ) {
            if( $parts[0] == ''){
                $parts[0] = \Codex::$app->web->defaultAction;
            }

            $parts = [
                \Codex::$app->web->defaultController, $parts[0],
            ];
        }

        $route = implode("/", $parts);

        return [ "$route", $parameters ];
    }

    public static function to( $args ){

        if( is_array( $args ) && count( $args ) > 0 ){
            $path = $args[0];
        } else {
            $path = $args;
        }

        if( is_array( $args ) && count( $args ) > 1 ){
            $params = array_splice($args, 1, count($args) -1 );
        } else {
            $params = [];
        }

        if( strlen($path) > 0 && $path[0] !== '/' ){
            $path = "/$path";
        }

        if( !empty($params) ){
            return $path . "?" . http_build_query( $params );
        } else {
            return $path;
        }
    }
}
?>
