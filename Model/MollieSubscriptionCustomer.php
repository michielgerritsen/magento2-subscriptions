<?php
/**
 * Copyright Magmodules.eu. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Mollie\Subscriptions\Model;

use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\Context;
use Magento\Framework\Registry;
use Mollie\Subscriptions\Api\Data\MollieSubscriptionCustomerInterface;
use Mollie\Subscriptions\Api\Data\MollieSubscriptionCustomerInterfaceFactory;
use Magento\Framework\Api\DataObjectHelper;
use Mollie\Subscriptions\Model\ResourceModel\MollieSubscriptionCustomer\Collection;

class MollieSubscriptionCustomer extends AbstractModel
{
    /**
     * @var MollieSubscriptionCustomerInterfaceFactory
     */
    protected $customerDataFactory;

    /**
     * @var DataObjectHelper
     */
    protected $dataObjectHelper;

    /**
     * @var string
     */
    protected $_eventPrefix = 'mollie_payment_customer';

    /**
     * @param Context $context
     * @param Registry $registry
     * @param MollieSubscriptionCustomerInterfaceFactory $customerDataFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param ResourceModel\MollieSubscriptionCustomer $resource
     * @param Collection $resourceCollection
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        MollieSubscriptionCustomerInterfaceFactory $customerDataFactory,
        DataObjectHelper $dataObjectHelper,
        ResourceModel\MollieSubscriptionCustomer $resource,
        Collection $resourceCollection,
        array $data = []
    ) {
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);

        $this->customerDataFactory = $customerDataFactory;
        $this->dataObjectHelper = $dataObjectHelper;
    }

    /**
     * Retrieve customer model with customer data
     * @return MollieSubscriptionCustomerInterface
     */
    public function getDataModel()
    {
        $customerData = $this->getData();

        $customerDataObject = $this->customerDataFactory->create();
        $this->dataObjectHelper->populateWithArray(
            $customerDataObject,
            $customerData,
            MollieSubscriptionCustomerInterface::class
        );

        return $customerDataObject;
    }
}
