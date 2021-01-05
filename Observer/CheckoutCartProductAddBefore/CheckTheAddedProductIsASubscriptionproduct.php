<?php
/*
 * Copyright Magmodules.eu. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Mollie\Subscriptions\Observer\CheckoutCartProductAddBefore;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Exception\LocalizedException;
use Mollie\Subscriptions\Config;

class CheckTheAddedProductIsASubscriptionproduct implements ObserverInterface
{
    /**
     * @var Config
     */
    private $config;

    public function __construct(
        Config $config
    ) {
        $this->config = $config;
    }

    public function execute(Observer $observer)
    {
        if (!$this->config->disableAddToCartButton()) {
            return;
        }

        /** @var array $info */
        $info = $observer->getData('info');

        if (!is_array($info) ||
            !array_key_exists('mollie_subscriptions_product_id', $info) ||
            !$info['mollie_subscriptions_product_id']
        ) {
            throw new LocalizedException(__('Please select a subscription option.'));
        }
    }
}