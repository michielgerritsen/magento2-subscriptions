<?php
/*
 * Copyright Magmodules.eu. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Mollie\Subscriptions\Service\Mollie;

use Magento\Sales\Api\Data\OrderInterface;
use Magento\Sales\Api\Data\OrderItemInterface;
use Mollie\Payment\Helper\General;
use Mollie\Subscriptions\Config\Source\IntervalType;
use Mollie\Subscriptions\Config\Source\RepetitionType;

class SubscriptionOptions
{
    /**
     * @var OrderInterface
     */
    private $order;

    /**
     * @var OrderItemInterface
     */
    private $orderItem;

    /**
     * @var array
     */
    private $options = [];

    /**
     * @var General
     */
    private $mollieHelper;

    public function __construct(
        General $mollieHelper
    ) {
        $this->mollieHelper = $mollieHelper;
    }

    public function forOrder(OrderInterface $order): array
    {
        $options = [];
        $this->order = $order;

        foreach ($order->getAllItems() as $orderItem) {
            if (!$orderItem->getProduct()->getData('mollie_subscription_product')) {
                continue;
            }

            $options[] = $this->createSubscriptionFor($orderItem);
        }

        return $options;
    }

    private function createSubscriptionFor(OrderItemInterface $orderItem)
    {
        $this->options = [];
        $this->orderItem = $orderItem;

        $this->addAmount();
        $this->addTimes();
        $this->addInterval();
        $this->addDescription();

        return $this->options;
    }

    private function addAmount()
    {
        $this->options['amount'] = $this->mollieHelper->getAmountArray(
            $this->order->getOrderCurrencyCode(),
            $this->orderItem->getRowTotalInclTax()
        );
    }

    private function addTimes()
    {
        $product = $this->orderItem->getProduct();
        $type = $product->getData('mollie_subscription_repetition_type');
        if (!$type || $type == RepetitionType::INFINITE) {
            return;
        }

        $this->options['times'] = $product->getData('mollie_subscription_repetition_amount');
    }

    private function addInterval()
    {
        $product = $this->orderItem->getProduct();
        $intervalType = $product->getData('mollie_subscription_interval_type');
        $intervalAmount = (int)$product->getData('mollie_subscription_interval_amount');

        $this->options['interval'] = $intervalAmount . ' ' . $intervalType;
    }

    private function addDescription()
    {
        $product = $this->orderItem->getProduct();

        $this->options['description'] = $product->getName() . ' - ' . $this->getIntervalDescription();
    }

    private function getIntervalDescription()
    {
        $product = $this->orderItem->getProduct();
        $intervalType = $product->getData('mollie_subscription_interval_type');
        $intervalAmount = $product->getData('mollie_subscription_interval_amount');

        if ($intervalType == IntervalType::DAYS) {
            return __('Every %1 day(s)', $intervalAmount);
        }

        if ($intervalType == IntervalType::WEEKS) {
            if ($intervalAmount == 1) {
                return __('Every week');
            }

            return __('Every %1 weeks', $intervalAmount);
        }

        if ($intervalType == IntervalType::MONTHS) {
            if ($intervalAmount == 1) {
                return __('Every month');
            }

            return __('Every %1 months', $intervalAmount);
        }

        return '';
    }
}
