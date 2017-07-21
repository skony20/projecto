<?php

namespace backend\controllers;

use Yii;
use common\models\BlogRelated;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * BlogRelatedController implements the CRUD actions for BlogRelated model.
 */
class BlogRelatedController extends Controller
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
     * Lists all BlogRelated models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => BlogRelated::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single BlogRelated model.
     * @param integer $blog_post_id
     * @param integer $blog_related_post_id
     * @return mixed
     */
    public function actionView($blog_post_id, $blog_related_post_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($blog_post_id, $blog_related_post_id),
        ]);
    }

    /**
     * Creates a new BlogRelated model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new BlogRelated();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'blog_post_id' => $model->blog_post_id, 'blog_related_post_id' => $model->blog_related_post_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing BlogRelated model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $blog_post_id
     * @param integer $blog_related_post_id
     * @return mixed
     */
    public function actionUpdate($blog_post_id, $blog_related_post_id)
    {
        $model = $this->findModel($blog_post_id, $blog_related_post_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'blog_post_id' => $model->blog_post_id, 'blog_related_post_id' => $model->blog_related_post_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing BlogRelated model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $blog_post_id
     * @param integer $blog_related_post_id
     * @return mixed
     */
    public function actionDelete($blog_post_id, $blog_related_post_id)
    {
        $this->findModel($blog_post_id, $blog_related_post_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the BlogRelated model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $blog_post_id
     * @param integer $blog_related_post_id
     * @return BlogRelated the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($blog_post_id, $blog_related_post_id)
    {
        if (($model = BlogRelated::findOne(['blog_post_id' => $blog_post_id, 'blog_related_post_id' => $blog_related_post_id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
