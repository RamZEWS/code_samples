<?php

declare(strict_types=1);

namespace Core\Enumeration;

use Core\Exception\NotFoundException;

abstract class BaseEnumeration implements EnumerationInterface
{
    /** @var int|string */
    private $code;

    protected static $names = [];

    /**
     * @param int|string $code
     */
    public function __construct($code)
    {
        $this->setCode($code);
    }

    /**
     * @param int|string $code
     *
     * @return self
     */
    public function setCode($code): self
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @return int|string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @return string
     *
     * @throws NotFoundException
     */
    public function getName(): string
    {
        $name = static::$names[$this->getCode()];

        if ($name === null) {
            throw new NotFoundException('Name for enumeration is not found');
        }

        return (string) $name;
    }
}