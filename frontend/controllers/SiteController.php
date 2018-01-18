<?php
namespace frontend\controllers;

use codex\security\User;

class SiteController extends \codex\web\Controller{
    public function actionIndex(){

        $q = new \codex\db\Query();
        $q->select('user.id')->from('user');
        $q->where([
            'and',
            ['user.id' => 1]
        ]);

        $user = User::find()->where([
            'and',
            ['is_deleted' => 1],
            ['=', 'is_enabled', 1]
        ])->orWhere([
            'and',
            ['in', 'id', $q]
        ])->one();

        return $this->render('index', [
            'user' => $user,
            'title' => 'test',
        ]);
    }

    public function actionError($exception){
        return $this->render('error', [
            'exception' => $exception
        ]);
    }
}
?>
