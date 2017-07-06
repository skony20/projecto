<?php

namespace backend\controllers;

use Yii;
use app\models\OrdersStatus;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * OrderStatusController implements the CRUD actions for OrdersStatus model.
 */
class OrdersStatusController extends Controller
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
                        'actions' => ['index', 'view', 'create', 'update', 'delete'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all OrdersStatus models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => OrdersStatus::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single OrdersStatus model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new OrdersStatus model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new OrdersStatus();
        
        if ($model->load(Yii::$app->request->post())) {
            $model->languages_id = 1;
            $model->is_default = 0;
            $model->save();
            return $this->redirect(['index']);
        }
        elseif (Yii::$app->request->isAjax) 
        {
           return $this->renderAjax('create', ['model'=>$model]);
        }
        else 
        {
          return $this->render('create', ['model'=>$model]);
        }
    }

    /**
     * Updates an existing OrdersStatus model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post())) {
            $model->languages_id = 1;
            $model->is_default = 0;
            $model->save();
            return $this->redirect(['index']);
        } 
        
        elseif (Yii::$app->request->isAjax) 
        {
           return $this->renderAjax('update', ['id' => $id, 'model'=>$model]);
        }
        else 
        {
          return $this->render('update', ['id' => $id, 'model'=>$model]);
        }
    }

    /**
     * Deletes an existing OrdersStatus model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the OrdersStatus model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return OrdersStatus the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = OrdersStatus::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
