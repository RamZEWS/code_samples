<?php

declare(strict_types=1);

namespace Modules\Cart\Controller;

use Core\Controller\BaseAjaxController;
use Core\Exception\NotFoundException;
use Core\Exception\WrongArgumentException;
use JsonException;
use Modules\Cart\Service\CartProductService;
use Modules\Cart\Service\CartService;
use Modules\Product\Service\ProductService;
use Modules\User\Service\UserService;

class AjaxController extends BaseAjaxController
{
    /** @var CartService */
    private $cartService;

    /** @var CartProductService */
    private $cartProductService;

    /** @var ProductService */
    private $productService;

    /** @var UserService */
    private $userService;

    /**
     * @param CartService $cartService
     * @param CartProductService $cartProductService
     * @param ProductService $productService
     * @param UserService $userService
     */
    public function __construct(
        CartService $cartService,
        CartProductService $cartProductService,
        ProductService $productService,
        UserService $userService
    ) {
        $this->cartService = $cartService;
        $this->cartProductService = $cartProductService;
        $this->productService = $productService;
        $this->userService = $userService;
    }

    /**
     * @param int $productId
     *
     * @return string
     *
     * @throws NotFoundException
     * @throws WrongArgumentException
     * @throws JsonException
     */
    public function addToCart(int $productId): string
    {
        $product = $this->productService->getById($productId);
        $cart = $this->cartService->getOrCreateByUser(
            $this->userService->getCurrentUser()
        );

        try {
            $this->cartProductService->addToCart($cart, $product);

            $this->responseBody['isSuccess'] = true;
        } catch (WrongArgumentException $e) {
            $this->responseBody['isSuccess'] = false;
        }

        return $this->sendResponse();
    }

    /**
     * @param int $productId
     *
     * @return string
     *
     * @throws JsonException
     * @throws NotFoundException
     * @throws WrongArgumentException
     */
    public function removeProductFromCart(int $productId): string
    {
        $product = $this->productService->getById($productId);
        $cart = $this->cartService->getOrCreateByUser(
            $this->userService->getCurrentUser()
        );

        try {
            $this->cartProductService->removeFromCart($cart, $product);

            $this->responseBody['isSuccess'] = true;
        } catch (WrongArgumentException $e) {
            $this->responseBody['isSuccess'] = false;
        }

        return $this->sendResponse();
    }

    /**
     * @param int $productId
     *
     * @return string
     *
     * @throws JsonException
     * @throws NotFoundException
     * @throws WrongArgumentException
     */
    public function plusOne(int $productId): string
    {
        $product = $this->productService->getById($productId);
        $cartProduct = $this->cartProductService->getCartProductsByUserAndProduct(
            $product,
            $this->userService->getCurrentUser()
        );

        try {
            $this->cartProductService->plusOne($cartProduct);

            $this->responseBody['isSuccess'] = true;
        } catch (WrongArgumentException $e) {
            $this->responseBody['isSuccess'] = false;
        }

        return $this->sendResponse();
    }

    /**
     * @param int $productId
     *
     * @return string
     *
     * @throws JsonException
     * @throws NotFoundException
     * @throws WrongArgumentException
     */
    public function minusOne(int $productId): string
    {
        $product = $this->productService->getById($productId);
        $cartProduct = $this->cartProductService->getCartProductsByUserAndProduct(
            $product,
            $this->userService->getCurrentUser()
        );

        try {
            $this->cartProductService->minusOne($cartProduct);

            $this->responseBody['isSuccess'] = true;
        } catch (WrongArgumentException $e) {
            $this->responseBody['isSuccess'] = false;
        }

        return $this->sendResponse();
    }
}