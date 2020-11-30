<?php
/**
 * Copyright © Magmodules.eu. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Mollie\Subscriptions\Model\Data;

use Magento\Framework\Api\AbstractExtensibleObject;
use Mollie\Subscriptions\Api\Data\CartItemSubscriptionInterface;

class CartItemSubscription extends AbstractExtensibleObject implements CartItemSubscriptionInterface
{
    /**
     * Get entity_id
     * @return string|null
     */
    public function getEntityId()
    {
        return $this->_get(static::ENTITY_ID);
    }

    /**
     * Set entity_id
     * @param string $entityId
     * @return \Mollie\Subscriptions\Api\Data\CartItemSubscriptionInterface
     */
    public function setEntityId($entityId)
    {
        return $this->setData(static::ENTITY_ID, $entityId);
    }

    /**
     * Get cart_item_id
     * @return string|null
     */
    public function getCartItemId()
    {
        return $this->_get(static::CART_ITEM_ID);
    }

    /**
     * Set cart_item_id
     * @param string $cartItemId
     * @return \Mollie\Subscriptions\Api\Data\CartItemSubscriptionInterface
     */
    public function setCartItemId($cartItemId)
    {
        return $this->setData(static::CART_ITEM_ID, $cartItemId);
    }

    /**
     * Get subscription_product_id
     * @return string|null
     */
    public function getSubscriptionProductId()
    {
        return $this->_get(static::SUBSCRIPTION_PRODUCT_ID);
    }

    /**
     * Set subscription_product_id
     * @param string $cartItemSubscriptionId
     * @return \Mollie\Subscriptions\Api\Data\CartItemSubscriptionInterface
     */
    public function setSubscriptionProductId($cartItemSubscriptionId)
    {
        return $this->setData(static::SUBSCRIPTION_PRODUCT_ID, $cartItemSubscriptionId);
    }

    /**
     * Retrieve existing extension attributes object or create a new one.
     * @return \Mollie\Subscriptions\Api\Data\CartItemSubscriptionExtensionInterface|null
     */
    public function getExtensionAttributes()
    {
        return $this->_getExtensionAttributes();
    }

    /**
     * Set an extension attributes object.
     * @param \Mollie\Subscriptions\Api\Data\CartItemSubscriptionExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \Mollie\Subscriptions\Api\Data\CartItemSubscriptionExtensionInterface $extensionAttributes
    ) {
        return $this->_setExtensionAttributes($extensionAttributes);
    }
}

