<?php

namespace grigor\accessManagement;

use yii\db\ActiveQueryInterface;

interface AccessManagementContract
{
    public const USER_ROLE = 'user';

    public function assign(string $userId, string $roleName): void;
}