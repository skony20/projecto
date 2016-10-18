<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
?>
<?php
    NavBar::begin([
        'brandLabel' => Html::img(Yii::$app->request->BaseUrl.'/img/logo.png'),
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse',
        ],
    ]);
    $menuItems = [
        ['label' => 'Home', 'url' => ['/']],
        ['label' => 'Wszystkie projekty', 'url' => ['/projekty']],
        ['label' => 'About', 'url' => ['/about']],
        ['label' => 'Contact', 'url' => ['/contact']],
    ];
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Signup', 'url' => ['/signup']];
        $menuItems[] = ['label' => 'Login', 'url' => ['/login']];
    } else {
        $menuItems[] = ['label' => 'Moje konto', 'url' => ['/user/account']];
        $menuItems[] = ['label' => 'Ulubione projekty', 'url' => ['/user/favorites']];
        $menuItems[] = '<li>'
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
                'Logout (' . Yii::$app->user->identity->delivery_name . ')',
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
