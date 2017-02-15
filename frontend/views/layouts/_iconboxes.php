<?php
use yii\helpers\Html;
use frontend\widget\LatestWidget;
?>
<div class="wrap wrap-icon">
    <div class="container container-icon">
        <div class="col-md-3 hidden-sm hidden-xs col-icon">
            <div class="icon-img"><?= Html::img(Yii::$app->request->BaseUrl.'/img/circle.png', ['class'=>'first_icon'])?></div>
            <div class="icon-text">
                <div class="icon-text-inner-top">PROJEKTY</div>
                <div class="icon-text-inner-bottom">Znajdź wymażony projekt.</div>
            </div>
            <div class="icon-img"><?= Html::img(Yii::$app->request->BaseUrl.'/img/arrow.png', ['class'=>'arrow_icon'])?></div>
        </div>
        <div class="col-md-3 hidden-sm hidden-xs col-icon">
            <div class="icon-img"><?= Html::img(Yii::$app->request->BaseUrl.'/img/lightbulb.png', ['class'=>'first_icon'])?></div>
            <div class="icon-text">
                <div class="icon-text-inner-top">Adaptacje projektów</div>
                <div class="icon-text-inner-bottom">Zgoda na adaptację projektów</div>
            </div>
            <div class="icon-img"><?= Html::img(Yii::$app->request->BaseUrl.'/img/arrow.png', ['class'=>'arrow_icon'])?></div>
        </div>
        <div class="col-md-3 hidden-sm hidden-xs col-icon">
            <div class="icon-img"><?= Html::img(Yii::$app->request->BaseUrl.'/img/tools.png', ['class'=>'first_icon'])?></div>
            <div class="icon-text">
                <div class="icon-text-inner-top">Systemy budowy</div>
                <div class="icon-text-inner-bottom">Buduj jak chcesz</div>
            </div>
            <div class="icon-img"><?= Html::img(Yii::$app->request->BaseUrl.'/img/arrow.png', ['class'=>'arrow_icon'])?></div>
        </div>
        <div class="col-md-3 hidden-sm hidden-xs col-icon">
            <div class="icon-img"><?= Html::img(Yii::$app->request->BaseUrl.'/img/video.png', ['class'=>'first_icon'])?></div>
            <div class="icon-text">
                <div class="icon-text-inner-top">Instalacje i wyposażenie</div>
                <div class="icon-text-inner-bottom">Wszystkie instalacje w cenie</div>
            </div>
            <div class="icon-img"><?= Html::img(Yii::$app->request->BaseUrl.'/img/arrow.png', ['class'=>'arrow_icon'])?></div>
        </div>
    </div>
</div>
<div class="wrap wrap-services">
    <div class="container container-services">
        <div class="col-md-3 col-sm-6 text-center" >
            <?= Html::img(Yii::$app->request->BaseUrl.'/img/service-1.png', ['class'=>'service-img'])?><br>
            <div class="text18m">Projekty</div><br>
            <div class="text13o">Nasz serwis zapewnia najłatwiejszy sposób wyszukiwania projektu, który ma spełniać Twoje wymagania. Oferujemy projekty z najlepszych polskich pracowni. Staramy się uzupełniać naszą ofertę o projekty kolejnych pracowni dlatego nasz serwis będzie rozwijał się jeszcze przez długie lata.</div>
        </div>
        <div class="col-md-3 col-sm-6 text-center">
            <?= Html::img(Yii::$app->request->BaseUrl.'/img/service-2.png', ['class'=>'service-img'])?><br>
            <div class="text18m">Adaptacje projektów</div><br>
            <div class="text13o">Wszystkie projekty należy adaptować do warunków lokalnych. Można to zrobić zarówno w swojej lokalnej pracowni architektonicznej lub możesz skorzystać ze sprawdzonymi pracowniami architektonicznymi, które współpracują z naszym serwisem.</div>
        </div>
        <div class="col-md-3 col-sm-6 text-center">
            <?= Html::img(Yii::$app->request->BaseUrl.'/img/service-3.png', ['class'=>'service-img'])?><br>
            <div class="text18m">Systemy budowy</div><br>
            <div class="text13o">Każdy z projektów przygotowany jest do budowania zarówno sposobem gospodarczym lub może być zlecony w całości do wykonania profesjonalnej firmie. Pamiętaj, że metoda gospodarcza na pewno jest tańszym sposobem ale musisz poświęcić więcej swojego czasu i uwagi. Satysfakcja z obserwowania jak powstaje dom Twoich marzeń - "bezcenna".</div>
        </div>
        <div class="col-md-3 col-sm-6 text-center">
            <?= Html::img(Yii::$app->request->BaseUrl.'/img/service-4.png', ['class'=>'service-img'])?><br>
            <div class="text18m">Instalacje i wyposażenie</div><br>
            <div class="text13o">Każdy projekt zawiera cześć związaną z instalacją we wszystkich branżach. W projekcie zawarte są instalacje elektryczne, hydrauliczne a dla projektów gdzie ogrzewanie jest przy pomocy pieca gazowego zawarta jest instalacja gazowa. Wszystkie instalacje mogą być zmienione na etapie adaptacji - wymaga to pracy osoby z odpowiednimi uprawnieniami.</div>
        </div>
    </div>
</div>
<div class="wrap wrap-popular">
    <div class="container container-popular">
        <div class="popular-title text-center">Popularne projekty</div>
        <div class="center-green-border text-center"></div>
        <div class="col-md-4 hidden-xs">
            <div class="popular-img text-center">
                <?= Html::img(Yii::$app->request->BaseUrl.'/img/popular-1.png')?>
                <div class="text-left img-icons">
                    <div class="popular-icon"><i class="fa fa-tags fa-lg" aria-hidden="true"></i></div>
                    <div class="popular-name">Domy parterowe</div>
                    <?=Html::a('<div class="popular-link"><i class="fa fa-external-link fa-lg" aria-hidden="true"></i></div>', Yii::$app->request->BaseUrl.'/projekty/filters/17')?>
                   
                </div>
            </div>
            
           
        </div>
        <div class="col-md-4 hidden-xs">
            <div class="popular-img text-center">
                <?= Html::img(Yii::$app->request->BaseUrl.'/img/popular-2.png')?>
                <div class="text-left img-icons">
                    <div class="popular-icon"><i class="fa fa-tags fa-lg" aria-hidden="true"></i></div>
                    <div class="popular-name">Domy z poddaszem</div>
                    <?=Html::a('<div class="popular-link"><i class="fa fa-external-link fa-lg" aria-hidden="true"></i></div>', Yii::$app->request->BaseUrl.'/projekty/filters/18')?>
                </div>
            </div>
            
        </div>
        <div class="col-md-4 hidden-xs">
            <div class="popular-img text-center">
                <?= Html::img(Yii::$app->request->BaseUrl.'/img/popular-3.png')?>
                <div class="text-left img-icons">
                    <div class="popular-icon"><i class="fa fa-tags fa-lg" aria-hidden="true"></i></div>
                    <div class="popular-name">Domy wielopiętrowe</div>
                    <?=Html::a('<div class="popular-link"><i class="fa fa-external-link fa-lg" aria-hidden="true"></i></div>', Yii::$app->request->BaseUrl.'/projekty/filters/19')?>
                </div>
            </div>
            
        </div>
        <div class="col-md-4 hidden-xs">
            <div class="popular-img text-center">
                <?= Html::img(Yii::$app->request->BaseUrl.'/img/popular-4.png')?>
                <div class="text-left img-icons">
                    <div class="popular-icon"><i class="fa fa-tags fa-lg" aria-hidden="true"></i></div>
                    <div class="popular-name">Domy z piwnicą</div>
                    <?=Html::a('<div class="popular-link"><i class="fa fa-external-link fa-lg" aria-hidden="true"></i></div>', Yii::$app->request->BaseUrl.'/projekty/filters/20/21')?>
                </div>
            </div>
            
        </div>
        <div class="col-md-4 hidden-xs">
            <div class="popular-img text-center">
                <?= Html::img(Yii::$app->request->BaseUrl.'/img/popular-5.png')?>
                <div class="text-left img-icons">
                    <div class="popular-icon"><i class="fa fa-tags fa-lg" aria-hidden="true"></i></div>
                    <div class="popular-name">Domy z garażem </div>
                    <?=Html::a('<div class="popular-link"><i class="fa fa-external-link fa-lg" aria-hidden="true"></i></div>', Yii::$app->request->BaseUrl.'/projekty/filters/24')?>
                </div>
            </div>
            
        </div>
        <div class="col-md-4 hidden-xs">
            <div class="popular-img text-center">
                <?= Html::img(Yii::$app->request->BaseUrl.'/img/popular-6.png')?>
                <div class="text-left img-icons">
                    <div class="popular-icon"><i class="fa fa-tags fa-lg" aria-hidden="true"></i></div>
                    <div class="popular-name">Domy z garażem wielostanowiskowym</div>
                    <?=Html::a('<div class="popular-link"><i class="fa fa-external-link fa-lg" aria-hidden="true"></i></div>', Yii::$app->request->BaseUrl.'/projekty/filters/25')?>
                </div>
            </div>
            
        </div>
    </div>
</div>
<?php
$oProducts = new \app\models\Products();
$iAvalaibleProject = $oProducts->Countall();
$iAvalaibleProject = floor($iAvalaibleProject / 100)* 100;
?>

<div class="wrap wrap-projects">
    <div class="container container-projects">
        <div class="projects-title r48 text-center">Ponad <?= $iAvalaibleProject ?> projektów</div>
        <div class="projects-content m13blue text-center"><?=Html::a('<i class="fa fa-search" aria-hidden="true"></i> Znajdź dom marzeń', Yii::$app->request->BaseUrl.'/projekty')?></div>
    </div>
</div>
<div class="wrap wrap-latest">
    <div class="container container-latest">
        <div class="latest-title text-center">Najnowsze produkty</div>
        <div class="center-green-border text-center"></div>
        <?php
        echo LatestWidget::widget(['limit'=>4]); 
        ?>
    </div>
    
</div>
<!--<div class="wrap wrap-people">
    <div class="container container-people">
        <div class="people-title text-center">Nasi klienci o nas</div>
        <div class="center-green-border text-center"></div>
        <div class="col-md-6 hidden-sm hidden-xs people-comment">
            <div class="comment-content">We have several sites now built in Elvyre across several servers and have had almost zero issues. The documentation is great and the feature set is phenomenal...The end product is great and easy to use and configure. Highly recommended....
            </div>
            <div class="client-photo"><?= Html::img(Yii::$app->request->BaseUrl.'/img/client2.png')?></div>
            <div class="client-name"><span class="m15b">Olga Zdrzalik</span><br><span class="o13ib">dreamland-jewelry.pl</span></div>
        </div>
        <div class="col-md-6 hidden-sm hidden-xs people-comment">
            <div class="comment-content">Best customer support and response time I have evr seen... not to mention a kick ass theme! Great feeling from this pourchase.<br>
Thank you Pixel Industry!</div>
            <div class="client-photo"><?= Html::img(Yii::$app->request->BaseUrl.'/img/client1.png')?></div>
            <div class="client-name"><span class="m15b">Mateusz Jeronicz</span><br><span class="o13ib">ramkazdata.pl</span></div>
        </div>
        
    </div>
    
</div>-->
    
    