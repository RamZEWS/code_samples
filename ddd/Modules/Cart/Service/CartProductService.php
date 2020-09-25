<?php

declare(strict_types=1);

namespace Modules\Cart\Service;

use Core\Exception\NotFoundException;
use Core\Exception\WrongArgumentException;
use Modules\Cart\Entity\Cart;
use Modules\Cart\Entity\CartProduct;
use Modules\Cart\Repository\CartProductRepository;
use Modules\Cart\Repository\CartRepository;
use Modules\Product\Entity\ProductInterface;
use Modules\User\Entity\UserInterface;

class CartProductService
{
    /** @var CartProductRepository */
    private $cartProductRepository;

    /** @var CartRepository */
    private $cartRepository;

    /** @var CartService */
    private $cartService;

    /**
     * @param CartProductRepository $cartProductRepository
     * @param CartRepository $cartRepository
     * @param CartService $cartService
     */
    public function __construct(
        CartProductRepository $cartProductRepository,
        CartRepository $cartRepository,
        CartService $cartService
    ) {
        $this->cartProductRepository = $cartProductRepository;
        $this->cartService = $cartService;
    }

    /**
     * @param Cart $cart
     *
     * @return CartProduct[]
     */
    public function getCartProductsByCart(Cart $cart): array
    {
        return $this->cartProductRepository->findBy([
            "cart_id = {$cart->getId()}"
        ]);
    }

    /**
     * @param UserInterface $user
     *
     * @return CartProduct[]
     */
    public function getCartProductsByUser(UserInterface $user): ?array
    {
        $cart = $this->cartService->getOrCreateByUser($user);

        return $this->cartProductRepository->findBy([
            "cart_id = {$cart->getId()}"
        ]);
    }

    /**
     * @param ProductInterface $product
     * @param UserInterface $user
     *
     * @return CartProduct
     *
     * @throws NotFoundException
     */
    public function getCartProductsByUserAndProduct(ProductInterface $product, UserInterface $user): CartProduct
    {
        $cart = $this->cartService->getOrCreateByUser($user);
        $cartProducts = $this->cartProductRepository->findBy([
            "cart_id = {$cart->getId()}",
            "product_id = {$product->getId()}"
        ]);

        if (count($cartProducts) === 0) {
            throw new NotFoundException('Product is not in cart');
        }

        return current($cartProducts);
    }

    /**
     * @param CartProduct $cartProduct
     */
    public function plusOne(CartProduct $cartProduct): void
    {
        $newQuantity = $cartProduct->getQuantity() + 1;

        $cartProduct->setQuantity($newQuantity);

        $this->cartProductRepository->save($cartProduct);
    }

    /**
     * @param CartProduct $cartProduct
     */
    public function minusOne(CartProduct $cartProduct): void
    {
        $newQuantity = $cartProduct->getQuantity() - 1;

        if ($newQuantity <= 0) {
            $this->cartProductRepository->delete($cartProduct);
        } else {
            $cartProduct->setQuantity($newQuantity);

            $this->cartProductRepository->save($cartProduct);
        }
    }

    /**
     * @param Cart $cart
     * @param ProductInterface $product
     *
     * @throws WrongArgumentException
     */
    public function addToCart(Cart $cart, ProductInterface $product): void
    {
        $cartProducts = $this->cartProductRepository->findBy([
            "cart_id = {$cart->getId()}",
            "product_id = {$product->getId()}"
        ]);

        if (count($cartProducts) !== 0) {
            throw new WrongArgumentException('Product already in cart');
        }

        $cartProduct = (new CartProduct())
            ->setCartId($cart->getId())
            ->setProductId($product->getId())
            ->setPrice($product->getPrice())
            ->setQuantity(1)
        ;

        $this->cartProductRepository->save($cartProduct);
    }

    /**
     * @param Cart $cart
     * @param ProductInterface $product
     *
     * @throws WrongArgumentException
     */
    public function removeFromCart(Cart $cart, ProductInterface $product): void
    {
        $cartProducts = $this->cartProductRepository->findBy([
            "cart_id = {$cart->getId()}",
            "product_id = {$product->getId()}"
        ]);

        if (count($cartProducts) === 0) {
            throw new WrongArgumentException('Product already is not in cart');
        }

        $cartProductIds = [];
        foreach ($cartProducts as $cartProduct) {
            $cartProductIds[] = $cartProduct->getId();
        }

        $this->cartProductRepository->deleteBy([
            'id IN (' . implode(', ', $cartProductIds) . ')'
        ]);
    }
}