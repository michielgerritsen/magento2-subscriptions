<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Mollie\Subscriptions\Model;

use Magento\Framework\Api\DataObjectHelper;
use Mollie\Subscriptions\Api\Data\SubscriptionToProductInterface;
use Mollie\Subscriptions\Api\Data\SubscriptionToProductInterfaceFactory;

class SubscriptionToProduct extends \Magento\Framework\Model\AbstractModel
{
    /**
     * @var SubscriptionToProductInterfaceFactory
     */
    protected $subscription_to_productDataFactory;

    /**
     * @var DataObjectHelper
     */
    protected $dataObjectHelper;

    /**
     * @var string
     */
    protected $_eventPrefix = 'mollie_subscriptions_subscription_to_product';

    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        SubscriptionToProductInterfaceFactory $subscription_to_productDataFactory,
        DataObjectHelper $dataObjectHelper,
        \Mollie\Subscriptions\Model\ResourceModel\SubscriptionToProduct $resource,
        \Mollie\Subscriptions\Model\ResourceModel\SubscriptionToProduct\Collection $resourceCollection,
        array $data = []
    ) {
        $this->subscription_to_productDataFactory = $subscription_to_productDataFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    /**
     * Retrieve subscription_to_product model with subscription_to_product data
     * @return SubscriptionToProductInterface
     */
    public function getDataModel()
    {
        $subscription_to_productData = $this->getData();

        $subscription_to_productDataObject = $this->subscription_to_productDataFactory->create();
        $this->dataObjectHelper->populateWithArray(
            $subscription_to_productDataObject,
            $subscription_to_productData,
            SubscriptionToProductInterface::class
        );

        return $subscription_to_productDataObject;
    }
}
