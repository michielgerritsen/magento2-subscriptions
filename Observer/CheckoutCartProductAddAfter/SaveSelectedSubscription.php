<?php
/*
 * Copyright Magmodules.eu. All rights reserved.
 *  See COPYING.txt for license details.
 */

namespace Mollie\Subscriptions\Observer\CheckoutCartProductAddAfter;

use Magento\Framework\App\RequestInterface;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Quote\Api\Data\CartItemInterface;
use Mollie\Subscriptions\Service\Cart\Item;

class SaveSelectedSubscription implements ObserverInterface
{
    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * @var Item
     */
    private $item;

    public function __construct(
        RequestInterface $request,
        Item $item
    ) {
        $this->request = $request;
        $this->item = $item;
    }

    public function execute(Observer $observer)
    {
        /** @var CartItemInterface $quoteItem */
        $quoteItem = $observer->getData('quote_item');

        if (!$this->request->getParam('mollie_subscriptions_product_id')) {
            return;
        }

        $this->item->addMollieSubscriptToItem($quoteItem, $this->request->getParam('mollie_subscriptions_product_id'));
    }
}
