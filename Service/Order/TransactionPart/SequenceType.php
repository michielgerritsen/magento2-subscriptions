<?php
/*
 * Copyright Magmodules.eu. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Mollie\Subscriptions\Service\Order\TransactionPart;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Quote\Api\CartRepositoryInterface;
use Magento\Sales\Api\Data\OrderInterface;
use Mollie\Payment\Model\Client\Orders;
use Mollie\Payment\Model\Client\Payments;
use Mollie\Payment\Service\Order\TransactionPartInterface;
use Mollie\Subscriptions\Service\Cart\CartContainsSubscriptionProduct;

class SequenceType implements TransactionPartInterface
{
    /**
     * @var CartRepositoryInterface
     */
    private $cartRepository;

    /**
     * @var CartContainsSubscriptionProduct
     */
    private $cartContainsSubscriptionProduct;

    public function __construct(
        CartRepositoryInterface $cartRepository,
        CartContainsSubscriptionProduct $cartContainsSubscriptionProduct
    ) {
        $this->cartRepository = $cartRepository;
        $this->cartContainsSubscriptionProduct = $cartContainsSubscriptionProduct;
    }

    public function process(OrderInterface $order, $apiMethod, array $transaction)
    {
        try {
            $quote = $this->cartRepository->get($order->getQuoteId());
        } catch (NoSuchEntityException $exception) {
            return $transaction;
        }

        if (!$this->cartContainsSubscriptionProduct->check($quote)) {
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