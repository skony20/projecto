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
        'css/site.css',
        'css/css.css',
        'css/prj-list.css',
        'css/prj.css',
        'css/cart-list.css',
        'css/account.css',
        'css/_navbar.css',
        'css/_iconboxes.css',
        'css/latest-products.css',
        'css/_footer.css',
        'css/_breadcrumbs.css',
        'css/accordion.css',
        'css/font-awesome.min.css',
        'css/static-page.css',
        'css/login.css',
        'css/order.css',
        'css/faq.css',
        'css/blog.css'
        
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
    public $js = [
        'frontend/web/js/front.js',
        'frontend/web/js/zoom-gallery.js',
        'frontend/web/js/jquery.cookie.js',
        'frontend/web/js/modal.js',
        
    ];
    
}
