<?php

namespace backend\controllers;

use Yii;
use app\models\FiltersToProducts;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;


class FiltersToProductsController extends Controller
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
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all FiltersGroup models.
     * @return mixed
     */
    public function actionIndex()
    {
        $Model = new FiltersToProducts();
        $aFltToPrd = $Model->get();
        return $this->render('index', ['aData' => $aFltToPrd]);

    }
}