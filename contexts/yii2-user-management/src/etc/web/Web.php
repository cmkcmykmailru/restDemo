<?php

namespace grigor\userManagement\etc\web;

use grigor\library\contexts\Config;
use grigor\userManagement\services\UserManagementService;
use grigor\userManagement\UserManagementContract;
use Yii;
use yii\base\BootstrapInterface;

class Web implements BootstrapInterface
{
    public function bootstrap($app)
    {
        Yii::$container->setSingleton(
            UserManagementContract::class,
            UserManagementService::class,
            [new Config(__DIR__)]
        );
    }
}