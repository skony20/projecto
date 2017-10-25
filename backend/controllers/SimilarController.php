<?php

namespace backend\controllers;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\models\Similar;
use app\models\Products;


class SimilarController extends \yii\web\Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'add' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                
                'rules' => [
                    [
                        'actions' => ['index', 'delete', 'add'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex($sName = '')
    {
        
        $iId = 0;
        if (isset($_GET['id']))
        {
            $iId = $_GET['id'];
        }
        
        $aFindSimilar =[];
        $aSimilarExistIds = [];
        $aProductsFind = [];
        $aProductsExist = [];
        $sActualName = '';
        
        /*Wyszukiwanie po nazwie z formularza*/
        if ($sName != '')
        {
            $oSimilar= new Similar();
            $aFindSimilar = $oSimilar->getSimilarByName($sName);
        }
        /*Pokazanie tych co są*/
        if ($iId>0)
        {
            $oActualPrj = new Products();
            $aActualPrj = $oActualPrj->findOne(['id'=>$iId]);
            $sActualName = $aActualPrj->productsDescriptons->name .' (' .$aActualPrj->producers->name . ')';
            $oSimilarsExist = new Similar();
            $aSimilarsExist = $oSimilarsExist->findAll(['main_product_id'=>$iId]);
            
            foreach ($aSimilarsExist as $aSimilarExist)
            {
                $aSimilarExistIds[]=$aSimilarExist->products_id;
            }
        }
        if (count($aFindSimilar) > 0)
        {
            $oProducts = new Products();
            $aProductsFind = $oProducts->find()->andWhere(['in', 'id', $aFindSimilar])->all();
        }
        if (count($aSimilarExistIds)>0)
        {
            $oProducts = new Products();
            $aProductsExist = $oProducts->find()->andWhere(['in', 'id', $aSimilarExistIds])->all();
        }
        return $this->render('index', ['aProductsFind'=>$aProductsFind, 'iId'=>$iId, 'aProductsExist'=>$aProductsExist, 'sActualName'=>$sActualName, 'sName'=>$sName]);
    }
    public function actionAdd()
    {
        $aSimilar = Yii::$app->request->post('Similar');
        foreach ($aSimilar['products_id'] as $iProductId)
        {
            $oSimilar = new Similar();
            $oSimilar->main_product_id = $aSimilar['main_product_id'];
            $oSimilar->products_id = $iProductId;
            if (!$oSimilar->findOne(['main_product_id'=>$aSimilar['main_product_id'], 'products_id'=>$iProductId]))
            {
                if ($oSimilar->save())
                {
                    Yii::$app->getSession()->setFlash('success', 'Podobne projekty dodane !');   
                }
            }
                
            
        }
        return $this->redirect(Yii::$app->request->referrer);
        
    }
    public function actionDelete($p_iMainId, $p_iSimilarId)       
    {
        $iMainId = ((int)($p_iMainId));
        $iSimilarId = ((int)($p_iSimilarId));
        $oSimilar = new Similar();
        if ($oSimilar->deleteSimilar($iMainId, $iSimilarId))
        {
            $oProducts = new Products();
            $aProduct = $oProducts->findOne(['id'=>$iSimilarId]);
            
            Yii::$app->session->setFlash('success', $aProduct->productsDescriptons->name.' został usunięty !');
        }
        
        return $this->redirect(Yii::$app->request->referrer);
        
    }

}
