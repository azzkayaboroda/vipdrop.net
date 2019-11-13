<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
            'baseUrl' => '',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
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
                '' => 'site/index',                                
                '<controller:\w+>/<action:\w+>/' => '<controller>/<action>',
            ],
        ],

        'eauth' => [
			'class' => 'nodge\eauth\EAuth',
			'popup' => true, // Use the popup window instead of redirecting.
			'cache' => false, // Cache component name or false to disable cache. Defaults to 'cache' on production environments.
			'cacheExpire' => 0, // Cache lifetime. Defaults to 0 - means unlimited.
			'httpClient' => [
				// uncomment this to use streams in safe_mode
				//'useStreamsFallback' => true,
			],
			'services' => [ // You can change the providers and their classes.
				'steam' => [
					'class' => 'nodge\eauth\services\SteamOpenIDService',
					//'realm' => '*.example.org', // your domain, can be with wildcard to authenticate on subdomains.
					//'apiKey' => '...', // Optional. You can get it here: https://steamcommunity.com/dev/apikey
				],
			],
		],
		
		'i18n' => [
			'translations' => [
				'eauth' => [
					'class' => 'yii\i18n\PhpMessageSource',
					'basePath' => '@eauth/messages',
				],
			],
        ],
        
        'assetManager' => [
            'bundles' => [

                'yii\bootstrap\BootstrapPluginAsset' => [
                    'js'=>[]
                ],
                'yii\bootstrap\BootstrapAsset' => [
                    'css' => [],
                ],
            ],
        ],
    ],
    'params' => $params,
];