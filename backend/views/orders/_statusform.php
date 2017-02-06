<?php

/* 
    Projekt    : projekttop.pl
    Created on : 2017-02-05, 21:12:39
    Author     : Mariusz Skonieczny mariuszskonieczny@hotmail.com
*/
use yii\helpers\Html;
use app\models\OrdersStatus;
use yii\helpers\ArrayHelper;



echo Html::beginForm('#');
echo Html::dropDownList('Zmień status', '', ArrayHelper::map(OrdersStatus::find()->asArray()->all(), 'id', 'name'),['class'=>'form-control','prompt' => 'Zmień']);
echo Html::endForm();
?>
