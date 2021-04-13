<?php

namespace grigor\userManagement\etc\rest;

use grigor\library\contexts\Config;
use grigor\userManagement\modules\user\api\UserInterface;
use grigor\userManagement\modules\user\User;
use grigor\userManagement\services\SignUpService;
use grigor\userManagement\services\UserManagementService;
use grigor\userManagement\SignupContract;
use grigor\userManagement\UserManagementContract;
use Yii;
use yii\base\BootstrapInterface;

class Rest implements BootstrapInterface
{
    public function bootstrap($app)
    {
        Yii::$container->set(
            UserInterface::class,
            User::class
        );

        Yii::$container->setSingleton(
            UserManagementContract::class,
            UserManagementService::class,
            [new Config(__DIR__)]
        );

        Yii::$container->setSingleton(
            SignupContract::class,
            SignupService::class,
            [new Config(__DIR__)]
        );
    }
}