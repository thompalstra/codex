<?php
namespace codex\widgets;

use codex\helpers\Html;

class Nav extends \Codex\base\Widget{
    public $options = [
        'class' => 'nav nav-default'
    ];
    public $inputOptions = [];
    public $itemOptions = [
        'class' => 'nav item-default',
        'nav' => '1',
    ];
    public $items = [];

    public function prepare( $args ){

        if( isset($args['options']) ){
            $this->options = Html::mergeHtmlAttributes( $this->options, $args['options'] );
        }
        if( isset($args['itemOptions']) ){
            $this->itemOptions = Html::mergeHtmlAttributes( $this->itemOptions, $args['itemOptions'] );
        }
        if( isset($args['inputOptions']) ){
            $this->inputOptions = Html::mergeHtmlAttributes( $this->inputOptions, $args['inputOptions'] );
        }
        if( isset($args['items']) ){
            $this->items = $args['items'];
        }
    }
    public function output(){
        return Html::nav( $this->items( $this->items ), $this->options );
    }

    public function items( $items ){
        $output = [];
        foreach( $items as $item ){
            $output[] = $this->item( $item );
        }
        return Html::ul( implode($output) );
    }
    public function item( $item ){

        if( isset( $item['options']) ){
            $itemOptions = Html::mergeHtmlAttributes( $itemOptions, $item['options'] );
        } else {
            $itemOptions = $this->itemOptions;
        }

        $output = "";

        if( isset($item['items']) ){
            $itemOptions['dropdown'] = "";
            $output = Html::li( Html::label( $item['label'] . $this->items( $item['items']), $itemOptions ) );
        } else if ( isset($item['label']) ) {
            $output = Html::li( Html::label( $item['label'] ), $itemOptions );
        }

        if( isset($item['url'])){
            $output = Html::a( $output, $item['url'] );
        }

        return $output;
    }

}

?>
