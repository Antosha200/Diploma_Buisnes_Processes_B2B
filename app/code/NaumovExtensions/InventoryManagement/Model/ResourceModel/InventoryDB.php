<?php
/**
 * @category NaumovExtensions
 * @package NaumovExtensions_InventoryManagement
 * @author Anton Naumov <anton2-2000@mail.ru>
 * @copyright Copyright (c) 2023 NaumovExtensions
 */

declare(strict_types=1);

namespace NaumovExtensions\InventoryManagement\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * class InventoryDB
 * @package NaumovExtensions\InventoryManagement\Model\ResourceModel
 */
class InventoryDB extends AbstractDb
{
    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init('naumovinventorymanagement_inventory', 'id');
    }
}
