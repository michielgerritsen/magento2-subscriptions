<?php
/**
 * Copyright © Magmodules.eu. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magmodules\Dummy\Api\DataSample;

use Magento\Framework\Api\ExtensibleDataInterface;

/**
 *  Interface for dummy data model
 *
 * @api
 */
interface DataInterface extends ExtensibleDataInterface
{

    /**
     * ID of store
     */
    const STORE_ID = 'store_id';

    /**
     * Sample value
     */
    const VALUE = 'value';

    /**
     * Created at time
     */
    const CREATED_AT = 'created_at';

    /**
     * Updated at time
     */
    const UPDATED_AT = 'updated_at';

    /**
     * Getter for store_id
     * @return int
     */
    public function getStoreId(): int;

    /**
     * Setter for store_id
     * @param int $storeId
     *
     * @return $this
     */
    public function setStoreId(int $storeId): self;

    /**
     * Getter for value
     * @return string
     */
    public function getValue(): string;

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setValue(string $value): self;

    /**
     * Getter for created_at
     * @return string
     */
    public function getCreatedAt(): string;

    /**
     * @param string $createdAt
     *
     * @return $this
     */
    public function setCreatedAt(string $createdAt): self;

    /**
     * Getter for updated_at
     * @return string
     */
    public function getUpdatedAt(): string;

    /**
     * @param string $updatedAt
     *
     * @return $this
     */
    public function setUpdatedAt(string $updatedAt): self;

    /**
     * @param integer $modelId
     * @param null|string $field
     * @return mixed
     */
    public function load($modelId, $field = null);
}
