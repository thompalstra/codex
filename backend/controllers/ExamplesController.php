<?php
namespace backend\controllers;

class ExamplesController extends \codex\web\Controller{
    public function actionQueries(){
        return $this->render('queries');
    }
}

?>
