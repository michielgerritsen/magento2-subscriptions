<?php
/*
 * Copyright Magmodules.eu. All rights reserved.
 *  See COPYING.txt for license details.
 */

namespace Mollie\Subscriptions\Form\Modifier;

use Magento\Catalog\Model\Locator\LocatorInterface;
use Magento\Catalog\Model\Product\Type;
use Magento\Catalog\Ui\DataProvider\Product\Form\Modifier\AbstractModifier;
use Magento\Framework\Stdlib\ArrayManager;
use Magento\Store\Model\StoreManagerInterface;
use Mollie\Payment\Model\Mollie;
use Mollie\Subscriptions\DTO\SubscriptionPlan;
use Mollie\Subscriptions\Service\EcurringApi;

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
     * @var EcurringApi
     */
    private $ecurringApi;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    public function __construct(
        ArrayManager $arrayManager,
        LocatorInterface $locator,
        EcurringApi $ecurringApi,
        StoreManagerInterface $storeManager
    ) {
        $this->arrayManager = $arrayManager;
        $this->locator = $locator;
        $this->ecurringApi = $ecurringApi;
        $this->storeManager = $storeManager;
    }

    public function modifyMeta(array $meta)
    {
        $path = $this->arrayManager->findPath(
            'mollie_subscription_product',
            $meta,
            null,
            'children'
        );

        $path .= static::META_CONFIG_PATH;

        if ($this->locator->getProduct()->getTypeId() != Type::TYPE_SIMPLE) {
            return $this->arrayManager->remove($path, []);
        }

        return $this->arrayManager->merge(
            $path,
            $meta,
            [
                'component' => 'Mollie_Subscriptions/js/view/product/input/map-ecurring-to-product',
                'template' => 'Mollie_Subscriptions/view/product/input/map-ecurring-to-product',
                'options' => $this->getOptions(),
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
        $plans = $this->ecurringApi->getSubscriptionPlans($this->storeManager->getStore()->getId());

        return array_map(function (SubscriptionPlan $plan) {
            return [
                'label' => $plan->getName(),
                'value' => $plan->getId(),
            ];
        }, $plans->getSubscriptionPlans());
    }
}
