<?php
/*
 * Copyright Magmodules.eu. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Mollie\Subscriptions\Observer\MollieProcessResponse;

use Magento\Checkout\Model\Session;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Quote\Api\CartRepositoryInterface;
use Magento\Sales\Api\Data\OrderInterface;
use Mollie\Api\Resources\Order as MollieOrder;
use Mollie\Subscriptions\Api\CartItemSubscriptionRepositoryInterface;
use Mollie\Subscriptions\Api\Data\OrderMandateInterface;
use Mollie\Subscriptions\Api\Data\OrderMandateInterfaceFactory;
use Mollie\Subscriptions\Api\OrderMandateRepositoryInterface;

class SaveMandateInformation implements ObserverInterface
{
    /**
     * @var OrderMandateRepositoryInterface
     */
    private $repository;

    /**
     * @var OrderMandateInterfaceFactory
     */
    private $mandateFactory;

    /**
     * @var CartItemSubscriptionRepositoryInterface
     */
    private $cartItemSubscriptionRepository;

    /**
     * @var Session
     */
    private $session;

    /**
     * @var CartRepositoryInterface
     */
    private $cartRepository;

    public function __construct(
        OrderMandateRepositoryInterface $repository,
        OrderMandateInterfaceFactory $mandateFactory,
        CartItemSubscriptionRepositoryInterface $cartItemSubscriptionRepository,
        CartRepositoryInterface $cartRepository,
        Session $session
    ) {
        $this->repository = $repository;
        $this->mandateFactory = $mandateFactory;
        $this->cartItemSubscriptionRepository = $cartItemSubscriptionRepository;
        $this->cartRepository = $cartRepository;
        $this->session = $session;
    }

    public function execute(Observer $observer)
    {
        $payment = $this->getPayment($observer);
        if (!$payment || !$payment->mandateId) {
            return;
        }

        $subscriptionProducts = [];
        /** @var OrderInterface $order */
        $order = $observer->getData('order');
        $quote = $this->cartRepository->get($order->getQuoteId());
        foreach ($quote->getAllItems() as $item) {
            try {
                $cartItem = $this->cartItemSubscriptionRepository->getByCartItem($item);
                $subscriptionProducts[] = $cartItem->getSubscriptionProductId();
            } catch (NoSuchEntityException $exception) {
                // The cart can contain items that don't have a subscription.
            }
        }

        if (!$subscriptionProducts) {
            return;
        }

        /** @var OrderMandateInterface $model */
        $model = $this->mandateFactory->create();
        $model->setOrderId($order->getEntityId());
        $model->setCustomerId($payment->customerId);
        $model->setMandateId($payment->mandateId);
        $model->setSubscriptionProducts(implode(',', $subscriptionProducts));

        $this->repository->save($model);
    }

    /**
     * @param Observer $observer
     * @return \Mollie\Api\Resources\Payment|null
     */
    private function getPayment(Observer $observer)
    {
        $payment = $observer->getData('mollie_payment');
        if ($observer->hasData('mollie_order')) {
            /** @var MollieOrder $order */
            $mollieOrder = $observer->getData('mollie_order');
            $payment = $mollieOrder->payments()[0];
        }

        return $payment;
    }
}