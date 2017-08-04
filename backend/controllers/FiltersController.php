<?php

namespace backend\controllers;

use Yii;
use app\models\Filters;
use app\models\FiltersSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * FiltersController implements the CRUD actions for Filters model.
 */
class FiltersController extends Controller
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
                        'actions' => ['index', 'view', 'create', 'update', 'delete', 'check', 'checksize'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Filters models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new FiltersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Filters model.
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
     * Creates a new Filters model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Filters();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Filters model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Filters model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
    public function actionCheck()
    {
        $aFilters =[];
        /*Sprawdzanie czy każdy projekt ma odpowiedź na wszystkie pytania*/
        $oFiltersGroup = Filters::findAll(['is_active'=>1]);
        $a =1;
        echo '<table><tr><td>Produkt</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>';
        foreach ($oFiltersGroup as $oFiltersGroup)
        {
            $aFilters[$oFiltersGroup->filters_group_id][] = $oFiltersGroup->id;
            
        }
        
        $oProducts = \app\models\Products::find()->andWhere(['is_active'=>1])->all();
        foreach ($oProducts as $oProducts)
        {
            
            echo '<tr><td>'.$oProducts->id.'</td>';
                
            echo '<td>'.$oProducts->producers->name.'</td>';
            echo '<td>'.$a.'</td>';
            echo '</tr>';
            $a++;
        }
        echo'</table>';
    }
    public function actionChecksize()
    {
        
        /*Sprawdzanie czy każdy projekt ma rozmiary dzialki i rozmiary swoje*/
        
        echo '<table><tr><td>Produkt</td><td>Wielkość</td><td>Szerokośc działki</td><td>Głębokośc działki</td><td></tr>';
        
        $oProducts = \app\models\Products::find()->andWhere(['is_active'=>1])->andWhere(['>=','id','5000'])->andWhere(['<','id','6000'])->all();
        foreach ($oProducts as $oProducts)
        {
            $oSizeX = \app\models\ProductsAttributes::findOne(['products_id'=>$oProducts->id, 'attributes_id'=>'4']);
            $oAreaX = \app\models\ProductsAttributes::findOne(['products_id'=>$oProducts->id, 'attributes_id'=>'6']);
            $oAreaY = \app\models\ProductsAttributes::findOne(['products_id'=>$oProducts->id, 'attributes_id'=>'7']);
            echo '<tr><td>'.$oProducts->id.'</td>';
            echo '<td>'.$oSizeX['value'].'</td>';
            echo '<td>'.$oAreaX['value'].'</td>';
            echo '<td>'.$oAreaY['value'].'</td>';
            echo '</tr>';
        }
        echo'</table>';
    }
    /**
     * Finds the Filters model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Filters the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Filters::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
