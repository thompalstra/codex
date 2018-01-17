<?php
namespace frontend\controllers\products;

class DigitalController extends \codex\web\Controller{
    public function actionCms(){
        $this->title = 'Cms';
        return $this->render('cms');
    }
}
