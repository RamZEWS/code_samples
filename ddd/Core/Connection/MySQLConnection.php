<?php

declare(strict_types=1);

namespace Core\Connection;

class MySQLConnection implements ConnectionInterface
{
    /** @var string */
    private $host;

    /** @var int */
    private $port;

    /** @var string */
    private $login;

    /** @var $password */
    private $password;

    /**@var MysqlDriver */
    private $_mysqlDriver;

    /**
     * @param string $host
     * @param int $port
     * @param string $login
     * @param string $password
     */
    public function __construct(
        string $host,
        int $port,
        string $login,
        string $password
    ) {
        $this->host = $host;
        $this->port = $port;
        $this->login = $login;
        $this->password = $password;

        $this->_mysqlDriver = new MysqlDriver();
    }

    /**
     * @inheritDoc
     */
    public function connect(): void
    {
        $this->_mysqlDriver->connect(
            $this->host,
            $this->port,
            $this->login,
            $this->password
        );
    }

    /**
     * @inheritDoc
     */
    public function closeConnection(): void
    {
        $this->_mysqlDriver->closeConnection();
    }

    /**
     * @inheritDoc
     */
    public function executeQuery(string $query): ?array
    {
        return $this->_mysqlDriver->execute($query);
    }

    /**
     * @return int
     */
    public function getLastId(): int
    {
        return $this->_mysqlDriver->getLastInsertedId();
    }
}