
<?php
/*  
    Projekt    : projekttop.pl
    Created on : 2017-05-25, 10:34:17
    Author     : Mariusz Skonieczny, mariuszskonieczny@hotmail.com
*/
?>
<?php
use yii\widgets\ActiveForm;
?>

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

    <?= $form->field($model, 'importFile')->fileInput() ?>

    <button>Importuj</button>

<?php ActiveForm::end() ?>