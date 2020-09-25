<?php

declare(strict_types=1);

namespace Core\Enumeration;

interface EnumerationInterface
{
    /**
     * @return string|int
     */
    public function getCode();

    /**
     * @return string
     */
    public function getName(): string;
}