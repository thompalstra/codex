<?php
namespace common\assets;

use codex\web\View;

class FormAsset extends \codex\web\Asset{
    public $js = [
        ['/web/assets/form/script.js' => View::POS_FOOTER ]
    ];
    public $css = [
        ['/web/assets/form/style.css' => View::POS_HEAD ]
    ];
}
?>
