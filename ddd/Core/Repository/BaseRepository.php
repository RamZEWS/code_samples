<?php

declare(strict_types=1);

namespace Core\Repository;

use Core\Connection\ConnectionInterface;
use Core\Entity\BaseEntity;
use Core\Entity\EntityInterface;
use Core\Helper\TextHelper;

class BaseRepository implements RepositoryInterface
{
    /** @var ConnectionInterface */
    protected $connection;

    /**
     * @inheritDoc
     */
    public function getTableName(): string
    {
        return '';
    }

    /**
     * @inheritDoc
     */
    public function findAll(): ?array
    {
        $sql = "SELECT * FROM {$this->getTableName()};";

        $rows = $this->connection->executeQuery($sql);

        $entities = [];
        foreach ($rows as $row) {
            $entities[] = $this->fillEntityByArray($row, new BaseEntity());
        }

        return $entities;
    }

    /**
     * @inheritDoc
     */
    public function findById(int $id): ?EntityInterface
    {
        $sql = "SELECT * FROM {$this->getTableName()} WHERE id = {$id};";

        $rows = $this->connection->executeQuery($sql);

        return $this->fillEntityByArray(current($rows), new BaseEntity());
    }

    /**
     * @inheritDoc
     */
    public function findBy(array $where, array $orderBy = [], int $offset = 0, int $limit = 0): ?array
    {
        $whereAsString = implode(' AND ', $where);

        $orderByAsString = '';
        if (count($orderBy) !== 0) {
            $orderByAsString = 'ORDER BY ' . implode(', ', $orderBy);
        }

        $limitAsString = '';
        if ($limit !== 0) {
            $limitAsString = 'LIMIT ';
            if ($offset !== 0) {
                $limitAsString .= "{$offset}, ";
            }

            $limitAsString .= $limit;
        }

        $sql = "
            SELECT *
            FROM {$this->getTableName()}
            WHERE {$whereAsString}
            {$orderByAsString}
            {$limitAsString}
        ";

        $rows = $this->connection->executeQuery($sql);

        $entities = [];
        foreach ($rows as $row) {
            $entities[] = $this->fillEntityByArray($row, new BaseEntity());
        }

        return $entities;
    }

    /**
     * @inheritDoc
     */
    public function insert(EntityInterface $entity): void
    {
        $sql = "
            INSERT INTO {$this->getTableName()} 
            ({$this->prepareEntityKeysForInsert($entity)}) 
            VALUES 
            ({$this->prepareEntityValuesForInsert($entity)})
            ;
        ";

        $this->connection->executeQuery($sql);

        $entity->setId($this->connection->getLastId());
    }

    /**
     * @inheritDoc
     */
    public function update(EntityInterface $entity): void
    {
        $sql = "
            UPDATE {$this->getTableName()} 
            SET {$this->prepareEntityForUpdate($entity)} 
            WHERE id = {$entity->getId()}
            ;
        ";

        $this->connection->executeQuery($sql);
    }

    /**
     * @inheritDoc
     */
    public function delete(EntityInterface $entity): void
    {
        $sql = "DELETE FROM {$this->getTableName()} WHERE id = {$entity->getId()};";

        $this->connection->executeQuery($sql);
    }

    /**
     * @inheritDoc
     */
    public function deleteBy(array $where): void
    {
        $whereStr = implode(' AND ', $where);

        $sql = "DELETE FROM {$this->getTableName()} WHERE {$whereStr};";

        $this->connection->executeQuery($sql);
    }

    /**
     * @param EntityInterface $entity
     *
     * @return string
     */
    public function prepareEntityKeysForInsert(EntityInterface $entity): string
    {
        $classVariables = get_class_vars(get_class($entity));

        $keysForInsert = [];
        foreach ($classVariables as $key => $value) {
            $keysForInsert[] = TextHelper::camelToUnderscore($key);
        }

        return implode(', ', $keysForInsert);
    }

    /**
     * @param EntityInterface $entity
     *
     * @return string
     */
    public function prepareEntityValuesForInsert(EntityInterface $entity): string
    {
        $classVariables = get_class_vars(get_class($entity));

        $valuesForInsert = [];
        foreach ($classVariables as $key => $value) {
            $updateFields[] = $value;
        }

        return implode(', ', $valuesForInsert);
    }

    /**
     * @param EntityInterface $entity
     *
     * @return string
     */
    public function prepareEntityForUpdate(EntityInterface $entity): string
    {
        $classVariables = get_class_vars(get_class($entity));

        $updateFields = [];
        foreach ($classVariables as $key => $value) {
            $dbKey = TextHelper::camelToUnderscore($key);
            $updateFields[] = "{$dbKey} = {$value}";
        }

        return implode(', ', $updateFields);
    }

    /**
     * @param array $row
     * @param EntityInterface $entity
     *
     * @return EntityInterface
     */
    public function fillEntityByArray(array $row, EntityInterface $entity): EntityInterface
    {
        foreach ($row as $key => $value) {
            $methodName = "set" . str_replace(' ', '', ucwords(str_replace('_', ' ', $key)));
            if (method_exists($entity, $methodName)) {
                $entity->$methodName($value);
            }
        }

        return $entity;
    }

    public function save(EntityInterface $entity): void
    {
        if ($entity->getId() !== 0) {
            $this->update($entity);
        } else {
            $this->insert($entity);
        }
    }
}