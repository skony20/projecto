<?php
/*  
    Projekt    : projekttop.pl
    Created on : 2017-01-04, 15:59:51
    Author     : Mariusz Skonieczny, mariuszskonieczny@hotmail.com
*/
namespace frontend\controllers;
use Yii;
use yii\web\Controller;


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
       
        Yii::$app->view->registerMetaTag(
        [
            'name' => 'robots',
            'content' => 'follow, index'
        ], 'robots'
        );
        
        return parent::beforeAction($action);
    }

}