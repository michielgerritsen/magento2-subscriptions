<?php
/**
 * Copyright © Magmodules.eu. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Mollie\Subscriptions\Model;

use Magento\Framework\Model\Context;
use Magento\Framework\Registry;
use Mollie\Subscriptions\Api\Data\OrderMandateInterface;
use Mollie\Subscriptions\Api\Data\OrderMandateInterfaceFactory;
use Magento\Framework\Api\DataObjectHelper;
use Mollie\Subscriptions\Model\ResourceModel\OrderMandate\Collection;

class OrderMandate extends \Magento\Framework\Model\AbstractModel
{
    /**
     * @var OrderMandateInterfaceFactory
     */
    protected $orderMandateDataFactory;

    /**
     * @var DataObjectHelper
     */
    protected $dataObjectHelper;

    /**
     * @var string
     */
    protected $_eventPrefix = 'mollie_subscriptions_order_mandate';

    public function __construct(
        Context $context,
        Registry $registry,
        OrderMandateInterfaceFactory $order_mandateDataFactory,
        DataObjectHelper $dataObjectHelper,
        ResourceModel\OrderMandate $resource,
        Collection $resourceCollection,
        array $data = []
    ) {
        $this->orderMandateDataFactory = $order_mandateDataFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    /**
     * Retrieve order_mandate model with order_mandate data
     * @return OrderMandateInterface
     */
    public function getDataModel()
    {
        $order_mandateData = $this->getData();

        $order_mandateDataObject = $this->orderMandateDataFactory->create();
        $this->dataObjectHelper->populateWithArray(
            $order_mandateDataObject,
            $order_mandateData,
            OrderMandateInterface::class
        );

        return $order_mandateDataObject;
    }
}
