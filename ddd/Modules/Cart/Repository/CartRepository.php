<?php

declare(strict_types=1);

namespace Modules\Cart\Repository;

use Core\Repository\BaseRepository;

class CartRepository extends BaseRepository
{
    /**
     * @inheritDoc
     */
    public function getTableName(): string
    {
        return 'cart';
    }
}