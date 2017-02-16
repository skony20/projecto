<?php

namespace frontend\controllers;

use Yii;
use app\models\FaqGroup;
use yii\web\Controller;
use yii\web\NotFoundHttpException;


/**
 * FaqController implements the CRUD actions for Faq model.
 */
class FaqController extends MetaController
{
   
    public function actionIndex()
    {
        $model = FaqGroup::find()->where(['is_active'=>1])->orderBy(['sort_order'=>SORT_ASC])->all();
        return $this->render('index', ['model'=>$model]);
    }
    protected function findModel($id)
    {
        if (($model = FaqGruop::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
