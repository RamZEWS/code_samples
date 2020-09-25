<?php

declare(strict_types=1);

namespace Modules\User\Service;

use Modules\User\Entity\UserInterface;

class UserService
{
    /** @var SessionService */
    private $sessionService;

    /**
     * @param SessionService $sessionService
     */
    public function __construct(
        SessionService $sessionService
    ) {
        $this->sessionService = $sessionService;
    }

    /**
     * @return UserInterface
     */
    public function getCurrentUser(): UserInterface
    {
        return $this->sessionService->getCurrent();
    }
}