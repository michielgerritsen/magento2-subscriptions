<?php
/**
 * Copyright © Magmodules.eu. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Mollie\Subscriptions\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

interface OrderMandateRepositoryInterface
{

    /**
     * Save order_mandate
     * @param \Mollie\Subscriptions\Api\Data\OrderMandateInterface $orderMandate
     * @return \Mollie\Subscriptions\Api\Data\OrderMandateInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(
        \Mollie\Subscriptions\Api\Data\OrderMandateInterface $orderMandate
    );

    /**
     * Retrieve order_mandate
     * @param string $orderMandateId
     * @return \Mollie\Subscriptions\Api\Data\OrderMandateInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function get($orderMandateId);

    /**
     * Retrieve order_mandate matching the specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Mollie\Subscriptions\Api\Data\OrderMandateSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    );

    /**
     * Delete order_mandate
     * @param \Mollie\Subscriptions\Api\Data\OrderMandateInterface $orderMandate
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(
        \Mollie\Subscriptions\Api\Data\OrderMandateInterface $orderMandate
    );

    /**
     * Delete order_mandate by ID
     * @param string $orderMandateId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($orderMandateId);
}

