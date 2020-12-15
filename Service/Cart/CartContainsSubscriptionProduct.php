<?php
/*
 * Copyright Magmodules.eu. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Mollie\Subscriptions\Service\Cart;

use Magento\Framework\Api\SearchCriteriaBuilderFactory;
use Magento\Quote\Api\Data\CartInterface;
use Magento\Quote\Api\Data\CartItemInterface;
use Mollie\Subscriptions\Api\CartItemSubscriptionRepositoryInterface;

class CartContainsSubscriptionProduct
{
    /**
     * @var CartItemSubscriptionRepositoryInterface
     */
    private $repository;

    /**
     * @var SearchCriteriaBuilderFactory
     */
    private $builderFactory;

    /**
     * @var bool[]
     */
    private $result = [];

    public function __construct(
        CartItemSubscriptionRepositoryInterface $repository,
        SearchCriteriaBuilderFactory $builderFactory
    ) {
        $this->repository = $repository;
        $this->builderFactory = $builderFactory;
    }

    public function check(CartInterface $cart): bool
    {
        if (isset($this->result[$cart->getId()])) {
            return $this->result[$cart->getId()];
        }

        $ids = array_map(function (CartItemInterface $item) {
            return $item->getItemId();
        }, $cart->getAllItems());

        $criteria = $this->builderFactory->create();
        $criteria->addFilter('cart_item_id', $ids, 'in');

        $items = $this->repository->getList($criteria->create());

        $result = (bool)$items->getTotalCount();
        $this->result[$cart->getId()] = $result;
        return $result;
    }
}
