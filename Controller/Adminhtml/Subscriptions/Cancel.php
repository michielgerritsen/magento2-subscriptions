<?php
/*
 * Copyright Magmodules.eu. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Mollie\Subscriptions\Controller\Adminhtml\Subscriptions;

use Magento\Backend\App\Action;
use Mollie\Payment\Model\Mollie;

class Cancel extends Action
{
    /**
     * @var Mollie
     */
    private $mollie;

    public function __construct(
        Action\Context $context,
        Mollie $mollie
    ) {
        parent::__construct($context);
        $this->mollie = $mollie;
    }

    public function execute()
    {
        $api = $this->mollie->getMollieApi($this->getRequest()->getParam('store_id'));
        $customerId = $this->getRequest()->getParam('customer_id');
        $subscriptionId = $this->getRequest()->getParam('subscription_id');

        $api->subscriptions->cancelForId($customerId, $subscriptionId);

        $this->messageManager->addSuccessMessage(
            __('Subscription with ID "%1" has been cancelled', $subscriptionId)
        );

        $this->_redirect('*/*/');
    }
}
