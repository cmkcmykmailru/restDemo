<?php

namespace grigor\signup;

use grigor\accessManagement\AccessManagementContract;
use grigor\signup\api\dto\SignUpDto;
use grigor\signup\api\SignupManageServiceInterface;
use grigor\signup\api\SignupRepositoryInterface;

class SignupManageService implements SignupManageServiceInterface
{
    private SignupRepositoryInterface $users;
    private AccessManagementContract $accessContract;

    public function __construct(
        SignupRepositoryInterface $users,
        AccessManagementContract $accessContract
    )
    {
        $this->users = $users;
        $this->accessContract = $accessContract;
    }

    public function request(SignupDto $dto): void
    {
        $user = $this->users->createUser($dto);

        $this->users->save($user);
        $this->accessContract->assign($user->id, AccessManagementContract::USER_ROLE);
    }

    public function confirm(string $token): void
    {
        if (empty($token)) {
            throw new \DomainException('Empty confirm token.');
        }
        $user = $this->users->getByEmailConfirmToken($token);
        $user->confirmSignup();
        $this->users->save($user);
    }
}