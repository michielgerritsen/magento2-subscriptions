<?php
/*
 * Copyright Magmodules.eu. All rights reserved.
 *  See COPYING.txt for license details.
 */

namespace Mollie\Subscriptions\Block\Frontend\Product\View;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Framework\Registry;
use Magento\Framework\View\Element\Template;
use Mollie\Subscriptions\DTO\ProductToProduct;
use Mollie\Subscriptions\Service\EcurringApi;
use Mollie\Subscriptions\Service\ProductData;

class SubscriptionProductButtons extends Template
{
    /**
     * @var Registry
     */
    private $registry;

    /**
     * @var EcurringApi
     */
    private $ecurringApi;

    /**
     * @var ProductData
     */
    private $productData;

    public function __construct(
        Template\Context $context,
        Registry $registry,
        EcurringApi $ecurringApi,
        ProductData $productData,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->registry = $registry;
        $this->ecurringApi = $ecurringApi;
        $this->productData = $productData;
    }

    /**
     * @return ProductToProduct[]
     */
    public function getSubscriptionProducts(): array
    {
        /** @var ProductInterface $product */
        $product = $this->registry->registry('product');

        return $this->productData->convertMollieSubscriptionProduct($product);
    }

    protected function _toHtml()
    {
        /** @var ProductInterface $product */
        $product = $this->registry->registry('product');

        if (!$product->getData('mollie_subscription_product')) {
            return null;
        }

        return parent::_toHtml();
    }
}