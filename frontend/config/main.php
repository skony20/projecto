<?php

$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);
use \yii\web\Request;
return [
    'id' => 'app-frontend',
    'name'=>'ProjektTop.pl',
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
        'formatter' => [
            'dateFormat' => 'dd.MM.yyyy',
            'datetimeFormat' => 'dd.MM.yyyy HH:mm:ss',
            'timeFormat' => 'H:i:s',
            'decimalSeparator' => ',',
            'thousandSeparator' => ' ',
            'currencyCode' => 'zł ',
       ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
        ],
        'session' => [

            'name' => 'projettopId',
            'timeout' => 432000,
            
//            'class' => 'yii\web\DbSession',
//            'sessionTable' => 'session', // session table name. Defaults to 'session'.
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
                    
                'projekty/szukaj/<szukaj:.*>' =>'projekty/index',
                [
                    'pattern' => 'projekty/szerokosc/<SizeX:\d+>/glebokosc/<SizeY:\d+>/HouseSize/<HouseSize:.*>/filters/<tag:.*>/strona/<strona:\d+>',
                    'route' => 'projekty/index',
                    'encodeParams' => true
                ],
                [
                    'pattern' => 'projekty/szerokosc/<SizeX:\d+>/glebokosc/<SizeY:\d+>/HouseSize/<HouseSize:.*>/filters/<tag:.*>',
                    'route' => 'projekty/index',
                    'encodeParams' => true
                ],
                [
                    'pattern' => 'projekty/szerokosc/<SizeX:\d+>/glebokosc/<SizeY:\d+>/HouseSize/<HouseSize:.*>/strona/<strona:\d+>',
                    'route' => 'projekty/index',
                    'encodeParams' => true
                ],
                [
                    'pattern' => 'projekty/szerokosc/<SizeX:\d+>/glebokosc/<SizeY:\d+>/HouseSize/<HouseSize:.*>',
                    'route' => 'projekty/index',
                    'encodeParams' => true
                ],
                [
                    'pattern' => 'projekty/szerokosc/<SizeX:\d+>/glebokosc/<SizeY:\d+>/filters/<tag:.*>/strona/<strona:\d+>',
                    'route' => 'projekty/index',
                    'encodeParams' => true
                ],
                [
                    'pattern' => 'projekty/szerokosc/<SizeX:\d+>/glebokosc/<SizeY:\d+>/filters/<tag:.*>',
                    'route' => 'projekty/index',
                    'encodeParams' => true
                ],
                [
                    'pattern' => 'projekty/szerokosc/<SizeX:\d+>/glebokosc/<SizeY:\d+>/strona/<strona:\d+>',
                    'route' => 'projekty/index',
                    'encodeParams' => true
                ],
                [
                    'pattern' => 'projekty/szerokosc/<SizeX:\d+>/glebokosc/<SizeY:\d+>/',
                    'route' => 'projekty/index',
                    'encodeParams' => true
                ],
                [
                    'pattern' => 'projekty/szerokosc/<SizeX:\d+>/HouseSize/<HouseSize:.*>/filters/<tag:.*>/strona/<strona:\d+>',
                    'route' => 'projekty/index',
                    'encodeParams' => true
                ],
                [
                    'pattern' => 'projekty/szerokosc/<SizeX:\d+>/HouseSize/<HouseSize:.*>/filters/<tag:.*>',
                    'route' => 'projekty/index',
                    'encodeParams' => true
                ],
                [
                    'pattern' => 'projekty/szerokosc/<SizeX:\d+>/HouseSize/<HouseSize:.*>/strona/<strona:\d+>',
                    'route' => 'projekty/index',
                    'encodeParams' => true
                ],
                [
                    'pattern' => 'projekty/szerokosc/<SizeX:\d+>/HouseSize/<HouseSize:.*>',
                    'route' => 'projekty/index',
                    'encodeParams' => true
                ],
                [
                    'pattern' => 'projekty/szerokosc/<SizeX:\d+>/filters/<tag:.*>/strona/<strona:\d+>',
                    'route' => 'projekty/index',
                    'encodeParams' => true
                ],
                [
                    'pattern' => 'projekty/szerokosc/<SizeX:\d+>/filters/<tag:.*>',
                    'route' => 'projekty/index',
                    'encodeParams' => true
                ],
                [
                    'pattern' => 'projekty/glebokosc/<SizeY:\d+>/HouseSize/<HouseSize:.*>/filters/<tag:.*>/strona/<strona:\d+>',
                    'route' => 'projekty/index',
                    'encodeParams' => true
                ],
                [
                    'pattern' => 'projekty/glebokosc/<SizeY:\d+>/HouseSize/<HouseSize:.*>/filters/<tag:.*>',
                    'route' => 'projekty/index',
                    'encodeParams' => true
                ],[
                    'pattern' => 'projekty/glebokosc/<SizeY:\d+>/HouseSize/<HouseSize:.*>/strona/<strona:\d+>',
                    'route' => 'projekty/index',
                    'encodeParams' => true
                ],
                [
                    'pattern' => 'projekty/glebokosc/<SizeY:\d+>/HouseSize/<HouseSize:.*>',
                    'route' => 'projekty/index',
                    'encodeParams' => true
                ],
                [
                    'pattern' => 'projekty/glebokosc/<SizeY:\d+>/filters/<tag:.*>/strona/<strona:\d+>',
                    'route' => 'projekty/index',
                    'encodeParams' => true
                ],
                [
                    'pattern' => 'projekty/glebokosc/<SizeY:\d+>/filters/<tag:.*>',
                    'route' => 'projekty/index',
                    'encodeParams' => true
                ],
                [
                    'pattern' => 'projekty/HouseSize/<HouseSize:.*>/filters/<tag:.*>/strona/<strona:\d+>',
                    'route' => 'projekty/index',
                    'encodeParams' => true
                ],
                [
                    'pattern' => 'projekty/HouseSize/<HouseSize:.*>/filters/<tag:.*>',
                    'route' => 'projekty/index',
                    'encodeParams' => true
                ],
                [
                    'pattern' => 'projekty/HouseSize/<HouseSize:.*>/strona/<strona:\d+>',
                    'route' => 'projekty/index',
                    'encodeParams' => true
                ],
                [
                    'pattern' => 'projekty/HouseSize/<HouseSize:.*>/',
                    'route' => 'projekty/index',
                    'encodeParams' => true
                ],
                [
                    'pattern' => 'projekty/filters/<tag:.*>/strona/<strona:\d+>',
                    'route' => 'projekty/index',
                    'encodeParams' => true
                ],
                [
                    'pattern' => 'projekty/filters/<tag:.*>',
                    'route' => 'projekty/index',
                    'encodeParams' => true
                ],[
                    'pattern' => 'projekty/szerokosc/<SizeX:\d+>/strona/<strona:\d+>',
                    'route' => 'projekty/index',
                    'encodeParams' => true
                ],
                [
                    'pattern' => 'projekty/szerokosc/<SizeX:\d+>',
                    'route' => 'projekty/index',
                    'encodeParams' => true
                ],
                [
                    'pattern' => 'projekty/glebokosc/<SizeY:\d+>/strona/<strona:\d+>',
                    'route' => 'projekty/index',
                    'encodeParams' => true
                ],
                
                [
                    'pattern' => 'projekty/glebokosc/<SizeY:\d+>',
                    'route' => 'projekty/index',
                    'encodeParams' => true
                ],
                

                'projekty/strona/<strona:\d+>' =>'projekty/index',
                'projekt/<symbol>.html' => 'projekt/view',
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>', 
                '<alias:login|signup|kontakt|wprojekcie|onas|regulamin|wspolpraca|faq|cookie|accordion|polityka-prywatnosci|zwrot>' => 'site/<alias>',
            ),
            
        ],
        'authClientCollection' => [
        'class' => 'yii\authclient\Collection',
        'clients' => [
          'facebook' => [
            'name' =>'facebook',
            'class' => 'yii\authclient\clients\Facebook',
            'authUrl' => 'https://www.facebook.com/dialog/oauth?display=popup',
            'clientId' => '1304805822925720',
            'clientSecret' => '3e9166cacad851c5fb18d07cb4c3574e',
            'attributeNames' => ['name', 'email', 'first_name', 'last_name'],
          ],
           'google' => [
                  'name' =>'google',
                  'class' => 'yii\authclient\clients\Google',
                  'clientId' => '231397738978-cn7knqev4928f22lgcgpkii36um593al.apps.googleusercontent.com',
                  'clientSecret' => 'njsDOucSDH8sS5K9xAZk2Ctu',
              ], 
        ],
      ],
    ],
    'params' => $params,
    
];
