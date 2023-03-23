<?php
/**
 * @category NaumovExtensions
 * @package NaumovExtensions_IntegrationLogs
 * @author Anton Naumov <anton2-2000@mail.ru>
 * @copyright Copyright (c) 2023 NaumovExtensions
 */

declare(strict_types=1);

namespace NaumovExtensions\IntegrationLogs\Model;

use Magento\Framework\App\ResourceConnection;

/**
 * Class FilterOptions
 * @package NaumovExtensions/IntegrationLogs/Model
 */
class FilterOptions
{
    /**
     * @var ResourceConnection
     */
    private ResourceConnection $resourceConnection;

    /**
     * @param ResourceConnection $resourceConnection
     */
    public function __construct(ResourceConnection $resourceConnection)
    {
        $this->resourceConnection = $resourceConnection;
    }

    /**
     * Retrieve unique object values from the logging table
     *
     * @return array
     */
    public function getObjectOptions(): array
    {
        $connection = $this->resourceConnection->getConnection();
        $table = $this->resourceConnection->getTableName('naumovextensions_integration_logs');

        $select = $connection->select()->distinct(true)->from($table, 'object')->order('object');
        return $connection->fetchCol($select);
    }

    /**
     * Retrieve unique event values from the logging table
     *
     * @return array
     */
    public function getEventOptions(): array
    {
        $connection = $this->resourceConnection->getConnection();
        $table = $this->resourceConnection->getTableName('naumovextensions_integration_logs');

        $select = $connection->select()->distinct(true)->from($table, 'event')->order('event');
        return $connection->fetchCol($select);
    }
}
