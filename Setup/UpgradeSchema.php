<?php
/*
 * Copyright Magmodules.eu. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Mollie\Subscriptions\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\UpgradeSchemaInterface;

class UpgradeSchema implements UpgradeSchemaInterface
{
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        if (version_compare($context->getVersion(), '0.1.0', '<=')) {
            $this->addCartItemTable($setup);
        }

        $setup->endSetup();
    }

    private function addCartItemTable(SchemaSetupInterface $setup)
    {
        $connection = $setup->getConnection();
        $tableName = $setup->getTable('mollie_subscriptions_cart_item');

        $table = $connection->newTable($tableName);

        $table->addColumn(
            'entity_id',
            Table::TYPE_INTEGER,
            null,
            ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
            'Entity Id'
        );

        $table->addColumn(
            'cart_item_id',
            Table::TYPE_INTEGER,
            null,
            ['unsigned' => true, 'nullable' => false],
            'Cart Item Id'
        );

        $table->addColumn(
            'subscription_product_id',
            Table::TYPE_TEXT,
            null,
            ['length' => '30', 'nullable' => false],
            'Subscription Product ID'
        );

        $table->addForeignKey(
            $setup->getFkName($tableName, 'cart_item_id', 'quote_item', 'item_id'),
            'cart_item_id',
            $setup->getTable('quote_item'),
            'item_id',
            Table::ACTION_CASCADE
        );

        $connection->createTable($table);
    }
}