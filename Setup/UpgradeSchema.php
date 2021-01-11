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
            $this->addOrderMandateTable($setup);
            $this->addMollieSubscriptionCustomerTable($setup);
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

    private function addOrderMandateTable(SchemaSetupInterface $setup)
    {
        $connection = $setup->getConnection();
        $tableName = $setup->getTable('mollie_subscriptions_order_mandate');

        $table = $connection->newTable($tableName);

        $table->addColumn(
            'entity_id',
            Table::TYPE_INTEGER,
            null,
            ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
            'Entity Id'
        );

        $table->addColumn(
            'order_id',
            Table::TYPE_INTEGER,
            null,
            ['unsigned' => true, 'nullable' => false],
            'Order ID'
        );

        $table->addColumn(
            'customer_id',
            Table::TYPE_TEXT,
            null,
            ['length' => '30', 'nullable' => false],
            'Customer ID'
        );

        $table->addColumn(
            'mandate_id',
            Table::TYPE_TEXT,
            null,
            ['length' => '30', 'nullable' => false],
            'Mandate ID'
        );

        $table->addColumn(
            'subscription_products',
            Table::TYPE_TEXT,
            null,
            ['length' => '255', 'nullable' => false],
            'Subscription Products'
        );

        $table->addForeignKey(
            $setup->getFkName($tableName, 'order_id', 'sales_order', 'entity_id'),
            'order_id',
            $setup->getTable('sales_order'),
            'entity_id',
            Table::ACTION_CASCADE
        );

        $connection->createTable($table);
    }

    private function addMollieSubscriptionCustomerTable(SchemaSetupInterface $setup)
    {
        $connection = $setup->getConnection();
        $tableName = $setup->getTable('mollie_subscriptions_customer');

        $table = $connection->newTable($tableName);

        $table->addColumn(
            'entity_id',
            Table::TYPE_INTEGER,
            null,
            ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
            'Entity Id'
        );

        $table->addColumn(
            'customer_id',
            Table::TYPE_INTEGER,
            null,
            ['unsigned' => true, 'nullable' => false],
            'Customer Id'
        );

        $table->addColumn(
            'mollie_subscription_customer_id',
            Table::TYPE_TEXT,
            null,
            ['unsigned' => true, 'nullable' => true],
            'Mollie Subscription Customer Id'
        );

        $table->addForeignKey(
            $setup->getFkName('mollie_subscriptions_customer', 'customer_id', 'customer_entity', 'entity_id'),
            'customer_id',
            $setup->getTable('customer_entity'),
            'entity_id',
            Table::ACTION_CASCADE
        );

        $connection->createTable($table);
    }
}
