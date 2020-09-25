<?php

declare(strict_types=1);

namespace Modules\Cart\Entity;

use Core\Entity\BaseEntity;

class Cart extends BaseEntity
{
    /** @var int */
    private $userId;

    /** @var string */
    private $cartNumber;

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @param int $userId
     *
     * @return self
     */
    public function setUserId(int $userId): self
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * @return string
     */
    public function getCartNumber(): string
    {
        return $this->cartNumber;
    }

    /**
     * @param string $cartNumber
     *
     * @return self
     */
    public function setCartNumber(string $cartNumber): self
    {
        $this->cartNumber = $cartNumber;

        return $this;
    }
}