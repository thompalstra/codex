<?php
namespace codex\base;

class Model extends \codex\db\Record{

    public $_attributes = [];
    public $_oldAttributes = [];

    public function __get( $key ){
        if( property_exists( $this, $key ) ){
            return $this->$key;
        } else if( method_exists( $this, "get" . ucwords($key) ) ){
            $fn = "get" . ucwords($key);
            return $this->$fn();
        }
    }

    public function __construct( $params = [] ){

        foreach($params as $k => $v){
            $this->$k = $v;
        }

        $arr = (array)$this;

        if( $this->isNewRecord == false ){
            $this->_attributes = $this->_oldAttributes = $arr;
        }

        foreach( $this->_attributes as $k => $v ){
            $this->_attributes[$k] = &$this->$k;
        }
    }


    public static function className(){
        return get_called_class();
    }
    public static function subClassName(){
        $className = get_called_class();
        $parts = explode('\\', $className);
        return $parts[ count( $parts ) - 1 ];
    }

    public function load( $params ){
        $out = false;

        $subClassName = self::subClassName();

        if( isset( $params[ $subClassName ] ) ){
            foreach( $params[ $subClassName ] as $k => $v ){
                $this->$k = $v;
            }
            $out = true;
        }

        return $out;
    }

    public function changedAttributes(){
        $changes = [];
        if( property_exists($this, '_attributes') && property_exists($this, '_oldAttributes') ){
            foreach( $this->_attributes as $k => $v ){
                if( isset( $this->_oldAttributes[$k] ) ){
                    if( $this->_attributes[$k] !== $this->_oldAttributes[$k] ){
                        $changes[$k] = [
                            'type' => 'updated',
                            'old' => $this->_oldAttributes[$k],
                            'new' => $this->_attributes[$k],
                        ];
                    }
                } else {
                    $changes[$k] = [
                        'type' => 'deleted'
                    ];
                }
            }
        }
        return $changes;
    }
}
?>
