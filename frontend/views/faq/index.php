<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'FAQ - Najczęściej zadawane pytania';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="green-border"></div>
    <?php
    foreach ($model as $oFaqGruop)
    {
    ?>
        
    <div class="faq-group">
        <div class="faq-group-title m21b text-center"><?= $oFaqGruop->name ?></div>
        <div class="center-green-border"></div>

        <?php
            foreach ($oFaqGruop->questions as $oFaq)
            {
        ?>  
                <div class="faq">
                    <div class="faq-question m18b" rel="<?= $oFaq->id ?>"><i class="fa fa-question-circle" aria-hidden="true"></i> <?=$oFaq->question?></div>
                    <div class="faq-answer faq-hide faq-answer-<?= $oFaq->id ?>"><?= $oFaq->answer ?></div>   
                </div>
        <?php
            }
        ?>
    </div>
        
    <?php
    }
    ?>
</div>
