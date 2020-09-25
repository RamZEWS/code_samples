<?php

declare(strict_types=1);

namespace Modules\Cart\Repository;

use Core\Repository\BaseRepository;

class CartProductRepository extends BaseRepository
{
    /**
     * @inheritDoc
     */
    public function getTableName(): string
    {
        return 'cart_product';
    }
}