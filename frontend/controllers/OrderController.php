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
use OpenPayU_Configuration;
use OpenPayU_Order;
use OpenPayU_Result;


class OrderController extends Controller
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
        $oSession = new Session();
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
        $oSession = new Session();
        $aProducts = $oSession->get('aPrjs');
        $aDelivery = $oSession['OrderData']['Orders'];
        $aTotal = $oSession->get('aTotal');
        //echo '<pre>'. print_r($aProducts, TRUE);  die();
        if ($order <> 0)
        {
            $oOrderPaymants = new OrdersPayments();
            $oOrderPays = $oOrderPaymants->find()->where(['orders_id'=>$order])->one();
            OpenPayU_Configuration::setEnvironment('secure');
            $response = OpenPayU_Order::retrieve($oOrderPays->code);
            $sStatus = $response->getresponse()->orders[0]->status;
            $oOrderPays->status = $sStatus;
            $oOrderPays->save(false);
            
            //echo '<pre>'.print_r($response->getresponse()->orders[0]->status, TRUE);
            $oOrderActual = $oOrder->findOne($order);
            if ($sStatus == 'COMPLETED')
            {
                $oOrderActual->orders_status_id = 2;
                $oOrderActual->save();
            }
            
            return $this->render('/order/confirm-order',['iOrderId'=>$order, 'oOrderActual' =>$oOrderActual]); 
        }
        $iOrderCode = uniqid('',true);
        $oOrder->is_deleted = 0;
        $oOrder->customers_id = Yii::$app->user->identity->id;
        $oOrder->languages_id = 1;
        $oOrder->order_date = time();
        $oOrder->order_code = $iOrderCode;
        $oOrder->orders_status_id = 1;
        $oOrder->customer_ip = ($_SERVER['REMOTE_ADDR'] ? $_SERVER['REMOTE_ADDR'] : '127.0.0.1');
        $oOrder->customer_phone = ($aDelivery['customer_phone'] ? $aDelivery['customer_phone'] : '');
        $oOrder->customer_email = (Yii::$app->user->identity->email ? Yii::$app->user->identity->email : 'ff');
        $oOrder->delivery_name = ($aDelivery['delivery_name'] ? $aDelivery['delivery_name'] : '');
        $oOrder->delivery_lastname = ($aDelivery['delivery_lastname'] ? $aDelivery['delivery_lastname'] : '');
        $oOrder->delivery_street_local = ($aDelivery['delivery_street_local'] ? $aDelivery['delivery_street_local'] : '');
        $oOrder->delivery_zip = ($aDelivery['delivery_zip'] ? $aDelivery['delivery_zip'] : '');
        $oOrder->delivery_city = ($aDelivery['delivery_city'] ? $aDelivery['delivery_city'] : '');
        $oOrder->delivery_country = ($aDelivery['delivery_country'] ? $aDelivery['delivery_country'] : '');
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

            $oOrderPosition = new OrdersPosition();
            
            foreach ($aProducts as $aProduct)
            {
                //echo '<pre>'. print_r($aProduct, TRUE); die();
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
                $oOrderPosition->creation_date - time();
                $oOrderPosition->save(false);
            }
//                $oSession->remove('Cart');
//                $oSession->remove('aPrjs');
//                $oSession->remove('OrderData');
//                $oSession->remove('aTotal');
                Yii::$app
                ->mailer
                ->compose(
                    ['html' => 'order-html', 'text' => 'order-text'],
                    ['aDelivery' => $aDelivery, 'aProducts' => $aProducts]
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
                        ['aDelivery' => $aDelivery, 'aProducts' => $aProducts]
                    )
                    ->setReplyTo(Yii::$app->params['supportEmail'])
                    ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name])
                    ->setTo(Yii::$app->params['supportEmail'])
                    ->setSubject('Nowe zamówienie')
                    ->send();
                if ($aDelivery['shippings_payments_id'] == 2)
                {
                
                    /*PayU*/
                    
                    $aOrder =[];
                    
                    $aOrder['notifyUrl'] = 'http://localhost/projecto/order/notify/';
                    $aOrder['continueUrl'] = 'http://localhost/projecto/order/confirm-order/?order='.$iOrderId;
                    $aOrder['customerIp'] = '127.0.0.1';
                    $aOrder['merchantPosId'] = OpenPayU_Configuration::getMerchantPosId();
                    $aOrder['description'] = 'Projekttop.pl';
                    $aOrder['currencyCode'] = 'PLN';
                    $aOrder['totalAmount'] = 200;//$aTotal['iTotal']*100;
                    $aOrder['extOrderId'] = $iOrderCode; //must be unique!
                    $a = 0;
                    foreach ($aProducts as $aProduct)
                    {
                        //echo '<pre>PAYU: ' .print_r($aProduct['prj']->productsDescriptons->name, TRUE); die();
                        $aOrder['products'][$a]['name'] = $aProduct['prj']->productsDescriptons->name;
                        $aOrder['products'][$a]['unitPrice'] = $aProduct['prj']->price_brutto*100;
                        $aOrder['products'][$a]['quantity'] = $aProduct['iQty'];
                        $a++;
                    }

                //optional section buyer
                    $aOrder['buyer']['email'] = Yii::$app->user->identity->email;
                    $aOrder['buyer']['phone'] = $aDelivery['customer_phone'];
                    $aOrder['buyer']['firstName'] = $aDelivery['delivery_name'] ;
                    $aOrder['buyer']['lastName'] = $aDelivery['delivery_lastname'] ;
                    //echo '<pre>PAYU: ' .print_r($aOrder['products'], TRUE); die();
                    OpenPayU_Configuration::setEnvironment('secure');
                    $response = OpenPayU_Order::create($aOrder);
                    $aStatus = $response->getResponse()->status;
                    //echo '<pre>PAYU: ' .print_r($response->getResponse()->orderId, TRUE); die();
                    if (isset($response->getResponse()->status) && $aStatus->statusCode =='SUCCESS')
                    {
                        //echo '<pre>PAYU3: ' .print_r($response->getResponse(), TRUE); die();
                        $oOrderPayments = new OrdersPayments();
                        $oOrderPayments->orders_id = $iOrderId;
                        $oOrderPayments->code = $response->getResponse()->orderId;
                        $oOrderPayments->source = 'payu';
                        $oOrderPayments->status ='Rozpoczęta';
                        $oOrderPayments->value = $aTotal['iTotal'];
                        $oOrderPayments->description = 'Zamówinie nr: '. $iOrderId;
                        $oOrderPayments->creation_time = time();
                        $oOrderPayments->save(false);
                        //echo '<pre>PAYU3: ' .print_r($response->getResponse(), TRUE); die();
                        return $this->redirect($response->getResponse()->redirectUri);
                    }
                    
                    
                    
                }

                $oOrderActual = $oOrder->findOne($iOrderId);
        }
        
        

        //echo '<pre>'. print_r($aProducts, TRUE); die();
        
        return $this->render('/order/confirm-order',['iOrderId'=>$iOrderId, 'oOrderActual' =>$oOrderActual]); 
    }
    public function actionNotify()
    {
//        OpenPayU_Configuration::setEnvironment('secure');
//        $body = file_get_contents ( 'php://input' );
//        $data =  trim ( $body );
//        echo '<pre>dd'. print_r($data , TRUE); die();
//            try {
//                if (!empty($data)) {
//                    $result = OpenPayU_Order::consumeNotification($data);
//                   
//                }
//
//                if ($result->getResponse()->order->orderId) {
//
//                    /* Check if OrderId exists in Merchant Service, update Order data by OrderRetrieveRequest */
//                    $order = OpenPayU_Order::retrieve($result->getResponse()->order->orderId);
//                    if($order->getStatus() == 'SUCCESS'){
//                        //the response should be status 200
//                        //header("HTTP/1.1 200 OK");
//                    }
//                }
//            } catch (OpenPayU_Exception $e) {
//                echo $e->getMessage();
//            }
//
//        
    }
            
     
    
}
