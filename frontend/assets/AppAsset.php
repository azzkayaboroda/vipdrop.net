<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/libs.min.css',
        'css/app.css'
    ];
    public $js = [
       // 'js/libs.min.js',
      //  'js/app.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
       // 'yii\bootstrap\BootstrapAsset',
        'frontend\assets\BootstrapAsset',
    ];
}