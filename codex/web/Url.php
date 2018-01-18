<?php
namespace codex\web;

class Url extends \codex\base\Model{
    public static function to( $url ){
        $c = \Codex::$app->web->urlClass;
        return $c::to( $url );
    }
}
?>
