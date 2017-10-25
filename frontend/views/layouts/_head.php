<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use frontend\assets\AppAsset;


AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <META http-equiv="Content-Language" content="pl">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Raleway&amp;subset=latin-ext" rel="stylesheet">

    <?= Html::csrfMetaTags() ?>

    <title><?= Html::encode($this->title) ?></title>
    <META name="title" content="<?= Html::encode($this->title) ?>">
    <META name="author" content="Mariusz Skonieczny">
    <META name="reply-to" content="mariusz@projekttop.pl">
    <META name="company" content="ProjektTop.pl">
    <link rel="shortcut icon" href="<?php echo Yii::$app->request->baseUrl; ?>/img/favicon.ico" type="image/x-icon" />

    <link rel="apple-touch-icon" sizes="57x57" href="<?php echo Yii::$app->request->baseUrl; ?>/img/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="<?php echo Yii::$app->request->baseUrl; ?>/img/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="<?php echo Yii::$app->request->baseUrl; ?>/img/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="<?php echo Yii::$app->request->baseUrl; ?>/img/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="<?php echo Yii::$app->request->baseUrl; ?>/img/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="<?php echo Yii::$app->request->baseUrl; ?>/img/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="<?php echo Yii::$app->request->baseUrl; ?>/img/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="<?php echo Yii::$app->request->baseUrl; ?>/img/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo Yii::$app->request->baseUrl; ?>/img/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="<?php echo Yii::$app->request->baseUrl; ?>/img/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo Yii::$app->request->baseUrl; ?>/img/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="<?php echo Yii::$app->request->baseUrl; ?>/img/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo Yii::$app->request->baseUrl; ?>/img/favicon-16x16.png">
    <link rel="manifest" href="<?php echo Yii::$app->request->baseUrl; ?>/img/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="<?php echo Yii::$app->request->baseUrl; ?>/img/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <meta name="google-site-verification" content="TWFmD-DWW_JmKuD6qMA7gyyh3DxkQYrSMS3wH232-O0" />
    <?php $this->head() ?>
<!--    <script type="text/javascript">
    (function(p,u,s,h){
        p._pcq=p._pcq||[];
        p._pcq.push(['_currentTime',Date.now()]);
        s=u.createElement('script');
        s.type='text/javascript';
        s.async=true;
        s.src='https://cdn.pushcrew.com/js/92305e94275779fe485dce7789975c5f.js';
        h=u.getElementsByTagName('script')[0];
        h.parentNode.insertBefore(s,h);
    })(window,document);
</script>-->
<!-- Smartsupp Live Chat script -->

<script type="text/javascript">
var _smartsupp = _smartsupp || {};
_smartsupp.key = '7bc9a47e7b571d65b7b337bcc672c9c6b8fe1a5c';
window.smartsupp||(function(d) {
	var s,c,o=smartsupp=function(){ o._.push(arguments)};o._=[];
	s=d.getElementsByTagName('script')[0];c=d.createElement('script');
	c.type='text/javascript';c.charset='utf-8';c.async=true;
	c.src='//www.smartsuppchat.com/loader.js?';s.parentNode.insertBefore(c,s);
})(document);
</script>

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-92625122-1', 'auto');
  ga('send', 'pageview');

</script>

</head>
