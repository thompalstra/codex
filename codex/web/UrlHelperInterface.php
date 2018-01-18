<?php
namespace codex\web;

interface UrlHelperInterface{
    public static function parse( $request, $parameters = [] );
    public static function to( $url );
}

?>
