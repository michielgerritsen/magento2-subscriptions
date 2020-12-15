<?php
/**
 * Copyright © Magmodules.eu. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Mollie\Subscriptions\Model\Data;

use Magento\Framework\Api\AbstractExtensibleObject;
use Mollie\Subscriptions\Api\Data\OrderMandateInterface;

class OrderMandate extends AbstractExtensibleObject implements OrderMandateInterface
{
    /**
     * Get entity_id
     * @return string|null
     */
    public function getEntityId()
    {
        return $this->_get(self::ENTITY_ID);
    }

    /**
     * Set entity_id
     * @param string $entityId
     * @return \Mollie\Subscriptions\Api\Data\OrderMandateInterface
     */
    public function setEntityId($entityId)
    {
        return $this->setData(self::ENTITY_ID, $entityId);
    }

    /**
     * Get order_id
     * @return string|null
     */
    public function getOrderId()
    {
        return $this->_get(self::ORDER_ID);
    }

    /**
     * Set order_id
     * @param string $orderId
     * @return \Mollie\Subscriptions\Api\Data\OrderMandateInterface
     */
    public function setOrderId($orderId)
    {
        return $this->setData(self::ORDER_ID, $orderId);
    }

    /**
     * Get customer_id
     * @return string|null
     */
    public function getCustomerId()
    {
        return $this->_get(self::CUSTOMER_ID);
    }

    /**
     * Set customer_id
     * @param string $customerId
     * @return \Mollie\Subscriptions\Api\Data\OrderMandateInterface
     */
    public function setCustomerId($customerId)
    {
        return $this->setData(self::CUSTOMER_ID, $customerId);
    }

    /**
     * Get mandate_id
     * @return string|null
     */
    public function getMandateId()
    {
        return $this->_get(self::MANDATE_ID);
    }

    /**
     * Set mandate_id
     * @param string $mandateId
     * @return \Mollie\Subscriptions\Api\Data\OrderMandateInterface
     */
    public function setMandateId($mandateId)
    {
        return $this->setData(self::MANDATE_ID, $mandateId);
    }

    /**
     * Get subscription_products
     * @return string|null
     */
    public function getSubscriptionProducts()
    {
        return $this->_get(self::SUBSCRIPTION_PRODUCTS);
    }

    /**
     * Set subscription_products
     * @param string $subscriptionProducts
     * @return \Mollie\Subscriptions\Api\Data\OrderMandateInterface
     */
    public function setSubscriptionProducts($subscriptionProducts)
    {
        return $this->setData(self::SUBSCRIPTION_PRODUCTS, $subscriptionProducts);
    }

    /**
     * Retrieve existing extension attributes object or create a new one.
     * @return \Mollie\Subscriptions\Api\Data\OrderMandateExtensionInterface|\Magento\Framework\Api\ExtensionAttributesInterface|null
     */
    public function getExtensionAttributes()
    {
        return $this->_getExtensionAttributes();
    }

    /**
     * Set an extension attributes object.
     * @param \Mollie\Subscriptions\Api\Data\OrderMandateExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \Mollie\Subscriptions\Api\Data\OrderMandateExtensionInterface $extensionAttributes
    ) {
        return $this->_setExtensionAttributes($extensionAttributes);
    }
}

