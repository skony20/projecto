<?php

namespace backend\controllers;

use Yii;
use app\models\ProductsFilters;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\Filters;
use app\models\FiltersGroup;
use app\models\Products;

/**
 * ProductsFiltersController implements the CRUD actions for ProductsFilters model.
 */
class ProductsFiltersController extends Controller
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
     * Lists all ProductsFilters models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => ProductsFilters::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ProductsFilters model.
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
     * Creates a new ProductsFilters model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $aProductsFilters =[0];
        $model = new ProductsFilters();
        $oFiltersGroup = new FiltersGroup();
        $oFilters = new Filters();
        $aFiltersGroup = $oFiltersGroup::find()->where(['is_active'=> 1])->orderBy('sort_order')->all();
        foreach ($aFiltersGroup as $_aFiltersGroup)
        {
            $aFilters = $oFilters::find()->where(['filters_group_id' => $_aFiltersGroup->id, 'is_active'=> 1])->all();
            $aData[$_aFiltersGroup->id] = ['question'=>$_aFiltersGroup, 'answer' => $aFilters];
        }
        $oProductsFilters = $model->find()->where(['products_id' => $_GET['id']])->all();
        foreach ($oProductsFilters as $_oProductsFilters)
        {
            $aProductsFilters[].=$_oProductsFilters->filters_id;
        }
        //echo '<pre>55' . print_r($aProductsFilters, TRUE). '</pre>'; die();
        if (Yii::$app->request->post()) 
            {
                $model->products_id = $_GET['id'];
                $model->deleteAll(['products_id' => $_GET['id']]);
                
                
                $sMax = count($_POST);
                for ($a=0; $a <= $sMax-2; $a++)
                {       
                    $model->filters_id = $_POST[$a];
                    $model->id = NULL; //primary key(auto increment id) id
                    $model->isNewRecord = true;
                    $model->save(false);
                }
                
            return $this->redirect(['./products']);
            } 
        else 
        {
            return $this->render('create', [
                'model' => $model,
                'aData' => $aData,
                'aProductsFilters'=> $aProductsFilters,
                ]);
        }
    }

    /**
     * Updates an existing ProductsFilters model.
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
     * Deletes an existing ProductsFilters model.
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
     * Finds the ProductsFilters model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ProductsFilters the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ProductsFilters::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
