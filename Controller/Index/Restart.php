<?php
/*
 * Copyright Magmodules.eu. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Mollie\Subscriptions\Controller\Index;

use Magento\Customer\Helper\Session\CurrentCustomer;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Mollie\Api\Resources\Subscription;
use Mollie\Payment\Model\Mollie;

class Restart extends Action
{
    /**
     * @var Mollie
     */
    private $mollie;

    /**
     * @var CurrentCustomer
     */
    private $currentCustomer;

    public function __construct(
        Context $context,
        Mollie $mollie,
        CurrentCustomer $currentCustomer
    ) {
        parent::__construct($context);
        $this->mollie = $mollie;
        $this->currentCustomer = $currentCustomer;
    }

    public function execute()
    {
        $customer = $this->currentCustomer->getCustomer();
        $extensionAttributes = $customer->getExtensionAttributes();

        $api = $this->mollie->getMollieApi();
        $subscriptionId = $this->getRequest()->getParam('subscription_id');

        $canceledSubscription = $api->subscriptions->getForId(
            $extensionAttributes->getMollieCustomerId(),
            $subscriptionId
        );

        $api->subscriptions->createForId($extensionAttributes->getMollieCustomerId(), [
            'amount' => [
                'currency' => $canceledSubscription->amount->currency,
                'value' => $canceledSubscription->amount->value,
            ],
            'times' => $canceledSubscription->times,
            'interval' => $canceledSubscription->interval,
            'description' => $canceledSubscription->description,
            'metadata' => $this->getMetadata($canceledSubscription),
            'webhookUrl' => $this->_url->getUrl('mollie-subscriptions/api/webhook'),
        ]);

        $this->messageManager->addSuccessMessage('The subscription has been restarted successfully');

        return $this->_redirect('*/*/index');
    }

    private function getMetadata(Subscription $canceledSubscription)
    {
        // Ignore as it has the wrong doctype:
        // https://github.com/mollie/mollie-api-php/pull/554
        // @phpstan-ignore-next-line
        if ($canceledSubscription->metadata instanceof \stdClass) {
            $metadata = $canceledSubscription->metadata;
            $metadata->parent_id = $canceledSubscription->id;

            return $metadata;
        }

        return [];
    }
}
