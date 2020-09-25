<?php

declare(strict_types=1);

namespace Modules\User\Entity;

use Core\Entity\BaseEntity;
use Modules\User\Enumeration\UserRoleEnumeration;

class User extends BaseEntity implements UserInterface
{
    /** @var string */
    private $firstName;

    /** @var string */
    private $lastName;

    /** @var string */
    private $patronymic;

    /** @var string */
    private $role;

    /** @var string */
    private $guid;

    /**
     * @return string
     */
    public function getFio(): string
    {
        return trim(
            implode(' ', [
                $this->getLastName(),
                $this->getFirstName(),
                $this->getPatronymic(),
            ])
        );
    }

    /**
     * @return string
     */
    public function getGuid(): string
    {
        return $this->guid;
    }

    /**
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->getRole() === UserRoleEnumeration::admin()->getCode();
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     *
     * @return self
     */
    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     *
     * @return self
     */
    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * @return string
     */
    public function getPatronymic(): string
    {
        return $this->patronymic;
    }

    /**
     * @param string $patronymic
     *
     * @return self
     */
    public function setPatronymic(string $patronymic): self
    {
        $this->patronymic = $patronymic;

        return $this;
    }

    /**
     * @return string
     */
    public function getRole(): string
    {
        return $this->role;
    }

    /**
     * @param string $role
     *
     * @return self
     */
    public function setRole(string $role): self
    {
        $this->role = $role;

        return $this;
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
