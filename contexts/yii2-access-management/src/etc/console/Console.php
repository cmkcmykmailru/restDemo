<?php

namespace grigor\accessManagement\etc\console;

use grigor\accessManagement\AccessManagementContract;
use grigor\accessManagement\services\AccessManagementService;
use grigor\library\contexts\Config;
use yii\base\BootstrapInterface;

class Console implements BootstrapInterface
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