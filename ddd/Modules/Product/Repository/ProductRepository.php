<?php

declare(strict_types=1);

namespace Modules\Product\Repository;

use Core\Repository\BaseRepository;

class ProductRepository extends BaseRepository
{
    /**
     * @return string
     */
    public function getTableName(): string
    {
        return 'product';
    }
}