<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use frontend\widget\CartWidget;
$sSearch = (isset($_GET['szukaj']) ? $_GET['szukaj']: '');
?>
<?php $aSessionCart = Yii::$app->session->get('Cart'); ?>
<?php
    NavBar::begin();
    $menuItems = [
        ['label' => 'Faq', 'url' => ['/faq']],
        ['label' => 'O nas', 'url' => ['/onas']],
        ['label' => 'Co zawiera projekt', 'url' => ['/wprojekcie']],
    ];
    if (Yii::$app->user->isGuest) {
        $menuItemsR[] = ['label' => 'Rejestracja', 'url' => ['/signup']];
        $menuItemsR[] = ['label' => 'Logowanie', 'url' => ['/login']];
    } else {
        $menuItemsR[] = ['label' => 'Moje konto', 'url' => ['/user/account']];
        $menuItemsR[] = ['label' => 'Ulubione projekty', 'url' => ['/user/favorites']];
        $menuItemsR[] = '<li>'
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
                'Logout (' . Yii::$app->user->identity->delivery_name . ')',
                ['class' => 'btn btn-link']
            )
            . Html::endForm()
            . '</li>';
    }
    $menuItemsR[] = '<li>'
            . CartWidget::widget(['aSessionCart' => $aSessionCart])
            . '</li>';
                
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-left '],
        'items' => $menuItems
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItemsR
    ]);
    

    NavBar::end();
    ?>
<div class="container">
    <div class="second-menu">
        <div class="logo nav_inline">
            <?= Html::a(Html::img(Yii::$app->request->BaseUrl.'/img/logo.png', ['class'=>'logo']), Yii::$app->homeUrl) ?>
        </div>
        <div class="contact nav_inline">
            <div class="nav_block">
                <?= Html::img(Yii::$app->request->BaseUrl.'/img/phone.png', ['class'=>'contact_png']) ?> +48 608 44 07 55
                <?= Html::img(Yii::$app->request->BaseUrl.'/img/hours.png', ['class'=>'contact_png']) ?> PN-PT 08:00 - 20:00 
            </div>
            <div class="nav_block">
                <div class="second_nav">
                <?php
                NavBar::begin();
                $menuItems = [
                    ['label' => 'Główna', 'url' => ['/']],
                    ['label' => 'Projekty', 'url' => ['/projekty']],
                    ['label' => 'Nowości', 'url' => ['/projekty']],
                    ['label' => 'O nas', 'url' => ['/onas']],
                    ['label' => 'Kontakt', 'url' => ['/kontakt']],
                ];
                echo Nav::widget([
                    'options' => ['class' => 'second-navbar navbar-nav '],
                    'items' => $menuItems
                ]);


                NavBar::end();
                ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="wrap search-bar-wrap">
    <div class="container search-bar-container">
        <div class="col-md-2 hidden-xs  hidden-sm text-right">Szukaj planu</div>
        <div class="col-md-10  col-xs-12 col-sm-12">
            <div class="search-from-index">
            <?php
            echo Html::beginForm();
            echo Html::input('text', 'szukaj', $sSearch, ['class'=>'search-input', 'placeholder'=>'Jakiego projektu szukasz ?']);
            echo Html::Button(Html::img(Yii::$app->request->BaseUrl.'/img/search.png'),['class'=>'search-submit']);
            ?>
            <?= Html::endForm() ?>
        </div>
        </div>
    </div>
</div>