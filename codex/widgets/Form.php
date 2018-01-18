<?php
namespace codex\widgets;
use codex\helpers\Html;
use codex\widgets\FormField;

class Form extends \codex\base\Widget{

    public $options = [
        'class' => 'form form-default'
    ];
    public $inputOptions = [];
    public $itemOptions = [
        'class' => 'form field-default',
    ];

    public function open(){
        return Html::open('form', $this->options);
    }
    public function close(){
        return Html::close('form');
    }
    public function field( $instance, $attribute ){
        return new FormField( [
            'form' => $this,
            'instance' => $instance,
            'attribute' => $attribute
        ] );
    }
}
?>
