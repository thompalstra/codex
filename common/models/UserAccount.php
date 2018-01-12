<?php
namespace common\models;

class UserAccount extends \codex\base\Model{
    public static $tableName = 'user_account';

    public function getPrettyName(){
        $names = [];

        if( !empty( $this->name_title ) )   {   $names[] = $this->name_title;       }
        if( !empty( $this->first_name ) )   {   $names[] = $this->first_name;       }
        if( !empty( $this->name_addition ) ){   $names[] = $this->name_addition;    }
        if( !empty( $this->last_name ) )    {   $names[] = $this->last_name;        }

        return implode( ' ', $names );
    }

    public static function derp(){
        return "returned derp";
    }
}
?>
