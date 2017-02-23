<?php
/*  
    Projekt    : projekttop.pl
    Created on : 2017-02-22, 15:23:25
    Author     : Mariusz Skonieczny, mariuszskonieczny@hotmail.com
*/
namespace frontend\controllers;

use Yii;
use app\models\OrdersPayments;
use app\models\Orders;

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
        $oOrderPayments = new OrdersPayments();
        $oOrderPayment = $oOrderPayments->find()->where(['session_id'=> Yii::$app->request->post('p24_session_id')])->one();
        if ($p24Service->trnVerify($p24Form)) { // response is available in $p24Service->result
    
            $oOrderPayment->code = Yii::$app->request->post("p24_statement");
            $oOrderPayment->error = print_r($p24Service->result['error'], TRUE);
            ($p24Service->result['error'] == 0 ? $oOrderPayment->status = 'Zakończona': $oOrderPayment->status = 'Błąd');
            $oOrderPayment->transfer_date = time();
            $oOrderPayment->save(false);
            
            $oOrders = new Orders();
            $oOrder = $oOrders->find()->where(['id'=> $oOrderPayment->orders_id])->one();
            $oOrder->orders_status_id = 2;
            $oOrder->paid_date = time();
            $oOrder->save(false);
            
            Yii::$app->end();
        }
         
        Yii::error($p24Service->getErrorMessage());
        $oOrderPayment->save(false);
        Yii::$app->end();
    }

}