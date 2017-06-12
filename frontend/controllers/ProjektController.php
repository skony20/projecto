<?php

namespace frontend\controllers;

use app\models\Products;
use app\models\ProductsDescripton;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\Attributes;
use app\models\Filters;
use Yii;



/**
 * ProductsController implements the CRUD actions for Products model.
 */
class ProjektController extends MetaController
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

  
    public function actionView($symbol)
    {
        $this->layout = 'prj_view';
        $aId = ProductsDescripton::findOne(['nicename_link'=>$symbol]); 
        $id = $aId->products_id;
        $aPrdAttributes = $this->findModel($id)->productsAttributes;
        $oAttributes = new Attributes();
        foreach ($aPrdAttributes as $aPrdAttribute)
        {
            $aPrdAttrs[$aPrdAttribute->attributes_id]['value'] = $aPrdAttribute->value;
            $aPrdAttrs[$aPrdAttribute->attributes_id]['name'] = $oAttributes->findOne($aPrdAttribute->attributes_id)->name;
            $aPrdAttrs[$aPrdAttribute->attributes_id]['sort'] = $oAttributes->findOne($aPrdAttribute->attributes_id)->sort_order;
            $aPrdAttrs[$aPrdAttribute->attributes_id]['measure'] = $oAttributes->findOne($aPrdAttribute->attributes_id)->measure;
            
        }
        $aUnsortPrdAttrs = $aPrdAttrs;                
        function build_sorter($key) {
            return function ($a, $b) use ($key) {
                return strnatcmp($a[$key], $b[$key]);
            };
        }
        usort($aPrdAttrs, build_sorter('sort'));
        
        $oFilters = new Filters();
        $aPrdsFilters  = $this->findModel($id)->productsFilters;
        $aPrdFilters = [];
        
        foreach ($aPrdsFilters as $aFilter)
        {
            $aPrdFilters[$aFilter->filters_id]['value'] = $oFilters->findOne($aFilter->filters_id)->description;
            $aPrdFilters[$aFilter->filters_id]['sort'] = $oFilters->findOne($aFilter->filters_id)->sort_order;
        }
        usort($aPrdFilters, build_sorter('sort'));
        
        $oSimilar = $this->findModel($id)->similar;
        $model = $this->findModel($id);
        Yii::$app->view->registerMetaTag(
        [
            'name' => 'description',
            'content' => $model->productsDescriptons->meta_description
        ], 'description'
        );
        
        return $this->render('view', [
            'model' => $model,
            'aPrdAttrs' => $aUnsortPrdAttrs,
            'aSortPrdAttrs' => $aPrdAttrs,
            'aPrdFilters' =>$aPrdFilters,
            'oSimilar' => $oSimilar,
        ]);
    }

    protected function findModel($id)
    {
        if (($model = Products::findOne($id)) !== null) {
            //echo '<pre>'. print_r($model, true); die();
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
