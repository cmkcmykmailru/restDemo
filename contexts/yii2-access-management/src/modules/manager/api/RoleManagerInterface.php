<?php

namespace grigor\accessManagement\modules\manager\api;

interface RoleManagerInterface
{
    public function assign(string $userId, string $name): void;
}