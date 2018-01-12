<?php
namespace common\models;

class User extends \codex\base\Model{
    public static $tableName = 'user';

    public function getUserAccount(){
        return UserAccount::find()->where([
            '=' => [
                'user_id' => $this->id
            ]
        ])->one();
    }

    public static function checkLogin(){
        
    }
}
?>
