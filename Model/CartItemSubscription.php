<?php
/**
 * Copyright © Magmodules.eu. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Mollie\Subscriptions\Model;

use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\Context;
use Magento\Framework\Registry;
use Mollie\Subscriptions\Api\Data\CartItemSubscriptionInterface;
use Mollie\Subscriptions\Api\Data\CartItemSubscriptionInterfaceFactory;
use Mollie\Subscriptions\Model\ResourceModel\CartItemSubscription\Collection;

class CartItemSubscription extends AbstractModel
{
    /**
     * @var CartItemSubscriptionInterfaceFactory
     */
    protected $cart_item_subscriptionDataFactory;

    /**
     * @var DataObjectHelper
     */
    protected $dataObjectHelper;

    /**
     * @var string
     */
    protected $_eventPrefix = 'mollie_subscriptions_cart_item_subscription';

    public function __construct(
        Context $context,
        Registry $registry,
        CartItemSubscriptionInterfaceFactory $cart_item_subscriptionDataFactory,
        DataObjectHelper $dataObjectHelper,
        ResourceModel\CartItemSubscription $resource,
        Collection $resourceCollection,
        array $data = []
    ) {
        $this->cart_item_subscriptionDataFactory = $cart_item_subscriptionDataFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    /**
     * Retrieve cart_item_subscription model with cart_item_subscription data
     * @return CartItemSubscriptionInterface
     */
    public function getDataModel()
    {
        $cart_item_subscriptionData = $this->getData();

        $cart_item_subscriptionDataObject = $this->cart_item_subscriptionDataFactory->create();
        $this->dataObjectHelper->populateWithArray(
            $cart_item_subscriptionDataObject,
            $cart_item_subscriptionData,
            CartItemSubscriptionInterface::class
        );

        return $cart_item_subscriptionDataObject;
    }
}
