<?php
/**
 * Copyright Magmodules.eu. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Mollie\Subscriptions\Service\Order\TransactionPart;

use Magento\Checkout\Model\Session;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Quote\Api\CartRepositoryInterface;
use Magento\Sales\Api\Data\OrderInterface;
use Mollie\Payment\Model\Api;
use Mollie\Payment\Model\Client\Orders;
use Mollie\Payment\Model\Client\Payments;
use Mollie\Payment\Service\Order\TransactionPart\CustomerId;
use Mollie\Payment\Service\Order\TransactionPartInterface;
use Mollie\Subscriptions\Service\Cart\CartContainsSubscriptionProduct;

class CreateCustomerForGuests implements TransactionPartInterface
{
    /**
     * @var Api
     */
    private $api;

    /**
     * @var CartRepositoryInterface
     */
    private $cartRepository;

    /**
     * @var CartContainsSubscriptionProduct
     */
    private $cartContainsSubscriptionProduct;

    /**
     * @var Session
     */
    private $session;

    public function __construct(
        Api $api,
        CartRepositoryInterface $cartRepository,
        CartContainsSubscriptionProduct $cartContainsSubscriptionProduct,
        Session $session
    ) {
        $this->api = $api;
        $this->cartRepository = $cartRepository;
        $this->cartContainsSubscriptionProduct = $cartContainsSubscriptionProduct;
        $this->session = $session;
    }

    /**
     * @param OrderInterface $order
     * @param string $apiMethod
     * @param array $transaction
     * @return array
     */
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

        /**
         * This case is already handled by the CustomerId transactio part.
         * @see CustomerId
         */
        if ($order->getCustomerId()) {
            return $transaction;
        }

        if ($apiMethod == Payments::CHECKOUT_TYPE) {
            $transaction['customerId'] = $this->getCustomerIdFromMollie($order);
        }

        if ($apiMethod == Orders::CHECKOUT_TYPE) {
            $transaction['payment']['customerId'] = $this->getCustomerIdFromMollie($order);
        }

        return $transaction;
    }

    private function getCustomerIdFromMollie(OrderInterface $order): string
    {
        if ($this->session->hasMollieCustomerId()) {
            return $this->session->getMollieCustomerId();
        }

        $this->api->load($order->getStoreId());
        $mollieCustomer = $this->api->customers->create([
            'name' => $order->getCustomerName(),
            'email' => $order->getCustomerEmail(),
        ]);

        $this->session->setMollieCustomerId($mollieCustomer->id);
        return $mollieCustomer->id;
    }
}