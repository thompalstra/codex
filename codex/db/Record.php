<?php
namespace codex\db;

class Record{

    public $isNewRecord = true;

    public static function find(){
        $query = new \codex\db\Query();
        $c = self::getClassName();
        return $query->fetchClass( $c )
        ->select( $c::$tableName . '.*' )
        ->from( $c::$tableName );
    }

    public static function getClassName(){
        return get_called_class();
    }
}
?>
