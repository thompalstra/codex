<?php
namespace common\assets;

class CodexAsset extends \codex\web\Asset{
    public $js = [
        '/web/script/codex.js'
    ];
    public $css = [
        '/web/style/style.css'
    ];

    public function assets(){
        return [
            \common\assets\NavAsset::className()
        ];
    }
}
?>
