<?php
/**
 * Copyright © Magmodules.eu. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Mollie\Subscriptions\Api\Data;

interface OrderMandateInterface extends \Magento\Framework\Api\ExtensibleDataInterface
{
    const ENTITY_ID = 'entity_id';
    const ORDER_ID = 'order_id';
    const CUSTOMER_ID = 'customer_id';
    const MANDATE_ID = 'mandate_id';
    const SUBSCRIPTION_PRODUCTS = 'subscription_products';

    /**
     * Get entity_id
     * @return string|null
     */
    public function getEntityId();

    /**
     * Set entity_id
     * @param string $entityId
     * @return \Mollie\Subscriptions\Api\Data\OrderMandateInterface
     */
    public function setEntityId($entityId);

    /**
     * Get order_id
     * @return string|null
     */
    public function getOrderId();

    /**
     * Set order_id
     * @param string $orderId
     * @return \Mollie\Subscriptions\Api\Data\OrderMandateInterface
     */
    public function setOrderId($orderId);

    /**
     * Get customer_id
     * @return string|null
     */
    public function getCustomerId();

    /**
     * Set customer_id
     * @param string $customerId
     * @return \Mollie\Subscriptions\Api\Data\OrderMandateInterface
     */
    public function setCustomerId($customerId);

    /**
     * Get mandate_id
     * @return string|null
     */
    public function getMandateId();

    /**
     * Set mandate_id
     * @param string $mandateId
     * @return \Mollie\Subscriptions\Api\Data\OrderMandateInterface
     */
    public function setMandateId($mandateId);

    /**
     * Get subscription_products
     * @return string|null
     */
    public function getSubscriptionProducts();

    /**
     * Set subscription_products
     * @param string $subscriptionProducts
     * @return \Mollie\Subscriptions\Api\Data\OrderMandateInterface
     */
    public function setSubscriptionProducts($subscriptionProducts);

    /**
     * Retrieve existing extension attributes object or create a new one.
     * @return \Mollie\Subscriptions\Api\Data\OrderMandateExtensionInterface|null
     */
    public function getExtensionAttributes();

    /**
     * Set an extension attributes object.
     * @param \Mollie\Subscriptions\Api\Data\OrderMandateExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \Mollie\Subscriptions\Api\Data\OrderMandateExtensionInterface $extensionAttributes
    );
}

