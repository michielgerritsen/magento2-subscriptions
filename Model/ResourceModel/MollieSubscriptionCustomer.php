<?php
/*
 * Copyright Magmodules.eu. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Mollie\Subscriptions\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class MollieSubscriptionCustomer extends AbstractDb
{
    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init('mollie_subscriptions_customer', 'entity_id');
    }
}
