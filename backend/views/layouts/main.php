<?php   

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php if (isset($this->sHeadDesc))
    {
        ?>
    <description><?= Html::encode($this->sHeadDesc) ?></description>
    <?php
    }
    ?>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => 'projekttop.pl',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    $menuItems = [
        ['label' => 'Home', 'url' => ['/site/index']],
        ['label' => 'Zamówienia', 'url' => ['/orders']],
        ['label' => 'Projekty', 'url' => ['/products']],
        
        
         [
            'label' => 'Do projektów',
            'items' => [
                ['label' => 'Pytania', 'url' => ['/filters-group']],
                ['label' => 'Odpowiedzi', 'url' => ['/filters']],
                ['label' => 'Dane techniczne', 'url' => ['/attributes']],
                ['label' => 'Faq', 'url' => ['/faq']],
                ['label' => 'Grupa pytań', 'url' => ['/faq-group']],
            ],
        ],
        [
            'label' => 'Mniej istotne',
            'items' => [

                ['label' => 'Dostawcy', 'url' => ['/producers']],
                ['label' => 'Opis co w projekcie', 'url' => ['/in-project']],
                ['label' => 'Stawki Vat', 'url' => ['/vats']],
                ['label' => 'Metody płatności', 'url' => ['/payments-method']],
            ],
        ],
        [
            'label' => 'Import',
            'items' => [
                ['label' => 'Import CSV', 'url' => ['/xml/import']],
                ['label' => 'Import ProArte', 'url' => ['/xml/proarte']],
                ['label' => 'Import Dom Projekt', 'url' => ['/xml/domprojekt']],
                ['label' => 'Import Archipelag', 'url' => ['/xml/archipelag']],
                ['label' => 'Import Horyzont', 'url' => ['/xml/horyzont']],
                ['label' => 'Import MGProjekt', 'url' => ['/xml/mgprojekt']],
                ['label' => 'Wielkość działki'],
                ['label' => 'Archilepag - Wielkość działki', 'url' => ['/xml/rzut?producent=5']],
                ['label' => 'Dom-Projekt - Wielkość działki', 'url' => ['/xml/rzut?producent=6']],
                ['label' => 'HORYZONT - Wielkość działki', 'url' => ['/xml/rzut?producent=8']],
                ['label' => 'MGProjekt -Wielkość działki', 'url' => ['/xml/rzut?producent=9']],
                ['label' => 'Rzuty pięter'],
                ['label' => 'ProArte - Rzuty pięter do ogarnięcia ilości osób', 'url' => ['/xml/pietra?producent=3']],
                ['label' => 'Archipelag - Rzuty pięter do ogarnięcia ilości osób', 'url' => ['/xml/pietra?producent=5']],
                ['label' => 'Dom-Projekt - Rzuty pięter do ogarnięcia ilości osób', 'url' => ['/xml/pietra?producent=6']],
                ['label' => 'Z500 - Rzuty pięter do ogarnięcia ilości osób', 'url' => ['/xml/pietra?producent=7']],
                ['label' => 'HORYZONT - Rzuty pięter do ogarnięcia ilości osób', 'url' => ['/xml/pietra?producent=8']],
                ['label' => 'MGProjekt - Rzuty pięter do ogarnięcia ilości osób', 'url' => ['/xml/pietra?producent=9']],
            ],
        ],
        [
            'label' => 'Export',
            'items' => [
                ['label' => 'Export CSV ProArte', 'url' => ['/xml/export?=producent=3']],
                ['label' => 'Export CSV Archipelag', 'url' => ['/xml/export?=producent=5']],
                ['label' => 'Export CSV Dom-Projekt', 'url' => ['/xml/export?=producent=6']],
                ['label' => 'Export CSV Z500', 'url' => ['/xml/export?=producent=7']],
                ['label' => 'Export CSV Horyzont', 'url' => ['/xml/export?=producent=8']],
                ['label' => 'Export CSV MGProjekt', 'url' => ['/xml/export?=producent=9']],
                ],
        ],
        
    ];
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
    } else {
        $menuItems[] = '<li>'
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
                'Logout (' . Yii::$app->user->identity->username . ')',
                ['class' => 'btn btn-link']
            )
            . Html::endForm()
            . '</li>';
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; projekttop.pl <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::$app->params['adminEmail'] ?></p>
    </div>
</footer>
<?php
yii\bootstrap\Modal::begin([
    'headerOptions' => ['id' => 'modalHeader'],
    'id' => 'modal',
    'size' => 'modal-lg',
    //keeps from closing modal with esc key or by clicking out of the modal.
    // user must click cancel or X to close
    'clientOptions' => ['backdrop' => 1, 'keyboard' => true]
]);
echo "<div id='modalContent'></div>";
yii\bootstrap\Modal::end();
?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
