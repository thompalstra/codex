<?php
namespace codex\helpers;

class Html extends \codex\base\Model{
    public static function createAttributes( $options){

        $out = [];
        foreach( $options as $k => $v ){
            if(is_array($v)){
                $out[] =  "$k='" . self::createArrayAttributes($v) . "'";
            } else {
                $out[] = "$k=$v";
            }
        }
        return implode(" ", $out);
    }
    public static function createArrayAttributes( $options ){
        $out = [];
        foreach($options as $k => $v){
            if(is_array($v)){
                self::createArrayAttributes($v);
            } else {
                $out[] = "$k:$v";
            }
        }
        return implode("; ", $out);
    }
}
?>
