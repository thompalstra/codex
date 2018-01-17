<?php
namespace codex\template;

class ModuleCollection extends \codex\base\Model{

    public $collection = [];

    public function output(){
        $out = [];
        foreach( $this->collection as $module ){
            $out[] = $module->output();
        }
        return implode($out);
    }

    public function addModule( $module ){
        $this->collection[] = $module;
    }
}
?>
