<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Mollie\Subscriptions\Model\Data;

use Magento\Framework\Api\AbstractExtensibleObject;
use Mollie\Subscriptions\Api\Data\SubscriptionToProductInterface;

class SubscriptionToProduct extends AbstractExtensibleObject implements SubscriptionToProductInterface
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
     * @param string $entity_id
     * @return \Mollie\Subscriptions\Api\Data\SubscriptionToProductInterface
     */
    public function setEntityId($entity_id)
    {
        return $this->setData(self::ENTITY_ID, $entity_id);
    }

    /**
     * Get product_id
     * @return string|null
     */
    public function getProductId()
    {
        return $this->_get(self::PRODUCT_ID);
    }

    /**
     * Set product_id
     * @param string $product_id
     * @return \Mollie\Subscriptions\Api\Data\SubscriptionToProductInterface
     */
    public function setProductId($product_id)
    {
        return $this->setData(self::PRODUCT_ID, $product_id);
    }

    /**
     * Get subscription_id
     * @return string|null
     */
    public function getSubscriptionId()
    {
        return $this->_get(self::SUBSCRIPTION_ID);
    }

    /**
     * Set subscription_id
     * @param string $subscription_id
     * @return \Mollie\Subscriptions\Api\Data\SubscriptionToProductInterface
     */
    public function setSubscriptionId($subscription_id)
    {
        return $this->setData(self::SUBSCRIPTION_ID, $subscription_id);
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

