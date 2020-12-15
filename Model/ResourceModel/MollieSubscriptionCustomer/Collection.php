<?php
/**
 * Copyright Magmodules.eu. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Mollie\Subscriptions\Model\ResourceModel\MollieSubscriptionCustomer;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            \Mollie\Subscriptions\Model\MollieSubscriptionCustomer::class,
            \Mollie\Subscriptions\Model\ResourceModel\MollieSubscriptionCustomer::class
        );
    }
}
