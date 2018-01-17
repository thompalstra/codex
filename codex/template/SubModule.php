<?php
namespace codex\template;

class SubModule extends \codex\base\Model{

    public $key;
    public $value;

    public function __construct( $key, $value ){
        $this->key = $key;
        $this->value = $value;
    }

    public function output(){
        return [
            $this->key => $this->value
        ];
    }
}
?>
