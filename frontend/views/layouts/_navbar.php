<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use frontend\widget\CartWidget;

?>
<?php $aSessionCart = Yii::$app->session->get('Cart'); ?>
<?php
echo '<div class="first-navbar">';
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
                'Wyloguj (' . Yii::$app->user->identity->delivery_name . ')',
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
    echo '</div>';
    ?>
<div class="container">
    <div class="second-menu">
        <div class="logo nav_inline">
            <?= Html::a(Html::img(Yii::$app->request->BaseUrl.'/img/logo.png', ['class'=>'logo']), Yii::$app->homeUrl) ?>
        </div>
        <div class="contact nav_inline">
            <div class="nav_block nav_contact">
                <div>
                    <div class="margin-hor-10 inline-block"><i class="fa fa-phone icon-green" aria-hidden="true"></i></div> +48 608 44 07 55
                </div>
                <div>
                    <div class="margin-hor-10 inline-block"><i class="fa fa-clock-o icon-green" aria-hidden="true"></i></div>PN-PT 08:00 - 20:00 
                </div>
                
            </div>
            <div class="nav_block">
                <div class="second_nav">
                <?php
                NavBar::begin();
                $menuItems = [
                    ['label' => 'Główna', 'url' => ['/']],
                    ['label' => 'Popularne', 
                        'items' => [
                            ['label' => 'Domy do 100 m2', 'url' => Yii::$app->request->BaseUrl.'/projekty/HouseSize/0-100', 'options'=> ['class'=>'menu-bar']],
                            ['label' => 'Domy powyżej 300 m2', 'url' => Yii::$app->request->BaseUrl.'/projekty/HouseSize/300-999', 'options'=> ['class'=>'menu-bar']],
                            ['label' => 'Domy dla 4 osób z garażem', 'url' => Yii::$app->request->BaseUrl.'/projekty/filters/5/24/25'],
                            ['label' => 'Domy dla 2 osób z kominkiem', 'url' => Yii::$app->request->BaseUrl.'/projekty/filters/4/28'],
                            ['label' => 'Na wąską działkę', 'url' => Yii::$app->request->BaseUrl.'/projekty/filters/1'],
                            ['label' => 'Domy pasywne', 'url' => Yii::$app->request->BaseUrl.'/projekty/filters/33'],
            ],],
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
