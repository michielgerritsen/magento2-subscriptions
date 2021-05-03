<?php
/*
 * Copyright Magmodules.eu. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Mollie\Subscriptions\Block\Frontend\Customer\Account;

use Magento\Customer\Helper\Session\CurrentCustomer;
use Magento\Framework\View\Element\Template;
use Mollie\Subscriptions\Service\EcurringApi;

class ActiveSubscriptions extends Template
{
    /**
     * @var CurrentCustomer
     */
    private $currentCustomer;

    // TODO
    public function __construct(
        Template\Context $context,
        CurrentCustomer $currentCustomer,
//        EcurringApi $ecurringApi,
        array $data = []
    ) {
        parent::__construct($context, $data);

        $this->currentCustomer = $currentCustomer;
    }

    public function getSubscriptions()
    {
        $customer = $this->currentCustomer->getCustomer();
        $extensionAttributes = $customer->getExtensionAttributes();
        if (!$extensionAttributes || !$extensionAttributes->getMollieSubscriptionCustomerId()) {
            return [];
        }

//        return $this->ecurringApi->getSubscriptionsForCustomer($extensionAttributes->getMollieSubscriptionCustomerId());
    }
}
