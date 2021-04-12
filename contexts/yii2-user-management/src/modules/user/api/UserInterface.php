<?php

namespace grigor\userManagement\modules\user\api;

use yii\db\ActiveRecordInterface;

interface UserInterface extends ActiveRecordInterface
{
    const STATUS_WAIT = 0;
    const STATUS_ACTIVE = 10;

    public function isWait(): bool;

    public function isActive(): bool;

    public function validatePassword(string $password): bool;

    public function setPassword(string $password): void;

    public function loginNotify(): void;

    public function generateAuthKey(): void;
}