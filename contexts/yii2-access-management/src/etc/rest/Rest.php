<?php

namespace grigor\accessManagement\etc\rest;

use grigor\accessManagement\AccessManagementContract;
use grigor\accessManagement\services\AccessManagementService;
use grigor\library\contexts\Config;
use yii\base\BootstrapInterface;

class Rest implements BootstrapInterface
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