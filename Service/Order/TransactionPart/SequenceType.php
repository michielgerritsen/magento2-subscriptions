<?php
/*
 * Copyright Magmodules.eu. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Mollie\Subscriptions\Service\Order\TransactionPart;

use Magento\Quote\Api\CartRepositoryInterface;
use Magento\Sales\Api\Data\OrderInterface;
use Mollie\Payment\Model\Client\Orders;
use Mollie\Payment\Model\Client\Payments;
use Mollie\Payment\Service\Order\TransactionPartInterface;
use Mollie\Subscriptions\Service\Order\OrderContainsSubscriptionProduct;

class SequenceType implements TransactionPartInterface
{
    /**
     * @var CartRepositoryInterface
     */
    private $cartRepository;

    /**
     * @var OrderContainsSubscriptionProduct
     */
    private $orderContainsSubscriptionProduct;

    public function __construct(
        CartRepositoryInterface $cartRepository,
        OrderContainsSubscriptionProduct $orderContainsSubscriptionProduct
    ) {
        $this->cartRepository = $cartRepository;
        $this->orderContainsSubscriptionProduct = $orderContainsSubscriptionProduct;
    }

    public function process(OrderInterface $order, $apiMethod, array $transaction)
    {
        if (!$this->orderContainsSubscriptionProduct->check($order)) {
            return $transaction;
        }

        if ($apiMethod == Payments::CHECKOUT_TYPE) {
            $transaction['sequenceType'] = 'first';
        }

        if ($apiMethod == Orders::CHECKOUT_TYPE) {
            $transaction['payment']['sequenceType'] = 'first';
        }

        return $transaction;
    }
}