<?php

use grigor\accessManagement\modules\manager\api\RoleManagerInterface;
use grigor\accessManagement\modules\manager\RoleManager;
use yii\di\Instance;
use yii\rbac\ManagerInterface;

return [
    ManagerInterface::class => function () {
        return Yii::$app->authManager;
    },
    RoleManager::class => [
        ['class' => RoleManager::class],
        [
            Instance::of(ManagerInterface::class),
        ]
    ],
    RoleManagerInterface::class => RoleManager::class
];
