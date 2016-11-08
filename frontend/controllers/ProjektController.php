<?php

namespace frontend\controllers;

use app\models\Products;
use app\models\ProductsDescripton;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\Attributes;



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

  
    public function actionView($symbol)
    {
        $aId = ProductsDescripton::findOne(['nicename_link'=>$symbol]); 
        $id = $aId->products_id;
        //echo '<pre>'. print_r($symbol, TRUE); die();
        $aPrdAttributes = $this->findModel($id)->productsAttributes;
        $oAttributes = new Attributes();
        //echo '<pre>22'.print_r($aPrdAttributes, TRUE);
        foreach ($aPrdAttributes as $aPrdAttribute)
        {
            $aPrdAttrs[$aPrdAttribute->attributes_id]['value'] = $aPrdAttribute->value;
            $aPrdAttrs[$aPrdAttribute->attributes_id]['name'] = $oAttributes->findOne($aPrdAttribute->attributes_id)->name;
            $aPrdAttrs[$aPrdAttribute->attributes_id]['sort'] = $oAttributes->findOne($aPrdAttribute->attributes_id)->sort_order;
            
        }
        $aUnsortPrdAttrs = $aPrdAttrs;
        function build_sorter($key) {
            return function ($a, $b) use ($key) {
                return strnatcmp($a[$key], $b[$key]);
            };
        }
        usort($aPrdAttrs, build_sorter('sort'));

        return $this->render('view', [
            'model' => $this->findModel($id),
            'aPrdAttrs' => $aUnsortPrdAttrs,
            'aSortPrdAttrs' => $aPrdAttrs,
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
