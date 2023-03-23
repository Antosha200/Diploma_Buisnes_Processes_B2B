<?php
/**
 * @category NaumovExtensions
 * @package NaumovExtensions_IntegrationLogs
 * @author Anton Naumov <anton2-2000@mail.ru>
 * @copyright Copyright (c) 2023 NaumovExtensions
 */

declare(strict_types=1);

namespace NaumovExtensions\IntegrationLogs\Model\ResourceModel;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Class Database
 * @package NaumovExtensions/IntegrationLogs/Model/ResourceModel
 */
class Database extends AbstractDb
{
    /**
     * Define table
     */
    protected function _construct()
    {
        $this->_init('naumovextensions_integration_logs', 'id');
    }

    /**
     * @throws LocalizedException
     */
    public function deleteLogsOlderThan($date)
    {
        $this->getConnection()->delete(
            $this->getMainTable(),
            ['created_at < ?' => $date]
        );
    }
}
