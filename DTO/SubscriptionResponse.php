<?php
/*
 * Copyright Magmodules.eu. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Mollie\Subscriptions\DTO;

use Magento\Customer\Api\Data\CustomerInterface;
use Mollie\Api\Resources\Subscription;

class SubscriptionResponse
{
    /**
     * @var Subscription
     */
    private $subscription;

    /**
     * @var CustomerInterface
     */
    private $customer;

    public function __construct(
        Subscription $subscription,
        CustomerInterface $customer
    ) {
        $this->subscription = $subscription;
        $this->customer = $customer;
    }

    /**
     * @return Subscription
     */
    public function getSubscription(): Subscription
    {
        return $this->subscription;
    }

    public function getCustomAttributes()
    {
        return [];
    }

    public function toArray()
    {
        return [
            'id' => $this->subscription->id,
            'customer_id' => $this->subscription->customerId,
            'customer_name' => $this->getFullName(),
            'amount' => $this->subscription->amount->value,
            'mode' => $this->subscription->mode,
            'status' => $this->subscription->status,
            'description' => $this->subscription->description,
            'created_at' => $this->subscription->createdAt,
        ];
    }

    /**
     * @return string
     */
    private function getFullName(): string
    {
        /** @var array $name */
        $name = array_filter([
            $this->customer->getFirstname(),
            $this->customer->getMiddlename(),
            $this->customer->getLastname(),
        ]);

        return implode(' ', $name);
    }
}