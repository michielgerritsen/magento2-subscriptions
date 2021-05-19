<?php
/*
 * Copyright Magmodules.eu. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Mollie\Subscriptions\Observer\MollieProcessResponse;

use Magento\Framework\Event\ManagerInterface;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Sales\Api\Data\OrderInterface;
use Mollie\Api\MollieApiClient;
use Mollie\Api\Resources\Order as MollieOrder;
use Mollie\Payment\Config;
use Mollie\Payment\Model\Mollie;
use Mollie\Subscriptions\Api\Data\SubscriptionToProductInterface;
use Mollie\Subscriptions\Api\Data\SubscriptionToProductInterfaceFactory;
use Mollie\Subscriptions\Api\SubscriptionToProductRepositoryInterface;
use Mollie\Subscriptions\DTO\SubscriptionOption;
use Mollie\Subscriptions\Service\Mollie\SubscriptionOptions;
use Mollie\Subscriptions\Service\Order\OrderContainsSubscriptionProduct;

class CreateSubscriptions implements ObserverInterface
{
    /**
     * @var Mollie
     */
    private $mollieModel;

    /**
     * @var OrderContainsSubscriptionProduct
     */
    private $orderContainsSubscriptionProduct;

    /**
     * @var SubscriptionOptions
     */
    private $subscriptionOptions;

    /**
     * @var SubscriptionToProductInterfaceFactory
     */
    private $subscriptionToProductFactory;

    /**
     * @var Config
     */
    private $config;

    /**
     * @var SubscriptionToProductRepositoryInterface
     */
    private $subscriptionToProductRepository;

    /**
     * @var MollieApiClient|null
     */
    private $mollieApi;

    /**
     * @var ManagerInterface
     */
    private $eventManager;

    public function __construct(
        Config $config,
        Mollie $mollieModel,
        OrderContainsSubscriptionProduct $orderContainsSubscriptionProduct,
        SubscriptionOptions $subscriptionOptions,
        SubscriptionToProductInterfaceFactory $subscriptionToProductFactory,
        SubscriptionToProductRepositoryInterface $subscriptionToProductRepository,
        ManagerInterface $eventManager
    ) {
        $this->config = $config;
        $this->mollieModel = $mollieModel;
        $this->orderContainsSubscriptionProduct = $orderContainsSubscriptionProduct;
        $this->subscriptionOptions = $subscriptionOptions;
        $this->subscriptionToProductFactory = $subscriptionToProductFactory;
        $this->subscriptionToProductRepository = $subscriptionToProductRepository;
        $this->eventManager = $eventManager;
    }

    public function execute(Observer $observer)
    {
        /** @var OrderInterface $order */
        $order = $observer->getData('order');
        if (!$this->orderContainsSubscriptionProduct->check($order)) {
            return;
        }

        $payment = $this->getPayment($observer);
        if (!$payment || !$payment->mandateId) {
            return;
        }

        $this->mollieApi = $this->mollieModel->getMollieApi($order->getStoreId());
        $subscriptions = $this->subscriptionOptions->forOrder($order);
        foreach ($subscriptions as $subscriptionOptions) {
            $this->createSubscription($payment->customerId, $subscriptionOptions);
        }
    }

    /**
     * @param Observer $observer
     * @return \Mollie\Api\Resources\Payment|null
     */
    private function getPayment(Observer $observer)
    {
        $payment = $observer->getData('mollie_payment');
        if ($observer->hasData('mollie_order')) {
            /** @var MollieOrder $mollieOrder */
            $mollieOrder = $observer->getData('mollie_order');
            $payment = $mollieOrder->payments()[0];
        }

        return $payment;
    }

    private function createSubscription(string $customerId, SubscriptionOption $subscriptionOptions)
    {
        $this->config->addToLog('request', ['customerId' => $customerId, 'options' => $subscriptionOptions->toArray()]);
        $subscription = $this->mollieApi->subscriptions->createForId($customerId, $subscriptionOptions->toArray());

        /** @var SubscriptionToProductInterface $model */
        $model = $this->subscriptionToProductFactory->create();
        $model->setCustomerId($subscription->customerId);
        $model->setSubscriptionId($subscription->id);
        $model->setProductId($subscriptionOptions->getProductId());
        $model->setStoreId($subscriptionOptions->getStoreId());

        $model = $this->subscriptionToProductRepository->save($model);

        $this->eventManager->dispatch('mollie_subscription_created', ['subscription' => $model]);
    }
}
