<?php
namespace codex\helpers;

use codex\web\Url;

class Html extends \codex\helpers\BaseHtml{

    public static function __callStatic( $name, $arguments ){
        if( method_exists( get_called_class(), $name ) ){
            return call_user_func_array( [ get_called_class(), $name ], $arguments );
        } else {
            if( !in_array( $name, self::$selfClosingTags ) ){
                return call_user_func_array( [ get_called_class(), 'element' ], [ $name, ( isset( $arguments[0] ) ? $arguments[0] : "" ), ( isset( $arguments[1] ) ? $arguments[1] : [] ) ] );
            } else {
                return call_user_func_array( [ get_called_class(), '_element' ], [ $name, ( isset( $arguments[0] ) ? $arguments[0] : "" ), ( isset( $arguments[1] ) ? $arguments[1] : [] ) ] );
            }
        }
    }

    public static $selfClosingTags = [
        "area", "base", "br", "col", "embed", "hr", "img", "input",
        "keygen", "meta", "link", "param", "source", "track", "wbr", "br"
    ];

    public static function element( $name, $content, $options = [] ){
        return self::open( $name, $options ) . $content . self::close( $name );
    }
    public static function _element( $name, $options = [] ){
        $attributes = self::htmlAttributes( $options );
        return "<$name $attributes/>";
    }

    public static function open( $name, $options ){
        $options = self::htmlAttributes( $options );
        return "<$name $options>";
    }
    public static function close( $name ){
        return "</$name>";
    }

    public static function a( $content, $url, $options = []){
        $options['href'] = Url::to( $url );
        $attributes = self::htmlAttributes( $options );
        return "<a $attributes>$content</a>";
    }
}
?>
