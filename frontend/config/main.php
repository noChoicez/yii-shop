<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
	'language' => 'zh-CN',
    'controllerNamespace' => 'frontend\controllers',
	'modules' => [
		'user' => [
			'class' => 'frontend\modules\user\UserModule',
		],
	],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
        ],
        'user' => [
            'identityClass' => 'common\models\UserModel',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
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
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '<controller:\w+>/<id:\d+>'=>'<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
                '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
            ],
        ],
    	'redis' =>[
    		'class' => 'yii\redis\Connection',
    		'hostname' => '127.0.0.1',  //你的redis地址
    		'port' => 6379, //端口
    		'database' => 0,
    	],
        'i18n' => [
            'translations' => [
                '*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    //'basePath' => '/messages',
                    'fileMap' => [
                        'common' => 'common.php',
                    ],
                ],
            ],
        ],
    	'authManager' => [
    			"class" => 'yii\rbac\DbManager',
    			"defaultRoles" => ["guest"],
    	],
    	'formatter' => [
   	     	'dateFormat' => 'Y-MM-dd H:i:s',
    		'decimalSeparator' => ',',
    		'thousandSeparator' => ' ',
    		'currencyCode' => 'EUR',
    	],
    ],
    'params' => $params,
];
