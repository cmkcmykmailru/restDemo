<?php

namespace grigor\accessManagement\services;

use grigor\accessManagement\AccessManagementContract;
use grigor\library\contexts\AbstractContract;

class AccessManagementService extends AbstractContract implements AccessManagementContract
{
    public function assign(string $userId, string $roleName): void
    {

    }
}