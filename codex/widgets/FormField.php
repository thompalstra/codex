<?php
namespace codex\widgets;
use codex\helpers\Html;
use codex\widgets\FormField;

class FormField extends \codex\base\Widget{
    public $form;

    public $instance;
    public $attribute;

    public $name;
    public $value;

    public $inputOptions = [];

    public function __construct( $args ){
        foreach( $args as $k => $v ){
            $this->$k = $v;
        }

        $i = $this->instance;
        $c = $i::getClassName();
        $s = $i::subClassName();
        $a = $this->attribute;

        $this->value = $i->$a;

        if( strpos( $this->attribute, '[]' ) ) {
            $name = str_replace( '[]', '', $this->attribute );
            $this->name = $s . '[' . $name . '][]';
        } else {
            $this->name = $this->attribute;
        }

        $this->inputOptions = [
            'name' => $this->name,
            'value' => $this->value
        ];
    }

    public function input( $options = [] ){
        $inputOptions = $options + $this->inputOptions + $this->form->inputOptions + ( isset( $options['type'] ) ? [] : ['type'=>'text'] );
        $itemOptions = $this->form->itemOptions;
        return Html::open( 'div', $itemOptions ) . Html::input( $inputOptions ) . Html::close( 'div' );
    }
}
