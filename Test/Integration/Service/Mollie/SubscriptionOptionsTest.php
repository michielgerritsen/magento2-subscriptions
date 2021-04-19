<?php
/*
 * Copyright Magmodules.eu. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Mollie\Subscriptions\Test\Integration\Service\Mollie;

use Mollie\Payment\Test\Integration\IntegrationTestCase;
use Mollie\Subscriptions\Config\Source\IntervalType;
use Mollie\Subscriptions\Config\Source\RepetitionType;
use Mollie\Subscriptions\Service\Mollie\SubscriptionOptions;

class SubscriptionOptionsTest extends IntegrationTestCase
{
    /**
     * @magentoDataFixture Magento/Sales/_files/order.php
     */
    public function testHandlesInfiniteOptionCorrect()
    {
        $order = $this->loadOrder('100000001');
        $items = $order->getItems();
        $item = array_shift($items)->getProduct();

        $item->setData('mollie_subscription_product', 1);
        $item->setData('mollie_subscription_repetition_type', RepetitionType::INFINITE);

        /** @var SubscriptionOptions $instance */
        $instance = $this->objectManager->create(SubscriptionOptions::class);
        $result = $instance->forOrder($order);

        $this->assertCount(1, $result);
        $subscription = $result[0];
        $this->assertArrayNotHasKey('times', $subscription);
    }

    /**
     * @magentoDataFixture Magento/Sales/_files/order.php
     */
    public function testIncludesTheTimesKey()
    {
        $order = $this->loadOrder('100000001');
        $items = $order->getItems();
        $item = array_shift($items)->getProduct();

        $item->setData('mollie_subscription_product', 1);
        $item->setData('mollie_subscription_repetition_amount', 10);
        $item->setData('mollie_subscription_repetition_type', RepetitionType::TIMES);

        /** @var SubscriptionOptions $instance */
        $instance = $this->objectManager->create(SubscriptionOptions::class);
        $result = $instance->forOrder($order);

        $this->assertCount(1, $result);
        $subscription = $result[0];
        $this->assertArrayHasKey('times', $subscription);
        $this->assertSame(10, $subscription['times']);
    }

    /**
     * @dataProvider includesTheCorrectIntervalProvider
     * @magentoDataFixture Magento/Sales/_files/order.php
     */
    public function testIncludesTheCorrectInterval($input, $expected)
    {
        $order = $this->loadOrder('100000001');
        $items = $order->getItems();
        $item = array_shift($items)->getProduct();

        $item->setData('mollie_subscription_product', 1);
        $item->setData('mollie_subscription_interval_amount', $input['amount']);
        $item->setData('mollie_subscription_interval_type', $input['type']);

        /** @var SubscriptionOptions $instance */
        $instance = $this->objectManager->create(SubscriptionOptions::class);
        $result = $instance->forOrder($order);

        $this->assertCount(1, $result);
        $subscription = $result[0];
        $this->assertArrayHasKey('interval', $subscription);
        $this->assertSame($expected, $subscription['interval']);
    }

    /**
     * @dataProvider addsADescriptionProvider
     * @magentoDataFixture Magento/Sales/_files/order.php
     */
    public function testAddsADescription($input, $expected)
    {
        $order = $this->loadOrder('100000001');
        $items = $order->getItems();
        $item = array_shift($items)->getProduct();

        $item->setData('mollie_subscription_product', 1);
        $item->setData('mollie_subscription_interval_amount', $input['amount']);
        $item->setData('mollie_subscription_interval_type', $input['type']);

        /** @var SubscriptionOptions $instance */
        $instance = $this->objectManager->create(SubscriptionOptions::class);
        $result = $instance->forOrder($order);

        $this->assertCount(1, $result);
        $subscription = $result[0];
        $this->assertArrayHasKey('description', $subscription);
        $this->assertStringContainsString($expected, $subscription['description']);
    }

    public function includesTheCorrectIntervalProvider()
    {
        return [
            'day' => [['amount' => 7, 'type' => IntervalType::DAYS], '7 days'],
            'single week' => [['amount' => 1, 'type' => IntervalType::WEEKS], '1 weeks'],
            'multiple weeks' => [['amount' => 3, 'type' => IntervalType::WEEKS], '3 weeks'],
            'single month' => [['amount' => 1, 'type' => IntervalType::MONTHS], '1 months'],
            'multiple months' => [['amount' => 3, 'type' => IntervalType::MONTHS], '3 months'],
            'float months' => [['amount' => '3.0000', 'type' => IntervalType::MONTHS], '3 months'],
        ];
    }

    public function addsADescriptionProvider()
    {
        return [
            'day' => [['amount' => 7, 'type' => IntervalType::DAYS], 'Every 7 days'],
            'single week' => [['amount' => 1, 'type' => IntervalType::WEEKS], 'Every week'],
            'multiple weeks' => [['amount' => 3, 'type' => IntervalType::WEEKS], 'Every 3 weeks'],
            'single month' => [['amount' => 1, 'type' => IntervalType::MONTHS], 'Every month'],
            'multiple months' => [['amount' => 3, 'type' => IntervalType::MONTHS], 'Every 3 months'],
            'float months' => [['amount' => '3.0000', 'type' => IntervalType::MONTHS], 'Every 3 months'],
        ];
    }
}
