<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Mollie\Subscriptions\Model\ResourceModel\CartItemSubscription;

use Mollie\Subscriptions\Model\CartItemSubscription;
use Mollie\Subscriptions\Model\ResourceModel\CartItemSubscription as ResourceModel;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    /**
     * @var string
     */
    protected $_idFieldName = 'entity_id';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(CartItemSubscription::class, ResourceModel::class);
    }
}

