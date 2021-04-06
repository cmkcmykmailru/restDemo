<?php

namespace grigor\blogManagement\etc\rest;

use grigor\blogManagement\BlogManagementContract;
use grigor\blogManagement\services\BlogManagementService;
use grigor\library\contexts\Config;
use yii\base\BootstrapInterface;

class Rest implements BootstrapInterface
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