<?php
use yii\web\Session;

$this->title = Yii::t('app', 'Koszyk');
$this->params['breadcrumbs'][] = $this->title;


foreach ($aPrjs as $aPrj)
{
    echo $aPrj['desc']->name .'x '. $aPrj['iQty'] . ' ';
    echo $aPrj['prj']->symbol .'<br>';
}
