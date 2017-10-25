<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;

/*  
    Projekt    : projekttop.pl
    Created on : 2017-10-19, 12:15:39
    Author     : Mariusz Skonieczny, mariuszskonieczny@hotmail.com
*/
$this->title = 'Podobne projekty do ';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Projekty'), 'url' => ['products/index']];
$this->params['breadcrumbs'][] = $this->title;
$aCheckoxListSimilar = [];
$aCheckListChecked = [];


?>
<div class="similar-index">

    <h1><?= Html::encode($this->title) .'<span class="sNameSimilar"><strong>' .$sActualName .'</strong></span>'?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    
    <div class="similar-form">

        <?php
        ?>
        <form action="" method="get" id="find-similar-form">
            <input type='text' name='sName' value='<?=$sName?>' class='sName'/>
            <button type='submit' class='find-similar-button btn btn-primary'>Szukaj</button>
        </form>
    </div>
    <div class='col-md-4'>
        <?php 
        if(count($aProductsFind) >0) 
        {
            echo '<div class="exist-similar-title">Dodaj podobne projekty</div>';
            
            echo '<div class="find-similar">';
            echo '<div id="check-all-similar" class="btn btn-warning">Zaznacz wszystkie</div>';
            $form = ActiveForm::begin([
            'id' => 'add-similar',
            'action'=>'../../similar/add'
            ]);
            
            foreach ($aProductsFind as $aProductFind)
            {
                $aCheckoxListSimilar[$aProductFind->id] = $aProductFind->productsDescriptons->name .' (' .$aProductFind->producers->name . ')' ;
                $oSimilar2 = new app\models\Similar();
                if ($oSimilar2->findOne(['main_product_id'=>$iId, 'products_id'=>$aProductFind->id]))
                {
                    $aCheckListChecked[]=$aProductFind->id;
                }
            }
            $oSimilar = new \app\models\Similar();
            $oSimilar->main_product_id = $iId;
            $oSimilar->products_id = $aCheckListChecked;
            
            echo $form->field($oSimilar, 'main_product_id')->hiddenInput()->label(false);
            echo $form->field($oSimilar, 'products_id')->checkboxList($aCheckoxListSimilar)->label(false);
        ?>
        <?= Html::submitButton('Dodaj podobne', ['class' => 'add-similar-button btn btn-primary']) ?>
    
        <?php ActiveForm::end();
            echo '</div>';
        }
        ?>
        </div>
    <div class="col-md-4">
        <?php
        if(count($aProductsExist) >0) 
        {
            echo '<div class="exist-similar-title">Przypisane podobne projekty</div>';
            echo '<div class="exist-similar">';
            foreach ($aProductsExist as $aProductExist)
            {
                echo '<div class="similar-exist-row">'.$aProductExist->productsDescriptons->name .' <span class="remove-similar" rel="'.$aProductExist->id.'" rel2="'.$iId.'" title="Usuń">x</span></div>';
            }
            
            echo '</div>';
        }
        ?>
    </div>
    </div>

</div>