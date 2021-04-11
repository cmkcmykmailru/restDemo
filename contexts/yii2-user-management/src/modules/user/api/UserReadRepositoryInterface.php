<?php

namespace grigor\userManagement\modules\user\api;

interface UserReadRepositoryInterface
{
    public function find(string $id): ?UserInterface;

    public function findActiveByUsername(string $username): ?UserInterface;

    public function findActiveById(string $id): ?UserInterface;
}