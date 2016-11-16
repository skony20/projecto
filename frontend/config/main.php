<?php

$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);
use \yii\web\Request;
$baseUrl = str_replace('/frontend/web', '', (new Request)->getBaseUrl()); 
return [
    'id' => 'app-frontend',
    'name'=>'Projekttop.pl',
    'language' => 'pl-PL',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
			'class' => 'common\components\Request',
			'web'=> '/frontend/web',
            'baseUrl' => '/projecto',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'baseUrl' => '/projecto',
            // Disable index.php
            'showScriptName' => false,
            // Disable r= routes
            'enablePrettyUrl' => true,
            //'suffix' =>'.html',
            'rules' => array(
                    'projekty/strona/<strona:\d+>' =>'projekty/index',
                    'projekty/szukaj/<szukaj:\w+>' =>'projekty/index',
                    'projekty/osoby/<7:\d+>/HouseSize/<HouseSize:.*>/Szerokosc/<SizeX:\d+>/Ksztalt/<3:\d+>' =>'projekty/index',
                    'projekty/HouseSize/<HouseSize:>/filters/<tag:.*>' =>'projekty/index',
                    'projekty/HouseSize/<HouseSize:.*>' =>'projekty/index',
                    'projekty/SizeX/<SizeX:\d+>' =>'projekty/index',
                    'projekt/<symbol>.html' => 'projekt/view',
                    '<controller:\w+>/<id:\d+>' => '<controller>/view',
                    '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                    '<controller:\w+>/<action:\w+>' => '<controller>/<action>', 
                    
                    '<alias:login|signup|kontakt|wprojekcie|onas|regulamin|wspolpraca>' => 'site/<alias>',
            ),
        ],
        'authClientCollection' => [
        'class' => 'yii\authclient\Collection',
        'clients' => [
          'facebook' => [
            'class' => 'yii\authclient\clients\Facebook',
            'authUrl' => 'https://www.facebook.com/dialog/oauth?display=popup',
            'clientId' => '1304805822925720',
            'clientSecret' => '3e9166cacad851c5fb18d07cb4c3574e',
            'attributeNames' => ['name', 'email', 'first_name', 'last_name'],
          ],
        ],
      ],
    ],
    'params' => $params,
    
];
