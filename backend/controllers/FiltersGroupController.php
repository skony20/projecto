<?php

namespace backend\controllers;

use Yii;
use app\models\FiltersGroup;
use app\models\FiltersGroupSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * FiltersGroupController implements the CRUD actions for FiltersGroup model.
 */
class FiltersGroupController extends Controller
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
     * Lists all FiltersGroup models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new FiltersGroupSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single FiltersGroup model.
     * @param string $name
     * @param integer $language_id
     * @return mixed
     */
    public function actionView($name, $language_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($name, $language_id),
        ]);
    }

    /**
     * Creates a new FiltersGroup model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new FiltersGroup();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing FiltersGroup model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $name
     * @param integer $language_id
     * @return mixed
     */
    public function actionUpdate($name, $language_id)
    {
        $model = $this->findModel($name, $language_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing FiltersGroup model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $name
     * @param integer $language_id
     * @return mixed
     */
    public function actionDelete($name, $language_id)
    {
        $this->findModel($name, $language_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the FiltersGroup model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $name
     * @param integer $language_id
     * @return FiltersGroup the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($name, $language_id)
    {
        if (($model = FiltersGroup::findOne(['name' => $name, 'language_id' => $language_id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
