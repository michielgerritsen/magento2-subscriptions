<?php
/**
 * Copyright Magmodules.eu. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Mollie\Subscriptions\Plugin\Customer;

use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Api\Data\CustomerInterface;
use Mollie\Subscriptions\Api\Data\MollieSubscriptionCustomerInterface;
use Mollie\Subscriptions\Api\Data\MollieSubscriptionCustomerInterfaceFactory;
use Mollie\Subscriptions\Api\MollieSubscriptionCustomerRepositoryInterface;

class SubscriptionCustomerId
{
    /**
     * @var MollieSubscriptionCustomerRepositoryInterface
     */
    private $repository;

    /**
     * @var MollieSubscriptionCustomerInterfaceFactory
     */
    private $mollieSubscriptionCustomerFactory;

    public function __construct(
        MollieSubscriptionCustomerRepositoryInterface $repository,
        MollieSubscriptionCustomerInterfaceFactory $mollieCustomerFactory
    ) {
        $this->repository = $repository;
        $this->mollieSubscriptionCustomerFactory = $mollieCustomerFactory;
    }

    public function aroundSave(
        CustomerRepositoryInterface $subject,
        callable $proceed,
        CustomerInterface $customer,
        $passwordHash = null
    ) {
        $extensionAttributes = $customer->getExtensionAttributes();
        if (!$extensionAttributes) {
            return $proceed($customer, $passwordHash);
        }

        $mollieId = $extensionAttributes->getMollieSubscriptionCustomerId();
        $result = $proceed($customer, $passwordHash);

        if (!$mollieId) {
            return $result;
        }

        $mollieCustomer = $this->getCustomerModel($customer);
        $mollieCustomer->setMollieSubscriptionCustomerId($mollieId);

        $this->repository->save($mollieCustomer);

        return $result;
    }

    public function afterGet(CustomerRepositoryInterface $subject, CustomerInterface $customer)
    {
        $this->retrieveForCustomer($customer);

        return $customer;
    }

    public function afterGetById(CustomerRepositoryInterface $subject, CustomerInterface $customer)
    {
        $this->retrieveForCustomer($customer);

        return $customer;
    }

    /**
     * @param CustomerInterface $customer
     * @return MollieSubscriptionCustomerInterface
     */
    private function getCustomerModel(CustomerInterface $customer)
    {
        if ($mollieCustomer = $this->repository->getByCustomer($customer)) {
            return $mollieCustomer;
        }

        /** @var MollieSubscriptionCustomerInterface $mollieCustomer */
        $mollieCustomer = $this->mollieSubscriptionCustomerFactory->create();
        $mollieCustomer->setCustomerId($customer->getId());

        return $mollieCustomer;
    }

    private function retrieveForCustomer(CustomerInterface $customer)
    {
        $extensionAttributes = $customer->getExtensionAttributes();
        if (!$extensionAttributes) {
            return $customer;
        }

        $model = $this->repository->getByCustomer($customer);

        if ($model) {
            $extensionAttributes->setMollieSubscriptionCustomerId($model->getMollieSubscriptionCustomerId());
        }
    }
}
