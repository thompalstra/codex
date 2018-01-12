<?php
namespace codex\base;

class Widget{
    public static function widget($a = null, $b = null, $c = null ){
        $c = get_called_class();
        $w = new $c();

        call_user_func_array( [$w, 'in'], func_get_args() );
        return $w->out();
    }
}
?>
