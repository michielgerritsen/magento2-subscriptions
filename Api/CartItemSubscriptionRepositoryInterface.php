<?php
/**
 * Copyright © Magmodules.eu. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Mollie\Subscriptions\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Quote\Api\Data\CartItemInterface;

interface CartItemSubscriptionRepositoryInterface
{

    /**
     * Save cart_item_subscription
     * @param \Mollie\Subscriptions\Api\Data\CartItemSubscriptionInterface $cartItemSubscription
     * @return \Mollie\Subscriptions\Api\Data\CartItemSubscriptionInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(
        \Mollie\Subscriptions\Api\Data\CartItemSubscriptionInterface $cartItemSubscription
    );

    /**
     * Retrieve cart_item_subscription
     * @param string $cartItemSubscriptionId
     * @return \Mollie\Subscriptions\Api\Data\CartItemSubscriptionInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function get($cartItemSubscriptionId);

    /**
     * Retrieve cart_item_subscription
     * @param CartItemInterface $cartItem
     * @return \Mollie\Subscriptions\Api\Data\CartItemSubscriptionInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getByCartItem(CartItemInterface $cartItem);

    /**
     * Retrieve cart_item_subscription matching the specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Mollie\Subscriptions\Api\Data\CartItemSubscriptionSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    );

    /**
     * Delete cart_item_subscription
     * @param \Mollie\Subscriptions\Api\Data\CartItemSubscriptionInterface $cartItemSubscription
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(
        \Mollie\Subscriptions\Api\Data\CartItemSubscriptionInterface $cartItemSubscription
    );

    /**
     * Delete cart_item_subscription by ID
     * @param string $cartItemSubscriptionId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($cartItemSubscriptionId);
}

