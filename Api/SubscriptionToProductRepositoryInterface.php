<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Mollie\Subscriptions\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

interface SubscriptionToProductRepositoryInterface
{
    /**
     * Save subscription_to_product
     * @param \Mollie\Subscriptions\Api\Data\SubscriptionToProductInterface $subscriptionToProduct
     * @return \Mollie\Subscriptions\Api\Data\SubscriptionToProductInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(
        \Mollie\Subscriptions\Api\Data\SubscriptionToProductInterface $subscriptionToProduct
    );

    /**
     * Retrieve subscription_to_product
     * @param string $subscriptionToProductId
     * @return \Mollie\Subscriptions\Api\Data\SubscriptionToProductInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function get($subscriptionToProductId);

    /**
     * Retrieve subscription_to_product matching the specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Mollie\Subscriptions\Api\Data\SubscriptionToProductSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    );

    /**
     * Delete subscription_to_product
     * @param \Mollie\Subscriptions\Api\Data\SubscriptionToProductInterface $subscriptionToProduct
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(
        \Mollie\Subscriptions\Api\Data\SubscriptionToProductInterface $subscriptionToProduct
    );

    /**
     * Delete subscription_to_product by ID
     * @param string $subscriptionToProductId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($subscriptionToProductId);
}
