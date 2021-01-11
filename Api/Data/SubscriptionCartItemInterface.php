<?php
/*
 * Copyright Magmodules.eu. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Mollie\Subscriptions\Api\Data;

use Mollie\Subscriptions\DTO\SubscriptionPlan;

interface SubscriptionCartItemInterface
{
    /**
     * @return string
     */
    public function getId();

    /**
     * @param string $id
     * @return $this
     */
    public function setId(string $id): self;

    /**
     * @return SubscriptionPlan
     */
    public function getPlan(): SubscriptionPlan;

    /**
     * @param SubscriptionPlan $plan
     * @return $this
     */
    public function setPlan(SubscriptionPlan $plan): self;
}
