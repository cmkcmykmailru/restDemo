<?php

namespace grigor\signup\api;

use grigor\signup\api\dto\SignUpDto;

interface SignupFactoryInterface
{
    public function create(SignUpDto $dto): SignupUserInterface;
}