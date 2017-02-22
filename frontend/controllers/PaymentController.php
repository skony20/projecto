<?php
/*  
    Projekt    : projekttop.pl
    Created on : 2017-02-22, 15:23:25
    Author     : Mariusz Skonieczny, mariuszskonieczny@hotmail.com
*/
namespace frontend\controllers;

use Yii;
use app\models\OrdersPayments;

class PaymentController extends \yii\web\Controller {

    public $enableCsrfValidation = false;

    function actionUpdateStatus() {

        $p24Service = Yii::$app->P24Service;

        $p24Form = $p24Service->getModelForm();

        $p24Form->setAttributes(Yii::$app->request->post());
        if (!$p24Form->validate()) {

            Yii::error('Błędne parametry płatności ' . serialize($p24Form->getErrors()));
            Yii::$app->end();
        }

        // verify payment

        if ($p24Service->trnVerify($p24Form)) { // response is available in $p24Service->result
            echo '<pre>'. print_r($p24Service->trnVerify($p24Form), TRUE); die();
            $oOrderPayment = new OrdersPayments();
            $oOrderPayment->status = 'Żadne';
            $oOrderPayment->save(false);
            Yii::$app->end();
        }
        //update your payment with error message $p24Service->getErrorMessage();
        Yii::error($p24Service->getErrorMessage());
        Yii::$app->end();
    }

}