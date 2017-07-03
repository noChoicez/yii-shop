<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'language' => 'zh-CN',
    "modules" => [
        //RABC模块
	    "admin" => [
	        "class" => "mdm\admin\Module",
	    	'defaultRoute'=>'user/index',
	    ],
        //商品管理模块
        'goods' => [
            'class' => 'backend\modules\goods\GoodsModule',
        	'defaultRoute'=>'goods/index',
        ],
    	//促销管理模块
    	'promo' => [
    		'class' => 'backend\modules\promo\PromoModule',
    	],
    	//文章模块
    	'posts' => [
    		'class' => 'backend\modules\posts\PostsModule',
    	],
    	//插件模块
    	'plugin' => [
    		'class' => 'backend\modules\plugin\PluginModule',
    	],
	],
	"aliases" => [
	    "@mdm/admin" => "@vendor/mdmsoft/yii2-admin",
	],
	'as access' => [
	    'class' => 'mdm\admin\components\AccessControl',
	    'allowActions' => [
	        //这里是允许访问的action
	        //controller/action
	        // * 表示允许所有，
	        '*'
	    ]
	],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        'user' => [
            'identityClass' => 'common\models\AdminModel',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
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
