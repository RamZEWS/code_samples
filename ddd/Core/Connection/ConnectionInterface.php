<?php

declare(strict_types=1);

namespace Core\Connection;

interface ConnectionInterface
{
    /**
     * @return void
     */
    public function connect(): void;

    /**
     * @return void
     */
    public function closeConnection(): void;

    /**
     * @param string $query
     *
     * @return array|null
     */
    public function executeQuery(string $query): ?array;

    /**
     * @return int
     */
    public function getLastId(): int;
}