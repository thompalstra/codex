<?php
namespace backend\controllers;

use codex\security\User;

class SiteController extends \codex\web\Controller{
    public function actionIndex(){
        return $this->render('index');
    }

    public function actionError($exception){
        return $this->render('error', [
            'exception' => $exception
        ]);
    }
}
?>
