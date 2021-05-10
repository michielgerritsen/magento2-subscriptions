<?php
/*
 * Copyright Magmodules.eu. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Mollie\Subscriptions\Controller\Index;

use Magento\Customer\Helper\Session\CurrentCustomer;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Mollie\Payment\Model\Mollie;

class Cancel extends Action
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
        if ($this->getRequest()->getMethod() != 'POST') {
            throw new \Exception('Method not allowed');
        }

        $customer = $this->currentCustomer->getCustomer();
        $extensionAttributes = $customer->getExtensionAttributes();

        $api = $this->mollie->getMollieApi();
        $subscriptionId = $this->getRequest()->getParam('subscription_id');

        $api->subscriptions->cancelForId($extensionAttributes->getMollieCustomerId(), $subscriptionId);

        $this->messageManager->addSuccessMessage(
            __('Subscription with ID "%1" has been cancelled', $subscriptionId)
        );

        return $this->_redirect('*/*/');
    }
}
