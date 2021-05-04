<?php

namespace grigor\userManagement;

use grigor\library\contexts\ContractInterface;
use grigor\userManagement\services\forms\SignupForm;

interface SignupContract extends ContractInterface
{
    public function getDefinitionOf(string $className): string;

    public function request(SignupForm $form): void;

    public function confirm(string $token): void;
}