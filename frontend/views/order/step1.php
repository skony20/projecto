<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\PaymentsMethod;

$this->title = 'Zamówienie krok 1 z 2';
$this->params['breadcrumbs'][] = ['label' => 'Koszyk', 'url' => ['/cart']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-step1">
    <?php $formData = ActiveForm::begin(['action'=>'/projecto/order/step2/', 'id' => 'order']); ?>    
    <div class="row-order">
        <div class="caption">Płatność:</div>
       <?= $formData->field($aOrder, 'shippings_payments_id')->radioList(ArrayHelper::map(PaymentsMethod::find()->all(), 'id', 'name'))->label(false) ?>
    </div>
    
    <div class="row-order">
        <div class="caption">Wysyłka:</div>
        <div  class="order-shipping">
            Wysyłka realizowana jest na koszt projekttop.pl
            <br> Odbywa się za za posrednictwem kuriera poczty polskiej.
            <br> Gotowy projekt u klienta docieraz zazwyczaj do 72 godzin od zaksięgowania wpłaty
        </div>
    </div>
    <div class="row-order">
        <div class="caption">
            <div class="order-caption">Dane do wysyłki:</div>
            <div class="order-caption"><div class="invoice-caption">Dane do faktury:</div></div>
        </div>
    </div>    
    <div class="row-order">
        <div class="p50p">
            <div class="delivery">
                <?= $formData->field($aOrder, 'delivery_name')->textInput(['value'=>$aUser->delivery_name]) ?>
                <?= $formData->field($aOrder, 'delivery_lastname')->textInput(['value'=>$aUser->delivery_lastname]) ?>
                <?= $formData->field($aOrder, 'delivery_street_local')->textInput(['value'=>$aUser->delivery_street_local]) ?>
                <?= $formData->field($aOrder, 'delivery_zip')->textInput(['value'=>$aUser->delivery_zip]) ?>
                <?= $formData->field($aOrder, 'delivery_city')->textInput(['value'=>$aUser->delivery_city]) ?>
                <?= $formData->field($aOrder, 'delivery_country')->textInput(['value'=>$aUser->delivery_country]) ?>
                <?= $formData->field($aOrder, 'customer_phone')->textInput(['value'=>$aUser->phone]) ?>
                <br><br>
                <div class="want-invoice-order">
                    <?= Html::checkbox('is_invoice', false) ?>
                    Chcę otrzymać fakturę VAT >
                </div>
            </div>
        </div>
        <div class="p50p">
            <div class="invoice">
                <?= $formData->field($aOrder, 'invoice_nip')->textInput(['value'=>$aUser->invoice_nip]) ?>
                <?= $formData->field($aOrder, 'invoice_firm_name')->textInput(['value'=>$aUser->invoice_firm_name]) ?>
                <?= $formData->field($aOrder, 'invoice_name')->textInput(['value'=>$aUser->invoice_name]) ?>
                <?= $formData->field($aOrder, 'invoice_lastname')->textInput(['value'=>$aUser->invoice_lastname]) ?>
                <?= $formData->field($aOrder, 'invoice_street_local')->textInput(['value'=>$aUser->invoice_street_local]) ?>
                <?= $formData->field($aOrder, 'invoice_zip')->textInput(['value'=>$aUser->invoice_zip]) ?>
                <?= $formData->field($aOrder, 'invoice_city')->textInput(['value'=>$aUser->invoice_city]) ?>
                <?= $formData->field($aOrder, 'invoice_country')->textInput(['value'=>$aUser->invoice_country]) ?>
            </div>
        </div>
        <div class="row-order">
            <div class="caption">Uwagi do zamówienia</div>
            <div class="order-comment">
                <?= $formData->field($aOrder, 'comments')->textarea(['placeholder' =>'Umieśc tu dodatkowe uwagi do zamówienia'])->label(false)?>
            </div>
            
        </div>
        <div class="row-order">
            <div class="giodo-order">
                <?= $formData->field($aOrder, 'is_giodo')->checkbox()->label(false) ?>
                    

            </div>
        </div>
        <div class="form-group">
            <?= Html::submitButton('Dalej', ['class' => '', 'name' => 'signup-button']) ?>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>