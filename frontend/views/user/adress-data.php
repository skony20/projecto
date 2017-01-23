<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Zmień dane adresowe';
$this->params['breadcrumbs'][] = ['label' => 'Moje konto', 'url' => ['/user/account']];
$this->params['breadcrumbs'][] = $this->title;
//echo '<pre>'.print_r($aUser, TRUE); die();
?>
<div class="site-signup">
    <div class="account-title">Zmień dane adresowe</div>
    <div class="row">
    
        <div class="caption">
            <div class="registry-caption">Dane do wysyłki:</div>
            <div class="registry-caption"><div class=" invoice-caption">Dane do faktury:</div></div>
        </div>
        <?php $formData = ActiveForm::begin(['id' => 'change-data']); ?>    
        <div class="p50p">
            <div class="delivery">
                <?= $formData->field($model, 'delivery_name')->textInput(['value'=>$aUser->delivery_name]) ?>
                <?= $formData->field($model, 'delivery_lastname')->textInput(['value'=>$aUser->delivery_lastname]) ?>
                <?= $formData->field($model, 'delivery_street_local')->textInput(['value'=>$aUser->delivery_street_local]) ?>
                <?= $formData->field($model, 'delivery_zip')->textInput(['value'=>$aUser->delivery_zip]) ?>
                <?= $formData->field($model, 'delivery_city')->textInput(['value'=>$aUser->delivery_city]) ?>
                <?= $formData->field($model, 'delivery_country')->textInput(['value'=>$aUser->delivery_country]) ?>
                <?= $formData->field($model, 'phone')->textInput(['value'=>$aUser->phone]) ?>
                <br><br>
                <div class="want-invoice">
                    Dane do faktury >
                </div>
            </div>
        </div>
        <div class="p50p">
            <div class="invoice">
                <?= $formData->field($model, 'invoice_nip')->textInput(['value'=>$aUser->invoice_nip]) ?>
                <?= $formData->field($model, 'invoice_firm_name')->textInput(['value'=>$aUser->invoice_firm_name]) ?>
                <?= $formData->field($model, 'invoice_name')->textInput(['value'=>$aUser->invoice_name]) ?>
                <?= $formData->field($model, 'invoice_lastname')->textInput(['value'=>$aUser->invoice_lastname]) ?>
                <?= $formData->field($model, 'invoice_street_local')->textInput(['value'=>$aUser->invoice_street_local]) ?>
                <?= $formData->field($model, 'invoice_zip')->textInput(['value'=>$aUser->invoice_zip]) ?>
                <?= $formData->field($model, 'invoice_city')->textInput(['value'=>$aUser->invoice_city]) ?>
                <?= $formData->field($model, 'invoice_country')->textInput(['value'=>$aUser->invoice_country]) ?>
            </div>
            </div>
        <div class="form-group">
            <?= Html::submitButton('Zmień dane', ['class' => 'blue-button', 'name' => 'signup-button']) ?>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
    
</div>
