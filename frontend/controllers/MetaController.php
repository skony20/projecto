<?php
/*  
    Projekt    : projekttop.pl
    Created on : 2017-01-04, 15:59:51
    Author     : Mariusz Skonieczny, mariuszskonieczny@hotmail.com
*/
namespace frontend\controllers;
use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\Products;
use common\widgets\Alert;

use yii\web\Session;

class MetaController extends Controller
{
    
    public function beforeAction($action) 
    {
        Yii::$app->view->registerMetaTag(
        [
            'name' => 'description',
            'content' => 'ProjektTop.pl - wybór projektu jeszcze nigdy nie był tak prosty. Największy i najłatwiejszy wybór projektów domu.'
        ], 'description'
        );
        Yii::$app->view->registerMetaTag(
        [
            'name' => 'keywords',
            'content' => 'projekty domów, dom, projekt, projekt domu, plan domu, plany domu'
        ]
        );
        return parent::beforeAction($action);
    }

}