<?php

namespace grigor\userManagement;

use grigor\userManagement\services\forms\SignupForm;

interface SignupContract
{
    public function getDefinitionOf(string $className): string;

    public function request(SignupForm $form): void;

    public function confirm(string $token): void;
}