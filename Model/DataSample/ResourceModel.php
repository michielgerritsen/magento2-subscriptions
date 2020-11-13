<?php
/**
 * Copyright © Magmodules.eu. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Mollie\Subscriptions\Model\DataSample;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * DataSample resource class
 *
 */
class ResourceModel extends AbstractDb
{

    /**
     * Table name
     */
    const ENTITY_TABLE = 'dummy_data';

    /**
     * Primary field
     */
    const PRIMARY = 'entity_id';

    /**
     * @inheritDoc
     */
    public function _construct()
    {
        $this->_init(
            self::ENTITY_TABLE,
            self::PRIMARY
        );
    }

    /**
     * Check is entity exists
     *
     * @param int $entityId
     * @return bool
     */
    public function isExists($entityId)
    {
        $connection = $this->getConnection();
        $select = $connection->select()->from(
            $this->getTable(self::ENTITY_TABLE),
            self::PRIMARY
        )->where(sprintf('%s = :%s', self::PRIMARY, self::PRIMARY));
        $bind = [sprintf(':%s', self::PRIMARY) => $entityId];
        return (bool)$connection->fetchOne($select, $bind);
    }
}
