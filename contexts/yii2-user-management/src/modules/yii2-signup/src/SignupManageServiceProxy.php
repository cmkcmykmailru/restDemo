<?php

namespace grigor\signup;

use grigor\library\services\ServiceEventsProxy;
use grigor\signup\api\dto\SignUpDto;
use grigor\signup\api\SignupManageServiceInterface;

class SignupManageServiceProxy  extends ServiceEventsProxy implements SignupManageServiceInterface
{
    public function __construct(
        SignupManageServiceInterface $realService,
        $config = []
    )
    {
        parent::__construct($realService, $config);
    }

    public function request(SignupDto $dto): void
    {
        $this->wrap([$this->realService, 'request'], ['dto' => $dto], [
            ServiceEventsProxy::EVENT_BEFORE_METHOD_EXECUTE => 'signupRequest',
            ServiceEventsProxy::EVENT_AFTER_METHOD_EXECUTE => 'signupRequested',
            ServiceEventsProxy::EVENT_ERROR_METHOD_EXECUTE => 'signupRequestError',
        ]);
    }

    public function confirm(string $token): void
    {
        $this->wrap([$this->realService, 'confirm'], ['token' => $token], [
            ServiceEventsProxy::EVENT_BEFORE_METHOD_EXECUTE => 'signupConfirm',
            ServiceEventsProxy::EVENT_AFTER_METHOD_EXECUTE => 'signupConfirm',
            ServiceEventsProxy::EVENT_ERROR_METHOD_EXECUTE => 'signupConfirmError',
        ]);
    }
}