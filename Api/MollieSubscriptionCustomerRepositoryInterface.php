<?php
/**
 * Copyright Magmodules.eu. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Mollie\Subscriptions\Api;

use Magento\Customer\Api\Data\CustomerInterface;

interface MollieSubscriptionCustomerRepositoryInterface
{
    /**
     * Save Customer
     * @param \Mollie\Subscriptions\Api\Data\MollieSubscriptionCustomerInterface $customer
     * @return \Mollie\Subscriptions\Api\Data\MollieSubscriptionCustomerInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(
        \Mollie\Subscriptions\Api\Data\MollieSubscriptionCustomerInterface $customer
    );

    /**
     * Retrieve Customer
     * @param string $id
     * @return \Mollie\Subscriptions\Api\Data\MollieSubscriptionCustomerInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function get($id);

    /**
     * Retrieve Mollie Customer by Magento customer
     * @param \Magento\Customer\Api\Data\CustomerInterface $customer
     * @return \Mollie\Subscriptions\Api\Data\MollieSubscriptionCustomerInterface|null
     */
    public function getByCustomer(CustomerInterface $customer);

    /**
     * Retrieve Customer matching the specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Magento\Framework\Api\SearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    );

    /**
     * Delete Customer
     * @param \Mollie\Subscriptions\Api\Data\MollieSubscriptionCustomerInterface $customer
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(
        \Mollie\Subscriptions\Api\Data\MollieSubscriptionCustomerInterface $customer
    );

    /**
     * Delete Customer by ID
     * @param string $customerId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($customerId);
}
