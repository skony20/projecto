<?php

namespace backend\controllers;

use Yii;
use app\models\Products;
use app\models\ProductsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\ProductsDescripton;
use yii\base\Model;
use yii\web\UploadedFile;
use app\models\UploadForm;
use yii\db;


/**
 * ProductsController implements the CRUD actions for Products model.
 */
class ProductsController extends Controller
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
                        'actions' => ['index', 'view', 'create', 'update', 'delete', 'active', 'unactive'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Products models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize=35;
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,

        ]);
    }

    /**
     * Displays a single Products model.
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
     * Creates a new Products model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Products();
        $oProductsDescription = new ProductsDescripton();



        if ($model->load(Yii::$app->request->post()) && $oProductsDescription->load(Yii::$app->request->post()) &&  Model::validateMultiple([$model, $oProductsDescription]))
        {
            $oImage = UploadedFile::getInstance($model, 'image');
            $model->creation_date = time();
            if ($model->save(false) )
            {
                if (is_object($oImage))
                    {
                        $this->UploadImage($model->id, $oImage);
                    }
            };
            $oProductsDescription->products_id = $model->id;
            $oProductsDescription->languages_id = 1;
            $oProductsDescription->save(false);

            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Products model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $oProductsDescription = ProductsDescripton::findOne($model->id, 1);
        //echo '<pre> '.print_r($oProductsDescription, TRUE) .'</pre>'; die();
        if ($model->load(Yii::$app->request->post()) && $oProductsDescription->load(Yii::$app->request->post()))
        {
            $oImage = UploadedFile::getInstance($model, 'image');
            if (is_object($oImage))
            {
                $this->UploadImage($id, $oImage);
            }

            $model->modification_date = time();
            $model->save(false); // skip validation as model is already validated
            $oProductsDescription->products_id = $model->id;
            $oProductsDescription->languages_id = 1;
            $oProductsDescription->save(false);

            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
                'oPD' =>$oProductsDescription ,
            ]);
        }
    }

    /**
     * Deletes an existing Products model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return $this->redirect((Yii::$app->request->referrer));
    }

    
    
    public function actionActive($id)
    {

        $model = $this->findModel($id);
        $model->is_active = 1;
        $model->save(false);
    }
    public function actionUnactive($id)
    {

        $model = $this->findModel($id);
        $model->is_active = 0;
        $model->save(false);
    }
    /**
     * Finds the Products model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Products the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Products::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    protected function UploadImage($p_iId, $p_oImage)
    {
        $oUpload = new UploadForm();
        $iId =  $p_iId;
        $oImage = $p_oImage;
        $oUpload->id = $iId;
        $oUpload->imageFiles = $oImage;
        $oUpload->saveImages();
        //echo '<pre>U' . print_r([$iId,$oImage], TRUE); die();

    }
}
