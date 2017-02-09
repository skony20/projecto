<?php


/* 
    Projekt    : projekttop.pl
    Created on : 2017-02-05, 21:12:39
    Author     : Mariusz Skonieczny mariuszskonieczny@hotmail.com
*/
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
//echo '<pre>'. print_r($model, TRUE); die();
$form = ActiveForm::begin(['layout' => 'horizontal', 'id'=>'change-adress']);
?>
<div class="adres-form-title">Dane do wysyłki</div>
<?php 
echo $form->field($model, 'delivery_name')->input('text',['value'=>$model->delivery_name]) ;
echo $form->field($model, 'delivery_lastname')->input('text',['value'=>$model->delivery_lastname]) ;
echo $form->field($model, 'delivery_street_local')->input('text',['value'=>$model->delivery_street_local]) ;
echo $form->field($model, 'delivery_zip')->input('text',['value'=>$model->delivery_zip]) ;
echo $form->field($model, 'delivery_city')->input('text',['value'=>$model->delivery_city]) ;
?>

<div class="adres-form-title">Dane do faktury</div>

<?php
echo $form->field($model, 'is_invoice')->checkbox(['checked'=>($model->is_invoice == 1 ? 'checked' : '')]);
echo $form->field($model, 'invoice_nip')->input('text',['value'=>$model->invoice_nip]) ;
echo $form->field($model, 'invoice_firm_name')->input('text',['value'=>$model->invoice_firm_name]) ;
echo $form->field($model, 'invoice_name')->input('text',['value'=>$model->invoice_name]) ;
echo $form->field($model, 'invoice_lastname')->input('text',['value'=>$model->invoice_lastname]) ;
echo $form->field($model, 'invoice_street_local')->input('text',['value'=>$model->invoice_street_local]) ;
echo $form->field($model, 'invoice_zip')->input('text',['value'=>$model->invoice_zip]) ;
echo $form->field($model, 'invoice_city')->input('text',['value'=>$model->invoice_city]) ;
?>
<div class="form-group text-center">
    <?= Html::submitButton('Zmień dane adresowe', ['class' => 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>