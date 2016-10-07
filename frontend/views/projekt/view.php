<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Products */

$this->title = $model->productsDescriptons->name . ' '. $model->productsDescriptons->name_model . ' ' . $model->productsDescriptons->name_subname ;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Projekt'), 'url' => ['/site/projekty']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="products-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
       
    </p>
    <?php
    $sPatch = Yii::getAlias('@image');
    
    
    echo '<div class="project_images">';
    foreach ($model->productsImages as $oProductsImages)
    {   
        echo '<div class="project_image">';
        echo '<a class="fancybox" rel="group" href="'. $sPatch.'/'.$model->id.'/big/'.$oProductsImages->name.'"><img src="'. $sPatch.'/'.$model->id.'/thumbs/'.$oProductsImages->name.'"/></a><br>';
        echo '</div>';
    }
    echo '</div>';
    ?>
    
</div>
