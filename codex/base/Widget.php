<?php
namespace codex\base;

class Widget{

    public function __construct( $args = [] ){
        foreach( $args as $k => $v ){
            $this->$k = $v;
        }
    }

    public static function widget($a = null, $b = null, $c = null ){
        $c = get_called_class();
        $w = new $c();

        call_user_func_array( [$w, 'prepare'], func_get_args() );
        return call_user_func_array( [$w, 'output'], func_get_args() );
    }
}
?>
