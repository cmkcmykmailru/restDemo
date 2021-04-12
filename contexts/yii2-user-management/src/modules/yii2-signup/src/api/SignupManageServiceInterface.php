<?php

namespace grigor\signup\api;

use grigor\signup\api\dto\SignUpDto;

interface SignupManageServiceInterface
{
    public function request(SignupDto $dto): void;

    public function confirm(string $token): void;
}