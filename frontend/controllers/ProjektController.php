<?php

namespace frontend\controllers;

use app\models\Products;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;



/**
 * ProductsController implements the CRUD actions for Products model.
 */
class ProjektController extends Controller
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
                    ],
                ],
            ],
          
        ];
    }

  
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionSlug($slug)
     { 
       $model = Products::find()->where(['symbol'=>$slug])->one();
       if (!is_null($model)) {
           return $this->render('view', [
               'model' => $model,
           ]);      
       } else {
         return $this->redirect('/projekty');
       }
     }
    protected function findModel($id)
    {
        if (($model = Products::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
