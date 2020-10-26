<?php
/**
 * Copyright © Magmodules.eu. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magmodules\Dummy\Api\Config;

use Magento\Store\Api\Data\StoreInterface;

/**
 * Config repository interface
 */
interface RepositoryInterface
{

    const EXTENSION_CODE = 'Magmodules_Dummy';
    const XML_PATH_EXTENSION_VERSION = 'magmodules_dummy/general/version';
    const XML_PATH_EXTENSION_ENABLE = 'magmodules_dummy/general/enable';
    const XML_PATH_DEBUG = 'magmodules_dummy/general/debug';
    const MODULE_SUPPORT_LINK = 'https://www.magmodules.eu/help/%s';

    /**
     * Get extension version
     *
     * @return string
     */
    public function getExtensionVersion(): string;

    /**
     * Get extension code
     *
     * @return string
     */
    public function getExtensionCode(): string;

    /**
     * Get Magento Version
     *
     * @return string
     */
    public function getMagentoVersion(): string;

    /**
     * Check if module is enabled
     *
     * @param int|null $storeId
     *
     * @return bool
     */
    public function isEnabled(int $storeId = null): bool;

    /**
     * Check if debug mode is enabled
     *
     * @param int|null $storeId
     *
     * @return bool
     */
    public function isDebugMode(int $storeId = null): bool;

    /**
     * Get current store
     *
     * @return StoreInterface
     */
    public function getStore(): StoreInterface;

    /**
     * Support link for extension.
     *
     * @return string
     */
    public function getSupportLink(): string;
}
