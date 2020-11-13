<?php
/*
 * Copyright Magmodules.eu. All rights reserved.
 *  See COPYING.txt for license details.
 */

namespace Mollie\Subscriptions\Form\Modifier;

use Magento\Catalog\Model\Locator\LocatorInterface;
use Magento\Catalog\Ui\DataProvider\Product\Form\Modifier\AbstractModifier;
use Magento\Framework\Stdlib\ArrayManager;
use Mollie\Payment\Helper\General;
use Mollie\Payment\Model\Mollie;

class SubscriptionProducts extends AbstractModifier
{
    /**
     * @var ArrayManager
     */
    private $arrayManager;

    /**
     * @var LocatorInterface
     */
    private $locator;

    /**
     * @var General
     */
    private $mollieHelper;

    public function __construct(
        ArrayManager $arrayManager,
        LocatorInterface $locator,
        General $mollieHelper
    ) {
        $this->arrayManager = $arrayManager;
        $this->locator = $locator;
        $this->mollieHelper = $mollieHelper;
    }

    public function modifyMeta(array $meta)
    {
        return $this->arrayManager->merge(
            $this->arrayManager->findPath('mollie_subscription_product', $meta, null, 'children') . static::META_CONFIG_PATH,
            $meta,
            [
                'component' => 'Mollie_Subscriptions/js/view/product/input/map-ecurring-to-product',
                'template' => 'Mollie_Subscriptions/view/product/input/map-ecurring-to-product',
                'options' => [
                    $this->getOptions()
                ],
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function modifyData(array $data)
    {
        return $data;
    }

    public function getOptions()
    {
        $result = file_get_contents('https://api.ecurring.com/subscription-plans', false, stream_context_create([
            'http' => [
                'method' => 'GET',
                'header' => 'Authorization: Bearer ' . '// TODO',
            ]
        ]));

        var_dump($result);
        exit;
        $api = $this->mollieModel->getMollieApi();
//        $api->subscriptions
    }
}
