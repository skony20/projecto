<?php

namespace backend\controllers;

use Yii;
use app\models\ProductsImages;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\Upload;
use yii\web\UploadedFile;

/**
 * ProductsImagesController implements the CRUD actions for ProductsImages model.
 */
class ProductsImagesController extends Controller
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
                    'deleteimages' => ['GET', 'POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'view', 'create', 'update', 'delete', 'deleteimages', 'add'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all ProductsImages models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => ProductsImages::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ProductsImages model.
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
     * Creates a new ProductsImages model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ProductsImages();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ProductsImages model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(Yii::$app->request->referrer);
        } else {
            if (Yii::$app->request->isAjax)
                {
                    return $this->renderAjax('update', [
                        'model' => $model,

                    ]);
                }
                else
                {
                    return $this->render('update', [
                        'model' => $model,
                        ]);
                }
        }
    }

    /**
     * Deletes an existing ProductsImages model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
    }

    /**
     * Finds the ProductsImages model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ProductsImages the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ProductsImages::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    public function actionDeleteimages($iModelId, $sName, $iImageId)
    {
        $this->actionDelete($iImageId);
        $sPatch = Yii::getAlias('@images');
        $filename = $sPatch.'/'.$iModelId.'/big/'.$sName;
        $filename2 = $sPatch.'/'.$iModelId.'/info/'.$sName;
        $filename3 = $sPatch.'/'.$iModelId.'/thumbs/'.$sName;
        unlink($filename);
        unlink($filename2);
        unlink($filename3);
        
    }
    public function actionAdd($id)
    {
        $model = new \app\models\UploadImage();
        if (Yii::$app->request->isPost) 
        {
            $aImageInfo = Yii::$app->request->post('UploadImage');
            $oFile = UploadedFile::getInstance($model, 'importFile');
            $model->upload($id, $aImageInfo['description'], $aImageInfo['image_type_id'], $oFile, $aImageInfo['storey_type']);
            return $this->redirect(Yii::$app->request->referrer);
        }
        else 
        {
            if (Yii::$app->request->isAjax)
            {
                return $this->renderAjax('add',['model'=>$model]);
            }
            else
            {
                return $this->render('add',['model'=>$model]);
            }
        }
    }
      
}
