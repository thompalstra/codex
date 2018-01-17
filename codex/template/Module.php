<?php
namespace codex\template;

class Module extends \codex\base\Model{

    public $collection = [];
    public $className;
    public $function;

    public function __construct( $className, $function ){
        $this->className = $className;
        $this->function = $function;
    }

    public function output(){
        $className = $this->className;
        $function = $this->function;
        // $options = $this->createOptions( $this->collection );

        $options = [];

        foreach( $this->collection as $subModule ){
            $options += $subModule->output();
        }
        
        return $className::$function($options);
    }
    public function createOptions( $collection ){

        $out = [];

        foreach($collection as $k => $v){
            $out[$v->key] = $v->value;
        }

        return $out;
    }

    public function addSubModule( $subModule ){
        $this->collection[] = $subModule;
    }

}
?>
