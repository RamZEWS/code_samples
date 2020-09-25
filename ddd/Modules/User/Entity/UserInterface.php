<?php

declare(strict_types=1);

namespace Modules\User\Entity;

use Core\Entity\EntityInterface;

interface UserInterface extends EntityInterface
{
    public function getFio(): string;
    public function getGuid(): string;
    public function isAdmin(): bool;
}