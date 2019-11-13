<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class BootstrapAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/modal.css',
        'css/libs.min.css',
        'css/app.css?ver1.7',
        'css/jquery.slotmachine.min.css'
    ];
    public $js = [
        'js/slotmachine.min.js',
        'js/jquery.slotmachine.min.js',
        'js/libs.min.js',
        'js/app.js?ver2.0'
    ];
}