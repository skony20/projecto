<?php
use yii\base\Widget;
use yii\helpers\Html;
use common\widgets\Alert;
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
                    <i class="fa fa-facebook" aria-hidden="true"></i>
                    <i class="fa fa-twitter" aria-hidden="true"></i>
                    <i class="fa fa-google-plus" aria-hidden="true"></i>
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
                    <li><?= Html::a('Polityka prywatności', Yii::$app->request->BaseUrl.'/polityka-prywatnosci')?></li>
                    <li><?= Html::a('Zwrot', Yii::$app->request->BaseUrl.'/zwrot')?></li>
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
                    <i class="fa fa-envelope submit-newslatter" aria-hidden="true"></i>
                </div>
            </div>
            
        </div>

    </div>
</footer>
<footter class="after-footer">
    <div class="wrap">
        <div class="container">
            <div class="pull-left after-footer-content"><i class="fa fa-info fa-3x cookie-info" aria-hidden="true"></i>ProjektTop.pl korzysta z technologii opartej na wykorzystaniu plików cookie. Używamy ich w celu dostosowania witryny do potrzeb użytkowników. W każdej chwili możesz wyłączyć obsługę plików cookie w ustawieniach swojej przeglądarki. Więcej informacji na temat wykorzystywanych przez nas rozwiązań znajdziesz w polityce prywatności.</div>
            <div class="pull-right after-footer-content">ProjektTop.pl 2017 - Wszelkie prawa zastrzeżone<br><br>Widzisz bład, zgłoś do: <?= Html::a(Yii::$app->params['adminEmail'], 'mailto:"'.Yii::$app->params['adminEmail'].'"') ?> </div>
        </div>
    </div>

</footter>

<?php
   if(Yii::$app->getSession()->getAllFlashes()) {
      $this->registerJs("$('#system-messages').fadeIn().animate({opacity: 1.0}, 4000). fadeOut('slow');");
   }
?>

<div id="system-messages" style="opacity: 1; display: none">
   <?= Alert::widget(); ?>
</div>