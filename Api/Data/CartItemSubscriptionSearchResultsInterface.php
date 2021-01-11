<?php
/**
 * Copyright © Magmodules.eu. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Mollie\Subscriptions\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface CartItemSubscriptionSearchResultsInterface extends SearchResultsInterface
{

    /**
     * Get cart_item_subscription list.
     * @return \Mollie\Subscriptions\Api\Data\CartItemSubscriptionInterface[]
     */
    public function getItems();

    /**
     * Set entity_id list.
     * @param \Mollie\Subscriptions\Api\Data\CartItemSubscriptionInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
