<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use frontend\widget\CartWidget;
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
        'options' => ['class' => 'navbar-nav navbar-left'],
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
       <?= Html::a(Html::img(Yii::$app->request->BaseUrl.'/img/logo.png', ['class'=>'logo']), Yii::$app->homeUrl) ?>
    </div>
</div>