<?php
/**
 * Copyright © Magmodules.eu. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magmodules\Dummy\Api\DataSample;

use Magento\Framework\Api\SearchResultsInterface as FrameworkSearchResultsInterface;

/**
 * Interface for sample data search results.
 *
 * @api
 */
interface SearchResultsInterface extends FrameworkSearchResultsInterface
{

    /**
     * Gets sample items
     *
     * @return DataInterface[]
     */
    public function getItems(): array;

    /**
     * Sets sample items
     *
     * @param DataInterface[] $items
     *
     * @return $this
     */
    public function setItems(array $items): self;
}
