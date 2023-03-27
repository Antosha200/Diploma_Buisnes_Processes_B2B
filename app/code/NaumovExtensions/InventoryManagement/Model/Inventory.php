<?php
/**
 * @category NaumovExtensions
 * @package NaumovExtensions_InventoryManagement
 * @author Anton Naumov <anton2-2000@mail.ru>
 * @copyright Copyright (c) 2023 NaumovExtensions
 */

declare(strict_types=1);

namespace NaumovExtensions\InventoryManagement\Model;

use Magento\Framework\Model\AbstractModel;
use NaumovExtensions\InventoryManagement\Model\ResourceModel\InventoryDB;

/**
 * class Inventory
 * @package NaumovExtensions\InventoryManagement\Model
 */
class Inventory extends AbstractModel
{
    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init(InventoryDB::class);
    }
}
