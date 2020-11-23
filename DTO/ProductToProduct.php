<?php
/*
 * Copyright Magmodules.eu. All rights reserved.
 *  See COPYING.txt for license details.
 */

namespace Mollie\Subscriptions\DTO;

class ProductToProduct
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $label;

    /**
     * @var SubscriptionPlan
     */
    private $plan;

    public function __construct(
        string $id,
        string $label,
        SubscriptionPlan $plan
    ) {
        $this->id = $id;
        $this->label = $label;
        $this->plan = $plan;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * @return SubscriptionPlan
     */
    public function getPlan(): SubscriptionPlan
    {
        return $this->plan;
    }
}