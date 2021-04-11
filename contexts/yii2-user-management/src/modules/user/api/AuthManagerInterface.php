<?php

namespace grigor\userManagement\modules\user\api;

interface AuthManagerInterface
{
    public function auth(UserInterface $user, bool $rememberMe): void;
}