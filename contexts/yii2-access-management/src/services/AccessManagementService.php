<?php

namespace grigor\accessManagement\services;

use grigor\accessManagement\AccessManagementContract;
use grigor\accessManagement\modules\manager\api\RoleManagerInterface;
use grigor\library\contexts\AbstractContract;

class AccessManagementService extends AbstractContract implements AccessManagementContract
{
    public function assign(string $userId, string $roleName): void
    {
        $this->container()->get(RoleManagerInterface::class )->assign($userId, $roleName);
    }
}