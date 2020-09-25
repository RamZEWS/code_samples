<?php

declare(strict_types=1);

namespace Modules\Product\Entity;

use Core\Entity\EntityInterface;

interface ProductInterface extends EntityInterface
{
    /**
     * @return string
     */
    public function getTitle(): string;

    /**
     * @return string
     */
    public function getGuid(): string;

    /**
     * @return float
     */
    public function getPrice(): float;

    /**
     * @return float
     */
    public function getOldPrice(): ?float;

    /**
     * @return int
     */
    public function getCategoryId(): int;
}