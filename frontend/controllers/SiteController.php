<?php
namespace frontend\controllers;

class SiteController extends \codex\web\Controller{
    public function actionTest( $derp ){
    }
    public function actionError($exception){
        return $this->render('error', [
            'exception' => $exception
        ]);
    }
}
?>
