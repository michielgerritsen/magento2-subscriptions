<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Mollie\Subscriptions\Model\Data;

use Mollie\Subscriptions\Api\Data\SubscriptionToProductInterface;

class SubscriptionToProduct extends \Magento\Framework\Api\AbstractExtensibleObject implements SubscriptionToProductInterface
{

    /**
     * Get subscription_to_product_id
     * @return string|null
     */
    public function getSubscriptionToProductId()
    {
        return $this->_get(self::SUBSCRIPTION_TO_PRODUCT_ID);
    }

    /**
     * Set subscription_to_product_id
     * @param string $subscriptionToProductId
     * @return \Mollie\Subscriptions\Api\Data\SubscriptionToProductInterface
     */
    public function setSubscriptionToProductId($subscriptionToProductId)
    {
        return $this->setData(self::SUBSCRIPTION_TO_PRODUCT_ID, $subscriptionToProductId);
    }

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
     * @return \Mollie\Subscriptions\Api\Data\SubscriptionToProductInterface
     */
    public function setEntityId($entityId)
    {
        return $this->setData(self::ENTITY_ID, $entityId);
    }

    /**
     * Retrieve existing extension attributes object or create a new one.
     * @return \Mollie\Subscriptions\Api\Data\SubscriptionToProductExtensionInterface|null
     */
    public function getExtensionAttributes()
    {
        return $this->_getExtensionAttributes();
    }

    /**
     * Set an extension attributes object.
     * @param \Mollie\Subscriptions\Api\Data\SubscriptionToProductExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \Mollie\Subscriptions\Api\Data\SubscriptionToProductExtensionInterface $extensionAttributes
    ) {
        return $this->_setExtensionAttributes($extensionAttributes);
    }
}

