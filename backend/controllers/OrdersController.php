<?php

namespace backend\controllers;

use Yii;
use app\models\Orders;
use app\models\OrdersSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\OrdersStatus;

/**
 * OrdersController implements the CRUD actions for Orders model.
 */
class OrdersController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'view', 'create', 'update', 'delete', 'statusform', 'adressform'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Orders models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OrdersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Orders model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Orders model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Orders();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Orders model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Orders model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Orders model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Orders the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionStatusform($id = '')
    {
        
        $model = $this->findModel($id);
        $iStatus = $model->orders_status_id;
        //echo '<pre>'. print_r($model, TRUE); die();
        if (Yii::$app->request->post()) 
        {
            $iOrderStatusId = $_POST['status_change'];
            $model->orders_status_id = $iOrderStatusId;
            switch ($iOrderStatusId)
            {
                case 2:
                    $model->paid_date = time();
                    break;
                case 3:
                    $model->paid_date = 0;
                    break;
                case 4:
                    $model->send_date = time();
                    break;
                
            }
            $model->save(false);
            $oStatus = new OrdersStatus();
            $aStatus = $oStatus->findOne(['id'=>$iOrderStatusId]);
            $sStatus = $aStatus->name;
            if ($aStatus->send_to_client)
            {
                Yii::$app->mailer->compose(
                        ['html' => 'status-change-html', 'text' => 'status-change-text'],
                        ['sStatus'=> $sStatus, 'sOrderCode'=>$model->order_code, 'iOrderDate'=>$model->order_date]
                    )
                    ->setReplyTo(Yii::$app->params['supportEmail'])
                    ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name])
                    ->setTo($model->customer_email)
                    ->setSubject('Zmiana statusu zamówienia:  ' .$id)
                    ->send();
            }
            
            return $this->redirect(['/orders/'.$id]);
        } 
        elseif (Yii::$app->request->isAjax) 
        {
           return $this->renderAjax('_statusform', ['iStatus'=>$iStatus, 'id' => $id]);
        }
        else 
        {
          return $this->render('_statusform', ['iStatus'=>$iStatus, 'id' => $id]);
        }
        
        
        
        
       
        
        return $this->renderAjax('_statusform', ['iStatus'=>$iStatus]);
    }
    public function actionAdressform($id = '')
    {
        
        $model = $this->findModel($id);
        
        if ($model->load(Yii::$app->request->post()) && $model->save(false)) 
        { 
            //echo '<pre>'. print_r(Yii::$app->request->post(), TRUE); die();
            return $this->redirect(['/orders/'.$id]);
        } 
        elseif (Yii::$app->request->isAjax) 
        {
           return $this->renderAjax('_adressform', ['id' => $id, 'model'=>$model]);
        }
        else 
        {
          return $this->render('_adressform', ['id' => $id, 'model'=>$model]);
        }
        
    }
    protected function findModel($id)
    {
        if (($model = Orders::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
