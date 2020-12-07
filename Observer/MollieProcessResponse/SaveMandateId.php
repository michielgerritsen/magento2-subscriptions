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
use Mollie\Subscriptions\Api\Data\OrderMandateInterface;
use Mollie\Subscriptions\Api\Data\OrderMandateInterfaceFactory;
use Mollie\Subscriptions\Api\OrderMandateRepositoryInterface;

class SaveMandateId implements ObserverInterface
{
    /**
     * @var OrderMandateRepositoryInterface
     */
    private $repository;

    /**
     * @var OrderMandateInterfaceFactory
     */
    private $mandateFactory;

    public function __construct(
        OrderMandateRepositoryInterface $repository,
        OrderMandateInterfaceFactory $mandateFactory
    ) {
        $this->repository = $repository;
        $this->mandateFactory = $mandateFactory;
    }

    public function execute(Observer $observer)
    {
        /** @var OrderInterface $order */
        $order = $observer->getData('order');

        $payment = $observer->getData('mollie_payment');
        if ($observer->hasData('mollie_order')) {
            /** @var MollieOrder $order */
            $mollieOrder = $observer->getData('mollie_order');
            $payment = $mollieOrder->payments()[0];
        }

        if (!$payment || !$payment->mandateId) {
            return;
        }

        /** @var OrderMandateInterface $model */
        $model = $this->mandateFactory->create();
        $model->setOrderId($order->getEntityId());
        $model->setMandateId($payment->mandateId);

        $this->repository->save($model);
    }
}