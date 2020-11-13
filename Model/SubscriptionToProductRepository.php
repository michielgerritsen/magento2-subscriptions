<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Mollie\Subscriptions\Model;

use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Api\ExtensibleDataObjectConverter;
use Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Reflection\DataObjectProcessor;
use Magento\Store\Model\StoreManagerInterface;
use Mollie\Subscriptions\Api\Data\SubscriptionToProductInterfaceFactory;
use Mollie\Subscriptions\Api\Data\SubscriptionToProductSearchResultsInterfaceFactory;
use Mollie\Subscriptions\Api\SubscriptionToProductRepositoryInterface;
use Mollie\Subscriptions\Model\ResourceModel\SubscriptionToProduct as ResourceSubscriptionToProduct;
use Mollie\Subscriptions\Model\ResourceModel\SubscriptionToProduct\CollectionFactory as SubscriptionToProductCollectionFactory;

class SubscriptionToProductRepository implements SubscriptionToProductRepositoryInterface
{

    protected $resource;

    protected $subscriptionToProductFactory;

    protected $subscriptionToProductCollectionFactory;

    protected $searchResultsFactory;

    protected $dataObjectHelper;

    protected $dataObjectProcessor;

    protected $dataSubscriptionToProductFactory;

    protected $extensionAttributesJoinProcessor;

    private $storeManager;

    private $collectionProcessor;

    protected $extensibleDataObjectConverter;

    /**
     * @param ResourceSubscriptionToProduct $resource
     * @param SubscriptionToProductFactory $subscriptionToProductFactory
     * @param SubscriptionToProductInterfaceFactory $dataSubscriptionToProductFactory
     * @param SubscriptionToProductCollectionFactory $subscriptionToProductCollectionFactory
     * @param SubscriptionToProductSearchResultsInterfaceFactory $searchResultsFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param DataObjectProcessor $dataObjectProcessor
     * @param StoreManagerInterface $storeManager
     * @param CollectionProcessorInterface $collectionProcessor
     * @param JoinProcessorInterface $extensionAttributesJoinProcessor
     * @param ExtensibleDataObjectConverter $extensibleDataObjectConverter
     */
    public function __construct(
        ResourceSubscriptionToProduct $resource,
        SubscriptionToProductFactory $subscriptionToProductFactory,
        SubscriptionToProductInterfaceFactory $dataSubscriptionToProductFactory,
        SubscriptionToProductCollectionFactory $subscriptionToProductCollectionFactory,
        SubscriptionToProductSearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        StoreManagerInterface $storeManager,
        CollectionProcessorInterface $collectionProcessor,
        JoinProcessorInterface $extensionAttributesJoinProcessor,
        ExtensibleDataObjectConverter $extensibleDataObjectConverter
    ) {
        $this->resource = $resource;
        $this->subscriptionToProductFactory = $subscriptionToProductFactory;
        $this->subscriptionToProductCollectionFactory = $subscriptionToProductCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataSubscriptionToProductFactory = $dataSubscriptionToProductFactory;
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
        \Mollie\Subscriptions\Api\Data\SubscriptionToProductInterface $subscriptionToProduct
    ) {
        /* if (empty($subscriptionToProduct->getStoreId())) {
            $storeId = $this->storeManager->getStore()->getId();
            $subscriptionToProduct->setStoreId($storeId);
        } */
        
        $subscriptionToProductData = $this->extensibleDataObjectConverter->toNestedArray(
            $subscriptionToProduct,
            [],
            \Mollie\Subscriptions\Api\Data\SubscriptionToProductInterface::class
        );
        
        $subscriptionToProductModel = $this->subscriptionToProductFactory->create()->setData($subscriptionToProductData);
        
        try {
            $this->resource->save($subscriptionToProductModel);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the subscriptionToProduct: %1',
                $exception->getMessage()
            ));
        }
        return $subscriptionToProductModel->getDataModel();
    }

    /**
     * {@inheritdoc}
     */
    public function get($subscriptionToProductId)
    {
        $subscriptionToProduct = $this->subscriptionToProductFactory->create();
        $this->resource->load($subscriptionToProduct, $subscriptionToProductId);
        if (!$subscriptionToProduct->getId()) {
            throw new NoSuchEntityException(__('subscription_to_product with id "%1" does not exist.', $subscriptionToProductId));
        }
        return $subscriptionToProduct->getDataModel();
    }

    /**
     * {@inheritdoc}
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $criteria
    ) {
        $collection = $this->subscriptionToProductCollectionFactory->create();
        
        $this->extensionAttributesJoinProcessor->process(
            $collection,
            \Mollie\Subscriptions\Api\Data\SubscriptionToProductInterface::class
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
        \Mollie\Subscriptions\Api\Data\SubscriptionToProductInterface $subscriptionToProduct
    ) {
        try {
            $subscriptionToProductModel = $this->subscriptionToProductFactory->create();
            $this->resource->load($subscriptionToProductModel, $subscriptionToProduct->getSubscriptionToProductId());
            $this->resource->delete($subscriptionToProductModel);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the subscription_to_product: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteById($subscriptionToProductId)
    {
        return $this->delete($this->get($subscriptionToProductId));
    }
}

