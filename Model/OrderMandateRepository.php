<?php
/**
 * Copyright © Magmodules.eu. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Mollie\Subscriptions\Model;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Sales\Api\Data\OrderInterface;
use Mollie\Subscriptions\Api\Data\OrderMandateInterface;
use Mollie\Subscriptions\Api\Data\OrderMandateInterfaceFactory;
use Mollie\Subscriptions\Api\Data\OrderMandateSearchResultsInterfaceFactory;
use Mollie\Subscriptions\Api\OrderMandateRepositoryInterface;
use Mollie\Subscriptions\Model\ResourceModel\OrderMandate as ResourceOrderMandate;
use Mollie\Subscriptions\Model\ResourceModel\OrderMandate\CollectionFactory as OrderMandateCollectionFactory;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Api\ExtensibleDataObjectConverter;
use Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Reflection\DataObjectProcessor;
use Magento\Store\Model\StoreManagerInterface;

class OrderMandateRepository implements OrderMandateRepositoryInterface
{
    /**
     * @var ResourceOrderMandate
     */
    protected $resource;

    /**
     * @var OrderMandateFactory
     */
    protected $orderMandateFactory;

    /**
     * @var OrderMandateCollectionFactory
     */
    protected $orderMandateCollectionFactory;

    /**
     * @var OrderMandateSearchResultsInterfaceFactory
     */
    protected $searchResultsFactory;

    /**
     * @var DataObjectHelper
     */
    protected $dataObjectHelper;

    /**
     * @var DataObjectProcessor
     */
    protected $dataObjectProcessor;

    /**
     * @var OrderMandateInterfaceFactory
     */
    protected $dataOrderMandateFactory;

    /**
     * @var JoinProcessorInterface
     */
    protected $extensionAttributesJoinProcessor;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;

    /**
     * @var ExtensibleDataObjectConverter
     */
    protected $extensibleDataObjectConverter;

    public function __construct(
        ResourceOrderMandate $resource,
        OrderMandateFactory $orderMandateFactory,
        OrderMandateInterfaceFactory $dataOrderMandateFactory,
        OrderMandateCollectionFactory $orderMandateCollectionFactory,
        OrderMandateSearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        StoreManagerInterface $storeManager,
        CollectionProcessorInterface $collectionProcessor,
        JoinProcessorInterface $extensionAttributesJoinProcessor,
        ExtensibleDataObjectConverter $extensibleDataObjectConverter
    ) {
        $this->resource = $resource;
        $this->orderMandateFactory = $orderMandateFactory;
        $this->orderMandateCollectionFactory = $orderMandateCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataOrderMandateFactory = $dataOrderMandateFactory;
        $this->dataObjectProcessor = $dataObjectProcessor;
        $this->storeManager = $storeManager;
        $this->collectionProcessor = $collectionProcessor;
        $this->extensionAttributesJoinProcessor = $extensionAttributesJoinProcessor;
        $this->extensibleDataObjectConverter = $extensibleDataObjectConverter;
    }

    /**
     * {@inheritdoc}
     */
    public function save(
        OrderMandateInterface $orderMandate
    ) {
        $orderMandateData = $this->extensibleDataObjectConverter->toNestedArray(
            $orderMandate,
            [],
            OrderMandateInterface::class
        );

        $orderMandateModel = $this->orderMandateFactory->create()->setData($orderMandateData);

        try {
            $this->resource->save($orderMandateModel);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the orderMandate: %1',
                $exception->getMessage()
            ));
        }
        return $orderMandateModel->getDataModel();
    }

    /**
     * {@inheritdoc}
     */
    public function get($orderMandateId)
    {
        $orderMandate = $this->orderMandateFactory->create();
        $this->resource->load($orderMandate, $orderMandateId);
        if (!$orderMandate->getId()) {
            throw new NoSuchEntityException(__('order_mandate with id "%1" does not exist.', $orderMandateId));
        }
        return $orderMandate->getDataModel();
    }

    /**
     * {@inheritdoc}
     */
    public function getByOrder(OrderInterface $order)
    {
        $orderMandate = $this->orderMandateFactory->create();
        $this->resource->load($orderMandate, $order->getEntityId(), 'order_id');
        if (!$orderMandate->getId()) {
            throw new NoSuchEntityException(__('order_mandate for order "%1" does not exist.', $order->getEntityId()));
        }
        return $orderMandate->getDataModel();
    }

    /**
     * {@inheritdoc}
     */
    public function getList(
        SearchCriteriaInterface $criteria
    ) {
        $collection = $this->orderMandateCollectionFactory->create();

        $this->extensionAttributesJoinProcessor->process(
            $collection,
            OrderMandateInterface::class
        );

        $this->collectionProcessor->process($criteria, $collection);

        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);

        $items = [];
        foreach ($collection as $model) {
            $items[] = $model->getDataModel();
        }

        $searchResults->setItems($items);
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * {@inheritdoc}
     */
    public function delete(
        OrderMandateInterface $orderMandate
    ) {
        try {
            $orderMandateModel = $this->orderMandateFactory->create();
            $this->resource->load($orderMandateModel, $orderMandate->getOrderMandateId());
            $this->resource->delete($orderMandateModel);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the order_mandate: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteById($orderMandateId)
    {
        return $this->delete($this->get($orderMandateId));
    }
}
