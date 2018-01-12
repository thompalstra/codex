<?php
namespace codex\base;

class Renderer extends \codex\base\Model{
    public static function fromTemplate( $filePath, $data ){
        // $pattern = "{{.(.*).}}";
        $pattern = "({{(.[a-zA-Z0-9.]*)}})";

        ob_start();
        include($filePath);
        $fileContent = ob_get_contents();
        ob_end_clean();

        preg_match_all( $pattern, $fileContent, $matches );

        $replaceNames = [];
        $replaceInstances = [];

        foreach( $matches[0] as $index => $name ){

            $instance = null;

            $string = $matches[1][$index];

            $instance = self::getInstanceFromString( $string, $data );

            if( !empty( $instance ) ){
                $replaceNames[] = $name;
                $replaceInstances[] = $instance;
            }
        }

        $functionPattern = "({{(.*)[:]\[(.*)\]}})";
        preg_match_all( $functionPattern, $fileContent, $matches );

        foreach( $matches[0] as $index => $name ){
            $match = $matches[0][$index];
            $params = explode(',', $matches[2][$index]);
            $instance = self::getInstanceFromString( $matches[1][$index], $data, $params );

            if( !empty( $instance ) ){
                $replaceNames[] = $name;
                $replaceInstances[] = $instance;
            }
        }

        $fileContent = str_replace( $replaceNames, $replaceInstances, $fileContent );

        return $fileContent;
    }

    public static function getInstanceFromString( $string, $data, $params = [] ){
        $instance = null;
        foreach( explode( '.', $string ) as $partIndex => $part ){
            if( $instance == null ){
                if( isset($data[$part]) ){ // from data
                    $instance = $data[$part];
                } else if( class_exists( $part ) ){ // from class
                    $instance = $part;
                }
            } else {
                if( property_exists( $instance, $part )){ // from instance as property
                    if( is_object($instance) ){
                        $instance = $instance->$part;
                    } else { // from instance as static property
                        $instance = $instance::$$part;
                    }
                } else if( method_exists( $instance, $part ) ){ // from instance as function
                    return call_user_func_array([$instance, $part], $params);
                }
            }
        }
        return $instance;
    }
}

?>
