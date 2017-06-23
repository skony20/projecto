<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        'css/admin.css',
        'css/orders.css',
        'css/jquery.fancybox.css',
        'css/font-awesome.min.css',
    ];
    public $js = [
        'js/admin.js', 
        'js/modal.js',
        'js/fancybox/jquery.fancybox.js',
        'js/fancybox/jquery.fancybox.pack.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
