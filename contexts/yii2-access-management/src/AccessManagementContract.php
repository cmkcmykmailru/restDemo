<?php

namespace grigor\accessManagement;

use grigor\generator\annotation as API;
use yii\db\ActiveQueryInterface;

interface AccessManagementContract
{
    public const USER_ROLE = 'user';

    public function assign(string $userId, string $roleName): void;
}