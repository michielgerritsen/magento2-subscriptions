<?php
/*
 * Copyright Magmodules.eu. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Mollie\Subscriptions\Controller\Api;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\ResponseInterface;
use Mollie\Payment\Model\Mollie;

class Webhook extends Action
{
    /**
     * @var Mollie
     */
    private $mollie;

    public function __construct(
        Context $context,
        Mollie $mollie
    ) {
        parent::__construct($context);
        $this->mollie = $mollie;
    }

    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        $api = $this->mollie->getMollieApi();
        $order = $api->payments->get($id);
    }
}
