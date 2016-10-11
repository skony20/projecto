<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
$sPatch = Yii::getAlias('@image');
/* @var $this yii\web\View */
/* @var $model app\models\Products */

$this->title = 'Projekt: '.$model->productsDescriptons->name;
$this->title .=($model->productsDescriptons->name_model ? ' '.$model->productsDescriptons->name_model: '');
$this->title .=($model->productsDescriptons->name_subname ? ' ' .$model->productsDescriptons->name_subname : '');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Projekt'), 'url' => ['/site/projekty']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="products-view">

    <h1><?= Html::encode($this->title) ?></h1>
    
    
    
    <div class="prj-images">
        <div class="prj-first-image">
            <a class="fancybox" rel="group" href="<?=$sPatch.'/'.$model->id.'/big/'.$model->productsImages[0]->name ?>"><img src="<?=$sPatch.'/'.$model->id.'/big/'.$model->productsImages[0]->name ?>"/></a>
        </div>
        <?php
        for ($a=1; $a=count($model->productsImages)-1; $a++)
        {   
        ?>
            <div class="project-image">
                <a class="fancybox" rel="group" href="<?=$sPatch.'/'.$model->id.'/big/'.$model->productsImages[$a]->name?>"><img src="<?=$sPatch.'/'.$model->id.'/thumbs/'.$model->productsImages[$a]->name?>"/></a>
            </div>
        <?php
        }
        ?>
    </div>
    
</div>
