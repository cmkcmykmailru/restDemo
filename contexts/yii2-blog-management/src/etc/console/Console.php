<?php

namespace grigor\blogManagement\etc\console;

use grigor\blogManagement\BlogManagementContract;
use grigor\blogManagement\services\BlogManagementService;
use grigor\library\contexts\Config;
use yii\base\BootstrapInterface;

class Console implements BootstrapInterface
{

    public function bootstrap($app)
    {
        \Yii::$container->setSingleton(
            BlogManagementContract::class,
            BlogManagementService::class,
            [new Config(__DIR__)]
        );
    }
}