<?php

namespace frontend\controllers;

use Yii;
use app\models\Reviews;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\swiftmailer\Mailer;

/**
 * PaymentsMethodController implements the CRUD actions for PaymentsMethod model.
 */
class ReviewsController extends MetaController
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
                        'actions' => ['add'],
                        'allow' => true,
                    ],
                ],
            ],
        ];
    }
    
    public function actionAdd($id)
    {
        $model = new Reviews();

        $aUser['name'] = (Yii::$app->user->isGuest ? '' : Yii::$app->user->identity->delivery_name);
        $aUser['email'] = (Yii::$app->user->isGuest ? '' : Yii::$app->user->identity->email);
        $model->customer_ip = ($_SERVER['REMOTE_ADDR'] ? $_SERVER['REMOTE_ADDR'] : '127.0.0.1');
        if ($model->load(Yii::$app->request->post()))
        {
            $model->creation_date = time();
            $model->is_active = 1;
            $model->languages_id = 1;
            $model->products_id = $id;
            $model->customers_id = (Yii::$app->user->isGuest ? 0 : Yii::$app->user->identity->id);
            $oProducts = new \app\models\Products();
            $oProduct = $oProducts->findOne($id);
            $oProductDesc = $oProduct->productsDescriptons;
            if ($model->validate() && $model->save())
            {
                Yii::$app->mailer->compose(
                        ['html' => 'reviews-html', 'text' => 'reviews-text'],
                        ['link' => $oProductDesc->nicename_link, 'name' => $oProductDesc->name, ]
                    )
                    ->setReplyTo(Yii::$app->params['supportEmail'])
                    ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name])
                    ->setTo(Yii::$app->params['supportEmail'])
                    ->setSubject('Nowa opinia do produktu ' .$oProductDesc->name)
                    ->send();
                return $this->redirect(Yii::$app->request->referrer);
            }
        } 
        elseif (Yii::$app->request->isAjax) 
        {
           return $this->renderAjax('_form', ['id' => $id, 'model' => $model, 'aUser'=>$aUser]);
        }
        else 
        {
          return $this->render('_form', ['id' => $id, 'model' => $model, 'aUser'=>$aUser]);
        }
    }
}
