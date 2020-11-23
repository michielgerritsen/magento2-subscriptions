<?php
/*
 * Copyright Magmodules.eu. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Mollie\Subscriptions\DTO;

use Assert\Assertion;

class SubscriptionPlanResponse
{
    /**
     * @var SubscriptionPlan[]
     */
    private $subscriptionPlans;

    public function __construct(
        array $subscriptionPlans
    ) {
        Assertion::allIsInstanceOf($subscriptionPlans, SubscriptionPlan::class);

        $this->subscriptionPlans = $subscriptionPlans;
    }

    public static function fromArray(array $response): self
    {
        $subscriptionPlans = [];
        foreach ($response['data'] as $subscriptionPlanData) {
            $subscriptionPlans[] = SubscriptionPlan::fromArray($subscriptionPlanData);
        }

        return new static(
            $subscriptionPlans
        );
    }

    /**
     * @return SubscriptionPlan[]
     */
    public function getSubscriptionPlans(): array
    {
        return $this->subscriptionPlans;
    }
}