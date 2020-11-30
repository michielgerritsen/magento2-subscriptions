<?php
/*
 * Copyright Magmodules.eu. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Mollie\Subscriptions\Observer\CatalogProductTypePrepareFullOptions;

use Magento\Framework\DataObject;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class AddSubscriptionToProductOptions implements ObserverInterface
{
    public function execute(Observer $observer)
    {
        /** @var \stdClass $transport */
        $transport = $observer->getData('transport');

        /** @var DataObject $buyRequest */
        $buyRequest = $observer->getData('buy_request');

        if (!$buyRequest->hasData('mollie_subscriptions_product_id')) {
            return;
        }

        $transport->options['mollie_subscriptions_product_id'] = $buyRequest->getData('mollie_subscriptions_product_id');
    }
}