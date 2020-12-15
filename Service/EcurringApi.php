<?php
/*
 * Copyright Magmodules.eu. All rights reserved.
 *  See COPYING.txt for license details.
 */

namespace Mollie\Subscriptions\Service;

use Magento\Framework\App\CacheInterface;
use Magento\Framework\HTTP\ClientInterface;
use Magento\Framework\HTTP\ClientInterfaceFactory;
use Magento\Sales\Api\Data\OrderAddressInterface;
use Mollie\Subscriptions\Config;
use Mollie\Subscriptions\DTO\ActiveSubscription;
use Mollie\Subscriptions\DTO\CreateCustomerResponse;
use Mollie\Subscriptions\DTO\CreateMandateResponse;
use Mollie\Subscriptions\DTO\SubscriptionPlanResponse;

class EcurringApi
{
    const CACHE_IDENTIFIER_PREFIX = 'mollie_subscriptions_api_';

    /**
     * @var ClientInterfaceFactory
     */
    private $clientFactory;

    /**
     * @var Config
     */
    private $config;

    /**
     * @var CacheInterface
     */
    private $cache;

    /**
     * @var string
     */
    private $beta = '?_beta=1';

    public function __construct(
        ClientInterfaceFactory $clientFactory,
        Config $config,
        CacheInterface $cache
    ) {
        $this->clientFactory = $clientFactory;
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

    /**
     * @param $mollieCustomerId
     * @throws \Exception
     * @return ActiveSubscription[]
     */
    public function getSubscriptionsForCustomer($mollieCustomerId)
    {
        $response = $this->doGetRequest(
            'https://api.ecurring.com/customers/' . $mollieCustomerId . '/subscriptions',
            $mollieCustomerId
        );

        $plans = $this->getSubscriptionPlans();

        $output = [];
        foreach ($response['data'] as $subscription) {
            $output[] = ActiveSubscription::fromArray(
                $subscription['id'],
                $plans->getById($subscription['relationships']['subscription-plan']['data']['id']),
                $subscription['attributes']
            );
        }

        return $output;
    }

    public function createCustomerFromAddress(OrderAddressInterface $address, $externalId)
    {
        $response = $this->doPostRequest('https://api.ecurring.com/customers' . $this->beta, [
            'data' => [
                'type' => 'customer',
                'attributes' => [
                    'first_name' => $address->getFirstname(),
                    'middle_name' => $address->getMiddlename(),
                    'last_name' => $address->getLastname(),
                    'email' => $address->getEmail(),
                    'company_name' => $address->getCompany(),
                    'postalcode' => $address->getPostcode(),
                    'street' => implode(PHP_EOL, $address->getStreet()),
                    'city' => $address->getCity(),
                    'country_iso2' => $address->getCountryId(),
                    'telephone' => $address->getTelephone(),
                    'external_id' => $externalId,
                ]
            ]
        ]);

        return CreateCustomerResponse::fromArray($response['data']['id'], $response['data']['attributes']);
    }

    public function createMandate($customerId, $mandateId)
    {
        $response = $this->doPostRequest('https://api.ecurring.com/mandates' . $this->beta, [
            'data' => [
                'type' => 'mandate',
                'attributes' => [
                    'customer_id' => $customerId,
                    'external_id' => $mandateId,
                ]
            ],
        ]);

        return CreateMandateResponse::fromArray($response['data']['id'], $response['data']['attributes']);
    }

    public function createActivatedSubscription($customerId, $productId)
    {
        $response = $this->doPostRequest('https://api.ecurring.com/subscriptions' . $this->beta, [
            'data' => [
                'type' => 'subscription',
                'attributes' => [
                    'customer_id' => $customerId,
                    'subscription_plan_id' => $productId,
                    'mandate_accepted' => true,
                    'mandate_accepted_date' => date("Y-m-d\TH:i:sP"),
                ],
            ]
        ]);

        return $response;
    }

    private function doGetRequest($url, $identifierKey = null)
    {
        $identifier = static::CACHE_IDENTIFIER_PREFIX . md5($url . $identifierKey);
        if ($result = $this->cache->load($identifier)) {
            return json_decode($result, true);
        }

        /** @var ClientInterface $client */
        $client = $this->clientFactory->create();

        $client->addHeader('X-Authorization', $this->config->getApiKey());
        $client->addHeader('Content-Type', 'application/vnd.api+json');
        $client->addHeader('Accept', 'application/vnd.api+json');
        $client->get($url);

        $response = $client->getBody();
        $json = json_decode($response, true);

        if (array_key_exists('errors', $json)) {
            $message = implode(', ', array_column($json['errors'], 'detail'));
            throw new \Exception($message);
        }

        $this->cache->save(
            $response,
            $identifier,
            ['mollie_payment', 'mollie_subscription_api'],
            60 * 60 // Cache for 1 hour
        );

        return $json;
    }

    private function doPostRequest($url, $data)
    {
        /** @var ClientInterface $client */
        $client = $this->clientFactory->create();

        $client->addHeader('X-Authorization', $this->config->getApiKey());
        $client->addHeader('Content-Type', 'application/vnd.api+json');
        $client->addHeader('Accept', 'application/vnd.api+json');

        $client->post($url, json_encode($data));



        return json_decode($client->getBody(), true);
    }
}