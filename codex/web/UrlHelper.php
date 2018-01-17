<?php
namespace codex\web;

class UrlHelper extends \codex\base\Model{
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
}
?>
