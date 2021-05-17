<?php
/*
 * Copyright Magmodules.eu. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Mollie\Subscriptions\Observer\CatalogProductSaveAfter;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Mollie\Payment\Helper\General;
use Mollie\Payment\Model\Mollie;

class UpdateSubscriptionProduct implements ObserverInterface
{
    /**
     * @var Mollie
     */
    private $mollie;

    /**
     * @var General
     */
    private $mollieHelper;

    public function __construct(
        Mollie $mollie,
        General $mollieHelper
    ) {
        $this->mollie = $mollie;
        $this->mollieHelper = $mollieHelper;
    }

    public function execute(Observer $observer)
    {
        /** @var \Magento\Catalog\Model\Product $product */
        $product = $observer->getData('product');

        if (!$product->dataHasChangedFor('price')) {
            return;
        }

        // TODO: Implement
    }
}
