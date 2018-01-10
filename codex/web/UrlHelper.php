<?php
namespace codex\web;

class UrlHelper extends \codex\base\Model{
    public static function parse( $request, $parameters = [] ){
        $request = trim($request, '/');
        $parts = explode('/', $request);

        if( count($parts) == 1 ) {
            if( $parts[0] == ''){
                $parts[0] = \Codex::$app->defaultAction;
            }

            $parts = [
                \Codex::$app->defaultController, $parts[0],
            ];
        }

        $actionId = $parts[ count($parts) - 1 ];
        array_pop($parts);
        $controllerId = $parts[ count($parts) - 1 ];

        return [ "$controllerId/$actionId", $parameters ];
    }
}
?>
