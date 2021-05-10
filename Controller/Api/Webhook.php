<?php
/*
 * Copyright Magmodules.eu. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Mollie\Subscriptions\Controller\Api;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\ResponseInterface;

class Webhook extends Action
{
    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
    }
}
