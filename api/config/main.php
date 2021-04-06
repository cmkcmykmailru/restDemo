<?php

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-api',
    'basePath' => dirname(__DIR__),
    'bootstrap' => [
        'log',
        \grigor\rest\RestBootstrap::class,
        \grigor\library\Bootstrap::class,
        \grigor\blogManagement\etc\rest\Rest::class,
        [
            'class' => 'yii\filters\ContentNegotiator',
            'formats' => [
                'application/json' => 'json',
                'application/xml' => 'xml',
            ],
        ],
    ],
    'modules' => [
        'rest' => [
            'class' => \grigor\rest\Module::class,
        ],
    ],
    'controllerNamespace' => 'api\controllers',
    'components' => [
        'request' => [
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ],
            'enableCsrfCookie' => false
        ],
        'response' => [
            'formatters' => [
                'json' => [
                    'class' => 'yii\web\JsonResponseFormatter',
                    'prettyPrint' => YII_DEBUG,
                    'encodeOptions' => JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE,
                ],
            ],
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => false,
            'enableSession' => false,
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
        'serviceInstaller' => [
            'class' => \grigor\rest\urls\installer\ServiceInstaller::class,
            'whiteList' => false,
        ],
        'serviceMetaDataReader' => [
            'class' => \grigor\rest\urls\installer\PhpServiceMetaDataReader::class,
            'serviceDirectoryPath' => $params['serviceDirectoryPath'],
            'rulesPath' => $params['rulesPath'],
        ],
        'urlManager' => [
            'class' => \grigor\rest\urls\UrlManager::class,
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
                '' => 'site/index',
            ],
        ],
    ],
    'params' => $params,
];