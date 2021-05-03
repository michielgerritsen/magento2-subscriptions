<?php
/*
 * Copyright Magmodules.eu. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Mollie\Subscriptions\Observer\MollieProcessResponse;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Sales\Api\Data\OrderInterface;
use Mollie\Api\Resources\Order as MollieOrder;
use Mollie\Payment\Config;
use Mollie\Payment\Model\Mollie;
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
     * @var CreateSubscriptions
     */
    private $subscriptionOptions;

    /**
     * @var Config
     */
    private $config;

    public function __construct(
        Mollie $mollieModel,
        OrderContainsSubscriptionProduct $orderContainsSubscriptionProduct,
        SubscriptionOptions $subscriptionOptions,
        Config $config
    ) {
        $this->mollieModel = $mollieModel;
        $this->orderContainsSubscriptionProduct = $orderContainsSubscriptionProduct;
        $this->subscriptionOptions = $subscriptionOptions;
        $this->config = $config;
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

        $mollieApi = $this->mollieModel->getMollieApi($order->getStoreId());
        $subscriptions = $this->subscriptionOptions->forOrder($order);
        foreach ($subscriptions as $subscriptionOptions) {
            $this->config->addToLog('request', ['customerId' => $payment->customerId, 'options' => $subscriptionOptions]);
            $mollieApi->subscriptions->createForId($payment->customerId, $subscriptionOptions);
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
}
