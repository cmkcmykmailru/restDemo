<?php

namespace grigor\accessManagement\etc\web;

use grigor\accessManagement\AccessManagementContract;
use grigor\accessManagement\services\AccessManagementService;
use grigor\library\contexts\Config;
use Yii;
use yii\base\BootstrapInterface;
use yii\rbac\ManagerInterface;

class Web implements BootstrapInterface
{
    public function bootstrap($app)
    {
        Yii::$container->setSingleton(ManagerInterface::class, function () use ($app) {
            return $app->authManager;
        });
        \Yii::$container->setSingleton(
            AccessManagementContract::class,
            AccessManagementService::class,
            [new Config(__DIR__)]
        );
    }
}