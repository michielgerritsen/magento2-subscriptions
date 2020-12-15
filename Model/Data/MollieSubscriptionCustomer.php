<?php
/**
 * Copyright Magmodules.eu. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Mollie\Subscriptions\Model\Data;

use Magento\Framework\Api\AbstractExtensibleObject;
use Mollie\Subscriptions\Api\Data\MollieSubscriptionCustomerInterface;

class MollieSubscriptionCustomer extends AbstractExtensibleObject implements MollieSubscriptionCustomerInterface
{
    /**
     * Get customer_id
     * @return string|null
     */
    public function getEntityId()
    {
        return $this->_get(self::ENTITY_ID);
    }

    /**
     * Set entity_id
     * @param string $entityId
     * @return \Mollie\Subscriptions\Api\Data\MollieSubscriptionCustomerInterface
     */
    public function setEntityId($entityId)
    {
        return $this->setData(self::ENTITY_ID, $entityId);
    }

    /**
     * Get customer_id
     * @return int|null
     */
    public function getCustomerId()
    {
        return $this->_get(self::CUSTOMER_ID);
    }

    /**
     * Set customer_id
     * @param int $customerId
     * @return \Mollie\Subscriptions\Api\Data\MollieSubscriptionCustomerInterface
     */
    public function setCustomerId($customerId)
    {
        return $this->setData(self::CUSTOMER_ID, $customerId);
    }

    /**
     * Get customer_id
     * @return int|null
     */
    public function getMollieSubscriptionCustomerId()
    {
        return $this->_get(self::MOLLIE_SUBSCRIPTION_CUSTOMER_ID);
    }

    /**
     * Set customer_id
     * @param int $mollieSubscriptionCustomerId
     * @return \Mollie\Subscriptions\Api\Data\MollieSubscriptionCustomerInterface
     */
    public function setMollieSubscriptionCustomerId($mollieSubscriptionCustomerId)
    {
        return $this->setData(self::MOLLIE_SUBSCRIPTION_CUSTOMER_ID, $mollieSubscriptionCustomerId);
    }

    /**
     * Retrieve existing extension attributes object or create a new one.
     * @return \Mollie\Subscriptions\Api\Data\MollieSubscriptionCustomerExtensionInterface|null
     */
    public function getExtensionAttributes()
    {
        return $this->_getExtensionAttributes();
    }

    /**
     * Set an extension attributes object.
     * @param \Mollie\Subscriptions\Api\Data\MollieSubscriptionCustomerExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \Mollie\Subscriptions\Api\Data\MollieSubscriptionCustomerExtensionInterface $extensionAttributes
    ) {
        return $this->_setExtensionAttributes($extensionAttributes);
    }
}
