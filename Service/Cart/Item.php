<?php
/*
 * Copyright Magmodules.eu. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Mollie\Subscriptions\Service\Cart;

use Magento\Quote\Api\CartItemRepositoryInterface;
use Magento\Quote\Api\Data\CartExtensionInterfaceFactory;
use Magento\Quote\Api\Data\CartItemInterface;
use Mollie\Subscriptions\Api\Data\SubscriptionCartItemInterface;
use Mollie\Subscriptions\Api\Data\SubscriptionCartItemInterfaceFactory;
use Mollie\Subscriptions\Service\EcurringApi;

class Item
{
    /**
     * @var SubscriptionCartItemInterfaceFactory
     */
    private $subscriptionItem;

    /**
     * @var CartItemRepositoryInterface
     */
    private $cartItemRepository;

    /**
     * @var CartExtensionInterfaceFactory
     */
    private $cartExtensionFactory;

    /**
     * @var EcurringApi
     */
    private $ecurringApi;

    public function __construct(
        CartExtensionInterfaceFactory $cartExtensionFactory,
        CartItemRepositoryInterface $cartItemRepository,
        SubscriptionCartItemInterfaceFactory $subscriptionItem,
        EcurringApi $ecurringApi
    ) {
        $this->subscriptionItem = $subscriptionItem;
        $this->cartItemRepository = $cartItemRepository;
        $this->cartExtensionFactory = $cartExtensionFactory;
        $this->ecurringApi = $ecurringApi;
    }

    public function addMollieSubscriptToItem(CartItemInterface $item, $id)
    {
        /** @var SubscriptionCartItemInterface $subscriptionCartItem */
        $subscriptionCartItem = $this->subscriptionItem->create();
        $subscriptionCartItem->setId($id);
        $subscriptionCartItem->setPlan($this->ecurringApi->getSubscriptionPlanById($id));

        $attributes = $item->getExtensionAttributes() ?? $this->cartExtensionFactory->create();
        $attributes->setMollieSubscription($subscriptionCartItem);
        $item->setExtensionAttributes($attributes);
    }
}
