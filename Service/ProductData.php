<?php
/*
 * Copyright Magmodules.eu. All rights reserved.
 *  See COPYING.txt for license details.
 */

namespace Mollie\Subscriptions\Service;

use Magento\Catalog\Api\Data\ProductInterface;
use Mollie\Subscriptions\DTO\ProductToProduct;

class ProductData
{
    /**
     * @var EcurringApi
     */
    private $ecurringApi;

    public function __construct(
        EcurringApi $ecurringApi
    ) {
        $this->ecurringApi = $ecurringApi;
    }

    /**
     * @param ProductInterface $product
     * @return ProductToProduct[]
     */
    public function convertMollieSubscriptionProduct(ProductInterface $product): array
    {
        $products = json_decode($product->getData('mollie_subscription_product'), true);

        return array_map(function ($product) {
            return new ProductToProduct(
                $product['productId'],
                $product['name'],
                $this->ecurringApi->getSubscriptionPlanById($product['productId'])
            );
        }, $products);
    }
}