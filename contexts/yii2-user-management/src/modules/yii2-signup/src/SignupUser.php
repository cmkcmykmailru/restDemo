<?php

namespace grigor\signup;

use grigor\signup\api\SignupUserInterface;
use grigor\signup\events\UserSignUpConfirmed;
use grigor\userManagement\modules\user\User;

class SignupUser extends User implements SignupUserInterface
{
    public function confirmSignup(): void
    {
        if (!$this->isWait()) {
            throw new \DomainException('User is already active.');
        }
        $this->status = self::STATUS_ACTIVE;
        $this->email_confirm_token = null;
        $this->recordEvent(new UserSignUpConfirmed($this->id));
    }
}