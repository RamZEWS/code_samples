<?php

declare(strict_types=1);

namespace Modules\User\Service;

use Modules\Cart\Repository\CartRepository;
use Modules\Cart\Service\CartProductService;
use Modules\User\Entity\UserInterface;

class UserCartService
{
    /** @var CartProductService */
    private $cartProductService;

    /**
     * @param CartRepository $cartRepository
     */
    public function __construct(
        CartProductService $cartProductService
    ) {
        $this->cartProductService = $cartProductService;
    }


    public function clearCart(UserInterface $user)
    {

    }

    public function getCart(UserInterface $user)
    {

    }
}