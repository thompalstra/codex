<?php
namespace common\assets;

class CodexAsset extends \codex\web\Asset{
    public $js = [
        '/web/script/codex.js',
        '/web/script/common-script.js',
    ];
    public $css = [
        '/web/style/codex.css',
        '/web/style/common-style.css'
    ];

    public function assets(){
        return [
            \common\assets\NavAsset::className(),
            \common\assets\FormAsset::className()
        ];
    }
}
?>
