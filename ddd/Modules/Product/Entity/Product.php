<?php

declare(strict_types=1);

namespace Modules\Product\Entity;

use Core\Entity\BaseEntity;

class Product extends BaseEntity implements ProductInterface
{
    /** @var string */
    private $title;

    /** @var float */
    private $price;

    /** @var float|null */
    private $oldPrice;

    /** @var int */
    private $categoryId;

    /** @var string */
    private $guid;

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     *
     * @return self
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @param float $price
     *
     * @return self
     */
    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getOldPrice(): ?float
    {
        return $this->oldPrice;
    }

    /**
     * @param float|null $oldPrice
     *
     * @return self
     */
    public function setOldPrice(?float $oldPrice): self
    {
        $this->oldPrice = $oldPrice;

        return $this;
    }

    /**
     * @return int
     */
    public function getCategoryId(): int
    {
        return $this->categoryId;
    }

    /**
     * @param int $categoryId
     *
     * @return self
     */
    public function setCategoryId(int $categoryId): self
    {
        $this->categoryId = $categoryId;

        return $this;
    }

    /**
     * @return string
     */
    public function getGuid(): string
    {
        return $this->guid;
    }

    /**
     * @param string $guid
     *
     * @return self
     */
    public function setGuid(string $guid): self
    {
        $this->guid = $guid;

        return $this;
    }
}
