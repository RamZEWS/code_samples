<?php

declare(strict_types=1);

namespace Modules\Product\Service;

use Core\Entity\EntityInterface;
use Core\Exception\NotFoundException;
use Core\Exception\WrongArgumentException;
use Modules\Product\Entity\ProductInterface;
use Modules\Product\Repository\ProductRepository;

class ProductService
{
    /** @var ProductRepository */
    private $productRepository;

    /**
     * @param ProductRepository $productRepository
     */
    public function __construct(
        ProductRepository $productRepository
    ) {
        $this->productRepository = $productRepository;
    }

    /**
     * @param int $productId
     *
     * @return ProductInterface
     *
     * @throws NotFoundException
     * @throws WrongArgumentException
     */
    public function getById(int $productId): EntityInterface
    {
        if ($productId <= 0) {
            throw new WrongArgumentException('productId <= 0');
        }

        $product = $this->productRepository->findById($productId);
        if ($product === null) {
            throw new NotFoundException('Product is not found');
        }

        return $product;
    }
}