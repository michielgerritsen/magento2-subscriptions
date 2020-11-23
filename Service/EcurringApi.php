<?php
/*
 * Copyright Magmodules.eu. All rights reserved.
 *  See COPYING.txt for license details.
 */

namespace Mollie\Subscriptions\Service;

use Magento\Framework\App\CacheInterface;
use Mollie\Subscriptions\Config;
use Mollie\Subscriptions\DTO\SubscriptionPlanResponse;

class EcurringApi
{
    const CACHE_IDENTIFIER_PREFIX = 'mollie_subscriptions_api_';

    /**
     * @var Config
     */
    private $config;

    /**
     * @var CacheInterface
     */
    private $cache;

    public function __construct(
        Config $config,
        CacheInterface $cache
    ) {
        $this->config = $config;
        $this->cache = $cache;
    }

    public function getSubscriptionPlans($storeId = null): SubscriptionPlanResponse
    {
        $response = $this->doGetRequest('https://api.ecurring.com/subscription-plans', $storeId);

        return SubscriptionPlanResponse::fromArray($response);
    }

    public function getSubscriptionPlanById($id, $storeId = null)
    {
        $plans = $this->getSubscriptionPlans($storeId);

        foreach ($plans->getSubscriptionPlans() as $plan) {
            if ($plan->getId() == $id) {
                return $plan;
            }
        }

        return null;
    }

    private function doGetRequest($url, $storeId = null)
    {
        $identifier = static::CACHE_IDENTIFIER_PREFIX . md5($url . $storeId);
        if ($result = $this->cache->load($identifier)) {
            return json_decode($result, true);
        }

        $options = [
            'http' => [
                'method'  => 'GET',
                'header' => 'X-Authorization: ' . $this->config->getApiKey(),
            ]
        ];

        $context  = stream_context_create($options);
        $response = file_get_contents($url, false, $context);

        $this->cache->save(
            $response,
            $identifier,
            ['mollie_payment', 'mollie_subscription_api'],
            60 * 60 // Cache for 1 hour
        );

        return json_decode($response, true);
    }
}