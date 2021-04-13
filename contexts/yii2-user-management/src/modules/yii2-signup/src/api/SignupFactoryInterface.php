<?php

namespace grigor\signup\api;

use grigor\signup\api\dto\SignUpDto;

interface SignupFactoryInterface
{
    /**
     * @param SignUpDto $dto
     * @return SignupUserInterface
     */
    public function create(SignUpDto $dto): SignupUserInterface;
}