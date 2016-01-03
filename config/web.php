<?php
$config = [
    'id' => 'api',
    'basePath' => '/var/www/html',
    'vendorPath' => '/var/www/vendor',
    'language' => 'zh-CN',
    'timeZone' => 'Asia/Chongqing',
    'bootstrap' => ['log', 'raven', 'newrelic'],
    'components' => [
        'cache' => [
            //'class' => 'yii\caching\ApcCache',
            'class' => 'yii\redis\Cache',
        ],
        'session' => [
          'class' => 'yii\redis\Session',
        ],
        'redis' => [
            'class' => 'yii\redis\Connection',
            'hostname' => \DockerEnv::get('REDIS_PORT_6379_TCP_ADDR'),
            'port' => 6379,
            'password' => \DockerEnv::get('REDIS_1_ENV_REDIS_PASSWORD'),
            'database' => 0,
        ],
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => \DockerEnv::dbDsn(),
            'username' => \DockerEnv::dbUser(),
            'password' => \DockerEnv::dbPassword(),
            'charset' => 'utf8mb4',
            'tablePrefix' => '',
            'enableSchemaCache' => \DockerEnv::get('ENABLE_OPTIMIZE'),
            'schemaCacheDuration' => 86400, // time in seconds
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mail' => [
            'class' => 'yii\swiftmailer\Mailer',
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => \DockerEnv::get('SMTP_HOST'),
                'username' => \DockerEnv::get('SMTP_USER'),
                'password' => \DockerEnv::get('SMTP_PASSWORD'),
            ],
        ],
        'newrelic' => [
            'class' => 'bazilio\yii\newrelic\Newrelic',
            'name' => \DockerEnv::get('NEW_RELIC_APP_NAME'),
        ],
        'raven' => [
            'class' => 'e96\sentry\ErrorHandler',
            'dsn' => \DockerEnv::get('SENTRY_DSN')
        ],
        'log' => [
            'traceLevel' => \DockerEnv::get('YII_TRACELEVEL', 0),
            'targets' => [
                [
                    'class' => 'codemix\streamlog\Target',
                    'url' => 'php://stdout',
                    'levels' => ['info','trace'],
                    'logVars' => [],
                ],
                [
                    'class' => 'codemix\streamlog\Target',
                    'url' => 'php://stderr',
                    'levels' => ['error', 'warning'],
                    'logVars' => [],
                ],
            ],
        ],
        'request' => [
            'cookieValidationKey' => \DockerEnv::get('COOKIE_VALIDATION_KEY', null, !YII_ENV_TEST),
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'response' => [
            'class' => 'yii\web\Response',
            'on beforeSend' => function ($event) {
                $response = $event->sender;
                if ($response->data !== null && Yii::$app->request->get('suppress_response_code')) {
                    $response->data = [
                        'success' => $response->isSuccessful,
                        'data' => $response->data,
                    ];
                    $response->statusCode = 200;
                }
            },
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
                ['class' => 'yii\rest\UrlRule', 'controller' => 'user'],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'activity'],
            ],
        ],
        'user' => [
            'identityClass' => 'someet\common\models\User',
        ],
        'i18n' => [
            'translations' => [
                'user*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@user/messages',
                    'sourceLanguage' => 'zh-CN',
                    //'fileMap' => [
                    //   'app' => 'app.php',
                    //  'app/error' => 'error.php',
                    //],
                ],
            ],
        ],
    ],
    'params' => require('/var/www/html/config/params.php'),
];

if (YII_ENV_DEV) {
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        'allowedIPs' => ['*'],
    ];
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = 'yii\gii\Module';
}

return $config;
