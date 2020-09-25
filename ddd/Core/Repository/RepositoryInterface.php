<?php

declare(strict_types=1);

namespace Core\Repository;

use Core\Entity\EntityInterface;

interface RepositoryInterface
{
    /**
     * @return string
     */
    public function getTableName(): string;

    /**
     * @return array|EntityInterface[]
     */
    public function findAll(): ?array;

    /**
     * @param int $id
     *
     * @return EntityInterface|null
     */
    public function findById(int $id): ?EntityInterface;

    /**
     * @param array $where
     * @param array $orderBy
     * @param int $offset
     * @param int $limit
     *
     * @return array|EntityInterface[]|null
     */
    public function findBy(array $where, array $orderBy = [], int $offset = 0, int $limit = 0): ?array;

    /**
     * @param EntityInterface $entity
     */
    public function insert(EntityInterface $entity): void;

    /**
     * @param EntityInterface $entity
     */
    public function update(EntityInterface $entity): void;

    /**
     * @param EntityInterface $entity
     */
    public function delete(EntityInterface $entity): void;

    /**
     * @param array $where
     */
    public function deleteBy(array $where): void;
}