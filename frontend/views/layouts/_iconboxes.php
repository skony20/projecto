<?php
use yii\helpers\Html;
use frontend\widget\LatestWidget;
?>
<div class="wrap wrap-icon">
    <div class="container container-icon">
        <div class="col-md-3 hidden-sm hidden-xs col-icon">
            <div class="icon-img"><?= Html::img(Yii::$app->request->BaseUrl.'/img/circle.png', ['class'=>'first_icon'])?></div>
            <div class="icon-text">
                <div class="icon-text-inner-top">services</div>
                <div class="icon-text-inner-bottom">house plan design</div>
            </div>
            <div class="icon-img"><?= Html::img(Yii::$app->request->BaseUrl.'/img/arrow.png', ['class'=>'arrow_icon'])?></div>
        </div>
        <div class="col-md-3 hidden-sm hidden-xs col-icon">
            <div class="icon-img"><?= Html::img(Yii::$app->request->BaseUrl.'/img/lightbulb.png', ['class'=>'first_icon'])?></div>
            <div class="icon-text">
                <div class="icon-text-inner-top">about</div>
                <div class="icon-text-inner-bottom">low-energy houses</div>
            </div>
            <div class="icon-img"><?= Html::img(Yii::$app->request->BaseUrl.'/img/arrow.png', ['class'=>'arrow_icon'])?></div>
        </div>
        <div class="col-md-3 hidden-sm hidden-xs col-icon">
            <div class="icon-img"><?= Html::img(Yii::$app->request->BaseUrl.'/img/tools.png', ['class'=>'first_icon'])?></div>
            <div class="icon-text">
                <div class="icon-text-inner-top">about</div>
                <div class="icon-text-inner-bottom">construction systems</div>
            </div>
            <div class="icon-img"><?= Html::img(Yii::$app->request->BaseUrl.'/img/arrow.png', ['class'=>'arrow_icon'])?></div>
        </div>
        <div class="col-md-3 hidden-sm hidden-xs col-icon">
            <div class="icon-img"><?= Html::img(Yii::$app->request->BaseUrl.'/img/video.png', ['class'=>'first_icon'])?></div>
            <div class="icon-text">
                <div class="icon-text-inner-top">latest</div>
                <div class="icon-text-inner-bottom">open house days</div>
            </div>
            <div class="icon-img"><?= Html::img(Yii::$app->request->BaseUrl.'/img/arrow.png', ['class'=>'arrow_icon'])?></div>
        </div>
    </div>
</div>
<div class="wrap wrap-services">
    <div class="container container-services">
        <div class="col-md-3 col-sm-6 text-center" >
            <?= Html::img(Yii::$app->request->BaseUrl.'/img/service-1.png', ['class'=>'service-img'])?><br>
            <div class="text18m">House plan design</div><br>
            <div class="text13o">Zou can order custom house plan design or choose one from wide varietz of premade house plans.</div>
        </div>
        <div class="col-md-3 col-sm-6 text-center">
            <?= Html::img(Yii::$app->request->BaseUrl.'/img/service-2.png', ['class'=>'service-img'])?><br>
            <div class="text18m">House Adaptation</div><br>
            <div class="text13o">Need to make some adjustments to existing real estate_ Contact us to get a free quote or plan a meeting..</div>
        </div>
        <div class="col-md-3 col-sm-6 text-center">
            <?= Html::img(Yii::$app->request->BaseUrl.'/img/service-3.png', ['class'=>'service-img'])?><br>
            <div class="text18m">House Construction</div><br>
            <div class="text13o">We have a professional team of architects working on our house plans and construction workers.</div>
        </div>
        <div class="col-md-3 col-sm-6 text-center">
            <?= Html::img(Yii::$app->request->BaseUrl.'/img/service-4.png', ['class'=>'service-img'])?><br>
            <div class="text18m">Inner instalations</div><br>
            <div class="text13o">We provide closed/in szstems which means zour house is readz to move in / all exterior and interior work.</div>
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
                    <div class="popular-icon"><?= Html::img(Yii::$app->request->BaseUrl.'/img/popular-icon.png')?></div>
                    <div class="popular-name">Domy parterowe</div>
                    <div class="popular-link"><?= Html::img(Yii::$app->request->BaseUrl.'/img/link-blue.png')?></div>
                </div>
            </div>
            
           
        </div>
        <div class="col-md-4 hidden-xs">
            <div class="popular-img text-center">
                <?= Html::img(Yii::$app->request->BaseUrl.'/img/popular-2.png')?>
                <div class="text-left img-icons">
                    <div class="popular-icon"><?= Html::img(Yii::$app->request->BaseUrl.'/img/popular-icon.png')?></div>
                    <div class="popular-name">Domy z poddaszem</div>
                    <div class="popular-link"><?= Html::img(Yii::$app->request->BaseUrl.'/img/link-blue.png')?></div>
                </div>
            </div>
            
        </div>
        <div class="col-md-4 hidden-xs">
            <div class="popular-img text-center">
                <?= Html::img(Yii::$app->request->BaseUrl.'/img/popular-3.png')?>
                <div class="text-left img-icons">
                    <div class="popular-icon"><?= Html::img(Yii::$app->request->BaseUrl.'/img/popular-icon.png')?></div>
                    <div class="popular-name">Domy wielopiętrowe</div>
                    <div class="popular-link"><?= Html::img(Yii::$app->request->BaseUrl.'/img/link-blue.png')?></div>
                </div>
            </div>
            
        </div>
        <div class="col-md-4 hidden-xs">
            <div class="popular-img text-center">
                <?= Html::img(Yii::$app->request->BaseUrl.'/img/popular-4.png')?>
                <div class="text-left img-icons">
                    <div class="popular-icon"><?= Html::img(Yii::$app->request->BaseUrl.'/img/popular-icon.png')?></div>
                    <div class="popular-name">Domy z piwnicą</div>
                    <div class="popular-link"><?= Html::img(Yii::$app->request->BaseUrl.'/img/link-blue.png')?></div>
                </div>
            </div>
            
        </div>
        <div class="col-md-4 hidden-xs">
            <div class="popular-img text-center">
                <?= Html::img(Yii::$app->request->BaseUrl.'/img/popular-5.png')?>
                <div class="text-left img-icons">
                    <div class="popular-icon"><?= Html::img(Yii::$app->request->BaseUrl.'/img/popular-icon.png')?></div>
                    <div class="popular-name">Domy z garażem </div>
                    <div class="popular-link"><?= Html::img(Yii::$app->request->BaseUrl.'/img/link-blue.png')?></div>
                </div>
            </div>
            
        </div>
        <div class="col-md-4 hidden-xs">
            <div class="popular-img text-center">
                <?= Html::img(Yii::$app->request->BaseUrl.'/img/popular-5.png')?>
                <div class="text-left img-icons">
                    <div class="popular-icon"><?= Html::img(Yii::$app->request->BaseUrl.'/img/popular-icon.png')?></div>
                    <div class="popular-name">Domy z garażem wielostanowiskowym</div>
                    <div class="popular-link"><?= Html::img(Yii::$app->request->BaseUrl.'/img/link-blue.png')?></div>
                </div>
            </div>
            
        </div>
    </div>
</div>
<div class="wrap wrap-projects">
    <div class="container container-projects">
        <div class="projects-title r48 text-center">Ponad 2800 projektów</div>
        <div class="projects-content m13blue text-center"><?= Html::img(Yii::$app->request->BaseUrl.'/img/search-white.png')?><?=Html::a('Znajdź dom marzeń', Yii::$app->request->BaseUrl.'/projekty')?></div>
    </div>
</div>
<div class="wrap wrap-latest">
    <div class="container container-latest">
        <div class="latest-title text-center">Najnowsze produkty</div>
        <div class="center-green-border text-center"></div>
        <?php echo LatestWidget::widget(); ?>
    </div>
    
</div>
<div class="wrap wrap-people">
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
    
</div>
    
    