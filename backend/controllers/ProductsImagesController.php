<?php

namespace backend\controllers;

use Yii;
use app\models\ProductsImages;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\UploadForm;

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
                    'delete' => ['POST', 'GET'],
                    'deleteimages' => ['POST', 'GET'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['delete', 'deleteimages', 'index', 'resizeall'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Deletes an existing ProductsImages model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
     public function actionIndex()
    {
        return $this->render('index');
    }
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect((Yii::$app->request->referrer));
    }
    public function actionDeleteimages($iModelId, $sName, $iImageId)
    {
        $this->actionDelete($iImageId);
        $filename = $sPatch.'/'.$iModelId.'/big/'.$sName;
        unlink($filename);
        return TRUE;
        
        
    }
    
    protected function findModel($id)
    {
        if (($model = ProductsImages::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    public function actionResizeall()
    {
        $model = new UploadForm();
        $model->resizeAll();
    }

}
