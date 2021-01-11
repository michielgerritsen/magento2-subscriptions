<?php
/*
 * Copyright Magmodules.eu. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Mollie\Subscriptions\Observer\MollieProcessTransactionEnd;

use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Api\Data\CustomerExtensionFactory;
use Magento\Customer\Helper\Session\CurrentCustomer;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Sales\Api\Data\OrderInterface;
use Mollie\Subscriptions\Api\Data\OrderMandateInterface;
use Mollie\Subscriptions\Api\OrderMandateRepositoryInterface;
use Mollie\Subscriptions\Service\EcurringApi;

class CreateEcurringSubscription implements ObserverInterface
{
    /**
     * @var EcurringApi
     */
    private $ecurringApi;

    /**
     * @var OrderMandateRepositoryInterface
     */
    private $mandateRepository;

    /**
     * @var CurrentCustomer
     */
    private $currentCustomer;

    /**
     * @var CustomerRepositoryInterface
     */
    private $customerRepository;

    /**
     * @var CustomerExtensionFactory
     */
    private $extensionAttributesFactory;

    public function __construct(
        EcurringApi $ecurringApi,
        OrderMandateRepositoryInterface $mandateRepository,
        CurrentCustomer $currentCustomer,
        CustomerRepositoryInterface $customerRepository,
        CustomerExtensionFactory $extensionAttributesFactory
    ) {
        $this->ecurringApi = $ecurringApi;
        $this->mandateRepository = $mandateRepository;
        $this->currentCustomer = $currentCustomer;
        $this->customerRepository = $customerRepository;
        $this->extensionAttributesFactory = $extensionAttributesFactory;
    }

    public function execute(Observer $observer)
    {
        /** @var OrderInterface $order */
        $order = $observer->getData('order');

        try {
            $mandate = $this->mandateRepository->getByOrder($order);
        } catch (NoSuchEntityException $exception) {
            return;
        }

        $customerId = $this->getSubscriptionCustomerId($order, $mandate);
        $this->saveSubscriptionCustomerIdToCustomer($customerId);

        $this->ecurringApi->createMandate(
            $customerId,
            $mandate->getMandateId()
        );

        foreach (explode(',', $mandate->getSubscriptionProducts()) as $productId) {
            $this->ecurringApi->createActivatedSubscription(
                $customerId,
                $productId
            );
        }
    }

    private function saveSubscriptionCustomerIdToCustomer($id)
    {
        $customer = $this->currentCustomer->getCustomer();

        $extensionAttributes = $customer->getExtensionAttributes();
        if (!$extensionAttributes) {
            $extensionAttributes = $this->extensionAttributesFactory->create();
        }

        $extensionAttributes->setMollieSubscriptionCustomerId($id);
        $customer->setExtensionAttributes($extensionAttributes);

        $this->customerRepository->save($customer);
    }

    /**
     * @param OrderInterface $order
     * @param OrderMandateInterface $mandate
     * @throws NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     * @return string
     */
    private function getSubscriptionCustomerId(OrderInterface $order, OrderMandateInterface $mandate)
    {
        $customer = $this->customerRepository->getById($order->getCustomerId());

        if ($id = $customer->getExtensionAttributes()->getMollieSubscriptionCustomerId()) {
            return $id;
        }

        $customer = $this->ecurringApi->createCustomerFromAddress(
            $order->getBillingAddress(),
            $mandate->getCustomerId()
        );

        return $customer->getId();
    }
}
