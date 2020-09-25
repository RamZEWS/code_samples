<?php

declare(strict_types=1);

namespace Core\Entity;

interface EntityInterface
{
    /**
     * @return int
     */
    public function getId(): int;

    /**
     * @param int $id
     *
     * @return mixed
     */
    public function setId(int $id);
}