<?php
/**
 * @category NaumovExtensions
 * @package NaumovExtensions_InventoryManagement
 * @author Anton Naumov <anton2-2000@mail.ru>
 * @copyright Copyright (c) 2023 NaumovExtensions
 */

declare(strict_types=1);

namespace NaumovExtensions\InventoryManagement\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use NaumovExtensions\InventoryManagement\Model\Inventory;
use NaumovExtensions\InventoryManagement\Model\ResourceModel\InventoryDB;

/**
 * class InventoryCollection
 * @package NaumovExtensions\InventoryManagement\Model\ResourceModel
 */
class InventoryCollection extends AbstractCollection
{
    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            Inventory::class,
            InventoryDB::class
        );
    }
}
