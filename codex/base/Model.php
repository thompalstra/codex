<?php
namespace codex\base;

class Model{
    public static function className(){
        return get_called_class();
    }
}
?>
