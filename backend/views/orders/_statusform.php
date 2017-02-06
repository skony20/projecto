<?php

/* 
    Projekt    : projekttop.pl
    Created on : 2017-02-05, 21:12:39
    Author     : Mariusz Skonieczny mariuszskonieczny@hotmail.com
*/
use yii\helpers\Html;
use app\models\OrdersStatus;
use yii\helpers\ArrayHelper;

echo Html::beginForm('statusform/'.$id);
echo Html::dropDownList('status_change', $iStatus, ArrayHelper::map(OrdersStatus::find()->asArray()->all(), 'id', 'name'),['class'=>'form-control','prompt' => 'Zmień', 'onchange'=> 'this.form.submit()']);
echo Html::endForm();
?>
