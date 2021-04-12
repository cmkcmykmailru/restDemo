<?php

namespace grigor\accessManagement\etc\web;

use grigor\accessManagement\AccessManagementContract;
use grigor\accessManagement\services\AccessManagementService;
use grigor\library\contexts\Config;
use yii\base\BootstrapInterface;

class Web implements BootstrapInterface
{
    public function bootstrap($app)
    {
        \Yii::$container->setSingleton(
            AccessManagementContract::class,
            AccessManagementService::class,
            [new Config(__DIR__)]
        );
    }
}