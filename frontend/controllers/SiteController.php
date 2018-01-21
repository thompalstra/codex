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

        $user1 = User::find()->where([
            'and',
            ['is_deleted' => 1],
            ['=', 'is_enabled', 1]
        ])->orWhere([
            'and',
            ['in', 'id', $q]
        ]);

        $user2 = User::find()->where([
                'or',
                [
                    'and',
                    ['is_deleted' => 1],
                    ['=', 'is_enabled', 1]
                ],
                [
                    'and',
                    ['in', 'id', $q]
                ]
        ]);

        print_r( $user1->createCommand() );
        echo '<br/>';
        print_r( $user2->createCommand() );

        // die;

        return $this->render('index');
    }

    public function actionError($exception){
        return $this->render('error', [
            'exception' => $exception
        ]);
    }
}
?>
