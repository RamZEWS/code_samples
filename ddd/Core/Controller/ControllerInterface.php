<?php

declare(strict_types=1);

namespace Core\Controller;

interface ControllerInterface
{
    public function sendResponse(): string;
}