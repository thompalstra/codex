<?php
namespace common\assets;

use codex\web\View;

class NavAsset extends \codex\web\Asset{
    public $js = [
        ['/web/assets/nav/script.js' => View::POS_FOOTER ]
    ];
    public $css = [
        ['/web/assets/nav/style.css' => View::POS_HEAD ]
    ];
}
?>
