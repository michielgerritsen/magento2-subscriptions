<?php
/*
 * Copyright Magmodules.eu. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Mollie\Subscriptions\Plugin\CartItem;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Quote\Api\CartRepositoryInterface;
use Magento\Quote\Api\Data\CartInterface;
use Magento\Quote\Api\Data\CartItemInterface;
use Mollie\Subscriptions\Api\CartItemSubscriptionRepositoryInterface;
use Mollie\Subscriptions\Api\Data\CartItemSubscriptionInterface;
use Mollie\Subscriptions\Api\Data\CartItemSubscriptionInterfaceFactory;

class SaveSelectedOption
{
    /**
     * @var CartItemSubscriptionRepositoryInterface
     */
    private $repository;

    /**
     * @var CartItemSubscriptionInterfaceFactory
     */
    private $factory;

    public function __construct(
        CartItemSubscriptionRepositoryInterface $repository,
        CartItemSubscriptionInterfaceFactory $factory
    ) {
        $this->repository = $repository;
        $this->factory = $factory;
    }

    public function aroundSave(CartRepositoryInterface $subject, Callable $proceed, CartInterface $quote)
    {
        $result = $proceed($quote);

        foreach ($quote->getItems() as $item) {
            $this->handleItem($item);
        }

        return $result;
    }

    private function handleItem(CartItemInterface $item)
    {
        if (!$item->getExtensionAttributes() || !$item->getExtensionAttributes()->getMollieSubscription()) {
            return;
        }

        if ($item->getExtensionAttributes()->getMollieSubscription()) {
            $this->save($item);
        }
    }

    /**
     * @param CartItemInterface $result
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    private function save(CartItemInterface $result): void
    {
        $subscription = $result->getExtensionAttributes()->getMollieSubscription();

        $model = $this->getCartItemSubscription($result);
        $model->setSubscriptionProductId($subscription->getId());
        $this->repository->save($model);
    }

    private function getCartItemSubscription(CartItemInterface $cartItem): CartItemSubscriptionInterface
    {
        try {
            return $this->repository->getByCart($cartItem);
        } catch (NoSuchEntityException $exception) {
            $model = $this->factory->create();
            $model->setCartItemId($cartItem->getItemId());

            return $model;
        }
    }
}