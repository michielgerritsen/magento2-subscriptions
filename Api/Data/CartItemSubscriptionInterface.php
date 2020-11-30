<?php
/**
 * Copyright © Magmodules.eu. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Mollie\Subscriptions\Api\Data;

interface CartItemSubscriptionInterface extends \Magento\Framework\Api\ExtensibleDataInterface
{
    const ENTITY_ID = 'entity_id';
    const CART_ITEM_ID = 'cart_item_id';
    const SUBSCRIPTION_PRODUCT_ID = 'subscription_product_id';

    /**
     * Get entity_id
     * @return string|null
     */
    public function getEntityId();

    /**
     * Set entity_id
     * @param string $entityId
     * @return \Mollie\Subscriptions\Api\Data\CartItemSubscriptionInterface
     */
    public function setEntityId($entityId);

    /**
     * Get cart_item_id
     * @return string|null
     */
    public function getCartItemId();

    /**
     * Set cart_item_id
     * @param string $cartItemId
     * @return \Mollie\Subscriptions\Api\Data\CartItemSubscriptionInterface
     */
    public function setCartItemId($cartItemId);

    /**
     * Get subscription_product_id
     * @return string|null
     */
    public function getSubscriptionProductId();

    /**
     * Set subscription_product_id
     * @param string $entityId
     * @return \Mollie\Subscriptions\Api\Data\CartItemSubscriptionInterface
     */
    public function setSubscriptionProductId($entityId);

    /**
     * Retrieve existing extension attributes object or create a new one.
     * @return \Mollie\Subscriptions\Api\Data\CartItemSubscriptionExtensionInterface|null
     */
    public function getExtensionAttributes();

    /**
     * Set an extension attributes object.
     * @param \Mollie\Subscriptions\Api\Data\CartItemSubscriptionExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \Mollie\Subscriptions\Api\Data\CartItemSubscriptionExtensionInterface $extensionAttributes
    );
}

