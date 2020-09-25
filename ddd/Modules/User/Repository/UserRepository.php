<?php

declare(strict_types=1);

namespace Modules\User\Repository;

use Core\Repository\BaseRepository;

class UserRepository extends BaseRepository
{
    /**
     * @inheritDoc
     */
    public function getTableName(): string
    {
        return 'user';
    }
}