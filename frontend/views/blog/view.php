<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
/*  
    Projekt    : projekttop.pl
    Created on : 2017-07-27, 14:15:13
    Author     : Mariusz Skonieczny, mariuszskonieczny@hotmail.com
*/

$this->title = 'Blog - ' . $aPost->title;
$this->params['breadcrumbs'][] = ['label' => 'Blog', 'url' => ['/blog']];
$this->params['breadcrumbs'][] = ['label' => $aPost->blogPostToCategories['category']['name'], 'url' => ['/blog/kategoria/'.$aPost->blogPostToCategories['category']['nice_name'].'.html']];
$this->params['breadcrumbs'][] = $aPost->title;
$url = Yii::$app->request->absoluteUrl;
?>
<div class="blog-view">
    <div class="blog-view-1">
        <div class="blog-view-date inline-block"><i class="fa fa-calendar blog-green-icon" aria-hidden="true"></i> <?=  date('d-m-y', strtotime($aPost->date_published))?></div>
        <div class="blog-view-category inline-block float-right"><?=$aPost->blogPostToCategories['category']['name']?></div>
        <br>
        <div class="blog-view-title inline-block m24b"><?=$aPost->title?></div>
        <div class="blog-view-share inline-block"><i class="fa fa-comments-o dark-blue" aria-hidden="true"></i> (<?=count($aPost->blogComments)?>) |  Podziel się: 
        <?= Html::a('<i class="fa fa-facebook share-icon blog-share" aria-hidden="true"></i>', 'https://www.facebook.com/sharer/sharer.php?u='.$url, ['title'=>'Facebook', 'class'=>'add_share', 'rel'=>$aPost->id])?>
        <?= Html::a('<i class="fa fa-twitter share-icon blog-share" aria-hidden="true"></i>', 'https://twitter.com/home?status='.$url, ['title'=>'Twitter', 'class'=>'add_share', 'rel'=>$aPost->id])?>
        <?= Html::a('<i class="fa fa-google-plus share-icon blog-share" aria-hidden="true"></i>','https://plus.google.com/share?url='.$url, ['title'=>'Google +', 'class'=>'add_share', 'rel'=>$aPost->id])?>
        <?= Html::a('<i class="fa fa-linkedin share-icon blog-share" aria-hidden="true"></i>', 'https://www.linkedin.com/shareArticle?mini=true&url='.$url.'&title='.$aPost->title.'&summary=&source=projekttop.pl', ['title'=>'Linkedin', 'class'=>'add_share', 'rel'=>$aPost->id])?></div>
    </div>
    <div class="blog-view-content">
        <?= $aPost->article?>
    </div>
    
</div>

<?php if ($aPost->comments_enabled && count($aPost->blogComments) >0)
    {
    ?>
    <div class="blog-view-comments">
        <div class="blog-view-comments-title text-center m21b ">Komentarze</div>
        <div class="center-green-border"></div>
    
    <?php
        $aIds=[];
        foreach ($aPost->blogComments as $aComment)
        {
            
            //echo '<pre>'. print_r($aComment->answer($aComment->id), TRUE) .'</pre>';
        ?>
        <div class="comment-row row">
            <div class="col-md-2 col-xs-1">&nbsp;</div>
            <div class="comment-row-content col-md-8 col-xs-10 <?=(($aComment->is_reply_to_id != 0) ? 'comment-row-content-answer' : '')?>">
                <div class="comment-row-avatar inline-block"><?= Html::img(Yii::$app->request->BaseUrl.'/img/avatar.png', ['class'=>'avatar'])?></div>
                <div class="comment-row-comment inline-block">
                    <span class="m15b"><?=$aComment->name?></span> <br>
                    <span class="o13ilg"><?=date('d-m-y H:i:s', strtotime($aComment->date))?></span><br><br>
                    <span><?=$aComment->comment.'<br>'?></span>
                </div>
                <div class="comment-row-reply block text-right"><?=(($aComment->is_reply_to_id == 0) ? '<i class="fa fa-repeat" aria-hidden="true"></i> Odpowiedz ' : '')?><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> <?=$aComment->like?></div>
            </div>
            <div class="col-md-2 col-xs-1">&nbsp;</div>
            
            
        </div>
        
            
        <?php
        }
    ?>
  
    
    </div>
 
  <?php
    }
    
    ?>  
  <?php if ($aPost->comments_enabled)
    {
      ?>
   
   <div class="comment-answer col-md-12 col-xs-12">
        <div class="col-md-2 hidden-xs">&nbsp;</div>
        <div class="col-md-8 col-xs-12">
            <h1 class="m21b">Zostaw komentarz</h1>
            <div class="green-border"></div>
                <?php $form = ActiveForm::begin(['id' => 'comment-answer-form', 'options' => ['class' => 'form-inline']]) ?>

                <?= $form->field($aNewComment, 'name')->textInput()->label('<i class="fa fa-pencil fa-lg contact-icon" aria-hidden="true"></i><span class="red">*</span> Imię') ?>

                <?= $form->field($aNewComment, 'email')->input('email')->label('<i class="fa fa-globe fa-lg contact-icon" aria-hidden="true"></i><span class="red">*</span> Adres e-mail') ?>
                <?= $form->field($aNewComment, 'comment')->textarea(['rows' => 6])->label('<i class="fa fa-envelope contact-icon contact-textarea" aria-hidden="true"></i><span class="red">*</span> Treść wiadomości', ["class"=>"blog-answer-tearea-label"]) ?>
                <?= $form->field($aNewComment, 'post_id')->hiddenInput(['value'=>$aPost->id])->label(false)?>
                <?= Html::submitButton("Wyślij", ["class" => "contact-submit btn btn-primary", "name" => "contact-button"]) ?>
                    <?php ActiveForm::end(); ?>
        </div>
        
        <div class="col-md-2 hidden-xs">&nbsp;</div>
    </div>
<?php
    }
    
    ?>