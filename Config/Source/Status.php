<?php
/*
 * Copyright Magmodules.eu. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Mollie\Subscriptions\Config\Source;

use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;

class Status extends AbstractSource
{
    const ENABLED = 1;
    const DISABLED = 2;

    public function getAllOptions()
    {
        return [
            [
                'value' => static::ENABLED,
                'label' => __('Enabled'),
            ],
            [
                'value' => static::DISABLED,
                'label' => __('Disabled'),
            ],
        ];
    }
}
