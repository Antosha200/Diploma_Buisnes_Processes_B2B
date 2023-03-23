<?php
/**
 * @category NaumovExtensions
 * @package NaumovExtensions_IntegrationLogs
 * @author Anton Naumov <anton2-2000@mail.ru>
 * @copyright Copyright (c) 2023 NaumovExtensions
 */

declare(strict_types=1);

namespace NaumovExtensions\IntegrationLogs\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use NaumovExtensions\IntegrationLogs\Model\Log;
use NaumovExtensions\IntegrationLogs\Model\ResourceModel\Database as LogResource;

/**
 * Class Grid
 * @package NaumovExtensions/IntegrationLogs/Model/ResourceModel
 */
class Collection extends AbstractCollection
{
    /**
     * Define model & resource model
     */
    protected function _construct()
    {
        $this->_init(
            Log::class,
            LogResource::class
        );
    }
}
