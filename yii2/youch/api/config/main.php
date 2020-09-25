<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/params.php')
);

$config = [
    'id' => 'app-api',
    'basePath' => dirname(__DIR__),
    'bootstrap' => [
        'log',
        [
            'class' => 'yii\filters\ContentNegotiator',
            'formats' => [
                'application/json' => \yii\web\Response::FORMAT_JSON
            ]
       ]
    ],
    'controllerNamespace' => 'api\controllers',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-api',
            'cookieValidationKey' => '5yV0FI5lKJxx7rvEbEVARiFzxH2a-5V0',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'formatter' => [
            'class' => 'yii\i18n\Formatter',
            'nullDisplay' => '',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-api', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the api
            'name' => 'advanced-api',
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
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
                'POST oauth2/<action:\w+>' => 'oauth2/rest/<action>',
                'user/get/<id:[\w-]+>'=>'user/view',
                
                'content/user/<id:[\w-]+>'=>'content/user',
                'tour/user/<id:[\w-]+>'=>'tour/user',
                'event/user/<id:[\w-]+>'=>'event/user',
                'subscription/black-list/<id:[\w-]+>'=>'subscription/black-list',
                'subscription/followers/<id:[\w-]+>'=>'subscription/followers',
                'subscription/followings/<id:[\w-]+>'=>'subscription/followings',
                'comment/user/<id:[\w-]+>'=>'comment/user',
                'comment/to-user/<id:[\w-]+>'=>'comment/to-user',
		'event/image/<id:\d+>' => 'event/image',

                '<controller:[\w-]+>/?'=>'<controller>/index',
                '<controller:[\w-]+>/<id:\d+>'=>'<controller>/view',
                '<controller:[\w-]+>/<action:[\w-]+>/?'=>'<controller>/<action>',
                //['class' => 'yii\rest\UrlRule', 'controller' => 'user'],
                //['class' => 'yii\rest\UrlRule', 'controller' => 'city'],
                //['class' => 'yii\rest\UrlRule', 'controller' => 'register'],
                //['class' => 'yii\rest\UrlRule', 'controller' => 'auth'],
            ],
        ],
    ],
    'params' => $params,
    'modules' => [
        'oauth2' => [
            'class' => 'filsh\yii2\oauth2server\Module',
            'tokenParamName' => 'access_token',
            'tokenAccessLifetime' => 3600 * 24,
            'controllerMap' => [
                'rest' => 'api\modules\oauth2\controllers\RestController'
            ],
            'storageMap' => [
                'user_credentials' => 'common\models\User',
            ],
            'grantTypes' => [
                'user_credentials' => [
                    'class' => 'OAuth2\GrantType\UserCredentials',
                ],
                'refresh_token' => [
                    'class' => 'OAuth2\GrantType\RefreshToken',
                    'always_issue_new_refresh_token' => true
                ]
            ]
        ]
    ]
];

if (!YII_ENV_TEST) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
