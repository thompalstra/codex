<?php
namespace frontend\controllers;

use common\models\User;

class SiteController extends \codex\web\Controller{
    public function actionIndex(){

        // $query = new \codex\db\Query();
        // $query->select('user.*')
        // ->from('user')
        // ->fetchClass( User::className() )
        // ->where([
        //     '=' => [
        //         'id' => 1,
        //         'is_deleted' => 0
        //     ]
        // ])
        // ->orWhere([
        //     '=' => [
        //         'id' => 2,
        //         'is_deleted' => 1
        //     ]
        // ]);

        $query = User::find()
        ->where([
            '=' => [
                'id' => 1,
                'is_deleted' => 0
            ]
        ])
        ->orWhere([
            '=' => [
                'id' => 2,
                'is_deleted' => 1
            ]
        ]);
        $users = $query->all();

        $user = $users[0];
        return $this->render('index', [
            'user' => $user,
            'title' => 'test',
        ]);
    }
    public function actionTest( $derp ){
    }
    public function actionError($exception){
        return $this->render('error', [
            'exception' => $exception,
            'title' => 'error',
        ]);
    }
}
?>
