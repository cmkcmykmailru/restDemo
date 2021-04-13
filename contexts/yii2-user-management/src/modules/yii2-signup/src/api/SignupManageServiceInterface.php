<?php

namespace grigor\signup\api;

use grigor\library\services\Service;
use grigor\signup\api\dto\SignUpDto;

interface SignupManageServiceInterface extends Service
{
    public function request(SignupDto $dto): void;

    public function confirm(string $token): void;
}