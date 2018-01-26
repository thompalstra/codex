<?php
namespace backend\controllers;

use codex\security\User;

class ToolsController extends \codex\web\Controller{
    public function actionNotepad(){
        return $this->renderPartial('notepad');
    }
    public function actionBrowser(){
        
    }
}
