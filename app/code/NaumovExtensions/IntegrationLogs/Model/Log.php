<?php
/**
 * @category NaumovExtensions
 * @package NaumovExtensions_IntegrationLogs
 * @author Anton Naumov <anton2-2000@mail.ru>
 * @copyright Copyright (c) 2023 NaumovExtensions
 */

declare(strict_types=1);

namespace NaumovExtensions\IntegrationLogs\Model;

use Magento\Framework\Model\AbstractModel;
use NaumovExtensions\IntegrationLogs\Model\ResourceModel\Database;

/**
 * Class Log
 * @package NaumovExtensions/IntegrationLogs/Model
 */
class Log extends AbstractModel
{
    /**
     * @return void
     */
    protected function _construct(): void
    {
        $this->_init(Database::class);
    }
}
