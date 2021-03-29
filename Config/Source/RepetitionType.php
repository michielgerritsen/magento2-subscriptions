<?php
/*
 * Copyright Magmodules.eu. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Mollie\Subscriptions\Config\Source;

use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;

class RepetitionType extends AbstractSource
{
    const TIMES = 'times';
    const INFINITE = 'infinite';

    public function getAllOptions()
    {
        return [
            [
                'value' => '',
                'label' => __('Please select'),
            ],
            [
                'value' => static::TIMES,
                'label' => __('Times'),
            ],
            [
                'value' => static::INFINITE,
                'label' => __('Infinite'),
            ],
        ];
    }
}
