<?php
/*
 * Copyright Magmodules.eu. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Mollie\Subscriptions\Service\Cart;

use Magento\Quote\Api\Data\CartInterface;

class CartContainsSubscriptionProduct
{
    public function check(CartInterface $cart): bool
    {
        foreach ($cart->getItems() as $item) {
            if ($item->getProduct()->getMollieSubscriptionProduct()) {
                return true;
            }
        }

        return false;
    }
}
