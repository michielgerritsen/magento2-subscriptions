<?php
/*
 * Copyright Magmodules.eu. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Mollie\Subscriptions\Block\Frontend\Customer\Account;

use Magento\Customer\Helper\Session\CurrentCustomer;
use Magento\Framework\View\Element\Template;
use Mollie\Payment\Model\Mollie;
use Mollie\Subscriptions\DTO\SubscriptionResponse;
use Mollie\Subscriptions\Service\EcurringApi;

class ActiveSubscriptions extends Template
{
    /**
     * @var CurrentCustomer
     */
    private $currentCustomer;

    /**
     * @var Mollie
     */
    private $mollie;

    public function __construct(
        Template\Context $context,
        CurrentCustomer $currentCustomer,
        Mollie $mollie,
        array $data = []
    ) {
        parent::__construct($context, $data);

        $this->currentCustomer = $currentCustomer;
        $this->mollie = $mollie;
    }

    /**
     * @return SubscriptionResponse[]
     */
    public function getSubscriptions()
    {
        $customer = $this->currentCustomer->getCustomer();
        $extensionAttributes = $customer->getExtensionAttributes();
        if (!$extensionAttributes || !$extensionAttributes->getMollieCustomerId()) {
            return [];
        }

        $api = $this->mollie->getMollieApi();
        $subscriptions = $api->subscriptions->listForId($extensionAttributes->getMollieCustomerId());

        return array_map(function ($subscription) use ($customer) {
            return new SubscriptionResponse($subscription, $customer);
        }, (array)$subscriptions);
    }
}
