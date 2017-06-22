<?php

namespace backend\controllers;

use Yii;
use app\models\ProductsAttributes;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\Attributes;

/**
 * ProductsAttributesController implements the CRUD actions for ProductsAttributes model.
 */
class ProductsAttributesController extends Controller
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
     * Lists all ProductsAttributes models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => ProductsAttributes::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ProductsAttributes model.
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
     * Creates a new ProductsAttributes model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ProductsAttributes();
        $aProductsAttributes = [0=>0];
        $oAttributes = new Attributes();
        $aAttributes = $oAttributes::find()->indexBy('id')->orderBy('sort_order')->all();
        $model->products_id = $_GET['id'];
        $oProductsAttributes = $model->find()->where(['products_id' => $model->products_id])->all();

        foreach ($oProductsAttributes as $_oProductsAttributes)
        {
            $aProductsAttributes[$_oProductsAttributes->attributes_id] =  $_oProductsAttributes->value;
        }

        if (Yii::$app->request->post())
        {
            //echo '<pre>' . print_r($_POST, TRUE) . '</pre>'; die();

            $aDataAttributes = $_POST;
            
            foreach ($aDataAttributes as $iDataAttrKey => $iDataAttrValue)
            {
                
                if ($iDataAttrKey != '_csrf-backend')
                {
                    $oPrdAttr = $model->findOne(['attributes_id'=>$iDataAttrKey, 'products_id'=>$model->products_id]);
                    if (!$oPrdAttr)
                    {
                        if ($iDataAttrValue != '')
                        {
                            $model = new ProductsAttributes();
                            $model->products_id = $_GET['id'];
                            $model->attributes_id = $iDataAttrKey;
                            $model->value = $iDataAttrValue;
                            $model->save(false);
                        }
                        
                    }
                    else 
                    {
                        if ($iDataAttrValue != '')
                        {
                            $oPrdAttr->attributes_id = $iDataAttrKey;
                            $oPrdAttr->value = $iDataAttrValue;
                            $oPrdAttr->save(false);
                        }
                        if($iDataAttrValue == '')
                        {
                            $oPrdAttr->delete();
                        }
                    }                 
                }
                
            }
            return $this->redirect(Yii::$app->request->referrer);
        }
        elseif (Yii::$app->request->isAjax)
        {
            return $this->renderAjax('create', [
                'model' => $model,
                'aAttributes' => $aAttributes,
                'aProductsAttributes' => $aProductsAttributes,
            ]);
        }
        else
        {
            return $this->render('create', [
                'model' => $model,
                'aAttributes' => $aAttributes,
                'aProductsAttributes' => $aProductsAttributes,
                ]);
        }
    }

    /**
     * Updates an existing ProductsAttributes model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
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
     * Deletes an existing ProductsAttributes model.
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
     * Finds the ProductsAttributes model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ProductsAttributes the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ProductsAttributes::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
