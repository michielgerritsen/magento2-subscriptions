<?php
/*
 * Copyright Magmodules.eu. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Mollie\Subscriptions\Cron;

use Magento\Framework\Api\SearchCriteriaBuilderFactory;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;
use Mollie\Subscriptions\Api\SubscriptionToProductRepositoryInterface;
use Mollie\Subscriptions\Config;
use Mollie\Subscriptions\Service\Email\SendPrepaymentReminderEmail;

class SendPrePaymentReminderEmailCron
{
    /**
     * @var Config
     */
    private $config;

    /**
     * @var SearchCriteriaBuilderFactory
     */
    private $searchCriteriaBuilderFactory;

    /**
     * @var SubscriptionToProductRepositoryInterface
     */
    private $subscriptionToProductRepository;

    /**
     * @var TimezoneInterface
     */
    private $timezone;

    /**
     * @var SendPrepaymentReminderEmail
     */
    private $sendPrepaymentReminderEmail;

    public function __construct(
        Config $config,
        SubscriptionToProductRepositoryInterface $subscriptionToProductRepository,
        SearchCriteriaBuilderFactory $searchCriteriaBuilderFactory,
        TimezoneInterface $timezone,
        SendPrepaymentReminderEmail $sendPrepaymentReminderEmail
    ) {
        $this->config = $config;
        $this->searchCriteriaBuilderFactory = $searchCriteriaBuilderFactory;
        $this->subscriptionToProductRepository = $subscriptionToProductRepository;
        $this->timezone = $timezone;
        $this->sendPrepaymentReminderEmail = $sendPrepaymentReminderEmail;
    }

    public function execute()
    {
        $now = $this->timezone->date();
        $prepaymentDate = $now->add(new \DateInterval('P' . $this->config->daysBeforePrepaymentReminder() . 'D'));

        $criteria = $this->searchCriteriaBuilderFactory->create();
        $criteria->addFilter('next_payment_date', $prepaymentDate->format('Y-m-d'), 'eq');

        $subscriptions = $this->subscriptionToProductRepository->getList($criteria->create());
        foreach ($subscriptions->getItems() as $subscription) {
            if (!$this->config->isPrepaymentReminderEnabled($subscription->getStoreId())) {
                continue;
            }

            $this->sendPrepaymentReminderEmail->execute($subscription);
        }
    }
}
