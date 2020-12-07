<?php
/**
 * Copyright © Magmodules.eu. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Mollie\Subscriptions\Model;

use Magento\Quote\Api\Data\CartItemInterface;
use Mollie\Subscriptions\Api\CartItemSubscriptionRepositoryInterface;
use Mollie\Subscriptions\Api\Data\CartItemSubscriptionInterfaceFactory;
use Mollie\Subscriptions\Api\Data\CartItemSubscriptionSearchResultsInterfaceFactory;
use Mollie\Subscriptions\Model\ResourceModel\CartItemSubscription as ResourceCartItemSubscription;
use Mollie\Subscriptions\Model\ResourceModel\CartItemSubscription\CollectionFactory as CartItemSubscriptionCollectionFactory;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Api\ExtensibleDataObjectConverter;
use Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Reflection\DataObjectProcessor;
use Magento\Store\Model\StoreManagerInterface;

class CartItemSubscriptionRepository implements CartItemSubscriptionRepositoryInterface
{
    /**
     * @var ResourceCartItemSubscription
     */
    protected $resource;

    /**
     * @var CartItemSubscriptionFactory
     */
    protected $cartItemSubscriptionFactory;

    /**
     * @var CartItemSubscriptionCollectionFactory
     */
    protected $cartItemSubscriptionCollectionFactory;

    /**
     * @var CartItemSubscriptionSearchResultsInterfaceFactory
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
     * @var CartItemSubscriptionInterfaceFactory
     */
    protected $dataCartItemSubscriptionFactory;

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
        ResourceCartItemSubscription $resource,
        CartItemSubscriptionFactory $cartItemSubscriptionFactory,
        CartItemSubscriptionInterfaceFactory $dataCartItemSubscriptionFactory,
        CartItemSubscriptionCollectionFactory $cartItemSubscriptionCollectionFactory,
        CartItemSubscriptionSearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        StoreManagerInterface $storeManager,
        CollectionProcessorInterface $collectionProcessor,
        JoinProcessorInterface $extensionAttributesJoinProcessor,
        ExtensibleDataObjectConverter $extensibleDataObjectConverter
    ) {
        $this->resource = $resource;
        $this->cartItemSubscriptionFactory = $cartItemSubscriptionFactory;
        $this->cartItemSubscriptionCollectionFactory = $cartItemSubscriptionCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataCartItemSubscriptionFactory = $dataCartItemSubscriptionFactory;
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
        \Mollie\Subscriptions\Api\Data\CartItemSubscriptionInterface $cartItemSubscription
    ) {
        /* if (empty($cartItemSubscription->getStoreId())) {
            $storeId = $this->storeManager->getStore()->getId();
            $cartItemSubscription->setStoreId($storeId);
        } */
        
        $cartItemSubscriptionData = $this->extensibleDataObjectConverter->toNestedArray(
            $cartItemSubscription,
            [],
            \Mollie\Subscriptions\Api\Data\CartItemSubscriptionInterface::class
        );
        
        $cartItemSubscriptionModel = $this->cartItemSubscriptionFactory->create()->setData($cartItemSubscriptionData);
        
        try {
            $this->resource->save($cartItemSubscriptionModel);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the cartItemSubscription: %1',
                $exception->getMessage()
            ));
        }
        return $cartItemSubscriptionModel->getDataModel();
    }

    /**
     * {@inheritdoc}
     */
    public function get($cartItemSubscriptionId)
    {
        $cartItemSubscription = $this->cartItemSubscriptionFactory->create();
        $this->resource->load($cartItemSubscription, $cartItemSubscriptionId);
        if (!$cartItemSubscription->getId()) {
            throw new NoSuchEntityException(__('cart_item_subscription with id "%1" does not exist.', $cartItemSubscriptionId));
        }
        return $cartItemSubscription->getDataModel();
    }

    /**
     * {@inheritdoc}
     */
    public function getByCartItem(CartItemInterface $cartItem)
    {
        $cartItemSubscription = $this->cartItemSubscriptionFactory->create();
        $this->resource->load($cartItemSubscription, $cartItem->getItemId(), 'cart_item_id');
        if (!$cartItemSubscription->getId()) {
            throw new NoSuchEntityException(__(
                'cart_item_subscription with cart itemid "%1" does not exist.',
                $cartItem->getItemId()
            ));
        }
        return $cartItemSubscription->getDataModel();
    }

    /**
     * {@inheritdoc}
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $criteria
    ) {
        $collection = $this->cartItemSubscriptionCollectionFactory->create();
        
        $this->extensionAttributesJoinProcessor->process(
            $collection,
            \Mollie\Subscriptions\Api\Data\CartItemSubscriptionInterface::class
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
        \Mollie\Subscriptions\Api\Data\CartItemSubscriptionInterface $cartItemSubscription
    ) {
        try {
            $cartItemSubscriptionModel = $this->cartItemSubscriptionFactory->create();
            $this->resource->load($cartItemSubscriptionModel, $cartItemSubscription->getCartItemSubscriptionId());
            $this->resource->delete($cartItemSubscriptionModel);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the cart_item_subscription: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteById($cartItemSubscriptionId)
    {
        return $this->delete($this->get($cartItemSubscriptionId));
    }
}

