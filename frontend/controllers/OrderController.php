<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\Products;
use common\models\User;
use app\models\Orders;
use yii\web\Session;
use app\models\PaymentsMethod;
use app\models\OrdersPosition;
use app\models\OrdersPayments;
use przelewy;
use yii\helpers\Url;




class OrderController extends MetaController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['step1', 'step2', 'confirm-order', 'notify'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
                
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'confirm-order' => ['post', 'get'],
                    'notify' => ['post', 'get'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }
    public function actionStep1()
    {   
        $oUser = new User(); 
        $oOrder = new Orders();
        $aUser = $oUser->findIdentity(Yii::$app->user->identity->id);
        return $this->render('/order/step1',['aUser'=>$aUser, 'aOrder'=>$oOrder]); 
    }

    public function actionStep2()
    {   
        //$aData = [];
        $oSession = Yii::$app->session;
        $aProducts = $oSession->get('aPrjs');
        $aTotal = $oSession->get('aTotal');
        $aOrderData = $oSession['OrderData'] = Yii::$app->request->post();
        $oPayment = new PaymentsMethod();
        $aPayment = $oPayment->findOne($aOrderData['Orders']['shippings_payments_id']);
        
        return $this->render('/order/step2', ['aProducts' => $aProducts, 'aOrderData' =>$aOrderData, 'aPayment'=>$aPayment, 'aTotal'=>$aTotal]);
        
    }
    public function actionConfirmOrder($order=0)
    {
        $oOrder = new Orders();
        $oSession = Yii::$app->session;
        $aProducts = $oSession->get('aPrjs');
        $aDelivery = $oSession['OrderData']['Orders'];
        $bIsInvoice = $oSession['OrderData']['is_invoice'];
        
        $aTotal = $oSession->get('aTotal');
        //echo '<pre>'. print_r($aProducts, TRUE);  die();
        if ($order <> 0)
        {   
            $oOrderActual = $oOrder->findOne($order);
            
            return $this->render('/order/confirm-order',['iOrderId'=>$order, 'oOrderActual' =>$oOrderActual]); 
        }

        $iOrderCode = 1; //bin2hex (random_bytes(5));
        $oOrder->is_deleted = 0;
        $oOrder->customers_id = Yii::$app->user->identity->id;
        $oOrder->languages_id = 1;
        $oOrder->order_date = time();
        $oOrder->order_code = $iOrderCode;
        $oOrder->orders_status_id = 1;
        $oOrder->customer_ip = ($_SERVER['REMOTE_ADDR'] ? $_SERVER['REMOTE_ADDR'] : '127.0.0.1');
        $oOrder->customer_phone = ($aDelivery['customer_phone'] ? $aDelivery['customer_phone'] : '');
        $oOrder->customer_email = (Yii::$app->user->identity->email ? Yii::$app->user->identity->email : '');
        $oOrder->delivery_name = ($aDelivery['delivery_name'] ? $aDelivery['delivery_name'] : '');
        $oOrder->delivery_lastname = ($aDelivery['delivery_lastname'] ? $aDelivery['delivery_lastname'] : '');
        $oOrder->delivery_street_local = ($aDelivery['delivery_street_local'] ? $aDelivery['delivery_street_local'] : '');
        $oOrder->delivery_zip = ($aDelivery['delivery_zip'] ? $aDelivery['delivery_zip'] : '');
        $oOrder->delivery_city = ($aDelivery['delivery_city'] ? $aDelivery['delivery_city'] : '');
        $oOrder->delivery_country = ($aDelivery['delivery_country'] ? $aDelivery['delivery_country'] : '');
        $oOrder->is_invoice = ($bIsInvoice ? $bIsInvoice : 0);
        $oOrder->invoice_name = ($aDelivery['invoice_name'] ? $aDelivery['invoice_name'] : '');
        $oOrder->invoice_lastname = ($aDelivery['invoice_lastname'] ? $aDelivery['invoice_lastname'] : '');
        $oOrder->invoice_firm_name = ($aDelivery['invoice_firm_name'] ? $aDelivery['invoice_firm_name'] : '');
        $oOrder->invoice_street_local = ($aDelivery['invoice_street_local'] ? $aDelivery['invoice_street_local'] : '');
        $oOrder->invoice_zip = ($aDelivery['invoice_zip'] ? $aDelivery['invoice_zip'] : '');
        $oOrder->invoice_city = ($aDelivery['invoice_city'] ? $aDelivery['invoice_city'] : '');
        $oOrder->invoice_country = ($aDelivery['invoice_country'] ? $aDelivery['invoice_country'] : '');
        $oOrder->invoice_nip = ($aDelivery['invoice_nip'] ? $aDelivery['invoice_nip'] : '');
        $oOrder->comments = ($aDelivery['comments'] ? $aDelivery['comments'] : '');
        $oOrder->shippings_payments_id  = ($aDelivery['shippings_payments_id'] ? $aDelivery['shippings_payments_id'] : '');
        $oOrder->value_brutto = ($aTotal['iTotal'] ? $aTotal['iTotal'] : '');
        $oOrder->creation_date = time();
        $oOrder->is_giodo = ($aDelivery['is_giodo'] ? $aDelivery['is_giodo'] : '');
        
        
        
        if ($oOrder->save())
        {
            $iOrderId = $oOrder->id;

            foreach ($aProducts as $aProduct)
            {
                $oOrderPosition = new OrdersPosition();
                $oOrderPosition->is_deleted = 0;
                $oOrderPosition->orders_id = $iOrderId;
                $oOrderPosition->products_id = $aProduct['prj']->id;
                $oOrderPosition->producers_id = $aProduct['prj']->producers_id;
                $oOrderPosition->name = $aProduct['prj']->productsDescriptons->name;
                $oOrderPosition->name_model = $aProduct['prj']->productsDescriptons->name_model;
                $oOrderPosition->name_subname = $aProduct['prj']->productsDescriptons->name_subname;
                $oOrderPosition->symbol = $aProduct['prj']->symbol;
                $oOrderPosition->vat_id = $aProduct['prj']->vats_id;
                $oOrderPosition->price_brutto_source = $aProduct['prj']->price_brutto_source;
                $oOrderPosition->price_brutto = $aProduct['prj']->price_brutto;
                $oOrderPosition->quantity = $aProduct['iQty'];
                $oOrderPosition->value_brutto = $aProduct['prj']->price_brutto * $aProduct['iQty'];
                $oOrderPosition->creation_date = time();
                $oOrderPosition->save(false);
                
                $oProducts = new Products();
                $aProductExist = $oProducts->findOne($aProduct['prj']->id);
                $aProductExist->sell_items += 1 ;
                $aProductExist->save(false);
            }
//                $oSession->remove('Cart');
//                $oSession->remove('aPrjs');
//                $oSession->remove('OrderData');
//                $oSession->remove('aTotal');
                Yii::$app
                ->mailer
                ->compose(
                    ['html' => 'order-html', 'text' => 'order-text'],
                    ['aDelivery' => $aDelivery, 'aProducts' => $aProducts, 'iOrderId'=>$iOrderId, 'aTotal'=>$aTotal, 'bIsInvoice'=>$bIsInvoice]
                )
                ->setReplyTo(Yii::$app->params['supportEmail'])
                ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name])
                ->setTo(Yii::$app->user->identity->email)
                ->setSubject('Twoje zamówienie z:  ' . Yii::$app->name)
                ->send();
                Yii::$app
                    ->mailer
                    ->compose(
                        ['html' => 'order-html', 'text' => 'order-text'],
                        ['aDelivery' => $aDelivery, 'aProducts' => $aProducts, 'iOrderId'=>$iOrderId, 'aTotal'=>$aTotal, 'bIsInvoice'=>$bIsInvoice]
                    )
                    ->setReplyTo(Yii::$app->params['supportEmail'])
                    ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name])
                    ->setTo(Yii::$app->params['supportEmail'])
                    ->setSubject('Nowe zamówienie')
                    ->send();
                if ($aDelivery['shippings_payments_id'] == 3)
                {
                   $p24Service = \Yii::$app->P24Service;
                   $iSessionId = uniqid();
                    $p24Form = $p24Service->getModelForm();
                    $p24Form->setAttributes([
                        'p24_amount' => $aTotal['iTotal']*100,
                        'p24_description' => 'Zaplata za zamowienie '.$iOrderId,
                        'p24_session_id' => $iSessionId,
                        'p24_email' => Yii::$app->user->identity->email,
                        'p24_url_status' => Url::to(['payment/update-status'], true),
                        'p24_url_return' => Url::to(['order/confirm-order/?order='.$iOrderId], true)
                        // if you need you can put other input
                    ]);
                    $oOrderPayment = new OrdersPayments();
                    $oOrderPayment->orders_id = $iOrderId;
                    $oOrderPayment->source = 'przelewy';
                    $oOrderPayment->code = $iSessionId;
                    $oOrderPayment->status = 'Rozpoczęta';
                    $oOrderPayment->value = $aTotal['iTotal'];
                    $oOrderPayment->description = 'Zaplata za zamowienie '.$iOrderId;
                    $oOrderPayment->creation_time = time();
                    $oOrderPayment->save();
                    if ($p24Form->validate() && $p24Service->testConnection()) {
                        
                        $p24Form->createSigin(); // create and add to p24_sign input
                    }
                }

                $oOrderActual = $oOrder->findOne($iOrderId);
        }
        
        return $this->render('/order/confirm-order',['iOrderId'=>$iOrderId, 'oOrderActual' =>$oOrderActual, 'p24Form' => $p24Form]); 
    }

            
     
    
}
