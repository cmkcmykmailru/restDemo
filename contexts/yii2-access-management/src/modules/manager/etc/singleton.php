<?php

use grigor\accessManagement\modules\manager\api\RoleManagerInterface;
use grigor\accessManagement\modules\manager\RoleManager;
use yii\di\Instance;
use yii\rbac\ManagerInterface;

return [
    RoleManager::class => [
        ['class' => RoleManager::class],
        [
            Instance::of(ManagerInterface::class),
        ]
    ],
    RoleManagerInterface::class => RoleManager::class
];
