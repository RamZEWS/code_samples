<?php

declare(strict_types=1);

namespace Modules\Cart\Service;

use Core\Helper\TextHelper;
use Modules\Cart\Entity\Cart;
use Modules\Cart\Repository\CartRepository;
use Modules\User\Entity\UserInterface;

class CartService
{
    /** @var CartRepository */
    private $cartRepository;

    /**
     * @param CartRepository $cartRepository
     */
    public function __construct(
        CartRepository $cartRepository
    ) {
        $this->cartRepository = $cartRepository;
    }

    /**
     * @param UserInterface $user
     *
     * @return Cart
     */
    public function getOrCreateByUser(UserInterface $user): Cart
    {
        $carts = $this->cartRepository->findBy([
            "user_id = {$user->getId()}"
        ]);

        if (count($carts) === 0) {
            $cart = (new Cart())
                ->setUserId($user->getId())
                ->setCartNumber(TextHelper::generateCartNumber())
            ;

            $this->cartRepository->save($cart);
        } else {
            $cart = current($carts);
        }

        return $cart;
    }

    public function addByProductId(int $productId)
    {

    }
}