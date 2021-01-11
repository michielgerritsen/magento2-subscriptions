<?php
/*
 * Copyright Magmodules.eu. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Mollie\Subscriptions\DTO;

use Mollie\Subscriptions\Api\Data\SubscriptionCartItemInterface;

class SubscriptionCartItem implements SubscriptionCartItemInterface
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var SubscriptionPlan
     */
    private $plan;

    public function getId()
    {
        return $this->id;
    }

    public function setId(string $id): SubscriptionCartItemInterface
    {
        $this->id = $id;

        return $this;
    }

    public function getPlan(): SubscriptionPlan
    {
        return $this->plan;
    }

    public function setPlan(SubscriptionPlan $plan): SubscriptionCartItemInterface
    {
        $this->plan = $plan;

        return $this;
    }
}
