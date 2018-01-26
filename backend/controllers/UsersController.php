<?php
namespace backend\controllers;

use codex\security\User;

class UsersController extends \codex\web\Controller{
    public function actionView(){
        return $this->renderPartial('view');
    }
    public function actionBrowse(){
        return $this->renderPartial('browse');
    }
}
