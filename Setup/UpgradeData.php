<?php
/*
 * Copyright Magmodules.eu. All rights reserved.
 *  See COPYING.txt for license details.
 */

namespace Mollie\Subscriptions\Setup;

use Magento\Catalog\Model\Product;
use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\UpgradeDataInterface;

class UpgradeData implements UpgradeDataInterface
{
    /**
     * @var EavSetupFactory
     */
    private $eavSetupFactory;

    public function __construct(
        EavSetupFactory $eavSetupFactory
    ) {
        $this->eavSetupFactory = $eavSetupFactory;
    }

    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        /** @var EavSetup $eavSetup */
        $eavSetup = $this->eavSetupFactory->create();

        if (version_compare($context->getVersion(), '0.1.0', '<=')) {
            $this->addProductAttribute($setup, $eavSetup);
        }

        $setup->endSetup();
    }

    private function addProductAttribute(ModuleDataSetupInterface $setup, EavSetup $eavSetup)
    {
        $eavSetup = $this->eavSetupFactory->create();

        // Already exists
        if ($eavSetup->getAttribute(Product::ENTITY, 'mollie_subscription_product')) {
            return;
        }

        $eavSetup->addAttribute(
            Product::ENTITY,
            'mollie_subscription_product',
            [
                'group' => 'Mollie',
                'type' => 'text',
                'label' => 'Subscription product',
                'input' => 'text',
                'required' => false,
                'sort_order' => 10,
                'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
                'is_used_in_grid' => false,
                'is_visible_in_grid' => false,
                'is_filterable_in_grid' => false,
                'visible' => true,
                'is_html_allowed_on_front' => false,
                'visible_on_front' => false
            ]
        );
    }
}