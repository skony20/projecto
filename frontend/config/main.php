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
    'bootstrap'    => ['assetsAutoCompress'],
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
                    'encodeParams' => false
                ],
                [
                    'pattern' => 'projekty/szerokosc/<SizeX:\d+>/glebokosc/<SizeY:\d+>/HouseSize/<HouseSize:.*>/filters/<tag:.*>',
                    'route' => 'projekty/index',
                    'encodeParams' => false
                ],
                [
                    'pattern' => 'projekty/szerokosc/<SizeX:\d+>/glebokosc/<SizeY:\d+>/HouseSize/<HouseSize:.*>/strona/<strona:\d+>',
                    'route' => 'projekty/index',
                    'encodeParams' => false
                ],
                [
                    'pattern' => 'projekty/szerokosc/<SizeX:\d+>/glebokosc/<SizeY:\d+>/HouseSize/<HouseSize:.*>',
                    'route' => 'projekty/index',
                    'encodeParams' => false
                ],
                [
                    'pattern' => 'projekty/szerokosc/<SizeX:\d+>/glebokosc/<SizeY:\d+>/filters/<tag:.*>/strona/<strona:\d+>',
                    'route' => 'projekty/index',
                    'encodeParams' => false
                ],
                [
                    'pattern' => 'projekty/szerokosc/<SizeX:\d+>/glebokosc/<SizeY:\d+>/filters/<tag:.*>',
                    'route' => 'projekty/index',
                    'encodeParams' => false
                ],
                [
                    'pattern' => 'projekty/szerokosc/<SizeX:\d+>/glebokosc/<SizeY:\d+>/strona/<strona:\d+>',
                    'route' => 'projekty/index',
                    'encodeParams' => false
                ],
                [
                    'pattern' => 'projekty/szerokosc/<SizeX:\d+>/glebokosc/<SizeY:\d+>/',
                    'route' => 'projekty/index',
                    'encodeParams' => false
                ],
                [
                    'pattern' => 'projekty/szerokosc/<SizeX:\d+>/HouseSize/<HouseSize:.*>/filters/<tag:.*>/strona/<strona:\d+>',
                    'route' => 'projekty/index',
                    'encodeParams' => false
                ],
                [
                    'pattern' => 'projekty/szerokosc/<SizeX:\d+>/HouseSize/<HouseSize:.*>/filters/<tag:.*>',
                    'route' => 'projekty/index',
                    'encodeParams' => false
                ],
                [
                    'pattern' => 'projekty/szerokosc/<SizeX:\d+>/HouseSize/<HouseSize:.*>/strona/<strona:\d+>',
                    'route' => 'projekty/index',
                    'encodeParams' => false
                ],
                [
                    'pattern' => 'projekty/szerokosc/<SizeX:\d+>/HouseSize/<HouseSize:.*>',
                    'route' => 'projekty/index',
                    'encodeParams' => false
                ],
                [
                    'pattern' => 'projekty/szerokosc/<SizeX:\d+>/filters/<tag:.*>/strona/<strona:\d+>',
                    'route' => 'projekty/index',
                    'encodeParams' => false
                ],
                [
                    'pattern' => 'projekty/szerokosc/<SizeX:\d+>/filters/<tag:.*>',
                    'route' => 'projekty/index',
                    'encodeParams' => false
                ],
                [
                    'pattern' => 'projekty/glebokosc/<SizeY:\d+>/HouseSize/<HouseSize:.*>/filters/<tag:.*>/strona/<strona:\d+>',
                    'route' => 'projekty/index',
                    'encodeParams' => false
                ],
                [
                    'pattern' => 'projekty/glebokosc/<SizeY:\d+>/HouseSize/<HouseSize:.*>/filters/<tag:.*>',
                    'route' => 'projekty/index',
                    'encodeParams' => false
                ],[
                    'pattern' => 'projekty/glebokosc/<SizeY:\d+>/HouseSize/<HouseSize:.*>/strona/<strona:\d+>',
                    'route' => 'projekty/index',
                    'encodeParams' => false
                ],
                [
                    'pattern' => 'projekty/glebokosc/<SizeY:\d+>/HouseSize/<HouseSize:.*>',
                    'route' => 'projekty/index',
                    'encodeParams' => false
                ],
                [
                    'pattern' => 'projekty/glebokosc/<SizeY:\d+>/filters/<tag:.*>/strona/<strona:\d+>',
                    'route' => 'projekty/index',
                    'encodeParams' => false
                ],
                [
                    'pattern' => 'projekty/glebokosc/<SizeY:\d+>/filters/<tag:.*>',
                    'route' => 'projekty/index',
                    'encodeParams' => false
                ],
                [
                    'pattern' => 'projekty/HouseSize/<HouseSize:.*>/filters/<tag:.*>/strona/<strona:\d+>',
                    'route' => 'projekty/index',
                    'encodeParams' => false
                ],
                [
                    'pattern' => 'projekty/HouseSize/<HouseSize:.*>/filters/<tag:.*>',
                    'route' => 'projekty/index',
                    'encodeParams' => false
                ],
                [
                    'pattern' => 'projekty/HouseSize/<HouseSize:.*>/strona/<strona:\d+>',
                    'route' => 'projekty/index',
                    'encodeParams' => false
                ],
                [
                    'pattern' => 'projekty/HouseSize/<HouseSize:.*>/',
                    'route' => 'projekty/index',
                    'encodeParams' => false
                ],
                [
                    'pattern' => 'projekty/filters/<tag:.*>/strona/<strona:\d+>',
                    'route' => 'projekty/index',
                    'encodeParams' => false
                ],
                [
                    'pattern' => 'projekty/filters/<tag:.*>',
                    'route' => 'projekty/index',
                    'encodeParams' => false
                ],[
                    'pattern' => 'projekty/szerokosc/<SizeX:\d+>/strona/<strona:\d+>',
                    'route' => 'projekty/index',
                    'encodeParams' => false
                ],
                [
                    'pattern' => 'projekty/szerokosc/<SizeX:\d+>',
                    'route' => 'projekty/index',
                    'encodeParams' => false
                ],
                [
                    'pattern' => 'projekty/glebokosc/<SizeY:\d+>/strona/<strona:\d+>',
                    'route' => 'projekty/index',
                    'encodeParams' => false
                ],
                
                [
                    'pattern' => 'projekty/glebokosc/<SizeY:\d+>',
                    'route' => 'projekty/index',
                    'encodeParams' => false
                ],
                

                'projekty/strona/<strona:\d+>' =>'projekty/index',
                'projekt/<symbol>.html' => 'projekt/view',
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>', 
                '<alias:login|signup|kontakt|wprojekcie|onas|regulamin|wspolpraca|cookie|accordion|polityka-prywatnosci|zwrot>' => 'site/<alias>',
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
         'P24Service' => [
            'class' => 'daweb\przelewy24\P24Service',
            'clientID' => 57788, 
            'sandboxSalt' => '551b07a57312ba16',  
            'salt' => '551b07a57312ba16',
            'currency' => 'PLN',
            'testMode' => true // enable sandbox mode
        ],
        

        'assetsAutoCompress' =>
        [
            'class'                         => '\skeeks\yii2\assetsAuto\AssetsAutoCompressComponent',
            'enabled'                       => true,
            'readFileTimeout'               => 3,           //Time in seconds for reading each asset file
            'jsCompress'                    => true,        //Enable minification js in html code
            'jsCompressFlaggedComments'     => true,        //Cut comments during processing js
            'cssCompress'                   => true,        //Enable minification css in html code
            'cssFileCompile'                => true,        //Turning association css files
            'cssFileRemouteCompile'         => false,       //Trying to get css files to which the specified path as the remote file, skchat him to her.
            'cssFileCompress'               => true,        //Enable compression and processing before being stored in the css file
            'cssFileBottom'                 => false,       //Moving down the page css files
            'cssFileBottomLoadOnJs'         => false,       //Transfer css file down the page and uploading them using js
            'jsFileCompile'                 => true,        //Turning association js files
            'jsFileRemouteCompile'          => false,       //Trying to get a js files to which the specified path as the remote file, skchat him to her.
            'jsFileCompress'                => true,        //Enable compression and processing js before saving a file
            'jsFileCompressFlaggedComments' => true,        //Cut comments during processing js
            'htmlCompress'                  => true,        //Enable compression html
            'htmlCompressOptions'           =>              //options for compressing output result
            [
                'extra' => true,        //use more compact algorithm
                'no-comments' => true   //cut all the html comments
            ],
        ],
        

    ],
    'params' => $params,
    
    
];
