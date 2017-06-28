<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Producers */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="producers-form">
<?php

        (isset($model->is_active_prd) ? '':  $model->is_active_prd = 1);
    ?>
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'is_active_prd')->checkbox() ?>
    <?= $form->field($model, 'sort_order')->textInput() ?>
    <?= $form->field($model, 'logo')->textInput(['maxlength' => true]) ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Dodaj') : Yii::t('app', 'Zmień'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
