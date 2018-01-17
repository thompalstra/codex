<?php
namespace common\widgets;

class NavMenu extends \Codex\base\Widget{

    public $options = [
        'inputOptions' => [],
        'itemOptions' => [],
        'options' => []
    ];
    public $items = [];

    public function prepare( $args ){
        foreach( $args as $k => $v ){
            $this->$k = $v;
        }
    }
    public function output(){
        return $this->begin() . $this->items() . $this->end();
    }
    public function begin(){

        $attributes = \codex\helpers\Html::createAttributes( $this->options['options'] );

        return "<div $attributes>";
    }
    public function items(){

    }
    public function item(){

    }
    public function end(){
        return "</div>";
    }

}

?>
