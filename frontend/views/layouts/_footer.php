<?php
use yii\base\Widget;
use yii\helpers\Html;
?>
<footer class="footer">
    <div class="container">
        <div class="col-md-3 col-sm-6">
            <div class="m15w footer-tittle">projekttop.pl</div>
            <div class="footer-content">Podleśna 11H<br>Ruda Bugaj<br>
                95-070 Aleksandrów Łódzki<br>
                <span class="m15w footer-phone"> +48 608 44 07 55</span><br>
                <?= Html::a(Yii::$app->params['supportEmail'], 'mailto:"'.Yii::$app->params['supportEmail'].'"') ?>
                <div class="footer-social">
                    <?= Html::img(Yii::$app->request->BaseUrl.'/img/footer-f.png')?>
                    <?= Html::img(Yii::$app->request->BaseUrl.'/img/footer-t.png')?>
                    <?= Html::img(Yii::$app->request->BaseUrl.'/img/footer-g.png')?>
                </div>
            </div>
            
        </div>
            
        <div class="col-md-3 col-sm-6">
            <div class="m15w footer-tittle">Szybkie menu</div>
            <div class="footer-content">
                <ul class="footer-menu">
                    <li><?= Html::a('O nas', Yii::$app->request->BaseUrl.'/onas')?></li>
                    <li><?= Html::a('Kontakt', Yii::$app->request->BaseUrl.'/kontakt')?></li>
                    <li><?= Html::a('FAQ', Yii::$app->request->BaseUrl.'/faq')?></li>
                    <li><?= Html::a('Co w projekcie', Yii::$app->request->BaseUrl.'/wprojekcie')?></li>
                    <li><?= Html::a('Regulamin', Yii::$app->request->BaseUrl.'/regulamin')?></li>
                    <li><?= Html::a('Cookie', Yii::$app->request->BaseUrl.'/cookie')?></li>
                </ul>
                        
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="m15w footer-tittle">Nowości i promocje</div>
            <div  class="footer-content">
                <div class="footer-news">
                    <div class="news-img"><?= Html::img(Yii::$app->request->BaseUrl.'/img/news1.png')?></div>
                    <div class="news-content">Nie mam pomysłu <br> co tu napisać<br><span class="m12b">01-01-2017</span></div>
                </div>
                <div class="footer-news">
                    <div class="news-img"><?= Html::img(Yii::$app->request->BaseUrl.'/img/news2.png')?></div>
                    <div class="news-content">Nie mam pomysłu <br> co tu napisać<br><span class="m12b">31-01-2017</span></div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div  class="footer-content">
                <div class="m15w footer-tittle">Newsletter</div>
                <div class="newsletter-text">Zapisz się na nasz newsletter. Z niego dowiesz się o nowościach, promocjach oraz eventach. Dzięki niemu na bieżąco możesz śledzić wydarzenia oraz informację o rozwoju.</div>
                <div class="newsletter-input"><?= Html::input('text', 'newslatter', '', ['class'=>'newsletter-input', 'placeholder'=>'Wpisz adres e-mail'])?>
                    <?= Html::img(Yii::$app->request->BaseUrl.'/img/newsletter-submit.png')?>
                </div>
            </div>
            
        </div>

    </div>
</footer>
<footter class="after-footer">
    <div class="container">
        <div class="pull-left">ProjektTop.pl 2017 - Wszelkie prawa zastrzeżone</div>
        <div class="pull-right">Widzisz bład, zgłoś do: <?= Html::a(Yii::$app->params['adminEmail'], 'mailto:"'.Yii::$app->params['adminEmail'].'"') ?> </div>
    </div>

</footter>