<?php
/**
 * Copyright © Magmodules.eu. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Mollie\Subscriptions\Api\Data;

interface OrderMandateSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{
    /**
     * Get order_mandate list.
     * @return \Mollie\Subscriptions\Api\Data\OrderMandateInterface[]
     */
    public function getItems();

    /**
     * Set entity_id list.
     * @param \Mollie\Subscriptions\Api\Data\OrderMandateInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
