<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Mollie\Subscriptions\Api\Data;

interface SubscriptionToProductInterface extends \Magento\Framework\Api\ExtensibleDataInterface
{
    const ENTITY_ID = 'entity_id';
    const PRODUCT_ID = 'product_id';
    const SUBSCRIPTION_ID = 'subscription_id';

    /**
     * Get entity_id
     * @return string|null
     */
    public function getEntityId();

    /**
     * Set entity_id
     * @param string $entityId
     * @return \Mollie\Subscriptions\Api\Data\SubscriptionToProductInterface
     */
    public function setEntityId($entityId);

    /**
     * Get product_id
     * @return string|null
     */
    public function getProductId();

    /**
     * Set product_id
     * @param string $productId
     * @return \Mollie\Subscriptions\Api\Data\SubscriptionToProductInterface
     */
    public function setProductId($productId);

    /**
     * Get subscription_id
     * @return string|null
     */
    public function getSubscriptionId();

    /**
     * Set subscription_id
     * @param string $subscriptionId
     * @return \Mollie\Subscriptions\Api\Data\SubscriptionToProductInterface
     */
    public function setSubscriptionId($subscriptionId);

    /**
     * Retrieve existing extension attributes object or create a new one.
     * @return \Mollie\Subscriptions\Api\Data\SubscriptionToProductExtensionInterface|null
     */
    public function getExtensionAttributes();

    /**
     * Set an extension attributes object.
     * @param \Mollie\Subscriptions\Api\Data\SubscriptionToProductExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \Mollie\Subscriptions\Api\Data\SubscriptionToProductExtensionInterface $extensionAttributes
    );
}
