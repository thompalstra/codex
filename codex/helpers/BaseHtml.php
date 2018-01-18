<?php
namespace codex\helpers;

class BaseHtml extends \codex\base\Model{
    public static function htmlAttributes( $options = [] ){
        $out = [];

        foreach( $options as $k => $v ){
            $out[] = self::htmlAttribute($k, $v);
        }
        return implode(" ", $out);
    }

    public static function htmlAttribute( $key, $value ){
        if( is_array( $value )){
            return "$key='" . self::nestedAttributes( $key, $value ) . "'";
        } else {
            return "$key='$value'";
        }
    }

    public static function nestedAttributes( $key, $options ){
        $out = [];
        foreach( $options as $k => $v ){
            if( is_array($k) ){
                $out[] = self::nestedAttributes($k, $v);
            } else {
                $out[] = "$k:$v";
            }
        }
        return implode("; ", $out);
    }

    public static function mergeHtmlAttributes( $arr1, $arr2, $output = [] ){
        return array_merge($arr1, $arr2);
    }
}
?>
